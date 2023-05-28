<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="pagetitle">
    <h1>Employees</h1>
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success my-3" role="alert">
            <?= session()->getFlashdata('success'); ?>
        </div>
    <?php endif; ?>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
            <li class="breadcrumb-item">Departments</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">List of Departments</h5>
                    <a href="/departments/create" class="btn btn-primary mb-3">Register new department</a>
                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Batch ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($departments as $department) :
                            ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $department['d_batch_id']; ?></td>
                                    <td><?= $department['d_name']; ?></td>
                                    <td><?= $department['d_contact']; ?></td>
                                    <td colspan="2">
                                        <a href="/departments/<?= $department['d_batch_id']; ?>" class="btn btn-success mb-3"><i class="bi bi-eye"></i></a>
                                        <form action="/departments/<?= $department['d_id']; ?>" method="POST" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger mb-3" onclick="return confirm('Are you sure?')"><i class="bi bi-trash"></i></button>
                                        </form>
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