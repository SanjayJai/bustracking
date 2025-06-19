<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Bus;

class FindMyBus extends Component
{
    public $buses;

    public function mount()
    {
        $this->buses = Bus::all();
    }

    public function render()
    {
        return view('livewire.find-my-bus');
    }
}