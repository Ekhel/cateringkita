<style>
    .table-responsive {
        border-radius: 10px 10px 10px 10px;
        -moz-border-radius: 6px 6px 6px 6px;
        -webkit-border-radius: 6px 6px 6px 6px;
        box-shadow: 10px 10px 25px 1px rgba(0, 0, 0, 0.15);
    }

    .table-responsive-checkout {
        border-radius: 10px 10px 10px 10px;
        -moz-border-radius: 6px 6px 6px 6px;
        -webkit-border-radius: 6px 6px 6px 6px;
        box-shadow: 10px 10px 25px 1px rgba(0, 0, 0, 0.15);
        margin-top: 20px;
        padding: 10px;
        background: #1accfd;
        color: white;
        text-align: center;
    }

    table {
        border-collapse: collapse;
        border-radius: 5px;
        overflow: hidden;
    }

    .bordered th:first-child {
        border-radius: 6px 0 0 0;
        -moz-border-radius: 6px 0 0 0;
        -webkit-border-radius: 6px 0 0 0;
    }

    .bordered th:last-child {
        border-radius: 0 6px 0 0;
        -moz-border-radius: 0 6px 0 0;
        -webkit-border-radius: 0 6px 0 0;
    }

    .bordered td:first-child,
    .bordered th:first-child {
        border-left: medium none;
    }

    .bordered th {
        background-color: #1accfd;
        background-image: -moz-linear-gradient(center top, #F8F8F8, #ECECEC);
        background-image: #1accfd;
        border-top: medium none;
        box-shadow: 0 1px 0 rgba(255, 255, 255, 0.8) inset;
        text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
        font-weight: bold;
    }

    .bordered td,
    .bordered th {
        padding: 10px;
    }

    .card {
        /* Add shadows to create the "card" effect */
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        padding: 15px 15px 1px 15px;
    }

    /* On mouse-over, add a deeper shadow */
    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    /* Add some padding inside the card container */
    .container {
        padding: 2px 16px;
    }

    .button-checkout:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .keranjang-belanja {
        background-color: #337ab7;
        color: white;
        text-align: center;
        padding: 10px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .bagian-cart {
        margin-bottom: 10px;
    }

    .font-harga {
        font-size: 13px;
    }

    .ringkasan-belanja {
        background-color: #337ab7;
        color: white;
        text-align: center;
        padding: 10px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .input-harga {
        border: 0;
        float: right;
        text-align: right;
        width: 100%;
    }
</style>
<!-- page -->
<div class="services-breadcrumb">
    <div class="contentmk_inner_breadcrumb">
        <div class="container">
            <ul class="allahsuper_short">
                <li>
                    <a href="index.html">Home</a>
                    <i>|</i>
                </li>
                <li><?= $judul; ?></li>
            </ul>
        </div>
    </div>
</div>
<!-- //page -->
<!-- checkout page -->
<div class="privacy">
    <div class="container">
        <!-- tittle heading -->
        <h3 class="tittle-allahsuperl"><?= $judul; ?>
        </h3>
        <!-- //tittle heading -->
        <input type="hidden" value="<?= count($this->cart->contents()) ?>" id="jum_record">
        <div class="row" style="margin-top: 15px;">
            <div class="<?= !empty($this->cart->contents()) ? 'col-md-8' : 'col-md-12' ?> col-xs-12">
                <div class="card">
                    <div class="keranjang-belanja">
                        Keranjang Belanja
                    </div>
                    <?php if (!empty($this->cart->contents())) { ?>
                        <?php $no = 0;
                        foreach ($this->cart->contents() as $items) {
                            $no++; ?>
                            <div class="row bagian-cart page-cart<?= $no ?>">
                                <div class="col-md-2 col-xs-12">
                                    <div class="invert-image">
                                        <a href="single2.html">
                                            <img src="<?= base_url('assets/images/gallery_produk/' . $items['produk_foto']) ?>" alt=" " width="100px" class="img-responsive">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <h5><?= $items['name'] ?></h5><br>
                                    <h5 class="font-harga rupiah-mask"><?= $items['price'] ?></h5>
                                    <del class="font-harga rupiah-mask" style="color: red;"><?= $items['price'] ?></del>
                                    <h5 class="font-harga">Berat : <?= $items['produk_berat'] . ' ' . $items['produk_satuan_berat'] ?></h5>
                                </div>
                                <input type="hidden" id="produk_id<?= $no ?>" value="<?= $items['id'] ?>">
                                <input type="hidden" id="produk_kd<?= $no ?>" value="<?= $items['produk_kd'] ?>">
                                <input type="hidden" id="produk_nm<?= $no ?>" value="<?= $items['name'] ?>">
                                <input type="hidden" id="produk_stok<?= $no ?>" value="<?= $items['produk_stok'] ?>">
                                <input type="hidden" id="produk_berat<?= $no ?>" value="<?= $items['produk_berat'] ?>">
                                <input type="hidden" id="produk_satuan_berat<?= $no ?>" value="<?= $items['produk_satuan_berat'] ?>">
                                <input type="hidden" id="produk_harga<?= $no ?>" value="<?= $items['price'] ?>">
                                <input type="hidden" id="produk_deskripsi<?= $no ?>" value="<?= $items['deskripsi'] ?>">
                                <input type="hidden" id="produk_harga_coret<?= $no ?>" value="<?= $items['produk_harga_coret'] ?>">
                                <input type="hidden" id="produk_diskon<?= $no ?>" value="<?= $items['produk_diskon'] ?>">
                                <input type="hidden" id="produk_jns_komisi<?= $no ?>" value="<?= $items['produk_jns_komisi'] ?>">
                                <input type="hidden" id="produk_nominal_komisi<?= $no ?>" value="<?= $items['produk_nominal_komisi'] ?>">
                                <input type="hidden" id="produk_foto<?= $no ?>" value="<?= $items['produk_foto'] ?>">
                                <div class=" col-md-4 col-xs-12" style="padding: 34px 15px 0px 15px;">
                                    <div class="invert">
                                        <div class="input-group lebar-input" width: 125px;>
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary btn-number<?= $no ?>" data-type="minus" data-field="quant[<?= $no ?>]">
                                                    <span class="glyphicon glyphicon-minus"></span>
                                                </button>
                                            </span>
                                            <input type="hidden" id="qtylama<?= $no ?>" value="<?= $items['qty'] ?>"></input>
                                            <input type="text" name="quant[<?= $no ?>]" class="form-control input-number input-qty<?= $no ?> text-center" id="<?= $items['id'] . $no ?>" value="<?= $items['qty'] ?>" min="1" max="1000">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary btn-number<?= $no ?>" data-type="plus" data-field="quant[<?= $no ?>]">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 col-xs-12" style="padding: 34px 15px 34px 15px;">
                                    <div class="invert">
                                        <div class="rem">
                                            <button type="button" id="<?= $items['rowid'] ?>" class="hapus_detail<?= $no ?> btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <center>
                            <h5 style="font-weight: bold; font-size: 20px;">Your shopping cart is empty</h5><a href="<?= base_url('main') ?>" class="btn btn-sm btn-success" style="margin-top: 10px;margin-bottom: 10px;">Buy Something ?</a>
                        </center>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-4 col-xs-12" id="detail_belanja" style="<?= !empty($this->cart->contents()) ? '' : 'display: none;' ?>">

            </div>
        </div>
    </div>
</div>

<!-- //checkout page -->