<?php

namespace App\Console\Commands;

use App\Http\Controllers\UpdaterControl;
use App\Models\SoftwareUpdate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use ZipArchive;

class UpdateSoftware extends Command
{
    protected $signature = 'software:update {version?}';
    protected $description = 'Update the software to the latest version or a specific version.';

    public string $repoUrl;

    public function handle()
    {
        $ARTHEMYS_UPDATER_SOURCE    = env('ARTHEMYS_UPDATER_SOURCE');
        $ARTHEMYS_UPDATER_PROVIDER  = env('ARTHEMYS_UPDATER_PROVIDER');
        
        $this->repoUrl  = "{$ARTHEMYS_UPDATER_SOURCE}/repos/{$ARTHEMYS_UPDATER_PROVIDER}/releases";

        $details = UpdaterControl::getRepoDetails($this->repoUrl);
        file_put_contents(base_path('demo.json'), json_encode($details));
        $version = $this->argument('version') ?? UpdaterControl::getLatestVersion($this->repoUrl);
        if (!$version) {
            $this->error('Não foi possível obter a versão mais recente.');
            return;
        }
        
        $zipUrl = UpdaterControl::getReleaseZipUrl($version, $this->repoUrl);
        if (!$zipUrl) {
            $this->error("Não foi possível encontrar a versão $version.");
            return;
        }

        $this->info("Baixando versão $version...");
        $zipPath = storage_path("update-$version.zip");
        File::put($zipPath, Http::withHeaders(['User-Agent' => 'Arthemys-Updater'])->get($zipUrl)->body());
        $size = File::size($zipPath);
        $this->info("Extraindo arquivos...");
        $extractPath = base_path('.updater');
        if (!File::exists($extractPath)) {
            File::makeDirectory($extractPath, 0755, true);
        }

        $this->info("Atualizando arquivos...");

        UpdaterControl::extractZip($zipPath, $extractPath);
        UpdaterControl::copyFiles($extractPath);
        File::delete($zipPath);

        SoftwareUpdate::create([
            'version'       => $version,
            'reliase'       => $details[0]['name'],
            'size'          => $size,
            'repository'    => $ARTHEMYS_UPDATER_PROVIDER,
            'artefact'      => $zipUrl,
            'extra'         => $details
        ]);

        $this->info("Atualização para versão $version concluída com sucesso!");
    }
}
