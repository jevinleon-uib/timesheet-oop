<?php

namespace App\Models;

use CodeIgniter\Model;


class EmployeeModel extends Model
{
    // protected $table      = 'employees';
    protected $table      = 't_employees';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['batch_id', 'f_name', 'm_name', 'l_name', 'department_id', 'address', 'date_of_birth', 'email', 'gender', 'marital_status', 'password', 'is_admin', 'shift'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getAll()
    {
        $this->join('t_departments', 't_departments.d_id = t_employees.department_id');
        $query = $this->orderBy('id', 'DESC')->get();
        return $query->getResult();
    }

    public function getDetail($batch_id)
    {
        return $this->join('t_departments', 't_departments.d_id = t_employees.department_id')->where(['batch_id' => $batch_id])->first();
    }

    public function getDetailFromId($id)
    {
        return $this->join('t_departments', 't_departments.d_id = t_employees.department_id')->where(['id' => $id])->first();
    }

    public function getMaxID()
    {
        return $this->selectMax('id')->first();
    }
}
