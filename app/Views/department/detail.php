<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="pagetitle">
    <div class="d-flex gap-2">
        <a href="/departments"><i class="bi bi-arrow-left"></i></a>
        <h1>Department Detail</h1>
    </div>
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success my-3" role="alert">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/departments">Departments</a></li>
            <li class="breadcrumb-item active">Department Detail</li>
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
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Department</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title"><?= $department['d_name'] . "'s Details"; ?></h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Name</div>
                                <div class="col-lg-9 col-md-8"><?= $department['d_name'] ?></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Batch ID</div>
                                <div class="col-lg-9 col-md-8"><?= $department['d_batch_id']; ?></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Contact</div>
                                <div class="col-lg-9 col-md-8"><?= $department['d_contact']; ?></div>
                            </div>

                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                            <!-- Profile Edit Form -->
                            <form class="row g-3" action="/departments/update/<?= $department['d_id']; ?>" method="POST">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="d_batch_id" value="<?= $department['d_batch_id']; ?>">
                                <div class="col-12">
                                    <label for="d_name" class="form-label">Department Name</label>
                                    <input type="text" class="form-control <?= validation_show_error('d_name') ? 'is-invalid' : ''; ?>" id="d_name" name="d_name" value="<?= old('d_name', $department['d_name']); ?>" autofocus>
                                    <div class="invalid-feedback">
                                        <?= validation_show_error('d_name'); ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="d_contact" class="form-label">Department Contact</label>
                                    <input type="text" class="form-control <?= validation_show_error('d_contact') ? 'is-invalid' : ''; ?>" id="d_contact" name="d_contact" value="<?= old('d_contact', $department['d_contact']); ?>">
                                    <div class="invalid-feedback">
                                        <?= validation_show_error('d_contact'); ?>
                                    </div>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade pt-3" id="profile-change-password">
                            <!-- Change Password Form -->
                            <form>

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


<?= $this->endSection(); ?>