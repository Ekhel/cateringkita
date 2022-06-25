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
                                    <!-- <small>List</small> -->
                                    <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" id="cont" data-target="#Modal_Add" data-backdrop="static" data-keyboard="false"><span class="fa fa-plus"></span> Add Ongkir Khusus</a>
                                </h1>
                            </div>
                            <br>
                            <table class="table table-hover text-nowrap table-striped table-bordered" id="mytableOngkirKhusus">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama Daerah</th>
                                        <!-- <th>Daerah</th> -->
                                        <th>nominal 1</th>
                                        <th>nominal 2</th>
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
<form id="addOngkirKhusus" autocomplete="off">
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Kelola Ongkir Khusus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 col-lg">
                            <label for="judul_ongkir">Judul Ongkir Khusus</label>
                            <input type="text" class="form-control" name="judul_ongkir" id="judul_ongkir">
                        </div>
                        <div class="col-md-4 col-lg">
                            <label for="nominal_ongkir1">Nominal Ongkir Khusus Awal</label>
                            <input type="text" class="form-control input-rupiah-mask" name="nominal_ongkir1" id="nominal_ongkir1">
                        </div>
                        <div class="col-md-4 col-lg">
                            <label for="nominal_ongkir2">Nominal Ongkir Khusus Promo</label>
                            <input type="text" class="form-control input-rupiah-mask" name="nominal_ongkir2" id="nominal_ongkir2">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3 col-12">
                            <label for="judul_ongkir">Piih Kota</label>
                            <select name="kabupaten[]" id="kabupaten" class="form-control select2kota"></select>
                        </div>
                        <div class="col-md-3 col-12">
                            <label for="judul_ongkir">Pilih Kecamatan</label>
                            <select name="kecamatan[]" id="select2kecamatan" class="form-control"></select>
                        </div>
                        <div class="col-md-5 col-12">
                            <label for="judul_ongkir">Pilih Kelurahan (Optional)</label>
                            <select name="kelurahan[]" id="kelurahan" class="form-control select2multiple-kelurahan" multiple="multiple"></select>
                        </div>
                        <div class="col-md-1 col-12">
                            <label for="kd_supplier"></label><br>
                            <a href="javascript:void(0);" class="btn btn-success mt-2 buttontambahongkirkhusus" id="buttontambahongkirkhusus"> <i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="bagiantambahongkirkhusus"></div>
                </div>
                <input type="hidden" id="jmlbarang" value="100">
                <!-- ini untuk perhitungan looping di for nya -->
                <input type="hidden" id="jmlbarang1" value="1">
                <!-- ini untuk index pada pertambahan -->
                <input type="hidden" id="jmlbarangplus" value="1">
                <!-- ini untuk index pada pengurangan -->
                <input type="hidden" id="jmlbarangminus" value="1">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_save" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->

<!-- MODAL EDIT -->
<form id="editOngkirKhusus" autocomplete="off">
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Ongkir Khusus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 col-lg">
                            <label for="judul_ongkir">Judul Ongkir Khusus</label>
                            <input type="hidden" class="form-control" name="kd_ongkir" id="kd_ongkir_edit">
                            <input type="hidden" id="kd_detail_edit" name="kd_detail[]" class="form-control">
                            <input type="text" class="form-control" name="judul_ongkir" id="judul_ongkir_edit">
                        </div>
                        <div class="col-md-4 col-lg">
                            <label for="nominal_ongkir1">Nominal Ongkir Awal</label>
                            <input type="text" class="form-control input-rupiah-mask" name="nominal_ongkir1" id="nominal_ongkir1_edit">
                        </div>
                        <div class="col-md-4 col-lg">
                            <label for="nominal_ongkir2">Nominal Ongkir Promo</label>
                            <input type="text" class="form-control input-rupiah-mask" name="nominal_ongkir2" id="nominal_ongkir2_edit">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3 col-12">
                            <label for="judul_ongkir">Piih Kota</label>
                            <select name="kabupaten_edit[]" id="kabupaten_edit" class="form-control select2kota"></select>
                        </div>
                        <div class="col-md-3 col-12">
                            <label for="judul_ongkir">Pilih Kecamatan</label>
                            <select name="kecamatan_edit[]" id="kecamatan_edit" class="form-control select2kecamatanedit"></select>
                        </div>
                        <div class="col-md-5 col-12">
                            <label for="judul_ongkir">Pilih Kelurahan (Optional)</label>
                            <select name="kelurahan_edit[]" id="kelurahan_edit" class="form-control select2multiple-kelurahan" multiple="multiple"></select>
                        </div>
                        <div class="col-md-1 col-12">
                            <label for="kd_supplier"></label><br>
                            <a href="javascript:void(0);" class="btn btn-success mt-2 buttontambahongkirkhususedit"> <i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div id="bagiantambahongkirkhusus_edit"></div>
                    <div class="bagiantambahongkirkhususs"></div>
                </div>
                <input type="hidden" id="tampungan" name="tampungan[]">
                <input type="hidden" id="edit_jmlbarang" value="100">
                <!-- ini untuk perhitungan looping di for nya -->
                <input type="hidden" id="edit_jmlbarang1" value="1">
                <!-- ini untuk index pada pertambahan -->
                <input type="hidden" id="edit_jmlbarangplus" value="1">
                <!-- ini untuk index pada pengurangan -->
                <input type="hidden" id="edit_jmlbarangminus" value="1">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_save" class="btn btn-primary">Edit</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->

<!--MODAL DELETE-->
<form id="hapusOngkirKhusus">
    <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Are you sure to delete this record?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->