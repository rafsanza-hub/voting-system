<?= $this->extend('layouts/main'); ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Kandidat</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="<?= base_url('dashboard') ?>">Dashboard</a></div>
            <div class="breadcrumb-item">kandidat</div>
            <div class="breadcrumb-item">Tabel</div>
        </div>
    </div>

    <div class="section-body">

        <div class="row">
            <div class="col-12">
                <?= $this->include('auth/_message_block.php') ?>
                <div class="card">
                    <div class="card-header">
                        <h4>Tabel Kandidat</h4>
                        <div class="card-header-form">
                            <a href="<?= base_url('candidate/template') ?>" class="btn btn-primary mr-1">download template</a>
                            <form action="<?= base_url('candidate/import_excel') ?>" method="post" enctype="multipart/form-data" class="d-inline">
                                <?= csrf_field() ?>
                                <label for="file_excel" class="btn btn-warning mb-0 mr-1" style="cursor: pointer;">Import Excel</label>
                                <input type="file" name="file_excel" id="file_excel" accept=".xlsx" style="display: none;" onchange="this.form.submit()">
                            </form>
                            <a href="<?= base_url('candidate/export_excel') ?>" class="btn btn-success mr-1">Export Excel</a>
                            <a href="<?= base_url('candidate/create') ?>" class="btn btn-primary">Tambah Data</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>image</th>
                                        <th>Nama</th>
                                        <th>username</th>
                                        <th>Visi</th>
                                        <th>Misi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($candidates as $candidate) : ?>
                                        <tr>
                                            <td>
                                                <?= $i++ ?>
                                            </td>
                                            <td>
                                                <img alt="image" src="<?= base_url('img/') . $candidate["image"] ?>" class="rounded-circle" width="35" height="35" data-toggle="tooltip" title="<?= $candidate["fullname"] ?>">
                                            </td>
                                            <td>
                                                <?= $candidate["fullname"] ?>
                                            </td>
                                            <td><?= $candidate["username"] ?></td>
                                            <td class="text-truncate" style="max-width: 200px;"><?= $candidate["vision"] ?></td>
                                            <td class="text-truncate" style="max-width: 200px;"><?= $candidate["mission"] ?></td>
                                            <td>
                                                <form action="<?= base_url('candidate/delete/') ?><?= $candidate['id'] ?>" method="post" class="d-inline delete-form" id="delete-form-<?= $candidate['id'] ?>">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button class="btn btn-danger delete-btn" type="button" data-id="<?= $candidate['id'] ?>">hapus</button>
                                                </form>
                                                <a href="<?= base_url("candidate/edit/" . $candidate['id']) ?>" class="btn btn-warning">edit</a>
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
<script src="assets/modules/sweetalert/sweetalert.min.js"></script>


<script>
$(function() {
    // Initialize DataTable
    let dataTable;
    if ($.fn.DataTable.isDataTable('#table-1')) {
        dataTable = $('#table-1').DataTable();
    } else {
        dataTable = $("#table-1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
        });
    }

    // Handle delete form submission
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let form = $(`#delete-form-${id}`);
        
        swal({
            title: 'Apakah anda yakin?',
            text: 'Once deleted, you will not be able to recover this candidate!',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            let tr = form.closest('tr');
                            dataTable.row(tr).remove().draw(false);
                            swal('Success!', response.message, 'success');

                            dataTable.rows().every(function(rowIdx) {
                                    $(this.node()).find('td:first').html(rowIdx + 1);
                                });
                        } else {
                            swal('Error!', 'Failed to delete candidate.', 'error');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        swal('Error!', 'An error occurred while deleting the candidate.', 'error');
                    }
                });
            } else {
                swal('Your candidate is safe!');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>