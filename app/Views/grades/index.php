<?= $this->extend('layouts/main.php') ?>

<?= $this->section('style') ?>
<link rel="stylesheet" href="<?= base_url() ?>assets/modules/datatables/datatables.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/modules/toastr/toastr.min.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Kelas</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="<?= base_url('grade') ?>">Kelas</a></div>
            <div class="breadcrumb-item">Tabel</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <!-- Message Block -->
                <?= $this->include('auth/_message_block.php') ?>

                <!-- Card Component -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Form Kelas</h4>
                        <div class="card-header-form d-flex align-items-center">
                            <a href="<?= base_url('grade/template') ?>" class="btn btn-primary mr-1">download template</a>
                            <form action="<?= base_url('grade/import_excel') ?>" method="post" enctype="multipart/form-data" class="d-inline">
                                <?= csrf_field() ?>
                                <label for="file_excel" class="btn btn-success mb-0" style="cursor: pointer;">Import Excel</label>
                                <input type="file" name="file_excel" id="file_excel" accept=".xlsx" style="display: none;" onchange="this.form.submit()">
                            </form>
                            <button type="button" class="btn btn-primary ml-2 mb-0" data-toggle="modal" data-target="#modal-default">
                                Tambah Kelas
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Grade Table -->
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Grade</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($grades as $grade) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $grade["name"] ?></td>
                                            <td>
                                                <form class="delete-form d-inline" action="<?= base_url('grade/delete/' . $grade['id']) ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary btn-sm btn-edit"
                                                    data-toggle="modal"
                                                    data-id="<?= $grade['id'] ?>"
                                                    data-name="<?= $grade['name'] ?>">
                                                    Edit
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- End of Card -->
            </div>
        </div>
    </div>
</section>



<!--****  TAMBAH MODAL ***-->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Kelas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addGradeForm" action="<?= base_url('grade/save') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!--**** EDIT MODAL ***-->
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Default Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="editGradeForm">
                    <?= csrf_field() ?>
                    <label for="name">Nama</label>
                    <input type="text" name="name" id="gradeName" class="form-control">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<?= $this->endSection() ?>


<?= $this->section('script') ?>
<script src="<?= base_url() ?>assets/modules/datatables/datatables.min.js"></script>
<script src="<?= base_url() ?>assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
<script src="<?= base_url() ?>assets/modules/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= base_url() ?>assets/modules/sweetalert/sweetalert.min.js"></script>

<script src="<?= base_url() ?>assets/modules/toastr/toastr.min.js"></script>
<script>
    $(function() {
        // Inisialisasi DataTable
        let dataTable = $("#table-1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
        });

        // Handle delete dengan SweetAlert
        $(document).on('submit', '.delete-form', function(e) {
            e.preventDefault(); // Prevent the form from submitting immediately

            // SweetAlert confirmation
            swal({
                title: 'Apakah anda yakin?',
                text: 'Once deleted, you will not be able to recover this record!',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    // Proceed with AJAX delete request
                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Hapus row dari DataTable
                                let tr = $(e.target).closest('tr');
                                dataTable.row(tr).remove().draw(false);

                                // Show success message
                                swal('Poof! Your record has been deleted!', {
                                    icon: 'success',
                                });

                                // Update nomor urut
                                dataTable.rows().every(function(rowIdx) {
                                    $(this.node()).find('td:first').html(rowIdx + 1);
                                });
                            }
                        },
                        error: function(xhr) {
                            swal('Error', 'Failed to delete the record', 'error');
                        }
                    });
                } else {
                    swal('Your record is safe!');
                }
            });
        });

        // Template untuk button aksi
        function getActionButtons(id, name) {
            return `<form class="delete-form d-inline" action="<?= base_url('grade/delete/') ?>${id}" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
        </form>
        <button type="button" class="btn btn-secondary btn-sm btn-edit"
            data-toggle="modal"
            data-id="${id}"
            data-name="${name}">
            Edit
        </button>`;
        }

        // Handle form tambah dengan AJAX
        $(document).on('submit', '#addGradeForm', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Tambah row baru ke DataTable
                        dataTable.row.add([
                            dataTable.rows().count() + 1,
                            response.data.name,
                            getActionButtons(response.data.id, response.data.name)
                        ]).draw(false);

                        $('#modal-default').modal('hide');
                        $('#addGradeForm')[0].reset();

                        toastr.success('Data berhasil ditambahkan', 'Sukses');
                    }
                },
                error: function(xhr) {
                    toastr.error('Gagal menambahkan data', 'Error');
                }
            });
        });

        // Handle form edit dengan AJAX
        $(document).on('submit', '#editGradeForm', function(e) {
            e.preventDefault();
            let id = $(this).attr('action').split('/').pop();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        let tr = $(`button[data-id="${id}"]`).closest('tr');
                        let rowData = dataTable.row(tr);

                        rowData.data([
                            rowData.index() + 1,
                            response.data.name,
                            getActionButtons(response.data.id, response.data.name)
                        ]).draw(false);

                        $('#modal-edit').modal('hide');
                        $('#editGradeForm')[0].reset();

                        toastr.success('Data berhasil diupdate', 'Sukses');
                    }
                },
                error: function(xhr) {
                    toastr.error('Gagal mengupdate data', 'Error');
                }
            });
        });

        // Handle tombol edit
        $(document).on('click', '.btn-edit', function() {
            let gradeId = $(this).data('id');
            let gradeName = $(this).data('name');

            $('#gradeName').val(gradeName);
            $('#editGradeForm').attr('action', '<?= base_url('grade/update/') ?>' + gradeId);
            $('#modal-edit').modal('show');
        });

        // Reset form saat modal ditutup
        $('#modal-edit, #modal-default').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
        });
    });
</script>

<?= $this->endSection() ?>