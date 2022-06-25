<!-- banner -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators-->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1" class=""></li>
        <li data-target="#myCarousel" data-slide-to="2" class=""></li>
        <li data-target="#myCarousel" data-slide-to="3" class=""></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <div class="container">
                <div class="carousel-caption">
                    <h3>Big
                        <span>Save</span>
                    </h3>
                    <p>Get flat
                        <span>10%</span> Cashback</p>
                    <a class="button2" href="product.html">Shop Now </a>
                </div>
            </div>
        </div>
        <div class="item item2">
            <div class="container">
                <div class="carousel-caption">
                    <h3>Healthy
                        <span>Saving</span>
                    </h3>
                    <p>Get Upto
                        <span>30%</span> Off</p>
                    <a class="button2" href="product.html">Shop Now </a>
                </div>
            </div>
        </div>
        <div class="item item3">
            <div class="container">
                <div class="carousel-caption">
                    <h3>Big
                        <span>Deal</span>
                    </h3>
                    <p>Get Best Offer Upto
                        <span>20%</span>
                    </p>
                    <a class="button2" href="product.html">Shop Now </a>
                </div>
            </div>
        </div>
        <div class="item item4">
            <div class="container">
                <div class="carousel-caption">
                    <h3>Today
                        <span>Discount</span>
                    </h3>
                    <p>Get Now
                        <span>40%</span> Discount</p>
                    <a class="button2" href="product.html">Shop Now </a>
                </div>
            </div>
        </div>
    </div>
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<!-- //banner -->

<!-- top Products -->
<div class="ads-grid">
    <div class="container">
        <!-- tittle heading -->
        <h3 class="tittle-allahsuperl">Our Top Products
            <span class="heading-style">
                <i></i>
                <i></i>
                <i></i>
            </span>
        </h3>
        <!-- //tittle heading -->
        <!-- product left -->

        <!-- //product left -->
        <!-- product right -->
        <div class="contentmkinfo-ads-display col-md-12">
            <div class="wrapper">
                <!-- first section (nuts) -->
                <div class="product-sec1">
                    <h3 class="heading-tittle">Featured</h3>

                    <div class="product-men">
                        <ul id="flexiselDemo1">
                            <?php foreach ($produk1 as $pro) {  ?>
                                <li>
                                    <div class="allahsuperl-specilamk1 men-pro-item simpleCart_shelfItem">
                                        <div class="speioffer-contentmk men-thumb-item">
                                            <a href="<?= base_url('product/productDetail/' . $pro['kd_produk']) ?>">
                                                <img src="<?= base_url('/assets/images/gallery_produk/' . $pro['foto_produk']) ?>" class="img-thumbnail" alt="">
                                                <div class="men-cart-pro">
                                                    <div class="inner-men-cart-pro">
                                                        <a href="<?= base_url('product/productDetail/' . $pro['kd_produk']) ?>" class="link-product-add-cart">Quick View</a>
                                                    </div>
                                                </div>
                                                <span class="product-new-top">New</span>
                                            </a>
                                        </div>
                                        <div class="product-name-allahsuperl">
                                            <h4>
                                                <?= $pro['nm_produk'] ?>
                                            </h4>
                                            <div class="allahsuperl-pricehkj">
                                                <?php if ($pro['harga_tertinggi'] == $pro['harga_terendah']) {  ?>
                                                    <h6 class="rupiah-mask"><?= $pro['harga_tertinggi'] ?></h6>
                                                    <?php if ($pro['harga_terendah'] != 0) { ?>
                                                        <p><del class="rupiah-mask"><?= $pro['harga_terendah'] ?></del></p>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <h6 style="display:inline-block" class="rupiah-mask"><?= $pro['harga_terendah'] ?></h6>
                                                    &nbsp;<h6 style="display:inline-block"><?= " - " ?></h6>
                                                    &nbsp;<h6 style="display:inline-block" class=" rupiah-mask"><?= $pro['harga_tertinggi'] ?></h6>
                                                    <?php if ($pro['harga_terendah'] != 0) { ?>
                                                        <p><del class="rupiah-mask"><?= $pro['harga_terendah'] ?></del></p>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                            <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out"></div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>

                    <div class="clearfix"></div>
                </div>
                <!-- //first section (nuts) -->
                <!-- second section (nuts special) -->
                <div class="product-sec1 product-sec2">
                    <div class="col-xs-7 effect-bg">
                        <h3 class="">Pure Energy</h3>
                        <h6>Enjoy our all healthy Products</h6>
                        <p>Get Extra 10% Off</p>
                    </div>
                    <h3 class="allahsuperl-nut-middle">Nuts & Dry Fruits</h3>
                    <div class="col-xs-5 bg-right-nut">
                        <img src="<?= base_url() ?>assets/toko/images/nut1.png" alt="">
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- //second section (nuts special) -->
                <!-- third section (oils) -->
                <div class="product-sec1">
                    <h3 class="heading-tittle">Best Seller</h3>

                    <div class="product-men">
                        <ul id="flexiselDemo2">
                            <?php foreach ($produk2 as $pro) {  ?>
                                <li>
                                    <div class="allahsuperl-specilamk1 men-pro-item simpleCart_shelfItem">
                                        <div class="speioffer-contentmk men-thumb-item">
                                            <a href="<?= base_url('product/productDetail/' . $pro['kd_produk']) ?>">
                                                <img src="<?= base_url('/assets/images/gallery_produk/' . $pro['foto_produk']) ?>" class="img-thumbnail" alt="">
                                                <div class="men-cart-pro">
                                                    <div class="inner-men-cart-pro">
                                                        <a href="<?= base_url('product/productDetail/' . $pro['kd_produk']) ?>" class="link-product-add-cart">Quick View</a>
                                                    </div>
                                                </div>
                                                <span class="product-new-top">New</span>
                                            </a>
                                        </div>
                                        <div class="product-name-allahsuperl">
                                            <h4>
                                                <?= $pro['nm_produk'] ?>
                                            </h4>
                                            <div class="allahsuperl-pricehkj">
                                                <?php if ($pro['harga_tertinggi'] == $pro['harga_terendah']) {  ?>
                                                    <h6 class="rupiah-mask"><?= $pro['harga_tertinggi'] ?></h6>
                                                    <?php if ($pro['harga_coret_tertinggi'] != 0) { ?>
                                                        <p><del class="rupiah-mask"><?= $pro['harga_coret_tertinggi'] ?></del></p>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <h6 style="display:inline-block" class="rupiah-mask"><?= $pro['harga_terendah'] ?></h6>
                                                    &nbsp;<h6 style="display:inline-block"><?= " - " ?></h6>
                                                    &nbsp;<h6 style="display:inline-block" class=" rupiah-mask"><?= $pro['harga_tertinggi'] ?></h6>
                                                    <?php if ($pro['harga_coret_tertinggi'] != 0) { ?>
                                                        <p><del class="rupiah-mask"><?= $pro['harga_coret_tertinggi'] ?></del></p>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                            <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out"></div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>

                    <div class="clearfix"></div>
                </div>
                <!-- //third section (oils) -->
                <!-- fourth section (noodles) -->
                <div class="product-sec1">
                    <h3 class="heading-tittle">Top Rated</h3>

                    <div class="product-men">
                        <ul id="flexiselDemo3">
                            <?php foreach ($produk3 as $pro) {  ?>
                                <li>
                                    <div class="allahsuperl-specilamk1 men-pro-item simpleCart_shelfItem">
                                        <div class="speioffer-contentmk men-thumb-item">
                                            <a href="<?= base_url('product/productDetail/' . $pro['kd_produk']) ?>">
                                                <img src="<?= base_url('/assets/images/gallery_produk/' . $pro['foto_produk']) ?>" class="img-thumbnail" alt="">
                                                <div class="men-cart-pro">
                                                    <div class="inner-men-cart-pro">
                                                        <a href="<?= base_url('product/productDetail/' . $pro['kd_produk']) ?>" class="link-product-add-cart">Quick View</a>
                                                    </div>
                                                </div>
                                                <span class="product-new-top">New</span>
                                            </a>
                                        </div>
                                        <div class="product-name-allahsuperl">
                                            <h4>
                                                <?= $pro['nm_produk'] ?>
                                            </h4>
                                            <div class="allahsuperl-pricehkj">
                                                <?php if ($pro['harga_tertinggi'] == $pro['harga_terendah']) {  ?>
                                                    <h6 class="rupiah-mask"><?= $pro['harga_tertinggi'] ?></h6>
                                                    <?php if ($pro['harga_coret_tertinggi'] != 0) { ?>
                                                        <p><del class="rupiah-mask"><?= $pro['harga_coret_tertinggi'] ?></del></p>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <h6 style="display:inline-block" class="rupiah-mask"><?= $pro['harga_terendah'] ?></h6>
                                                    &nbsp;<h6 style="display:inline-block"><?= " - " ?></h6>
                                                    &nbsp;<h6 style="display:inline-block" class=" rupiah-mask"><?= $pro['harga_tertinggi'] ?></h6>
                                                    <?php if ($pro['harga_coret_tertinggi'] != 0) { ?>
                                                        <p><del class="rupiah-mask"><?= $pro['harga_coret_tertinggi'] ?></del></p>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                            <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out"></div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>

                    <div class="clearfix"></div>
                </div>
                <!-- //fourth section (noodles) -->
            </div>
        </div>
        <!-- //product right -->
    </div>
</div>
<!-- //top products -->
<!-- special offers -->
<div class="featured-section" id="projects">
    <div class="container">
        <!-- tittle heading -->
        <h3 class="tittle-allahsuperl">Special Offers
            <span class="heading-style">
                <i></i>
                <i></i>
                <i></i>
            </span>
        </h3>
        <!-- //tittle heading -->
        <div class="content-bottom-in">
            <ul id="flexiselDemo">
                <li>
                    <div class="allahsuperl-specilamk">
                        <div class="speioffer-contentmk">
                            <a href="single.html">
                                <img src="<?= base_url() ?>assets/toko/images/s1.jpg" alt="">
                            </a>
                        </div>
                        <div class="product-name-allahsuperl">
                            <h4>
                                <a href="single.html">Aashirvaad, 5g</a>
                            </h4>
                            <div class="allahsuperl-pricehkj">
                                <h6>$220.00</h6>
                                <p>Save $40.00</p>
                            </div>
                            <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                <form action="#" method="post">
                                    <fieldset>
                                        <input type="hidden" name="cmd" value="_cart" />
                                        <input type="hidden" name="add" value="1" />
                                        <input type="hidden" name="business" value=" " />
                                        <input type="hidden" name="item_name" value="Aashirvaad, 5g" />
                                        <input type="hidden" name="amount" value="220.00" />
                                        <input type="hidden" name="discount_amount" value="1.00" />
                                        <input type="hidden" name="currency_code" value="USD" />
                                        <input type="hidden" name="return" value=" " />
                                        <input type="hidden" name="cancel_return" value=" " />
                                        <input type="submit" name="submit" value="Add to cart" class="button" />
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="allahsuperl-specilamk">
                        <div class="speioffer-contentmk">
                            <a href="single.html">
                                <img src="<?= base_url() ?>assets/toko/images/s4.jpg" alt="">
                            </a>
                        </div>
                        <div class="product-name-allahsuperl">
                            <h4>
                                <a href="single.html">Kissan Tomato Ketchup, 950g</a>
                            </h4>
                            <div class="allahsuperl-pricehkj">
                                <h6>$99.00</h6>
                                <p>Save $20.00</p>
                            </div>
                            <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                <form action="#" method="post">
                                    <fieldset>
                                        <input type="hidden" name="cmd" value="_cart" />
                                        <input type="hidden" name="add" value="1" />
                                        <input type="hidden" name="business" value=" " />
                                        <input type="hidden" name="item_name" value="Kissan Tomato Ketchup, 950g" />
                                        <input type="hidden" name="amount" value="99.00" />
                                        <input type="hidden" name="discount_amount" value="1.00" />
                                        <input type="hidden" name="currency_code" value="USD" />
                                        <input type="hidden" name="return" value=" " />
                                        <input type="hidden" name="cancel_return" value=" " />
                                        <input type="submit" name="submit" value="Add to cart" class="button" />
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="allahsuperl-specilamk">
                        <div class="speioffer-contentmk">
                            <a href="single.html">
                                <img src="<?= base_url() ?>assets/toko/images/s2.jpg" alt="">
                            </a>
                        </div>
                        <div class="product-name-allahsuperl">
                            <h4>
                                <a href="single.html">Madhur Pure Sugar, 1g</a>
                            </h4>
                            <div class="allahsuperl-pricehkj">
                                <h6>$69.00</h6>
                                <p>Save $20.00</p>
                            </div>
                            <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                <form action="#" method="post">
                                    <fieldset>
                                        <input type="hidden" name="cmd" value="_cart" />
                                        <input type="hidden" name="add" value="1" />
                                        <input type="hidden" name="business" value=" " />
                                        <input type="hidden" name="item_name" value="Madhur Pure Sugar, 1g" />
                                        <input type="hidden" name="amount" value="69.00" />
                                        <input type="hidden" name="discount_amount" value="1.00" />
                                        <input type="hidden" name="currency_code" value="USD" />
                                        <input type="hidden" name="return" value=" " />
                                        <input type="hidden" name="cancel_return" value=" " />
                                        <input type="submit" name="submit" value="Add to cart" class="button" />
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="allahsuperl-specilamk">
                        <div class="speioffer-contentmk">
                            <a href="single2.html">
                                <img src="<?= base_url() ?>assets/toko/images/s3.jpg" alt="">
                            </a>
                        </div>
                        <div class="product-name-allahsuperl">
                            <h4>
                                <a href="single2.html">Surf Excel Liquid, 1.02L</a>
                            </h4>
                            <div class="allahsuperl-pricehkj">
                                <h6>$187.00</h6>
                                <p>Save $30.00</p>
                            </div>
                            <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                <form action="#" method="post">
                                    <fieldset>
                                        <input type="hidden" name="cmd" value="_cart" />
                                        <input type="hidden" name="add" value="1" />
                                        <input type="hidden" name="business" value=" " />
                                        <input type="hidden" name="item_name" value="Surf Excel Liquid, 1.02L" />
                                        <input type="hidden" name="amount" value="187.00" />
                                        <input type="hidden" name="discount_amount" value="1.00" />
                                        <input type="hidden" name="currency_code" value="USD" />
                                        <input type="hidden" name="return" value=" " />
                                        <input type="hidden" name="cancel_return" value=" " />
                                        <input type="submit" name="submit" value="Add to cart" class="button" />
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="allahsuperl-specilamk">
                        <div class="speioffer-contentmk">
                            <a href="single.html">
                                <img src="<?= base_url() ?>assets/toko/images/s8.jpg" alt="">
                            </a>
                        </div>
                        <div class="product-name-allahsuperl">
                            <h4>
                                <a href="single.html">Cadbury Choclairs, 655.5g</a>
                            </h4>
                            <div class="allahsuperl-pricehkj">
                                <h6>$160.00</h6>
                                <p>Save $60.00</p>
                            </div>
                            <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                <form action="#" method="post">
                                    <fieldset>
                                        <input type="hidden" name="cmd" value="_cart" />
                                        <input type="hidden" name="add" value="1" />
                                        <input type="hidden" name="business" value=" " />
                                        <input type="hidden" name="item_name" value="Cadbury Choclairs, 655.5g" />
                                        <input type="hidden" name="amount" value="160.00" />
                                        <input type="hidden" name="discount_amount" value="1.00" />
                                        <input type="hidden" name="currency_code" value="USD" />
                                        <input type="hidden" name="return" value=" " />
                                        <input type="hidden" name="cancel_return" value=" " />
                                        <input type="submit" name="submit" value="Add to cart" class="button" />
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="allahsuperl-specilamk">
                        <div class="speioffer-contentmk">
                            <a href="single2.html">
                                <img src="<?= base_url() ?>assets/toko/images/s6.jpg" alt="">
                            </a>
                        </div>
                        <div class="product-name-allahsuperl">
                            <h4>
                                <a href="single2.html">Fair & Lovely, 80 g</a>
                            </h4>
                            <div class="allahsuperl-pricehkj">
                                <h6>$121.60</h6>
                                <p>Save $30.00</p>
                            </div>
                            <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                <form action="#" method="post">
                                    <fieldset>
                                        <input type="hidden" name="cmd" value="_cart" />
                                        <input type="hidden" name="add" value="1" />
                                        <input type="hidden" name="business" value=" " />
                                        <input type="hidden" name="item_name" value="Fair & Lovely, 80 g" />
                                        <input type="hidden" name="amount" value="121.60" />
                                        <input type="hidden" name="discount_amount" value="1.00" />
                                        <input type="hidden" name="currency_code" value="USD" />
                                        <input type="hidden" name="return" value=" " />
                                        <input type="hidden" name="cancel_return" value=" " />
                                        <input type="submit" name="submit" value="Add to cart" class="button" />
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="allahsuperl-specilamk">
                        <div class="speioffer-contentmk">
                            <a href="single.html">
                                <img src="<?= base_url() ?>assets/toko/images/s5.jpg" alt="">
                            </a>
                        </div>
                        <div class="product-name-allahsuperl">
                            <h4>
                                <a href="single.html">Sprite, 2.25L (Pack of 2)</a>
                            </h4>
                            <div class="allahsuperl-pricehkj">
                                <h6>$180.00</h6>
                                <p>Save $30.00</p>
                            </div>
                            <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                <form action="#" method="post">
                                    <fieldset>
                                        <input type="hidden" name="cmd" value="_cart" />
                                        <input type="hidden" name="add" value="1" />
                                        <input type="hidden" name="business" value=" " />
                                        <input type="hidden" name="item_name" value="Sprite, 2.25L (Pack of 2)" />
                                        <input type="hidden" name="amount" value="180.00" />
                                        <input type="hidden" name="discount_amount" value="1.00" />
                                        <input type="hidden" name="currency_code" value="USD" />
                                        <input type="hidden" name="return" value=" " />
                                        <input type="hidden" name="cancel_return" value=" " />
                                        <input type="submit" name="submit" value="Add to cart" class="button" />
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="allahsuperl-specilamk">
                        <div class="speioffer-contentmk">
                            <a href="single2.html">
                                <img src="<?= base_url() ?>assets/toko/images/s9.jpg" alt="">
                            </a>
                        </div>
                        <div class="product-name-allahsuperl">
                            <h4>
                                <a href="single2.html">Lakme Eyeconic Kajal, 0.35 g</a>
                            </h4>
                            <div class="allahsuperl-pricehkj">
                                <h6>$153.00</h6>
                                <p>Save $40.00</p>
                            </div>
                            <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                <form action="#" method="post">
                                    <fieldset>
                                        <input type="hidden" name="cmd" value="_cart" />
                                        <input type="hidden" name="add" value="1" />
                                        <input type="hidden" name="business" value=" " />
                                        <input type="hidden" name="item_name" value="Lakme Eyeconic Kajal, 0.35 g" />
                                        <input type="hidden" name="amount" value="153.00" />
                                        <input type="hidden" name="discount_amount" value="1.00" />
                                        <input type="hidden" name="currency_code" value="USD" />
                                        <input type="hidden" name="return" value=" " />
                                        <input type="hidden" name="cancel_return" value=" " />
                                        <input type="submit" name="submit" value="Add to cart" class="button" />
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- //special offers -->