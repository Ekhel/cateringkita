<?php

$tanggal = date('Y-m-d');
$catatan_hari_ini = $this->db->get_where('catatan_selera', ['day(tanggal)' => date('d'), 'month(tanggal)' => date('m'), 'year(tanggal)' => date('Y')])->result_array();
$catatan_besok = $this->db->get_where('catatan_selera', ['day(tanggal)' => date('d', (strtotime('+1 day', strtotime($tanggal)))), 'month(tanggal)' => date('m'), 'year(tanggal)' => date('Y')])->result_array();

?>
<a class="nav-link" data-toggle="dropdown" href="#">
    <i class="far fa-comments"></i>
    <span class="badge badge-warning navbar-badge"><?= count($catatan_hari_ini) + count($catatan_besok) ?></span>
</a>

<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <?php if (empty($catatan_hari_ini) && empty($catatan_besok)) { ?>
        <div style="min-height: 100px; max-height: 400px; overflow: scroll;">
            <div class="dropdown-divider"></div>
            <center><img src="<?= base_url('assets/images/404.gif') ?>" width="250px" height="250px" alt=""></center>
            <center class="text-danger" style="margin-top: 10%;"><b>You Don't Have Any Message !!!</b></center>
        </div>
    <?php } else { ?>
        <span class=" dropdown-item dropdown-header"><?= count($catatan_hari_ini) + count($catatan_besok) ?> Notifications</span>
        <div style="min-height: 100px; max-height: 400px; overflow: scroll;">
            <?php if (!empty($catatan_besok)) { ?>
                <?php foreach ($catatan_besok as $o) { ?>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <img src="<?= base_url('assets/images/message.png') ?>" class="w-50 rounded-circle" style="width: 15%!important;"></i> <strong class="text-info"><?= $o['title'] ?><span class="badge badge-warning ml-2">Besok</span></strong>
                        <p class="text-sm text-justify"><?= $o['catatan'] ?></p>
                        <small class="text-danger"><b><?= format_hari_tanggal($o['tanggal']) ?></b></small>
                    </a>
                <?php } ?>
            <?php } ?>

            <?php if (!empty($catatan_hari_ini)) { ?>
                <?php foreach ($catatan_hari_ini as $o) { ?>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <img src="<?= base_url('assets/images/message.png') ?>" class="w-50 rounded-circle" style="width: 15%!important;"></i> <strong class="text-info"><?= $o['title'] ?><span class="badge badge-success ml-2">Hari Ini</span></strong>
                        <p class="text-sm text-justify"><?= $o['catatan'] ?></p>
                        <small class="text-danger"><b><?= format_hari_tanggal($o['tanggal']) ?></b></small>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>

        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
    <?php }  ?>
</div>