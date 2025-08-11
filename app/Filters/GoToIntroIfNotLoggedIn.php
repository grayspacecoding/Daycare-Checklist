<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class GoToIntroIfNotLoggedIn implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $cookieName = 'room';
        if (!$request->getCookie($cookieName)) {
            return service('response')->setBody(view('intro'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after response
    }
}