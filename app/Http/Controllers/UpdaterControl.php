<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use ZipArchive;

class UpdaterControl extends Controller
{

    public static function getRepoDetails($repoUrl)
    {
        $response = Http::withHeaders(['User-Agent' => 'Laravel-Updater'])->get($repoUrl);
        if ($response->successful()) {
            return $response->json();
        }
        return null;
    }

    public static function getLatestVersion($repoUrl)
    {
        $response = Http::withHeaders(['User-Agent' => 'Laravel-Updater'])->get($repoUrl);
        if ($response->successful()) {
            return $response->json()[0]['tag_name'] ?? null;
        }
        return null;
    }

    public static function getReleaseZipUrl($version, $repoUrl)
    {
        $response = Http::withHeaders(['User-Agent' => 'Laravel-Updater'])->get($repoUrl);
        if ($response->successful()) {
            foreach ($response->json() as $release) {
                if ($release['tag_name'] === $version) {
                    return $release['zipball_url'];
                }
            }
        }
        return null;
    }

    public static function extractZip($zipPath, $extractPath)
    {
        $zip = new ZipArchive;
        if ($zip->open($zipPath) === true) {
            $zip->extractTo($extractPath);
            $zip->close();

            # /Users/victorratts/Documents/Projects/php/Laravel/arthemys-project/.updater/RattsTechServices-arthemys-680b598/.DS_Store
            # /Users/victorratts/Documents/Projects/php/Laravel/arthemys-project/.updater/.DS_Store
            // Identificar a pasta raiz dentro do ZIP
            $extractedFolders = File::directories($extractPath);
            
            if (!empty($extractedFolders)) {
                $mainFolder = $extractedFolders[0];
                foreach (File::allFiles($mainFolder, true) as $file) {
                    $relativePath = str_replace($mainFolder, '', $file->getPathname());
                    File::move($file->getPathname(), $extractPath . $relativePath);
                }
                File::deleteDirectory($mainFolder);
            }
        } else {
            return throw new Exception("Error to extract files from .zip to .updater");
        }
    }

    public static function copyFiles($sourceDir, $targetDir = null)
    {
        $targetDir = $targetDir ?? base_path();
        foreach (File::allFiles($sourceDir) as $file) {
            $relativePath = str_replace($sourceDir, '', $file->getPathname());
            $destination = $targetDir . $relativePath;
            File::ensureDirectoryExists(dirname($destination), 0755, true);
            File::copy($file->getPathname(), $destination);
        }
    }
}
