<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<?php session()->set('previous_url', previous_url()) ?>
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="<?= base_url() ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Profile</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Profile</div>
        </div>
    </div>
    <?= $this->include('auth/_message_block.php') ?>
    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-5">
            <div class="card profile-widget">
                <div class="profile-widget-header">
                    <img alt="image" src="<?= base_url('img/') . $voter['image'] ?>" class="rounded-circle profile-widget-picture">
                </div>
                <div class="profile-widget-description">
                    <div class="profile-widget-name"><?= user()->username ?><div class="text-muted d-inline font-weight-normal">
                            <div class="slash"></div>
                            <?= get_role() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
                <form method="POST" action="<?= base_url('profile/voter/update/') . $voter['id'] ?>" class="needs-validation" novalidate="">
                    <?= csrf_field() ?>
                    <input type="hidden" name="grade_id" value="<?= $voter['grade_id'] ?>">
                    <div class="card-header">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Username Field -->
                            <div class="form-group col-12">
                                <label>Username</label>
                                <input type="text"
                                    class="form-control"
                                    name="username" value="<?= old('username', $voter['username']) ?>" disabled required>
                            </div>
                            <div class="form-group col-12">
                                <label>Nama Lengkap</label>
                                <input type="text"
                                    class="form-control"
                                    name="assksksks" value="<?=  $voter['fullname'] ?>" required disabled>
                            </div>
                            <input type="hidden" name="fullname"  value="<?=  $voter['fullname'] ?>">

                            <div class="form-group col-12 col-md-6">
                                <label>Kelas</label>
                                <input type="text" class="form-control" value=" <?= $voter['grade'] ?>" disabled>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label>Role</label>
                                <input type="text" class="form-control" value=" <?= get_role() ?>" disabled>
                            </div>
                            <div class="form-group col-12">
                                <label class="form-label">Avatar</label>
                                <div class="selectgroup selectgroup-pills">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="image" value="default.png" class="selectgroup-input" <?= ($voter['image'] == 'default.png') ? 'checked' : '' ?>>
                                        <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-user text-info"></i></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="image" value="default-2.png" class="selectgroup-input" <?= ($voter['image'] == 'default-2.png') ? 'checked' : '' ?>>
                                        <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-user text-danger"></i></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="image" value="default-3.png" class="selectgroup-input" <?= ($voter['image'] == 'default-3.png') ? 'checked' : '' ?>>
                                        <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-user"></i></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="image" value="default-4.png" class="selectgroup-input" <?= ($voter['image'] == 'default-4.png') ? 'checked' : '' ?>>
                                        <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-user text-warning"></i></span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="image" value="default-5.png" class="selectgroup-input" <?= ($voter['image'] == 'default-5.png') ? 'checked' : '' ?>>
                                        <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-user text-success"></i></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</section>


<?= $this->endSection(); ?>