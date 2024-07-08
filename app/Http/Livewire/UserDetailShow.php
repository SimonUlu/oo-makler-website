<?php

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Statamic\Facades\Entry;
use Statamic\Facades\GlobalSet;

class UserDetailShow extends Component
{
    public int $estateId;

    public int $userId;

    public bool $showUser;

    public string $userName;

    public string $userImage;

    public bool $loaded;

    public bool $loadedImage = false;

    public string $businessName = '';

    public bool $userExists = false;

    public string $userEmail = '';

    public string $userPhoneNumber = '';

    public string $email;

    public function mount($estateId, $userId): void
    {
        $this->estateId = $estateId;
        $this->userId = $userId;
    }

    public function render(): View
    {
        $this->showUser = GlobalSet::find('estate_appearance_configuration')->in('default')->get('ansprechpartner');

        return view('livewire.user-detail-show', [
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
            $this->userImage = $userDetails->photo ?? '';
            $this->userPhoneNumber = $userDetails->Telefon;
            $this->email = $userDetails->email;
            $this->loadedImage = true;
        } else {
            $vorname = '';
            $nachname = '';
            $this->userName = $vorname.' '.$nachname;
        }
        $this->loaded = true;
    }
}
