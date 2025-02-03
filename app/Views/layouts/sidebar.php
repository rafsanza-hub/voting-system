<style>
    .sidebar-menu .nav-link.active {
        position: relative;
        color: #007bff !important;
        /* Warna teks aktif */
        font-weight: bold;
    }
</style>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?= base_url() ?>"><?= get_config('name') ?? 'E-Voting' ?></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?= base_url() ?>"><?= substr(get_config('name') ?? 'EV', 0, 2) ?></a>
        </div>
        <?php if (in_groups('admin')) : ?>
            <ul class="sidebar-menu">
                <li class="menu-header">Dashboard</li>
                <li>
                    <a class="nav-link <?= url_is('dashboard') ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
                        <i class="fas fa-fire"></i> <span>Dashboard</span>
                    </a>
                </li>

                <?php if (!url_is('admin/profile') && !url_is('change-password')) : ?>
                    <li class="menu-header">Kelola User</li>
                    <li>
                        <a class="nav-link <?= url_is('admin') ? 'active' : '' ?>" href="<?= base_url('admin') ?>">
                            <i class="fas fa-users-cog"></i> <span>Admin</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link <?= url_is('candidate') ? 'active' : '' ?>" href="<?= base_url('candidate') ?>">
                            <i class="fas fa-user"></i> <span>Kandidat</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link <?= url_is('voter') ? 'active' : '' ?>" href="<?= base_url('voter') ?>">
                            <i class="fas fa-users"></i> <span>Pemilih</span>
                        </a>
                    </li>

                    <li class="menu-header">Master Data</li>
                    <li>
                        <a class="nav-link <?= url_is('grade') ? 'active' : '' ?>" href="<?= base_url('grade') ?>">
                            <i class="fas fa-chalkboard-teacher"></i> <span>Kelas</span>
                        </a>
                    </li>

                    <li class="menu-header">Pengaturan</li>
                    <li>
                        <a class="nav-link <?= url_is('configuration') ? 'active' : '' ?>" href="<?= base_url('configuration') ?>">
                            <i class="fas fa-cog"></i> <span>Pengaturan</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link <?= url_is('period') ? 'active' : '' ?>" href="<?= base_url('period') ?>">
                            <i class="fas fa-calendar-alt"></i> <span>Jadwal</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="menu-header">Pengaturan</li>
                    <li>
                        <a class="nav-link <?= url_is('admin/profile') ? 'active' : '' ?>" href="<?= base_url('admin/profile') ?>">
                            <i class="fas fa-poll"></i> <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link <?= url_is('change-password') ? 'active' : '' ?>" href="<?= base_url('change-password') ?>">
                            <i class="fas fa-poll"></i> <span>Password</span>
                        </a>
                    </li>
                <?php endif; ?>

                <li class="menu-header">Logout</li>
                <li>
                    <a class="nav-link <?= url_is('logout') ? 'active' : '' ?>" href="<?= base_url('logout') ?>">
                        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                    </a>
                </li>
            </ul>
        <?php elseif (in_groups('candidate')) : ?>
            <ul class="sidebar-menu">
                <li class="menu-header">Pengaturan</li>
                <li>
                    <a class="nav-link" href="<?= base_url('candidate/profile') ?>">
                        <i class="fas fa-poll"></i> <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="<?= base_url('change-password') ?>">
                        <i class="fas fa-poll"></i> <span>Password</span>
                    </a>
                </li>
                <li class="menu-header">Logout</li>
                <li>
                    <a class="nav-link" href="<?= base_url('logout') ?>">
                        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                    </a>
                </li>
            </ul>
        <?php elseif (in_groups('voter')) : ?>
            <ul class="sidebar-menu">
                <li class="menu-header">Home</li>
                <li>
                    <a class="nav-link" href="<?= base_url() ?>">
                        <i class="fas fa-poll"></i> <span>Home</span>
                    </a>
                </li>
                <li class="menu-header">Pengaturan</li>
                <li>
                    <a class="nav-link <?= url_is('voter/profile') ? 'active' : '' ?>" href="<?= base_url('voter/profile') ?>">
                        <i class="fas fa-poll"></i> <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link <?= url_is('change-password') ? 'active' : '' ?>" href="<?= base_url('change-password') ?>">
                        <i class="fas fa-poll"></i> <span>Password</span>
                    </a>
                </li>
                <li class="menu-header">Logout</li>
                <li>
                    <a class="nav-link" href="<?= base_url('logout') ?>">
                        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                    </a>
                </li>
            </ul>
        <?php endif; ?>
    </aside>
</div>