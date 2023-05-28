<?php

namespace App\Controllers;

use App\Models\DepartmentModel;

class Department extends BaseController
{
    protected $departmentModel;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->departmentModel = new DepartmentModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Departments',
            'departments' => $this->departmentModel->findAll()
        ];

        return view('/department/index', $data);
    }

    public function detail($batch_id)
    {
        $data = [
            'title' => 'Department Detail',
            'department' => $this->departmentModel->getDetail($batch_id)
        ];

        if (empty($data['department'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Department's batch ID not found.");
        }

        return view('/department/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Departments Registration Form',
        ];

        return view('/department/create', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'd_name' => 'required',
            'd_contact' => 'required',
        ])) {
            return redirect()->to('/departments/create')->withInput();
        }


        $batch_id = 'DPT' . sprintf('%04d', strval(((int)$this->departmentModel->getMaxID()['d_id']) + 1));

        $this->departmentModel->save([
            'd_id' => (int)$this->departmentModel->getMaxID()['d_id'] + 1,
            'd_batch_id' => $batch_id,
            'd_name' => $this->request->getVar('d_name'),
            'd_contact' => $this->request->getVar('d_contact'),
        ]);

        session()->setFlashdata('success', 'New department has been added successfully.');

        return redirect()->to('/departments');
    }

    public function delete($id)
    {
        $this->departmentModel->delete($id);
        session()->setFlashdata('success', 'Department has been deleted successfully.');
        return redirect()->to('/departments');
    }

    public function update($id)
    {
        if (!$this->validate([
            'd_name' => 'required',
            'd_contact' => 'required',
        ])) {
            session()->setFlashdata('error', 'Failed to update data. Open update form to see error.');
            return redirect()->to('/departments' . '/' . $this->request->getVar('d_batch_id'))->withInput();
        }

        $this->departmentModel->save([
            'd_id' => $id,
            'd_batch_id' => $this->request->getVar('d_batch_id'),
            'd_name' => $this->request->getVar('d_name'),
            'd_contact' => $this->request->getVar('d_contact'),
        ]);

        session()->setFlashdata('success', 'Data has been updated successfully.');

        return redirect()->to('/departments' . '/' . $this->request->getVar('d_batch_id'));
    }
}
