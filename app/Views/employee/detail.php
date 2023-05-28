<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="pagetitle">
    <div class="d-flex gap-2">
        <a href="/employees"><i class="bi bi-arrow-left"></i></a>
        <h1>Employee Detail</h1>
        <p hidden id="referer"><?= isset($_SERVER['HTTP_REFERER']) and (mb_strpos($_SERVER['HTTP_REFERER'], 'http://localhost:8080/employees/' . $employee['batch_id']) !== false) ?></p>
        <p hidden id="error_val"><?= validation_errors() ? '1' : ''; ?></p>

    </div>
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success my-3" role="alert">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger my-3" role="alert">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/employees">Employees</a></li>
            <li class="breadcrumb-item active">Employee Detail</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section profile">
    <div class="row">
        <div class="col-xl-8">

            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link to-edit" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Employee</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title"><?= $employee['f_name'] . ' ' . $employee['m_name'] . ' ' . $employee['l_name'] . "'s Details"; ?></h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                <div class="col-lg-9 col-md-8"><?= $employee['f_name'] . ' ' . $employee['m_name'] . ' ' . $employee['l_name']; ?></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Department</div>
                                <div class="col-lg-9 col-md-8"><?= $employee['d_name']; ?></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Address</div>
                                <div class="col-lg-9 col-md-8"><?= $employee['address']; ?></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Date of Birth</div>
                                <div class="col-lg-9 col-md-8"><?= $employee['date_of_birth']; ?></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8"><?= $employee['email']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Gender</div>
                                <div class="col-lg-9 col-md-8"><?= ucfirst($employee['gender']); ?></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Marital Status</div>
                                <div class="col-lg-9 col-md-8"><?= $employee['marital_status']; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Shift</div>
                                <div class="col-lg-9 col-md-8"><?= $employee['shift']; ?></div>
                            </div>
                            <?php if (session()->get('is_admin') == '1') : ?>
                                <form action="/employees/makeadmin/<?= $employee['id']; ?>" method="POST">
                                    <input type="hidden" name="batch_id" value="<?= $employee['batch_id']; ?>">
                                    <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to make this employee an admin?')">Make Admin</button>
                                </form>
                            <?php endif ?>

                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                            <!-- Profile Edit Form -->
                            <?php if (session()->get('is_admin') == '1') : ?>
                                <form class="row g-3" action="/employees/update/<?= $employee['id']; ?>" method="POST">
                                <?php else : ?>
                                    <form class="row g-3" action="/user_profile/update/<?= $employee['id']; ?>" method="POST">
                                    <?php endif ?>
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="batch_id" value="<?= $employee['batch_id']; ?>">

                                    <div class="col-12">
                                        <label for="f_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control <?= validation_show_error('f_name') ? 'is-invalid' : ''; ?>" id="f_name" name="f_name" value="<?= old('f_name', $employee['f_name']); ?>" autofocus>
                                        <div class="invalid-feedback">
                                            <?= validation_show_error('f_name'); ?>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="m_name" class="form-label">Middle Name</label>
                                        <input type="text" class="form-control <?= validation_show_error('m_name') ? 'is-invalid' : ''; ?>" id="m_name" name="m_name" value="<?= old('m_name', $employee['m_name']); ?>">
                                        <div class="invalid-feedback">
                                            <?= validation_show_error('m_name'); ?>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="l_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control <?= validation_show_error('l_name') ? 'is-invalid' : ''; ?>" id="l_name" name="l_name" value="<?= old('l_name', $employee['l_name']); ?>">
                                        <div class="invalid-feedback">
                                            <?= validation_show_error('l_name'); ?>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="d_name" class="form-label">Department</label>
                                        <?php if (session()->get('is_admin') == '1') : ?>
                                            <select class="form-select <?= validation_show_error('department_id') ? 'is-invalid' : ''; ?>" id="department_id" name="department_id">
                                            <?php else : ?>
                                                <input type="hidden" name="department_id" id="department_id" value="<?= $employee['department_id']; ?>">
                                                <select class="form-select <?= validation_show_error('department_id') ? 'is-invalid' : ''; ?>" id="department_id" name="department_id" disabled>
                                                <?php endif ?>
                                                <?php foreach ($departments as $department) : ?>
                                                    <?php if (old('department_id', $employee['department_id']) === $department['d_id']) : ?>
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
                                        <input type="text" class="form-control <?= validation_show_error('address') ? 'is-invalid' : ''; ?>" id="address" name="address" value="<?= old('address', $employee['address']); ?>">
                                        <div class="invalid-feedback">
                                            <?= validation_show_error('address'); ?>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control <?= validation_show_error('date_of_birth') ? 'is-invalid' : ''; ?>" id="date_of_birth" name="date_of_birth" value="<?= old('date_of_birth', $employee['date_of_birth']); ?>">
                                        <div class="invalid-feedback">
                                            <?= validation_show_error('date_of_birth'); ?>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control <?= validation_show_error('email') ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= old('email', $employee['email']); ?>">
                                        <div class="invalid-feedback">
                                            <?= validation_show_error('email'); ?>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-select <?= validation_show_error('gender') ? 'is-invalid' : ''; ?>" id="gender" name="gender">
                                            <?php if (old('gender', $employee['gender']) === 'female') : ?>
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
                                        <label for="marital_status" class="form-label">Marital Status</label>
                                        <select class="form-select <?= validation_show_error('marital_status') ? 'is-invalid' : ''; ?>" id="marital_status" name="marital_status">
                                            <?php foreach ($marital_statuses as $marital_status) : ?>
                                                <?php if (old('marital_status', $employee['marital_status']) === $marital_status) : ?>
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
                                    <div class="col-12">
                                        <label for="shift" class="form-label">Shift</label>
                                        <?php if (session()->get('is_admin') == '1') : ?>
                                            <select class="form-select <?= validation_show_error('shift') ? 'is-invalid' : ''; ?>" id="shift" name="shift">
                                            <?php else : ?>
                                                <input type="hidden" name="shift" id="shift" value="<?= $employee['shift']; ?>">
                                                <select class="form-select <?= validation_show_error('shift') ? 'is-invalid' : ''; ?>" id="shift" name="shift" disabled>
                                                <?php endif ?>
                                                <?php foreach ($shifts as $shift) : ?>
                                                    <?php if (old('shift', $employee['shift']) === $shift) : ?>
                                                        <option value="<?= $shift; ?>" selected><?= $shift; ?></option>
                                                    <?php else : ?>
                                                        <option value="<?= $shift; ?>"><?= $shift; ?></option>

                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    <?= validation_show_error('shift'); ?>
                                                </div>
                                    </div>
                                    <div class="text-end mt-3">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                    </form>

                        </div>

                        <div class="tab-pane fade pt-3" id="profile-change-password">
                            <!-- Change Password Form -->
                            <form action="/employees/changePassword/<?= session()->get('id'); ?>" method="POST">
                                <input type="hidden" name="batch_id" value="<?= session()->get('batch_id'); ?>">
                                <div class="row mb-3">
                                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password" type="password" class="form-control" id="currentPassword">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </form><!-- End Change Password Form -->

                        </div>

                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
    </div>
</section>

<!-- <script>
    const referer = document.querySelector('#referer');
    const error_val = document.querySelector('#error_val');
    const to_edit = document.querySelector('.to-edit');
    console.log(referer.innerHTML == error_val.innerHTML);
    console.log(to_edit);
    if (referer.innerHTML == error_val.innerHTML) {
        to_edit.click();
    }
</script> -->


<?= $this->endSection(); ?>