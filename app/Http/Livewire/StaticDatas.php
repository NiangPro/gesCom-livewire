<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use Livewire\Component;
use App\Models\StaticData;

class StaticDatas extends Component
{
    public $data = [
        'icon' => 'fas fa-database',
        'title' => 'Données Statiques',
        'subtitle' => 'Liste des données statiques'
    ];

    public $form = [
        'type' => '',
        'valeur' => '',
        'id' => null,
    ];

    public $etat = 'list';
    public $types;
    public $histo;

    protected $rules =[
        'form.type' => 'required',
        'form.valeur' => 'required',
    ];

    protected $messages = [
        'form.type.required' => 'Type requis.',
        'form.valeur.required' => 'Valeur requis.',
    ];

    public function removeSpace($value)
    {
        $tab = explode(' ', $value);

        return implode("_", $tab);
    }

    public function addNew()
    {
        $this->etat = 'add';
        $this->data['subtitle'] = 'Ajout donnée statique';
    }

    public function edit($id)
    {
        $this->etat = 'add';
        $this->data['subtitle'] = 'Edition donnée statique';

        $sd = StaticData::where('id', $id)->first();

        $this->form['id'] = $sd->id;
        $this->form['type'] = $sd->type;
        $this->form['valeur'] = $sd->valeur;
    }

    public function save()
    {
        $this->validate();
        if($this->form['id']){
            $sd = StaticData::where('id', $this->form['id'])->first();
            $sd->type = $this->form['type'];
            $sd->label = $this->form['type'];
            $sd->valeur = $this->form['valeur'];

            $sd->save();
            $this->dispatchBrowserEvent('staticDataUpdated');

            $this->histo->addHistorique("Edition d'une donnée statique", "Edition");
        }else{

            StaticData::create([
                'type' => $this->form['type'],
                'valeur' => $this->form['valeur'],
                'label' => $this->form['type'],
                'statut' => 0,
            ]);
            $this->dispatchBrowserEvent('staticDataAdded');
            $this->dispatchBrowserEvent('staticDataAdded');

            $this->histo->addHistorique("Ajout d'une donnée statique", "Ajout");
        }

        $this->retour();
    }

    public function retour()
    {
        $this->etat = 'list';
        $this->initForm();
    }

    public function delete($id)
    {
        $sd = StaticData::where('id', $id)->first();
        $sd->delete();

        $this->histo->addHistorique("Suppression d'une donnée statique", "Suppression");
        $this->dispatchBrowserEvent('staticDataDeleted');

    }


    public function render()
    {
        $this->histo = new Astuce();
        $staticDatas = StaticData::all()->groupBy('type');
        $this->types = StaticData::orderBy('type', 'ASC')->distinct()->get('type');

        return view('livewire.static-datas', [
            'page' => 'staticData',
            'staticDatas' => $staticDatas,
        ])
        ->layout('layouts.app');
    }

    private function initForm()
    {
        $this->form['type'] = '';
        $this->form['valeur'] = '';
        $this->form['id'] = null;
    }
}
