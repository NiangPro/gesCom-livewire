<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvoiMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $contenu = $this->data['contenu'];
        return $this->subject('Email subjet')->view('emails.email_template', compact('contenu'))
                ->attach($this->data['fichier']->getRealPath(), [
                    'as' => $this->data['fichier']->getClientOriginalName()
                ]);
    }
}
