<?php

namespace App\Controllers;

use App\Models\EmployeeModel;

class Login extends BaseController
{

    protected $employeeModel;
    protected $helpers = ['form'];


    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();

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
        $data = ['title' => 'Login'];

        return view('/auth/login', $data);
    }

    public function login()
    {

        if (!$this->validate([
            'batch_id' => 'required',
            'password' => 'required',
        ])) {
            session()->setFlashdata('loginError', 'Please enter Batch ID and Password!');
            return redirect()->to('/login')->withInput();
        }

        $authData = $this->employeeModel->where('batch_id', $this->request->getVar('batch_id'))->first();

        if (!$authData) {
            session()->setFlashdata('loginError', 'Login failed!');
            return redirect()->to('/login')->withInput();
        }

        if (password_verify($this->request->getVar('password'), $authData['password'])) {

            $loginData = [
                'id' => $authData['id'],
                'batch_id' => $authData['batch_id'],
                'username' => $authData['f_name'] . ' ' . $authData['m_name'] . ' ' . $authData['l_name'],
                'department_id' => $authData['department_id'],
                'is_admin' => $authData['is_admin'],
                'email' => $authData['email'],
                'shift' => $authData['shift']
            ];

            session()->set($loginData);

            return redirect()->to('/');
        } else {
            session()->setFlashdata('loginError', 'Login failed!');
            return redirect()->to('/login')->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
