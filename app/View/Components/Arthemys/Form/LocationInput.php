<?php

namespace App\View\Components\Arthemys\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LocationInput extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $model,
        public bool $showButtom = false,


    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.arthemys.form.location-input');
    }
}
