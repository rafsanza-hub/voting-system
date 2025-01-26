<?= $this->extend('votes/main') ?>

<?= $this->section('content') ?>

<style>
    .modal-fullscreen {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        max-width: none;
    }

    .modal-fullscreen .modal-content {
        height: 100%;
        border: 0;
        border-radius: 0;
    }

    .modal-fullscreen .modal-body {
        overflow-y: auto;
        height: calc(100% - 56px - 56px);
        /* Mengurangi tinggi header dan footer */
    }

    .modal-fullscreen .modal-header,
    .modal-fullscreen .modal-footer {
        border: 0;
    }
</style>

<section class="section mt-3">
    <div class="section-header">
        <div class="section-header-back">
            <a href="<?= base_url() ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Voting</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></div>
            <div class="breadcrumb-item">Voting</div>
        </div>
    </div>

    <div class="section-body">
        <?php if ($voting_status == 'ongoing'): ?> 
            <div class="row justify-content-center">
                <?php foreach ($candidates as $candidate): ?>
                    <div class="col-6 col-sm-6 col-md-6 col-lg-4">
                        <article class="article">
                            <div class="article-header rounded">
                                <div class="article-image bg-secondary img-fluid"
                                    style="background-image: url('<?= base_url() . "img/" . $candidate["image"] ?>');">
                                </div>
                            </div>
                            <div class="article-details">
                                <h3 class="text-center font-weight-bold"><?= ucwords(strtolower($candidate["fullname"])) ?></h3>
                                <p class="text-center text-muted">Kandidat <?= $candidate['candidate_order'] ?></p>
                                <div class="article-cta">
                                    <button class="btn btn-primary btn-custom vote-button" data-toggle="modal"
                                        data-target="#konfirmasi" data-id="<?= $candidate['id'] ?>"
                                        data-image="<?= base_url() . "img/" . $candidate["image"] ?>"
                                        data-name="<?= $candidate["fullname"] ?>"
                                        data-vision="<?= htmlspecialchars($candidate["vision"]) ?>"
                                        data-mission="<?= htmlspecialchars($candidate["mission"]) ?>">
                                        Voting
                                        sekarang</button>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif ($voting_status == 'pending'): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="alert alert-info">
                                <h4>Voting Belum Dimulai</h4>
                                <p>Proses pemungutan suara akan segera dimulai.</p>
                                <p>Silakan tunggu pengumuman resmi.</p>
                            </div>
                            <div class="mt-3">
                                <a href="<?= base_url() ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif ($voting_status == 'completed'): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="alert alert-success">
                                <h4>Voting Telah Selesai</h4>
                                <p>Terima kasih telah berpartisipasi.</p>
                                <p>Hasil resmi akan segera diumumkan.</p>
                            </div>
                            <div class="mt-3">
                                <a href="<?= base_url() ?>" class="btn btn-outline-success">
                                    <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="alert alert-warning">
                                <h4>Status Voting Tidak Dikenali</h4>
                                <p>Terjadi kesalahan dalam menentukan status voting.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>




<div class="modal fade" id="confirmVoteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <h5 class="fw-bold mb-3">Apakah yakin dengan pilihan Anda?</h5>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-danger mr-2" data-dismiss="modal">Tidak</button>
                    <button class="btn btn-primary" id="confirmVoteButton">Ya</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script>
    class VotingSystem {
        constructor() {
            this.selectedCandidateId = null;
            this.initEventListeners();
            this.configureToastr();
        }

        configureToastr() {
            toastr.options = {
                closeButton: true,
                positionClass: "toast-top-right",
                preventDuplicates: true,
                timeOut: "5000",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            };
        }

        initEventListeners() {
            document.querySelectorAll('.vote-button').forEach(button => {
                button.addEventListener('click', (e) => this.handleVoteButtonClick(e));
            });

            document.getElementById('confirmVoteButton').addEventListener('click', () => this.submitVote());
        }

        handleVoteButtonClick(e) {
            const button = e.currentTarget;
            this.selectedCandidateId = button.dataset.candidateId;

            $('#confirmVoteModal').modal('show');
        }

        async submitVote() {
            try {
                const formData = new FormData();
                formData.append('candidate_id', this.selectedCandidateId);

                const response = await fetch('<?= base_url('vote/save') ?>', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                $('#confirmVoteModal').modal('hide');

                if (result.success) {
                    toastr.success(result.message, 'Sukses');
                    this.disableVoteButtons();
                } else {
                    toastr.error(result.message, 'Error');
                }
            } catch (error) {
                console.error('Vote error:', error);
                toastr.error('Terjadi kesalahan sistem', 'Error');
            }
        }

        disableVoteButtons() {
            document.querySelectorAll('.vote-button').forEach(btn => {
                btn.disabled = true;
                btn.classList.add('disabled');
            });
        }
    }

    document.addEventListener('DOMContentLoaded', () => new VotingSystem());
</script>
<?= $this->endSection() ?>
<?= $this->section('style') ?>
<style>
    .article {
        position: relative;
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        /* Tambahan ini penting */
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .article-header {
        width: 100% !important;
        background-color: #f4f4f4;
        padding: 20px;
        margin-bottom: auto;
    }

    .article-image {
        width: 130px !important;
        height: 130px !important;
        margin: auto;
        display: block;
    }

    .article-image.bg-secondary {
        border-radius: 50% !important;
        background-position: center !important;
        background-size: cover !important;
        background-repeat: no-repeat !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .article-image {
            width: 110px !important;
            height: 110px !important;
        }

        .article-header {
            width: 100% !important;
            background-color: #f4f4f4;
            padding: auto;
            margin: auto;
        }

        .article-details h3 {
            font-size: 01.1rem;
        }


    }
</style>
<?= $this->endSection() ?>