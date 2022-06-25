<?php
if (!$this->session->userdata('kd_member')) {
    $this->session->set_flashdata('error_page', 'Maaf, Anda Perlu login terlebih dahulu.');
    redirect(base_url('main'));
}
?>
<section class="py-5 account-page bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="<?= base_url('catering/password_act') ?>" method="post" enctype="multipart/form-data">
                                <div class="card-header">
                                    <div class="p-4">
                                        <div class="osahan-user text-center">
                                            <h4 class="text-dark mt-0 mb-0">Ubah Password</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="password">New Password <span class="required">*</span></label>
                                        <input class="form-control border-form-control" name="bagian_addmember" id="bagian_addmember" value="1" placeholder="Masukkan Nama Anda" type="hidden" required>
                                        <input type="password" name="password" class="form-control" id="password_edit1" placeholder="Masukkan Password Baru" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Retype New Password <span class="required">*</span></label>
                                        <input type="password" name="retype_password" class="form-control" id="retype_password_edit" placeholder="Masukkan Ulangi Password Baru" required>
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
                                    <button type="submit" id="editProfile" class="btn btn-primary btn-block">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- <div class="osahan-account-page-right rounded shadow-sm bg-white p-4 h-100">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="my-profile" role="tabpanel" aria-labelledby="my-profile-tab">
                            <div class="p-4">
                                <div class="osahan-user text-center">
                                    <h4 class="text-dark mt-0 mb-4">My Profile</h4>
                                    <div class="osahan-user-media">
                                        <img class="mb-3 rounded-pill shadow-sm mt-1" src="<?= base_url() ?>assets/toko_/img/user/1.jpg" alt="gurdeep singh osahan">
                                    </div>
                                </div>
                            </div>
                            <form>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label">Nama <span class="required">*</span></label>
                                            <input class="form-control border-form-control" value="<?= !empty($this->session->userdata('nama')) ? $this->session->userdata('nama') : "" ?>" placeholder="Masukkan Nama Anda" type="text" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Nomer Telepon <span class="required">*</span></label>
                                            <input class="form-control border-form-control" value="<?= !empty($this->session->userdata('telp')) ? $this->session->userdata('telp') : "" ?>" placeholder="Masukkan Nomer Telepon" type="text" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Alamat <span class="required">*</span></label>
                                            <textarea name="alamat_cust_temp" id="alamat" cols="20" rows="5" class="form-control" placeholder="Masukkan Alamat Lengkap" required><?= !empty($this->session->userdata('alamat')) ? $this->session->userdata('alamat') : "" ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Password <span class="required">*</span></label>
                                            <input class="form-control border-form-control" value="" placeholder="Masukkan Password" type="text" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Ulangi Password <span class="required">*</span></label>
                                            <input class="form-control border-form-control" value="" placeholder="Masukkan Ulang Password" type="text" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        <button type="submit" class="btn btn-block btn-primary"> Simpan </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</section>