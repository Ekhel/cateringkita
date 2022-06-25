<?php
$admin = $this->db->get_where('admin', ['kd_admin' => $this->session->userdata('kd_admin')])->row_array();

$this->db->select("*");
$this->db->from("order");
$this->db->join("detail_order", "order.kd_order=detail_order.kd_order");
$this->db->join("reseller", "order.kd_reseller=reseller.kd_reseller");
$this->db->where("order.tgl_order <= curdate() - interval 2 day");
$this->db->where(['is_order_hapus' => "1", 'payment_status' => '0']);
$this->db->group_by("order.kd_order", "ASC");
$order = $this->db->get()->result_array();

?>
<a class="nav-link" data-toggle="dropdown" href="#">
    <i class="fas fa-bell"></i>
    <span class="badge badge-warning navbar-badge"><?= count($order) ?></span>
</a>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

    <?php if (empty($order)) { ?>
        <div style="min-height: 100px; max-height: 400px; overflow: scroll;">
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <center><img src="<?= base_url('assets/images/404.gif') ?>" width="250px" height="250px" alt=""></center>
                <center class="text-danger" style="margin-top: 10%;"><b>You Don't Have Any Order !!!</b></center>
            </a>
        </div>
    <?php } else if (!empty($order)) { ?>
        <span class=" dropdown-item dropdown-header"><?= count($order) ?> Notifications Pembayaran Order</span>
        <div style="min-height: 100px; max-height: 400px; overflow: scroll;">
            <?php foreach ($order as $pro) { ?>
                <div class="dropdown-divider"></div>
                <a href="<?= base_url('order/detail_pesanan/' . $pro['kd_order']) ?>" class="dropdown-item">
                    <img src="<?= base_url('assets/images/message.png') ?>" class="w-50 rounded-circle" style="width: 15%!important;"></i> <strong class="text-info"><?= $pro['nm_reseller'] ?></strong>
                    <p class="text-sm text-justify text-danger"><b><?= date('d-m-Y', strtotime($pro['tgl_order'])), " - " . strtoupper($pro['payment_type']) ?></b></p>
                </a>
            <?php } ?>
        </div>

        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    <?php }  ?>
</div>