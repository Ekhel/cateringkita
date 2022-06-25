<?php
if (in_array('1', $dataTampunganRole)) {
} else {
    $this->session->set_flashdata('error', 'Tidak Bisa Akses Menu Tersebut. Bukan Bagian Anda!');
    redirect(base_url('dashboard'));
}
?>

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
        <div class="container-fluid">
            <form id="addProdukMasuk" method="POST" enctype="multipart/form-data" autocomplete="off">
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
                            <div class="card-body">
                                <!-- <a href="<?= base_url('product/upload_excel') ?>" class="btn btn-success"><span class="fa fa-upload"></span> Upload Data Excel</a><br><br> -->
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12">
                                        <label for="">Tanggal Produk Masuk</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" name="tgl_produk_masuk" id="datepickersingle" data-target="#reservationdate" required />
                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" id="detailProduk">
                                    <div class="col-12 col-sm-12 col-md-12 mt-2">
                                        <label for="supplier">Supplier</label>
                                        <select class="form-control select2supplier" name="supplier" style="width: 100%;" id="supplier" required>
                                            <option value="">Pilih Supplier</option>
                                        </select>
                                    </div>
                                    <div class="col-3 col-sm-3 col-md-3 mt-2" id="produkk">
                                        <label for="produk1">Nama Menu</label>
                                        <select class="form-control select2produkmasuk" name="produk[]" id="produk1" style="width: 100%;" required>
                                            <option value="">Pilih Produk</option>
                                        </select>
                                    </div>
                                    <div class="col-3 col-sm-3 col-md-2 mt-2">
                                        <div class="form-group">
                                            <label for="jml_ukuran">Harga Modal <small>Per Pcs</small></label>
                                            <input type="text" class="form-control input-rupiah-mask" name="harga_modal[]" id="harga_modal1" placeholder="Masukan Harga Modal" required>
                                        </div>
                                    </div>
                                    <div class="col-3 col-sm-3 col-md-2 mt-2">
                                        <div class="form-group">
                                            <label for="harga_produk">Harga Menu <small>Per Pcs</small></label>
                                            <input type="text" class="form-control input-rupiah-mask" name="harga_produk[]" id="harga_produk1" placeholder="Masukan Harga Menu" required>
                                        </div>
                                    </div>
                                    <div class="col-3 col-sm-3 col-md-2 mt-2">
                                        <div class="form-group">
                                            <label for="jml_ukuran">Ujroh Reseller <small>Per Pcs</small></label>
                                            <input type="text" class="form-control input-rupiah-mask" name="ujroh_reseller[]" id="ujroh_reseller1" placeholder="Masukan Ujroh Reseller" required>
                                        </div>
                                    </div>
                                    <div class="col-3 col-sm-3 col-md-2 mt-2">
                                        <div class="form-group">
                                            <label>Stok Masuk</label>
                                            <input type="number" name="stok_masuk[]" id="stok_masuk" class="form-control" min="1" max="1000" placeholder="Stok Masuk" required>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-1 col-sm-1">
                                        <label></label><br>
                                        <a href="javascript:void(0)" class="btn btn-success mt-3 btn-block" id="tambahfieldprodukmasuk"><i class="fa fa-plus"></i> </a>
                                    </div>
                                </div>
                                <div id="bagianProdukMasuk">
                                </div>
                                <div class="row" style="margin-top: -12px;">
                                    <div class="col-6 col-sm-6 col-md-6 mt-2">
                                        <div class="form-group">
                                            <label>Nominal Bayar</label>
                                            <input type="text" name="nominal_bayar" id="nominal_bayar" class="form-control input-rupiah-mask" placeholder="Masukkan Nominal Bayar" required>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-6 col-md-6 mt-2">
                                        <div class="form-group">
                                            <label>Tanggal Jatuh Tempo</label>
                                            <div class="input-group date" data-target-input="nearest">
                                                <input type="text" class="form-control" name="tanggal_jatuh_tempo" id="tanggal_order" required />
                                                <div class="input-group-append" data-target="#tanggal_order" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
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
                                            <label>Bukti Pembayaran <small style="color: grey;">*Bisa Dikosongkan</small></label>
                                            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran1" class="form-control">
                                        </div>
                                    </div>
                                </div>




                            </div>
                            <!-- /.card-body -->

                            <!-- ini untuk max pembelian -->
                            <input type="hidden" id="jmlbarang" value="10">
                            <!-- ini untuk perhitungan looping di for nya -->
                            <input type="hidden" id="jmlbarang1" value="1">
                            <!-- ini untuk index pada pertambahan -->
                            <input type="hidden" id="jmlbarangplus" value="1">
                            <!-- ini untuk index pada pengurangan -->
                            <input type="hidden" id="jmlbarangminus" value="1">


                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-danger">Cancel</button>
                            </div>

                            <div class="modal fade" id="setperhitunganharga1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <input type="text" name="margin100[]" id="margin1001" class="form-control rupiah-mask" placeholder="Masukan Margin">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="margin701">Margin <?= $konfigurasi['ujroh_selera'] ?>% Selera</label>
                                                    <input type="text" name="margin70[]" id="margin701" class="form-control rupiah-mask" placeholder="Masukan Biaya Lainnya">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="margin301">Margin <?= $konfigurasi['ujroh_reseller'] ?>% Reseller</label>
                                                    <input type="text" name="margin30[]" id="margin301" class="form-control rupiah-mask" placeholder="Masukan Harga Modal">
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
                                                    <input type="text" name="harga_jual_reseller[]" id="harga_jual_reseller1" class="form-control rupiah-mask" placeholder="Masukan Biaya Lainnya">
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
                            </div>

                            <div id="modal-detail">

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>