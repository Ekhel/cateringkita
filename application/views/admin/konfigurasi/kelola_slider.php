<?php
if (in_array('1', $dataTampunganRole)) {
} else {
    $this->session->set_flashdata('error', 'Tidak Bisa Akses Menu Tersebut. Bukan Bagian Anda!');
    redirect(base_url('dashboard'));
}

$slider1 = $slider->num_rows();
$slider = $slider->result_array();
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
                        <div class="card-body">
                            <div class="add-logo-area">
                                <div class="row" id="bagian_slider">
                                    <?php foreach ($slider as $s) { ?>
                                        <div class="col-md-6 mb-3">
                                            <div class="position-relative">
                                                <img src="<?= base_url('assets/images/slider/' . $s['nm_slider']) ?>" alt="" height="160px" class="img-fluid">
                                                <div class="ribbon-wrapper ribbon-sm">
                                                    <a href="<?= base_url('konfigurasi/slider_hapus/' . $s['kd_slider']) ?>" class="tombol_hapus">
                                                        <div class="ribbon bg-light text-lg">
                                                            <span aria-hidden="true" class="fa fa-times-circle"></span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="col-md-6">
                                        <a data-toggle="modal" data-target="#add-slider-modal" href="javascript:void(0)">
                                            <div class="bg-light p-3 border rounded  mb-0  shadow-sm text-center h-100 d-flex align-items-center">
                                                <h6 class="text-center m-0 w-100"><i class="fa fa-plus-circle fa-4x"></i><br><br>Tambah Slider</h6>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
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

<!-- Modal Upload Bukti Pembayaran -->
<form action="<?= base_url('konfigurasi/upload_slider') ?>" method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="add-slider-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Slider</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="pemb4yaran">
                        <!-- <div>
                            <img src="<?= base_url('assets/images/no-image.png') ?>" alt="" id="imgView" srcset="">
                        </div> -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                            </div>

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="gambarfoto" id="inputFile" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" id="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
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
</form>
<!-- Modal End Upload Bukti Pembayaran -->