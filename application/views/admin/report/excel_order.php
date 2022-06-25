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
                                <a href="<?= base_url('excel/template-order.xlsx') ?>" class="btn btn-success">Download Format</a>
                            </div>
                            <br>
                            <?= form_open_multipart('report/preview'); ?>
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
                        <div class="card">
                            <div class="card-body table-responsive">
                                <table class="table table-striped table-bordered" id="example">
                                    <thead>
                                        <tr>
                                            <th>Nomor</th>
                                            <th>Kode Reseller</th>
                                            <th>Kode Member</th>
                                            <th>No Telepon</th>
                                            <th>Alamat</th>
                                            <th>Kode Menu</th>
                                            <th>QTY</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th>Diskon</th>
                                            <th>Ongkir</th>
                                            <th>Total Pembayaran</th>
                                            <th>Metode Pembayaran</th>
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
                                                if ($data['kd_reseller'] == null && $data['kd_customer'] == null && $data['no_telp'] == null && $data['alamat'] == null && $data['kd_detail_produk'] == null && $data['qty'] == null && $data['harga'] == null && $data['total'] == null && $data['diskon'] == null && $data['ongkir'] == null && $data['total_pembayaran'] == null && $data['metode_pembayaran'] == null) {
                                                    echo '<tr><td colspan="10" class="text-center">Data kosong! pastikan anda menggunakan format yang telah disediakan.</td></tr>';
                                                } else { ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td class="<?= $data['kd_reseller'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['kd_reseller'] == null ? '<font color=red>BELUM DIISI</font>' : $data['kd_reseller']; ?>
                                                        </td>
                                                        <td class="<?= $data['kd_customer'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['kd_customer'] == null ? '<font color=red>BELUM DIISI</font>' : $data['kd_customer']; ?>
                                                        </td>
                                                        <td class="<?= $data['no_telp'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['no_telp'] == null ? '<font color=red>BELUM DIISI</font>' : $data['no_telp']; ?>
                                                        </td>
                                                        <td class="<?= $data['alamat'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['alamat'] == null ? '<font color=red>BELUM DIISI</font>' : $data['alamat']; ?>
                                                        </td>
                                                        <td class="<?= $data['kd_detail_produk'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['kd_detail_produk'] == null ? '<font color=red>BELUM DIISI</font>' : $data['kd_detail_produk']; ?>
                                                        </td>
                                                        <td class="<?= $data['qty'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['qty'] == null ? '<font color=red>BELUM DIISI</font>' : $data['qty']; ?>
                                                        </td>
                                                        <td class="<?= $data['harga'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['harga'] == null ? '<font color=red>BELUM DIISI</font>' : $data['harga']; ?>
                                                        </td>
                                                        <td class="<?= $data['total'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['total'] == null ? '<font color=red>BELUM DIISI</font>' : $data['total']; ?>
                                                        </td>
                                                        <td class="<?= $data['diskon'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['diskon'] == null ? '<font color=red>BELUM DIISI</font>' : $data['diskon']; ?>
                                                        </td>
                                                        <td class="<?= $data['ongkir'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['ongkir'] == null ? '<font color=red>BELUM DIISI</font>' : $data['ongkir']; ?>
                                                        </td>
                                                        <td class="<?= $data['total_pembayaran'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['total_pembayaran'] == null ? '<font color=red>BELUM DIISI</font>' : $data['total_pembayaran']; ?>
                                                        </td>
                                                        <td class="<?= $data['metode_pembayaran'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['metode_pembayaran'] == null ? '<font color=red>BELUM DIISI</font>' : $data['metode_pembayaran']; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                        <?php
                                                if ($data['kd_reseller'] == null || $data['kd_customer'] == null || $data['no_telp'] == null || $data['alamat'] == null || $data['kd_detail_produk'] == null || $data['qty'] == null || $data['harga'] == null || $data['total'] == null || $data['diskon'] == null || $data['ongkir'] == null || $data['total_pembayaran'] == null || $data['metode_pembayaran'] == null) {
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

                                <?= form_open('report/upload_excel_act', null, ['data' => json_encode($import)]); ?>
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