<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Passwords extends Component
{
    public $histo;

    public $data = [
        'icon' => 'icon-lock-open',
        'title' => 'Mot de passe',
        'subtitle' => 'Changement de mot de passe',
    ];

    public $form = [
        'password' => '',
        'password_confirmation' => '',
        'id' => null
    ];

    protected $rules = [
        'form.password' => 'required|min:6|confirmed',
    ];

    protected $messages = [
        'form.password.required' => 'Ce champ est requis',
        'form.password.min' => 'Le mot de passe doit avoir minimum 6 caractères',
        'form.password.confirmed' => 'Les deux mots de passe sont différents',
    ];

    public function editPassword()
    {
        if ($this->form['id']) {
            $this->validate([
                'form.password' => 'required|min:6|confirmed',
            ]);
            $user = User::where('id', $this->form['id'])->first();

            $user->password = Hash::make($this->form['password']);
            $user->save();
            $this->histo->addHistorique("Edition du mot de passe", "Edition");

        }

        $this->dispatchBrowserEvent('passwordUpdated');
    }

    public function mount()
    {
        if (!Auth::check()) {
            return redirect(route('login'));
        }
    }

    public function render()
    {
        $this->histo = new Astuce();
        $this->form['id'] = Auth::user()->id;

        return view('livewire.passwords', [
            'page' => 'mdp'
        ])->layout('layouts.app');
    }
}
