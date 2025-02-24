<?php

namespace App\View\Components\Arthemys\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileInput extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public string|null $label,
        public string|null $placeholder = 'Arraste uma imagem aqui ou clique para selecionar',
        public string|null $value,
        public string|null $mask,
        public string|null $model,
        public bool $required = false,
        public string $type = 'file',
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.arthemys.form.file-input');
    }
}
