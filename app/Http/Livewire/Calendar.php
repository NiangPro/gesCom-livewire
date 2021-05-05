<?php

namespace App\Http\Livewire;

use App\Models\Reunion;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Calendar extends Component
{
    public $events = [];

    public function mount()
    {
        if (!Auth::check()) {
            return redirect(route('login'));
        }
    }

    public function render()
    {
        $r = Reunion::all();
        $this->initEvent($r);
        return view('livewire.calendar');
    }

    private function initEvent($reunions)
    {
        foreach ($reunions as $r) {
            array_push($this->events, [
                'id' => $r->id,
                'title' => $r->title,
                'start' => $r->date,
                'end' => null
            ]);

        }
        $this->events = json_encode($this->events);
    }
}
