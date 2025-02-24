<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoftwareUpdate extends Model
{
    protected $table = "software_updates";
    
    protected $fillable = [
        'version', 'reliase', 'repository', 'artefact', 'size', 'extra'
    ];

    protected $casts = [
        'extra' => 'array'
    ];
}
