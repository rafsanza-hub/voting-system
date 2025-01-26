<?= $this->extend('votes/main') ?>

<?= $this->section('content') ?>
<?php if (in_groups('admin') || in_groups('voter')): ?>
    <section class="section mt-3">
        <div class="section-header">
            <h1>Sistem Pemilihan</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="hero bg-primary text-white">
                        <div class="hero-inner">
                            <h2>Selamat Datang di Sistem Pemilihan</h2>
                            <p class="lead">Gunakan hak pilih Anda untuk memilih pemimpin masa depan.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Kandidat</h4>
                            </div>
                            <div class="card-body">
                                3
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon bg-success">
                            <i class="fas fa-vote-yea"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pemilih</h4>
                            </div>
                            <div class="card-body">
                                100
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Sisa Waktu Voting</h4>
                            </div>
                            <div class="card-body" id="countdown">
                                7 hari
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Menu Utama</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <a href="<?= base_url('candidates') ?>" class="btn btn-primary btn-block">
                                        <i class="fas fa-users mr-2"></i>Lihat Kandidat
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <a href="<?= base_url('voting') ?>" class="btn btn-success btn-block">
                                        <i class="fas fa-vote-yea mr-2"></i>Mulai Voting
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <a href="<?= base_url('result') ?>" class="btn btn-info btn-block">
                                        <i class="fas fa-chart-bar mr-2"></i>Lihat Hasil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif ?>

<?php if (in_groups('candidate')): ?>
    <section class="section">
        <div class="section-header">
            <h1>Dashboard Kandidat</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Dukungan</h4>
                            </div>
                            <div class="card-body">
                                0
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-vote-yea"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jumlah Suara</h4>
                            </div>
                            <div class="card-body">
                                0
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Sisa Waktu Voting</h4>
                            </div>
                            <div class="card-body" id="countdown">
                                7 hari
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Menu Kandidat</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <a href="<?= base_url('kandidat/profil') ?>" class="btn btn-primary btn-block">
                                        <i class="fas fa-user mr-2"></i>Lihat Profil
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <a href="<?= base_url('kandidat/visi-misi') ?>" class="btn btn-success btn-block">
                                        <i class="fas fa-lightbulb mr-2"></i>Edit Visi Misi
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <a href="<?= base_url('kandidat/statistik') ?>" class="btn btn-info btn-block">
                                        <i class="fas fa-chart-bar mr-2"></i>Lihat Statistik
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif ?>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    function updateCountdown() {
        const countdownElement = document.getElementById('countdown');
        const endDate = new Date();
        endDate.setDate(endDate.getDate() + 7);

        const now = new Date();
        const timeLeft = endDate - now;

        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        countdownElement.textContent = `${days} hari`;
    }

    // Update countdown immediately and then every day
    updateCountdown();
    setInterval(updateCountdown, 24 * 60 * 60 * 1000);
</script>
<?= $this->endSection() ?>