<?php

namespace App\Controllers;
use CodeIgniter\Cookie\Cookie;
use DateTime;

class Dashboard extends BaseController
{
    function __construct() {
        $this->clModel = new \App\Models\Checklists();
    }

    public function getIndex() {
        $room = $this->request->getCookie('room');
        return view('dashboard', [
            'room' => $room,
            'checklist' => $this->todaysChecklist($room),
            'previous' => $this->previousChecklist($room),
            'recent' => $this->clModel->orderBy('date_applied', 'DESC')->where('room', $room)->findAll(10),
        ]);
    }

    public function getFulllist() {
        $room = $this->request->getCookie('room');
        return view('fulllist', ["lists" => $this->clModel->orderBy('date_applied', 'DESC')->where('room', $room)->findAll()]);
    }

    protected function todaysChecklist($room, $previous = false) {
        $today = date('o-m-d');
        return $this->clModel->where(['date_applied' => $today, 'room' => $room])->first();
    }

    protected function previousChecklist($room) {
        $items = [];
        $counts = 0;
        $yesterday = date('o-m-d', strtotime('-1 day'));
        $list = $this->clModel->orderBy('date_applied', 'DESC')->where(['date_applied <=' => $yesterday, 'room' => $room])->first();
        if (!$list) {$items[] = 'No previous checklist found!'; $counts = 1;}
        elseif ($list->status == 'active') {$items[] = 'The previous checklist is still in progress!'; $counts = 1;}
        else {
            $responses = json_decode($list->form_data);
            $schemaModel = new \App\Models\Checklistschema();
            $schema = $schemaModel->currentVersion();
            foreach ($schema['checklist_items'] as $section) {
                $index = 0;
                $payload = ["section" => $section['section'], "groups" => []];
                $count = 0;
                //$counts[$section['section']] = 0;
                foreach ($section['groups'] as $group) {
                    $payload['groups'][$group['title'] ?: 'General'] = [];
                    foreach ($group['inputs'] as $input) {
                        $checked = $responses->{$section['shortcode'].'_'.$index} ?? 0;
                        if (!$checked) {
                            $payload['groups'][$group['title'] ?: 'General'][] = $input;
                            $count++;
                        }
                        $index++;
                    }
                }
                if ($count > 0) {
                    $items[] = $payload;
                    $counts += $count;
                }
            }
        }
        return ["i" => $items, "c" => $counts];
    }
}