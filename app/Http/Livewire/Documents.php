<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use Livewire\Component;
use App\Models\Document;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Documents extends Component
{

    use WithFileUploads;

    public $form = [
        'titre' =>'',
        'fichier' =>'',
        'id'=> ''
    ];

    protected $rules = [
        'form.titre' => 'required',
        'form.fichier' => 'file',
    ];

    protected $messages = [
        'form.titre.required' => 'Le champ titre est requis',
        'form.fichier.file' => 'Fichier invalide',
    ];

    public $idEmp;
    public $histo;
    public $etat = 'list';
    public $title = 'liste des documents';

    public function addNew()
    {
        $this->etat = 'add';
        $this->title = 'Ajout document';
    }

    public function retour()
    {
        $this->etat = 'list';
        $this->title = 'liste des documents';
        $this->initForm();
    }

    public function save()
    {
        $this->validate();

        $contrat = 'contrat_'.uniqid().'.pdf';

        $this->form['fichier']->storeAs('public/contrats', $contrat);

        Document::create([
            'titre' => $this->form['titre'],
            'fichier' => $contrat,
            'employed_id' => $this->idEmp
        ]);

        $this->dispatchBrowserEvent('contratAdded');

        $this->histo->addHistorique("Ajout d'un contrat employé", "Ajout");
        $this->retour();
    }

    public function mount($id)
    {
        $this->idEmp = $id;

        if (!Auth::check()) {
            return redirect(route('login'));
        }
    }

    public function render()
    {
        $this->histo = new Astuce();

        $docs = Document::where('employed_id', $this->idEmp)->orderBy('id', 'DESC')->get();

        return view('livewire.documents', [
            'docs' =>$docs
        ]);
    }

    private function initForm()
    {
        $this->form['titre'] = '';
        $this->form['fichier'] = null;
    }
}
