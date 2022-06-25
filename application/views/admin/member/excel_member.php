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
                                <a href="<?= base_url('excel/template-member.xlsx') ?>" class="btn btn-success">Download Format</a>
                            </div>
                            <?= form_open_multipart('member/preview'); ?>
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
                    <input type="hidden" name="total_excel_member" id="total_excel_member" value="<?= count($import) ?>">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-striped table-bordered" id="example12">
                                    <?= form_open('member/upload_excel_act', null, ['data' => json_encode($import)]); ?>
                                    <thead>
                                        <tr>
                                            <th>Nomor</th>
                                            <th>Nama Member</th>
                                            <th>No Telepon</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Email</th>
                                            <th>Alamat</th>
                                            <th>Kecamatan</th>
                                            <th>Username</th>
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
                                                if ($data['nm_member'] == null && $data['username'] == null && $data['no_telp'] == null && $data['jenis_kelamin'] == null && $data['email'] == null && $data['alamat'] == null) {
                                                    echo '<tr><td colspan="10" class="text-center">Data kosong! pastikan anda menggunakan format yang telah disediakan.</td></tr>';
                                                } else { ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td class="<?= $data['nm_member'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['nm_member'] == null ? '<font color=red>BELUM DIISI</font>' : $data['nm_member']; ?>
                                                        </td>
                                                        <td class="<?= $data['no_telp'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['no_telp'] == null ? '<font color=red>BELUM DIISI</font>' : $data['no_telp']; ?>
                                                        </td>
                                                        <td class="<?= $data['jenis_kelamin'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['jenis_kelamin'] == null ? '<font color=red>BELUM DIISI</font>' : $data['jenis_kelamin']; ?>
                                                        </td>
                                                        <td class="<?= $data['email'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['email'] == null ? '<font color=red>BELUM DIISI</font>' : $data['email']; ?>
                                                        </td>
                                                        <td class="<?= $data['alamat'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['alamat'] == null ? '<font color=red>BELUM DIISI</font>' : $data['alamat']; ?>
                                                        </td>
                                                        <td width="40%">
                                                            <select name="kecamatan[]" class="form-control select2tujuan<?= $no ?>"></select>
                                                            <input type="hidden" name="kode_pos[]" class="form-control" id="kode_pos_member<?= $no ?>">
                                                        </td>
                                                        <td class="<?= $data['username'] == null ? 'bg-warning' : ''; ?>">
                                                            <?= $data['username'] == null ? '<font color=red>BELUM DIISI</font>' : $data['username']; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                        <?php
                                                if ($data['nm_member'] == null || $data['username'] == null || $data['no_telp'] == null || $data['jenis_kelamin'] == null || $data['email'] == null || $data['alamat'] == null) {
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