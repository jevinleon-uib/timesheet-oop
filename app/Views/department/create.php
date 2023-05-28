<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Departments</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/departments">Departments</a></li>
            <li class="breadcrumb-item">Departments Registration</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-8 my-4">
                        <form class="row g-3" action="/departments/store" method="POST">
                            <?= csrf_field(); ?>
                            <div class="col-12">
                                <label for="d_name" class="form-label">Department Name</label>
                                <input type="text" class="form-control <?= validation_show_error('d_name') ? 'is-invalid' : ''; ?>" id="d_name" name="d_name" value="<?= old('d_name'); ?>" autofocus>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('d_name'); ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="d_contact" class="form-label">Department Contact</label>
                                <input type="text" class="form-control <?= validation_show_error('d_contact') ? 'is-invalid' : ''; ?>" id="d_contact" name="d_contact" value="<?= old('d_contact'); ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('d_contact'); ?>
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary">Register New Department</button>
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