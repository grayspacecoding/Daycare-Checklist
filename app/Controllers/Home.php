<?php

namespace App\Controllers;
use CodeIgniter\Cookie\Cookie;
use DateTime;

class Home extends BaseController
{
    public function index(): string {
        return $this->summary();
    }

    protected function summary(): string {
        return view('summarylist');
    }

    public function getFull(): string {
        return view('fulllist');
    }
}
