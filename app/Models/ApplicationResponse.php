<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationResponse extends Model
{
    protected $table = "application_responses";
    protected $fillable = [
        'client_application_id', 'client_register_collection_id', 'content'
    ];

    protected $casts = [
        'content' => 'array'
    ];

    public function application() {
        return $this->hasOne(ClientApplication::class, 'id', 'client_application_id');
    }

    public function clientRegisterCollection() {
        return $this->hasOne(ClientRegisterCollection::class, 'id', 'client_register_collection_id');
    }
}
