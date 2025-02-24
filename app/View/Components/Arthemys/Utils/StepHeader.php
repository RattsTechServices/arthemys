<?php

namespace App\View\Components\Arthemys\Utils;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StepHeader extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title,
        public string | null $subtitle,
        public string | null $tooltipInfo
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.arthemys.utils.step-header');
    }
}
