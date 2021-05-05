<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Expense;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Depenses extends Component
{
    public $data = [
        'icon' => 'fa fa-file',
        'title' => 'Dépenses',
        'subtitle' => 'Liste des dépenses',
    ];
    public $etat = 'list';
    public $histo;
    public $payments;
    public $categories;

    public function addNew()
    {
        $this->data['subtitle'] = 'Ajout Dépense';
        $this->etat = 'add';
    }

    public function edit($id)
    {
        $this->data['subtitle'] = 'Edition Dépense';
        $this->etat = 'add';

        $depense = Expense::where('id', $id)->first();

        $this->form['id'] = $depense->id;
        $this->form['category'] = $depense->category;
        $this->form['payment_mode'] = $depense->payment_mode;
        $this->form['montant'] = $depense->montant;
        $this->form['date'] = $depense->date;
        $this->form['description'] = $depense->description;
        $this->form['recu'] = $depense->recu;
    }

    public function retour()
    {
        $this->data['subtitle'] = 'Liste des dépenses';
        $this->etat = 'list';

        $this->initForm();
    }

    public $form = [
            'category' => '',
            'payment_mode' => '',
            'montant' => '',
            'date' => '',
            'description' => '',
            'recu' => '',
            'id' => null,
    ];

    protected $rules = [
        'form.category' => 'required',
        'form.payment_mode' => 'required',
        'form.montant' => 'required',
        'form.date' => 'required'
    ];

    public function save()
    {
        $this->validate();

        if ($this->form['id']) {
            $prod = Expense::where('id', $this->form['id'])->first();

            $prod->category = $this->form['category'];
            $prod->montant = $this->form['montant'];
            $prod->description = $this->form['description'];
            $prod->date = $this->form['date'];
            $prod->recu = $this->form['recu'];
            $prod->payment_mode = $this->form['payment_mode'];
            $prod->save();

            $this->dispatchBrowserEvent('depenseUpdated');

            $this->histo->addHistorique("Edition d'une dépense", "Edition");
        } else {
            Expense::create([
                'category' => $this->form['category'],
                'montant' => $this->form['montant'],
                'description' => $this->form['description'],
                'date' => $this->form['date'],
                'recu' => $this->form['recu'],
                'payment_mode' => $this->form['payment_mode'],
            ]);

            $this->dispatchBrowserEvent('depenseAdded');

            $this->histo->addHistorique("Ajout d'une dépense", "Ajout");
        }

        $this->retour();
    }

    public function delete($id)
    {
        $depense = Expense::where('id', $id)->first();

        $depense->delete();
    }

    public function mount()
    {
        if (!Auth::check()) {
            return redirect(route('login'));
        }
    }

    public function render()
    {
        $depenses =Expense::orderBy('date', 'DESC')->get();

        $this->histo = new Astuce();

        $this->payments = $this->histo->getPaymentsMode();
        $this->categories = $this->histo->getExpenseType();

        return view('livewire.depenses', [
            'page' => 'depense',
            'depenses' => $depenses,
        ])->layout('layouts.app');
    }

    private function initForm()
    {
        $this->form['category'] = '';
        $this->form['payment_mode'] = '';
        $this->form['montant'] = '';
        $this->form['date'] = '';
        $this->form['description'] = '';
        $this->form['recu'] = '';
        $this->form['id'] = null;
    }
}
