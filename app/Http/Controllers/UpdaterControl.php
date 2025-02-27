<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use ZipArchive;

class UpdaterControl extends Controller
{

    public static function getRepoDetails($repoUrl)
    {
        $response = Http::withHeaders(['User-Agent' => 'Arthemys-Updater'])->get($repoUrl);
        if ($response->successful()) {
            return $response->json();
        }
        return null;
    }

    public static function getLatestVersion($repoUrl)
    {
        $response = Http::withHeaders(['User-Agent' => 'Arthemys-Updater'])->get($repoUrl);
        if ($response->successful()) {
            return $response->json()[0]['tag_name'] ?? null;
        }
        return null;
    }

    public static function getReleaseZipUrl($version, $repoUrl)
    {
        $response = Http::withHeaders(['User-Agent' => 'Arthemys-Updater'])->get($repoUrl);
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

            $extractedFolders = File::directories($extractPath);
            
            if (!empty($extractedFolders)) {
                $mainFolder = $extractedFolders[0];
                foreach (File::allFiles($mainFolder, true) as $file) {
                    $relativePath = str_replace($mainFolder, '', $file->getPathname());
                    $destinationPath = $extractPath . $relativePath;
                    File::ensureDirectoryExists(dirname($destinationPath), 0755, true);
                    File::move($file->getPathname(), $destinationPath);
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
