<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UtilsController extends Controller
{
    public static function getControllersFromNamespace(string $directory, string $namespace): array
    {
        $controllers = [];

        // Obtém os arquivos PHP dentro do diretório especificado
        $files = File::allFiles($directory);

        foreach ($files as $file) {
            $relativePath = $file->getRelativePathname();

            // Garante que seja um arquivo PHP
            if ($file->getExtension() !== 'php') {
                continue;
            }

            // Converte o caminho do arquivo para um namespace válido
            $className = $namespace . '\\' . str_replace(['/', '.php'], ['\\', ''], $relativePath);

            if (class_exists($className)) {
                $controllers[$className] = $className . "::class";
            }
        }

        return $controllers;
    }
}
