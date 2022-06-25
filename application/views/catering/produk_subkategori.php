<!-- banner-2 -->
<div class="page-head_contentmk_info_allahsuperl">

</div>
<!-- //banner-2 -->
<!-- page -->
<div class="services-breadcrumb">
    <div class="contentmk_inner_breadcrumb">
        <div class="container">
            <ul class="allahsuper_short">
                <li>
                    <a href="<?= base_url() ?>">Home</a>
                    <i>| </i>
                </li>
                <li><?= $sub; ?></li>
            </ul>
        </div>
    </div>
</div>
<!-- //page -->
<!-- Single Page -->
<div class="banner-bootom-allahsuper-contentmkits">
    <div class="container">
        <!-- tittle heading -->
        <h3 class="tittle-allahsuperl"><?= $judul . ' ' . $sub; ?>
            <!-- <span class="heading-style">
                <i></i>
                <i></i>
                <i></i>
            </span> -->
        </h3>
        <!-- //tittle heading -->

        <!-- <div class="product-sec1"> -->

        <div class="row">
            <?php foreach ($subKategori as $sb) { ?>
                <div class="col-md-3 col-xs-6 bagian-card">
                    <div class="allahsuperl-specilamk1 bagian-margin-card" style="border-radius: 5px;box-shadow: 2px 3px 15px 4px rgba(0, 0, 0, 0.15); margin-right: 5px;margin-left: 5px;">
                        <div class="speioffer-contentmk men-thumb-item">
                            <img src="<?= base_url('/assets/images/gallery_produk/' . $sb['foto_produk']) ?>" class="img-thumbnail" alt="" />
                            <div class="men-cart-pro">
                                <div class="inner-men-cart-pro">
                                    <a href="<?= base_url('product/productDetail/' . $sb['kd_produk']) ?>" class="link-product-add-cart">Quick View</a>
                                </div>
                            </div>
                            <span class="product-new-top">New</span>
                        </div>
                        <div class="product-name-allahsuperl">
                            <h4><?= $sb['nm_produk'] ?></h4>
                            <div class="allahsuperl-pricehkj">

                                <?php if ($sb['harga_tertinggi'] == $sb['harga_terendah']) {  ?>
                                    <h6 class="rupiah-mask"><?= $sb['harga_tertinggi'] ?></h6>
                                    <?php if ($sb['harga_coret_tertinggi'] != 0) { ?>
                                        <p><del class="rupiah-mask"><?= $sb['harga_coret_tertinggi'] ?></del></p>
                                    <?php } ?>
                                <?php } else { ?>
                                    <h6 style="display:inline-block" class="rupiah-mask"><?= $sb['harga_terendah'] ?></h6>
                                    &nbsp;<h6 style="display:inline-block"><?= " - " ?></h6>
                                    &nbsp;<h6 style="display:inline-block" class=" rupiah-mask"><?= $sb['harga_tertinggi'] ?></h6>
                                    <?php if ($sb['harga_coret_tertinggi'] != 0) { ?>
                                        <p><del class="rupiah-mask"><?= $sb['harga_coret_tertinggi'] ?></del></p>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="clearfix"></div>
        <nav aria-label="Page navigation" id="pagination">
            <?php echo $this->pagination->create_links(); ?>
        </nav>
        <!-- </div> -->



        <div class="clearfix"> </div>

    </div>

</div>
<!-- //Single Page -->
<!-- special offers -->

<!-- //special offers -->