<?php
$admin = $this->db->get_where('admin', ['kd_admin' => $this->session->userdata('kd_admin')])->row_array();

$this->db->select("*");
$this->db->from("produk");
$this->db->where(['is_produk_aktif' => "1", 'is_produk_hapus' => "1"]);
$this->db->order_by('nm_produk', 'asc');
$produk = $this->db->get()->result_array();
?>
<a class="nav-link" data-toggle="dropdown" href="#">
    <i class="fas fa-clipboard-list"></i>
    <span class="badge badge-warning navbar-badge"><?= count($produk) ?></span>
</a>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

    <?php if (empty($produk)) { ?>
        <div style="min-height: 100px; max-height: 400px; overflow: scroll;">
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <center><img src="<?= base_url('assets/images/404.gif') ?>" width="250px" height="250px" alt=""></center>
                <center class="text-danger" style="margin-top: 10%;"><b>You Don't Have Any Product !!!</b></center>
            </a>
        </div>
    <?php } else if (!empty($produk)) { ?>
        <span class=" dropdown-item dropdown-header"><?= count($produk) ?> Notifications Stock of Produk</span>
        <div style="min-height: 100px; max-height: 400px; overflow: scroll;">
            <?php foreach ($produk as $pro) { ?>
                <div class="dropdown-divider"></div>
                <a href="<?= base_url('product/edit_product/' . $pro['kd_produk']) ?>" class="dropdown-item">
                    <img src="<?= base_url('assets/images/message.png') ?>" class="w-50 rounded-circle" style="width: 15%!important;"></i> <strong class="text-info"><?= $pro['nm_produk'] . " (" . $pro['berat'] . " " . $pro['satuan_berat'] . ")" ?></strong>
                    <p class="text-sm text-justify text-danger"><b><?= "Sisa Stok " . $pro['stok'] ?></b></p>
                </a>
            <?php } ?>
        </div>

        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    <?php }  ?>
</div>