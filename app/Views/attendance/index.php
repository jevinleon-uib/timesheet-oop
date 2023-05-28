<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<h1>Attendance</h1>
<hr class="line-divider">

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success my-3" role="alert">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<?php if (!$checked_in) :  ?>

    <div class="card">
        <div class="card-header">Attendance Form</div>
        <div class="card-body">
            <h5 class="card-title">Stamp your attendance</h5>
            <h6 class="card-title" id="current-time">Loading..</h6>
            <form action="/clock_in" method="POST">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Shift</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?= session()->get('shift'); ?>" disabled>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Check In</button>
            </form>
        </div>
    </div>

<?php else : ?>

    <?php if ($checked_out) : ?>

        <div class="card">
            <div class="card-header">Attendance Form</div>
            <div class="card-body">
                <h5 class="card-title">Thank you for your work!</h5>
                <h6>We hope you have a good rest and come back fresh!</h6>
                <hr>
                <h6>Remarks :</h6>
                <?php if ($late or $OT or $early) : ?>
                    <?php if ($late) : ?>
                        <h6 style="color: red">*You were late for <?= $late; ?> today!</h6>
                    <?php endif ?>
                    <?php if ($OT) : ?>
                        <h6 style="color: green">*You worked overtime for <?= $OT; ?> today!</h6>
                    <?php endif ?>
                    <?php if ($early) : ?>
                        <h6 style="color: red">*You checked out <?= $early; ?> early today!</h6>
                    <?php endif ?>
                    <hr>
                <?php endif ?>
                <div class="d-flex justify-content-between">
                    <h6>You checked in at : <?= $ci; ?></h5>
                        <h6>You checked out at : <?= $co; ?></h5>
                </div>
            </div>
        </div>

    <?php else : ?>

        <div class="card">
            <div class="card-header">Attendance Form</div>
            <div class="card-body">
                <h5 class="card-title">Checked In</h5>
                <h6>“Work hard and be kind and amazing things will happen.” - Conan O'Brien</h6>
                <hr>
                <h6>You checked in at : <?= $ci; ?></h5>
                    <?php if ($late) : ?>
                        <h6 style="color: red">*You were late for <?= $late; ?> today! Don't repeat this action!</h6>
                    <?php endif ?>
                    <form action="/clock_out" method="POST">
                        <input type="hidden" name="t_id" value="<?= $t_id; ?>">
                        <button type="submit" class="btn btn-primary">Check Out</button>
                    </form>
            </div>
        </div>

    <?php endif ?>

<?php endif ?>







<?= $this->endSection(); ?>