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
                        <div class="card-body">
                            <div class="add-logo-area">
                                <div class="row" id="bagian_slider">
                                    <?php if (!empty($saranmasukkan)) { ?>
                                        <?php foreach ($saranmasukkan as $s) { ?>
                                            <div class="col-md-3">
                                                <div class="bg-light card border addresses-item mb-0  shadow-sm">
                                                    <div class="gold-members p-3">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <span class="badge badge-danger"><?= $s['nm_pelanggan'] ?></span>
                                                                <h6 class="mb-3 mt-3 text-dark"><?= ucfirst($this->session->userdata('nama')) ?></h6>
                                                                <p><?= $s['email_pelanggan'] ?>
                                                                </p>
                                                                <p class="text-secondary">Nomor Telepon: <span class="text-dark"><?= $s['notelp_pelanggan'] ?></span></p>
                                                                <p class="text-secondary text-center">Pesan: <br><span class="text-dark"><?= $s['pesan'] ?></span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div class="col-md-12">
                                            <div class="bg-light card border addresses-item mb-0  shadow-sm">
                                                <div class="gold-members p-3">
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <p class="text-secondary">Tidak Ada Data Saran dan Masukkan.</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
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