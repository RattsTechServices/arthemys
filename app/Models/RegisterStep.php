<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterStep extends Model
{
    protected $table = "register_steps";
    protected $fillable = [
        'client_application_id',
        'description',
        'show_info',
        'identify',
        'tooltip',
        'status',
        'title',
        'step'
    ];

    public function client_application() {
        return $this->hasOne(ClientApplication::class, 'id', 'client_application_id');
    }

    public function register_inputs() {
        return $this->hasMany(RegisterInput::class, 'register_step_id', 'id');
    }
}
