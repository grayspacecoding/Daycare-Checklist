<?php

namespace App\Models;

use CodeIgniter\Model;

class Checklists extends Model
{
    protected $table      = 'checklists';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['created', 'updated', 'deleted', 'room', 'date_applied', 'status', 'completed_by', 'completed_on', 'form_data'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'timestamp';
    protected $createdField  = 'created';
    protected $updatedField  = 'updated';
    protected $deletedField  = 'deleted';

    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}