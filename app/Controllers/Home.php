<?php

namespace App\Controllers;
use CodeIgniter\Cookie\Cookie;
use DateTime;

class Home extends BaseController
{
    public function index() {
        return view('intro');
    }
}
