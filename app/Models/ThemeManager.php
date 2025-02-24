<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class ThemeManager extends Model
{
    protected $table = "theme_managers";
    protected $fillable = [
        'title', 'slug', 'namespace', 'size', 'sha256', 'is_active', 'url'
    ];

    public function info() {
        $manifest = File::get(public_path("assets/{$this->slug}/manifest.json"));
        return json_decode($manifest, false);
    }
}
