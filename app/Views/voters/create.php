<?= $this->extend('layouts/main'); ?>
<?= $this->section('main') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="section-header">
        <h1>Tambah pemilih</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('voter') ?>">Pemilih</a></div>
            <div class="breadcrumb-item">Tambah pemilih</div>
        </div>
    </div>

    <div class="section-body">


        <!-- <div class="row"> -->

        <div class="card">
            <?= $this->include('auth/_message_block.php') ?>

            <form Action="<?= base_url('voter/save') ?>" method="post">
                <?= csrf_field() ?>
                <div class="card-header">
                    <h4>Form Tambah pemilih</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control <?= session('errors') && isset(session('errors')['fullname']) ? 'is-invalid' : ''; ?>" name="fullname" value="<?= old('fullname') ?>">
                                <div class="invalid-feedback">
                                    <?= (session('errors')['fullname']) ?? null ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control <?= session('errors') && isset(session('errors')['username']) ? 'is-invalid' : ''; ?>" name="username" value="<?= old('username') ?>">
                                <div class="invalid-feedback">
                                    <?= (session('errors')['username']) ?? null ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control <?= session('errors') && isset(session('errors')['password']) ? 'is-invalid' : ''; ?>" name="password" value="<?= old('password') ?>">
                                <div class="invalid-feedback">
                                    <?= (session('errors')['password']) ?? null ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Ulang Password</label>
                                <input type="password" class="form-control <?= session('errors') && isset(session('errors')['pass_confirm']) ? 'is-invalid' : ''; ?>" name="pass_confirm" value="<?= old('pass_confirm') ?>">
                                <div class="invalid-feedback">
                                    <?= (session('errors')['pass_confirm']) ?? null ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Kelas</label>
                                <select class="form-control <?= session('errors') && isset(session('errors')['grade_id']) ? 'is-invalid' : ''; ?>" name="grade_id" value="<?= old('grade_id') ?>">
                                    <?php foreach ($grades as $grade): ?>
                                        <option value="<?= $grade['id'] ?>"><?= $grade['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    <?= (session('errors')['grade_id']) ?? null ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                <a class="btn btn-danger" href="<?=base_url('voter')?>">Kembali</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>


    </div>
</section>

<?= $this->endSection('content') ?>


<?= $this->endSection() ?>