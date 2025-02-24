<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientRegisterCollection extends Model
{
    protected $table = "client_register_collections";
    protected $fillable = [
        'client_application_id',
        'precollected', 
        'collected', 
        'session_id', 
        'register_ip', 
        'register_ip_sha256'
    ];

    protected $casts = [
        'precollected' => 'array',
        'collected' => 'array'
    ];

    public function application() {
        return $this->hasOne(ClientApplication::class, 'id', 'client_application_id');
    }
}
