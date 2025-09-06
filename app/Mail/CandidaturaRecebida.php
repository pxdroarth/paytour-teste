<?php

namespace App\Mail;

use App\Models\Candidatura;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CandidaturaRecebida extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Candidatura $candidatura) {}

    public function build()
    {
        $mail = $this->subject('Nova Candidatura Recebida')
            ->markdown('emails.candidatura', ['c' => $this->candidatura]);

        if ($this->candidatura->arquivo_path && Storage::exists($this->candidatura->arquivo_path)) {
            $mail->attach(Storage::path($this->candidatura->arquivo_path));
        }
        return $mail;
    }
}
