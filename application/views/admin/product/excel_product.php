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
                        <div class="card-body">
                            <ul class="alert alert-info" style="padding-left: 40px">
                                <li>Silahkan import data dari excel, menggunakan format yang sudah disediakan</li>
                                <li>Data tidak boleh ada yang kosong, harus terisi semua.</li>
                                <!-- <li>Untuk data Kelas, hanya bisa diisi menggunakan Kode Kelas. <a data-toggle="modal" href="#kelasId" style="text-decoration:none" class="btn btn-xs btn-primary">Lihat Kode</a>.</li> -->
                            </ul>
                            <div class="text-center">
                                <a href="<?= base_url('excel/template-produk.xlsx') ?>" class="btn btn-success">Download Format</a>
                            </div>
                            <br>
                            <?= form_open_multipart('product/preview'); ?>
                            <?php echo $this->session->flashdata('notif') ?>
                            <label for="">Pilih File</label>

                            <div class="form-group" id="">
                                <?= form_error('file', '<div class="alert alert-danger">', '</div>'); ?>
                                <input type="file" class="form-control" name="userfile">
                            </div>

                            <div class="text-center">
                                <button name="preview" type="submit" class="btn btn-sm btn-success">Preview</button>
                            </div>

                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>
                <?php if (isset($_POST['preview'])) : ?>
                    <div class="col-12">
                        <input type="hidden" name="jml_record" id="jml_record" value="<?= isset($_POST['preview']) ? count($import) : '' ?>">
                        <div class="card">
                            <div class="card-body">
                                <?= form_open('product/upload_excel_act', null, ['data' => json_encode($import)]); ?>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="3%">No</th>
                                            <th>Nama Menu</th>
                                            <th>Kategori</th>
                                            <th>Sub Kategori</th>
                                            <th>Supplier</th>
                                            <!-- <th width="2%">Detail</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $status = true;
                                        if (empty($import)) {
                                            echo '<tr><td colspan="10" class="text-center">Data kosong! pastikan anda menggunakan format yang telah disediakan.</td></tr>';
                                        } else {
                                            $no = 1;
                                            $angkaId = 1;
                                            $nmProduk = "";
                                            foreach ($import as $data) :
                                        ?>



                                                <?php
                                                if ($data['nm_produk'] == null && $data['berat'] == null && $data['satuan_berat'] == null && $data['stok'] == null && number_format($data['diskon'], 0, '.', '') == null) {
                                                    echo '<tr><td colspan="10" class="text-center">Data kosong! pastikan anda menggunakan format yang telah disediakan.</td></tr>';
                                                } else { ?>

                                                    <?php if ($nmProduk != $data['nm_produk']) {
                                                        $nmProduk = $data['nm_produk']; ?>
                                                        <tr>
                                                            <td><?= $no++;
                                                                $angkaId++; ?></td>
                                                            <td class="<?= $data['nm_produk'] == null ? 'bg-warning' : ''; ?>">
                                                                <?= $data['nm_produk'] == null ? '<font color=red>BELUM DIISI</font>' : '<span id=nm_produk' . $angkaId . '>' . $data['nm_produk'] . '</span>' ?>
                                                            </td>
                                                            <td width="25%">
                                                                <select name="kd_kategori[]" id="kd_kategori<?= $angkaId ?>" class="select2kategori<?= $angkaId ?> form-control"></select>
                                                            </td>
                                                            <td width="25%">
                                                                <select name="kd_sub_kategori[]" id="kd_sub_kategori<?= $angkaId ?>" class="select2subkategori<?= $angkaId ?> form-control"></select>
                                                            </td>
                                                            <td width="25%">
                                                                <select name="kd_supplier[]" id="kd_supplier<?= $angkaId ?>" class="select2supplier<?= $angkaId ?> form-control"></select>
                                                            </td>
                                                            <!-- <td>
                                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                            </td> -->

                                                            <!-- <td class="<?= number_format($data['diskon'], 0, '.', '') == null ? 'bg-warning' : ''; ?>">
                                                                <?= number_format($data['diskon'], 0, '.', '') == null ? '<font color=red>BELUM DIISI</font>' : number_format($data['diskon'], 0, '.', ''); ?>
                                                            </td> -->

                                                        </tr>
                                                    <?php } else {
                                                        $angkaId++;  ?>
                                                        <div style="display: none;">
                                                            <!-- <?= $data['nm_produk'] == null ? '<font color=red>BELUM DIISI</font>' : $data['nm_produk']; ?> -->
                                                            <input type="hidden" name="nm_produk[]" id="enm_produk<?= $angkaId ?>" value="<?= $data['nm_produk'] ?>">
                                                            <input type="hidden" name="kd_kategori[]" id="ekd_kategori<?= $angkaId ?>" class="form-control">
                                                            <input type="hidden" name="kd_sub_kategori[]" id="ekd_sub_kategori<?= $angkaId ?>" class="form-control">
                                                            <input type="hidden" name="kd_supplier[]" id="ekd_supplier<?= $angkaId ?>" class="form-control">
                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                        <?php
                                                if ($data['nm_produk'] == null || $data['berat'] == null || $data['satuan_berat'] == null || $data['stok'] == null || number_format($data['diskon'], 0, '.', '') == null) {
                                                    $status = false;
                                                }
                                            endforeach;
                                        }
                                        ?>

                                    </tbody>
                                </table>

                                <?php if (empty($import)) { ?>
                                    <?php $status = false; ?>

                                <?php } ?>

                                <br>
                                <button type='submit' class='btn btn-block' style="background-color: #00AAFF; color: white;">Import</button>
                                <?= form_close(); ?>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered" id="example">
                    <thead>
                        <tr>
                            <th width="3%">No</th>
                            <th>Nama Menu</th>
                            <th>Stok</th>
                            <th>Berat Produk</th>
                            <th>Harga Modal</th>
                            <th>Harga Menu</th>
                            <th>Diskon</th>
                            <th>Deskripsi Produk</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $status = true;
                        if (empty($import)) {
                            echo '<tr><td colspan="10" class="text-center">Data kosong! pastikan anda menggunakan format yang telah disediakan.</td></tr>';
                        } else {
                            $no = 1;
                            foreach ($import as $data) :
                        ?>

                                <?php
                                if ($data['nm_produk'] == null && $data['berat'] == null && $data['satuan_berat'] == null && $data['stok'] == null && $data['harga_produk'] == null && number_format($data['diskon'], 0, '.', '') == null) {
                                    echo '<tr><td colspan="10" class="text-center">Data kosong! pastikan anda menggunakan format yang telah disediakan.</td></tr>';
                                } else { ?>

                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td class="<?= $data['nm_produk'] == null ? 'bg-warning' : ''; ?>">
                                            <?= $data['nm_produk'] == null ? '<font color=red>BELUM DIISI</font>' : $data['nm_produk']; ?>
                                        </td>
                                        <td class="<?= $data['stok'] == null ? 'bg-warning' : ''; ?>">
                                            <?= $data['stok'] == null ? '<font color=red>BELUM DIISI</font>' : $data['stok']; ?>
                                        </td>
                                        <td class="<?= $data['berat'] == null && $data['satuan_berat'] == null ? 'bg-warning' : ''; ?>">
                                            <?= $data['stok'] == null ? '<font color=red>BELUM DIISI</font>' : $data['berat'] . " " . $data['satuan_berat']; ?>
                                        </td>
                                        <td class="<?= ($data['harga_modal'] == null && $data['harga_modal'] == null) ? 'bg-warning' : ''; ?>">
                                            <?= ($data['harga_modal'] == null && $data['harga_modal'] == null) ? '<font color=red>BELUM DIISI</font>' : $data['harga_modal'] ?>
                                        </td>
                                        <td class="<?= ($data['pembulatan_harga_jual'] == null && $data['pembulatan_harga_jual'] == null) ? 'bg-warning' : ''; ?>">
                                            <?= ($data['pembulatan_harga_jual'] == null && $data['pembulatan_harga_jual'] == null) ? '<font color=red>BELUM DIISI</font>' : $data['pembulatan_harga_jual'] ?>
                                        </td>
                                        <td class="<?= number_format($data['diskon'], 0, '.', '') == null ? 'bg-warning' : ''; ?>">
                                            <?= number_format($data['diskon'], 0, '.', '') == null ? '<font color=red>BELUM DIISI</font>' : number_format($data['diskon'], 0, '.', ''); ?>
                                        </td>
                                        </td>
                                        <td class="<?= $data['deskripsi_produk'] == null ? 'bg-warning' : ''; ?>">
                                            <?= $data['deskripsi_produk'] == null ? '<font color=red>BELUM DIISI</font>' : $data['deskripsi_produk']; ?>
                                        </td>

                                    </tr>

                                <?php } ?>

                        <?php
                                if ($data['nm_produk'] == null || $data['berat'] == null || $data['satuan_berat'] == null || $data['stok'] == null || number_format($data['diskon'], 0, '.', '') == null) {
                                    $status = false;
                                }
                            endforeach;
                        }
                        ?>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div> -->