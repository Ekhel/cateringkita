<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $judul; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active"><?= $judul; ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="<?= base_url('assets/images/user/' . $user['image']) ?>" alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center"><?= $user["nm_$tabel"] ?></h3>

                                    <?php if ($this->session->userdata('kd_masak')) { ?>
                                        <p class="text-muted text-center">Pemasak</p>
                                    <?php } else if ($this->session->userdata('kd_admin')) {  ?>
                                        <p class="text-muted text-center">Administrator</p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <form action="<?= base_url('dashboard/edit_user/1') ?>" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nm_user">Nama <?= $this->session->userdata('kd_reseller') ? "Reseller" : "User"; ?></label>
                                            <input type="hidden" name="kd_user" class="form-control" id="kd_user" placeholder="Masukkan Nama" value="<?= $user["kd_$tabel"] ?>">
                                            <input type="text" name="nm_user" class="form-control" id="nm_user" placeholder="Masukkan Nama" value="<?= $user["nm_$tabel"] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan Username" value="<?= $user["username"] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="no_telp">No. Telepon</label>
                                            <input type="text" name="no_telp" class="form-control" id="no_telp" placeholder="Masukkan Nomor Telepon" value="<?= $user["no_telp"] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email" value="<?= $user["email"] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Foto</label>
                                            <input type="file" class="form-control" name="userfile" id="recipient-name" placeholder="Masukkan Foto">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <!-- <input type="password" name="password" class="form-control" id="password_edit" placeholder="Masukkan Password Baru"> -->
                                            <input type="password" name="password" class="form-control" id="password_edit1" placeholder="Masukkan Password Baru">
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Retype New Password</label>
                                            <input type="password" name="retype_password" class="form-control" id="retype_password_edit" placeholder="Masukkan Ulangi Password Baru">
                                        </div>
                                        <div class="feedback"></div>
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="checkboxpass">
                                            <label for="checkboxpass">
                                                Lihat Password
                                            </label>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <button type="submit" id="editProfile" class="btn btn-primary">Edit Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->