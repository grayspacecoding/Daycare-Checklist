<?php

namespace App\Controllers;
use CodeIgniter\Cookie\Cookie;
use DateTime;

class Sessionmods extends BaseController
{
    public function postSetroom($room) : string
    {
        $setroomModel = model('Setroom');
        $result = $setroomModel->setRoom($room);
        return $room;
    }

    public function postGetroom() : string
    {
        return $this->request->getCookie('room') ?? '';
    }

    public function postExitroom() : string
    {
        $setroomModel = model('Setroom');
        $result = $setroomModel->clearRoom();
        return '';
    }
}
