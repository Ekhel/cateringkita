<section class="py-5 account-page bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="<?= base_url('catering/add_member_act') ?>" method="post" enctype="multipart/form-data">
                                <div class="card-header">
                                    <div class="p-4">
                                        <div class="osahan-user text-center">
                                            <h4 class="text-dark mt-0 mb-0">Pendaftaran Member</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="control-label">Nama <span class="required">*</span></label>
                                        <input class="form-control border-form-control" name="nm_member" value="<?= !empty($this->session->userdata('nama')) ? $this->session->userdata('nama') : "" ?>" placeholder="Masukkan Nama Anda" type="text" required>
                                        <input class="form-control border-form-control" name="bagian_addmember" id="bagian_addmember" value="1" placeholder="Masukkan Nama Anda" type="hidden" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Jenis Kelamin <span class="required">*</span></label>
                                        <select name="jk" id="jk" class="form-control" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="laki-laki">Laki - Laki</option>
                                            <option value="perempuan">Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Nomer Telepon <span class="required">*</span></label>
                                        <input class="form-control border-form-control" id="notelp" name="no_telp" value="<?= !empty($this->session->userdata('telp')) ? $this->session->userdata('telp') : "" ?>" placeholder="Masukkan Nomer Telepon" type="text" required>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-8">
                                            <label>Kecamatan <span class="required text-danger">*</span></label>
                                            <select class="select2tujuan1 form-control border-form-control" id="subdis_session" name="subdistrict_cust_temp">
                                                <?php if (!empty($this->session->userdata('subdis'))) { ?>
                                                    <?php
                                                    $kec = $this->db->get_where('kecamatan', ['id' => $this->session->userdata('subdis')])->row_array()
                                                    ?>
                                                    <?php if (!empty($kec['id'])) { ?>
                                                        <option value="<?= $kec['id'] ?>" selected><?= $kec['provinsi'] . "," . $kec['kabupaten'] . ", " . $kec['kecamatan'] . ", " . $kec['kelurahan'] ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label">Kode Pos <span class="required">*</span></label>
                                            <input class="form-control border-form-control" id="kodepos" name="kodepos" value="<?= !empty($this->session->userdata('kd_pos')) ? $this->session->userdata('kd_pos') : "" ?>" placeholder="Kode Pos" type="text" required readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Alamat <span class="required">*</span></label>
                                        <textarea name="alamat" id="alamat" cols="20" rows="5" class="form-control" placeholder="Masukkan Alamat Lengkap" required><?= !empty($this->session->userdata('alamat')) ? $this->session->userdata('alamat') : "" ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Foto</label>
                                        <input type="file" class="form-control" name="userfile" id="recipient-name" placeholder="Masukkan Foto">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">New Password <span class="required">*</span></label>
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
            </div>
        </div>
    </div>
</section>