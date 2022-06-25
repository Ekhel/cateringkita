<?php
if (!$this->session->userdata('kd_member')) {
    $this->session->set_flashdata('error_page', 'Maaf, Anda Perlu login terlebih dahulu.');
    redirect(base_url('main'));
}
?>
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
                            <input type="hidden" name="checkout_page" value="0">
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
                            <label class="control-label">Nama Lengkap <span class="required text-danger">*</span></label>
                            <input type="hidden" name="checkout_page" value="0">
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
                    <input type="hidden" name="checkout_page" value="0">
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
<div class="modal fade" id="detailModalKhusus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="special-box">
                                        <div class="heading-area">
                                            <h4 class="title">
                                                Detail Pesanan
                                            </h4>
                                        </div>
                                        <div class="table-responsive-sm">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <table class="table">
                                                        <tbody id="detail_order_kurir_1">

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-lg-6">
                                                    <table class="table">
                                                        <tbody id="detail_order_kurir_2">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-lg-12">
                                        <div class="special-box">
                                            <div class="heading-area">
                                                <h4 class="title">
                                                    Penerima Order
                                                </h4>
                                            </div>
                                            <div class="table-responsive-sm">
                                                <table class="table">
                                                    <tbody id="detail_order_kurir_3">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-lg-12">
                                        <div class="special-box">
                                            <div class="heading-area">
                                                <h4 class="title">
                                                    Detail Pesanan
                                                </h4>
                                            </div>
                                            <div class="table-responsive-sm">
                                                <table class="table">
                                                    <tbody id="detail_order_kurir_4">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="special-box">
                                                <div class="heading-area">
                                                    <h4 class="title">
                                                        Produk Yang Di Order
                                                    </h4>
                                                </div>
                                                <br>
                                                <div class="table-responsive-sm">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th width="10%">Nomor</th>
                                                                <th class="text-center">Nama Menu</th>
                                                                <th class="text-center">Tanggal Kirim</th>
                                                                <th class="text-center">Qty</th>
                                                                <th class="text-center">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="detail_order_kurir_5" class="text-center">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pesanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="special-box">
                                        <div class="heading-area">
                                            <h4 class="title">
                                                Detail Pesanan
                                            </h4>
                                        </div>
                                        <div class="table-responsive-sm">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <table class="table">
                                                        <tbody id="detail_order_kurir_1">

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-lg-6">
                                                    <table class="table">
                                                        <tbody id="detail_order_kurir_2">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-lg-12">
                                        <div class="special-box">
                                            <div class="heading-area">
                                                <h4 class="title">
                                                    Penerima Order
                                                </h4>
                                            </div>
                                            <div class="table-responsive-sm">
                                                <table class="table">
                                                    <tbody id="detail_order_kurir_3">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-lg-12">
                                        <div class="special-box">
                                            <div class="heading-area">
                                                <h4 class="title">
                                                    Detail Pesanan
                                                </h4>
                                            </div>
                                            <div class="table-responsive-sm">
                                                <table class="table">
                                                    <tbody id="detail_order_kurir_4">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="special-box">
                                                <div class="heading-area">
                                                    <h4 class="title">
                                                        Produk Yang Di Order
                                                    </h4>
                                                </div>
                                                <br>
                                                <div class="table-responsive-sm">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th width="10%">Nomor</th>
                                                                <th class="text-center">Nama Menu</th>
                                                                <th class="text-center">Harga Menu</th>
                                                                <th class="text-center">Qty</th>
                                                                <th class="text-center">Sub Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="detail_order_kurir_5" class="text-center">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
            </div>

        </div>
    </div>
</div>
<section class="py-5 account-page bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="osahan-account-page-left overflow-hidden shadow-sm rounded bg-white h-100">
                    <div class="p-4">
                        <div class="osahan-user text-center">
                            <div class="osahan-user-media">
                                <img class="mb-3 rounded-pill shadow-sm mt-1" src="<?= base_url('assets/images/user/' . $user['image']) ?>" alt="gurdeep singh osahan">
                                <div class="osahan-user-media-body">
                                    <h6 class="mb-2 font-weight-bold"><?= ucfirst($user['nm_member']) ?></h6>
                                    <p class="mb-1"><?= $user['no_telp'] ?></p>
                                    <p><?= !empty($user['email']) ? $user['email'] : "-" ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs flex-column border-0" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="my-profile-tab" data-toggle="tab" href="#my-profile" role="tab" aria-controls="my-profile" aria-selected="true"><i class="icofont-ui-user"></i> Profil Saya</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="my-address-tab" data-toggle="tab" href="#my-address" role="tab" aria-controls="my-address" aria-selected="false"><i class="icofont-location-pin"></i> Alamat Saya</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false"><i class="icofont-key"></i> Ubah Password</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="order-list-tab" data-toggle="tab" href="#order-list" role="tab" aria-controls="order-list" aria-selected="false"><i class="icofont-list"></i> Daftar Pesanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="order-status-tab" data-toggle="tab" href="#order-status" role="tab" aria-controls="order-status" aria-selected="false"><i class="icofont-list"></i> Daftar Pesanan Khusus</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tombol_logout" href="<?= base_url('main/logout_pelanggan') ?>"><i class="icofont-logout"></i> Keluar</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="osahan-account-page-right rounded shadow-sm bg-white p-4 h-100">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="my-profile" role="tabpanel" aria-labelledby="my-profile-tab">
                            <h4 class="text-dark mt-0 mb-4">Profil Saya</h4>
                            <form action="<?= base_url('catering/edit_profile_act') ?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="control-label">Nama <span class="required">*</span></label>
                                    <input class="form-control border-form-control" name="nm_member" value="<?= !empty($user['nm_member']) ? $user['nm_member'] : "" ?>" placeholder="Masukkan Nama Anda" type="text" required>
                                    <input class="form-control border-form-control" name="kd_member" value="<?= !empty($user['kd_member']) ? $user['kd_member'] : "" ?>" placeholder="Masukkan Nama Anda" type="hidden" required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Jenis Kelamin <span class="required">*</span></label>
                                    <select name="jk" id="jk" class="form-control" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="laki-laki" <?= $user['jenis_kelamin'] == "laki-laki" ? "selected" : ""; ?>>Laki - Laki</option>
                                        <option value="perempuan" <?= $user['jenis_kelamin'] == "perempuan" ? "selected" : ""; ?>>Perempuan</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Nomer Telepon <span class="required">*</span></label>
                                    <input class="form-control border-form-control" name="no_telp" value="<?= !empty($user['no_telp']) ? $user['no_telp'] : "" ?>" placeholder="Masukkan Nomer Telepon" type="text" required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label"> Email </label>
                                    <input class="form-control border-form-control" name="email" value="<?= !empty($user['email']) ? $user['email'] : "" ?>" placeholder="Masukkan Email" type="text">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Foto</label>
                                    <input type="file" class="form-control" name="userfile" id="recipient-name" placeholder="Masukkan Foto">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary"> Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="my-address" role="tabpanel" aria-labelledby="my-address-tab">
                            <h4 class="text-dark mt-0 mb-4">Alamat Saya</h4>
                            <h6 class="text-dark">Alamat Utama</h6>
                            <div class="row">
                                <div class="col-md-6" style="<?= empty($user['alamat']) ? 'display: none;' : '' ?>" id="bagianalamatutama">
                                    <div class="bg-white card addresses-item mb-3 shadow-sm">
                                        <div class="gold-members p-3">
                                            <div class="media">
                                                <div class="media-body">
                                                    <span class="badge badge-danger">Rumah <?= ucfirst($user['nm_member']) ?> </span>
                                                    <h6 class="mb-3 mt-3 text-dark"><?= ucfirst($user['nm_member']) ?></h6>
                                                    <p id="txt_alamat"><?= ucfirst(strip_tags(decrypt($user['alamat']))) ?>
                                                    </p>
                                                    <?php $kec = $this->db->get_where('kecamatan', ['id' => $user['kd_subdistricts']])->row_array() ?>
                                                    <p id="txt_kecamatan">
                                                        <?php if (!empty($kec['id'])) { ?>
                                                            <?= $kec['provinsi'] . "," . $kec['kabupaten'] . ", " . $kec['kecamatan'] . ", " . $kec['kelurahan'] ?>
                                                        <?php } ?>
                                                    </p>
                                                    <p class="text-secondary" id="txt_kodepos"> <span class="text-dark">
                                                            <?php if (!empty($kec['id'])) { ?>
                                                                <?= $kec['kodepos'] ?>
                                                            <?php } ?></span>
                                                    </p>
                                                    <hr>
                                                    <p class="mb-0 text-black">
                                                        <a class="text-success mr-3" data-toggle="modal" data-target="#edit-alamat-utama" href="javascript:void(0)" data-id="<?= $user['kd_member'] ?>" id="edit_alamat_utama"><i class="icofont-ui-edit"></i> UBAH</a>
                                                        <a class="text-danger" data-toggle="modal" data-target="#delete-alamat-utama" href="javascript:void(0)" data-id="<?= $user['kd_member'] ?>" id="delete_alamat_utama"><i class="icofont-ui-delete"></i> HAPUS</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 pb-4" style="<?= empty($user['alamat']) ? '' : 'display: none;' ?>" id="bagiantambahalamatutama">
                                    <a data-toggle="modal" data-target="#edit-alamat-utama" href="#">
                                        <div class="bg-light border rounded  mb-3  shadow-sm text-center h-100 d-flex align-items-center">
                                            <h6 class="text-center m-0 w-100"><i class="icofont-plus-circle icofont-3x mb-5"></i><br><br>Tambah Alamat Utama</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <h6 class="text-dark">Alamat Lain</h6>
                            <div class="row" id="bagian_alamat_lain">
                                <?php $alamat_lain = $this->db->get_where('detail_alamat', ['kd_member' => $user['kd_member']])->result_array();
                                $no = 0; ?>
                                <?php if (count($alamat_lain) > 0) { ?>
                                    <?php foreach ($alamat_lain as $a) {
                                        $no++; ?>
                                        <?php $kec = $this->db->get_where('kecamatan', ['id' => $a['subdistricts_']])->row_array(); ?>
                                        <div class="col-md-6">
                                            <div class="bg-white card addresses-item mb-3  shadow-sm">
                                                <div class="gold-members p-3">
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <span class="badge badge-danger"><?= ucfirst($a['nm_member_']) ?> - <?= $a['lokasi_'] ?></span>
                                                            <h6 class="mb-3 mt-3 text-dark"><?= ucfirst($a['nm_member_']) ?></h6>
                                                            <p><?= ucfirst(strip_tags($a['alamat'])) ?>
                                                            </p>
                                                            <p> <?= $kec['provinsi'] . "," . $kec['kabupaten'] . ", " . $kec['kecamatan'] . ", " . $kec['kelurahan'] ?>
                                                            </p>
                                                            <p class="text-secondary" id="txt_kodepos_lain"><span class="text-dark">
                                                                    <?= $kec['kodepos'] ?>
                                                            </p>
                                                            <hr>
                                                            <p class="mb-0 text-black">
                                                                <a class="text-success mr-3 edit_alamat_lain" data-toggle="modal" data-target="#edit-alamat-lain" href="javascript:void(0)" data-id="<?= $a['kd_detail_alamat'] ?>"><i class="icofont-ui-edit"></i> UBAH</a>
                                                                <a class="text-danger delete_alamat_lain" data-toggle="modal" data-target="#delete-alamat_lain" href="javascript:void(0)" data-id="<?= $a['kd_detail_alamat'] ?>"><i class="icofont-ui-delete"></i> HAPUS</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                <div class="col-md-6 pb-4">
                                    <a data-toggle="modal" data-target="#add-alamat-lain" href="#">
                                        <div class="bg-light border rounded  mb-3  shadow-sm text-center h-100 d-flex align-items-center">
                                            <h6 class="text-center m-0 w-100"><i class="icofont-plus-circle icofont-3x mb-5"></i><br><br>Tambah Alamat Lain</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <h4 class="text-dark mt-0 mb-4">Ubah Password</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?= base_url('catering/password_act') ?>" method="post" enctype="multipart/form-data">
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
                        </div>
                        <div class="tab-pane fade" id="order-list" role="tabpanel" aria-labelledby="order-list-tab">
                            <h4 class="text-dark mt-0 mb-4">Daftar Pesanan</h4>
                            <div class="order-list-tabel-main table-responsive">
                                <table class="table table-hover text-nowrap table-striped table-bordered" id="order_pelanggan" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Kode Order</th>
                                            <th>Nama Pembeli</th>
                                            <th>Nomor Telepon</th>
                                            <th>Total</th>
                                            <th>Status Pesanan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="order-status" role="tabpanel" aria-labelledby="order-status-tab">
                            <h4 class="text-dark mt-0 mb-4">Daftar Pesanan Khusus</h4>
                            <div class="order-list-tabel-main table-responsive">
                                <table class="table table-hover text-nowrap table-striped table-bordered" id="order_pelanggan_khusus" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Kode Order</th>
                                            <th>Nama Pembeli</th>
                                            <th>Nomor Telepon</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>