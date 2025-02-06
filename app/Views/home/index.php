<?= $this->extend('votes/main') ?>

<?= $this->section('content') ?>
<?php if (in_groups('admin') || in_groups('voter')): ?>
    <section class="section mt-3">
        <div class="section-header">
            <h1>Beranda</h1>
        </div>

        <div class="section-body">
            <div class="row">

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
                                <?= $count_candidate ?>
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
                                <?= $count_voter ?>
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
                                <?= $timeUntilStart ?>
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
                                <?= $timeUntilStart ?>
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
                                    <a href="<?= base_url('change-password') ?>" class="btn btn-primary btn-block">
                                        <i class="fas fa-key mr-2"></i>Ubah Password
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <a href="<?= base_url('profile/candidate') ?>" class="btn btn-success btn-block">
                                        <i class="fas fa-lightbulb mr-2"></i>Edit Visi Misi
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                    <a href="<?= base_url('result') ?>" class="btn btn-info btn-block">
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
        if (!countdownElement) return;

        const now = Math.floor(Date.now() / 1000);
        const timeLeft = <?php echo $isVotingStarted ? $timeUntilEnd : $timeUntilStart ?>;
        const targetTime = now + timeLeft;

        function formatTime(remainingTime) {
            const hours = Math.floor(remainingTime / 3600);
            const minutes = Math.floor((remainingTime % 3600) / 60);
            const seconds = remainingTime % 60;
            return `${hours}j ${minutes}m ${seconds}d`;
        }

        function updateTimer() {
            const currentTime = Math.floor(Date.now() / 1000);
            const remainingTime = Math.max(0, targetTime - currentTime);

            if (remainingTime === 0) {
                <?php if ($isVotingStarted): ?>
                    countdownElement.textContent = 'Voting telah berakhir';
                <?php else: ?>
                    countdownElement.textContent = 'Voting telah dimulai';
                    location.reload();
                <?php endif; ?>
                return;
            }

            const timeDisplay = formatTime(remainingTime);
            countdownElement.textContent = <?php echo $isVotingStarted ?
                                                'timeDisplay' :
                                                '`${timeDisplay}`' ?>;
        }

        updateTimer();
        setInterval(updateTimer, 1000);
    }

    document.addEventListener('DOMContentLoaded', updateCountdown);
</script>
<?= $this->endSection() ?>