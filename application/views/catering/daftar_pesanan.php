<style type="text/css">
    .bs-example .nav-tabs {
        overflow-x: auto;
        overflow-y: hidden;
        flex-wrap: nowrap;
    }

    .bs-example .nav-tabs .nav-link {
        white-space: nowrap;
    }
</style>
<section class="py-5 account-page bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-header">
                                <div class="p-4">
                                    <div class="osahan-user text-center">
                                        <h4 class="text-dark mt-0 mb-0"><?= $judul ?></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php if ($this->session->userdata('telp')) { ?>
                                    <?php $telp = $this->session->userdata('telp');

                                    $temp_order = $this->db->get_where('temporary_order', ['cust_phone' => replace_phone_number($telp)])->num_rows();
                                    $order = $this->db->get_where('order', ['cust_phone' => replace_phone_number($telp)])->num_rows(); ?>
                                    <div class="form-group">
                                        <label>Nomor Telepon <span class="required text-danger">*</span></label>
                                        <div class="input-group">
                                            <input class="form-control border-form-control" id="telp_check" name="telp_check" value="<?= $this->session->userdata('telp') ?>" placeholder="Masukkan Nomor Telepon(Whatsapp)" onkeypress="return hanyaAngka(event)" type="text" required>
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-info btn-flat" id="check_no_telp"><i class="fas fa-check"></i> </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="bs-example">
                                        <ul class="nav nav-tabs" style="margin-bottom: 20px;">
                                            <li class="nav-item">
                                                <a href="#pbt" class="button-nav nav-link active" data-toggle="tab">Pesanan Belum Terkonfirmasi
                                                    <span class="badge badge-info right">
                                                        <?= $temp_order ?>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#pst" class="button-nav nav-link" data-toggle="tab">Pesanan Sudah Terkonfirmasi
                                                    <span class="badge badge-info right">
                                                        <?= $order ?>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="pbt">
                                                <div class="row">
                                                    <div class="order-list-tabel-main table-responsive" style="padding: 10px;">
                                                        <table class="table table-hover text-nowrap table-striped table-bordered" id="temporary_order_pelanggan" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Tanggal</th>
                                                                    <th>Kode Order</th>
                                                                    <th>Nama Pembeli</th>
                                                                    <th>Nomor Telepon</th>
                                                                    <th>Total</th>
                                                                    <th>Status Pesanan</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="pst">
                                                <div class="row">
                                                    <div class="order-list-tabel-main table-responsive" style="padding: 10px;">
                                                        <table class="table table-hover text-nowrap table-striped table-bordered" id="order_pelanggan_nonmember" style="width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Tanggal</th>
                                                                    <th>Kode Order</th>
                                                                    <th>Nama Pembeli</th>
                                                                    <th>Nomor Telepon</th>
                                                                    <th>Total</th>
                                                                    <th>Status Pesanan</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="form-group">
                                        <label>Nomor Telepon <span class="required text-danger">*</span></label>
                                        <div class="input-group">
                                            <input class="form-control border-form-control" id="telp_check" name="telp_check" placeholder="Masukkan Nomor Telepon(Whatsapp)" onkeypress="return hanyaAngka(event)" type="text" required>
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-info btn-flat" id="check_no_telp"><i class="fas fa-check"></i> </button>
                                            </span>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MODAL DETAIL ORDER -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="special-box">
                                        <div class="heading-area">
                                            <h4 class="title">
                                                Detail Order
                                            </h4>
                                        </div>
                                        <div class="table-responsive-sm">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <table class="table">
                                                        <tbody id="detail_order_kurir_1">

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-lg-6">
                                                    <table class="table">
                                                        <tbody id="detail_order_kurir_2">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-lg-12">
                                        <div class="special-box">
                                            <div class="heading-area">
                                                <h4 class="title">
                                                    Penerima Order
                                                </h4>
                                            </div>
                                            <div class="table-responsive-sm">
                                                <table class="table">
                                                    <tbody id="detail_order_kurir_3">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-lg-12">
                                        <div class="special-box">
                                            <div class="heading-area">
                                                <h4 class="title">
                                                    Detail Order
                                                </h4>
                                            </div>
                                            <div class="table-responsive-sm">
                                                <table class="table">
                                                    <tbody id="detail_order_kurir_4">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="special-box">
                                                <div class="heading-area">
                                                    <h4 class="title">
                                                        Produk Yang Di Order
                                                    </h4>
                                                </div>
                                                <br>
                                                <div class="table-responsive-sm">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th width="10%">Nomor</th>
                                                                <th class="text-center">Nama Menu</th>
                                                                <th class="text-center">Berat</th>
                                                                <th class="text-center">Harga Menu</th>
                                                                <th class="text-center">Qty</th>
                                                                <th class="text-center">Sub Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="detail_order_kurir_5" class="text-center">

                                                        </tbody>
                                                    </table>
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
            </div>

        </div>
    </div>
</div>
<!--END MODAL DETAIL ORDER-->