<?php

namespace App\Http\Livewire;

use App\Models\Astuce;
use App\Models\Client;
use App\Mail\EnvoiMail;
use App\Models\Message;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Chats extends Component
{
    use WithFileUploads;

    public $histo;
    public $clients;
    public $client;
    public $clientActif;
    public $messagers;
    public $clientMessagers;

    public $form = [
        'contenu' => '',
        'fichier' => null,
        'client_id' => ''
    ];
    protected $rules = [
        'form.contenu' => 'required',
        'form.fichier' => 'file',
        'form.client_id' => 'required'
    ];

    protected $messages = [
        'form.contenu' => 'Ce champ est requis',
        'fichier.file'=> 'Fichier invalide',
        'form.client_id' => 'Ce champ est requis'
    ];

    public $data = [
        'icon' => 'icon-envelope-letter',
        'title' => 'Messages',
        'subtitle' => 'Envoi messages',
    ];

    public function mount()
    {
        if (!Auth::check()) {
            return redirect(route('login'));
        }
    }

    public function send()
    {
        $this->validate();


        $pdf = 'pdf_' . uniqid() . '.pdf';

        $this->form['fichier']->storeAs('public/fichiers', $pdf);

        Message::create([
            'contenu' => $this->form['contenu'],
            'fichier' => $pdf,
            'client_id' => $this->form['client_id'],
            'user_id' => Auth::user()->id
        ]);

        $data = [
            'title' => 'Le titre',
            'contenu' => $this->form['contenu'],
            'fichier' => $this->form['fichier'],
        ];

        $client = Client::where('id', $this->form['client_id'])->first();


        $this->dispatchBrowserEvent('mailSent');

        $this->formInit();
        $this->histo->addHistorique("Envoi message", "Ajout");

        Mail::to($client->email)->send(new EnvoiMail($data));
    }

    public function currentClient($id)
    {
        // dd($id);
        $this->clientActif = Client::with(['messages'])->where('id', $id)->first();
    }

    public function render()
    {
        $this->histo = new Astuce();
        $this->clients = Client::orderBy('nom', 'ASC')->get();

        $this->clientMessagers = $this->listClients();


        $this->client = $this->clientActif ? $this->clientActif : $this->lastClient();

        return view('livewire.chats', [
            'page' => 'chat'
        ])->layout('layouts.app');
    }

    private function formInit()
    {
        $this->form['contenu'] = '';
        $this->form['fichier'] = null;
        $this->form['client_id'] = '';
    }

    private function listClients()
    {
        $clients = Message::with(['user', 'client'])->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->distinct()->get('client_id');
        $data = [];
        foreach ($clients as $cli) {
            $data[] = Client::with(['messages'])->where('id', $cli->client_id)->first();
        }

        return count($data) > 0 ? $data : null;
    }

    private function lastClient()
    {
        $clients = Message::with(['user', 'client'])->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->distinct()->get('client_id');
        $result = count($clients) > 0
                    ? Client::with(['messages'])->where('id', $clients[0]->client_id)->first()
                    :null;

        return $result;
    }
}
