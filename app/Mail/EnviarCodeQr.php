<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnviarCodeQr extends Mailable
{
    use Queueable, SerializesModels;
    public $codigo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Correos.codeqr')
            ->from('movilidadmanta@gmail.com', 'TICS MOVILIDAD.')
            ->subject('Codigo generador para su permiso.');
    }
}