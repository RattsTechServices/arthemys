<?php

namespace App\View\Components\Arthemys\Utils;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class MultiForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string | null $name,
        public Collection | null $steps
    )
    {
        if(!isset($this->name)){
            $this->name = Str::random(6);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.arthemys.utils.multi-form');
    }
}
