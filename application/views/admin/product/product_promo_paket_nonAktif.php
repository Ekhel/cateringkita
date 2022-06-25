<?php
if (in_array('1', $dataTampunganRole)) {
} else {
    $this->session->set_flashdata('error', 'Tidak Bisa Akses Menu Tersebut. Bukan Bagian Anda!');
    redirect(base_url('dashboard'));
}

$data = $this->db->get_where('promo', ['type_promo' => 'paket', 'is_promo_aktif' => "0", 'is_promo_hapus' => "1"])->result_array();
foreach ($data as $dt) {
    $order = $this->db->get_where('detail_order', ['kd_produk' => $dt['kd_promo']])->row_array();

    if (!$order) {
        $this->db->delete('promo', ['kd_promo' => $dt['kd_promo']]);
        $this->db->delete('detail_promo', ['kd_promo' => $dt['kd_promo']]);
    }
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
                                    <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add" data-backdrop="static" data-keyboard="false"><span class="fa fa-plus"></span> Add Promo Paket</a>
                                </h1>
                            </div>
                            <br>
                            <table class="table table-hover text-nowrap table-striped table-bordered" id="mytablePromoPaketNonAktif" style="width: 100%;">
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

<form id="addPromoPaket" autocomplete="off">
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
                        <div class="col-xs-6 col-md-6">
                            <div class="form-group">
                                <label for="">Ada Ujroh ?</label>
                                <select name="status_ujroh" class="form-control" id="status_ujroh">
                                    <option value="ya">Ya</option>
                                    <option value="tidak">Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6">
                            <div class="form-group">
                                <label>Stok Paket Produk</label>
                                <input type="text" class="form-control" name="stok" id="stok" placeholder="Masukan Stok Paket" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-6 col-6">
                            <div class="form-group">
                                <label>Produk</label>
                                <select name="produk[]" class="form-control select2produkpaket" id="promo_produk" required>
                                    <option value="">Pilih Produk</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1 col-xs-1 col-1">
                            <label>QTY</label>
                            <input type="text" class="form-control" name="qty[]" id="qtypaket1" placeholder="QTY" required>
                        </div>
                        <div class="col-md-4 col-xs-4 col-4">
                            <label for="harga_produk">Harga Menu</label>
                            <div class="input-group">
                                <input type="text" class="form-control input-rupiah-mask" name="harga_produk[]" id="harga_produk1" placeholder="Harga Menu" readonly required>
                                <input type="hidden" class="form-control input-rupiah-mask" id="harga_produkk1" placeholder="Harga Menu" readonly required>
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-info btn-flat" id="eujrohpaketan1"><i class="fas fa-dollar-sign"></i> </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-1 col-xs-1 col-1">
                            <label for="kd_supplier"></label><br>
                            <a href="javascript:void(0);" class="btn btn-success mt-2 " id="buttontambahprodukPaket"> <i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div id="bagiantambahprodukpaket"></div>
                    <div class="row">
                        <div class="col-md-6 col-xs-6 col-6">
                            <div class="form-group">
                                <label>Total Harga Menu</label>
                                <input type="text" class="form-control rupiah-mask" name="harga_modal" id="harga_modal" placeholder="Total Harga Menu" required readonly>
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

    <!-- MODAL UJROH -->
    <div class="modal fade" id="Modal_ujroh_paketan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Ujroh</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6 col-md-6">
                            <div class="form-group">
                                <label for="">Jumlah Ujroh Selera</label>
                                <input type="text" name="ujroh_selera[]" id="ujroh_selera1" class="form-control rupiah-mask">
                                <input type="hidden" id="hid_ujroh_selera1" class="form-control rupiah-mask" readonly>
                                <input type="hidden" id="hid_ujroh1" class="form-control rupiah-mask" readonly>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6">
                            <div class="form-group">
                                <label for="">Jumlah Ujroh Reseller</label>
                                <input type="text" name="ujroh[]" id="ujroh1" class="form-control rupiah-mask">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tmpt-ujroh-paket"></div>
    <!--END MODAL UJROH-->
</form>

<form id="editPromoProductPaket" autocomplete="off">
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Produk Promo</h5>
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
                    <div class="form-group row" id="edit_bagian_tanggal">
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
                    <div class="form-group row" id="edit_bagian_waktu">
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
                        <div class="col-xs-6 col-md-6">
                            <div class="form-group">
                                <label for="">Ada Ujroh ?</label>
                                <select name="status_ujroh" class="form-control" id="edit_status_ujroh">
                                    <option value="ya">Ya</option>
                                    <option value="tidak">Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6">
                            <div class="form-group">
                                <label>Stok Paket Produk</label>
                                <input type="text" class="form-control" name="stok" id="edit_stok" placeholder="Masukan Stok Paket" required>
                            </div>
                        </div>
                    </div>
                    <div id="edit_bagiantambahprodukpaket"></div>
                    <div id="edit_bagiantambahprodukpaket1"></div>
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
                    <a href="javascript:void(0);" class="btn btn-success mt-2 btn-block" id="editbuttontambahprodukpaket">Tambah Menu <i class="fa fa-plus"></i></a>
                    <input type="hidden" id="edit_jmlbarang" value="100">
                    <!-- ini untuk perhitungan looping di for nya -->
                    <input type="hidden" id="edit_jmlbarang1" value="1">
                    <!-- ini untuk index pada pertambahan -->
                    <input type="hidden" id="edit_jmlbarangplus" value="1">
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

    <div class="edit-tmpt-ujroh-paket"></div>
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