<section id="bagian_modal_checkout">
    <?php $this->load->view('catering/modal_checkout') ?>
</section>
<section class="py-5 account-page bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <form action="<?= base_url('catering/add_member_act') ?>" method="post" enctype="multipart/form-data"> -->
                            <div class="card-header">
                                <div class="p-4">
                                    <div class="osahan-user text-center">
                                        <h4 class="text-dark mt-0 mb-0" style="font-weight: bold;">Tambah Pesanan Bulanan</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12">
                                        <div class="shop-head mb-3">
                                            <h5 class="mb-1 text-dark text-center" style="font-weight: bold;">Daftar Menu</h5>
                                        </div>
                                        <?php
                                        $kat1 = $this->db->get_where('kategori', ['nm_kategori' => "Paket Khusus"])->row_array();
                                        $this->db->select('*');
                                        $this->db->from('produk');
                                        $this->db->where(['kd_kategori' => $kat1['kd_kategori']]);
                                        $this->db->where(['is_produk_hapus' => 1]);
                                        $data = $this->db->get();
                                        if ($data->num_rows() > 0) { ?>
                                            <div class="row">
                                                <?php foreach ($data->result() as $row) { ?>
                                                    <div class="col-6 col-md-3">
                                                        <div class="card list-item bg-white rounded overflow-hidden position-relative shadow-sm">
                                                            <a href="javascript:void(0)">

                                                                <img src="<?= base_url('assets/images/gallery_produk/' . $row->foto_produk) ?>" class="card-img-top" alt="..."></a>
                                                            <div class="card-body">
                                                                <h6 class="card-title mb-1"><?= ucfirst($row->nm_produk) ?></h6>
                                                                <p class="mb-0 text-dark"><?= format_rupiah($row->harga) ?>/pax <span class="text-black-50"> </span></p>
                                                                <?php if ($row->deskripsi != "") { ?>
                                                                    <hr>
                                                                    <p class="mb-0 text-dark"><b>Deskripsi</b> : <span class="text-black-50"> </span></p>
                                                                    <p class="mb-0 text-dark"><?= $row->deskripsi ?> <span class="text-black-50"> </span></p>
                                                                <?php } ?>
                                                                <hr>
                                                                <a href="javascript:void(0)" class="btn btn-outline-primary mt-2 btn-block add_to_cart_mingguan" data-id="<?= $row->kd_produk ?>" data-harga="<?= $row->harga ?>" data-nama="<?= $row->nm_produk ?>">Pilih</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                        <div id="load_data_message" class="row"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" id="bagian_data_alamat" style="display: none;">
                                <div class="shop-head mb-3">
                                    <h5 class="mb-1 text-dark text-center" style="font-weight: bold;">Data Pembeli</h5>
                                </div>
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
                                                        <button data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour" type="button" class="btn <?= empty($this->session->userdata('alamat_pengiriman')) || $this->session->userdata('alamat_pengiriman') == "alamat_utama" ? "btn-primary" : "btn-outline-primary" ?> btn-block selected_alamat_utama">PENGIRIMAN DISINI</button>
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
                                                                <button data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour" type="button" class="btn <?= !empty($this->session->userdata('alamat_pengiriman')) && $this->session->userdata('alamat_pengiriman') != "alamat_utama" ? "btn-primary" : "btn-outline-primary" ?> btn-block collapsed selected_alamat_lain" data-id="<?= $a['kd_detail_alamat'] ?>">PENGIRIMAN DISINI</button>
                                                                <hr>
                                                                <p class=" mb-0 text-black">
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
                            <div class="card-body" id="bagian_data_pesanan" style="display: none;">
                                <form action="<?= base_url('catering/add_pemesanan_bulanan') ?>" method="POST" autocomplete="off">
                                    <div class="shop-head mb-3">
                                        <h5 class="mb-1 text-dark text-center" style="font-weight: bold;">Data Detail Pemesanan</h5>
                                    </div>
                                    <input type="hidden" class="form-control" name="order_type" id="order_type" value="bulanan" required />
                                    <input type="hidden" class="form-control" name="total_hari" id="total_hari" value="30" required />
                                    <input type="hidden" class="form-control" name="kd_produk" id="kd_produk" required />
                                    <input type="hidden" class="form-control" name="nm_produk" id="nm_produk" required />
                                    <input type="hidden" class="form-control" name="harga_produk" id="harga_produk" required />
                                    <div class="card-body osahan-payment">
                                        <div class="form-group">
                                            <label for="">Jumlah Orang <span class="required text-danger">*</span></label>
                                            <input type="text" onkeypress="return hanyaAngka(event)" class="form-control" placeholder="Masukkan jumlah orang" name="qty" id="qty_orang" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="">Tanggal Kirim <span class="required text-danger">*</span></label>
                                            <div class="input-group date" id="tanggal_kirim" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input" name="tgl_kirim" id="datepickersingle1" data-target="#tanggal_kirim" required />
                                                <div class="input-group-append" data-target="#tanggal_kirim" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="payment_type">Metode Pembayaran</label>
                                            <select name="payment_type" id="payment_type_checkout" class="form-control">
                                                <option value="transfer">Transfer</option>
                                                <option value="ambil_langsung">Tunai</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputPassword4">Catatan Pemesanan</label>
                                            <!-- <input type="text" name="catatan" class="form-control"> -->
                                            <textarea name="catatan" class="form-control textarea" id="catatan" placeholder="Masukkan Catatan Pemesanan"></textarea>
                                        </div>

                                    </div>
                                    <div class="shop-head mb-3">
                                        <h5 class="mb-1 text-dark text-center" style="font-weight: bold;">Total Harga</h5>
                                    </div>
                                    <div class="card-body osahan-payment">
                                        <p class="mb-1">Harga Menu <span class="float-right text-dark" id="txt_harga_menu">0</span></p>
                                        <p class="mb-1">Total Hari <span class="float-right text-dark" id="txt_total_hari">30</span></p>
                                        <p class="mb-1">Jumlah Orang <span class="float-right text-dark" id="txt_jumlah_orang">0</span></p>
                                        <hr />
                                        <h6 class="font-weight-bold text-danger mb-0">Total Pembayaran
                                            <span class="float-right" id="total_bayar_txt">0</span>
                                        </h6>
                                    </div>
                                    <h2 class="text-center mb-0">
                                        <span class="mytooltip tooltip-effect-5">
                                            <button class="btn btn-primary btn-block btn-lg tooltip-item" id="button_submit" type="submit" disabled>
                                                <i class="icofont-simple-right float-right mt-1"></i>
                                                Lakukan Pemesanan
                                            </button>
                                        </span>
                                    </h2>
                                </form>
                            </div>
                            <!-- </form> -->
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>