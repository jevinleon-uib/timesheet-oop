<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Employees</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item">Employees</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">List of Employees</h5>
                    <!-- <button class="btn btn-primary mb-3">Register new employee</button> -->
                    <!-- Create Employee Modal -->
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#basicModal">
                        Register new employee
                    </button>
                    <div class="modal fade" id="basicModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Create Employee Form</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="row g-3" action="/employees/store" method="POST">
                                        <?= csrf_field(); ?>
                                        <div class="col-12">
                                            <label for="f_name" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="f_name" name="f_name">
                                        </div>
                                        <div class="col-12">
                                            <label for="m_name" class="form-label">Middle Name</label>
                                            <input type="text" class="form-control" id="m_name" name="m_name">
                                        </div>
                                        <div class="col-12">
                                            <label for="l_name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="l_name" name="l_name">
                                        </div>
                                        <div class="col-12">
                                            <label for="d_name" class="form-label">Department</label>
                                            <select class="form-select" id="department_id" name="department_id">
                                                <?php foreach ($departments as $department) : ?>
                                                    <option value="<?= $department['d_id']; ?>" selected><?= $department['d_name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="address" name="address">
                                        </div>
                                        <div class="col-12">
                                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                                        </div>
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email">
                                        </div>
                                        <div class="col-12">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-select" id="department_id" name="department_id">
                                                <option value="male" selected>Male</option>
                                                <option value="female" selected>Female</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="marital_status" class="form-label">Marital Status</label>
                                            <select class="form-select" id="department_id" name="department_id">
                                                <option value="TK" selected>TK</option>
                                                <option value="K0">K0</option>
                                                <option value="K1">K1</option>
                                                <option value="K2">K2</option>
                                                <option value="K3">K3</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- End Create Employee Modal-->

                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Batch ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Department</th>
                                <th scope="col">Address</th>
                                <th scope="col">Email</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($employees as $employee) :
                            ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $employee['batch_id']; ?></td>
                                    <td><?= $employee['f_name'] . ' ' . $employee['m_name'] . ' ' . $employee['l_name']; ?></td>
                                    <td><?= $employee['d_name']; ?></td>
                                    <td><?= $employee['address']; ?></td>
                                    <td><?= $employee['email']; ?></td>
                                    <td colspan="2">
                                        <a href="/employees/<?= $employee['batch_id']; ?>" class="btn btn-success mb-3"><i class="bi bi-eye"></i></a>
                                        <a href="/" class="btn btn-danger mb-3"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            <?php $i++;
                            endforeach; ?>
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->

                </div>
            </div>

        </div>
    </div>
</section>



<?= $this->endSection(); ?>