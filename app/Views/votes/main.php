<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Layout &rsaquo; Top Navigation &mdash; Stisla</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/modules/toastr/toastr.min.css">
    <?= $this->renderSection("style") ?>

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <style>
        .modal-xl-custom {
            max-width: 90%;
            width: 90%;
        }

        .btn-custom {
            width: 8rem;
        }

        .large {
            width: 8rem;
            height: 8rem;
        }

        .navbar-secondary .nav-item.active .nav-link {
            position: relative;
            color: #007bff !important;
            /* Warna teks untuk menu aktif */
            font-weight: bold;
            /* Opsional untuk menonjolkan teks */
        }
    </style>

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-94034622-3');
    </script>
</head>

<body class="layout-3">
    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg"></div>

            <!-- Main Navbar -->
            <nav class="navbar navbar-expand-lg main-navbar">
                <a href="index.html" class="navbar-brand sidebar-gone-hide">SMKN 2 Kuningan</a>
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link  sidebar-gone-show nav-link-lg"><i class="fas fa-bars"></i></a></li>

                    </ul>
                </form>



                <ul class="navbar-nav navbar-right ml-auto">
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="<?= base_url('img/') . (get_image() ?? 'default.png') ?>" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block"><?= user()->username ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-title">
                                <?= get_role() ?></div>
                            <a
                                href="<?= in_groups('admin') ? base_url('admin/profile') : (in_groups('candidate') ? base_url('candidate/profile') : (in_groups('voter') ? base_url('voter/profile') : base_url())) ?>"
                                class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <?php if (in_groups('admin')) : ?>
                                <a href="features-settings.html" class="dropdown-item has-icon">
                                    <i class="fas fa-cog"></i> Settings
                                </a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url('logout') ?>" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- Secondary Navbar -->
            <nav class="navbar navbar-secondary navbar-expand-lg">
                <div class="container">
                    <ul class="navbar-nav">
                        <li class="nav-item <?= url_is('/') ? 'active' : '' ?>">
                            <a class="nav-link" href="<?= base_url() ?>"><i class="fas fa-users"></i> <span>Para
                                    Kandidat</span></a>
                        </li>
                        <li class="nav-item <?= url_is('voting') ? 'active' : '' ?>">
                            <a class="nav-link" href="<?= base_url('voting') ?>"><i class="fas fa-poll"></i>
                                <span>Voting</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="#"><i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span></a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">
                <?= $this->renderSection('content') ?>
                <!-- <section class="section mt-3">
                    <div class="section-header">
                        <h1>Para Kandidat</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item"><a href="#">Para Kandidat</a></div>
                            <div class="breadcrumb-item"><a href="#">Voting</a></div>
                        </div>
                    </div>
                    <div class="section-body">
                        <div class="row justify-content-center">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                <article class="article">
                                    <div class="article-header rounded">
                                        <div class="article-image bg-secondary img-fluid"
                                            style="background-image: url('https://picsum.photos/400/300');">
                                        </div>
                                    </div>
                                    <div class="article-details">
                                        <h3 class="text-center font-weight-bold">Gustavo Fring</h3>
                                        <p class="text-center text-muted">Kandidat 1</p>
                                        <div class="article-cta">
                                            <button type="button" class="btn btn-primary btn-custom" data-toggle="modal"
                                                data-target="#exampleModal">
                                                Visi & Misi
                                            </button>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </div>
                </section> -->
            </div>
        </div>
    </div>



    <!-- General JS Scripts -->
    <script src="assets/modules/jquery.min.js"></script>
    <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="assets/js/stisla.js"></script>
    <script src="assets/modules/toastr/toastr.min.js"></script>

    <!-- Template JS File -->
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/custom.js"></script>
    <?= $this->renderSection('script') ?>
</body>

</html>