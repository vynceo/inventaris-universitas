<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $header;
    public $icon;
    public $iconBg;
    public $iconColor;
    public $action;
    public $bodyClass;

    public function __construct(
        $header = null,
        $icon = null,
        $iconBg = null,
        $iconColor = null,
        $action = null,
        $bodyClass = null
    ) {
        $this->header = $header;
        $this->icon = $icon;
        $this->iconBg = $iconBg;
        $this->iconColor = $iconColor;
        $this->action = $action;
        $this->bodyClass = $bodyClass;
    }

    public function render()
    {
        return view('components.card');
    }
}
