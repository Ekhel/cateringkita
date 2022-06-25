<?php
if (empty($product)) {
    $this->session->set_flashdata('error_page', 'Tidak Bisa Akses Menu Tersebut.');
    redirect(base_url('main'));
}
?>
<section class="py-2  inner-header">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-12">
                <div class="breadcrumbs">
                    <p class="mb-0"><a href="<?= base_url('main') ?>"><span class="icofont icofont-ui-home"></span> Home</a> <span class="icofont icofont-thin-right"></span> <a href="#"><?= $judul ?></a> <span class="icofont icofont-thin-right"></span> <span><?= ucfirst($product[0]['nm_produk']) ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5 shop-single bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="shop-detail-left">
                    <div class="shop-detail-slider position-relative">
                        <!-- <div class="favourite-icon"> <a class="fav-btn" title="" data-placement="bottom" data-toggle="tooltip" href="#" data-original-title="59% OFF"><i class="icofont-ui-tag"></i></a>
                        </div> -->
                        <?php $gallery = $this->db->get_where('gallery_produk', ['kd_produk' => $product[0]['kd_produk']])->result_array(); ?>
                        <?php $gallery_produk = $this->db->get_where('produk', ['kd_produk' => $product[0]['kd_produk']])->result_array(); ?>
                        <div id="sync1" class="border rounded shadow-sm bg-white mb-2 owl-carousel text-center">
                            <?php if (count($gallery) > 0) { ?>
                                <div class="item bg-b">
                                    <img alt="" src="<?= base_url('assets/images/gallery_produk/' . $gallery_produk[0]['foto_produk']) ?>" class="img-fluid img-center">
                                </div>
                                <?php foreach ($gallery as $p) { ?>
                                    <div class="item bg-b">
                                        <img alt="" src="<?= base_url('assets/images/gallery_produk/' . $p['foto']) ?>" class="img-fluid img-center">
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="item bg-b">
                                    <img alt="" src="<?= base_url('assets/images/gallery_produk/' . $gallery_produk[0]['foto_produk']) ?>" class="img-fluid img-center">
                                </div>
                            <?php } ?>
                        </div>

                        <div id="sync2" class="owl-carousel">
                            <?php if (count($gallery) > 0) { ?>
                                <div class="item">
                                    <img alt="" src="<?= base_url('assets/images/gallery_produk/' . $gallery_produk[0]['foto_produk']) ?>" class="img-fluid img-center">
                                </div>
                                <?php foreach ($gallery as $p) { ?>
                                    <div class="item">
                                        <img alt="" src="<?= base_url('assets/images/gallery_produk/' . $p['foto']) ?>" class="img-fluid img-center">
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="item">
                                    <img alt="" src="<?= base_url('assets/images/gallery_produk/' . $gallery_produk[0]['foto_produk']) ?>" class="img-fluid img-center">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="shop-detail-right">
                    <div class="border rounded shadow-sm bg-white p-4">
                        <div class="product-name">
                            <h2><?= ucfirst($product[0]['nm_produk']) ?></h2>
                            <!-- <span>Product code: <b>OSAHAN456</b> | <strong class="text-info">FREE Delivery</strong> on orders over $299</span> -->
                        </div>
                        <div class="price-box">
                            <h5>
                                <span class="product-price"><?= format_rupiah($product[0]['harga']) ?>/pax</span>
                            </h5>
                        </div>
                        <div class="clearfix"></div>
                        <div class="product-variation">
                            <form action="#" method="post">
                                <div class="mt-1 pt-2 float-left mr-2">Quantity :</div>
                                <div class="input-group quantity-input"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-outline-secondary btn-number btn-lg" data-type="minus" data-field="quant[1]" style="font-size: 17px;">
                                            <span class="fa fa-minus"></span>
                                        </button>
                                    </span>
                                    <input type="number" name="quant[1]" class="text-center form-control border-form-control form-control-sm input-number" value="<?= $product[0]['min_order'] ?>" min="<?= $product[0]['min_order'] ?>" max="1000" style="margin-right: 0px;"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-outline-secondary btn-number btn-lg" data-type="plus" data-field="quant[1]" style="font-size: 17px;">
                                            <span class="fa fa-plus"></span>
                                        </button>
                                    </span>
                                </div>
                                <span class="float-right">
                                    <!-- <button type="button" title="" data-placement="top" data-toggle="tooltip" href="#" data-original-title="Add to Wishlist" class="btn btn-outline-primary btn-lg"><i class="icofont icofont-heart"></i></button> -->
                                    <input type="hidden" id="produk_id" value="<?= $product[0]['kd_produk'] ?>">
                                    <input type="hidden" id="produk_kd" value="<?= $product[0]['kd_produk'] ?>">
                                    <input type="hidden" id="produk_nm" value="<?= $product[0]['nm_produk'] ?>">
                                    <input type="hidden" id="produk_harga" value="<?= $product[0]['harga'] ?>">
                                    <input type="hidden" id="produk_deskripsi" value="<?= $product[0]['deskripsi'] ?>">
                                    <input type="hidden" id="min_order" value="<?= $product[0]['min_order'] ?>">
                                    <input type="hidden" id="produk_foto" value="<?= $product[0]['foto_produk'] ?>">
                                    <input type="hidden" id="produk_deskripsi" value="<?= $product[0]['deskripsi'] ?>">
                                    <button type="button" class="btn btn-primary btn-lg btn_cart">&nbsp;&nbsp;&nbsp; <i class="icofont icofont-shopping-cart"></i> Add To Cart &nbsp;&nbsp;&nbsp;</button>
                                </span>
                            </form>
                        </div>
                        <div class="short-description border-bottom">
                            <h6 class="mb-3">
                                <span class="text-dark font-weight-bold">Deskripsi Produk</span>
                            </h6>
                            <p><b><?= !empty($product[0]['deskripsi']) ? $product[0]['deskripsi'] : "Tidak Ada Deskripsi."; ?></b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>