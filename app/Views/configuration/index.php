<!-- View (admin/configuration/index.php) -->
<?= $this->extend('layouts/main') ?>

<?= $this->section('style') ?>
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css" rel="stylesheet" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="section">
    <div class="section-header">
        <h1>Konfigurasi</h1>
        <div class="section-header-button">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#documentationModal">
                <i class="fas fa-question-circle"></i> Panduan Pengisian
            </button>
        </div>
    </div>

    <div class="section-body">
        <?= $this->include('auth/_message_block') ?>
        <div class="card">
            <form action="<?= base_url('configuration/update') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="oldLogo" value="<?= $config['logo'] ?? '' ?>">

                <div class="card-body">
                    <div class="row">
                        <!-- Nama -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>"
                                    value="<?= old('name', $config['name'] ?? '') ?>" required>
                                <div class="invalid-feedback">
                                    <?= session('errors.name') ?>
                                </div>
                            </div>
                        </div>

                        <!-- Logo -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Logo</label>
                                <input type="file" name="logo" class="image-preview-filepond">
                                <div class="invalid-feedback">
                                    <?= session('errors.logo') ?>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>"
                                    value="<?= old('email', $config['email'] ?? '') ?>" required>
                                <div class="invalid-feedback">
                                    <?= session('errors.email') ?>
                                </div>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Telepon</label>
                                <input type="text" name="phone" class="form-control <?= session('errors.phone') ? 'is-invalid' : '' ?>"
                                    value="<?= old('phone', $config['phone'] ?? '') ?>" required>
                                <div class="invalid-feedback">
                                    <?= session('errors.phone') ?>
                                </div>
                            </div>
                        </div>

                        <!-- Website -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Website</label>
                                <input type="url" name="website" class="form-control <?= session('errors.website') ? 'is-invalid' : '' ?>"
                                    value="<?= old('website', $config['website'] ?? '') ?>">
                                <div class="invalid-feedback">
                                    <?= session('errors.website') ?>
                                </div>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-12">
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="address" class="form-control <?= session('errors.address') ? 'is-invalid' : '' ?>"
                                    rows="3"><?= old('address', $config['address'] ?? '') ?></textarea>
                                <div class="invalid-feedback">
                                    <?= session('errors.address') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Simpan Konfigurasi</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Documentation Modal -->
<div class="modal fade" id="documentationModal" tabindex="-1" role="dialog" aria-labelledby="documentationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="documentationModalLabel">Panduan Pengisian Konfigurasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Konfigurasi ini akan digunakan di seluruh bagian website. Pastikan data yang diisi sudah benar.
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Kegunaan</th>
                                <th>Format</th>
                                <th>Contoh</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td>
                                    <ul class="mb-0">
                                        <li>Digunakan sebagai nama website/aplikasi</li>
                                        <li>Muncul di header website</li>

                                    </ul>
                                </td>
                                <td>
                                    <ul class="mb-0">
                                        <li>Hanya huruf, angka, dan spasi</li>
                                    </ul>
                                </td>
                                <td>Pemilihan Ketua Osis SMKN 2 Kuningan</td>
                            </tr>
                            <tr>
                                <td>Logo</td>
                                <td>
                                    <ul class="mb-0">
                                        <li>Logo utama website</li>
                                        <li>Muncul di navbar</li>
                                        <li>Digunakan sebagai favicon</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="mb-0">
                                        <li>Format: PNG, JPG, JPEG</li>
                                        <li>Maksimal ukuran: 5MB</li>
                                        <li>Rekomendasi ukuran: 200x200px</li>
                                    </ul>
                                </td>
                                <td>logo.png</td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td>
                                    <ul class="mb-0">
                                        <li>Nomor WhatsApp untuk pengaduan</li>
                                        <li>Digunakan untuk redirect chat WA</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="mb-0">
                                        <li>Diawali dengan 628</li>
                                        <li>Hanya angka</li>
                                        <li>Pastikan nomor aktif di WhatsApp</li>
                                    </ul>
                                </td>
                                <td>62895804217653</td>
                            </tr>
                            <tr>
                                <td>Website</td>
                                <td>
                                    <ul class="mb-0">
                                        <li>Website resmi instansi</li>
                                        <li>Link di footer</li>
                                        <li>Referensi website utama</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="mb-0">
                                        <li>URL valid dengan https://</li>
                                        <li>Domain resmi instansi</li>
                                    </ul>
                                </td>
                                <td>https://smkn2-kng.sch.id/</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>
                                    <ul class="mb-0">
                                        <li>-</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="mb-0">
                                        <li>-</li>
                                    </ul>
                                </td>
                                <td>Jl. Malaraman, Desa Cisantana, Kec. Cigugur, Kab. Kuningan, Provinsi Jawa Barat</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>
                                    <ul class="mb-0">
                                        <li>-</li>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="mb-0">
                                        <li>-</li>
                                    </ul>
                                </td>
                                <td>rapsanza@gmail.com</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle"></i> <strong>Penting:</strong>
                    <ul class="mb-0">
                        <li>Nomor telepon harus aktif di WhatsApp karena akan digunakan untuk menerima pengaduan</li>
                        <li>Logo sebaiknya menggunakan format PNG dengan background transparan</li>
                        <li>Pastikan semua informasi kontak selalu update</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<!-- FilePond Plugins -->
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>

<script>
    // Register plugins
    FilePond.registerPlugin(
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview,
        FilePondPluginFilePoster
    );

    // Get existing file info
    const existingFile = '<?= $config['logo'] ?? '' ?>';
    const baseUrl = '<?= base_url() ?>';

    // Initialize FilePond
    const pond = FilePond.create(document.querySelector('.image-preview-filepond'), {
        allowImagePreview: true,
        allowFilePoster: true,
        allowImageFilter: false,
        allowImageExifOrientation: false,
        allowImageCrop: false,
        acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg'],
        maxFileSize: '5MB',
        storeAsFile: true,
        labelIdle: 'Seret & Lepas file atau <span class="filepond--label-action"> Pilih File </span>',

        // Konfigurasi file yang sudah ada
        files: existingFile ? [{
            // source adalah nama file
            source: existingFile,
            options: {
                type: 'local',
                // Informasi file
                file: {
                    name: existingFile,
                    size: 0,
                    type: 'image/png'
                },
                // Metadata untuk preview
                metadata: {
                    poster: `${baseUrl}/img/config/${existingFile}`
                }
            }
        }] : [],


        server: {
            load: (source, load, error, progress, abort, headers) => {
                // Create URL
                const url = `${baseUrl}/img/config/${source}`;

                // Fetch file
                fetch(url)
                    .then(response => response.blob())
                    .then(blob => {
                        load(blob);
                    })
                    .catch(err => {
                        console.error('Error loading file:', err);
                        error('Error loading file');
                    });

                return {
                    abort: () => {
                        abort();
                    }
                };
            }
        }
    });
</script>
<?= $this->endSection() ?>