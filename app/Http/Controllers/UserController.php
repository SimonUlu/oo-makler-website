<?php

namespace App\Http\Controllers;

use App\Services\OnOfficeService;

class UserController extends Controller
{
    public static function getUser($user_id)
    {

        $onOfficeService = new OnOfficeService();
        $user = $onOfficeService->getOnOfficeUserById($user_id);

        return $user;
    }

    public static function concatenateUsers(array $estates)
    {
        $onOfficeService = new OnOfficeService();

        foreach ($estates as &$estate) {
            $userId = $estate['elements']['benutzer'] ?? null;

            if ($userId !== null) {
                $user = $onOfficeService->getOnOfficeUserById($userId);
                $estate['elements']['user'] = $user;
            }
        }

        return $estates;
    }
}
