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

class ProjectContactMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = [
            'formData' => $data['formData'],
            'estateData' => $data['estateData'],
            'addressData' => $data['addressData'],
        ];
    }

    public function build()
    {
        $formData = $this->data['formData'];
        $xmlString = ContactHelper::createOpenImmoXml(estateData: $this->data['estateData'], addressData: $this->data['addressData']);

        if ($xmlString !== null) {
            $xml = new SimpleXMLElement($xmlString);

            return $this->from(GlobalSet::find('onoffice')->in('default')->get('e-mail_formulare_send_from_e-mail') ?? 'noreply@inno-brain.de')
                ->view('emails.project-contact')
                ->with(['formData' => $formData])
                // attach xml file
                ->attachData($xml->asXML(), 'openimmo.xml', [
                    'mime' => 'application/xml',
                ]);
        } else {
            return $this->from(GlobalSet::find('onoffice')->in('default')->get('e-mail_formulare_send_from_e-mail') ?? 'noreply@inno-brain.de')
                ->view('emails.project-contact')
                ->with(['formData' => $formData]);
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Neue Projekt-Anfrage von Ihrer Website',
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
