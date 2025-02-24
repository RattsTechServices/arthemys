<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemConfigs extends Model
{
    protected $table = "system_configs";
    protected $fillable = [
        'title', 'description', 'logo_light', 'logo_dark', 'favicon', 'app_domain', 'image_controller', 'ia_models_directory', 'ia_detect_object_driver'
    ];
}
