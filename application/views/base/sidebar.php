<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php
    $sess_masak = $this->session->userdata('kd_masak');
    $sess_admin = $this->session->userdata('kd_admin');
    $sess_kurir = $this->session->userdata('kd_kurir');

    if ($sess_masak) {
        $tabel = "masak";
        $sess = "masak";
    } else if ($sess_admin) {
        $tabel = "admin";
        $sess = "admin";
    } else if ($sess_kurir) {
        $tabel = "kurir";
        $sess = "kurir";
    }

    $logo = $this->db->get('logo')->row_array();
    $konfigurasi = $this->db->get('konfigurasi')->row_array();

    $this->db->select("kd_role");
    if ($sess_masak) {
        $this->db->from("masak");
    } else if ($sess_admin) {
        $this->db->from("admin");
    } else if ($sess_kurir) {
        $this->db->from("kurir");
    }
    $this->db->join("user_role", "$tabel.kd_$tabel=user_role.kd_user");
    if ($sess_masak) {
        $this->db->where("$tabel.kd_$tabel", $this->session->userdata("kd_$sess"));
    } else if ($sess_admin) {
        $this->db->where("$tabel.kd_$tabel", $this->session->userdata("kd_$sess"));
    } else if ($sess_kurir) {
        $this->db->where("$tabel.kd_$tabel", $this->session->userdata("kd_$sess"));
    }
    $role = $this->db->get()->result_array();

    $dataTampunganRole = [];

    for ($i = 0; $i < count($role); $i++) {
        array_push($dataTampunganRole, $role[$i]['kd_role']);
    };

    ?>
    <a href="<?= base_url('dashboard'); ?>" class="brand-link">
        <img src="<?= !empty($logo['nm_logo']) ? base_url('assets/images/logo_website/' . $logo['nm_logo']) : base_url('assets/images/noimage.png') ?>" alt="AdminLTE Logo" id="logo-seleraa" class="brand-image img-thumbnail bg-transparent border-transparent">
        <span class="brand-text font-weight-light" style="font-size: 20px; font-weight: bold;"><b><?= $konfigurasi['nama_toko'] != "" ? $konfigurasi['nama_toko'] : "" ?></b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image mt-2">
                <?php $data = $this->db->get_where("$tabel", ["kd_$tabel" => $this->session->userdata("kd_$sess")])->row_array(); ?>

                <img src="<?= base_url(); ?>assets/images/user/<?= $data['image']; ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <?php if ($sess_admin) { ?>
                    <span href="#" class="d-block text-white">Administrator</span>
                <?php } else if ($sess_masak) { ?>
                    <span href="#" class="d-block text-white">Pemasak</span>
                <?php } ?>

                <span href="#" class="d-block text-white" style="font-size: 14px;"><?= $data["nm_$tabel"] ?></span>

            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link <?= $this->uri->segment(1) == 'dashboard' ? ' active' : '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <?php if (in_array('1', $dataTampunganRole)) { ?>
                    <li class="nav-header">Master</li>
                    <li class="nav-item">
                        <a href="<?= base_url('custom') ?>" class="nav-link <?= $this->uri->segment(1) == 'custom' && $this->uri->segment(2) == ''  ? ' active' : '' ?>">
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>
                                Menu Custom
                            </p>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="<?= base_url('kategori') ?>" class="nav-link <?= $this->uri->segment(1) == 'kategori' && $this->uri->segment(2) == ''  ? ' active' : '' ?>">
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>
                                Kategori
                            </p>
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a href="<?= base_url('kategori/sub_kategori') ?>" class="nav-link <?= $this->uri->segment(1) == 'kategori' && $this->uri->segment(2) == 'sub_kategori' ? ' active' : '' ?>">
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>
                                Sub Kategori
                            </p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview<?= $this->uri->segment(1) == 'product' ? ' menu-open' : '' ?>">
                        <a href="#" class="nav-link<?= $this->uri->segment(1) == 'product' ? ' active' : '' ?>">
                            <i class="nav-icon fas fa-cart-plus"></i>
                            <p>
                                Kelola Menu
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('product/add_produk') ?>" class="nav-link <?= $this->uri->segment(2) == 'add_produk' ? ' active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tambah Menu</p>
                                </a>
                            </li>
                            <li class="nav-item user-panel has-treeview<?= $this->uri->segment(1) == 'product' &&  ($this->uri->segment(2) == 'daftar_produk' || $this->uri->segment(2) == 'daftar_produk_nonAktif') ? ' menu-open' : '' ?>">
                                <a href="javascript::" class="nav-link<?= $this->uri->segment(1) == 'product' &&  $this->uri->segment(2) == 'daftar_produk' || $this->uri->segment(2) == 'daftar_produk_nonAktif' ? ' active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Daftar Menu
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('product/daftar_produk'); ?>" class="nav-link<?= $this->uri->segment(2) == 'daftar_produk' ? ' active' : '' ?>">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>Menu Aktif</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('product/daftar_produk_nonAktif'); ?>" class="nav-link<?= $this->uri->segment(2) == 'daftar_produk_nonAktif' ? ' active' : '' ?>">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>Menu Tidak Aktif</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview<?= $this->uri->segment(1) == 'member' ? ' menu-open' : '' ?>">
                        <a href="#" class="nav-link<?= $this->uri->segment(1) == 'member' ? ' active' : '' ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Kelola Member
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('member') ?>" class="nav-link<?= $this->uri->segment(1) == 'member' && empty($this->uri->segment(2)) ? ' active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Member Aktif</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('member/member_nonAktif'); ?>" class="nav-link<?= $this->uri->segment(2) == 'member_nonAktif' ? ' active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Member Tidak Aktif</p>
                                    <span class="badge badge-info right txt_member_nonAktif"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <li class="nav-header">Transaksi</li>
                <li class="nav-item has-treeview<?= $this->uri->segment(1) == 'order' ? ' menu-open' : '' ?>">
                    <a href="#" class="nav-link<?= $this->uri->segment(1) == 'order' ? ' active' : '' ?>">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p>
                            Pesanan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('order/semua_pesanan'); ?>" class="nav-link<?= $this->uri->segment(2) == 'semua_pesanan' ? ' active' : '' ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Semua pesanan</p>
                                <span class="badge badge-info right txt_semuapesanan"></span>
                            </a>
                        </li>
                        <?php if (in_array('1', $dataTampunganRole)) { ?>
                            <li class="nav-item">
                                <a href="<?= base_url('order/kon_bukti_tf'); ?>" class="nav-link<?= $this->uri->segment(2) == 'kon_bukti_tf' ? ' active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Konfirmasi Bukti TF</p>
                                    <span class="badge badge-info right txt_kon_bukti_tf"></span>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a href="<?= base_url('order/pesanan_khusus'); ?>" class="nav-link<?= $this->uri->segment(2) == 'pesanan_khusus' ? ' active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Data pesanan khusus</p>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>

                <?php if (in_array('1', $dataTampunganRole)) { ?>
                    <li class="nav-item">
                        <a href="<?= base_url('report/order') ?>" class="nav-link <?= $this->uri->segment(1) == 'report' ? ' active' : '' ?>">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                Laporan
                            </p>
                        </a>
                    </li>

                    <li class="nav-header">Konfigurasi</li>

                    <li class="nav-item has-treeview<?= $this->uri->segment(1) == 'konfigurasi' ? ' menu-open' : '' ?>">
                        <a href="#" class="nav-link<?= $this->uri->segment(1) == 'konfigurasi' ? ' active' : '' ?>">
                            <i class="nav-icon fas fa-cart-plus"></i>
                            <p>
                                Kelola Aplikasi
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('konfigurasi') ?>" class="nav-link<?= $this->uri->segment(1) == 'konfigurasi' && empty($this->uri->segment(2)) ? ' active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Konfigurasi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('konfigurasi/rekening') ?>" class="nav-link<?= $this->uri->segment(1) == 'konfigurasi' && $this->uri->segment(2) == "rekening" ? ' active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Rekening</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('konfigurasi/logo') ?>" class="nav-link<?= $this->uri->segment(1) == 'konfigurasi' && $this->uri->segment(2) == "logo" ? ' active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Logo Aplikasi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('konfigurasi/slider'); ?>" class="nav-link<?= $this->uri->segment(1) == 'konfigurasi' &&  $this->uri->segment(2) == 'slider' ? ' active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Slider Aplikasi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('konfigurasi/contact') ?>" class="nav-link<?= $this->uri->segment(1) == 'konfigurasi' && $this->uri->segment(2) == "contact" ? ' active' : '' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Saran dan Masukkan</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>