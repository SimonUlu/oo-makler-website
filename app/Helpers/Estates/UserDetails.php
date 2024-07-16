<?php

namespace App\Helpers\Estates;

class UserDetails
{
    public $vorname;

    public $nachname;

    public $email;

    public $userUrl;

    public $userHrefUrl;

    public $userPhoneNumber;

    public $picUrl;

    public function __construct($vorname = '', $nachname = '', $email = '', $picUrl = '', $phoneNumber = '', $userUrl = '', $userHrefUrl = '')
    {
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->email = $email;
        $this->picUrl = $picUrl;
        $this->userPhoneNumber = $phoneNumber;
        $this->userUrl = $userUrl;
        $this->userHrefUrl = $userHrefUrl;

    }
}
