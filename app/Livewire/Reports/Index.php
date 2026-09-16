<?php

namespace App\Livewire\Reports;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Reports')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.reports.index');
    }
}
