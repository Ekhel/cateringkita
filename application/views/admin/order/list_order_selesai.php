<?php

$tanggal = date('Y-m-d');
$admin = $this->db->get_where('admin', ['kd_admin' => $this->session->userdata('kd_admin')])->row_array();
$order_done = $this->db->get_where('order', ['read_order' => 1, 'order_status' => 'done', 'tgl_order' => $tanggal, 'is_order_hapus' => '1', 'order_toko' => $admin['toko']])->result_array();

?>
<a class="nav-link" data-toggle="dropdown" href="#">
    <i class="fas fa-bell" style="color: #C0C0C0;"></i>
    <span class="badge badge-warning navbar-badge"><?= count($order_done) ?></span>
</a>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <?php if (empty($order_done)) { ?>
        <div style="min-height: 100px; max-height: 400px; overflow: scroll;">
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <center><img src="<?= base_url('assets/images/404.gif') ?>" width="250px" height="250px" alt=""></center>
                <center class="text-danger" style="margin-top: 10%;"><b>You Don't Have Any Message !!!</b></center>
            </a>
        </div>
    <?php } else if (!empty($order_done)) { ?>
        <span class=" dropdown-item dropdown-header"><?= count($order_done) ?> Notifications</span>
        <div style="min-height: 100px; max-height: 400px; overflow: scroll;">
            <?php foreach ($order_done as $o) { ?>
                <div class="dropdown-divider"></div>
                <a href="<?= base_url('order/read_order/' . $o['kd_order']) ?>" class="dropdown-item">
                    <img src="<?= base_url('assets/images/message.png') ?>" class="w-50 rounded-circle" style="width: 15%!important;"></i> <strong class="text-info"><?= $o['cust_name'] ?><span class="badge badge-success ml-2">Orderan Baru</span></strong>
                    <p class="text-sm text-justify"><?= $o['cust_address'] ?></p>
                    <small class="text-danger"><b><?= format_hari_tanggal($o['tgl_order']) ?></b></small>
                </a>
            <?php } ?>
        </div>

        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    <?php } ?>
</div>