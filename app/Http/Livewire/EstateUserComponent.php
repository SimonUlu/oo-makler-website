<?php

namespace App\Http\Livewire;

use App\Services\OnOfficeService;
use Livewire\Component;
use Statamic\Facades\GlobalSet;

class EstateUserComponent extends Component
{
    public $estateId;

    public $logoUrl;

    public $userName = '';

    public $userUrl = '';

    public $loaded = false;

    public $userId = 21;

    public $loadedImage = false;

    public $showUser = false;

    public $email = '';

    public $userHrefUrl = '';

    public $source;

    public function mount($estateId, $logoUrl, $userId, $source)
    {
        $this->estateId = $estateId;
        $this->logoUrl = $logoUrl;
        $this->userId = $userId;
        $this->source = $source;
    }

    public function render()
    {
        $this->showUser = GlobalSet::find('estate_appearance_configuration')->in('default')->get('ansprechpartner');

        return view('livewire.estate-user-component', [
            'ansprechpartner' => $this->showUser,
        ]);
    }

    public function loadUser($userId)
    {
        $this->userId = $userId;
        $this->load();
    }

    public function load()
    {
        $onOfficeService = new OnOfficeService();
        $userDetails = $onOfficeService->getOnOfficeUserById($this->userId);

        if ($userDetails) {
            $this->userName = $userDetails->vorname.' '.$userDetails->nachname;
            $this->userUrl = $userDetails->picUrl;
            $this->userHrefUrl = $userDetails->userHrefUrl;
            $this->email = $userDetails->email;
            $this->loadedImage = true; // Stellen Sie sicher, dass dies korrekt gesetzt wird, basierend auf ob ein Bild vorhanden ist oder nicht.
        } else {
            $this->userName = '';
        }
        $this->loaded = true;
    }
}
