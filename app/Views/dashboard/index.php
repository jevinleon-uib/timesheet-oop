<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<h1>Dashboard</h1>
<hr class="line-divider">

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success my-3" role="alert">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<?php if (session()->get('is_admin') == '1') :  ?>
    <div class="d-flex flex-wrap">
        <div class="col-xxl-4 col-md-6 m-2">
            <div class="card info-card sales-card">
                <div class="card-body">
                    <h5 class="card-title">Employees Count <span>| Today</span></h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6><?= $employees_count; ?></h6>
                            <span class="text-muted small pt-2 ps-1">People</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6 m-2">
            <div class="card info-card revenue-card">
                <div class="card-body">
                    <h5 class="card-title">
                        Departments Counts
                    </h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-box"></i>
                        </div>
                        <div class="ps-3">
                            <h6><?= $departments_count; ?></h6>
                            <span class="text-muted small pt-2 ps-1">Departments</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6 m-2  ">
            <div class="card info-card late-card">
                <div class="card-body">
                    <h5 class="card-title">
                        Late Counts
                        <span>| <?= $curr_month_name ?? 'This month'; ?></span>
                    </h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-exclamation-circle"></i>
                        </div>
                        <div class="ps-3">
                            <h6><?= $curr_month_lates; ?></h6>
                            <span class="text-muted small pt-2 ps-1">Lates</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif ?>


<?= $this->endSection(); ?>