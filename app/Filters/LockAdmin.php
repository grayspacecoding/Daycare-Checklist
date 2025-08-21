<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class LockAdmin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $cookieName = 'admin';
        if (!session()->get('isAdmin')) {
            return service('response')->setBody(view('adminaccess'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after response
    }
}