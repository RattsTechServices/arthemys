<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterInput extends Model
{
    protected $table = "register_inputs";
    protected $fillable = [
        'register_step_id',
        'client_application_id',
        'is_client_register_collection',
        'name', 'type', 'label',
        'placeholder', 'value', 'card',
        'mask', 'options', 'icon', 'html', 
        'ai_auto_verify'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function application() {
        return $this->hasOne(ClientApplication::class, 'id', 'client_application_id');
    }

    public function register_step() {
        return $this->hasOne(RegisterStep::class, 'id', 'register_step_id');
    }
}
