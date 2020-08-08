<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link = url('/') . '/recuperarSenha/novaSenha/' . $this->token . '?email=' . $this->email;
        return $this->from('to@email.com', 'Laravel')
                ->view('emails.recuperarSenha')
                ->subject('Recuperar Senha')
                ->with([
                    'link' => $link
                ]);
    }
}
