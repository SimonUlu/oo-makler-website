<?php

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Statamic\Facades\Entry;
use Statamic\Facades\GlobalSet;

class EstateUserComponent extends Component
{
    public $estateId;

    public $logoUrl;

    public string $userName = '';

    public string $userImage = '';

    public bool $loaded = false;

    public int $userId = 21;

    public bool $loadedImage = false;

    public bool $showUser = false;

    public string $email = '';

    public string $userHrefUrl = '';

    public string $userPhoneNumber = '';

    public $source;

    public function mount($estateId, $logoUrl, $userId, $source): void
    {
        $this->estateId = $estateId;
        $this->logoUrl = $logoUrl;
        $this->userId = $userId;
        $this->source = $source;
    }

    public function render(): View
    {
        $this->showUser = GlobalSet::find('estate_appearance_configuration')->in('default')->get('ansprechpartner');

        return view('livewire.estate-user-component', [
            'ansprechpartner' => $this->showUser,
        ]);
    }

    public function loadUser($userId): void
    {
        $this->userId = $userId;
        $this->load();
    }

    public function load(): void
    {
        $userDetails = Entry::query()->where('collection', 'on_office_users')
            ->where('Nr', $this->userId)
            ->get()
            ->first();

        if ($userDetails) {
            $this->userName = $userDetails->Vorname.' '.$userDetails->Nachname;
            $this->userImage = $userDetails->photo ?? '';  // Ensure it's a string
            $this->userPhoneNumber = $userDetails->Telefon;
            $this->email = $userDetails->email;
            $this->loadedImage = true;
        } else {
            $this->userName = '';
        }

        $this->loaded = true;
    }
}
