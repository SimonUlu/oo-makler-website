<?php

namespace App\Http\Livewire;

use App\Services\OnOfficeService;
use Livewire\Component;
use Statamic\Facades\GlobalSet;

class UserDetailShow extends Component
{
    public $estateId;

    public $userId;

    public $showUser;

    public $userName;

    public $userUrl;

    public $loaded;

    public $loadedImage = false;

    public $businessName = '';

    public $userExists = false;

    public $userEmail = '';

    public $userPhoneNumber = '';

    public function mount($estateId, $userId)
    {
        $this->estateId = $estateId;
        $this->userId = $userId;
    }

    public function render()
    {
        $this->showUser = GlobalSet::find('estate_appearance_configuration')->in('default')->get('ansprechpartner');

        return view('livewire.user-detail-show', [
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
            $this->userEmail = $userDetails->email;
            $this->userUrl = $userDetails->picUrl;
            $this->userPhoneNumber = $userDetails->userPhoneNumber;
            $this->loadedImage = true;
            $this->loaded = true;
        } else {
            $vorname = '';
            $nachname = '';
            $this->userName = $vorname.' '.$nachname;
            $this->loaded = true;
        }
        $this->loaded = true;
    }
}
