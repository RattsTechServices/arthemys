<?php

use App\Models\SystemConfigs;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('system_configs', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("description");
            $table->string("logo_light");
            $table->string("logo_dark");
            $table->string("favicon")->nullable();
            $table->string("app_domain")->nullable();
            $table->enum("image_controller", ['gd', 'imagick', 'vips']);
            $table->string('ia_models_directory');
            $table->string('ia_detect_object_driver')->nullable();
            $table->timestamps();
        });

        SystemConfigs::create([
            'title' => "Seja bem-vindo ao Arthemys ©",
            'description' => "Sistema de Cadastro de codigo aberto",
            'logo_light' => "static/images/arthemys-logo-light.png",
            'logo_dark' => "static/images/arthemys-logo.png",
            'favicon' => "static/images/arthemys-icon.png",
            'app_domain' => env('APP_DOMAIN'),
            'image_controller' => 'imagick',
            'ia_models_directory' => "models"
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_configs');
    }
};
