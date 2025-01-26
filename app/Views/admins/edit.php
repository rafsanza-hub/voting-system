<?= $this->extend('layouts/main'); ?>
<?= $this->section('main') ?>

<?= $this->section('content') ?>

<section class="section">
    <div class="section-header">
        <h1>Edit Admin</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('admin') ?>">Admin</a></div>
            <div class="breadcrumb-item">Edit Admin</div>
        </div>
    </div>

    <div class="section-body">


        <!-- <div class="row"> -->

        <div class="card">
            <form Action="<?= base_url('admin/update/' . $admin['id']) ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="user_id" value="<?= $admin['user_id'] ?>" hidden>
                <div class="card-header">
                    <h4>Form Edit Admin</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control <?= session('errors') && isset(session('errors')['fullname']) ? 'is-invalid' : ''; ?>" name="fullname" value="<?= old('fullname', $admin['fullname']) ?>">
                                <div class="invalid-feedback">
                                    <?= (session('errors')['fullname']) ?? null ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control <?= session('errors') && isset(session('errors')['username']) ? 'is-invalid' : ''; ?>" name="username" value="<?= old('username', $admin['username']) ?>">
                                <div class="invalid-feedback">
                                    <?= (session('errors')['username']) ?? null ?>
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


            <!-- ganti pw -->
    <div class="card">
        <div class="card-header">
            <h4>Ganti Password</h4>
            <div class="card-header-action">
                <a data-collapse="#password-form" class="btn btn-icon btn-info" href="#"><i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="collapse" id="password-form">
            <form action="<?= base_url('admin/updatePassword/' . $admin['id']) ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="user_id" value="<?= $admin['user_id'] ?>" hidden>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" class="form-control <?= session('errors') && isset(session('errors')['password']) ? 'is-invalid' : ''; ?>" name="password">
                                <div class="invalid-feedback">
                                    <?= session('errors')['password'] ?? null ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Konfirmasi Password</label>
                                <input type="password" class="form-control <?= session('errors') && isset(session('errors')['password_confirm']) ? 'is-invalid' : ''; ?>" name="password_confirm">
                                <div class="invalid-feedback">
                                    <?= session('errors')['password_confirm'] ?? null ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-warning">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>

    </div>
</section>

<?= $this->endSection('content') ?>


<?= $this->endSection() ?>