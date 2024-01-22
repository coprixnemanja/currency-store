<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Pagination\AbstractPaginator;

class CurrencyTable extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public AbstractPaginator $data)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.currency-table',['data'=>$this->data]);
    }
}
