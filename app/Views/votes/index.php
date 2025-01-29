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
        <h1>Para Kandidat</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="#">Para Kandidat</a></div>
            <div class="breadcrumb-item"><a href="#">Voting</a></div>
        </div>
    </div>

    <div class="section-body">
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
                                    data-target="#candidateModal" data-id="<?= $candidate['id'] ?>"
                                    data-image="<?= base_url() . "img/" . $candidate["image"] ?>"
                                    data-name="<?= $candidate["fullname"] ?>"
                                    data-vision="<?= htmlspecialchars($candidate["vision"]) ?>"
                                    data-mission="<?= htmlspecialchars($candidate["mission"]) ?>">
                                    Visi & Misi
                                </button>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="candidateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-xl-custom">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Kandidat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 col-md-12 mb-4">
                        <img id="modalImage" class="img-fluid rounded mx-auto d-block" alt="kandidat"
                            style="max-height: 300px;">
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <h3 class="mb-4 text-center text-lg-left" id="modalName"></h3>
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-4">
                                    <h5><strong>Visi:</strong></h5>
                                    <div id="modalVision"></div>
                                </div>
                                <div>
                                    <h5><strong>Misi:</strong></h5>
                                    <div id="modalMission"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script>
    // Vote Handler Class
    class VoteHandler {
        constructor() {
            this.selectedCandidateId = null;
            this.initializeEventListeners();
            initToastr();
        }

        initializeEventListeners() {
            // Vote buttons
            document.querySelectorAll('.vote-button').forEach(button => {
                button.addEventListener('click', (e) => this.handleVoteButtonClick(e));
            });

            // Vote action button
            document.getElementById('voteButton').addEventListener('click', () => this.handleVoteAction());

            // Confirm vote button
            document.getElementById('confirmVote').addEventListener('click', () => this.handleConfirmVote());
        }

        handleVoteButtonClick(e) {
            const button = e.currentTarget;
            this.selectedCandidateId = button.dataset.id;

            // Update modal content
            document.getElementById('modalImage').src = button.dataset.image;
            document.getElementById('modalName').textContent = button.dataset.name;
            document.getElementById('modalVision').innerHTML = button.dataset.vision;
            document.getElementById('modalMission').innerHTML = button.dataset.mission;

            $('#candidateModal').modal('show');
        }

        handleVoteAction() {
            $('#candidateModal').modal('hide');
            $('#konfirmasi').modal('show');
        }

        async handleConfirmVote() {
            try {
                const formData = new FormData();
                formData.append('candidate_id', this.selectedCandidateId);

                const response = await fetch('<?= base_url('vote/save') ?>', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();
                $('#konfirmasi').modal('hide');

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

    // Initialize voting system when DOM is ready
    document.addEventListener('DOMContentLoaded', () => {
        new VoteHandler();
    });
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