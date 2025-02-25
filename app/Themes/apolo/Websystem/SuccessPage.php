<?php

namespace App\Themes\Apolo\Websystem;

use App\Models\ClientApplication;
use Livewire\Component;

class SuccessPage extends Component
{

    public string | null $callback;
    public string | null $title;

    public function mount() {
        $application = ClientApplication::where('slug_title', request()->slug)->first();
        $this->callback = $application->callback;
        $this->title = $application->title;
    }

    public function render()
    {
        return view('themes.apolo.websystem.success-page');
    }
}
