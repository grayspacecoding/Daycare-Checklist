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

    public function postAdminauth() {
        $passcode = $this->request->getPost('passcode');
        if ($passcode === getenv('admin.auth.passcode')) {
            session()->set('isAdmin', true);
            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setJSON(['status' => 'error']);
    }

    public function postAdmindeauth() {
        if (session()->get('isAdmin')) {
            session()->remove('isAdmin');
            return json_encode(['status' => 'success']);
        }
        return $this->response->setJSON(['status' => 'error']);
    }
}