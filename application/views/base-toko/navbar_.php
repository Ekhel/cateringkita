<div class="modal fade login-modal-main" id="login">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="login-modal">
                    <div class="row">
                        <div class="col-lg-6 d-flex align-items-center">
                            <div class="login-modal-left p-4 text-center pl-5">
                                <img src="<?= base_url() ?>assets/images/logo_website/<?= $logo['nm_logo'] ?>" width="90%" alt=" Gurdeep singh osahan">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="close close-top-right position-absolute" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="icofont-close-line"></i></span>
                                <span class="sr-only">Close</span>
                            </button>
                            <div class="position-relative">
                                <ul class="mt-4 mr-4 nav nav-tabs-login float-right position-absolute" role="tablist">
                                    <li>
                                        <a class="nav-link-login active" data-toggle="tab" href="#login-form" role="tab"><i class="icofont-ui-lock"></i> MASUK</a>
                                    </li>
                                    <li>
                                        <a class="nav-link-login" href="<?= base_url('catering/add_member') ?>"><i class="icofont icofont-pencil"></i> DAFTAR</a>
                                    </li>
                                </ul>
                                <div class="login-modal-right p-4">
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="login-form" role="tabpanel">
                                            <h5 class="heading-design-h5 text-dark">MASUK</h5>
                                            <fieldset class="form-group mt-4">
                                                <label>Nomer Handphone</label>
                                                <input type="text" id="username_pelanggan" class="form-control" placeholder="Masukkan Nomer Hp Anda">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label>Password</label>
                                                <input type="password" id="password_pelanggan" class="form-control" placeholder="Masukkan Password Anda">
                                            </fieldset>
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" id="checkboxpasslogin">
                                                <label for="checkboxpasslogin">
                                                    Lihat Password
                                                </label>
                                            </div>
                                            <fieldset class="form-group">
                                                <button type="submit" class="btn btn-lg btn-primary btn-block" id="button_login">Masuk</button>
                                            </fieldset>
                                        </div>
                                        <div class="tab-pane" id="register" role="tabpanel">
                                            <h5 class="heading-design-h5 text-dark">DAFTAR</h5>
                                            <fieldset class="form-group mt-4">
                                                <label>Nomer Handphone</label>
                                                <input type="text" class="form-control" placeholder="Masukkan Nomer Hp Anda">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" placeholder="Masukkan Password">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <label>Ulangi Password </label>
                                                <input type="password" class="form-control" placeholder="Ulangi Masukkan Password">
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <button type="submit" class="btn btn-lg btn-primary btn-block">Buat Akun</button>
                                            </fieldset>
                                            <!-- <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                <label class="custom-control-label" for="customCheck2">Saya setuju dengan <a href="#">Term and Conditions</a></label>
                                            </div> -->
                                            <!-- <div class="login-with-sites mt-4">
                                                <p class="mb-2">or Login with your social profile:</p>
                                                <div class="row text-center">
                                                    <div class="col-6 pr-1">
                                                        <button class="btn-facebook btn-block login-icons btn-lg"><i class="icofont icofont-facebook"></i> Facebook</button>
                                                    </div>
                                                    <div class="col-6 pl-1">
                                                        <button class="btn-google btn-block login-icons btn-lg"><i class="icofont icofont-google-plus"></i> Google</button>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-light">
    <div class="main-nav shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-light bg-white pt-0 pb-0">
            <div class="container">
                <a class="navbar-brand" href="<?= base_url('main') ?>">
                    <img src="<?= base_url() ?>assets/images/logo_website/<?= $logo['nm_logo'] ?>" style="width: 100px;" alt="gurdeep osahan designer">
                </a>
                <a class="toggle" href="#">
                    <span></span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto main-nav-left">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('main') ?>"><i class="icofont-ui-home"></i></a>
                        </li>
                        <li class="nav-item dropdown mega-drop-main">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Kategori
                            </a>
                            <div class="dropdown-menu mega-drop  shadow-sm border-0" aria-labelledby="navbarDropdown">
                                <div class="row ml-0 mr-0">
                                    <?php
                                    $kat = $this->db->get_where('kategori', ['nm_kategori' => "Custom"])->row_array();
                                    $kat1 = $this->db->get_where('kategori', ['nm_kategori' => "Paket Khusus"])->row_array();
                                    $this->db->select('*');
                                    $this->db->from('kategori');
                                    $this->db->where(['kd_kategori!=' => $kat['kd_kategori']]);
                                    $this->db->where(['kd_kategori!=' => $kat1['kd_kategori']]);
                                    $this->db->order_by("nm_kategori", "ASC");
                                    $kategori = $this->db->get()->result_array(); ?>
                                    <?php foreach ($kategori as $k) { ?>
                                        <div class="col-lg-2 col-md-2" style="line-height: auto;word-wrap: break-word;">
                                            <div class="mega-list">
                                                <a class="mega-title produk_kategori" href="javascript:void(0)" data-id="<?= base64_encode(encrypt($k['kd_kategori'])) ?>"><?= $k['nm_kategori'] ?></a>
                                                <?php $sub_kategori = $this->db->get_where('sub_kategori', ['kd_kategori' => $k['kd_kategori']])->result_array(); ?>
                                                <?php foreach ($sub_kategori as $sb) { ?>
                                                    <a href="javascript:void(0)" class="produk_sub_kategori" data-id="<?= base64_encode(encrypt($sb['kd_sub_kategori'])) ?>"><?= $sb['nm_sub_kategori'] ?></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Halaman
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow-sm border-0">
                                <a class="dropdown-item" href="<?= base_url('catering/product') ?>">Daftar Menu</a>
                                <a class="dropdown-item" href="<?= base_url('catering/about') ?>">Tentang Kami</a>
                                <a class="dropdown-item" href="<?= base_url('catering/contact') ?>">Kontak Kami</a>
                            </div>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0 top-search">
                        <button class="btn-link" type="submit"><i class="icofont-search"></i></button>
                        <input class="form-control mr-sm-2" type="search" id="searchProduct" placeholder="Cari Nama Menu" aria-label="Search" autocomplete="off">
                    </form>
                    <ul class="navbar-nav ml-auto profile-nav-right">
                        <?php if (!$this->session->userdata('kd_member')) { ?>
                            <li class="nav-item">
                                <a href="#" data-target="#login" data-toggle="modal" class="nav-link ml-0">
                                    <i class="icofont-ui-user"></i> Masuk/Daftar
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link ml-0 dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php
                                    if (!empty($this->session->userdata('kd_member'))) {
                                        $key = kunci();
                                        $id = $this->session->userdata('kd_member');
                                        $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
                                        $this->db->from('member');
                                        $this->db->join("detail_sosmed", "member.kd_member=detail_sosmed.kd_member");
                                        $this->db->where(['member.kd_member' => $id]);
                                        $user = $this->db->get()->row_array();

                                        if ($user == null) {
                                            $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
                                            $this->db->from('member');
                                            $this->db->where(['member.kd_member' => $id]);
                                            $user = $this->db->get()->row_array();
                                        }
                                    }
                                    $nama = explode(' ', $user['nm_member']);
                                    if (empty($nama[1])) {
                                        $name = $nama[0];
                                    } else {
                                        $name = $nama[0] . ' ' . $nama[1];
                                    }
                                    ?>
                                    <img alt="No Image" src="<?= base_url('assets/images/user/' . $user['image']) ?>" class="nav-osahan-pic rounded-pill"> Hallo, <?= $name ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow-sm border-0">
                                    <a class="dropdown-item" href="<?= base_url('catering/profile') ?>"><i class="icofont-ui-user"></i> Profil Saya</a>
                                    <!-- <a class="dropdown-item" href="<?= base_url('catering/password') ?>"><i class="icofont-key"></i> Ubah Password</a> -->
                                    <a class="dropdown-item tombol_logout" href="<?= base_url('main/logout_pelanggan') ?>"><i class="icofont-logout"></i> Keluar</a>
                                </div>
                            </li>
                        <?php } ?>
                        <li class="nav-item cart-nav">
                            <a data-toggle="offcanvas" class="nav-link" href="#">
                                <i class="icofont-basket"></i> Keranjang
                                <?php $count = count($this->cart->contents()); ?>
                                <span class="badge badge-danger" id="total_cart"><?= $count ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

</div>