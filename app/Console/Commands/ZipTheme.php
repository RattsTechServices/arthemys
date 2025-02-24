<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use ZipArchive;

class ZipTheme extends Command
{
    protected $signature = 'theme:zip';
    protected $description = 'Compact a custom theme';

    public function handle()
    {
        $theme = $this->ask('Insert a name using up case firt for your theme. Example: Arthemys');
        $slug = strtolower($theme);
        $name = ucfirst($slug);
        
        $directories = [
            "app/Themes/{$name}",
            "app/View/Components/{$name}",
            "resources/views/components/{$name}",
            "public/assets/{$name}",
            "resources/views/themes/{$name}",
        ];
        
        $destination = base_path(".theme/{$slug}");
        $filesystem = new Filesystem();
        $filesystem->cleanDirectory($destination);
        
        foreach ($directories as $dir) {
            $sourcePath = base_path($dir);
            if ($filesystem->exists($sourcePath)) {
                $relativePath = str_replace("{$name}", '', $dir);
                $targetPath = "$destination/{$relativePath}{$name}";
                $this->info("Copiando: {$sourcePath} para {$targetPath}");
                $filesystem->copyDirectory($sourcePath, $targetPath);
            }
        }
        
        $zipPath = base_path("{$slug}.zip");
        
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $this->addFolderToZip($destination, $zip, strlen(base_path('.theme/')));
            $zip->close();
            $this->info("Zip file for your theme is created: {$zipPath}");
        } else {
            $this->error("Error to create .zip file for your theme");
        }
    }

    private function addFolderToZip($folder, ZipArchive $zip, $stripLength)
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folder, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            $relativePath = substr($file->getPathname(), $stripLength);
            $zip->addFile($file->getPathname(), $relativePath);
        }
    }
}
