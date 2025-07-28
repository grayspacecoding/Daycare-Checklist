<?php

namespace App\Controllers;

class Uimods extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        // Set JavaScript content type for all methods in this controller
        $this->response->setHeader('Content-Type', 'text/javascript');
    }

    public function getLightdark(): string {return view('uimods/lightdark.js');}
    public function getSetroom(): string {return view('uimods/setroom.js');}
    public function getNewchecklist(): string {return view('uimods/newchecklist.js');}

}
