<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <!-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard </li>
                    </ol>
                </div> -->
                <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="flash-data1" data-flashdata="<?= $this->session->flashdata('flash'); ?>" style=""></div>
            <div class="error-data1" data-error="<?= $this->session->flashdata('error'); ?>" style=""></div>

            <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
            <div class="error-data" data-error="<?= $this->session->flashdata('error'); ?>"></div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-box"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Produk</span>
                            <span class="info-box-number">
                                <?= $this->db->get_where('produk', ['is_produk_hapus' => 1, 'is_produk_aktif' => 1])->num_rows(); ?>
                                <!-- <small>%</small> -->
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Ketegori Menu</span>
                            <span class="info-box-number">
                                <?= $this->db->get('kategori')->num_rows(); ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-xs-12 col-sm-12 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cart-plus"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Pesanan Hari ini</span>
                            <span class="info-box-number">
                                <?= $order_harian ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-default elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Pesanan </span>
                            <span class="info-box-number">
                                <?php
                                $this->db->select('*');
                                $this->db->from('order');
                                echo $total = $this->db->get()->num_rows();
                                ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->