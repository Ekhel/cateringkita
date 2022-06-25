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
                            <div class="col-md-12">
                                <h1>
                                    <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add" data-backdrop="static" data-keyboard="false"><span class="fa fa-plus"></span> Add Promo Bonus</a>
                                </h1>
                            </div>
                            <br>
                            <table class="table table-hover text-nowrap table-striped table-bordered" id="mytablePromoBonus" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama Promo</th>
                                        <th>Tanggal Promo</th>
                                        <th>Waktu Promo</th>
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

<form id="addPromoProductBonus" autocomplete="off">
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Promo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Promo</label>
                        <input type="text" class="form-control" name="nama_promo" id="nama_promo" placeholder="Masukkan Nama Promo" required>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label>Jenis Promo</label>
                        <select name="jenis_promo" id="jenis_promo" class="form-control">
                            <option value="">Pilih Jenis Promo</option>
                            <option value="1">Promo Harian</option>
                            <option value="2">Promo Jangka Panjang</option>
                        </select>
                    </div>
                    <div class="form-group row" id="bagian_tanggal">
                        <div class="col-md-12 col-xs-12 col-12" id="bagian_tanggal_start">
                            <label>Tanggal Mulai</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="date_start" id="datepickersingle" data-target="#reservationdate" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6 col-6" id="bagian_tanggal_end" style="display: none;">
                            <label>Tanggal Selesai</label>
                            <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="date_end" id="datepickersingle1" data-target="#reservationdate" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="bagian_waktu">
                        <div class="col-md-6 col-xs-6 col-6" id="bagian_waktu_start">
                            <label>Waktu Mulai</label>
                            <input type="time" class="form-control" name="time_start" id="time_start">
                        </div>
                        <div class="col-md-6 col-xs-6 col-6" id="bagian_waktu_end">
                            <label>Waktu Selesai</label>
                            <input type="time" class="form-control" name="time_end" id="time_end">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 col-xs-7 col-7">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border"> Produk Promo</legend>
                                <div class="row">
                                    <div class="col-md-6 col-xs-6 col-6">
                                        <div class="form-group">
                                            <label>Produk</label>
                                            <select name="produk[]" class="form-control select2produkpaket" id="promo_produk" required>
                                                <option value="">Pilih Produk</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-xs-2 col-2">
                                        <label>QTY</label>
                                        <input type="text" class="form-control" name="qty[]" id="qtypaket1" placeholder="QTY" required>
                                    </div>
                                    <div class="col-md-3 col-xs-3 col-3">
                                        <label>Harga Menu</label>
                                        <input type="text" class="form-control input-rupiah-mask" name="harga_produk[]" id="harga_produk1" placeholder="Harga Menu" readonly required>
                                        <input type="hidden" class="form-control input-rupiah-mask" id="harga_produkk1" placeholder="Harga Menu" readonly required>
                                    </div>
                                    <div class="col-md-1 col-xs-1 col-1">
                                        <label for="kd_supplier"></label><br>
                                        <a href="javascript:void(0);" class="btn btn-success mt-2 " id="buttontambahprodukpaketbonus"> <i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                <div id="bagiantambahprodukpaket"></div>
                            </fieldset>
                        </div>
                        <div class="col-md-5 col-xs-5 col-5">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border"> Produk Bonus</legend>
                                <div class="row">
                                    <div class="col-md-8 col-xs-8 col-8">
                                        <div class="form-group">
                                            <label>Produk</label>
                                            <select name="produk_bonus[]" class="form-control select2produkbonus" id="promo_produk_bonus" required>
                                                <option value="">Pilih Produk</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-xs-3 col-3">
                                        <label>QTY</label>
                                        <input type="text" class="form-control" name="qty_bonus[]" id="qtybonus1" placeholder="QTY" required>
                                    </div>
                                    <div class="col-md-1 col-xs-1 col-1">
                                        <label for="kd_supplier"></label><br>
                                        <a href="javascript:void(0);" class="btn btn-success mt-2 " id="buttontambahprodukbonus"> <i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                <div id="bagiantambahprodukbonus"></div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-xs-6 col-6">
                            <div class="form-group">
                                <label>Harga Modal</label>
                                <input type="text" class="form-control rupiah-mask" name="harga_modal" id="harga_modal" placeholder="Total Harga Modal" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6 col-6">
                            <div class="form-group">
                                <label>Harga Promo</label>
                                <input type="text" class="form-control input-rupiah-mask" name="harga_promo" id="harga_promo" placeholder="Masukkan Harga Promo" required>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="jmlbarang" value="100">
                    <!-- ini untuk perhitungan looping di for nya -->
                    <input type="hidden" id="jmlbarang1" value="1">
                    <!-- ini untuk index pada pertambahan -->
                    <input type="hidden" id="jmlbarangplus" value="1">
                    <!-- ini untuk index pada pengurangan -->
                    <input type="hidden" id="jmlbarangminus" value="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_save_promo" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="editPromoProductBonus" autocomplete="off">
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Promo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Promo</label>
                        <input type="hidden" class="form-control" name="kode_promo" id="edit_kode_promo" placeholder="Masukkan Nama Promo" required>
                        <input type="text" class="form-control" name="nama_promo" id="edit_nama_promo" placeholder="Masukkan Nama Promo" required>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label>Jenis Promo</label>
                        <select name="jenis_promo" id="edit_jenis_promo" class="form-control">
                            <option value="">Pilih Jenis Promo</option>
                            <option value="1">Promo Harian</option>
                            <option value="2">Promo Jangka Panjang</option>
                        </select>
                    </div>
                    <div class="form-group row" id="edit_bagian_tanggal" style="display: none;">
                        <div class="col-md-6 col-xs-6 col-6" id="edit_bagian_tanggal_start">
                            <label>Tanggal Mulai</label>
                            <div class="input-group date" id="edit_reservationdate" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="date_start" id="edit_datepickersingle" data-target="#reservationdate" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6 col-6" id="edit_bagian_tanggal_end">
                            <label>Tanggal Selesai</label>
                            <div class="input-group date" id="edit_reservationdate1" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="date_end" id="edit_datepickersingle1" data-target="#reservationdate" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="edit_bagian_waktu" style="display: none;">
                        <div class="col-md-6 col-xs-6 col-6" id="edit_bagian_waktu_start">
                            <label>Waktu Mulai</label>
                            <input type="time" class="form-control" name="time_start" id="edit_time_start">
                        </div>
                        <div class="col-md-6 col-xs-6 col-6" id="edit_bagian_waktu_end">
                            <label>Waktu Selesai</label>
                            <input type="time" class="form-control" name="time_end" id="edit_time_end">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7 col-xs-7 col-7">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border"> Produk Promo</legend>

                                <div id="edit_bagiantambahprodukpaketbonus"></div>
                                <div id="edit_bagiantambahprodukpaketbonus1"></div>
                                <a href="javascript:void(0);" class="btn btn-success mt-2 btn-block" id="editbuttontambahprodukpaketbonus">Tambah Menu <i class="fa fa-plus"></i></a>
                            </fieldset>
                        </div>
                        <div class="col-md-5 col-xs-5 col-5">
                            <fieldset class="scheduler-border">
                                <legend class="scheduler-border"> Produk Bonus</legend>

                                <div id="edit_bagiantambahprodukbonus"></div>
                                <div id="edit_bagiantambahprodukbonus1"></div>
                                <a href="javascript:void(0);" class="btn btn-success mt-2 btn-block" id="editbuttontambahprodukbonus">Tambah Menu <i class="fa fa-plus"></i></a>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-xs-6 col-6">
                            <div class="form-group">
                                <label>Harga Modal</label>
                                <input type="text" class="form-control rupiah-mask" name="harga_modal" id="edit_harga_modal" placeholder="Total Harga Modal" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6 col-6">
                            <div class="form-group">
                                <label>Harga Promo</label>
                                <input type="text" class="form-control input-rupiah-mask" name="harga_promo" id="edit_harga_promo" placeholder="Masukkan Harga Promo" required>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="edit_jmlbarang" value="100">
                    <!-- ini untuk perhitungan looping di for nya -->
                    <input type="hidden" id="edit_jmlbarang1" value="1">
                    <!-- ini untuk index pada pertambahan -->
                    <input type="hidden" id="edit_jmlbarangplus" value="1">

                    <input type="hidden" id="edit_jmlbarangbonus1" value="1">
                    <!-- ini untuk index pada pertambahan -->
                    <input type="hidden" id="edit_jmlbarangplusbonus" value="1">
                    <!-- ini untuk index pada pengurangan -->
                    <input type="hidden" id="edit_jmlbarangminus" value="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="edit_btn_save" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- MODAL LIHAT PROMO -->
<div class="modal fade" id="Modal_Lihat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Promo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped mt-2">
                    <thead>
                        <tr>
                            <th>Nama Menu</th>
                            <th>Harga Menu</th>
                            <th>Harga Promo</th>
                        </tr>
                    </thead>
                    <tbody id="demo">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--END MODAL LIHAT PROMO-->