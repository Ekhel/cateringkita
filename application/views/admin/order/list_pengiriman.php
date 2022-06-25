<?php
$this->db->select("*");
$this->db->from("pengiriman");
$this->db->join("order", "pengiriman.kd_order=order.kd_order");
$this->db->where(['kd_kurir' => $this->session->userdata('kd_masak'), 'read_pengiriman' => 0, 'is_order_hapus' => '1', 'order.order_status' => 'ondelivery']);
$pengiriman = $this->db->get()->result_array();


$tanggal = date('Y-m-d');
$this->db->select("*");
$this->db->from("pengiriman");
$this->db->join("order", "pengiriman.kd_order=order.kd_order");
$this->db->where(['kd_kurir' => $this->session->userdata('kd_masak'), 'read_order' => 1, 'is_order_hapus' => '1', 'order_status' => 'done', 'tgl_order' => $tanggal]);
$order_done = $this->db->get()->result_array();
?>
<a class="nav-link" data-toggle="dropdown" href="#">
    <i class="far fa-bell"></i>
    <span class="badge badge-warning navbar-badge"><?= count($pengiriman) ?></span>

    <span class="badge badge-warning navbar-badge"><?= count($pengiriman) + count($order_done) ?></span>
</a>
<ul class="dropdown-menu">
    <li class="head text-light bg-dark">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-12">
                <span>Notifications (<?= count($pengiriman) + count($order_done) ?>)</span>
            </div>
        </div>
    </li>
    <?php if (empty($pengiriman) && empty($order_done)) { ?>
        <div class="drop-content">
            <li class="notification-box" style="padding: 28px 0px;">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-12 text-center">
                        You Don't Have Any Message !!!
                    </div>
                </div>
            </li>
        </div>
    <?php } else if (!empty($pengiriman || !empty($order_done))) { ?>
        <?php foreach ($pengiriman as $p) { ?>
            <div class="drop-content">
                <li class="notification-box">
                    <div class="row">
                        <div class="col-lg-3 col-sm-3 col-3 text-center">
                            <a href="javascript:void(0);" class="detail_order" data-id="<?= $p['kd_order'] ?>">
                                <img src="<?= base_url('assets/images/message.png') ?>" class="w-50 rounded-circle" style="width: 70%!important;">
                            </a>
                        </div>
                        <div class="col-lg-9 col-sm-9 col-9">
                            <strong class="text-info"><?= $p['cust_name'] ?><font style="color: green;"> (Paket Baru)</font></strong>
                            <div>
                                Alamat : <?= strip_tags($p['cust_address']) ?>
                            </div>
                            <small class="text-warning"><?= format_hari_tanggal($p['tgl_order'], "jam") ?></small>
                        </div>
                    </div>
                </li>
            </div>
        <?php } ?>
        <?php foreach ($order_done as $p) { ?>
            <div class="drop-content">
                <li class="notification-box">
                    <div class="row">
                        <div class="col-lg-3 col-sm-3 col-3 text-center">
                            <a href="javascript:void(0);" class="detail_order" data-id="<?= $p['kd_order'] ?>">
                                <img src="<?= base_url('assets/images/message.png') ?>" class="w-50 rounded-circle" style="width: 70%!important;">
                            </a>
                        </div>
                        <div class="col-lg-9 col-sm-9 col-9">
                            <strong class="text-info"><?= $p['cust_name'] ?><font style="color: green;"> (Paket Selesai Diantar)</font></strong>
                            <div>
                                Alamat : <?= strip_tags($p['cust_address']) ?>
                            </div>
                            <small class="text-warning"><?= format_hari_tanggal($p['tgl_order'], "jam") ?></small>
                        </div>
                    </div>
                </li>
            </div>
        <?php } ?>
    <?php } ?>
    <li class="footer bg-dark text-center">
        <a href="" class="text-light">View All</a>
    </li>
</ul>