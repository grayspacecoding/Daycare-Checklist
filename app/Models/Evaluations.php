<?php

namespace App\Models;

use CodeIgniter\Model;
use \Ramsey\Uuid\Uuid;

class Evaluations extends Model
{
    protected $table      = 'evaluations';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['created', 'updated', 'deleted', 'teacher', 'reviewed_on', 'round', 'eval_schema', 'responses', 'status'];

    protected bool $allowEmptyInserts = true;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted';

    protected $allowCallbacks = true;
    protected $beforeInsert   = ['beforeInsert'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function beforeInsert(array $data): array
    {
        if (!isset($data['data']['id'])) {
            $data['data']['id'] = Uuid::uuid4()->toString();
        }
        return $data;
    }
}