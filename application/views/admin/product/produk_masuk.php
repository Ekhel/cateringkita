<?php
if (in_array('1', $dataTampunganRole)) {
} else {
    $this->session->set_flashdata('error', 'Tidak Bisa Akses Menu Tersebut. Bukan Bagian Anda!');
    redirect(base_url('dashboard'));
}
?>

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
                <div class="col-12">
                    <div class="card">
                        <!-- <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div> -->
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <!-- <div class="col-md-12">
                                <h1>
                                    <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Tambah Menu Masuk</a>
                                </h1>
                            </div>
                            <br> -->
                            <table class="table table-hover text-nowrap table-striped table-bordered" id="mytableProductMasuk" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Supplier</th>
                                        <th>Nominal Bayar</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Status Pembayaran</th>
                                        <th>Bukti Pembayaran</th>
                                        <th style="text-align: right;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- MODAL ADD -->
<!-- <form id="addProdukMasuk">
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Menu Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="supplier">Supplier</label>
                            <select name="supplier" id="supplier" class="form-control select2supplier">
                                <option value="Pilih Supplier">Pilih Supplier</option>
                            </select>
                        </div>
                        <div class="col-md-4" id="produkk">
                            <label for="produk1">Nama Menu</label>
                            <select class="form-control select2produksup" name="produk" id="produk1" style="width: 100%;" required>
                                <option value="Pilih produk">Pilih Produk</option>
                            </select>
                        </div>
                        <div class="col-md-4" id="jnsprodukk">
                            <label for="jenis_produk1">Jenis Produk</label>
                            <select class="form-control select2jnsproduk1" name="jenis_produk" id="jenis_produk1" style="width: 100%;" required>
                                <option value="Pilih produk">Pilih Jenis Produk</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jml_ukuran">Harga Modal</label>
                                <input type="text" class="form-control input-rupiah-mask" name="harga_modal[]" id="harga_modal1" placeholder="Masukan Harga Modal">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="harga_produk">Harga Menu</label>
                                <input type="text" class="form-control input-rupiah-mask" name="harga_produk[]" id="harga_produk1" placeholder="Masukan Harga Menu">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Stok Masuk</label>
                                <input type="number" name="stok_masuk" id="stok_masuk" class="form-control" min="1" max="1000" placeholder="Stok Masuk">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="kd_supplier"></label><br>
                            <button class="btn btn-success mt-2"><i class="fa fa-plus"></i> </button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_save" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</form> -->
<!--END MODAL ADD-->

<!-- MODAL EDIT -->
<form id="editProdukMasuk">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Produk Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Tanggal Produk Masuk</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" name="tgl_produk_masuk" id="tanggal_produk_masuk" data-target="#reservationdate" required />
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="supplier">Supplier</label>
                        <select name="supplier" id="supplier_edit" class="form-control select2supplier">
                            <option value="Pilih Supplier">Pilih Supplier</option>
                            <?php foreach ($supplier as $s) { ?>
                                <option value="<?= $s['kd_supplier'] ?>"><?= $s['nm_supplier'] . ' - ' . $s['contact_person'] . ' - ' . $s['no_telp'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div id="showbagianprodukmasuk">
                    </div>
                    <div id="bagianProdukMasuk">
                    </div>
                    <div class="row" style="margin-top: -30px;">
                        <div class="col-md-12 col-12 col-sm-12">
                            <label></label><br>
                            <a href="javascript:void(0)" class="btn btn-success btn-block" id="tambahfieldprodukmasuk"><i class="fa fa-plus"></i> </a>
                        </div>
                    </div>
                    <input type="hidden" id="jmlbarang" value="10">
                    <!-- ini untuk perhitungan looping di for nya -->
                    <input type="hidden" id="jmlbarang1" value="1">
                    <!-- ini untuk index pada pertambahan -->
                    <input type="hidden" id="jmlbarangplus" value="1">
                    <!-- ini untuk index pada pengurangan -->
                    <input type="hidden" id="jmlbarangminus" value="1">

                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 mt-2">
                            <div class="form-group">
                                <label>Nominal Bayar</label>
                                <input type="text" name="nominal_bayar" id="nominal_bayar" class="form-control input-rupiah-mask" placeholder="Masukkan Nominal Bayar" required>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" name="checkboxbayarnanti" id="checkboxbayarnanti1">
                                <label for="checkboxbayarnanti1">
                                    Bayar Nanti ?
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row bagian-pembayaran">
                        <div class="col-12 col-sm-12 col-md-12 mt-2" id="bagian-metode-pembayaran">
                            <div class="form-group">
                                <label for="metode_pembayaran">Metode Pembayaran</label>
                                <select name="metode_pembayaran" id="metode_pembayaran1" class="form-control" required>
                                    <option value="">Pilih Metode Pembayaran</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="tunai">Tunai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6 mt-2 bagian-bukti-pembayaran" style="display: none;">
                            <div class="form-group">
                                <label>Bukti Pembayaran <small style="color: grey;">*Bisa kosongkan</small></label>
                                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran1" class="form-control">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_save" class="btn btn-primary">Save</button>
                </div>

                <div id="modal-detail">

                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->

<div id="Modal_Detail_ProdukMasuk" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Produk Masuk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-hover text-nowrap table-striped table-bordered" id="mytableDetailProductMasuk" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Nama Menu</th>
                            <th>Stok Masuk</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<div id="lihatbukti" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Display Bukti</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div id="bagian_embed">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>

<!--MODAL DELETE-->
<form id="hapusProdukMasuk">
    <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Produk Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Are you sure to delete this record?</strong>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="produk_masuk" id="kd_produk_masuk_delete" class="form-control">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->

<!--MODAL Stok Keluar-->
<form id="AddStokKeluar" autocomplete="off">
    <div class="modal fade" id="Modal_Stok_keluar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Stok Keluar Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Produk</label>
                        <input type="hidden" name="kd_produk_masuk" id="kd_produk_masuk_edit1" class="form-control" placeholder="Stok Masuk">
                        <input type="hidden" name="kd_detail_produk" id="kd_detail_produk_edit1" class="form-control" placeholder="Stok Masuk">
                        <input type="text" name="detail_produk" id="detail_produk_edit1" class="form-control" placeholder="Produk" readonly required>
                    </div>
                    <div class="form-group">
                        <label>Stok Masuk</label>
                        <input type="text" name="stok_produk" id="stok_produk_edit1" class="form-control" placeholder="Produk" readonly required>
                        <input type="hidden" id="stok_produk_edit2" class="form-control" placeholder="Produk" readonly required>
                    </div>
                    <div class="form-group">
                        <label>Lokasi Keluar</label>
                        <?php $admin = $this->db->get_where('admin', ['kd_admin' => $this->session->userdata('kd_admin')])->row_array(); ?>
                        <input type="text" name="lokasi" id="lokasi_edit1" value="<?= $admin['toko'] == "tsp" ? "BRP" : "TSP" ?>" class="form-control" placeholder="Lokasi Stok" readonly required>
                    </div>
                    <div class="form-group">
                        <label>Stok Keluar</label>
                        <input type="text" name="stok_keluar" id="stok_keluar_edit1" class="form-control" placeholder="Stok Keluar" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_save_stok" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL Stok Keluar-->
<!-- <div class="modal fade" id="setperhitunganharga" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kalkulasi Detail Harga</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-4">
                        <label for="hrg_modal1">Harga Modal</label>
                        <input type="text" name="hrg_modal[]" id="hrg_modal1" class="form-control rupiah-mask" placeholder="Masukan Harga Modal" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="biaya_lainnya1">Biaya Lainnya</label>
                        <input type="text" name="biaya_lainnya[]" id="biaya_lainnya1" class="form-control input-rupiah-mask" placeholder="Masukan Biaya Lainnya">
                    </div>
                    <div class="col-md-4">
                        <label for="ttl_hrg_modal1">Total Harga Modal</label>
                        <input type="text" name="ttl_hrg_modal[]" id="ttl_hrg_modal1" class="form-control rupiah-mask" placeholder="Masukan Harga Modal" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <label for="margin1">Margin Produk</label>
                        <input type="text" name="margin[]" id="margin1" class="form-control" placeholder="Masukan Margin dalam Persen">
                    </div>
                    <div class="col-md-3">
                        <label for="hasil_margin1">Hasil Margin</label>
                        <input type="text" name="hasil_margin[]" id="hasil_margin1" class="form-control input-rupiah-mask" placeholder="Masukan Biaya Lainnya" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="harga_jual1">Harga Jual</label>
                        <input type="text" name="harga_jual[]" id="harga_jual1" class="form-control rupiah-mask" placeholder="Masukan Harga Modal" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="harga_jual1">Harga Jual (Pembulatan)</label>
                        <input type="text" name="pembulatan_harga_jual[]" id="pembulatan_harga_jual1" class="form-control rupiah-mask" placeholder="Masukan Harga Modal" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="harga_competitor1">Harga Kompetitor</label>
                        <input type="text" name="harga_competitor[]" id="harga_competitor1" class="form-control input-rupiah-mask" placeholder="Masukan Biaya Lainnya">
                    </div>
                    <div class="col-md-6">
                        <label for="selisih_harga1">Selisih Harga</label>
                        <input type="text" name="selisih_harga[]" id="selisih_harga1" class="form-control rupiah-mask" placeholder="Masukan Harga Modal" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="margin1001">Margin 100%</label>
                        <input type="text" name="margin100[]" id="margin1001" class="form-control rupiah-mask" placeholder="Masukan Margin" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="margin701">Margin 70% Selera</label>
                        <input type="text" name="margin70[]" id="margin701" class="form-control rupiah-mask" placeholder="Masukan Biaya Lainnya" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="margin301">Margin 30% Reseller</label>
                        <input type="text" name="margin30[]" id="margin301" class="form-control rupiah-mask" placeholder="Masukan Harga Modal" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <label for="insentif1">Insentif 6%</label>
                        <input type="text" name="insentif[]" id="insentif1" class="form-control rupiah-mask" placeholder="Masukan Margin" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="hasil_insentif1">Hasil Harga Insentif</label>
                        <input type="text" name="hasil_insentif[]" id="hasil_insentif1" class="form-control rupiah-mask" placeholder="Masukan Harga Modal" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="harga_jual_reseller1">Harga Jual Reseller (Pembulatan)</label>
                        <input type="text" name="harga_jual_reseller[]" id="harga_jual_reseller1" class="form-control rupiah-mask" placeholder="Masukan Biaya Lainnya" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="selisih_harga_jual1">Selisih Harga Jual</label>
                        <input type="text" name="selisih_harga_jual[]" id="selisih_harga_jual1" class="form-control rupiah-mask" placeholder="Masukan Biaya Lainnya" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="kelebihan_bagi_hasil1">Kelebihan Margin Ujroh</label>
                        <input type="text" name="kelebihan_bagi_hasil[]" id="kelebihan_bagi_hasil1" class="form-control rupiah-mask" placeholder="Masukan Harga Modal" readonly>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="hrg_competitor1">Harga Kompetitor</label>
                        <input type="text" name="hrg_competitor[]" id="hrg_competitor1" class="form-control rupiah-mask" placeholder="Masukan Margin" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="hrg_jual_umum1">Harga Jual Umum</label>
                        <input type="text" name="hrg_jual_umum[]" id="hrg_jual_umum1" class="form-control rupiah-mask" placeholder="Masukan Biaya Lainnya" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="hrg_jual_reseller1">Harga Jual Reseller</label>
                        <input type="text" name="hrg_jual_reseller[]" id="hrg_jual_reseller1" class="form-control rupiah-mask" placeholder="Masukan Harga Modal" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div> -->