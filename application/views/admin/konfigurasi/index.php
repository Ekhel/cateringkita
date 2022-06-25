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
            <!-- <form id="addProduct" method="POST" enctype="multipart/form-data"> -->
            <form action="<?= base_url('konfigurasi/process') ?>" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="insentif">Nama Toko</label>
                                    <input type="hidden" name="kd_konfigurasi" class="form-control" id="kd_konfigurasi" value="<?= empty($konfigurasi['kd_konfigurasi']) ? '' : $konfigurasi['kd_konfigurasi'] ?>">
                                    <input type="text" name="nama_toko" class="form-control" id="nama_toko" value="<?= empty($konfigurasi['nama_toko']) ? '' : $konfigurasi['nama_toko'] ?>" placeholder="Masukkan Nama Toko">
                                </div>
                                <div class="form-group">
                                    <label for="insentif">No Telepon (Whatsapp)</label>
                                    <input type="text" name="no_hp" class="form-control" id="no_hp" value="<?= empty($konfigurasi['no_hp']) ? '' : $konfigurasi['no_hp'] ?>" placeholder="Masukkan Nomor Telepon">
                                </div>
                                <div class="form-group">
                                    <label for="insentif">Email</label>
                                    <input type="text" name="email" class="form-control" id="email" value="<?= empty($konfigurasi['email']) ? '' : $konfigurasi['email'] ?>" placeholder="Masukkan Email">
                                </div>
                                <div class="form-group">
                                    <label for="insentif">Link Facebook</label>
                                    <input type="text" name="facebook" class="form-control" id="facebook" value="<?= empty($konfigurasi['facebook']) ? '' : $konfigurasi['facebook'] ?>" placeholder="Masukkan Facebook">
                                </div>
                                <div class="form-group">
                                    <label for="insentif">Link Twitter</label>
                                    <input type="text" name="twitter" class="form-control" id="twitter" value="<?= empty($konfigurasi['twitter']) ? '' : $konfigurasi['twitter'] ?>" placeholder="Masukkan Twitter">
                                </div>
                                <div class="form-group">
                                    <label for="insentif">Link Instagram</label>
                                    <input type="text" name="instagram" class="form-control" id="instagram" value="<?= empty($konfigurasi['instagram']) ? '' : $konfigurasi['instagram'] ?>" placeholder="Masukkan Instagram">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-danger">Cancel</button>
                            </div>
                        </div>

                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->

            </form>
        </div>
        <!-- /.row -->
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