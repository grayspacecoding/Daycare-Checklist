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

    public function postGetroom() : string
    {
        return $this->request->getCookie('room') ?? '';
    }

    public function postExitroom() : string
    {
        $cookie = new Cookie('room', '', [
            'expires' => time() - 3600, // Set to expire in the past
            'path' => '/',
            'secure' => true,
            'httponly' => true,
        ]);
        $this->response->setCookie($cookie);
        return '';
    }
}
