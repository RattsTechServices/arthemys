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

    public static function convertBytes($value, $unit = 'B')
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        if (is_numeric($value)) {
            // Convert bytes para unidade desejada
            $power = array_search(strtoupper($unit), $units);
            return round($value / pow(1024, $power), 2) . " " . $unit;
        } elseif (preg_match('/^(\d+(?:\.\d+)?)\s*(B|KB|MB|GB|TB|PB)$/i', $value, $matches)) {
            // Convert unidade para bytes
            $number = (float) $matches[1];
            $power = array_search(strtoupper($matches[2]), $units);
            return (int) ($number * pow(1024, $power));
        }

        return null; // Retorna null caso a entrada seja inválida
    }
}
