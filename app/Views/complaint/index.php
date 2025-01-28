<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Form Pengaduan &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
            <div class="login-brand">
              Stisla
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Form Pengaduan</h4></div>

              <div class="card-body">
                <form method="POST" id="pengaduanForm">
                  <div class="form-group">
                    <label for="nis">NIS</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-id-card"></i>
                        </div>
                      </div>
                      <input id="nis" type="text" class="form-control" name="nis" autofocus placeholder="NIS" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-user"></i>
                        </div>
                      </div>
                      <input id="nama_lengkap" type="text" class="form-control" name="nama_lengkap" placeholder="Nama Lengkap" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-school"></i>
                        </div>
                      </div>
                      <input id="kelas" type="text" class="form-control" name="kelas" placeholder="Kelas" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="pengaduan">Pengaduan</label>
                    <textarea id="pengaduan" class="form-control" name="pengaduan" placeholder="Deskripsi Pengaduan" required></textarea>
                  </div>

                  <div class="form-group text-center">
                    <button type="submit" class="btn btn-lg btn-round btn-primary">
                      Kirim Pengaduan
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; Stisla 2018
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <script>
  document.getElementById('pengaduanForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const nis = document.getElementById('nis').value;
    const nama = document.getElementById('nama_lengkap').value;
    const kelas = document.getElementById('kelas').value;
    const pengaduan = document.getElementById('pengaduan').value;

    // Format pesan dengan emoji dan struktur yang rapi
    const message = `📝 *FORM PENGADUAN* 📝%0A%0A` +
                    `🔢 *NIS*: ${nis}%0A` +
                    `👤 *Nama Lengkap*: ${nama}%0A` +
                    `🏫 *Kelas*: ${kelas}%0A` +
                    `📄 *Pengaduan*: ${pengaduan}%0A%0A` +
                    `Terima kasih telah mengirimkan pengaduan. Tim kami akan segera menindaklanjuti.`;

    const whatsappUrl = `https://wa.me/62895804217653?text=${message}`; // Ganti dengan nomor WhatsApp yang dituju

    // Buka WhatsApp di tab baru
    window.open(whatsappUrl, '_blank');
  });
</script>
</body>
</html>