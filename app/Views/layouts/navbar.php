<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>

        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="<?= base_url('img/') . (get_image() ?? 'default.png') ?>" class="rounded-circle mr-1">

                <div class="d-sm-none d-lg-inline-block"><?= user()->username ?></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">
                    <?= get_role() ?></div>
                <a
                    href="<?= in_groups('admin') ? base_url('profile/admin') : (in_groups('candidate') ? base_url('profile/candidate') : (in_groups('voter') ? base_url('profile/voter') : base_url())) ?>"
                    class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <?php if (in_groups('admin')) : ?>
                    <a href="<?= base_url('configuration') ?>" class="dropdown-item has-icon">
                        <i class="fas fa-cog"></i> Pengaturan
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