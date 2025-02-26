<?php

use App\Models\ClientApplication;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_applications', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('title');
            $table->string('slug_title');
            $table->text('description');
            $table->boolean('status');
            $table->text('url');
            $table->text('webhookie')->nullable();
            $table->text('callback')->nullable();
            $table->text('logo_light')->nullable();
            $table->text('logo_dark')->nullable();
            $table->text('favicon')->nullable();
            $table->enum('condition', ['aproved', 'canceled', 'pedding', 'blocked']);
            $table->enum('webhookie_type', ['queue', 'request']);
            $table->timestamps();
        });

        ClientApplication::create([
            'user_id' => User::first()->id,
            'title' => "Arthemys",
            'slug_title' => "arthemys",
            'description' => "Sistema de Cadastro de código aberto",
            'status' => 1,
            'url' => env('APP_URL'),
            'callback' => env('APP_URL') . "/arthemys",
            'webhookie' => env('APP_URL') . "/api/webhook",
            'webhookie_type' => 'request',
            'logo_light' => "static/images/arthemys-logo-light.png",
            'logo_dark' => "static/images/arthemys-logo.png",
            'condition' => 'aproved'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_applications');
    }
};
