<?php

use App\Models\ThemeManager;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;


Route::middleware('web')
    ->prefix("/{slug}")
    ->group(function () {
        if (Schema::hasTable('theme_managers')) {
            $theme = ThemeManager::first();

            if (!isset($theme)) {
                return null;
            }

            $themePath = resource_path("views/themes/{$theme->info()->slug}/websystem");
            $files = collect(File::files($themePath))->map(fn($file) => $file->getFilenameWithoutExtension());

            foreach ($files as $file) {
                $file = explode(".", $file)[0];

                $className = Str::studly($file); // Transforma para a notação de classe (CamelCase)
                // Construa o nome da classe com o namespace correto
                $class = "App\\Themes\\{$theme->info()->namespace}\\Websystem\\{$className}";

                if (class_exists($class)) {
                    // Se o nome do arquivo for 'index' ou 'homepage', mapeia para a rota raiz
                    if ($file === 'index' || $file === 'homepage') {
                        Route::get("/", $class)->name("{$file}");
                        continue;
                    }

                    // Se o nome do arquivo contiver colchetes, mapeia para um padrão
                    if (Str::contains($file, '[') && Str::contains($file, ']')) {
                        $pattern = preg_replace('/\[(.+?)\]/', '{$1}', $file);
                        Route::get("/$pattern", $class)->name("{$file}");
                        continue;
                    }

                    // Para todos os outros arquivos, cria uma rota padrão
                    Route::get("/$file", $class)->name("{$file}");
                }
            }
        }
    });
