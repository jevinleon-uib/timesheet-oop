<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee's Timesheet - PDF</title>

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .border-table {
            font-family: Arial, Helvetica, sans-serif;
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            font-size: 14px;
        }

        .border-table th {
            border: 1 solid black;
            font-weight: bold;
            background-color: #e1e1e1;
        }

        .border-table td {
            border: 1 solid black;
        }

        p {
            text-align: center;
        }

        .title {
            font-weight: bold;
            font-size: 2rem;
            margin: 0;
        }

        .sub-title {
            font-weight: 300;
            font-size: 1.1rem;
            color: darkgray;
            margin-top: 0;
        }

        .copyright {
            margin-top: 2rem;
            text-align: center;
        }
    </style>
</head>

<body>
    <p class="title">Timesheet OOP</p>
    <p class="sub-title">- Employee's Timesheet -</p>

    <div>
        <p class="col-lg-6 fw-bold">Start Date : <?= $start_date; ?></p>
        <p class="col-lg-6 fw-bold">End Date : <?= $end_date; ?></p>
        <p class="col-lg-6 fw-bold">Department : <?= $department_name; ?></p>
    </div>

    <table class="border-table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Department</th>
                <th scope="col">Shift</th>
                <th scope="col">Date</th>
                <th scope="col">Checked In</th>
                <th scope="col">Checked Out</th>
                <th scope="col">Late</th>
                <th scope="col">Checked Out Early</th>
                <th scope="col">Overtime</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($timesheets as $timesheet) :
            ?>
                <tr>
                    <td scope="row"><?= $i; ?></td>
                    <td><?= $timesheet['f_name'] . ' ' . $timesheet['m_name'] . ' ' . $timesheet['l_name']; ?></td>
                    <td><?= $timesheet['d_name']; ?></td>
                    <td><?= $timesheet['shift']; ?></td>
                    <td><?= $timesheet['t_date']; ?></td>
                    <td><?= date('H:i:s', $timesheet['t_check_in']); ?></td>
                    <td><?= date('H:i:s', $timesheet['t_check_out']); ?></td>
                    <td><?= $timesheet['t_late'] ?? '-' ?></td>
                    <td><?= $timesheet['t_early'] ?? '-' ?></td>
                    <td><?= $timesheet['t_overtime'] ?? '-' ?></td>
                </tr>
            <?php $i++;
            endforeach; ?>
        </tbody>
    </table>
    <div class="copyright">
        &copy; Copyright <strong><span>Timesheet OOP</span></strong>. All Rights Reserved
    </div>
</body>

</html>