<?php

namespace App\Controllers;

use DateTime;
use DateTimeZone;
use Dompdf\Dompdf;
use CodeIgniter\I18n\Time;
use App\Models\EmployeeModel;
use App\Models\TimesheetModel;
use App\Models\DepartmentModel;
use App\Controllers\BaseController;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use function App\Controllers\convert_object_to_array as ControllersConvert_object_to_array;

class Timesheet extends BaseController
{
    protected $timesheetModel;
    protected $employeeModel;
    protected $departmentModel;
    protected $currTime;
    protected $shifts = [
        'N1' => ['start' => 8, 'end' => 17],
        'S1' => ['start' => 7, 'end' => 15],
        'S2' => ['start' => 15, 'end' => 23],
        'S3' => ['start' => 23, 'end' => 7],
    ];
    protected $late;
    protected $OT;
    protected $early;

    public function __construct()
    {
        $this->timesheetModel = new TimesheetModel();
        $this->employeeModel = new EmployeeModel();
        $this->departmentModel = new DepartmentModel();
        $this->currTime = new DateTime('now', new DateTimeZone('Asia/Jakarta'));

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

        function addZero($val)
        {
            return ($val < 10 ? "0" . $val : $val);
        }
    }

    public function index()
    {
        $att = $this->timesheetModel->getDetail($this->currTime->format('Y-m-d'));

        if (!empty($att['t_check_in'])) {
            $ci = Time::createFromTimestamp($att['t_check_in']);
            $h = addZero($ci->getHour());
            $m = addZero($ci->getMinute());
            $formattedCi = $h . ":" . $m;
        } else {
            $formattedCi = null;
        }

        if (!empty($att['t_check_out'])) {
            $co = Time::createFromTimestamp($att['t_check_out']);
            $h = addZero($co->getHour());
            $m = addZero($co->getMinute());
            $formattedCo = $h . ":" . $m;
        } else {
            $formattedCo = null;
        }

        $data = [
            'title' => 'Attendance',
            'checked_in' => !empty($att['t_check_in']),
            'checked_out' => !empty($att['t_check_out']),
            'ci' => $formattedCi,
            'co' => $formattedCo,
            't_id' => !empty($att['t_id']) ? $att['t_id'] : "-1",
            'late' => $att['t_late'] ?? null,
            'OT' => $att['t_overtime'] ?? null,
            'early' => $att['t_early'] ?? null
        ];

        return view('/attendance/index', $data);
    }

    public function clockIn()
    {
        // $currTime = new DateTime('now', new DateTimeZone('Asia/Jakarta'));

        $uci = strtotime($this->currTime->format('Y-m-d H:i:s'));

        $ci = Time::createFromTimestamp($uci);

        if ($ci->getHour() >= $this->shifts[session()->get('shift')]['start']) {
            $shiftStart = Time::today()->setHour($this->shifts[session()->get('shift')]['start']);
            if ($shiftStart->difference($ci)->getMinutes() % 60 > 0) {
                $late_h = addZero($shiftStart->difference($ci)->getHours());
                $late_m = addZero($shiftStart->difference($ci)->getMinutes() % 60);
                $this->late = ($late_h == '00') ? $late_m . " minutes" : $late_h . " hours and " . $late_m . " minutes";
            }
        }

        $this->timesheetModel->save([
            'e_id' => session()->get('id'),
            'd_id' => session()->get('department_id'),
            't_date' => $this->currTime->format('Y-m-d'),
            't_check_in' => $uci,
            't_late' => $this->late
        ]);

        session()->setFlashdata('success', 'Clocked in successfully.');
        return redirect()->to('/attendance')->withInput();
    }

    public function clockOut()
    {
        $uco = strtotime($this->currTime->format('Y-m-d H:i:s'));

        $co = Time::createFromTimestamp($uco);

        if (session()->get('shift') == 'S3') {
            $shiftEnd = Time::tomorrow()->setHour($this->shifts[session()->get('shift')]['end']);
        } else {
            $shiftEnd = Time::today()->setHour($this->shifts[session()->get('shift')]['end']);
        }
        $OT_h = $shiftEnd->difference($co)->getHours();
        $OT_m = $shiftEnd->difference($co)->getMinutes() % 60;

        if ($OT_h == 1) {
            $OT_h = addZero($OT_h);
            $OT_m = addZero($OT_m);
            $this->OT = $OT_h . " hour and " . $OT_m . " minutes";
        } else if ($OT_h > 1) {
            $OT_h = addZero($OT_h);
            $OT_m = addZero($OT_m);
            $this->OT = $OT_h . " hours and " . $OT_m . " minutes";
        } else if ($OT_h < 0 or $OT_m < 0) {
            $OT_h *= -1;
            $OT_m *= -1;
            $OT_h = addZero($OT_h);
            $OT_m = addZero($OT_m);
            $this->early = ($OT_h == '00') ? $OT_m . " minutes" : $OT_h . " hours and " . $OT_m . " minutes";
        }

        $this->timesheetModel->save([
            't_id' => $this->request->getVar('t_id'),
            't_check_out' => $uco,
            't_early' => $this->early,
            't_overtime' => $this->OT
        ]);

        session()->setFlashdata('success', 'Clocked out successfully. Thank you for your work!');
        return redirect()->to('/attendance')->withInput();
    }

    public function showByEmployee()
    {
        $emp_id = $this->request->getVar('e_id');
        $timesheet_details = ControllersConvert_object_to_array($this->timesheetModel->showByEmployee($emp_id));
        $employees = $this->employeeModel->findAll();

        if ($timesheet_details) {
            $employee_detail = $this->employeeModel->getDetailFromId($emp_id);
            $department_name = $this->departmentModel->getDetailFromId($employee_detail['d_id'])['d_name'];
        }

        $data = [
            'title' => 'Timesheets - Employee',
            'timesheets' => $timesheet_details,
            'employees' => $employees,
            'employee_detail' => $employee_detail ?? null,
            'department_name' => $department_name ?? null,
            'late' => $this->late ?? null,
            'OT' => $this->OT ?? null,
            'early' => $this->early ?? null,
        ];

        return view('/attendance/timesheets_employee', $data);
    }

    public function showByUser()
    {
        $emp_id = session()->get('id');
        $timesheet_details = ControllersConvert_object_to_array($this->timesheetModel->showByEmployee($emp_id));
        $employees = $this->employeeModel->findAll();

        if ($timesheet_details) {
            $employee_detail = $this->employeeModel->getDetailFromId($emp_id);
            $department_name = $this->departmentModel->getDetailFromId($employee_detail['d_id'])['d_name'];
        }

        $data = [
            'title' => 'My Timesheets',
            'timesheets' => $timesheet_details,
            'employees' => $employees,
            'employee_detail' => $employee_detail ?? null,
            'department_name' => $department_name ?? null,
            'late' => $this->late ?? null,
            'OT' => $this->OT ?? null,
            'early' => $this->early ?? null,
        ];

        return view('/attendance/timesheets_user', $data);
    }

    public function showByDate()
    {
        $start_date = $this->request->getVar('start_date');
        $end_date = $this->request->getVar('end_date');
        $dept_id = $this->request->getVar('d_id');
        $timesheet_details = convert_object_to_array($this->timesheetModel->showByDate($start_date, $end_date, $dept_id));
        $departments = $this->departmentModel->findAll();

        if ($timesheet_details) {
            $department_name = $this->departmentModel->getDetailFromId($dept_id)['d_name'];
        }

        $data = [
            'title' => 'Timesheets - Date',
            'timesheets' => $timesheet_details,
            'departments' => $departments,
            'd_id' => $dept_id,
            'late' => $this->late ?? null,
            'OT' => $this->OT ?? null,
            'early' => $this->early ?? null,
            'start_date' => $start_date ?? null,
            'end_date' => $end_date ?? null,
            'department_name' => $department_name ?? null
        ];

        return view('/attendance/timesheets_date', $data);
    }

    public function exportPDFByEmployee($id)
    {
        $timesheet_details = ControllersConvert_object_to_array($this->timesheetModel->showByEmployee($id));
        $employees = $this->employeeModel->findAll();

        if ($timesheet_details) {
            $employee_detail = $this->employeeModel->getDetailFromId($id);
            $department_name = $this->departmentModel->getDetailFromId($employee_detail['d_id'])['d_name'];
        }

        $data = [
            'title' => 'Timesheets - Employee',
            'timesheets' => $timesheet_details,
            'employees' => $employees,
            'employee_detail' => $employee_detail ?? null,
            'department_name' => $department_name ?? null,
            'late' => $this->late ?? null,
            'OT' => $this->OT ?? null,
            'early' => $this->early ?? null,
        ];

        $view = view('attendance/timesheets_employee_export_pdf', $data);


        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("Employee's Timesheet - " . $employee_detail['f_name'] . " " . $employee_detail['m_name'] . " " . $employee_detail['l_name'], array('Attachment' => false));
    }

    public function exportPDFByDate($start_date, $end_date, $dept_id)
    {
        $timesheet_details = convert_object_to_array($this->timesheetModel->showByDate($start_date, $end_date, $dept_id));
        $departments = $this->departmentModel->findAll();

        if ($timesheet_details) {
            $department_name = $this->departmentModel->getDetailFromId($dept_id)['d_name'];
        }

        $data = [
            'title' => 'Timesheets - Date',
            'timesheets' => $timesheet_details,
            'departments' => $departments,
            'late' => $this->late ?? null,
            'OT' => $this->OT ?? null,
            'early' => $this->early ?? null,
            'start_date' => $start_date ?? null,
            'end_date' => $end_date ?? null,
            'department_name' => $department_name ?? null
        ];

        $view = view('attendance/timesheets_date_export_pdf', $data);


        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("Employee's Timesheet - " . $start_date . " - " . $end_date . " - " . $department_name, array('Attachment' => false));
    }

    public function exportPDFByUser()
    {
        $emp_id = session()->get('id');
        $timesheet_details = ControllersConvert_object_to_array($this->timesheetModel->showByEmployee($emp_id));
        $employees = $this->employeeModel->findAll();

        if ($timesheet_details) {
            $employee_detail = $this->employeeModel->getDetailFromId($emp_id);
            $department_name = $this->departmentModel->getDetailFromId($employee_detail['d_id'])['d_name'];
        }

        $data = [
            'title' => 'My Timesheets',
            'timesheets' => $timesheet_details,
            'employees' => $employees,
            'employee_detail' => $employee_detail ?? null,
            'department_name' => $department_name ?? null,
            'late' => $this->late ?? null,
            'OT' => $this->OT ?? null,
            'early' => $this->early ?? null,
        ];

        $view = view('attendance/timesheets_user_export_pdf', $data);


        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("Employee's Timesheet - " . $employee_detail['f_name'] . " " . $employee_detail['m_name'] . " " . $employee_detail['l_name'], array('Attachment' => false));
    }

    public function exportExcelByEmployee($id)
    {
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        foreach (range('A', 'G') as $colId) {
            $spreadsheet->getActiveSheet()->getColumnDimension($colId)->setAutosize(true);
        }

        $activeWorksheet->setCellValue('A1', 'No');
        $activeWorksheet->setCellValue('B1', 'Date');
        $activeWorksheet->setCellValue('C1', 'Checked In');
        $activeWorksheet->setCellValue('D1', 'Checked Out');
        $activeWorksheet->setCellValue('E1', 'Late');
        $activeWorksheet->setCellValue('F1', 'Checked Out Early');
        $activeWorksheet->setCellValue('G1', 'Overtime');

        $row = 2;

        $timesheet_details = ControllersConvert_object_to_array($this->timesheetModel->showByEmployee($id));
        $employees = $this->employeeModel->findAll();

        if ($timesheet_details) {
            $employee_detail = $this->employeeModel->getDetailFromId($id);
            $department_name = $this->departmentModel->getDetailFromId($employee_detail['d_id'])['d_name'];
        }

        foreach ($timesheet_details as $key => $timesheet) {
            $activeWorksheet
                ->setCellValue('A' . $row, $key + 1)
                ->setCellValue('B' . $row, $timesheet['t_date'])
                ->setCellValue('C' . $row, date('H:i:s', $timesheet['t_check_in']))
                ->setCellValue('D' . $row, date('H:i:s', $timesheet['t_check_out']))
                ->setCellValue('E' . $row, $timesheet['t_late'])
                ->setCellValue('F' . $row, $timesheet['t_early'])
                ->setCellValue('G' . $row, $timesheet['t_overtime']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "Employee's Timesheet - " . $employee_detail['f_name'] . " " . $employee_detail['m_name'] . " " . $employee_detail['l_name'] . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function exportExcelByDate($start_date, $end_date, $dept_id)
    {
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        foreach (range('A', 'J') as $colId) {
            $spreadsheet->getActiveSheet()->getColumnDimension($colId)->setAutosize(true);
        }

        $activeWorksheet->setCellValue('A1', 'No');
        $activeWorksheet->setCellValue('B1', 'Name');
        $activeWorksheet->setCellValue('C1', 'Department');
        $activeWorksheet->setCellValue('D1', 'Shift');
        $activeWorksheet->setCellValue('E1', 'Date');
        $activeWorksheet->setCellValue('F1', 'Checked In');
        $activeWorksheet->setCellValue('G1', 'Checked Out');
        $activeWorksheet->setCellValue('H1', 'Late');
        $activeWorksheet->setCellValue('I1', 'Checked Out Early');
        $activeWorksheet->setCellValue('J1', 'Overtime');

        $row = 2;

        $timesheet_details = convert_object_to_array($this->timesheetModel->showByDate($start_date, $end_date, $dept_id));
        $departments = $this->departmentModel->findAll();

        if ($timesheet_details) {
            $department_name = $this->departmentModel->getDetailFromId($dept_id)['d_name'];
        }

        foreach ($timesheet_details as $key => $timesheet) {
            $activeWorksheet
                ->setCellValue('A' . $row, $key + 1)
                ->setCellValue('B' . $row, $timesheet['f_name'] . ' ' . $timesheet['m_name'] . ' ' . $timesheet['l_name'])
                ->setCellValue('C' . $row, $timesheet['d_name'])
                ->setCellValue('D' . $row, $timesheet['shift'])
                ->setCellValue('E' . $row, $timesheet['t_date'])
                ->setCellValue('F' . $row, date('H:i:s', $timesheet['t_check_in']))
                ->setCellValue('G' . $row, date('H:i:s', $timesheet['t_check_out']))
                ->setCellValue('H' . $row, $timesheet['t_late'])
                ->setCellValue('I' . $row, $timesheet['t_early'])
                ->setCellValue('J' . $row, $timesheet['t_overtime']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "Employee's Timesheet - " . $start_date . " - " . $end_date . " - " . $department_name . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function exportExcelByUser()
    {
        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        foreach (range('A', 'G') as $colId) {
            $spreadsheet->getActiveSheet()->getColumnDimension($colId)->setAutosize(true);
        }

        $activeWorksheet->setCellValue('A1', 'No');
        $activeWorksheet->setCellValue('B1', 'Date');
        $activeWorksheet->setCellValue('C1', 'Checked In');
        $activeWorksheet->setCellValue('D1', 'Checked Out');
        $activeWorksheet->setCellValue('E1', 'Late');
        $activeWorksheet->setCellValue('F1', 'Checked Out Early');
        $activeWorksheet->setCellValue('G1', 'Overtime');

        $row = 2;

        $emp_id = session()->get('id');
        $timesheet_details = ControllersConvert_object_to_array($this->timesheetModel->showByEmployee($emp_id));
        $employees = $this->employeeModel->findAll();


        foreach ($timesheet_details as $key => $timesheet) {
            $activeWorksheet
                ->setCellValue('A' . $row, $key + 1)
                ->setCellValue('B' . $row, $timesheet['t_date'])
                ->setCellValue('C' . $row, date('H:i:s', $timesheet['t_check_in']))
                ->setCellValue('D' . $row, date('H:i:s', $timesheet['t_check_out']))
                ->setCellValue('E' . $row, $timesheet['t_late'])
                ->setCellValue('F' . $row, $timesheet['t_early'])
                ->setCellValue('G' . $row, $timesheet['t_overtime']);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = "Employee's Timesheet - " . session()->get('username') . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
}
