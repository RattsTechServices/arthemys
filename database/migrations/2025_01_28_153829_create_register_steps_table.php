<?php

use App\Models\ClientApplication;
use App\Models\RegisterStep;
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
        Schema::create('register_steps', function (Blueprint $table) {
            $table->id();
            $table->integer('client_application_id');
            $table->string('title')->nullable();
            $table->string('identify')->nullable();
            $table->string('description')->nullable();
            $table->string('tooltip')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('show_info')->default(1);
            $table->integer('step')->default(0);
            $table->timestamps();
        });

        RegisterStep::create([
            'client_application_id' => ClientApplication::first()->id,
            'title' => 'Selecione o tipo da conta',
            'description' => 'Nos informe qual tipo de conta deseja abrir',
            'step' => 0,
            'identify' => 'tipo_da_conta'
        ]);

        RegisterStep::create([
            'client_application_id' => ClientApplication::first()->id,
            'title' => 'Informações da conta',
            'description' => 'Nos forneça algumas informações para proseguir com seu cadastro',
            'step' => 1,
            'identify' => 'informacoes_da_conta'
        ]);

        RegisterStep::create([
            'client_application_id' => ClientApplication::first()->id,
            'title' => 'Informações de endereço',
            'description' => 'Nos forneça suas informações postais atualizadas',
            'tooltip' => 'Seu endereço será encriptado com suas informações pessoais onde terceiros não terão acesso',
            'step' => 2,
            'identify' => 'informacoes_do_endereco'

        ]);

        RegisterStep::create([
            'client_application_id' => ClientApplication::first()->id,
            'title' => 'Final',
            'description' => 'Finalize seu cadastro',
            'show_info' => false,
            'step' => 3,
            'identify' => 'final'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_steps');
    }
};
