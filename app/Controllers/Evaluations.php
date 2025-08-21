<?php

namespace App\Controllers;
use CodeIgniter\Cookie\Cookie;
use DateTime;

class Evaluations extends BaseController
{
    protected $evModel;
    protected $esModel;

    function __construct() {
        $this->evModel = new \App\Models\Evaluations();
        $this->esModel = new \App\Models\Evalschemas();
    }

    public function getIndex() {
        $ongoing = $this->evModel->select('id, teacher, reviewed_on, updated, round')->where('status', 'ongoing')->findAll();
        $teachers = $this->evModel->select('teacher')->distinct()->orderBy('teacher', 'ASC')->findAll();
        $recent = $this->evModel->select('id, teacher, reviewed_on, updated, status')->where(['status !=' => 'ongoing'])->findAll(50);
        $evals = $this->esModel->select('id, title, version')->where(['usable' => true])->findAll();

        return view('evaluations/index', ['ongoing' => $ongoing, 'teachers' => $teachers, 'recent' => $recent, 'evals' => $evals]);
    }

    public function getSingle($id) {
        $evaluation = $this->evModel->find($id);
        if (!$evaluation) {throw new \CodeIgniter\Exceptions\PageNotFoundException("Evaluation not found");}
        $schema = $this->esModel->find($evaluation->eval_schema);
        return view('evaluations/' . ($evaluation->status == 'ongoing' ? 'single' : 'report'), ['evaluation' => $evaluation, 'schema' => $schema]);
    }

    public function postNeweval() {
        try {
            $data = $this->request->getPost();
            $this->evModel->insert($data);
            return $this->response->setJSON(['status' => "success", 'id' => $this->evModel->getInsertID()]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => "error", 'message' => 'Failed to create evaluation: ' . $e->getMessage()]);
        }
    }

    public function postUpdateeval($id) {
        try {
            $data = $this->request->getPost();
            $this->evModel->update($id, ["responses" => json_encode($data['r'])]);
            return $this->response->setJSON(['status' => "success"]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => "error", 'message' => 'Failed to update evaluation: ' . $e->getMessage()]);
        }
    }

    public function postCompleteeval($id) {
        try {
            $this->evModel->update($id, ['status' => 'completed']);
            return $this->response->setJSON(['status' => "success"]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => "error", 'message' => 'Failed to complete evaluation: ' . $e->getMessage()]);
        }
    }
}