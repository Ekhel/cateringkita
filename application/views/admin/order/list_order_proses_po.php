<?php

$admin = $this->db->get_where('admin', ['kd_admin' => $this->session->userdata('kd_admin')])->row_array();

$order_nonmember = $this->db->get_where('temporary_order', ['read_order' => 0, 'order_status' => 'onprocess', 'order_toko' => $admin['toko']])->result_array();
$order = $this->db->get_where('order', ['read_order' => 0, 'order_status' => 'onprocess', 'is_order_hapus' => '1', 'order_toko' => $admin['toko']])->result_array();

$this->db->select("kd_role");
$this->db->from("admin");
$this->db->join("user_role", "admin.kd_admin=user_role.kd_user");
$this->db->where("admin.kd_admin", $this->session->userdata('kd_admin'));
$role = $this->db->get()->result_array();

$dataTampunganRole = [];
$TampunganPoMember = [];
$TampunganPoNonMember = [];

$hasilNotifMember = [];
$AngkaNotifMember = [];
$hasilNotifNonMember = [];
$AngkaNotifNonMember = [];

// Periksa Data Pesanan Dari Member, Reseller & Admin
if ($order) {
    foreach ($order as $ord) {
        $this->db->select("*");
        $this->db->from("order");
        $this->db->join("detail_order", "order.kd_order=detail_order.kd_order");
        $this->db->join("produk", "produk.kd_produk=detail_order.kd_produk");
        $this->db->where(['read_order' => 0, 'order_status' => 'onprocess', 'is_order_hapus' => '1', 'order.kd_order' => $ord['kd_order']]);
        $data = $this->db->get()->result_array();

        foreach ($data as $dt) {
            if ($dt['jns_produk'] == "po") {
                array_push($TampunganPoMember, $dt['kd_order']);
            }
        }

        if (count($TampunganPoMember) > 0) {
            $this->db->select("*");
            $this->db->from("order");
            $this->db->join("detail_order", "order.kd_order=detail_order.kd_order");
            $this->db->join("produk", "produk.kd_produk=detail_order.kd_produk");
            $this->db->where(['read_order' => 0, 'order_status' => 'onprocess', 'is_order_hapus' => '1', 'order.kd_order' => $ord['kd_order']]);
            $this->db->group_by("order.kd_order");
            $order = $this->db->get()->result_array();
            if ($order) {
                array_push($hasilNotifMember, $order);
                array_push($AngkaNotifMember, 1);
            }
        } else {
            array_push($AngkaNotifMember, 0);
        }

        // untuk menghapus data push array di data yang sebelum nya
        foreach (array_keys($TampunganPoMember, $ord['kd_order']) as $key) {
            unset($TampunganPoMember[$key]);
        }
    }
} else {
    array_push($AngkaNotifMember, 0);
}

// Periksa Data Pesanan Dari Non Member
if ($order_nonmember) {
    foreach ($order_nonmember as $ord) {
        $this->db->select("*");
        $this->db->from("temporary_order");
        $this->db->join("temporary_detail_order", "temporary_order.kd_temporary_order=temporary_detail_order.kd_temporary_order");
        $this->db->join("produk", "produk.kd_produk=temporary_detail_order.kd_produk");
        $this->db->where(['read_order' => 0, 'order_status' => 'onprocess', 'temporary_order.kd_temporary_order' => $ord['kd_temporary_order']]);
        $data = $this->db->get()->result_array();

        foreach ($data as $dt) {
            if ($dt['jns_produk'] == "po") {
                array_push($TampunganPoNonMember, $dt['kd_temporary_order']);
            }
        }

        if (count($TampunganPoNonMember) > 0) {
            $this->db->select("*");
            $this->db->from("temporary_order");
            $this->db->join("temporary_detail_order", "temporary_order.kd_temporary_order=temporary_detail_order.kd_temporary_order");
            $this->db->join("produk", "produk.kd_produk=temporary_detail_order.kd_produk");
            $this->db->where(['read_order' => 0, 'order_status' => 'onprocess', 'temporary_order.kd_temporary_order' => $ord['kd_temporary_order']]);
            $this->db->group_by("temporary_order.kd_temporary_order");
            $order_nonmember = $this->db->get()->result_array();

            array_push($hasilNotifNonMember, $order_nonmember);
            array_push($AngkaNotifNonMember, 1);
        } else {
            array_push($AngkaNotifNonMember, 0);
        }

        // untuk menghapus data push array di data yang sebelum nya
        foreach (array_keys($TampunganPoNonMember, $ord['kd_temporary_order']) as $key) {
            unset($TampunganPoNonMember[$key]);
        }
    }
} else {
    array_push($AngkaNotifNonMember, 0);
}

for ($i = 0; $i < count($role); $i++) {
    array_push($dataTampunganRole, $role[$i]['kd_role']);
};

if (in_array("8", $dataTampunganRole) && in_array("9", $dataTampunganRole)) {
    $this->db->select("*");
    $this->db->from("order");
    $this->db->where(['read_order' => 0, 'order_status' => 'pending', 'is_order_hapus' => '1']);
    $this->db->or_where(['read_order' => 0, 'order_status' => 'onprocess', 'is_order_hapus' => '1']);
    $order = $this->db->get()->result_array();
}

$tanggal = date('Y-m-d');
?>
<a class="nav-link" data-toggle="dropdown" href="#">
    <i class="fas fa-bell" style="color: pearl;"></i>
    <span class="badge badge-warning navbar-badge"><?= array_sum($AngkaNotifMember) + array_sum($AngkaNotifNonMember) ?></span>
</a>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <?php if (empty($hasilNotifMember) && empty($hasilNotifNonMember)) { ?>
        <div style="min-height: 100px; max-height: 400px; overflow: scroll;">
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
                <center><img src="<?= base_url('assets/images/404.gif') ?>" width="250px" height="250px" alt=""></center>
                <center class="text-danger" style="margin-top: 10%;"><b>You Don't Have Any Message !!!</b></center>
            </a>
        </div>
    <?php } else if (!empty($hasilNotifMember) || !empty($hasilNotifNonMember)) { ?>
        <span class=" dropdown-item dropdown-header"><?= array_sum($AngkaNotifMember) + array_sum($AngkaNotifNonMember) ?> Notifications</span>
        <div style="min-height: 100px; max-height: 400px; overflow: scroll;">
            <?php foreach ($hasilNotifMember as $order) { ?>
                <?php foreach ($order as $o) { ?>
                    <div class="dropdown-divider"></div>
                    <a href="<?= base_url('order/read_order/' . $o['kd_order']) ?>" class="dropdown-item">
                        <img src="<?= base_url('assets/images/message.png') ?>" class="w-50 rounded-circle" style="width: 15%!important;"></i> <strong class="text-info"><?= $o['cust_name'] ?><span class="badge badge-success ml-2">Orderan Baru</span></strong>
                        <p class="text-sm text-justify"><?= $o['cust_address'] ?></p>
                        <small class="text-danger"><b><?= format_hari_tanggal($o['tgl_order']) ?></b></small>
                    </a>
                <?php } ?>
            <?php } ?>

            <?php foreach ($hasilNotifNonMember as $order_nonmember) { ?>
                <?php foreach ($order_nonmember as $o) { ?>
                    <div class="dropdown-divider"></div>
                    <a href="<?= base_url('order/read_temporary_order/' . $o['kd_temporary_order']) ?>" class="dropdown-item">
                        <img src="<?= base_url('assets/images/message.png') ?>" class="w-50 rounded-circle" style="width: 15%!important;"></i> <strong class="text-info"><?= $o['cust_name'] ?><span class="badge badge-success ml-2">Orderan Baru NonMember</span></strong>
                        <p class="text-sm text-justify"><?= $o['cust_address'] ?></p>
                        <small class="text-danger"><b><?= format_hari_tanggal($o['tgl_order']) ?></b></small>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>

        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    <?php } ?>
</div>