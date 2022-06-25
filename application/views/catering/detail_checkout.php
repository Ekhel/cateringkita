<style>
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
<div class="privacy">
    <div class="container">
        <!-- tittle heading -->
        <h3 class="tittle-allahsuperl"><?= $judul; ?>
        </h3>
        <!-- //tittle heading -->
        <div class="row" style="margin-top: 15px;">
            <div class="col-md-8">
                <div class="card">
                    <div class="address_form_contentmk">
                        <div class="keranjang-belanja">
                            Data Customer
                        </div>
                        <form action="payment.html" method="post" class="creditly-card-form contentmkinfo_form">
                            <div class="creditly-wrapper textan, allahsuper_contentmkits_wrapper">
                                <div class="information-wrapper">
                                    <div class="first-row">
                                        <div class="controls">
                                            <input class="form-control" type="text" name="nama_lengkap" placeholder="Nama Lengkap" required="">
                                        </div>
                                        <div class="controls">
                                            <input class="form-control" type="text" name="no_telp" placeholder="Nomor Telepon (Whatsapp)" required="">
                                        </div>
                                        <div class="controls">
                                            <input class="form-control" type="email" name="email" placeholder="Email" required="">
                                        </div>
                                        <div class="controls row">
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="kecamatan" placeholder="Kecamatan" required="">
                                            </div>
                                            <div class="col-md-4">
                                                <input class="form-control" type="text" name="kode_pos" placeholder="Kode Pos" required="">
                                            </div>
                                        </div>
                                        <div class="controls">
                                            <textarea class="form-control" name="alamat" cols="30" rows="5" placeholder="Alamat"></textarea>
                                        </div>
                                    </div>
                                    <!-- <button class="submit check_out">Delivery to this Address</button> -->
                                </div>
                            </div>
                            <input type="checkbox" id="alamat_lain">
                            <label class="form-check-label" for="alamat_lain">Alamat Lain</label>
                        </form>
                        <!-- <div class="checkout-right-basket">
                            <a href="payment.html">Make a Payment
                                <span class="fa fa-hand-o-right" aria-hidden="true"></span>
                            </a>
                        </div> -->
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-12" id="detail_belanja" style="<?= !empty($this->cart->contents()) ? '' : 'display: none;' ?>">

            </div>
        </div>
    </div>
</div>