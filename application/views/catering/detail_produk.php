<!-- banner-2 -->
<div class="page-head_contentmk_info_allahsuperl">

</div>
<!-- //banner-2 -->
<!-- page -->
<?php var_dump($product);
die; ?>
<div class="services-breadcrumb">
    <div class="contentmk_inner_breadcrumb">
        <div class="container">
            <ul class="allahsuper_short">
                <li>
                    <a href="index.html">Home</a>
                    <i>| </i>
                </li>
                <li><?= $judul; ?></li>
            </ul>
        </div>
    </div>
</div>
<!-- //page -->
<!-- Single Page -->
<div class="banner-bootom-allahsuper-contentmkits">
    <div class="container">
        <!-- tittle heading -->
        <h3 class="tittle-allahsuperl"><?= $judul; ?>
            <!-- <span class="heading-style">
                <i></i>
                <i></i>
                <i></i>
            </span> -->
        </h3>
        <!-- //tittle heading -->

        <div class="product-sec1">

            <div class="col-md-5 single-right-left ">
                <div class="grid images_3_of_2">
                    <div class="flexslider">
                        <ul class="slides">
                            <?php $gallery = $this->db->get_where('gallery_produk', ['kd_produk' => $product[0]['kd_produk']])->result_array(); ?>
                            <?php $gallery_produk = $this->db->get_where('produk', ['kd_produk' => $product[0]['kd_produk']])->result_array(); ?>
                            <?php if (count($gallery) > 0) { ?>
                                <?php foreach ($gallery as $p) { ?>
                                    <li data-thumb="<?= base_url('assets/images/gallery_produk/' . $p['foto']) ?>">
                                        <div class="thumb-image">
                                            <img src="<?= base_url('assets/images/gallery_produk/' . $p['foto']) ?>" data-imagezoom="true" class="img-responsive" alt="">
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } else { ?>
                                <li data-thumb="<?= base_url('assets/images/gallery_produk/' . $gallery_produk[0]['foto_produk']) ?>">
                                    <div class="thumb-image">
                                        <img src="<?= base_url('assets/images/gallery_produk/' . $gallery_produk[0]['foto_produk']) ?>" data-imagezoom="true" class="img-responsive" alt="">
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 single-right-left simpleCart_shelfItem">
                <h3><?= $product[0]['nm_produk'] ?></h3>
                <!-- <div class="rating1">
                    <span class="starRating">
                        <input id="rating5" type="radio" name="rating" value="5">
                        <label for="rating5">5</label>
                        <input id="rating4" type="radio" name="rating" value="4">
                        <label for="rating4">4</label>
                        <input id="rating3" type="radio" name="rating" value="3" checked="">
                        <label for="rating3">3</label>
                        <input id="rating2" type="radio" name="rating" value="2">
                        <label for="rating2">2</label>
                        <input id="rating1" type="radio" name="rating" value="1">
                        <label for="rating1">1</label>
                    </span>
                </div> -->
                <input type="hidden" value="<?= count($product) ?>" id="record_produk">
                <p>
                    Pilih Ukuran
                    <?php
                    $no = 0;
                    foreach ($product as $p) {
                        $no++ ?>
                        <button class="btn btn-sm btn-primary berat_produk<?= $no ?>" data-id="<?= $p['kd_detail_produk'] ?>"><?= $p['berat'] . ' ' . $p['satuan_berat'] ?></button>
                    <?php } ?>
                </p>
                <p>
                    <span class="item_price rupiah-mask"><?= $product[0]['harga_produk'] ?></span>
                    <!-- <del class="harga_coret rupiah-mask"><?= $product[0]['harga_coret'] ?></del> -->
                    <!-- <label>Cash On Dilevery</label> -->
                </p>
                <p>
                    <span class=""><i class="fa fa-truck"></i> Cash On Delivery (COD)</span>
                </p>
                <div class="row" style="margin-left: -15px ;">
                    <div class="col-md-3 col-xs-7">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-number" data-type="minus" data-field="quant[2]">
                                    <span class="glyphicon glyphicon-minus"></span>
                                </button>
                            </span>
                            <input type="text" name="quant[2]" class="form-control input-number text-center input-qty" value="1" min="1" max="1000">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[2]">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="produk_id" value="<?= $product[0]['kd_detail_produk'] ?>">
                <input type="hidden" id="produk_kd" value="<?= $product[0]['kd_produk'] ?>">
                <input type="hidden" id="produk_nm" value="<?= $product[0]['nm_produk'] ?>">
                <input type="hidden" id="produk_stok" value="<?= $product[0]['stok'] ?>">
                <input type="hidden" id="produk_berat" value="<?= $product[0]['berat'] ?>">
                <input type="hidden" id="produk_satuan_berat" value="<?= $product[0]['satuan_berat'] ?>">
                <input type="hidden" id="produk_harga" value="<?= $product[0]['harga_produk'] ?>">
                <input type="hidden" id="produk_deskripsi" value="<?= $product[0]['deskripsi'] ?>">
                <!-- <input type="hidden" id="produk_harga_coret" value="<?= $product[0]['harga_coret'] ?>"> -->
                <input type="hidden" id="produk_diskon" value="<?= $product[0]['diskon'] ?>">
                <input type="hidden" id="produk_jns_komisi" value="<?= $product[0]['jns_komisi'] ?>">
                <input type="hidden" id="produk_nominal_komisi" value="<?= $product[0]['nominal_komisi'] ?>">
                <input type="hidden" id="produk_foto" value="<?= $product[0]['foto_produk'] ?>">
                <button class="add_cart btn btn-lg btn-primary">Add To Cart</button>

                <div class="row" style="margin-left: -15px ; margin-top: 20px;">
                    <div class="col-md-12 col-xs-12">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#deskripsi">Deskripsi Produk</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#ulasan">Ulasan</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane container active" id="deskripsi">
                                <?= $product[0]['deskripsi'] ?>
                            </div>
                            <div class="tab-pane container fade" id="ulasan">
                                <p>Ulasan Produk</p>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
            <div class="clearfix"></div>
            <nav aria-label="Page navigation" id="pagination">
                <?php echo $this->pagination->create_links(); ?>
            </nav>
        </div>

        <div class="clearfix"> </div>

    </div>

</div>
<!-- //Single Page -->
<!-- special offers -->

<!-- //special offers -->