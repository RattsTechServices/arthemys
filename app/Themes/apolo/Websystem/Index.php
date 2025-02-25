<?php

namespace App\Themes\Apolo\Websystem;

use App\Models\ClientApplication;
use App\Models\ClientRegisterCollection;
use App\Models\RegisterInput;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Index extends Component
{

    public array $reference = [];
    public ClientApplication|null $Application;
    public ClientRegisterCollection|null $clientCollection;
    public Collection|null $initialRegisterInputs;
    public string $slug;

    public function mount()
    {
        
        $session = session()->id();
        $this->Application = ClientApplication::where('slug_title', request()->slug)->first();
        $appClientSession = "{$session}::{$this->Application->id}";
        // dd($appClientSession);
        $this->initialRegisterInputs = RegisterInput::where('client_application_id', $this->Application->id)->where('is_client_register_collection', 1)->get();
        $this->clientCollection = ClientRegisterCollection::where('session_id', $appClientSession)->first();
        $this->slug = request()->slug;

        // Inicializar os valores no array associativo
        foreach ($this->initialRegisterInputs as $input) {
            $this->reference[$input->name] = null; // Pode preencher com um valor default se necessário
        }
    }

    public function CollectEmail()
    {
        /** Pre-Coleta de dados do usuario **/
        if (isset($this->clientCollection)) {
            $this->clientCollection->update([
                'precollected' => $this->reference,
            ]);
        }

        return $this->redirectRoute('register-page', ['slug' => $this->slug]);
    }

    public function render()
    {
        return view('themes.apolo.websystem.index');
    }
}
