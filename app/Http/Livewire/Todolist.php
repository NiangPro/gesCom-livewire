<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Todolist as Todo;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Todolist extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $etat = 'list';

    public $form = [
        'titre' => '',
        'date' => ''
    ];

    protected $rules = [
        'form.titre' => 'required',
        'form.date' => 'required'
    ];
    protected $messages = [
        'form.titre' => 'Ce champ est requis',
        'form.date' => 'Ce champ est requis'
    ];

    public function save()
    {
        $this->validate();

        Todo::create([
            'titre' => $this->form['titre'],
            'date' => $this->form['date'],
            'user_id' => Auth::user()->id,
            'is_check' => 0,
        ]);

        $this->dispatchBrowserEvent('todoAdded');
        $this->retour();
    }

    public function delete($id)
    {
        $td = Todo::where('id', $id)->first();
        $td->delete();

        $this->dispatchBrowserEvent('todoDeleted');
    }

    public function retour()
    {
        $this->etat = 'list';
        $this->initForm();
    }

    public function add()
    {
        $this->etat = 'add';
    }

    public function render()
    {
        $todos = Todo::with('user')->where('user_id', Auth::user()->id)->orderBy('date', 'DESC')->paginate(6);
        return view('livewire.todolist', [
            'todos' => $todos
        ]);
    }

    private function initForm()
    {
        $this->form['titre'] = '';
        $this->form['date'] = '';
    }
}
