<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Astuce;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $data = [
        'icon' => 'icon-users',
        'title' => 'Utilisateurs',
        'subtitle' => 'Liste des utilisateurs'
    ];

    public $etat = 'list';
    public $photo;
    public $histo;

    public $form = [
        'name' => '',
        'email' => '',
        'role' => '',
        'sexe' => '',
        'avatar' => '',
        'password' => '',
        'password_confirmation' => '',
        'id' => null
    ];

    protected $rules = [
        'form.name' => 'required|min:2',
        'form.email' => 'required',
        'form.role' => 'required',
        'form.sexe' => 'required',
        'form.password' =>'required|min:6|confirmed',
    ];

    protected $messages = [
        'form.email.required' => 'L\'email est requis',
        'form.role.required' => 'Le rôle est requis',
        'form.sexe.required' => 'Le genre est requis',
        'form.name.required' => 'Le nom est requis',
        'form.name.min' => 'Le nom doit avoir au minimum 2 caractéres',
        'form.password.required' => 'Ce champ est requis',
        'form.password.min' => 'Le mot de passe doit avoir minimum 6 caractères',
        'form.password.confirmed' => 'Les deux mots de passe sont différents',
    ];

    public function addNew()
    {
        $this->etat = 'add';
        $this->data['subtitle'] = 'Ajout Utilisateur';
    }

    public function info($id)
    {
        $user = User::where('id', $id)->first();

        $this->form['id'] = $user->id;
        $this->form['avatar'] = $user->avatar;
        $this->form['name'] = $user->name;
        $this->form['email'] = $user->email;
        $this->form['sexe'] = $user->sexe;
        $this->form['role'] = $user->role;

        $this->etat = 'info';
        $this->data['subtitle'] = 'Information Utilisateur';
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->first();

        $this->form['id'] = $user->id;
        $this->form['avatar'] = $user->avatar;
        $this->form['name'] = $user->name;
        $this->form['email'] = $user->email;
        $this->form['sexe'] = $user->sexe;
        $this->form['role'] = $user->role;

        $this->etat = 'edit';
        $this->data['subtitle'] = 'Edition mot de passe Utilisateur';
    }

    public function retour()
    {
        $this->etat = 'list';
        $this->data['subtitle'] = 'Liste des utilisateurs';
        $this->formInit();
    }

    public function editPassword()
    {
        if($this->form['id']){
            $this->validate([
                'form.password' => 'required|min:6|confirmed',
            ]);
            $user = User::where('id', $this->form['id'])->first();

            $user->password = Hash::make($this->form['password']);
            $user->save();

            $this->histo->addHistorique("Edition de mot de passe d'un utilisateur", "Edition");

        }

        $this->retour();
    }


    public function uploadImage()
    {
        if ($this->form['id']) {
            $this->validate([
                'photo' => 'image|max:1024'
            ]);

            $user = User::where('id', $this->form['id'])->first();

            $imgName = 'img_user_' . md5($this->form['id']) . '.jpg';

            $this->photo->storeAs('public/images', $imgName);

            $user->profil = $imgName;
            $user->save();

            $this->form['avatar'] = $imgName;

            $this->photo = null;

            $this->dispatchBrowserEvent('userUpdated');

            $this->histo->addHistorique("Edition de l'image d'un utilisateur", "Edition");
        }
    }

    public function save()
    {
        if($this->form['id']){
            $this->validate([
                'form.name' => 'required|min:2',
                'form.email' => 'required',
                'form.role' => 'required',
                'form.sexe' => 'required'
            ]);
            $user = User::where('id', $this->form['id'])->first();

            $user->name = $this->form['name'];
            $user->email = $this->form['email'];
            $user->role = $this->form['role'];
            $user->sexe = $this->form['sexe'];

            $user->save();
            $this->dispatchBrowserEvent('userUpdated');

            $this->histo->addHistorique("Edition d'un utilisateur", "Edition");

        }else{
            $this->validate();

            User::create([
                'name' => $this->form['name'],
                'email' => $this->form['email'],
                'password' => Hash::make($this->form['password']),
                'role' => $this->form['role'],
                'sexe' => $this->form['sexe'],
                'avatar' => $this->form['sexe'] === 'Homme' ? "user-male.png" : "user-female.png"
            ]);


            $this->dispatchBrowserEvent('userAdded');
            $this->histo->addHistorique("Ajout d'un utilisateur", "Ajout");

        }
        $this->retour();
    }

    public function delete($id)
    {
        $user = User::where('id', $id)->first();

        $user->delete();
        $this->dispatchBrowserEvent('userDeleted');
        $this->histo->addHistorique("Suppression d'un utilisateur", "Suppression");
    }

    public function render()
    {
        $users = User::orderBy('name', 'ASC')->paginate(8);
        $this->histo = new Astuce();
        $this->fonctions = $this->histo->getFonction();

        return view('livewire.users', [
            'page' => 'users',
            'users' => $users,
        ])->layout('layouts.app');
    }

    public function formInit()
    {
        $this->form['name'] = '';
        $this->form['email'] = '';
        $this->form['role'] = '';
        $this->form['sexe'] = '';
        $this->form['avatar'] = '';
        $this->form['id'] = null;
        $this->form['password'] = '';
        $this->form['password_confirmation'] = '';
        $this->photo = null;
    }

    public function mount()
    {
        if (!Auth::check()) {
            return redirect(route('login'));
        }
    }
}
