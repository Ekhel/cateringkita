<?php
if (in_array('1', $dataTampunganRole) || in_array('2', $dataTampunganRole) || in_array('4', $dataTampunganRole)) {
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
                            <div class="col-lg-12">
                                <div class="special-box">
                                    <div class="heading-area">
                                        <h4 class="title">
                                            Detail Order
                                        </h4>
                                    </div>
                                    <div class="table-responsive-sm">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input type="hidden" name="kd_order" id="kd_order" value="<?= $order_member['kd_order'] ?>">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th class="45%" width="45%">Kode Order</th>
                                                            <td width="10%">:</td>
                                                            <td class="45%" width="45%"><?= $order_member['kd_order'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">Total Pembayaran</th>
                                                            <td width="10%">:</td>
                                                            <td class="45% rupiah-mask txt_total_transfer" width="45%"><?= $order_member['total_transfer'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">Tanggal Order</th>
                                                            <td width="10%">:</td>
                                                            <td class="45%" width="45%"><?= format_hari_tanggal($order_member['tgl_order']) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">Status Order</th>
                                                            <td width="10%">:</td>
                                                            <td class="45%" width="45%" id="status_order">
                                                                <?php
                                                                switch ($order_member['order_status']) {
                                                                    case 'pending':
                                                                        echo "Pending";
                                                                        break;
                                                                    case 'onprocess':
                                                                        echo "Diproses";
                                                                        break;
                                                                    case 'ondelivery':
                                                                        echo "Dikirim";
                                                                        break;
                                                                    case 'rejected':
                                                                        echo "Ditolak";
                                                                        break;
                                                                    case 'done':
                                                                        echo "Selesai";
                                                                        break;
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th width="45%">Status Pembayaran</th>
                                                            <td width="10%">:</td>
                                                            <?php $data_bukti_pembayaran = $this->db->get_where('bukti_pembayaran', ['kd_order' => $order_member['kd_order']])->result_array(); ?>
                                                            <td class="45%" width="45%"><span class="badge <?= $order_member['payment_status'] == 0 ? 'badge-danger' : 'badge-success' ?>" id="status_bayar" style="padding: 5%;">
                                                                    <?= $order_member['payment_status'] == 0 ? "Belum Dibayar" : "Sudah Dibayar"  ?> </span>
                                                                <?php if (in_array('1', $dataTampunganRole)) { ?>
                                                                    <button class="btn btn-warning mt-2 btn-stat-pem" data-id="<?= $order_member['kd_order'] ?>" style="font-size: 13px;"> <i class="fa fa-edit"></i> Edit Pembayaran</button>
                                                                    <?php if ($order_member['payment_status'] == 0) { ?>
                                                                        <br>
                                                                        <div class="bagian_bukti_pembayaran" style="<?= count($data_bukti_pembayaran) > 0 ? "" : "display: none;" ?>">
                                                                            <button class="btn btn-success mt-2 button_konfirmasi" data-id="<?= $order_member['kd_order'] ?>" style="font-size: 13px;"> <i class="fa fa-check"></i> Konfirmasi</button>
                                                                            <button class="btn btn-danger mt-2 button_tolak" data-id="<?= $order_member['kd_order'] ?>" style="font-size: 13px;"> <i class="fa fa-trash"></i> Hapus</button>
                                                                        </div>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">Keterangan Order</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%" style="text-align: justify;"><?= $order_member['catatan_order'] ?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-lg-6">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <th width="45%">Nama Pengirim</th>
                                                            <td width="10%">:</td>
                                                            <td width="45%"><?= !empty($order_member['nm_member']) ? $order_member['nm_member'] : $order_member['cust_name'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">Email</th>
                                                            <td width="10%">:</td>
                                                            <td width="45%"><?= !empty($order_member['email']) ? $order_member['email'] : $order_member['cust_email'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">Telepon</th>
                                                            <td width="10%">:</td>
                                                            <td width="45%"><?= !empty($order_member['no_telp']) ? $order_member['no_telp'] : $order_member['cust_phone'] ?>
                                                                <?php if (in_array('1', $dataTampunganRole)) { ?>
                                                                    <a class="btn btn-sm btn-success" target="_blank" href="https://api.whatsapp.com/send?phone=<?= $order_member['cust_phone'] ?>"><i class="far fa-comments"></i></a>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">Kode Pos</th>
                                                            <td width="10%">:</td>
                                                            <td width="45%"><?= !empty($order_member['kodepos']) ? $order_member['kodepos'] : $order_member['cust_office'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">Alamat</th>
                                                            <td width="10%">:</td>
                                                            <td width="45%" style="text-align: justify;"><?= $order_member['cust_address'] ?></td>
                                                        </tr>
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

                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <!-- <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div> -->
                        <!-- /.card-header -->
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
                                            <tbody>
                                                <tr>
                                                    <th width="45%">Nama Penerima</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%"><?= $order_member['cust_name'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th width="45%">Email Penerima</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%"><?= $order_member['cust_email'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th width="45%">No. Telepon Penerima</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%"><?= $order_member['cust_phone'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th width="45%">Kode Pos Penerima</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%"><?= $order_member['cust_office'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th width="45%">Alamat Penerima</th>
                                                    <td width="10%">:</td>
                                                    <td width="45%" style="text-align: justify;"><?= $order_member['cust_address'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
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
                                        <?php
                                        if ($order_member['payment_type'] == "ambil_langsung") {
                                            $payment_type = "Tunai";
                                        } else if ($order_member['payment_type'] == "cod") {
                                            $payment_type = "COD";
                                        } else if ($order_member['payment_type'] == "transfer") {
                                            $payment_type = "Transfer";
                                        } else if ($order_member['payment_type'] == "kredit") {
                                            $payment_type = "Kredit";
                                        }
                                        ?>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th class="45%" width="45%">Metode Pembayaran</th>
                                                    <td width="10%">:</td>
                                                    <td class="45%" width="45%"><span class="met-pem-det"><?= $payment_type ?></span> &ensp;
                                                        <?php if (in_array('1', $dataTampunganRole)) { ?>
                                                            <button class="btn btn-sm btn-warning mt-2 btn-met-pem" data-id="<?= $order_member['kd_order'] ?>" style="font-size: 13px;"> <i class="fa fa-edit"></i> Edit Metode</button>
                                                            <button type="button" id="buttoneditkredit" data-toggle="modal" data-target="#Modal_Add_Kredit" class="btn btn-sm btn-primary" style="<?= $payment_type == "Kredit" ? "" : "display:none"; ?>"><i class="fa fa-edit"></i> Input Kredit</button>
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                                <?php if ($order_member['payment_type'] == "transfer" || $order_member['payment_type'] == "kredit") { ?>
                                                    <tr>
                                                        <?php if ($order_member['payment_type'] == "transfer") {  ?>
                                                            <th width="45%">Bukti Transfer</th>
                                                        <?php } else if ($order_member['payment_type'] == "kredit") {  ?>
                                                            <th width="45%">Bukti Pembayaran</th>
                                                        <?php }  ?>
                                                        <td width="10%">:</td>
                                                        <td id="bagian_bukti" style="<?= $rows_bukti_pembayaran > 0 ? '' : 'display: none;'; ?>">
                                                            <div class="position-relative">
                                                                <img src="<?= $bukti_pembayaran ? base_url('assets/images/bukti_pembayaran/' . $bukti_pembayaran['bukti_upload']) : "" ?>" alt="" id="review_bukti" class="bkt_pembayaran img-fluid">
                                                                <?php if (in_array('1', $dataTampunganRole)) { ?>
                                                                    <div class="ribbon-wrapper ribbon-sm">
                                                                        <a href="javascript:void(0);" class="tombol_hapus_transfer">
                                                                            <div class="ribbon bg-light text-lg">
                                                                                <span aria-hidden="true" class="fa fa-minus-circle"></span>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                        <td id="bagian_bukti_1" style="<?= $rows_bukti_pembayaran == 0 ? '' : 'display: none;'; ?>">
                                                            <?= "Bukti Belum Diupload!" ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <!-- <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div> -->
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="special-box">
                                        <div class="heading-area">
                                            <h4 class="title">
                                                Produk Yang Di Order
                                            </h4>
                                        </div>
                                        <input type="hidden" name="kd_order" id="kd_order" value="<?= $kd_order ?>">
                                        <input type="hidden" name="kd_member1" id="kd_member1" value="<?= $order_member['kd_member'] ?>">
                                        <br>
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered table-hover" id="mytableOrderProduk">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="10%">Nomor</th>
                                                        <th class="text-center">Nama Menu</th>
                                                        <th class="text-center">Harga Menu</th>
                                                        <th class="text-center">Qty</th>
                                                        <th class="text-center">Sub Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    for ($i = 0; $i < count($detail_order); $i++) {
                                                        $this->db->select("*, detail_order.qty as qtyy, produk.nm_produk as nm_produkk");
                                                        $this->db->from("produk");
                                                        $this->db->join("detail_order", "detail_order.kd_produk=produk.kd_produk");
                                                        $this->db->where(['detail_order.kd_detail_order' => $detail_order[$i]['kd_detail_order']]);
                                                        $data = $this->db->get()->row_array();

                                                    ?>
                                                        <tr>
                                                            <td class="text-center" width="10%"><?= $no++ ?></td>
                                                            <td class="text-center"><b><?= $data['nm_produkk'] ?></b> <br><?= $data['deskripsi'] ?> </td>
                                                            <td class="text-center rupiah-mask"><?= $data["harga_produk"] ?></td>
                                                            <td class="text-center"><?= $data['qtyy'] ?></td>
                                                            <td class="text-center rupiah-mask"><?= $data["sub_total"] ?></td>
                                                        </tr>
                                                    <?php } ?>
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
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!--MODAL DELETE-->
<form id="edit_status_order">
    <div class="modal fade" id="modal_edit_status_order" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Status Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Are you sure to Edit this record?</strong>
                    <div class="form-group row mt-3" id="kurir" style="display: <?= $order_member['pilihan_kurir'] == "" ? "none" : "" ?>;">
                        <div class="col-md-3">
                            <label>Pilih Kurir</label>
                        </div>
                        <div class="col-md-9">
                            <select name="kurir" class="form-control select2kurir">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="detail_order_code_edit" id="detail_order_code_edit" class="form-control">
                    <input type="hidden" name="status_edit" id="status_edit" class="form-control">
                    <input type="hidden" name="kd_reseller" id="kd_reseller" class="form-control">
                    <input type="hidden" name="kd_member" id="kd_member" class="form-control">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->

<!-- Modal Tracking -->
<div class="modal fade" id="ModalOrderTracking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Order Tracking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body-track">
                <table class="table table-striped table-bordered text-center" id="myTableOrderTracking">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Status Order</th>
                            <th>Tanggal Input</th>
                            <th>Diinput Oleh</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="bodyTracking">

                    </tbody>
                </table>
                <div class="orderTracking">
                    <div class="Tracking"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal End Tracking -->

<!--MODAL DELETE-->
<form id="hapusTracking">
    <div class="modal fade" id="hapusModalTacking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Order Tracking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Are you sure to delete this record?</strong>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="kd_tracking" id="tracking_code_delete" class="form-control">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->

<!-- Modal Upload Bukti Pembayaran -->
<form id="uploadBuktiPembayaran">
    <div class="modal fade setgallery" id="ModalUploadPembayaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Bukti Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- <input class="custom-file-label" type="file" id="multiFiles" /> -->
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="multiFiles" name="userfile[]" multiple="multiple" aria-describedby="inputGroupFileAddon01">
                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                    </div>
                    <br><br>

                    <div class="gallery-images">
                        <div class="selected-image" id="selected-image_prev">
                            <div class="row" id="row_prev_gallery"></div>
                        </div>
                        <input type="hidden" name="totalimagereview" id="totalimagereview" value="0">
                        <input type="hidden" name="kd_reseller" id="kd_reseller" class="form-control">
                        <input type="hidden" name="kd_order" id="kd_orderr">
                    </div>
                    <!-- <img src="" class="mt-2" width="150px" height="150px" id="imgVieww" name="gambarBaru" alt=""> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_save" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Modal End Upload Bukti Pembayaran -->

<!-- modal edit pengiriman -->
<form id="edit_pengiriman">
    <div class="modal fade" id="modal_edit_pengiriman" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Kurir Pengiriman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row mt-3">
                        <div class="col-md-3">
                            <label>Pilih Kurir</label>
                        </div>
                        <div class="col-md-9">
                            <?php
                            $this->db->select('*');
                            $this->db->from("admin");
                            $this->db->join("user_role", "admin.kd_admin=user_role.kd_user");
                            $this->db->where(["user_role.kd_role" => '5']);
                            $get = $this->db->get()->result_array();
                            ?>
                            <select name="kurir" id="edit_kurir" class="form-control select2kurir">
                                <?php foreach ($get as $k) { ?>
                                    <option value="<?= $k['kd_admin'] ?>"><?= $k['nm_admin'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="kd_pengiriman" id="kd_pengiriman">
                    <input type="hidden" id="kurir_name_edit">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- end modal edit pengiriman -->
<!-- modal input ongkir -->
<form id="addOngkirLain">
    <div class="modal fade" id="Modal_Add_Ongkir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Ongkir Ekspedisi Lain</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Biaya Ongkir</label>
                        <input type="text" class="form-control input-rupiah-mask" name="ongkir" id="ongkir" value="<?= $order_member['ongkir'] ?>" placeholder="Biaya Ongkir" required>
                        <input type="hidden" class="form-control input-rupiah-mask" id="ongkir_lama" value="<?= $order_member['ongkir'] ?>" placeholder="Biaya Ongkir" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="kd_order" value="<?= $order_member['kd_order'] ?>">
                    <input type="hidden" name="total_transfer" id="total_transfer" value="<?= $order_member['total_transfer'] ?>">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="addKredit">
    <div class="modal fade" id="Modal_Add_Kredit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Biaya Kredit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Biaya Kredit</label>
                        <input type="text" class="form-control input-rupiah-mask" name="kredit" id="kredit" value="<?= $order_member['total_transfer'] ?>" placeholder="Biaya Ongkir" required readonly>
                        <input type="hidden" class="form-control input-rupiah-mask" name="kredit" id="sisa_total_kredit" value="<?= $order_member['total_transfer'] ?>" placeholder="Biaya Ongkir" required readonly>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6 col-xs-6 col-6 bagian_cicil" style="display: none;">
                            <label>Sudak Dibayar</label>
                        </div>
                        <div class="form-group col-md-6 col-xs-6 col-6 bagian_cicil" style="display: none;">
                            <label>Tanggal Bayar</label>
                        </div>
                        <div class="col-md-12 col-xs-12 col-12 bagian_cicil" style="margin-top: -15px;margin-bottom: 15px;display: none;">
                            <div class="row" id="bagian_form_cicil">

                            </div>
                        </div>
                        <div class="form-group col-md-6 col-xs-6 col-6">
                            <label>Nominal Bayar</label>
                            <input type="text" class="form-control input-rupiah-mask" name="nominal_kredit" id="nominal_kredit" placeholder="Nominal Bayar" required>
                        </div>
                        <div class="form-group col-md-6 col-xs-6 col-6">
                            <label>Sisa</label>
                            <input type="text" class="form-control input-rupiah-mask" name="sisa_kredit" id="sisa_kredit" placeholder="Sisa Kredit" required readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="kd_order" value="<?= $order_member['kd_order'] ?>">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- end modal input ongkir -->

<!-- Modal -->
<div class="modal fade" id="modal_bukti_penerimaan" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bukti-foto" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body-track">
                <div class="gmbr"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<form id="edit_stat_pembayaran">
    <div class="modal fade" id="update-status-pembayaran">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Status Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="body-track">
                    <div class="form-group col-md-12 col-xs-12 col-12">
                        <label>Status Pembayaran</label>
                        <select name="stat_pembayaran" id="stat_pembayaran" class="form-control">
                            <option value="0">Belum Dibayar</option>
                            <option value="1">Sudah Dibayar</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal -->
<form id="edit_met_pembayaran">
    <div class="modal fade" id="update-metode-pembayaran">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Metode Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="body-track">
                    <div class="form-group col-md-12 col-xs-12 col-12">
                        <label>Metode Pembayaran</label>
                        <select name="met_pembayaran" id="met_pembayaran" class="form-control">
                            <option value="transfer">Transfer</option>
                            <option value="cod">COD</option>
                            <option value="ambil_langsung">Tunai</option>
                            <option value="kredit">Kredit</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</form>