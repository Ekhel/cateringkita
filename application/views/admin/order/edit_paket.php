<?php
if (in_array('8', $dataTampunganRole) || in_array('9', $dataTampunganRole) || $this->session->userdata('kd_role') == "reseller") {
} else {
    $this->session->set_flashdata('error', 'Tidak Bisa Akses Menu Tersebut. Bukan Bagian Anda!');
    redirect(base_url('dashboard'));
}

?>

<style type="text/css">
    #map_edit_order {
        height: 60vh;
        position: sticky;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
    }
</style>
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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $judul; ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <form id="editOrderPaket" method="POST" enctype="multipart/form-data">

            <div class="container-fluid">
                <!-- <form action="<?= base_url('Product/add_product') ?>" method="POST" enctype="multipart/form-data"> -->
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <!-- <div class="card-header">
                            <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
                        </div> -->
                            <!-- /.card-header -->
                            <!-- form start -->
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <!-- <div class="card-header">
                            <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
                        </div> -->
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="kd_order">Kode Order</label>
                                    <input type="hidden" name="map_section" class="form-control" id="map_section" value="edit_order">
                                    <input type="text" name="kd_order" class="form-control" id="kd_order" value="<?= $order_member['kd_order'] ?>" placeholder="Masukan Nama Menu" readonly>
                                </div>

                                <div class="form-group mt-2" id="select2reseller">
                                    <label for="kd_reseller">Pilih Reseller</label>
                                    <select class="form-control select2reseller" name="reseller" id="reseller1" style="width: 100%;">
                                        <?php if ($order_member['kd_reseller'] == "#") {  ?>
                                            <option value="#">Pilih Reseller</option>
                                        <?php } else {  ?>
                                            <option value="<?= $order_member['kd_reseller'] ?>"><?= $order_member['nm_reseller'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="<?= $order_member['kd_member'] == "#" ? "col-md-12 col-xs-12 col-12" : "col-md-6 col-xs-6 col-6" ?>" id="tnpmember">
                                        <div class="form-group mt-2">
                                            <label for="kd_member">Transaksi Dengan Member</label>
                                            <select name="checktnpmember" id="checktnpmember" class="form-control">
                                                <option value="ya" <?= $order_member['kd_member'] != "#" ? "selected" : "" ?>>Ya</option>
                                                <option value="tidak" <?= $order_member['kd_member'] == "#" ? "selected" : "" ?>>Tidak</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12" id="dgnmember" style="<?= $order_member['kd_member'] == "#" ? "display:none" : "" ?>;">
                                        <div class="form-group mt-2" id="memberselect2">
                                            <label for="kd_member">Pilih Member</label>
                                            <select class="form-control select2member" name="member" id="member1" style="width: 100%;" required>
                                                <?php if ($order_member['kd_member'] == "#") {  ?>
                                                    <option value="#">Pilih Member</option>
                                                <?php } else {  ?>
                                                    <option value="<?= $order_member['kd_member'] ?>"><?= $order_member['nm_member'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="newmember" style="display: none;">
                                    <div class="form-group">
                                        <label for="nm_member">Nama Member</label>
                                        <input type="text" name="nm_member" class="form-control" id="nm_member" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="nm_member">Username</label>
                                        <input type="text" name="username" class="form-control" id="username" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="jk">Jenis Kelamin</label>
                                        <select name="jk" id="jk" class="form-control">
                                            <option value="laki-laki">Laki Laki</option>
                                            <option value="perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_telp">Nomer Telepon (Whatsapp)</label>
                                        <input type="text" name="no_telp" class="form-control" id="no_telp" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" class="form-control" id="email" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea name="alamat" class="form-control" id="alamat" placeholder=""></textarea>
                                    </div>
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" name="checkboxsosmed" id="checkboxsosmed">
                                        <label for="checkboxsosmed">
                                            Add Social Media?
                                        </label>
                                    </div>
                                    <div id="socialmedia" style="display: none;">
                                        <div class="form-group">
                                            <label for="instagram">Instagram</label>
                                            <input type="text" name="instagram" class="form-control" id="instagram" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="facebook">Facebook</label>
                                            <input type="text" name="facebook" class="form-control" id="facebook" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="twitter">Twitter</label>
                                            <input type="text" name="twitter" class="form-control" id="twitter" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="jmlRecord" id="jmlRecord" value="<?= count($detail_order) ?>">
                                <input type="hidden" name="tampunganDataHapus[]" id="tampunganDataHapus">

                                <div class="form-group">
                                    <label for="">Tanggal Order</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="tgl_order" value="<?= date('Y-m-d', strtotime($order_member['tgl_order'])) ?>" id="datepickersingle" data-target="#reservationdate" required />
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="">Tanggal Pesan</label>
                                    <div class="input-group date" id="tanggal_kirim" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" name="tgl_order" value="<?= date('Y-m-d', strtotime($order_member['tgl_order'])) ?>" id="datepickersingle1" data-target="#tanggal_kirim" required />
                                        <div class="input-group-append" data-target="#tanggal_kirim" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <!-- ini untuk max pembelian -->
                            <input type="hidden" id="jmlbarang" value="10">
                            <!-- ini untuk perhitungan looping di for nya -->
                            <input type="hidden" id="jmlbarang1" value="<?= count($detail_order) ?>">
                            <!-- ini untuk index pada pertambahan -->
                            <input type="hidden" id="jmlbarangplus" value="<?= count($detail_order) ?>">
                            <!-- ini untuk index pada pengurangan -->
                            <input type="hidden" id="jmlbarangminus" value="<?= count($detail_order) ?>">
                        </div>

                    </div>

                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <!-- <div class="card-header">
                            <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
                        </div> -->
                            <div class="card-body">
                                <div class="form-group" id="detailProduk">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="hidden" name="kd_detail[]" id="kd_detail" value="<?= $detail_order[0][0]['kd_detail_order'] ?>">
                                            <label for="produk1">Nama Paket</label>
                                            <select class="form-control select2productpaket" name="eproduk[]" id="produk1" style="width: 100%;" required>
                                                <option value="<?= $detail_order[0][0]['kd_produk'] ?>"><?= $detail_order[0][0]['nama_promo'] ?></option>
                                            </select>
                                        </div>
                                        <div class="col-md-3" id="nominall">
                                            <label for="jmlkomisi1">Qty</label>
                                            <input type="text" name="eqty[]" id="qty1" class="form-control" value="<?= $detail_order[0][0]['qty'] ?>" placeholder="Masukan Nominal">
                                            <input type="hidden" name="eharga_produk[]" id="harga_produk1" class="form-control" value="<?= $detail_order[0][0]['harga_produk'] ?>" placeholder="Masukan Nominal">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="harga_produk">Sub Total</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control input-rupiah-mask" name="esub_total[]" id="sub_total1" value="<?= $detail_order[0][0]['sub_total'] ?>" placeholder="Masukan Harga Menu" readonly>
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-info btn-flat" id="detailprodukpaket1"><i class="fas fa-eye"></i> </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="kd_supplier"></label><br>
                                            <a href="javascript:void(0)" class="btn btn-success mt-2" id="tambahfieldprodukpaket"> <i class="fa fa-plus"></i> Tambah Barang</a>
                                        </div>
                                    </div>

                                    <input type="hidden" name="jml_record" id="jml_record" value="<?= count($detail_order) ?>">

                                    <?php for ($i = 1; $i < count($detail_order); $i++) { ?>
                                        <?php $j = json_decode($i); ?>
                                        <div id="bagianProdukhapus<?= ++$j ?>">
                                            <div class="row mt-3">
                                                <div class="col-md-4">
                                                    <input type="hidden" name="kd_detail[]" id="kd_detail<?= $j ?>" value="<?= $detail_order[$i][0]['kd_detail_order'] ?>">
                                                    <label for="produk1">Nama Paket</label>
                                                    <select class="form-control select2productpaket<?= $j ?>" name="eproduk[]" id="produk<?= $j ?>" style="width: 100%;" required>
                                                        <option value="<?= $detail_order[$i][0]['kd_produk'] ?>"><?= $detail_order[$i][0]['nama_promo'] ?></option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3" id="nominall">
                                                    <label for="jmlkomisi1">Qty</label>
                                                    <input type="text" name="eqty[]" id="qty<?= $j ?>" class="form-control" value="<?= $detail_order[$i][0]['qty'] ?>" placeholder="Masukan Nominal">
                                                    <input type="hidden" name="eharga_produk[]" id="harga_produk<?= $j ?>" class="form-control" value="<?= $detail_order[$i][0]['harga_produk'] ?>" placeholder="Masukan Nominal">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="harga_produk">Sub Total</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control input-rupiah-mask" name="esub_total[]" id="sub_total<?= $j ?>" value="<?= $detail_order[$i][0]['sub_total'] ?>" placeholder="Masukan Harga Menu" readonly>
                                                        <span class="input-group-append">
                                                            <button type="button" class="btn btn-info btn-flat" id="detailprodukpaket<?= $j ?>"><i class="fas fa-eye"></i> </button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <label for="kd_supplier"></label><br>
                                                    <a href="javascript:void(0)" class="btn btn-danger mt-2" id="buttonhapusprodukpakett<?= $j ?>"> <i class="fa fa-minus"></i></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="detail-produk-paket<?= $j ?>">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Detail PRoduk Paket</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>No. </th>
                                                                    <th>Nama Menu</th>
                                                                    <th>Qty</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="demo-produk-paket<?= $j ?>">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <!-- <button type="submit" class="btn btn-primary">Save</button> -->
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    <?php } ?>
                                </div>
                                <div id="bagianProduk"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <!-- <div class="card-header">
                            <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
                        </div> -->
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jenis_order">Jenis Order</label>
                                            <select name="jenis_order" id="jenis_order" class="form-control">
                                                <option <?= $order_member['jenis_order'] == "0" ? "selected" : "" ?> value="0">Reguler</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="payment_type">Metode Pembayaran</label>
                                            <select name="payment_type" id="payment_type" class="form-control">
                                                <option value="transfer" <?= $order_member['payment_type'] == "transfer" ? "selected" : "" ?>>Transfer</option>
                                                <option value="cod" <?= $order_member['payment_type'] == "cod" ? "selected" : "" ?>>COD</option>
                                                <option value="ambil_langsung" <?= $order_member['payment_type'] == "ambil_langsung" ? "selected" : "" ?>>Tunai</option>
                                                <option value="kredit" <?= $order_member['payment_type'] == "kredit" ? "selected" : "" ?>>Kredit</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" name="checkboxalamat" id="checkboxalamat" <?= $order_member['alamat_lain'] == '1' ? "checked" : "" ?>>
                                        <label for="checkboxalamat">
                                            Alamat Lain ?
                                        </label>
                                    </div>
                                </div>

                                <div id="alamatutama" style="<?= $order_member['alamat_lain'] == '1' ? "display:none;" : "" ?>">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div ccattaalass="form-group">
                                                <label for="nm_penerima_utama">Nama Penerima</label>
                                                <input type="text" name="nm_penerima_utama" value="<?= $order_member['alamat_lain'] == '0' ? $order_member['cust_name']  : "" ?>" class="form-control" id="nm_penerima_utama" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_telp_utama">Nomor Telepon</label>
                                                <input type="text" name="no_telp_utama" value="<?= $order_member['alamat_lain'] == '0' ? $order_member['cust_phone']  : "" ?>" class="form-control" id="no_telp_utama" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email_utama">Email</label>
                                                <input type="text" name="email_utama" value="<?= $order_member['alamat_lain'] == '0' ? $order_member['cust_email']  : "" ?>" class="form-control" id="email_utama" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="kecamatan_utama">kecamatan</label>
                                                <input type="text" class="form-control" value="<?= $order_member['alamat_lain'] == '0' ? $order_member['cust_subdistrict']  : "" ?>" name="kecamatan_utama" id="kecamatan_utama">
                                                <input type="hidden" class="form-control" name="jnskecamatan" id="jnskecamatan" value="<?= $order_member['alamat_lain'] == '0' ? 'utama' : 'lainnya' ?>">
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="kodepos_utama">Kode Pos</label>
                                                <input type="text" name="kodepos_utama" value="<?= $order_member['alamat_lain'] == '0' ? $order_member['cust_office']  : "" ?>" class="form-control" id="kodepos_utama" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat_utama">Alamat</label>
                                        <textarea name="alamat_utama" id="alamat_utama" class="form-control textarea" placeholder="Place some text here" rows="4"><?= $order_member['alamat_lain'] == '0' ? $order_member['cust_address']  : "" ?></textarea>
                                    </div>

                                </div>

                                <div id="alamatlain" style="<?= $order_member['alamat_lain'] == '0' ? "display:none;" : "" ?>">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div ccattaalass="form-group">
                                                <label for="nm_penerima_lain">Nama Penerima</label>
                                                <input type="text" name="nm_penerima_lain" value="<?= $order_member['alamat_lain'] == '1' ? $order_member['cust_name']  : "" ?>" class="form-control" id="nm_penerima_lain" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="no_telp_lain">Nomor Telepon</label>
                                                <input type="text" name="no_telp_lain" value="<?= $order_member['alamat_lain'] == '1' ? $order_member['cust_phone']  : "" ?>" class="form-control" id="no_telp_lain" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email_lain">Email</label>
                                                <input type="text" name="email_lain" value="<?= $order_member['alamat_lain'] == '1' ? $order_member['cust_email']  : "" ?>" class="form-control" id="email_lain" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="kecamatan_lain">kecamatan</label>
                                                <input type="text" class="form-control" value="<?= $order_member['alamat_lain'] == '1' ? $order_member['cust_subdistrict']  : "" ?>" name="kecamatan_lain" id="kecamatan_lain">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="kodepos_lain">Kode Pos</label>
                                                <input type="text" name="kodepos_lain" class="form-control" value="<?= $order_member['alamat_lain'] == '1' ? $order_member['cust_office']  : "" ?>" id="kodepos_lain" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat_lain">Alamat</label>
                                        <textarea name="alamat_lain" id="alamat_lain" class="form-control textarea" placeholder="Place some text here" rows="4"><?= $order_member['alamat_lain'] == '1' ? $order_member['cust_address']  : "" ?></textarea>
                                    </div>
                                </div>
                                <div class="row" id="ongkirKelurahan" style="<?= $order_member['payment_type'] == "ambil_langsung" ? "display:none" : "" ?>">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Cek Ongkir Berdasarkan Kelurahan</label>
                                            <input type="text" class="form-control" id="searchmap" placeholder="masukkan kelurahan">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12 test1" id="tampilanMap" style="<?= $order_member['payment_type'] == "ambil_langsung" ? "display:none" : "" ?>">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="map_edit_order"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <!-- <div class="card-header">
                            <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
                        </div> -->
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6 col-sm-12" style="display: <?= $order_member['payment_type'] == "ambil_langsung" ? "none"  : ""  ?>;">
                                        <div class="form-group">
                                            <label for="pilihan_kurir">Pilih Jenis Kurir</label>
                                            <select name="pilihan_kurir" id="pilihan_kurir" class="form-control">
                                                <option value="selera_express" <?= $order_member['pilihan_kurir'] == "selera_express" ? "selected" : "" ?>>Selera Express</option>
                                                <option value="ekpedisi_yang_lain" <?= $order_member['pilihan_kurir'] == "ekpedisi_yang_lain" ? "selected" : "" ?>>Ekspedisi Yang Lain</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="<?= $order_member['payment_type'] == "ambil_langsung" ? "col-md-12 col-sm-12" : "col-md-6 col-sm-12" ?>">
                                        <div class="form-group">
                                            <label for="ongkir_utama">Biaya Ongkir</label>
                                            <input type="hidden" name="latitude_order_lama" value="<?= $order_member['latitude_order'] ?>" class="form-control" id="latitude_order_lama" <?= $order_member['payment_type'] == "ambil_langsung" ? "readonly" : "" ?> placeholder="">
                                            <input type="hidden" name="longitude_order_lama" value="<?= $order_member['longitude_order'] ?>" class="form-control" id="longitude_order_lama" <?= $order_member['payment_type'] == "ambil_langsung" ? "readonly" : "" ?> placeholder="">
                                            <input type="hidden" name="latitude_order" class="form-control" id="latitude_order_edit" <?= $order_member['payment_type'] == "ambil_langsung" ? "readonly" : "" ?> placeholder="">
                                            <input type="hidden" name="longitude_order" class="form-control" id="longitude_order_edit" <?= $order_member['payment_type'] == "ambil_langsung" ? "readonly" : "" ?> placeholder="">
                                            <input type="hidden" name="status_ongkir" value="<?= $order_member['status_ongkir'] ?>" class="form-control input-rupiah-mask" id="status_ongkir" <?= $order_member['payment_type'] == "ambil_langsung" ? "readonly" : "" ?> placeholder="">
                                            <input type="text" name="ongkir_utama" value="<?= $order_member['ongkir'] ?>" class="form-control input-rupiah-mask" id="ongkir_utama" <?= $order_member['payment_type'] == "ambil_langsung" ? "readonly" : "" ?> placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div>
                                        <label for="diskon_tambahan">Diskon Tambahan</label>
                                        <input type="text" name="diskon_tambahan" id="diskon_tambahan" class="form-control input-rupiah-mask" value="<?= $order_member['diskon_tambahan'] ?>" placeholder="Masukan Diskon Tambahan">
                                    </div>
                                </div>

                                <div class="form-group" id="detailProduk">
                                    <div>
                                        <label for="total_harga">Total Harga</label>
                                        <input type="text" name="total_harga" id="total_harga" value="<?= $order_member['total_harga'] ?>" class="form-control rupiah-mask" placeholder="Masukan Nominal" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="catatan">Catatan Pesanan</label>
                                    <textarea name="catatan" id="catatan" class="textarea" placeholder="Place some text here" style="width: 100%; height: 10px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?= $order_member['catatan_order'] ?></textarea>
                                </div>

                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-danger">Cancel</button>
                        </div>
                    </div>

                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->

            <div class="modal fade" id="detail-produk-paket">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Detail PRoduk Paket</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No. </th>
                                        <th>Nama Menu</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody id="demo-produk-paket">

                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <!-- <button type="submit" class="btn btn-primary">Save</button> -->
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

        </form>
</div>
<!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- Modal -->
<div class="modal fade" id="setgallery" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <input class="custom-file-label" type="file" id="multiFiles" /> -->
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="multiFiles" name="gallery[]" multiple="multiple" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
                <br><br>

                <div class="gallery-images">
                    <div class="selected-image" id="selected-image_prev">
                        <div class="row" id="row_prev_gallery"></div>
                    </div>
                    <input type="hidden" name="totalimagereview" id="totalimagereview" value="0">
                </div>

                <!-- <img src="" class="mt-2" width="150px" height="150px" id="imgVieww" name="gambarBaru" alt=""> -->

            </div>
            <div class="modal-footer">
                <button type="button" id="closeModalGallery" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pilih Kecamatan Anda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select class="form-control select2tujuan" name="pilihankecamatan" id="pilihankecamatan" style="width: 100%;" required>
                    <option value="Pilih kecamatan">Pilih Kecamatan</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>