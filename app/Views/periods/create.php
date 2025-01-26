<?= $this->extend('layouts/main'); ?>



<?= $this->section('content') ?>

<section class="section">
    <div class="section-header">
        <h1>Form Validation</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Forms</a></div>
            <div class="breadcrumb-item">Form Validation</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Form Validation</h2>
        <p class="section-lead">
            Form validation using default from Bootstrap 4
        </p>

        <!-- <div class="row"> -->

        <div class="card">
            <form Action="<?= base_url('period/save') ?>" method="post">
            <?= csrf_field() ?>
                <div class="card-header">
                    <h4>Server-side Validation</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control <?= session('errors') && isset(session('errors')['name']) ? 'is-invalid' : ''; ?>" name="name" value="<?= old('name') ?>">
                                <div class="invalid-feedback">
                                    <?= (session('errors')['name']) ?? null ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>start_date</label>
                                <input type="date" class="form-control <?= session('errors') && isset(session('errors')['start_date']) ? 'is-invalid' : ''; ?>" name="start_date" value="<?= old('start_date') ?>">
                                <div class="invalid-feedback">
                                    <?= (session('errors')['start_date']) ?? null ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Berakhir</label>
                                <input type="date" class="form-control <?= session('errors') && isset(session('errors')['end_date']) ? 'is-invalid' : ''; ?>" name="end_date" value="<?= old('mision') ?>">
                                <div class="invalid-feedback">
                                    <?= (session('errors')['end_date']) ?? null ?>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>


    </div>
</section>


<?= $this->endSection() ?>

