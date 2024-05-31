<?php

namespace App\Helpers\Contacts;

use App\Mail\ContactFormMailable;
use App\Mail\EstateContactMailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use SimpleXMLElement;
use Statamic\Facades\GlobalSet;

class ContactHelper
{
    public static function createOpenImmoXml($estateData = null, $addressData = null): bool|string
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="iso-8859-1"?><openimmo_feedback xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"></openimmo_feedback>');

        // Adding the version using addChild directly since it does not involve special characters
        $xml->addChild('version', '1.2.5');

        $sender = $xml->addChild('sender');
        self::addCData($sender, 'name', 'InnoBrain');
        $sender->addChild('openimmo_anid');
        self::addCData($sender, 'datum', date('Y-m-d'));
        self::addCData($sender, 'makler_id', (string) rand());
        $sender->addChild('regi_id');

        $objekt = $xml->addChild('objekt');
        if (isset($estateData)) {
            foreach ($estateData as $key => $value) {
                if (str_contains($key, 'estate_')) {
                    $key = str_replace('estate_', '', $key);
                }
                self::addCData($objekt, strtolower($key), $value);
            }
        }

        $interessent = $objekt->addChild('interessent');
        if (isset($addressData)) {
            foreach ($addressData as $key => $value) {
                if (str_contains($key, 'address_')) {
                    $key = str_replace('address_', '', $key);
                }
                self::addCData($interessent, strtolower($key), $value);
            }
        }

        return $xml->asXML();
    }

    private static function addCData($parent, $nodeName, $nodeContent): void
    {
        $newChild = $parent->addChild($nodeName);
        if ($newChild !== null) {
            $node = dom_import_simplexml($newChild);
            $no = $node->ownerDocument;
            $node->appendChild($no->createCDATASection($nodeContent));
        }
    }

    public static function sendEmail($addressData)
    {
        try {
            $emailAddress = GlobalSet::find('onoffice')->in('default')->get('e-mail_inbox_expose-mails');
            $mailable = new ContactFormMailable(['formData' => $addressData]);

            Mail::to($emailAddress)->queue($mailable);

            session()->flash('success', 'Sie erhalten in Kürze weitere Informationen per E-Mail!');

        } catch (\Exception $e) {
            Log::error('Fehler beim Versenden der E-Mail: '.$e->getMessage());
            session()->flash('email_error', 'Beim Versenden Ihrer Anfrage ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut.');
        }
    }

    public static function sendEstateMail($addressData, $estateData)
    {
        try {
            $data = array_merge($addressData, $estateData);
            $mail = Mail::to(GlobalSet::find('onoffice')->in('default')->get('e-mail_inbox_expose-mails'))->queue(
                new EstateContactMailable([
                    'formData' => $data,
                    'estateData' => $estateData,
                    'addressData' => $addressData,
                ])
            );
            session()->flash('success', 'Sie erhalten in Kürze weitere Informationen per E-Mail!');

        } catch (\Exception $e) {
            Log::error('Fehler beim Versenden der E-Mail: '.$e->getMessage());
            session()->flash('email_error', 'Beim Versenden Ihrer Anfrage ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut.');
        }

    }
}
