<?php

$this->session->unset_userdata('ongkir');
$this->session->unset_userdata('searchmap');
$this->session->unset_userdata('jarak');

$count = count($this->cart->contents());
if ($count == 0) {
    $this->session->set_flashdata('error_page', 'Maaf, Keranjang Anda Kosong. Tidak Bisa Akses Halaman Tersebut.');
    redirect(base_url('main'));
}
?>

<style type="text/css">
    #map {
        height: 40vh;
        position: sticky;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
    }

    #edit_map {
        height: 40vh;
        position: sticky;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
    }

    .leaflet-right {
        right: 0;
        display: none;
    }

    .dropdown-menu ul li {
        list-style-type: none;
    }

    .mytooltip {
        display: inline;
        position: relative;
        z-index: 999
    }

    .mytooltip .tooltip-item {
        cursor: pointer;
        display: inline-block;
    }

    .mytooltip .tooltip-content {
        position: absolute;
        z-index: 9999;
        width: 360px;
        left: 50%;
        margin: 0 0 20px -180px;
        bottom: 100%;
        text-align: left;
        font-size: 14px;
        line-height: 30px;
        -webkit-box-shadow: -5px -5px 15px rgba(48, 54, 61, 0.2);
        box-shadow: -5px -5px 15px rgba(48, 54, 61, 0.2);
        background: #2b2b2b;
        opacity: 0;
        cursor: default;
        pointer-events: none
    }

    .mytooltip .tooltip-content::after {
        content: '';
        top: 100%;
        left: 50%;
        border: solid transparent;
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-color: #2a3035 transparent transparent;
        border-width: 10px;
        margin-left: -10px
    }

    .mytooltip:hover .tooltip-item::after {
        pointer-events: auto
    }

    .mytooltip:hover .tooltip-content {
        pointer-events: auto;
        opacity: 1;
        -webkit-transform: translate3d(0, 0, 0) rotate3d(0, 0, 0, 0deg);
        transform: translate3d(0, 0, 0) rotate3d(0, 0, 0, 0deg)
    }

    .mytooltip .tooltip-text {
        font-size: 14px;
        line-height: 24px;
        display: block;
        padding: 1.31em 1.21em 1.21em 0;
        color: #fff
    }

    .tooltip-effect-5 .tooltip-text {
        padding: 1.4em
    }

    .tooltip-effect-5 .tooltip-content {
        width: 360px;
        margin-left: -180px;
        -webkit-transform-origin: 50% calc(106%);
        transform-origin: 50% calc(106%);
        -webkit-transform: rotate3d(0, 0, 1, 15deg);
        transform: rotate3d(0, 0, 1, 15deg);
        -webkit-transition: opacity 0.2s, -webkit-transform 0.2s;
        transition: opacity 0.2s, -webkit-transform 0.2s;
        transition: opacity 0.2s, transform 0.2s;
        transition: opacity 0.2s, transform 0.2s, -webkit-transform 0.2s;
        -webkit-transition-timing-function: ease, cubic-bezier(0.17, 0.67, 0.4, 1.39);
        transition-timing-function: ease, cubic-bezier(0.17, 0.67, 0.4, 1.39)
    }
</style>
<section id="bagian_modal_checkout">
    <?php $this->load->view('catering/modal_checkout') ?>
</section>
<section class="py-2  inner-header">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-12">
                <div class="breadcrumbs">
                    <p class="mb-0"><a href="<?= base_url('main') ?>"><span class="icofont icofont-ui-home"></span> Home</a> <span class="icofont icofont-thin-right"></span> <a href="#"><?= $judul ?></a> <span class="icofont icofont-thin-right"></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="checkout-body py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="checkout-body-left">
                    <div class="accordion checkout-step" id="accordionExample">
                        <div class="bg-white rounded shadow-sm mb-3 overflow-hidden">
                            <div class="card-header bg-white" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <i class="icofont-simple-down float-right mt-1"></i>
                                        1. Data Pembeli
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse <?= !empty($this->session->userdata('nama')) ? "" : "show" ?>" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <?php if ($this->session->userdata('kd_member')) { ?>
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
                                    <?php } else { ?>
                                        <div class="row" id="bagian_alamat_checkout">
                                            <?php $this->load->view('catering/alamat_checkout') ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <!-- <div class="card-footer bg-white">
                                    <h2 class=" float-right">
                                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                                            <i class="icofont-simple-right float-right mt-1"></i>
                                            Lanjut
                                        </button>
                                    </h2>
                                </div> -->
                            </div>
                        </div>
                        <div class="bg-white rounded shadow-sm mb-3 overflow-hidden">
                            <div class="card-header bg-white" id="headingfour">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
                                        <i class="icofont-simple-down float-right mt-1"></i> 2. Pembayaran
                                    </button>
                                </h2>
                            </div>
                            <div id="collapsefour" class="collapse <?= !empty($this->session->userdata('nama')) ? "show" : "" ?>" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <form action="<?= base_url('catering/add_pemesanan') ?>" method="POST" autocomplete="off">
                                    <div class="card-body osahan-payment">
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
                                    <h2 class="text-center mb-0">
                                        <span class="mytooltip tooltip-effect-5">
                                            <button class="btn btn-primary btn-block btn-lg tooltip-item" type="submit">
                                                <i class="icofont-simple-right float-right mt-1"></i>
                                                Lakukan Pemesanan
                                            </button>
                                        </span>
                                    </h2>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" id="bagian_keranjang_checkout">
                <?php $this->load->view('catering/keranjang_checkout') ?>
            </div>
        </div>
    </div>
</section>