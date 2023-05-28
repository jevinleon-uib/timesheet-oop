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
        <label for="start_date" class="form-label">Start Date</label>
        <input type="date" class="form-control" id="start_date" name="start_date" value="<?= old('start_date'); ?>">
    </div>
    <div class="col-12">
        <label for="end_date" class="form-label">End Date</label>
        <input type="date" class="form-control" id="end_date" name="end_date" value="<?= old('end_date'); ?>">
    </div>
    <div class="col-12">
        <label for="d_name" class="form-label">Department</label>
        <select class="form-select" id="d_id" name="d_id">
            <option value="-1">All</option>
            <?php foreach ($departments as $departments) : ?>
                <?php if (old('d_id') === $departments['d_id']) : ?>
                    <option value="<?= $departments['d_id']; ?>" selected><?= $departments['d_name']; ?></option>
                <?php else : ?>
                    <option value="<?= $departments['d_id']; ?>"><?= $departments['d_name']; ?></option>
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
                        <h5 class="card-title">Employees' Timesheets</h5>
                        <div class="row">
                            <h6 class="col-lg-6 fw-bold">Start Date : <?= $start_date; ?></h6>
                            <h6 class="col-lg-6 fw-bold">End Date : <?= $end_date; ?></h6>
                            <h6 class="col-lg-6 fw-bold">Department : <?= $department_name; ?></h6>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-end">
                            <a href="/export-excel-by-date/<?= $start_date; ?>/<?= $end_date; ?>/<?= $d_id; ?>" class="btn btn-success m-2">Export Excel</a>
                            <a href="/export-pdf-by-date/<?= $start_date; ?>/<?= $end_date; ?>/<?= $d_id; ?>" target="_blank" class="btn btn-primary m-2">Export PDF</a>
                        </div>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
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
                                        <th scope="row"><?= $i; ?></th>
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
                    </div>
                    <!-- End Table with stripped rows -->

                </div>
            </div>

        </div>
        </div>
    </section>

<?php endif ?>



<?= $this->endSection(); ?>