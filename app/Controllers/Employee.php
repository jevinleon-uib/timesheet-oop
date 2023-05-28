<?php

namespace App\Controllers;

use App\Models\DepartmentModel;
use App\Models\EmployeeModel;

class Employee extends BaseController
{
    protected $employeeModel;
    protected $departmentModel;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
        $this->departmentModel = new DepartmentModel();

        function convert_object_to_array($data)
        {
            if (is_object($data)) {
                $data = get_object_vars($data);
            }

            if (is_array($data)) {
                return array_map(__FUNCTION__, $data);
            } else {
                return $data;
            }
        }
    }

    public function index()
    {
        $employees = convert_object_to_array($this->employeeModel->getAll());
        $departments = $this->departmentModel->findAll();

        $data = [
            'title' => 'Employees',
            'employees' => $employees,
            'departments' => $departments,
        ];

        return view('/employee/index', $data);
    }

    public function detail($batch_id)
    {
        $employee = $this->employeeModel->getDetail($batch_id);

        $departments = $this->departmentModel->findAll();

        $data = [
            'title' => 'Employee Detail',
            'employee' => $employee,
            'departments' => $departments,
            'marital_statuses' => ['TK', 'K0', 'K1', 'K2', 'K3'],
            'shifts' => ['N1', 'S1', 'S2', 'S3']
        ];

        if (empty($data['employee'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Employee's batch ID not found.");
        }

        return view('/employee/detail', $data);
    }

    public function create()
    {
        $departments = $this->departmentModel->findAll();

        $data = [
            'title' => 'Employees Registration Form',
            'departments' => $departments,
            'marital_statuses' => ['TK', 'K0', 'K1', 'K2', 'K3'],
            'shifts' =>
            [
                [
                    'value' => 'N1',
                    'name' => 'N1 (08:00 - 17:00)',
                ],
                [
                    'value' => 'S1',
                    'name' => 'S1 (07:00 - 15:00)',
                ],
                [
                    'value' => 'S2',
                    'name' => 'S2 (15:00 - 23:00)',
                ],
                [
                    'value' => 'S3',
                    'name' => 'S3 (23:00 - 07:00)',
                ],
            ]
            // 'shifts' => ['N1', 'S1', 'S2', 'S3']
        ];

        return view('/employee/create', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'f_name' => 'required',
            'department_id' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required',
            'email' => 'required|is_unique[employees.email]',
            'gender' => 'required',
            'marital_status' => 'required',
            'shift' => 'required'
        ])) {
            return redirect()->to('/employees/create')->withInput();
        }

        $batch_id = 'EMP' . sprintf('%04d', strval(((int)$this->employeeModel->getMaxID()['id']) + 1));

        $this->employeeModel->save([
            'batch_id' => $batch_id,
            'f_name' => $this->request->getVar('f_name'),
            'm_name' => $this->request->getVar('m_name'),
            'l_name' => $this->request->getVar('l_name'),
            'department_id' => $this->request->getVar('department_id'),
            'address' => $this->request->getVar('address'),
            'date_of_birth' => $this->request->getVar('date_of_birth'),
            'email' => $this->request->getVar('email'),
            'gender' => $this->request->getVar('gender'),
            'marital_status' => $this->request->getVar('marital_status'),
            'shift' => $this->request->getVar('shift'),
            'is_admin' => '0',
            'password' => password_hash('123123', PASSWORD_BCRYPT)
        ]);

        session()->setFlashdata('success', 'New employee has been added successfully.');

        return redirect()->to('/employees');
    }

    public function delete($id)
    {
        $this->employeeModel->delete($id);
        session()->setFlashdata('success', 'Employee has been deleted successfully.');
        return redirect()->to('/employees');
    }

    public function update($id)
    {
        $oldEmail = $this->employeeModel->getDetail($this->request->getVar('batch_id'));

        if ($oldEmail['email'] === $this->request->getVar('email')) {
            $email_rules = 'required';
        } else {
            $email_rules = 'required|is_unique[employees.email]';
        }

        if (!$this->validate([
            'f_name' => 'required',
            'department_id' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required',
            'email' => $email_rules,
            'gender' => 'required',
            'marital_status' => 'required',
            'shift' => 'required'
        ])) {
            // return redirect()->to('/employees' . '/' . $this->request->getVar('batch_id'))->withInput();
            session()->setFlashdata('error', 'Failed to update data. Open update form to see error.');
            return redirect()->back()->withInput();
        }

        $this->employeeModel->save([
            'id' => $id,
            'batch_id' => $this->request->getVar('batch_id'),
            'f_name' => $this->request->getVar('f_name'),
            'm_name' => $this->request->getVar('m_name'),
            'l_name' => $this->request->getVar('l_name'),
            'department_id' => $this->request->getVar('department_id'),
            'address' => $this->request->getVar('address'),
            'date_of_birth' => $this->request->getVar('date_of_birth'),
            'email' => $this->request->getVar('email'),
            'gender' => $this->request->getVar('gender'),
            'marital_status' => $this->request->getVar('marital_status'),
            'shift' => $this->request->getVar('shift')
        ]);

        session()->setFlashdata('success', 'Data has been updated successfully.');

        return redirect()->to('/employees' . '/' . $this->request->getVar('batch_id'));
    }

    public function userProfile($batch_id)
    {
        $employee = $this->employeeModel->getDetail($batch_id);

        $departments = $this->departmentModel->findAll();

        $data = [
            'title' => 'Employee Detail',
            'employee' => $employee,
            'departments' => $departments,
            'marital_statuses' => ['TK', 'K0', 'K1', 'K2', 'K3'],
            'shifts' => ['N1', 'S1', 'S2', 'S3']
        ];

        if (empty($data['employee'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Employee's batch ID not found.");
        }

        if (session()->get('batch_id') != $batch_id) {
            return redirect()->back();
        }

        return view('/employee/detail', $data);
    }

    public function userProfileUpdate($id)
    {
        $oldEmail = $this->employeeModel->getDetail($this->request->getVar('batch_id'));

        if ($oldEmail['email'] === $this->request->getVar('email')) {
            $email_rules = 'required';
        } else {
            $email_rules = 'required|is_unique[employees.email]';
        }

        if (!$this->validate([
            'f_name' => 'required',
            'department_id' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required',
            'email' => $email_rules,
            'gender' => 'required',
            'marital_status' => 'required',
            'shift' => 'required'
        ])) {
            // return redirect()->to('/employees' . '/' . $this->request->getVar('batch_id'))->withInput();
            session()->setFlashdata('error', 'Failed to update data. Open update form to see error.');
            return redirect()->back()->withInput();
        }

        $this->employeeModel->save([
            'id' => $id,
            'batch_id' => $this->request->getVar('batch_id'),
            'f_name' => $this->request->getVar('f_name'),
            'm_name' => $this->request->getVar('m_name'),
            'l_name' => $this->request->getVar('l_name'),
            'department_id' => $this->request->getVar('department_id'),
            'address' => $this->request->getVar('address'),
            'date_of_birth' => $this->request->getVar('date_of_birth'),
            'email' => $this->request->getVar('email'),
            'gender' => $this->request->getVar('gender'),
            'marital_status' => $this->request->getVar('marital_status'),
            'shift' => $this->request->getVar('shift')
        ]);

        session()->setFlashdata('success', 'Data has been updated successfully.');

        return redirect()->to('/user_profile' . '/' . $this->request->getVar('batch_id'));
    }

    public function makeAdmin($id)
    {
        $this->employeeModel->save([
            'id' => $id,
            'is_admin' => '1'
        ]);

        session()->setFlashdata('success', 'You have successfully made this an Admin.');

        return redirect()->to('/employees' . '/' . $this->request->getVar('batch_id'));
    }

    public function changePassword($id)
    {
        $oldPassword = $this->employeeModel->getDetail($this->request->getVar('batch_id'))['password'];

        if (!password_verify($this->request->getVar('password'), $oldPassword)) {
            session()->setFlashdata('error', 'Password is wrong! Try again with the correct password!');
            return redirect()->back()->withInput();
        }

        if ($this->request->getVar('newpassword') != $this->request->getVar('renewpassword')) {
            session()->setFlashdata('error', 'New password must match with re-entered new password! Try again!');
            return redirect()->back()->withInput();
        }

        $this->employeeModel->save([
            'id' => $id,
            'password' => password_hash($this->request->getVar('newpassword'), PASSWORD_BCRYPT),
        ]);

        session()->setFlashdata('success', 'Password has been changed successfully.');

        return redirect()->back()->withInput();
    }
}
