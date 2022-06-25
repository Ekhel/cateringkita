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
                        <div class="card-body table-responsive">
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="">Tanggal Pesan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control datemask" id="tanggal_order" placeholder="masukkan tanggal" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy-mm-dd" data-mask="" im-insert="false" autocomplete="false">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Bulan</label>
                                    <select name="bulan" id="bulan_order" class="form-control">
                                        <option value="">Pilih Bulan</option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Tahun</label>
                                    <select name="tahun" id="tahun_order" class="form-control">
                                        <option value="">Pilih Tahun</option>
                                        <?php
                                        $tahun = date('Y');
                                        for ($x = $tahun; $x >= 2010; $x--) { ?>
                                            <option value="<?= $x ?>"><?= $x ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Status Order</label>
                                    <select name="order_status" id="order_status" class="form-control">
                                        <option value="">Pilih Status Order</option>
                                        <option value="pending">Tertunda</option>
                                        <option value="onprocess">Proses</option>
                                        <option value="done">Selesai</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Status Pembayaran</label>
                                    <select name="payment_status" id="payment_status" class="form-control">
                                        <option value="">Pilih Status Pembayaran</option>
                                        <option value="1">Sudah Bayar</option>
                                        <option value="0">Belum Bayar</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <!--/.col (right) -->
        </div>
    </section>
    <!-- /.content -->
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
                            <div class="btn-group">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-print"> Print Report</i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);" id="buttonprintorder1">Report Order - Sederhana</a>
                                    <a class="dropdown-item" href="javascript:void(0);" id="buttonprintorder2">Report Order - Perincian</a>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-download"> Download Pdf Report</i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);" id="buttonpdforder1">Report Order - Sederhana</a>
                                    <a class="dropdown-item" href="javascript:void(0);" id="buttonpdforder2">Report Order - Perincian</a>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-file-excel"> Data Excel</i>
                                </button>
                                <div class="dropdown-menu">
                                    <a href="javascript:void(0);" id="buttonexcelorder" class="dropdown-item btn btn-success"> Export Data Order</a>
                                </div>
                            </div>
                            <br><br>
                            <table class="table table-hover text-nowrap table-striped table-bordered" id="report_order">
                                <thead>
                                    <tr>
                                        <th>Tanggal Pesan</th>
                                        <th>Kode Order</th>
                                        <th>Nama Pembeli</th>
                                        <th>Nomor Telepon</th>
                                        <th>Total</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Action</th>
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
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="modal-lihat-reportorder">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Order</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Kode Menu</th>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody id="demo">

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <th>Total Harga</th>
                            <th class="bagian_total"></th>
                        </tr>
                    </tfoot>
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