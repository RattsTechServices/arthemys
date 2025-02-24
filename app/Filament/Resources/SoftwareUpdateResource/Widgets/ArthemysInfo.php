<?php

namespace App\Filament\Resources\SoftwareUpdateResource\Widgets;

use Filament\Widgets\Widget;

class ArthemysInfo extends Widget
{
    protected static string $view = 'filament.resources.software-update-resource.widgets.arthemys-info';
    public string $version;
}
