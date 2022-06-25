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
            <form id="addProduct" method="POST" enctype="multipart/form-data">

                <div class="row">

                    <div class="col-md-12">

                        <div class="card card-primary">

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="kd_produk">Kode Menu</label>
                                    <input type="text" name="kd_produk" class="form-control" id="kd_produk" value="<?= $kodeOtomatis ?>" placeholder="Masukan Nama Menu" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="nm_produk">Nama Menu</label>
                                    <input type="text" name="nm_produk" class="form-control" id="nm_produk" placeholder="Masukan Nama Menu">
                                </div>

                                <div class="form-group">
                                    <label for="kategori">Ketegori Menu</label>
                                    <select name="kategori" id="kategori" class="form-control select2kategori" style="width: 100%;">
                                        <option value="Pilih Kategori">Pilih Kategori</option>
                                    </select>
                                </div>

                                <div class="form-group" id="sub_kat" style="display: none;">
                                    <label for="kategori">Sub Ketegori Menu</label>
                                    <select name="sub_kategori" id="sub_kategori" class="form-control select2subkategori" style="width: 100%;">
                                        <option value="Pilih Kategori">Pilih Sub Kategori</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nm_produk">Gambar Utama</label>

                                    <div class="row">
                                        <div id='img_contain'>
                                            <img id="image-preview-produk" align='middle' title='' />
                                        </div>

                                        <input type="file" id="file-input-produk" name="gallery[]" style="display:none;" style="visibility: hidden;">

                                    </div>
                                    <a href="javascript:;" id="btn-uploadimg" class="d-inline-block mt-2 btn btn-primary">
                                        <i class="icofont-upload-alt"></i> Upload Image Here
                                    </a>
                                </div>

                                <div class="form-group mt-5">
                                    <label for="nm_produk">Galery Menu</label>
                                    <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#setgallery">
                                        <i class="icofont-plus"></i> Set Gallery
                                    </a>
                                </div>
                                <div class="form-group">
                                    <label for="harga_produk">Harga Menu</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="harga_produk" id="harga_produk1" placeholder="Masukan Harga Menu">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="min_order">Minimal Order</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="min_order" id="min_order1" placeholder="Masukan Minimal Order">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="stok">Deskripsi Menu</label>
                                    <textarea name="deskripsi" id="deskripsi" class="textarea" placeholder="Place some text here" style="width: 100%; height: 10px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
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

                <!-- Modal -->
                <div class="modal fade" id="setperhitunganharga" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <label for="insentif1">Insentif <?= $konfigurasi['insentif'] ?>%</label>
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

            </form>
        </div>
        <!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- Modal -->
<div class="modal fade setgallery" id="setgallery" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <button type="button" data-dismiss="modal" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>