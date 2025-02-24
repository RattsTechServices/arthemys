<?php

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
        Schema::create('client_register_collections', function (Blueprint $table) {
            $table->id();
            $table->integer('client_application_id');
            $table->json('precollected')->nullable();
            $table->json('collected')->nullable();
            $table->string('session_id');
            $table->string('register_ip');
            $table->string('register_ip_sha256');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_register_collections');
    }
};
