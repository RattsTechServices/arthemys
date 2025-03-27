<?php

namespace App\Themes\Arthemys\Components;

use App\Http\Controllers\DriverControl;
use App\Models\SystemConfigs;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class SelfieCapture extends Component
{
    use WithFileUploads;

    public string $name;
    public bool $useIa = false;

    public $selfie;
    public $imageData;

    public function capture($imageData)
    {
        $this->imageData = $imageData;
    }

    public function confirm()
    {
        if ($this->imageData) {
            $itensToSend = [];
            $image = str_replace('data:image/png;base64,', '', $this->imageData);
            $image = str_replace(' ', '+', $image);
            $imageName = 'storage/app/photos/selfie_' . time() . '.png';
            $iaImagePath = 'storage/app/photos/ia';
            
            Storage::disk('public')->put($imageName, base64_decode($image));

            $itensToSend["{$this->name}_item"] = asset($imageName);
            $itensToSend["{$this->name}_original_object"] = $imageName;

            if($this->useIa){
                $totalItensForString = "";
                $useDriverFor = (new DriverControl)->use(SystemConfigs::first()->ia_detect_object_driver)->exec(public_path($imageName));

                $itensToSend["{$this->name}_ia_object"] = $useDriverFor->object_output->path_to_image;
                $itensToSend["{$this->name}_ia_moved_object"] = rename(storage_path("{$useDriverFor->object_output->path_to_image}/{$useDriverFor->object_output->image_name}"), public_path("{$iaImagePath}/{$useDriverFor->object_output->image_name}"));
                $itensToSend["{$this->name}_ia_public_artefact"] = asset("{$iaImagePath}/{$useDriverFor->object_output->image_name}");

                foreach($useDriverFor->object_result->list_itens as $value){
                    $itenPercentAverageAcertable = number_format(100 * $value->score, 2, '.', '');
                    $totalItensForString .= "{$value->label}: {$value->score}, certainty: {$itenPercentAverageAcertable}, ";
                }

                $itensToSend["{$this->name}_ia_object_itens"] = substr($totalItensForString, 0, strlen($totalItensForString) - 2);
            } else {
                $itensToSend["{$this->name}_ia_public_artefact"] = asset($imageName);
            }

            $this->dispatch('event-collection', itens: $itensToSend);
            session()->flash('message', "Selfie enviada com sucesso: <a href='{$itensToSend["{$this->name}_ia_public_artefact"]}' target='_blank'>{$imageName}</a>");
            $this->reset(['imageData', 'selfie']);
        }
    }

    public function render()
    {
        return view('themes.arthemys.components.selfie-capture');
    }
}
