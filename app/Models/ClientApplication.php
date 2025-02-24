<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientApplication extends Model
{
    protected $table = "client_applications";
    protected $fillable = [
        'user_id', 'title', 'description', 'status', 'url', 'webhookie', 'logo_light', 'logo_dark', 'favicon', 'condition', 'slug_title', 'callback'
    ];
    
    protected $casts = [
        'status' => 'boolean'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function register_steps() {
        return $this->hasMany(RegisterStep::class, 'client_application_id', 'id');
    }

}
