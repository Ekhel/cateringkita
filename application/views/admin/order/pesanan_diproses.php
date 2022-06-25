<?php
if (in_array('8', $dataTampunganRole) || in_array('9', $dataTampunganRole)) {
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
                                    <a href="javascript:void(0);" class="btn" data-toggle="modal" id="btn_Modal_Scan_Order" data-target="#Modal_Scan" style="background-color:#4169E1; color:white"><i class="fas fa-qrcode" style="color: white;"></i><span id="valuescan"> Scan Order</span></a>
                                </h1>
                            </div>
                            <br>
                            <table class="table table-hover text-nowrap table-striped table-bordered" id="mytablePesananDiproses">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Tanggal Pesanan</th>
                                        <th>Kode Order</th>
                                        <th>Nama Pelanggan</th>
                                        <th>No. Telp Pelanggan</th>
                                        <th>Jenis Pengiriman</th>
                                        <th>Total Harga</th>
                                        <th>Metode Pembayaran</th>
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

<!--MODAL DELETE-->
<form id="hapusOrder">
    <div class="modal fade" id="hapusmodalPesananDiproses" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Are you sure to delete this record?</strong>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="donatur_code_delete" id="product_code_delete" class="form-control">
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
                <h5 class="modal-title" id="exampleModalLabel">Scan Order</h5>
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
                    <div id="scanorder" style="display: none;">
                        <center><span class="font-weight-bold text-primary" style="margin: auto; font-size:20px">Hasil Scan</span></center>

                        <hr>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="special-box">
                                                <div class="heading-area">
                                                    <h4 class="title">
                                                        Detail Order
                                                    </h4>
                                                </div>
                                                <div class="table-responsive-sm">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <table class="table">
                                                                <tbody id="detail_order_kurir_1_pesanan_diproses">

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <table class="table">
                                                                <tbody id="detail_order_kurir_2_pesanan_diproses">

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
                                                            <tbody id="detail_order_kurir_3_pesanan_diproses">

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
                                                            Detail Order
                                                        </h4>
                                                    </div>
                                                    <div class="table-responsive-sm">
                                                        <table class="table">
                                                            <tbody id="detail_order_kurir_4_pesanan_diproses">

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
                                                                        <th class="text-center">Berat</th>
                                                                        <th class="text-center">Harga Menu</th>
                                                                        <th class="text-center">Qty</th>
                                                                        <th class="text-center">Sub Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="detail_order_kurir_5_pesanan_diproses" class="text-center">

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
    </div>
</div>
<!--END MODAL SCAN-->

<!-- MODAL PRINT QRCODE -->
<div class="modal fade" id="Modal_Print" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labelOrder"></h5>
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