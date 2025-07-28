<?php

namespace App\Controllers;
use CodeIgniter\Cookie\Cookie;
use DateTime;

class Home extends BaseController
{
    public function index(): string {
        if ($this->request->getCookie('room')) {return view('summarylist');}
        else {return view('intro');}
    }

    public function getFull(): string {
        return view('fulllist');
    }
}
