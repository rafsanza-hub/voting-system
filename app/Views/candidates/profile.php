<?= $this->extend('layouts/main'); ?>

<?= $this->section('style') ?>
<!-- CSS styles -->
<link rel="stylesheet" href="<?= base_url() ?>assets/modules/summernote/summernote-bs4.css">
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
            <a href="<?= base_url() ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Profile</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Profile</div>
        </div>
    </div>
    <?= $this->include('auth/_message_block.php') ?>

    <div class="row mt-sm-4">
        <!-- Profile Widget -->
        <div class="col-12 col-md-12 col-lg-5">
            <div class="card profile-widget">
                <div class="profile-widget-header">
                    <img alt="image" src="/img/<?= $candidate['image'] ?>" class="rounded-circle profile-widget-picture">
                    <div class="profile-widget-items"></div>
                </div>
                <div class="profile-widget-description">
                    <div class="profile-widget-name"><?= ucwords(strtolower($candidate['fullname'])) ?>
                        <div class="text-muted d-inline font-weight-normal">
                            <div class="slash"></div> Web Developer
                        </div>
                    </div>
                    <?= $candidate['vision'] ?>
                    <?= $candidate['mission'] ?>
                </div>
                <!-- <div class="card-footer text-center">
                    <div class="font-weight-bold mb-2">Follow Ujang On</div>
                    <a href="#" class="btn btn-social-icon btn-facebook mr-1">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon btn-twitter mr-1">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon btn-github mr-1">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="#" class="btn btn-social-icon btn-instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div> -->
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
                <form method="post" action="<?= base_url('candidate/profile/update/' . $candidate['id']) ?>" class="needs-validation" novalidate="" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="oldImage" value="<?= $candidate['image'] ?>">
                    <input type="hidden" name="grade_id" value="<?= $candidate['grade_id'] ?>">
                    <input type="hidden" name="user_id" value="<?= user_id() ?>">
                    <div class="card-header">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Full Name Field -->
                            <div class="form-group col-md-6 col-12">
                                <label>Nama</label>
                                <input type="text"
                                    class="form-control <?= session('errors') && isset(session('errors')['fullname']) ? 'is-invalid' : ''; ?>"
                                    name="fullname" value="<?= old('fullname', $candidate['fullname']) ?>" required>
                                <div class="invalid-feedback">
                                    <?= (session('errors')['fullname']) ?? null ?>
                                </div>
                            </div>

                            <!-- Username Field -->
                            <div class="form-group col-md-6 col-12">
                                <label>Username</label>
                                <input type="text" disabled
                                    class="form-control"
                                    name="hahdhashd" value="<?= old('username', $candidate['username']) ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Visi Field -->
                            <div class="form-group col-md-12 col-12">
                                <label for="vision">Visi</label>
                                <textarea class="form-control summernote" id="vision-summernote" name="vision"
                                    required><?= old('vision', $candidate['vision']) ?></textarea>
                                <div class="invalid-feedback">
                                    <?= (session('errors')['vision']) ?? null ?>
                                </div>
                            </div>

                            <!-- Misi Field -->
                            <div class="form-group col-md-12 col-12">
                                <label for="mission">Misi</label>
                                <textarea class="form-control summernote" id="mission-summernote" name="mission"
                                    required><?= old('mission', $candidate['mission']) ?></textarea>
                                <div class="invalid-feedback">
                                    <?= (session('errors')['mission']) ?? null ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">


                            <!-- Upload Image -->
                            <div class="form-group col-md-12 col-12">
                                <label>Upload Gambar</label>
                                <input type="file" name="image" id="image" class="image-preview-filepond image">
                                <div class="invalid-feedback">
                                    <?= (session('errors')['image']) ?? null ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script src="<?= base_url() ?>assets/modules/summernote/summernote-bs4.js"></script>
<script src="<?= base_url() ?>assets/modules/codemirror/lib/codemirror.js"></script>
<script src="<?= base_url() ?>assets/modules/codemirror/mode/javascript/javascript.js"></script>
<script src="<?= base_url() ?>assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
<script src="<?= base_url() ?>assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js"></script>
<script src="<?= base_url() ?>assets/modules/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<!-- filepond validation -->
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

<!-- image editor -->
<script
    src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-filter/dist/filepond-plugin-image-filter.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js"></script>

<script src="<?= base_url() ?>assets/modules/toastify/toastify.js"></script>

<script src="https://unpkg.com/filepond/dist/filepond.js"></script>

<script>
    console.log("<?= old('mission', $candidate['mission']) ?>             <?= $candidate['mission'] ?>")

    // Register plugins yang diperlukan untuk preview
    FilePond.registerPlugin(
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview,
        FilePondPluginFilePoster,
        FilePondPluginImageExifOrientation,
        FilePondPluginImageCrop,
        FilePondPluginImageResize,
        FilePondPluginImageFilter
    );


    const imageUrl = '<?= base_url('img/' . $candidate['image']) ?>';
    console.log('Image URL:', imageUrl);


    const pond = FilePond.create(document.querySelector('.image'), {
        allowImagePreview: true,
        allowFilePoster: true,
        allowImageFilter: false,
        allowImageExifOrientation: false,
        allowImageCrop: false,
        acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg'],


        files: [{
            source: '<?= $candidate['image'] ?>',
            options: {
                type: 'local',
                metadata: {
                    poster: imageUrl
                },
                file: {
                    name: '<?= $candidate['image'] ?>',
                    size: 0,
                    type: 'image/png'
                }
            }
        }],
        acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg", "application/pdf"],
        fileValidateTypeDetectType: (source, type) =>
            new Promise((resolve, reject) => {
                resolve(type)
            }),
        storeAsFile: true,
    })
    $('.summernote').summernote({
        toolbar: [
            ['para', ['ul', 'ol']]
        ]
    });
    $("#vision-summernote").summernote("code", '<?= htmlspecialchars_decode(old('vision', $candidate['vision'])) ?>');
    $("#mission-summernote").summernote("code", "<?= htmlspecialchars_decode(old('mission', $candidate['mission'])) ?>");
</script>
<?= $this->endSection() ?>