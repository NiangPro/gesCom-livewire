<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Astuce;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

class Profil extends Component
{
    use WithFileUploads;

    public $data = [
        'icon' => 'icon-user',
        'title' => 'Utilisateur',
        'subtitle' => 'Vos informations'
    ];

    public $photo;
    public $histo;

    public $form = [
        'name' => '',
        'email' => '',
        'role' => '',
        'sexe' => '',
        'avatar' => '',
        'id' => null
    ];

    protected $rules = [
        'form.name' => 'required|min:2',
        'form.email' => 'required',
        'form.role' => 'required',
        'form.sexe' => 'required',
    ];

    protected $messages = [
        'form.email.required' => 'L\'email est requis',
        'form.role.required' => 'Le rôle est requis',
        'form.sexe.required' => 'Le genre est requis',
        'form.name.required' => 'Le nom est requis',
        'form.name.min' => 'Le nom doit avoir au minimum 2 caractéres',
    ];


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

    public function uploadImage()
    {
        if ($this->form['id']) {
            $this->validate([
                'photo' => 'image|max:1024'
            ]);

            $user = User::where('id', $this->form['id'])->first();

            $imgName = 'img_user_' . md5($this->form['id']) . '.jpg';

            $this->photo->storeAs('public/images', $imgName);

            $user->avatar = $imgName;
            $user->save();

            $this->form['avatar'] = $imgName;

            $this->photo = null;

            $this->dispatchBrowserEvent('userUpdated');

            $this->histo->addHistorique("Edition de l'image d'un utilisateur", "Edition");
            $this->photo = null;
        }
    }

    public function save()
    {
        if ($this->form['id']) {
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
        }
    }

    public function mount()
    {
        $this->form['id'] = Auth::user()->id;
        $this->form['name'] = Auth::user()->name;
        $this->form['email'] = Auth::user()->email;
        $this->form['avatar'] = Auth::user()->avatar;
        $this->form['sexe'] = Auth::user()->sexe;
        $this->form['role'] = Auth::user()->role;

    }
    public function render()
    {
        $this->histo = new Astuce();

        return view('livewire.profil', [
            'page' => 'profil',
        ])->layout('layouts.app');
    }

}
