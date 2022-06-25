<style>
    .dropdown-menu {
        top: 60px;
        right: 0px;
        left: unset;
        width: 460px;
        box-shadow: 0px 5px 7px -1px #c1c1c1;
        padding-bottom: 0px;
        padding: 0px;
    }

    .dropdown-menu:before {
        content: "";
        position: absolute;
        top: -20px;
        right: 12px;
        border: 10px solid #343A40;
        border-color: transparent transparent #343A40 transparent;
    }

    @media (min-width: 300px) and (max-width: 500px) {
        .nm_user {
            display: none;
        }
    }

    .head {
        padding: 5px 15px;
        border-radius: 3px 3px 0px 0px;
    }

    .footer {
        padding: 5px 15px;
        border-radius: 0px 0px 3px 3px;
    }

    .notification-box {
        padding: 10px 0px;
    }

    .bg-gray {
        background-color: #eee;
    }

    @media (max-width: 640px) {
        .dropdown-menu {
            top: 50px;
            left: -16px;
            width: 290px;
        }

        .nav {
            display: block;
        }

        .nav .nav-item,
        .nav .nav-item a {
            padding-left: 0px;
        }

        .message {
            font-size: 13px;
        }
    }

    .drop-content {
        min-height: 100px;
        max-height: 200px;
        overflow-y: scroll;
    }

    .drop-content::-webkit-scrollbar-track {
        background-color: #F5F5F5;
    }

    .drop-content::-webkit-scrollbar {
        width: 8px;
        background-color: #F5F5F5;
    }

    .drop-content::-webkit-scrollbar-thumb {
        background-color: #ccc;
    }
</style>
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

$user = $this->db->get_where("$tabel", ["kd_$tabel" => $this->session->userdata("kd_$sess")])->row_array();

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
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
            <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li> -->
    </ul>

    <!-- SEARCH FORM -->
    <!-- <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form> -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
                <i class="fa fa-user"></i> <span class="nm_user"><?= $user["nm_$tabel"]  ?></span>
                <!-- <span class="badge badge-danger navbar-badge">3</span> -->
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right " style="left: inherit; right: 0px;">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="<?= base_url('assets/images/user/' . $user['image']) ?>" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Welcome, <?= str_replace(substr($user["nm_$tabel"], 17), "...", $user["nm_$tabel"]) ?>

                                <!-- <p>Username : <?= $user['username'] ?></p> -->
                                <!-- <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span> -->
                            </h3>
                            <h3 class="dropdown-item-title">

                            </h3>
                            <!-- <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p> -->
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <a href="<?= base_url('dashboard/profile') ?>" class="dropdown-item dropdown-footer">Edit Your Profile</a>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php if ($this->session->userdata('kd_admin')) { ?>
                            <a href="<?= base_url('admin'); ?>" class="dropdown-item dropdown-footer tombol-logout">Logout</a>
                        <?php } elseif ($this->session->userdata('kd_masak')) { ?>
                            <a href="<?= base_url('masak'); ?>" class="dropdown-item dropdown-footer tombol-logout">Logout</a>
                        <?php } elseif ($this->session->userdata('kd_kurir')) { ?>
                            <a href="<?= base_url('kurir'); ?>" class="dropdown-item dropdown-footer tombol-logout">Logout</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
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