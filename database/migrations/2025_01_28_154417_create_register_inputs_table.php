<?php

use App\Models\ClientApplication;
use App\Models\RegisterInput;
use App\Models\RegisterStep;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('register_inputs', function (Blueprint $table) {
            $table->id();
            $table->integer('client_application_id');
            $table->integer('register_step_id');
            $table->string('name');
            $table->string('type');
            $table->string('label')->nullable();
            $table->string('placeholder')->nullable();
            $table->string('value')->nullable();
            $table->string('mask')->nullable();
            $table->boolean('required')->default(0);
            $table->json('options')->nullable();
            $table->longText('html')->nullable();
            $table->text('icon')->nullable();
            $table->boolean('ai_auto_verify')->default(0);
            $table->boolean('is_client_register_collection')->default(0);
            $table->timestamps();
        });

        $defaultApplication = ClientApplication::first();
        $defaultApplication->register_steps()->get()->map(function ($mp, $index) {
            /**
             * 
             */

            if ($mp->step == 0) {
                DB::table('register_inputs')->insert([
                    [
                        'client_application_id' => $mp->client_application_id,
                        'register_step_id'  => $mp->id,
                        'name'              => 'account_type',
                        'type'              => 'checkbox',
                        'label'             => 'Pessoa Fisica',
                        'value'             => 'personal',
                        'placeholder'       => 'Cadastro Pessoa Fisica',
                        'mask'              => null,
                        'icon'              => "<i class='ki-duotone ki-badge fs-3x me-5'><span class='path1'></span><span class='path2'></span><span class='path3'></span><span class='path4'></span><span class='path5'></span></i>",
                        'required'          => 1,
                        'created_at'        => now(),
                        'updated_at'        => now()
                    ],
                    [
                        'client_application_id' => $mp->client_application_id,
                        'register_step_id'  => $mp->id,
                        'name'              => 'account_type',
                        'type'              => 'checkbox',
                        'label'             => 'Pessoa Juridica',
                        'value'             => 'corporative',
                        'placeholder'       => 'Cadastro Pessoa Juridica',
                        'mask'              => null,
                        'icon'              => "<i class='ki-duotone ki-briefcase fs-3x me-5'><span class='path1'></span><span class='path2'></span></i>",
                        'required'          => 1,
                        'created_at'        => now(),
                        'updated_at'        => now()
                    ]
                ]);
            } else if ($mp->step == 1) {
                DB::table('register_inputs')->insert([
                    [
                        'client_application_id' => $mp->client_application_id,
                        'register_step_id'  => $mp->id,
                        'name'              => 'complete_name',
                        'type'              => 'text',
                        'label'             => 'Nome completo',
                        'placeholder'       => 'Insira seu nome completo',
                        'mask'              => null,
                        'required'          => 1,
                        'is_client_register_collection' => 0,
                        'created_at'        => now(),
                        'updated_at'        => now()
                    ],
                    [
                        'client_application_id' => $mp->client_application_id,
                        'register_step_id'  => $mp->id,
                        'name'              => 'social_name',
                        'type'              => 'text',
                        'label'             => 'Nome social',
                        'placeholder'       => 'Insira o nome que gostaria de ser chamado',
                        'mask'              => null,
                        'required'          => 0,
                        'is_client_register_collection' => 0,
                        'created_at'        => now(),
                        'updated_at'        => now()
                    ],
                    [
                        'client_application_id' => $mp->client_application_id,
                        'register_step_id'  => $mp->id,
                        'name'              => 'email',
                        'type'              => 'email',
                        'label'             => 'Email',
                        'placeholder'       => 'Seu endereço de email',
                        'mask'              => null,
                        'required'          => 1,
                        'is_client_register_collection' => 1,
                        'created_at'        => now(),
                        'updated_at'        => now()
                    ],
                    [
                        'client_application_id' => $mp->client_application_id,
                        'register_step_id'  => $mp->id,
                        'name'              => 'phone',
                        'type'              => 'text',
                        'label'             => 'Telefone',
                        'placeholder'       => 'Numero de telefone atual',
                        'mask'              => '(99) 99999-9999',
                        'required'          => 0,
                        'is_client_register_collection' => 0,
                        'created_at'        => now(),
                        'updated_at'        => now()
                    ],
                    [
                        'client_application_id' => $mp->client_application_id,
                        'register_step_id'  => $mp->id,
                        'name'              => 'password',
                        'type'              => 'password',
                        'label'             => 'Senha',
                        'placeholder'       => 'Digite uma senha',
                        'mask'              => null,
                        'required'          => 1,
                        'is_client_register_collection' => 0,
                        'created_at'        => now(),
                        'updated_at'        => now()
                    ]
                ]);
            } else if ($mp->step == 2) {
                DB::table('register_inputs')->insert([
                    [
                        'client_application_id' => $mp->client_application_id,
                        'register_step_id'  => $mp->id,
                        'name'              => 'address',
                        'type'              => 'text',
                        'label'             => 'Endereço',
                        'placeholder'       => 'Endeço / logradouro',
                        'required'          => 1,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                        'options'           => null
                    ],
                    [
                        'client_application_id' => $mp->client_application_id,
                        'register_step_id'  => $mp->id,
                        'name'              => 'number',
                        'type'              => 'text',
                        'label'             => 'Numero',
                        'placeholder'       => 'Numero da residencia / Apartamento',
                        'required'          => 1,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                        'options'           => null
                    ],
                    [
                        'client_application_id' => $mp->client_application_id,
                        'register_step_id'  => $mp->id,
                        'name'              => 'district',
                        'type'              => 'text',
                        'label'             => 'Bairro',
                        'placeholder'       => 'Nome do seu bairro / distrito',
                        'required'          => 0,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                        'options'           => null
                    ],
                    [
                        'client_application_id' => $mp->client_application_id,
                        'register_step_id'  => $mp->id,
                        'name'              => 'city',
                        'type'              => 'text',
                        'label'             => 'Cidade',
                        'placeholder'       => 'Nome da sua cidade',
                        'required'          => 1,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                        'options'           => null
                    ],
                    [
                        'client_application_id' => $mp->client_application_id,
                        'register_step_id'  => $mp->id,
                        'name'              => 'state',
                        'type'              => 'text',
                        'label'             => 'Estado',
                        'placeholder'       => 'Nome do seu estado',
                        'required'          => 1,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                        'options'           => null
                    ],
                    [
                        'client_application_id' => $mp->client_application_id,
                        'register_step_id'  => $mp->id,
                        'name'              => 'country',
                        'type'              => 'select',
                        'label'             => 'País',
                        'placeholder'       => 'Nome do país',
                        'required'          => 1,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                        'options'           => json_encode([
                            'br' => "Brasil",
                            'en' => "Estados Unidos"
                        ])
                    ]
                ]);
            } else if ($mp->step == 3) {
                DB::table('register_inputs')->insert(
                    [
                        [
                            'client_application_id' => $mp->client_application_id,
                            'register_step_id'  => $mp->id,
                            'name'              => 'alert_card_01',
                            'type'              => 'card',
                            'label'             => "Final",
                            'placeholder'       => "Finalize o cadastro",
                            'required'          => 0,
                            'created_at'        => now(),
                            'updated_at'        => now(),
                            'html'              => "
                            <div class='row mb-5'>
                                <div class='col-md-4 mx-auto text-center'>
                                    <i class='ki-duotone ki-information-5 text-warning' style='font-size: 100px;'>
                                        <span class='path1'></span>
                                        <span class='path2'></span>
                                        <span class='path3'></span>
                                    </i>
                                </div>
                                <div class='col-md-12'>
                                    <div class='card bg-transparent shadow-lg'>
                                        <div class='card-title text-center fs-2'>
                                            AVISO
                                        </div>
                                        <div class='card-body fs-4 text-center'>
                                            Ao clicar em <b>Enviar</b> vc estará de acordo com nossos <a href='#'>Termos e condições de uso</a>. Deseja continuar?
                                        </div>
                                    </div>
                                </div>
                            </div>"
                        ],
                    ]
                );
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_inputs');
    }
};
