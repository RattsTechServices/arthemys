<?php

namespace App\Themes\Arthemys\Websystem;

use App\Http\Controllers\UtilsController;
use App\Models\ClientApplication;
use App\Models\ClientRegisterCollection;
use App\Models\RegisterInput;
use App\Models\RegisterStep;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegisterPage extends Component
{
    use WithFileUploads;

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

    #[On('event-collection')] 
    public function EventFormData(array $itens) {
        $this->formData = [...$this->formData, ...$itens];
    }

    public function RegisterSubmit()
    {
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
        
        /** Salva arquivos de imagem **/
        foreach($this->formData as $key => $data){
            if(is_file($data)){
                $extension = $data->getClientOriginalExtension();
                $name = Str::uuid();
                $path = "storage/app/registers/{$name}.{$extension}";

                if(!is_dir(public_path("storage/app/registers"))){
                    mkdir(public_path("storage/app/registers"));
                }

                copy($data->path(), public_path($path));
                $this->formData[$key] = asset($path);
            }
        }

        /** Atualizando dados pre-coletados **/
        $this->clientCollection->update([
            'collected' => $this->formData
        ]);

        UtilsController::sendWebhookie($this->application, $this->formData);

        return $this->redirectRoute('success-page', ['slug' => $this->slug]);
    }

    public function render()
    {
        return view('themes.arthemys.websystem.register-page');
    }
}
