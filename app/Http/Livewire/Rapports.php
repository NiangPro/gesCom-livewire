<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Rapports extends Component
{
    public $data = [
        'icon' => 'fas fa-chart-bar',
        'title' => 'Rapports',
        'subtitle' => 'Comptabilité Générale',
    ];

    public $histo;
    public $sumSale;
    public $sumExpense;
    public $ventes;
    public $depenses;
    public $compta;

    public function mount()
    {
        if (!Auth::check()) {
            return redirect(route('login'));
        }
    }

    public function render()
    {
        $this->histo = new Astuce();
        $this->sumSale = $this->histo->sumSale();
        $this->sumExpense = $this->histo->sumExpense();

        $this->ventes = $this->histo->saleByMonth();
        $this->depenses = $this->histo->expenseByMonth();
        $this->compta = $this->histo->compta();

        return view('livewire.rapports', [
            'page' => 'rapport'
        ])->layout('layouts.app');
    }
}
