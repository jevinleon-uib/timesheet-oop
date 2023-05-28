<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;
use DateTimeZone;
use PDO;
use CodeIgniter\I18n\Time;


class TimesheetModel extends Model
{
    protected $table      = 't_timesheet';
    protected $primaryKey = 't_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['e_id', 't_date', 'd_id', 't_check_in', 't_check_out', 't_late', 't_early', 't_overtime'];

    protected $useTimestamps = true;
    protected $createdField  = 't_created_at';
    protected $updatedField  = 't_updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getAll()
    {
        $this->join('t_employees', 't_employees.id = t_timesheet.e_id');
        $this->join('t_departments', 't_departments.d_id = t_timesheet.d_id');
        $query = $this->get();
        return $query->getResult();
    }

    public function getDetail($date)
    {
        return $this->join('t_employees', 't_employees.id = t_timesheet.e_id')->where(['t_date' => $date])->where('e_id', session()->get('id'))->first();
    }

    public function showByDate($start_date, $end_date, $dept_id)
    {
        if ($start_date == '' or $end_date == '') {
            return false;
        }

        if ($dept_id == '-1') {
            $this->join('t_employees', 't_employees.id = t_timesheet.e_id')->join('t_departments', 't_departments.d_id = t_timesheet.d_id')->where(['t_date >=' => $start_date])->where('t_date <=', $end_date);
        } else {
            $this->join('t_employees', 't_employees.id = t_timesheet.e_id')->join('t_departments', 't_departments.d_id = t_timesheet.d_id')->where(['t_date >=' => $start_date])->where('t_date <=', $end_date)->where(['t_timesheet.d_id' => $dept_id]);
        }
        $query = $this->get();
        return $query->getResult();
    }

    public function showByEmployee($emp_id)
    {
        if ($emp_id == '') {
            return false;
        }

        $this->join('t_employees', 't_employees.id = t_timesheet.e_id')->join('t_departments', 't_departments.d_id = t_timesheet.d_id')->where(['t_timesheet.e_id' => $emp_id]);

        $query = $this->get();
        return $query->getResult();
    }

    public function latePerMonth()
    {
        $currTime = Time::now('Asia/Jakarta');
        $currMonth = $currTime->getMonth();

        $this->where('MONTH(t_date)', $currMonth)->where('t_late !=', NULL);
        $query = $this->get();
        return $query->getResult();
    }
}
