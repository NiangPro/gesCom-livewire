<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\History;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Home extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $histo;
    public $ventes;
    public $depenses;

    public $data = [
        'icon' => 'icon-home',
        'title' => 'Accueil',
        'subtitle' => '',
    ];

    public $total;
    public $activities;

    public function mount()
    {
        if (!Auth::check()) {
            return redirect(route('login'));
        }
    }


    public function render()
    {
        $this->histo = new Astuce();
        $this->ventes = $this->histo->saleByMonth();
        $this->depenses = $this->histo->expenseByMonth();
        $this->activities[] = History::with('user')->where('user_id', Auth::user()->id)->orderBy('date', 'DESC')->paginate(6);

        $this->total = $this->histo->allCounts();

        return view('livewire.home', [
            'page' => 'home',
        ])
        ->layout('layouts.app');
    }
}
