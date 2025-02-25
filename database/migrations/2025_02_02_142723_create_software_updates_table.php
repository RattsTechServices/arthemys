<?php

use App\Models\SoftwareUpdate;
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
        Schema::create('software_updates', function (Blueprint $table) {
            $table->id();
            $table->string('version');
            $table->string('reliase');
            $table->string('repository');
            $table->string('artefact');
            $table->string('size');
            $table->json('extra');
            $table->timestamps();
        });

        SoftwareUpdate::create([
            'version' => '0.0.2',
            'reliase' => 'stable',
            'repository' => 'RattsTechServices/arthemys',
            'artefact' => '#',
            'size' => 1024000,
            'extra' => ["branch" => "main"]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software_updates');
    }
};
