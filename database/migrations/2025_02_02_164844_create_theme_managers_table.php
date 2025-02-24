<?php

use App\Models\ThemeManager;
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
        Schema::create('theme_managers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('namespace');
            $table->integer('size')->default(0);
            $table->string('sha256')->unique()->nullable();
            $table->boolean('is_active')->default(0);
            $table->string('url')->nullable();
            $table->timestamps();
        });

        ThemeManager::create([
            'title' => 'Arthemys Web System', 
            'slug' => 'arthemys',
            'namespace' => 'Arthemys',
            'size' => 0,
            'sha256' => null,
            'is_active' => 1,
            'url' => null
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_managers');
    }
};
