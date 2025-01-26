<?= $this->extend('layouts/main'); ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Table</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Components</a></div>
            <div class="breadcrumb-item">Table</div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">Table</h2>
        <p class="section-lead">Example of some Bootstrap table components.</p>
        <div class="row">
            <div class="col-12">
                <?= $this->include('auth/_message_block.php') ?>
                <div class="card">
                    <div class="card-header">
                        <h4>Advanced Table</h4>
                        <div class="card-header-form">
                            <?php if (!$dataExists) : ?>
                                <!-- Tombol "Tambah Data" hanya ditampilkan jika tidak ada data -->
                                <a href="<?= base_url('period/create') ?>" class="btn btn-primary">Tambah Data</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Dimulai</th>
                                        <th>Berkhir</th>
                                        <th>Status</th>
                                        <th>Ubah status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($periods as $period) : ?>
                                        <tr>
                                            <td>
                                                <?= $i++ ?>
                                            </td>

                                            <td><?= $period["name"] ?></td>
                                            <td><?= $period["start_date"] ?></td>
                                            <td><?= $period["end_date"] ?></td>
                                            <td>
                                                <?php if ($period["status"] == 'pending') : ?>
                                                    <span class="badge badge-info">Belum Berlangsung</span>
                                                <?php elseif ($period["status"] == 'ongoing') : ?>
                                                    <span class="badge badge-warning">Berlangsung</span>
                                                <?php elseif ($period["status"] == 'completed') : ?>
                                                    <span class="badge badge-success">Selesai</span>
                                                <?php else : ?>
                                                    <span class="badge badge-secondary"><?= $period["status"] ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('period/change-status/' . $period['id'] . '?status=' . $period['status']) ?>"
                                                    class="btn btn-sm btn-info"
                                                    data-toggle="modal"
                                                    data-target="#statusModal"
                                                    title="Ubah Status">
                                                    <i class="fas fa-sync-alt"></i> <!-- Ikon sync -->
                                                </a>
                                            </td>
                                            <td>
                                                <form action="<?= base_url() ?>period/delete/<?= $period["id"] ?>" method="post" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button class="btn btn-danger" type="submit">hapus</button>
                                                </form>
                                                <a href="<?= base_url("period/edit/" . $period['id']) ?>" class="btn btn-warning">edit</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal untuk Ubah Status -->
<?php foreach ($periods as $period) : ?>
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Ubah Status Voting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('period/update-status') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="selectgroup selectgroup-pills">
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="pending" class="selectgroup-input" <?= ($period['status'] == 'pending') ? 'checked' : '' ?>>
                                    <span class="selectgroup-button selectgroup-button-icon">
                                        <i class="fas fa-hourglass-start text-info"></i> Belum Berlangsung
                                    </span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="ongoing" class="selectgroup-input" <?= ($period['status'] == 'ongoing') ? 'checked' : '' ?>>
                                    <span class="selectgroup-button selectgroup-button-icon">
                                        <i class="fas fa-sync-alt text-warning"></i> Berlangsung
                                    </span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="completed" class="selectgroup-input" <?= ($period['status'] == 'completed') ? 'checked' : '' ?>>
                                    <span class="selectgroup-button selectgroup-button-icon">
                                        <i class="fas fa-check-circle text-success"></i> Selesai
                                    </span>
                                </label>
                            </div>
                        </div>
                        <input type="hidden" name="periodId" value="<?= $period['id'] ?>">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?= $this->endSection() ?>



<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url() ?>assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script src="<?= base_url() ?>assets/modules/datatables/datatables.min.js"></script>
<script src="<?= base_url() ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
<script src="<?= base_url() ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>

<!-- Page Specific JS File -->
<script src="<?= base_url() ?>assets/js/page/modules-datatables.js"></script>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tangkap semua tombol dengan class btn-change-status
        const changeStatusButtons = document.querySelectorAll('.btn-change-status');

        // Tangkap input hidden dan radio button di modal
        const periodIdInput = document.getElementById('periodId');
        const statusRadios = document.querySelectorAll('input[name="status"]');

        changeStatusButtons.forEach(button => {
            button.addEventListener('click', function() {
                const periodId = this.getAttribute('data-id'); // Ambil ID dari atribut data-id
                const currentStatus = this.getAttribute('data-status'); // Ambil status dari atribut data-status

                // Isi ID ke input hidden di modal
                periodIdInput.value = periodId;

                // Set radio button yang sesuai dengan status saat ini
                statusRadios.forEach(radio => {
                    if (radio.value === currentStatus) {
                        radio.checked = true;
                    } else {
                        radio.checked = false;
                    }
                });
            });
        });
    });
</script>
<?= $this->endSection() ?>