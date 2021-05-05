<?php

namespace App\Http\Livewire;

use App\Models\History;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Historiques extends Component
{
    public function mount()
    {
        if (!Auth::check()) {
            return redirect(route('login'));
        }
    }
    public function render()
    {
        $data = [];
        $data['icon'] = 'fas fa-history';
        $data['title'] = 'Historiques';
        $data['subtitle'] = 'Liste des historiques';

        $histos = History::orderBy('date', 'DESC')->get();


        return view('livewire.historiques', [
            'page' => 'historique',
            'data' => $data,
            'histos' => $histos,
        ])->layout('layouts.app');
    }
}
