<?php

namespace App\View\Components\Arthemys\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SimpleSelectInput extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string|null $label,
        public string|null $placeholder,
        public string|null $selected,
        public string|null $model,
        public string|null $value,
        public bool $required = false,
        public bool $search = false,
        public array $options = [],
    
    )
    {
        $this->value = $this->selected;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.arthemys.form.simple-select-input');
    }
}
