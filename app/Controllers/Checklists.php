<?php

namespace App\Controllers;
use CodeIgniter\Cookie\Cookie;
use DateTime;

class Checklists extends BaseController
{
    protected $clModel;

    public function __construct() {
        $this->clModel = model('checklists');

    }

    private function failNoRoom(): string
    {
        return json_encode([
            'error' => 'No room set. Please set a room before proceeding.'
        ]);
        exit;
    }

    public function postCrud($action, $specifier = false): object
    {
        switch($action) {
            case "all":
                $data = $this->clModel->where('room', $this->request->getCookie('room'))->findAll($specifier);
                return $this->response->setJSON(json_encode($data));
                break;
            case "single":
                break;
            case "create":
                break;
            case "save":
                break;
        }
    }
}