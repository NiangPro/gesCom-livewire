<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use Livewire\Component;

class RapportBetween extends Component
{
    public $histo;
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

        if ($this->form['dateFrom'] > $this->form['dateTo']) {
            $this->dispatchBrowserEvent('errorDate');
        } else {
            $this->results = $this->histo->getSumBetweenTwoDate($this->form);
            $this->etat = true;
        }
    }

    private function initForm()
    {
        $this->form['dateFrom'] = '';
        $this->form['dateTo'] = '';
    }

    public function refresh()
    {
        $this->etat = false;
        $this->initForm();
    }

    public function render()
    {
        $this->histo = new Astuce();
        return view('livewire.rapport-between');
    }
}
