<?php

namespace App\Mail;

use App\Helpers\Contacts\ContactHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use SimpleXMLElement;
use Statamic\Facades\GlobalSet;

class ContactFormMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;

    public $view;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $view = 'emails.default-contact')
    {
        $this->data = [
            'formData' => $data['formData'],
        ];
        $this->view = $view;
    }

    public function build()
    {
        $formData = $this->data['formData'];
        $xmlString = ContactHelper::createOpenImmoXml(addressData: $formData);

        if ($xmlString !== null) {
            $xml = new SimpleXMLElement($xmlString);

            return $this->from(GlobalSet::find('onoffice')->in('default')->get('e-mail_formulare_send_from_e-mail') ?? 'noreply@inno-brain.de')
                ->view($this->view)
                ->with(['formData' => $formData])
                ->attachData($xml->asXML(), 'openimmo.xml', [
                    'mime' => 'application/xml',
                ]);
        } else {
            return $this->from(GlobalSet::find('onoffice')->in('default')->get('e-mail_formulare_send_from_e-mail') ?? 'noreply@inno-brain.de')
                ->view($this->view)
                ->with(['formData' => $formData]);
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Neue Kontaktanfrage von Ihrer Website ('.$this->data['formData']['title_request'].') [eigene-Website]',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
