<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Statamic\Facades\GlobalSet;

class SimpleContact extends Mailable
{
    use Queueable, SerializesModels;

    public $form;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $form)
    {
        $this->form = $form;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fromEmail = GlobalSet::find('onoffice')->in('default')->get('e-mail_formulare_send_from_e-mail');

        return $this->from($fromEmail, 'Kontaktanfrage Website')
            ->subject('Kontaktanfrage von Ihrer Webseite')
            ->view('email.standard'); // verwendet Ihre ursprüngliche Blade-View zum Rendern der E-Mail
    }
}
