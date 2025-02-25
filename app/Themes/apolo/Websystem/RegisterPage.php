<?php

namespace App\Themes\Apolo\Websystem;

use App\Models\ClientApplication;
use App\Models\ClientRegisterCollection;
use App\Models\RegisterInput;
use App\Models\RegisterStep;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class RegisterPage extends Component
{

    public ClientRegisterCollection | null $clientCollection;
    public ClientApplication $application;
    public Collection | null $registerSteps;
    public Collection | null $registerInputs;
    public string | null $appClientSession;
    public string $slug;


    public array $formData = [];

    public function mount()
    {
        $session = session()->id();
        $this->slug = request()->slug;
        $this->application = ClientApplication::where('slug_title', request()->slug)->first();
        $this->appClientSession = "{$session}::{$this->application->id}";

        // Buscar os steps do formulário
        $this->registerSteps = RegisterStep::where('client_application_id', $this->application->id)->get();

        // Buscar os inputs relacionados aos steps
        $this->registerInputs = RegisterInput::whereIn('register_step_id', $this->registerSteps->pluck('id'))->get();
        $this->clientCollection = ClientRegisterCollection::where('session_id', $this->appClientSession)->first();
        // Inicializar os valores no array associativo
        foreach ($this->registerInputs as $input) {
            if (!isset($input->html)) {
                $value = null;
                if ($this->clientCollection && $this->clientCollection->precollected) {
                    if (in_array($input->name, array_keys($this->clientCollection->precollected))) {
                        $value = $this->clientCollection->precollected[$input->name];
                    }
                }

                $this->formData[$input->name] = $value; // Pode preencher com um valor default se necessário

            }
        }
    }

    public function RegisterSubmit()
    {
        // dd($this->formData);
        /** Pre-Coleta de dados do usuario **/
        if (!isset($this->clientCollection)) {
            $appClientSession = session()->id() . '::' . $this->application->id;

            ClientRegisterCollection::create([
                'client_application_id' => $this->application->id,
                'session_id' => $appClientSession,
                'register_ip' => request()->ip(),
                'register_ip_sha256' => hash('sha256', request()->ip())
            ]);

            $this->clientCollection = ClientRegisterCollection::where('session_id', $appClientSession)->first();
        }

        $this->clientCollection->update([
            'collected' => $this->formData
        ]);

        return $this->redirectRoute('success-page', ['slug' => $this->slug]);
    }

    public function render()
    {
        return view('themes.apolo.websystem.register-page');
    }
}
