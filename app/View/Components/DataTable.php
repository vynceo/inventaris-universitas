<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DataTable extends Component
{
    public $headers;
    public $paginator;
    public $tableClass;

    public function __construct(
        $headers = [],
        $paginator = null,
        $tableClass = null
    ) {
        $this->headers = $headers;
        $this->paginator = $paginator;
        $this->tableClass = $tableClass;
    }

    public function render()
    {
        return view('components.data-table');
    }
}
