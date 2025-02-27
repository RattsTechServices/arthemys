<?php

namespace App\View\Components\Arthemys\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardSelectInput extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string $title,
        public string $value,
        public string $label,
        public string|null $subtitle,
        public string|null $model,
        public bool $checked = false,
        public bool $required = false,
    )
    {
        if($this->checked){
            $this->checked = "checked";
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.arthemys.form.card-select-input');
    }
}
