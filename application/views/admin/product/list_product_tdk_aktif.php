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
                                    <a href="javascript:void(0);" class="btn" data-toggle="modal" id="btn_Modal_Scan_Produk" data-target="#Modal_Scan" style="background-color:#4169E1; color:white"><i class="fas fa-qrcode" style="color: white;"></i><span id="valuescan"> Scan Produk</span></a>
                                    <a href="<?= base_url('product/export_excel_produk/0') ?>" class="btn btn-success"><i class="fa fa-file-excel"></i> Export Data Menu</a>
                                </h1>
                            </div>
                            <br>
                            <table class="table table-hover text-nowrap table-striped table-bordered" id="mytableProdukTdkAktif" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama Kategori</th>
                                        <th>Nama Sub Kategori</th>
                                        <th>Nama Menu</th>
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

<!-- View Gallery -->
<!-- <div class="modal fade gallery_foto" id="setgallery" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Gallery</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="gallery-images">
                    <div class="selected-image">
                        <div class="row" id="roww">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div> -->
<!--END View Gallery-->

<!-- View Detail Produk -->
<div class="modal fade view_detaill" id="setgallery" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Detail Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="modal-title mb-2 text-center">Data Produk</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Menu</th>
                                    <th>Kategori</th>
                                    <th>Sub Kategori</th>
                                    <th>Nama Supplier</th>
                                </tr>
                            </thead>
                            <tbody id="demo">

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <h4 class="modal-title mb-2 text-center" style="margin-top: 20px;">Detail Data Produk</h4>
                        <table class=" table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Satuan Berat</th>
                                    <th>Harga Modal</th>
                                    <th>Harga Saat Ini</th>
                                    <th>Diskon</th>
                                    <th>Stok Barang</th>
                                    <th>Persentase Ujroh</th>
                                    <th>Total Ujroh</th>
                                </tr>
                            </thead>
                            <tbody id="demo1">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</div>
<!--END View Detail Produk-->

<!-- View Highlight -->
<form id="editHighlight">
    <div class="modal fade hightlight_product" id="hightlight_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hightlight Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <p for="" class="text-right" style="font-size:25px">Higlight in Featured</p>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="switchToggle">
                                <input type="hidden" name="kd_produk" id="kd_produk">
                                <input type="checkbox" name="featured" id="switch1">
                                <label for="switch1" style="margin-top:4px">Toggle</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <p for="" class="text-right" style="font-size:25px">Higlight in Best Seller</p>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="switchToggle">
                                <input type="checkbox" name="best_seller" id="switch2">
                                <label for="switch2" style="margin-top:4px">Toggle</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <p for="" class="text-right" style="font-size:25px">Higlight in Top Rated</p>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="switchToggle">
                                <input type="checkbox" name="top_rated" id="switch3">
                                <label for="switch3" style="margin-top:4px">Toggle</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <p for="" class="text-right" style="font-size:25px">Higlight in Big Saved</p>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="switchToggle">
                                <input type="checkbox" name="big_saved" id="switch4">
                                <label for="switch4" style="margin-top:4px">Toggle</label>
                            </div>
                        </div>
                    </div>``
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_save" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END View Highlight-->

<!--MODAL DELETE-->
<form id="hapusProduk">
    <div class="modal fade" id="hapusModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Are you sure to dssselete this record?</strong>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="product_code_delete" id="product_code_delete" class="form-control">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->

<!-- MODAL SCAN -->
<div class="modal fade" id="Modal_Scan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Scan Reseller</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center mt-0">
                    <div class="col-md-9">
                        <div class="card-header bg-transparent mb-0">
                            <h5 class="text-center">
                                <span class="font-weight-bold text-primary">Scan</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <center><video src="" id="preview" class="img-thumbnail bg-transparent border-transparent" width="350" height="350"></video></center>
                            <div class="form-group"></div><br>
                        </div>

                    </div>
                </div>
                <div class="col-md-12">
                    <div id="scanproduct" style="display: none;">
                        <center><span class="font-weight-bold text-primary" style="margin: auto; font-size:20px">Hasil Scan</span></center>
                        <table class="table table-striped mt-2">
                            <thead>
                                <tr>
                                    <th>Nama Menu</th>
                                    <th>Kategori</th>
                                    <th>Sub Kategori</th>
                                    <th>Nama Supplier</th>
                                </tr>
                            </thead>
                            <tbody id="bodyProduk1">

                            </tbody>
                        </table>

                        <table class="table table-striped mt-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Satuan Berat</th>
                                    <th>Harga Modal</th>
                                    <th>Harga Saat Ini</th>
                                    <th>Diskon</th>
                                    <th>Stok Barang</th>
                                    <th>Persentase Ujroh</th>
                                    <th>Total Ujroh</th>
                                </tr>
                            </thead>
                            <tbody id="bodyProduk2">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL SCAN-->

<!-- MODAL PRINT QRCODE -->
<div class="modal fade" id="Modal_Print" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labelProduk"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <center>
                    <div>
                        <div class="form-group mt-2">
                            <img src="" id="image-preview" alt="" class="img-thumbnail">
                        </div>

                        <a id="linkPrint" class="btn btn-primary" target="_blank">Print QrCode</a>
                    </div>
                </center>
            </div>
        </div>
    </div>
</div>
<!--END MODAL PRINT QRCODE-->