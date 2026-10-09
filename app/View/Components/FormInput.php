<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormInput extends Component
{
    public $name;
    public $label;
    public $type;
    public $placeholder;
    public $value;
    public $required;
    public $icon;
    public $rows;

    public function __construct(
        $name = '',
        $label = null,
        $type = 'text',
        $placeholder = null,
        $value = null,
        $required = false,
        $icon = null,
        $rows = 4
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->required = $required;
        $this->icon = $icon;
        $this->rows = $rows;
    }

    public function render()
    {
        return view('components.form-input');
    }
}
