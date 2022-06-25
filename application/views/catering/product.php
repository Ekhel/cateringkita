<style>
    @-webkit-keyframes placeHolderShimmer {
        0% {
            background-position: -468px 0;
        }

        100% {
            background-position: 468px 0;
        }
    }

    @keyframes placeHolderShimmer {
        0% {
            background-position: -468px 0;
        }

        100% {
            background-position: 468px 0;
        }
    }

    .content-placeholder {
        display: inline-block;
        -webkit-animation-duration: 1s;
        animation-duration: 1s;
        -webkit-animation-fill-mode: forwards;
        animation-fill-mode: forwards;
        -webkit-animation-iteration-count: infinite;
        animation-iteration-count: infinite;
        -webkit-animation-name: placeHolderShimmer;
        animation-name: placeHolderShimmer;
        -webkit-animation-timing-function: linear;
        animation-timing-function: linear;
        background: #f6f7f8;
        background: -webkit-gradient(linear, left top, right top, color-stop(8%, #eeeeee), color-stop(18%, #dddddd), color-stop(33%, #eeeeee));
        background: -webkit-linear-gradient(left, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
        background: linear-gradient(to right, #eeeeee 8%, #dddddd 18%, #eeeeee 33%);
        -webkit-background-size: 800px 104px;
        background-size: 800px 104px;
        height: inherit;
        position: relative;
    }

    .post_data {
        padding: 24px;
        border: 1px solid #f9f9f9;
        border-radius: 5px;
        margin-bottom: 24px;
        box-shadow: 10px 10px 5px #eeeeee;
    }

    .scroll {
        max-height: 200px;
        overflow-y: auto;
    }

    div.bs-example {
        overflow: auto;
        white-space: nowrap;
    }

    div.bs-example a {
        display: inline-block;
        /* color: white; */
        text-align: center;
        padding: 14px;
        text-decoration: none;
    }
</style>
<input type="hidden" name="" id="where_product" value="<?= $this->uri->segment(3) ?>">
<section class="py-5 products-listing bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="filters mobile-filters shadow-sm rounded bg-white mb-4 d-none d-block d-md-none">
                    <div class="border-bottom">
                        <a class="h6 font-weight-bold text-dark d-block m-0 p-3 collapsed" data-toggle="collapse" href="#mobile-filters" role="button" aria-expanded="false" aria-controls="mobile-filters">Filter <i class="icofont-arrow-down float-right mt-1"></i></a>
                    </div>
                    <div id="mobile-filters" class="filters-body multi-collapse collapse">
                        <div id="accordion">
                            <div class="filters-card border-bottom p-3">
                                <div class="filters-card-header" id="headingOffer">
                                    <h6 class="mb-0">
                                        <a href="" class="btn-link collapsed" data-toggle="collapse" data-target="#collapseSort" aria-expanded="false" aria-controls="collapseSort">
                                            Urutkan Berdasarkan Produk <i class="icofont-arrow-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                <div id="collapseSort" class="collapse" aria-labelledby="headingOffer" data-parent="#accordion">
                                    <div class="filters-card-body card-shop-filters">
                                        <div class="custom-control" style="padding-left: 0;">
                                            <a href="javascript:void(0)" class="btn btn-dark btn-sm btn-block mb-2 pricelow">
                                                Harga (Terendah sampai Tertinggi)
                                            </a>
                                        </div>
                                        <div class="custom-control" style="padding-left: 0;">
                                            <a href="javascript:void(0)" class="btn btn-dark btn-sm btn-block mb-2 pricehigh">
                                                Harga (Tertinggi sampai Terendah)
                                            </a>
                                        </div>
                                        <div class="custom-control" style="padding-left: 0;">
                                            <a href="javascript:void(0)" class="btn btn-dark btn-sm btn-block mb-2 abjadA-Z">
                                                Nama (A to Z)
                                            </a>
                                        </div>
                                        <div class="custom-control" style="padding-left: 0;">
                                            <a href="javascript:void(0)" class="btn btn-dark btn-sm btn-block mb-2 abjadZ-A">
                                                Nama (Z to A)
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="filters-card border-bottom p-3">
                                <div class="filters-card-header" id="headingTwo">
                                    <h6 class="mb-0">
                                        <a href="#" class="btn-link" data-toggle="collapse" data-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
                                            Kategori
                                            <i class="icofont-arrow-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                <div id="collapsetwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="filters-card-body card-shop-filters  scroll">
                                        <?php
                                        $kat = $this->db->get_where('kategori', ['nm_kategori' => "Custom"])->row_array();
                                        $this->db->select('*');
                                        $this->db->from('kategori');
                                        $this->db->where(['kd_kategori!=' => $kat['kd_kategori']]);
                                        $this->db->order_by("nm_kategori", "ASC");
                                        $kategori = $this->db->get()->result_array(); ?>
                                        <?php foreach ($kategori as $k) { ?>
                                            <div class="custom-control" style="padding-left: 0;">
                                                <a href="javascript:void(0)" data-id="<?= base64_encode(encrypt($k['kd_kategori'])) ?>" class="btn btn-dark btn-sm btn-block mb-2 produk_kategori">
                                                    <?= $k['nm_kategori'] ?>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="filters-card border-bottom p-3">
                                <div class="filters-card-header" id="headingOffer">
                                    <h6 class="mb-0">
                                        <a href="#" class="btn-link collapsed" data-toggle="collapse" data-target="#collapseOffer" aria-expanded="false" aria-controls="collapseOffer">
                                            Harga <i class="icofont-arrow-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                <div id="collapseOffer" class="collapse" aria-labelledby="headingOffer" data-parent="#accordion">
                                    <div class="filters-card-body card-shop-filters row">
                                        <div class="col-md-6 col-xs-6 col-6">
                                            <input type="text" class="form-control text-center harga_min_mobile" onkeypress="return hanyaAngka(event)" placeholder="MIN">
                                        </div>
                                        <div class="col-md-6 col-xs-6 col-6">
                                            <input type="text" class="form-control text-center harga_max_mobile" onkeypress="return hanyaAngka(event)" placeholder="MAX">
                                        </div>
                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-block mt-2 batas_harga_mobile">
                                            Cari Produk
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filters shadow-sm rounded bg-white mb-3 d-none d-sm-none d-md-block">
                    <div class="filters-header border-bottom pl-4 pr-4 pt-3 pb-3">
                        <h5 class="m-0 text-dark">Filter</h5>
                    </div>
                    <div class="filters-body">
                        <div id="accordion">
                            <div class="filters-card border-bottom p-4">
                                <div class="filters-card-header" id="headingTwo">
                                    <h6 class="mb-0">
                                        <a href="#" class="btn-link" data-toggle="collapse" data-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
                                            Kategori
                                            <i class="icofont-arrow-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                <div id="collapsetwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="filters-card-body card-shop-filters">
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
                                            <div class="custom-control" style="padding-left: 0;">
                                                <a href="javascript:void(0)" data-id="<?= base64_encode(encrypt($k['kd_kategori'])) ?>" class="btn btn-dark btn-sm btn-block mb-2 produk_kategori">
                                                    <?= $k['nm_kategori'] ?>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="filters-card border-bottom p-4">
                                <div class="filters-card-header" id="headingOffer">
                                    <h6 class="mb-0">
                                        <a href="#" class="btn-link collapsed" data-toggle="collapse" data-target="#collapseOffer" aria-expanded="false" aria-controls="collapseOffer">
                                            Harga <i class="icofont-arrow-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                <div id="collapseOffer" class="collapse" aria-labelledby="headingOffer" data-parent="#accordion">
                                    <div class="filters-card-body card-shop-filters row">
                                        <div class="col-md-6 col-xs-6 col-6">
                                            <input type="text" class="form-control text-center harga_min" onkeypress="return hanyaAngka(event)" placeholder="MIN">
                                        </div>
                                        <div class="col-md-6 col-xs-6 col-6">
                                            <input type="text" class="form-control text-center harga_max" onkeypress="return hanyaAngka(event)" placeholder="MAX">
                                        </div>
                                        <a href="javascript:void(0)" class="btn btn-primary btn-sm btn-block mt-2 batas_harga">
                                            Cari Produk
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <img src="<?= base_url() ?>assets/toko_/img/offer-2.png" class="w-100 bg-white rounded overflow-hidden position-relative shadow-sm d-none d-sm-none d-md-block" alt="..."> -->
            </div>
            <div class="col-md-9">
                <div class="shop-head mb-3">
                    <div class="btn-group float-right mt-2 d-none d-sm-none d-md-block">
                        <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="icofont icofont-filter"></span> Urutkan Berdasarkan Produk &nbsp;&nbsp;
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- <a class="dropdown-item" href="javascript:void(0)">Relevance</a> -->
                            <a class="dropdown-item pricelow" href="javascript:void(0)">Harga (Terendah sampai Tertinggi)</a>
                            <a class="dropdown-item pricehigh" href="javascript:void(0)">Harga (Tertinggi sampai Terendah)</a>
                            <!-- <a class="dropdown-item" href="javascript:void(0)">Discount (High to Low)</a> -->
                            <a class="dropdown-item abjadA-Z" href="javascript:void(0)">Nama (A to Z)</a>
                            <a class="dropdown-item abjadZ-A" href="javascript:void(0)">Nama (Z to A)</a>
                        </div>
                    </div>
                    <h5 class="mb-1 text-dark">Daftar Menu</h5>
                    <a href="<?= base_url('main') ?>"><span class="icofont icofont-ui-home"></span> Home</a>
                    <span class="icofont icofont-thin-right"></span>
                    <a href="<?= base_url('catering/product'); ?>">Daftar Menu</a>
                    <span class="icofont icofont-thin-right"></span>
                    <?php if (empty($this->uri->segment('3'))) { ?>
                        <span class="txt_kategori">All</span>
                    <?php } else if ($this->uri->segment('3') != "") { ?>
                        <?php
                        $where = $this->uri->segment('3');
                        $text = substr(decrypt(base64_decode($where)), 0, 3);
                        ?>
                        <?php if ($text == "KAT") { ?>

                            <?php
                            $this->db->select("*");
                            $this->db->from("kategori");
                            $this->db->where(['kd_kategori' => decrypt(base64_decode($where))]);
                            $kategori = $this->db->get()->row_array();
                            ?>
                            <?php if ($kategori) { ?>
                                <span class="txt_kategori"><?= $kategori['nm_kategori'] ?></span>
                            <?php } else { ?>
                                <span class="txt_kategori">-</span>

                            <?php } ?>
                        <?php } else if ($text == "KSB") { ?>

                            <?php
                            $this->db->select("*");
                            $this->db->from("sub_kategori");
                            $this->db->where(['kd_sub_kategori' => decrypt(base64_decode($where))]);
                            $sub_kategori = $this->db->get()->row_array();

                            $this->db->select("*");
                            $this->db->from("kategori");
                            $this->db->where(['kd_kategori' => $sub_kategori['kd_kategori']]);
                            $kategori = $this->db->get()->row_array();
                            ?>

                            <a href="<?= base_url('catering/product/' . base64_encode(encrypt($kategori['kd_kategori']))); ?>"><?= $kategori['nm_kategori'] ?></a>
                            <span class="icofont icofont-thin-right"></span>
                            <span><?= $sub_kategori['nm_sub_kategori'] ?></span>
                        <?php } else { ?>
                            <span class="txt_kategori"><?= ucfirst($this->uri->segment(3)) ?></span>
                        <?php } ?>
                    <?php } ?>
                </div>
                <?php $sub_kategori = $this->db->get_where('sub_kategori', ['kd_kategori' =>  !empty($this->uri->segment('3')) ?  decrypt(base64_decode($this->uri->segment('3'))) : $this->uri->segment('3')])->result_array(); ?>
                <?php if (count($sub_kategori) > 0 && $this->uri->segment('3') != "preorder" && $this->uri->segment('3') != "stock") { ?>
                    <div class="bs-example">
                        <?php foreach ($sub_kategori as $sb) { ?>
                            <a href="javascript:void(0)" class="badge badge-pill badge-warning mb-2 mr-1 p-2 produk_sub_kategori" data-id="<?= base64_encode(encrypt($sb['kd_sub_kategori']))  ?>">
                                <?= $sb['nm_sub_kategori'] ?>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="row" id="bagian_produk"></div>
                <div id="load_data_message" class="row"></div>
            </div>
        </div>
    </div>

</section>