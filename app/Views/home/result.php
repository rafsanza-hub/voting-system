<?= $this->extend('votes/main') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="<?= base_url() ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Hasil Resmi Pemilihan</h1>
    </div>

    <div class="section-body">
        <?php
        if ($voting_status == 'completed'): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Ringkasan Hasil Voting</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="card card-statistic-1">
                                        <div class="card-icon bg-primary">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4>Total Pemilih Terdaftar</h4>
                                            </div>
                                            <div class="card-body">
                                                <?= $total_registered_voters ?? 10 ?>
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
                                                <h4>Total Suara Masuk</h4>
                                            </div>
                                            <div class="card-body">
                                                <?= $total_votes ?? 10 ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="card card-statistic-1">
                                        <div class="card-icon bg-warning">
                                            <i class="fas fa-chart-pie"></i>
                                        </div>
                                        <div class="card-wrap">
                                            <div class="card-header">
                                                <h4>Partisipasi</h4>
                                            </div>
                                            <div class="card-body">
                                                <?= number_format($participation_percentage ?? 10, 2) ?>%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Perolehan Suara Kandidat</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Kandidat</th>
                                            <th>Jumlah Suara</th>
                                            <th>Persentase</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($candidates as $candidate): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?= base_url('img/' . $candidate['image']) ?>" class="rounded-circle mr-3" width="50" height="50">
                                                        <?= $candidate['fullname'] ?>
                                                    </div>
                                                </td>
                                                <td><?= $candidate['vote_count'] ?? '' ?></td>
                                                <td><?= number_format($candidate['vote_percentage'] ?? 10, 2) ?>%</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Sertifikat Hasil Resmi</h4>
                        </div>
                        <div class="card-body text-center">
                            <div class="alert alert-info">
                                <p>
                                    <strong>Hasil resmi telah diverifikasi dan disahkan oleh Komisi Pemilihan.</strong>
                                </p>
                                <p>Dokumen resmi dapat diminta di sekretariat panitia pemilihan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif ($voting_status == 'pending'): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="alert alert-info">
                                <h4>Voting Belum Dimulai</h4>
                                <p>Proses pemungutan suara akan segera berlangsung.</p>
                                <p>Silakan tunggu pengumuman resmi dari panitia.</p>
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
        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="alert alert-warning">
                                <h4>Hasil Voting Belum Tersedia</h4>
                                <p>Proses pemungutan suara masih berlangsung atau belum selesai.</p>
                                <p>Hasil resmi akan dipublikasikan setelah proses voting selesai.</p>
                            </div>
                            <div class="mt-3">
                                <a href="<?= base_url() ?>" class="btn btn-outline-warning">
                                    <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?= $this->endSection() ?>