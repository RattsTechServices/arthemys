<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use ZipArchive;

class UnzipThemeController extends Controller
{
    public static function unzip(string $zipPath)
    {

        if (!file_exists($zipPath)) {
            return response()->json(['error' => 'Arquivo ZIP não encontrado.'], 404);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath) !== true) {
            return response()->json(['error' => 'Erro ao abrir o arquivo ZIP.'], 500);
        }

        $slug = pathinfo($zipPath, PATHINFO_FILENAME);
        $destination = base_path(".theme/{$slug}");
        $filesystem = new Filesystem();
        $filesystem->ensureDirectoryExists($destination);

        $zip->extractTo($destination);
        $zip->close();

        static::verifyDepences("{$destination}/public/assets/{$slug}/manifest.json");

        $directories = [
            "app/Themes/{$slug}",
            "public/assets/{$slug}",
            "app/View/Components/{$slug}",
            "resources/views/themes/{$slug}",
            "resources/views/components/{$slug}",
        ];

        foreach ($directories as $dir) {
            $sourcePath = "$destination/" . str_replace("{$slug}", '', $dir) . "{$slug}";
            if ($filesystem->exists($sourcePath)) {
                $filesystem->copyDirectory($sourcePath, base_path($dir));
            }
        }

        $manifestFile = "assets/{$slug}/manifest.json";

        if (file_exists(public_path($manifestFile))) {
            return json_decode(file_get_contents(public_path($manifestFile)));
        }

        return (object)[
            'name' => $slug,
            'slug' => $slug,
            'namespace' => ucfirst($slug),
            'version' => "0.0.1",
            'description' => "Sem descrição",
            'url' => null,
            'extra' => [],
            'assets' => [
                'js' => [],
                'css' => []
            ]
        ];
    }

    public static function delete(string $slug)
    {
        $directories = [
            "app/Themes/{$slug}",
            "public/assets/{$slug}",
            "app/View/Components/{$slug}",
            "resources/views/themes/{$slug}",
            "resources/views/components/{$slug}",
        ];

        foreach ($directories as $dir) {
            File::deleteDirectory(base_path($dir));
        }

        return (object)['message' => 'deleted files'];
    }

    public static function verifyDepences(string $manifestPath): void
    {
        $manifest = File::get($manifestPath);
        $manifest = json_decode($manifest);
        if(isset($manifest->dependes)){
            foreach ($manifest->dependes as $dependes) {
                if (!file_exists(public_path("assets/{$dependes->slug}/manifest.json"))) {
                    throw new Exception("Theme manifest file not found!");
                }
            }
        }
    }
}
