<div class="modal fade" id="delete-address-modal" tabindex="-1" role="dialog" aria-labelledby="delete-address" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-address">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0 text-black">Kamu Yakin Ingin Menghapus Alamat ini ? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn d-flex w-50 text-center justify-content-center btn-outline-primary" data-dismiss="modal">CANCEL
                </button><button type="button" class="btn d-flex w-50 text-center justify-content-center btn-primary" id="hapus_alamat_sess">DELETE</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<form id="form_edit_alamat" autocomplete="off">
    <div class="modal fade" id="edit-address-modal" tabindex="-1" role="dialog" aria-labelledby="add-address" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-address">Edit Data Pembeli</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Nama <span class="required text-danger">*</span></label>
                            <input class="form-control border-form-control" id="nama_cust_temp" name="nama_cust_temp" value="<?= !empty($this->session->userdata('nama')) ? $this->session->userdata('nama') : "" ?>" placeholder="Masukkan Nama Anda" type="text" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Nomor Telepon <span class="required text-danger">*</span></label>
                            <input class="form-control border-form-control" id="telp_cust_temp" value="<?= !empty($this->session->userdata('telp')) ? $this->session->userdata('telp') : "" ?>" name="telp_cust_temp" placeholder="Masukkan Nomor Telepon(Whatsapp)" onkeypress="return hanyaAngka(event)" type="text" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Email</label>
                            <input class="form-control border-form-control" id="email_cust_temp" value="<?= !empty($this->session->userdata('email')) ? $this->session->userdata('email') : "" ?>" name="email_cust_temp" placeholder="Masukkan Email" type="email">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Kecamatan <span class="required text-danger">*</span></label>
                            <select class="select2tujuan1 form-control border-form-control" id="subdis_session" name="subdistrict_cust_temp">
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Kode Pos <span class="required text-danger">*</span></label>
                            <input class="form-control border-form-control" id="edit_kode_pos" name="kdpos_cust_temp" value="<?= !empty($this->session->userdata('kd_pos')) ? $this->session->userdata('kd_pos') : "" ?>" placeholder="Kode Pos" type="number" required>
                        </div>
                        <div class="col-md-12" style="display: none;">
                            <input type="hidden" name="map_section" class="form-control" id="edit_map_section" value="order_pelanggan">
                            <div id="edit_map">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Alamat Lengkap<span class="required text-danger">*</span>
                            </label>
                            <textarea name="alamat_cust_temp" id="edit_alamat" cols="20" rows="5" class="form-control" placeholder="Masukkan Alamat Lengkap" required><?= !empty($this->session->userdata('alamat')) ? $this->session->userdata('alamat') : "" ?></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Catatan Pengiriman
                            </label>
                            <input type="text" name="patokan_cust_temp" id="catatan_cust_temp" value="<?= !empty($this->session->userdata('patokan_alamat')) ? $this->session->userdata('patokan_alamat') : "" ?>" class="form-control" placeholder="Masukkan Catatan Pengiriman">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="display: block;">
                    <button type="button" class="btn btn-lg text-center justify-content-center btn-primary" data-dismiss="modal">CANCEL</button>
                    <span class="mytooltip tooltip-effect-5">
                        <button type="submit" class="btn btn-lg text-center justify-content-center btn-primary tooltip-item btn-edit-alamat">SUBMIT</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</form>
<form id="form_add_alamat" autocomplete="off">
    <div class="modal fade" id="add-address-modal" tabindex="-1" role="dialog" aria-labelledby="add-address" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add-address">Tambah Data Pembeli</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Nama<span class="required text-danger">*</span></label>
                            <input class="form-control border-form-control" name="nama_cust_temp" value="" placeholder="Masukkan Nama Anda" type="text" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Nomor Telepon <span class="required text-danger">*</span></label>
                            <input class="form-control border-form-control" value="<?= !empty($this->session->userdata('telp')) ? $this->session->userdata('telp') : "" ?>" name="telp_cust_temp" id="add_telp_cust_temp" placeholder="Masukkan Nomor Telepon(Whatsapp)" onkeypress="return hanyaAngka(event)" type="text" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Email</label>
                            <input class="form-control border-form-control" value="" name="email_cust_temp" placeholder="Masukkan Email" type="email">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Kecamatan <span class="required text-danger">*</span></label>
                            <select class="select2tujuan form-control border-form-control" name="subdistrict_cust_temp" required>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Kode Pos <span class="required text-danger">*</span></label>
                            <input class="form-control border-form-control" id="kode_pos" name="kdpos_cust_temp" value="" placeholder="Kode Pos" type="number" required>
                        </div>
                        <div class="col-md-12" style="display: none;">
                            <input type="hidden" name="map_section" class="form-control" id="map_section" value="order_pelanggan">
                            <div id="map">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Alamat Lengkap<span class="required text-danger">*</span>
                            </label>
                            <textarea name="alamat_cust_temp" id="alamat" cols="20" rows="5" class="form-control" placeholder="Masukkan Alamat Lengkap" required></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Catatan Pengiriman
                            </label>
                            <input type="text" name="patokan_cust_temp" class="form-control" placeholder="Masukkan Catatan Pengiriman">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn d-flex w-50 text-center justify-content-center btn-outline-primary" data-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn d-flex w-50 text-center justify-content-center btn-primary btn-add-alamat">SUBMIT</button>
                </div>
            </div>
        </div>
    </div>
</form>
<form id="form_edit_alamat_lain" autocomplete="off">
    <div class="modal fade" id="edit-alamat-lain" tabindex="-1" role="dialog" aria-labelledby="add-address" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-address">Tambah Alamat Lain</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Nama Lengkap <span class="required text-danger">*</span></label>
                            <input type="hidden" name="checkout_page" value="1">
                            <input class="form-control border-form-control" id="kd_detail_alamat_edit" name="kd_detail_alamat" placeholder="" type="hidden" required readonly>
                            <input class="form-control border-form-control" id="nama_lengkap_edit" name="nama_lengkap" placeholder="Nama Lengkap" type="text" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">No. Handphone <span class="required text-danger">*</span></label>
                            <input class="form-control border-form-control" id="no_handphone_edit" name="no_handphone" placeholder="No. Handphone" onkeypress="return hanyaAngka(event)" type="text" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Kecamatan <span class="required text-danger">*</span></label>
                            <select class="select2tujuan1 form-control border-form-control" id="kecamatan_lain_edit" name="subdistrict" required>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Kode Pos <span class="required text-danger">*</span></label>
                            <input class="form-control border-form-control" id="kode_pos_lain_edit" name="kode_pos" placeholder="Kode Pos" type="number" required readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Alamat Lengkap<span class="required text-danger">*</span>
                            </label>
                            <textarea name="alamat" id="alamat_lain_edit" cols="20" rows="5" class="form-control" placeholder="Masukkan Alamat Lengkap" required></textarea>
                        </div>
                        <div class="form-group col-md-12" id="tandai_sebagai_edit">
                            <label>Tandai Sebagai <span class="required text-danger">*</span></label>
                            <select class="form-control border-form-control" id="label_edit" name="label" required>
                                <option value="">Pilih Lokasi</option>
                                <option value="kantor">Kantor</option>
                                <option value="rumah">Rumah</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6" id="input_tandai_sebagai_edit" style="display: none;">
                            <label class="control-label"></label><br>
                            <input class="form-control border-form-control mt-2" name="label_name" id="label_name_edit" placeholder="Nama Lokasi" type="text">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn d-flex w-50 text-center justify-content-center btn-outline-primary" data-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn d-flex w-50 text-center justify-content-center btn-primary">SIMPAN</button>
                </div>
            </div>
        </div>
    </div>
</form>
<form id="form_add_alamat_lain" autocomplete="off">
    <div class="modal fade" id="add-alamat-lain" tabindex="-1" role="dialog" aria-labelledby="add-address" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-address">Tambah Alamat Lain</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input type="hidden" name="checkout_page" value="1">
                            <label class="control-label">Nama Lengkap <span class="required text-danger">*</span></label>
                            <input class="form-control border-form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap" type="text" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">No. Handphone <span class="required text-danger">*</span></label>
                            <input class="form-control border-form-control" id="no_handphone" name="no_handphone" placeholder="No. Handphone" onkeypress="return hanyaAngka(event)" type="text" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Kecamatan <span class="required text-danger">*</span></label>
                            <select class="select2tujuan1 form-control border-form-control" id="kecamatan_lain" name="subdistrict" required>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Kode Pos <span class="required text-danger">*</span></label>
                            <input class="form-control border-form-control" name="kd_member" value="<?= !empty($user['kd_member']) ? $user['kd_member'] : "" ?>" placeholder="Masukkan Nama Anda" type="hidden" required>
                            <input class="form-control border-form-control" id="kode_pos_lain" name="kode_pos" placeholder="Kode Pos" type="number" required readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Alamat Lengkap<span class="required text-danger">*</span>
                            </label>
                            <textarea name="alamat" id="alamat_lain" cols="20" rows="5" class="form-control" placeholder="Masukkan Alamat Lengkap" required></textarea>
                        </div>
                        <div class="form-group col-md-12" id="tandai_sebagai">
                            <label>Tandai Sebagai <span class="required text-danger">*</span></label>
                            <select class="form-control border-form-control" id="label" name="label" required>
                                <option value="">Pilih Lokasi</option>
                                <option value="kantor">Kantor</option>
                                <option value="rumah">Rumah</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6" id="input_tandai_sebagai" style="display: none;">
                            <label class="control-label"></label><br>
                            <input class="form-control border-form-control mt-2" name="label_name" placeholder="Nama Lokasi" type="text">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn d-flex w-50 text-center justify-content-center btn-outline-primary" data-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn d-flex w-50 text-center justify-content-center btn-primary">SIMPAN</button>
                </div>
            </div>
        </div>
    </div>
</form>
<form id="form_delete_alamat_lain">
    <div class="modal fade" id="delete-alamat-lain" tabindex="-1" role="dialog" aria-labelledby="delete-address" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete-address">Hapus Alamat Lain</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-0 text-black">Kamu Yakin Ingin mengahapus data Alamat ini ?</p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="checkout_page" value="1">
                    <input type="hidden" id="kd_detail_alamat_delete" name="kd_detail_alamat">
                    <button type="button" class="btn d-flex w-50 text-center justify-content-center btn-outline-primary" data-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn d-flex w-50 text-center justify-content-center btn-primary">HAPUS</button>
                </div>
            </div>
        </div>
    </div>
</form>
<form id="form_edit_alamat_utama" autocomplete="off">
    <div class="modal fade" id="edit-alamat-utama" tabindex="-1" role="dialog" aria-labelledby="add-address" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-address">Alamat Utama</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Kecamatan <span class="required text-danger">*</span></label>
                            <select class="select2tujuan1 form-control border-form-control" id="pilihankecamatan_edit" name="subdistrict">
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Kode Pos <span class="required text-danger">*</span></label>
                            <input class="form-control border-form-control" name="kd_member" value="<?= !empty($user['kd_member']) ? $user['kd_member'] : "" ?>" placeholder="Masukkan Nama Anda" type="hidden" required>
                            <input class="form-control border-form-control" id="kode_pos_edit" name="kode_pos" placeholder="Kode Pos" type="number" required readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputPassword4">Alamat Lengkap<span class="required text-danger">*</span>
                            </label>
                            <textarea name="alamat" id="alamat_edit" cols="20" rows="5" class="form-control" placeholder="Masukkan Alamat Lengkap" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn d-flex w-50 text-center justify-content-center btn-outline-primary" data-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn d-flex w-50 text-center justify-content-center btn-primary">SIMPAN</button>
                </div>
            </div>
        </div>
    </div>
</form>
<form id="form_delete_alamat_utama">
    <div class="modal fade" id="delete-alamat-utama" tabindex="-1" role="dialog" aria-labelledby="delete-address" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete-address">Hapus Alamat Utama</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-0 text-black">Kamu Yakin Ingin mengahapus data Alamat ini ?</p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="kd_member_delete" name="kd_member">
                    <button type="button" class="btn d-flex w-50 text-center justify-content-center btn-outline-primary" data-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn d-flex w-50 text-center justify-content-center btn-primary">HAPUS</button>
                </div>
            </div>
        </div>
    </div>
</form>