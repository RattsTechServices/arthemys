<?php

namespace App\View\Components\Arthemys\Utils;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StepNavigation extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $item,
        public string | null $label,
        public string | null $description
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.arthemys.utils.step-navigation');
    }
}
