<?php

namespace App\Controllers;
use CodeIgniter\Cookie\Cookie;
use \Ramsey\Uuid\Uuid;
use DateTime;

class Checklists extends BaseController
{
    protected $clModel;

    public function __construct() {
        $this->clModel = model('checklists');
    }

    public function getIndex(): string {
        return view('fulllist');
    }

    public function getSingle($id) {
        $checklist = $this->clModel->find($id);
        $room = $checklist->room;
        $setroomModel = model('Setroom');
        $room = $setroomModel->setRoom($room);
        return view('single', [
            'checklist' => $checklist,
            'formdata' => json_decode($checklist->form_data)
        ]);
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
        try{
            switch($action) {
                case "all":
                    $columns = ['id', 'room', 'created', 'completed_on', 'date_applied', 'status'];
                    $data = $this->clModel->where('room', $this->request->getCookie('room'))->findAll($specifier);
                    return $this->response->setJSON(json_encode($data));
                    break;
                case "single":
                    break;
                case "create":
                    if (!$this->request->getCookie('room')) {
                        return $this->response->setJSON($this->failNoRoom());
                    }
                    $uuid = Uuid::uuid4()->toString();
                    $data = [
                        "id" => $uuid,
                        "room" => $this->request->getCookie('room'),
                        "date_applied" => date('Y-m-d')
                    ];
                    $this->clModel->insert($data);
                    return $this->response->setJSON(json_encode([
                        'success' => true,
                        'id' => $uuid
                    ]));
                    break;
                case "save":
                    $data = [
                        "id" => $specifier ?? null,
                        "date_applied" => date('Y-m-d H:i:s'),
                        "form_data" => json_encode($_POST),
                        "room" => $this->request->getCookie('room'),
                    ];
                    $this->clModel->save($data);
                    return $this->response->setJSON(json_encode([
                        'success' => true,
                        'id' => $data['id'] ?? $this->clModel->insertID()
                    ]));
                    break;
            }
        }
        catch (\Exception $e) {
            return $this->response->setJSON(json_encode([
                'error' => 'An error occurred: ' . $e->getMessage()
            ]));
        }
    }
}