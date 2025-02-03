<?= $this->extend('layouts/main'); ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Table</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('period') ?>">Jadwal</a></div>
            <div class="breadcrumb-item">Tabel</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <?= $this->include('auth/_message_block.php') ?>
                <!-- Table Card -->
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Jadwal</h4>
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
                                    <?php if (!empty($periods)) : ?>
                                        <?php $period = $periods[0]; // Mengambil data pertama saja ?>
                                        <tr>
                                            <td>1</td>
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
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info btn-change-status" 
                                                        data-toggle="modal" 
                                                        data-target="#statusModal"
                                                        data-id="<?= $period['id'] ?>"
                                                        data-status="<?= $period['status'] ?>">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <form action="<?= base_url() ?>period/delete/<?= $period["id"] ?>" method="post" class="d-inline delete-form">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button class="btn btn-danger delete-btn" type="button">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="card">
                    <div class="card-header">
                        <h4><?= !empty($periods) ? 'Edit' : 'Tambah' ?> Jadwal</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('period/save') ?>" method="POST">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= !empty($periods) ? $periods[0]['id'] : null ?>">

                            <div class="form-group">
                                <label>Nama Jadwal</label>
                                <input type="text" class="form-control" name="name" 
                                    value="<?= !empty($periods) ? $periods[0]['name'] : old('name') ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Mulai</label>
                                <input type="date" class="form-control" name="start_date" 
                                    value="<?= !empty($periods) ? $periods[0]['start_date'] : old('start_date') ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Selesai</label>
                                <input type="date" class="form-control" name="end_date" 
                                    value="<?= !empty($periods) ? $periods[0]['end_date'] : old('end_date') ?>" required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Status Modal -->
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
                                <input type="radio" name="status" value="pending" class="selectgroup-input">
                                <span class="selectgroup-button selectgroup-button-icon">
                                    <i class="fas fa-hourglass-start text-info"></i> Belum Berlangsung
                                </span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="status" value="ongoing" class="selectgroup-input">
                                <span class="selectgroup-button selectgroup-button-icon">
                                    <i class="fas fa-sync-alt text-warning"></i> Berlangsung
                                </span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="status" value="completed" class="selectgroup-input">
                                <span class="selectgroup-button selectgroup-button-icon">
                                    <i class="fas fa-check-circle text-success"></i> Selesai
                                </span>
                            </label>
                        </div>
                    </div>
                    <input type="hidden" name="periodId" id="periodId">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="<?= base_url() ?>assets/js/page/modules-datatables.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            swal({
                title: 'Are you sure?',
                text: 'Once deleted, you will not be able to recover this data!',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
        });
    });

    // Status modal handling
    const changeStatusButtons = document.querySelectorAll('.btn-change-status');
    changeStatusButtons.forEach(button => {
        button.addEventListener('click', function() {
            const periodId = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-status');
            
            document.getElementById('periodId').value = periodId;
            document.querySelector(`input[name="status"][value="${currentStatus}"]`).checked = true;
        });
    });
});
</script>
<?= $this->endSection() ?>