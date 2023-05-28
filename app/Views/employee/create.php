<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Employees</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/employees">Employees</a></li>
            <li class="breadcrumb-item">Employees Registration</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="col-lg-8 my-4">
                        <form class="row g-3" action="/employees/store" method="POST">
                            <?= csrf_field(); ?>
                            <div class="col-12">
                                <label for="f_name" class="form-label">First Name</label>
                                <input type="text" class="form-control <?= validation_show_error('f_name') ? 'is-invalid' : ''; ?>" id="f_name" name="f_name" value="<?= old('f_name'); ?>" autofocus>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('f_name'); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="m_name" class="form-label">Middle Name</label>
                                <input type="text" class="form-control <?= validation_show_error('m_name') ? 'is-invalid' : ''; ?>" id="m_name" name="m_name" value="<?= old('m_name'); ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('m_name'); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="l_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control <?= validation_show_error('l_name') ? 'is-invalid' : ''; ?>" id="l_name" name="l_name" value="<?= old('l_name'); ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('l_name'); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="d_name" class="form-label">Department</label>
                                <select class="form-select <?= validation_show_error('department_id') ? 'is-invalid' : ''; ?>" id="department_id" name="department_id">
                                    <?php foreach ($departments as $department) : ?>
                                        <?php if (old('department_id') === $department['d_id']) : ?>
                                            <option value="<?= $department['d_id']; ?>" selected><?= $department['d_name']; ?></option>
                                        <?php else : ?>
                                            <option value="<?= $department['d_id']; ?>"><?= $department['d_name']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('department_id'); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control <?= validation_show_error('address') ? 'is-invalid' : ''; ?>" id="address" name="address" value="<?= old('address'); ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('address'); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control <?= validation_show_error('date_of_birth') ? 'is-invalid' : ''; ?>" id="date_of_birth" name="date_of_birth" value="<?= old('date_of_birth'); ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('date_of_birth'); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control <?= validation_show_error('email') ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= old('email'); ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('email'); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select <?= validation_show_error('gender') ? 'is-invalid' : ''; ?>" id="gender" name="gender">
                                    <?php if (old('gender') === 'female') : ?>
                                        <option value="female" selected>Female</option>
                                        <option value="male">Male</option>
                                    <?php else : ?>
                                        <option value="female">Female</option>
                                        <option value="male" selected>Male</option>
                                    <?php endif; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('gender'); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="marital_status" class="form-label">Shift</label>
                                <select class="form-select <?= validation_show_error('marital_status') ? 'is-invalid' : ''; ?>" id="shift" name="shift">
                                    <?php foreach ($shifts as $shift) : ?>
                                        <?php if (old('shift') === $shift['value']) : ?>
                                            <option value="<?= $shift['value']; ?>" selected><?= $shift['name']; ?></option>
                                        <?php else : ?>
                                            <option value="<?= $shift['value']; ?>"><?= $shift['name']; ?></option>

                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('shift'); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="shift" class="form-label">Marital Status</label>
                                <select class="form-select <?= validation_show_error('shift') ? 'is-invalid' : ''; ?>" id="marital_status" name="marital_status">
                                    <?php foreach ($marital_statuses as $marital_status) : ?>
                                        <?php if (old('marital_status') === $marital_status) : ?>
                                            <option value="<?= $marital_status; ?>" selected><?= $marital_status; ?></option>
                                        <?php else : ?>
                                            <option value="<?= $marital_status; ?>"><?= $marital_status; ?></option>

                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('marital_status'); ?>
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary">Register New Employee</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

    </div>
    </div>
</section>



<?= $this->endSection(); ?>