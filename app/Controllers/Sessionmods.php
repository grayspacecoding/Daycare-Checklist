<?php

namespace App\Controllers;
use CodeIgniter\Cookie\Cookie;
use DateTime;

class Sessionmods extends BaseController
{
    public function postSetroom($room) : string
    {
        $cookie = new Cookie('room', $room, [
            'expires' => (new DateTime('+1 year'))->getTimestamp(),
            'path' => '/',
            'secure' => true,
            'httponly' => true,
        ]);
        $this->response->setCookie($cookie);
        return $room;
    }
}
