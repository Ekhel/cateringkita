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
            <form id="editProduct" method="POST" enctype="multipart/form-data">
                <!-- <form action="<?= base_url('Product/add_product') ?>" method="POST" enctype="multipart/form-data"> -->
                <div class="row">

                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="kd_produk">Kode Menu</label>
                                    <input type="text" name="kd_produk" class="form-control" id="kd_produk" value="<?= $dataProduk['kd_produk'] ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="nm_produk">Nama Menu</label>
                                    <input type="text" name="nm_produk" class="form-control" id="nm_produk" placeholder="Masukan Nama Menu" value="<?= $dataProduk['nm_produk'] ?>">
                                </div>

                                <div class="form-group">
                                    <label for="kategori">Ketegori Menu</label>
                                    <select name="kategori" id="kategori" class="form-control select2kategori">
                                        <option selected="selected" value="<?= $dataProduk['kd_kategori'] ?>"><?= $dataProduk['nm_kategori'] ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="kategori">Sub Ketegori Menu</label>
                                    <select name="sub_kategori" id="sub_kategori" class="form-control select2subkategori" style="width: 100%;">
                                        <option selected="selected" value="<?= $dataProduk['kd_sub_kategori'] ?>"><?= $dataProduk['nm_sub_kategori'] ?></option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nm_produk">Gambar Utama</label>

                                    <div class="row">
                                        <div id='img_contain'>
                                            <img id="image-preview-produk" align='middle' src="<?= base_url('assets/images/gallery_produk/' . $dataProduk['foto_produk']) ?>" title='' />
                                        </div>

                                        <input type="file" id="file-input-produk" name="gambarfoto" style="display:none;" style="visibility: hidden;">

                                    </div>
                                    <a href="javascript:;" id="btn-uploadimg" class="d-inline-block mt-2 btn btn-primary">
                                        <i class="icofont-upload-alt"></i> Upload Image Here
                                    </a>
                                </div>

                                <div class="form-group mt-5">
                                    <label for="nm_produk">Galery Menu</label>
                                    <a id="set-gallery" class="btn btn-primary btn-sm text-white">
                                        <i class="icofont-plus"></i> Set Gallery
                                    </a>
                                </div>

                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="text" class="form-control" name="harga" id="harga1" value="<?= $dataProduk['harga'] ?>" placeholder="Masukan Harga">
                                </div>

                                <div class="form-group">
                                    <label for="min_order">Minimal Order</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="min_order" id="min_order1" value="<?= $dataProduk['min_order'] ?>" placeholder="Masukan Minimal Order">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="stok">Deskripsi Menu</label>
                                    <textarea name="deskripsi" id="deskripsi" class="textarea" placeholder="Place some text here" style="width: 100%; height: 10px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?= $dataProduk['deskripsi'] ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Status Produk</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" <?= $dataProduk['is_produk_aktif'] == 1 ? "selected" : "" ?>>Aktif</option>
                                        <option value="0" <?= $dataProduk['is_produk_aktif'] == 0 ? "selected" : "" ?>>Tidak Aktif</option>
                                    </select>
                                </div>

                                <input type="hidden" name="ketfoto" id="ketfoto">

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-danger">Cancel</button>
                                </div>
                            </div>

                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->

                    <div id="modal-detail">

                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="setgallery" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Upload Gallery Produk</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- <input class="custom-file-label" type="file" id="multiFiles" /> -->
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="multiFiles_edit" name="gallery[]" multiple="multiple" aria-describedby="inputGroupFileAddon01">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                    <br><br>

                                    <div class="gallery-images">
                                        <div class="selected-image" id="selected-image_prev">
                                            <div class="row" id="row_prev_gallery"></div>
                                        </div>
                                        <input type="hidden" name="totalimagereview" id="totalimagereview" value="0">
                                    </div>

                                    <hr id="hr">

                                    <div class="gallery-images">
                                        <div class="selected-image" id="selected-image_awal">
                                            <div class="row" id="row_awal_gallery">

                                            </div>
                                        </div>
                                    </div>

                                    <!-- <img src="" class="mt-2" width="150px" height="150px" id="imgVieww" name="gambarBaru" alt=""> -->

                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="closeModalGallery" data-dismiss="modal" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

            </form>
        </div>
    </section>
</div>

<!--MODAL DELETE-->
<form id="hapusGallery">
    <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <input type="hidden" name="donatur_code_delete" id="product_code_delete" class="form-control">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->