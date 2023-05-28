<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Timesheets</h1>
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success my-3" role="alert">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item">Timesheets</li>
        </ol>
    </nav>
</div>

<form action="" method="GET" class="my-3">
    <div class="col-12">
        <label for="e_id" class="form-label">Employee</label>
        <select class="form-select" id="e_id" name="e_id">
            <?php foreach ($employees as $employee) : ?>
                <?php if (old('id') === $employee['id']) : ?>
                    <option value="<?= $employee['id']; ?>" selected><?= $employee['f_name'] . ' ' . $employee['m_name'] . ' ' . $employee['l_name']; ?></option>
                <?php else : ?>
                    <option value="<?= $employee['id']; ?>"><?= $employee['f_name'] . ' ' . $employee['m_name'] . ' ' . $employee['l_name']; ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="text-end mt-3">
        <button type="submit" class="btn btn-primary">Show</button>
    </div>
</form>

<?php if (!$timesheets) : ?>
    <p class="text-center">No Data Found. Please try another query.</p>
<?php else : ?>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="col-lg-6 card-title">Employees' Timesheets</h5>
                        <div class="row">
                            <h6 class="col-lg-6 fw-bold">Employee : <?= $employee_detail['f_name'] . ' ' . $employee_detail['m_name'] . ' ' . $employee_detail['l_name']; ?></h6>
                            <h6 class="col-lg-6 fw-bold">Batch ID : <?= $employee_detail['batch_id']; ?></h6>
                            <h6 class="col-lg-6 fw-bold">Department : <?= $department_name; ?></h6>
                            <h6 class="col-lg-6 fw-bold">Shift : <?= $employee_detail['shift']; ?></h6>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-end">
                            <a href="/export-excel-by-employee/<?= $employee_detail['id']; ?>" class="btn btn-success m-2">Export Excel</a>
                            <a href="/export-pdf-by-employee/<?= $employee_detail['id']; ?>" target="_blank" class="btn btn-primary m-2">Export PDF</a>
                        </div>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
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
                                        <th scope="row"><?= $i; ?></th>
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
                    </div>
                    <!-- End Table with stripped rows -->

                </div>
            </div>

        </div>
        </div>
    </section>

<?php endif ?>



<?= $this->endSection(); ?>