<?php
if (in_array('1', $dataTampunganRole)) {
} else {
    $this->session->set_flashdata('error', 'Tidak Bisa Akses Menu Tersebut. Bukan Bagian Anda!');
    redirect(base_url('dashboard'));
}

$logo1 = $logo->num_rows();
$logo = $logo->row_array();
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
                                <div class="gocover"></div>
                                <div class="row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="special-box">
                                            <div class="heading-area">
                                                <h4 class="title">
                                                    <center><span>Website Logo</span></center>
                                                </h4>
                                            </div>

                                            <form id="uploadLogoSelera" method="POST" enctype="multipart/form-data">

                                                <div style="padding: 20px 0px 20px 0px;">
                                                    <center>
                                                        <a href="javascript:;" id="btn-upload-logo" class="d-inline-block">
                                                            <div id='img_contain'>
                                                                <img id="image-preview-logo" style="height: 220px;" align='middle' src="<?= $logo1 > 0 ? base_url('assets/images/logo_website/' . $logo['nm_logo']) : base_url('assets/images/noimagefound.jpg') ?>" alt="your image" title='' />
                                                            </div>
                                                        </a>

                                                        <input type="file" id="file-input-logo" name="gallery" style="display:none;">
                                                        <input type="hidden" name="kd_logo" id="kd_logo" value="<?= empty($logo['kd_logo']) ? '' : $logo['kd_logo'] ?>">

                                                        <button type="submit" class="d-inline-block mt-2 btn btn-primary">
                                                            <i class="icofont-upload-alt"></i> Upload Website Logo
                                                        </button>
                                                    </center>
                                                </div>
                                            </form>

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
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->