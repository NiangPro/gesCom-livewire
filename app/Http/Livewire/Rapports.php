<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use Livewire\Component;

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
    public $results;
    public $etat = false;

    public $form = [
        'dateFrom' => null,
        'dateTo' => null,
    ];

    protected $rules = [
        'form.dateFrom' => 'required',
        'form.dateTo' => 'required',
    ];

    protected $messages = [
        'form.dateFrom.required' => 'Ce champs est requis',
        'form.dateTo.required' => 'Ce champs est requis',
    ];

    public function search()
    {
        $this->validate();

        if($this->form['dateFrom'] > $this->form['dateTo']){
            $this->dispatchBrowserEvent('errorDate');
        }else{
            $this->results = $this->histo->getSumBetweenTwoDate($this->form);
            $this->etat = true;
        }
    }

    public function refresh()
    {
        $this->dispatchBrowserEvent('refresh');

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
