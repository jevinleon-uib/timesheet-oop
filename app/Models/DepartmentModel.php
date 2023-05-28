<?php

namespace App\Models;

use CodeIgniter\Model;


class DepartmentModel extends Model
{
    protected $table      = 't_departments';
    protected $primaryKey = 'd_id';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['d_id', 'd_name', 'd_batch_id', 'd_contact'];

    protected $useTimestamps = true;
    protected $createdField  = 'd_created_at';
    protected $updatedField  = 'd_updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getDetail($batch_id)
    {
        return $this->where(['d_batch_id' => $batch_id])->first();
    }

    public function getDetailFromId($id)
    {
        if ($id == '-1') {
            return ['d_name' => 'All'];
        }

        return $this->where(['d_id' => $id])->first();
    }

    public function getMaxID()
    {
        return $this->selectMax('d_id')->first();
    }
}
