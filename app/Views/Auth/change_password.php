<?= $this->extend('layouts/main'); ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url() ?>assets/modules/summernote/summernote-bs4.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/modules/codemirror/lib/codemirror.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/modules/codemirror/theme/duotone-dark.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/modules/jquery-selectric/selectric.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/modules/dropzonejs/dropzone.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/modules/perfect-scrollbar/perfect-scrollbar.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/modules/toastify/toastify.css">
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css" rel="stylesheet" />

<style>
    .dropzone {
        min-height: 150px !important;
        border: 2px dashed #ddd !important;
        border-radius: 5px;
        padding: 10px !important;
    }

    /* Custom styles for the Dropzone */
    .dropzone .dz-message {
        margin: 2em 0 !important;
        text-align: center;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="<?= in_groups('admin') ? base_url('dashboard') : base_url() ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Ubah Password</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= in_groups('admin') ? base_url('dashboard') : base_url() ?>">Dashboard</a></div>
            <div class="breadcrumb-item">Ubah Password</div>
        </div>
    </div>

    <div class="section-body">
        <?= $this->include('auth/_message_block.php') ?>

        <!-- ganti pw -->
        <div class="card">
            <div class="card-header">
                <h4>Form Ubah Password</h4>
            </div>
            <div class="card-body">
                <form action="<?= base_url(relativePath: 'update-password') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="user_id" value="<?= user_id() ?>" hidden>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Password Saat Ini</label>
                                    <input type="password"
                                        class="form-control <?= session('errors') && isset(session('errors')['current_password']) ? 'is-invalid' : ''; ?>"
                                        name="current_password">
                                    <div class="invalid-feedback">
                                        <?= session('errors')['current_password'] ?? null ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Password Baru</label>
                                    <input type="password"
                                        class="form-control <?= session('errors') && isset(session('errors')['password']) ? 'is-invalid' : ''; ?>"
                                        name="password">
                                    <div class="invalid-feedback">
                                        <?= session('errors')['password'] ?? null ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Konfirmasi Password</label>
                                    <input type="password"
                                        class="form-control <?= session('errors') && isset(session('errors')['password_confirm']) ? 'is-invalid' : ''; ?>"
                                        name="password_confirm">
                                    <div class="invalid-feedback">
                                        <?= session('errors')['password_confirm'] ?? null ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Ubah Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
<?= $this->section('script') ?>

<?= $this->endSection() ?>