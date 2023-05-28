<?php

namespace App\Controllers;

use App\Models\DepartmentModel;
use App\Models\EmployeeModel;
use App\Models\TimesheetModel;
use CodeIgniter\I18n\Time;

class Home extends BaseController
{

    protected $employeeModel;
    protected $departmentModel;
    protected $timesheetModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
        $this->departmentModel = new DepartmentModel();
        $this->timesheetModel = new TimesheetModel();
    }

    public function index()
    {
        $months = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $currTime = Time::now('Asia/Jakarta');
        $currMonth = $currTime->getMonth();

        $data = [
            'title' => 'Dashboard',
            'employees_count' => $this->employeeModel->countAllResults(),
            'departments_count' => $this->departmentModel->countAllResults(),
            'curr_month_lates' => count($this->timesheetModel->latePerMonth()),
            'curr_month_name' => $months[$currMonth]
        ];

        return view('/dashboard/index', $data);
    }
}
