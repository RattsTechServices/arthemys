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
        $namespace = ucfirst($slug);
        $destination = base_path(".theme/{$slug}/{$slug}");
        $filesystem = new Filesystem();
        $filesystem->ensureDirectoryExists($destination);

        $zip->extractTo($destination);
        $zip->close();

        $dependences = "{$destination}/public/assets/{$namespace}/manifest.json";

        static::verifyDepences($dependences);

        $directoriesUC = [
            "app/Themes/{$namespace}",
            "public/assets/{$namespace}",
            "app/View/Components/{$namespace}",
            "resources/views/themes/{$namespace}",
            "resources/views/components/{$namespace}",
        ];

        foreach ($directoriesUC as $dir) {
            $sourcePath = "{$destination}/{$dir}";

            if ($filesystem->exists($sourcePath)) {
                $filesystem->copyDirectory($sourcePath, base_path($dir));
            }
        }

        $manifestUCFile = "assets/{$slug}/manifest.json";

        if (file_exists(public_path($manifestUCFile))) {
            return json_decode(file_get_contents(public_path($manifestUCFile)));
        }

        $manifestLCFile = "assets/{$namespace}/manifest.json";

        if (file_exists(public_path($manifestLCFile))) {
            return json_decode(file_get_contents(public_path($manifestLCFile)));
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
        $slug = ucfirst($slug);

        $directoriesUC = [
            "app/Themes/{$slug}",
            "public/assets/{$slug}",
            "app/View/Components/{$slug}",
            "resources/views/themes/{$slug}",
            "resources/views/components/{$slug}",
        ];

        foreach ($directoriesUC as $dir) {
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
                $slug = ucfirst($dependes->slug);
                if (!file_exists(public_path("assets/{$slug}/manifest.json"))) {
                    throw new Exception("Dependence file not foud. Please install {$dependes->slug}@{$dependes->version} first!");
                }
            }
        }
    }
}
