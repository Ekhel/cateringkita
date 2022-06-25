<?php
$count = count($this->cart->contents());
if ($count <= 0) {
    $hasil = 0;
} else {
    $hasil = $count;
}
$no = 0;

?>
<div class="osahan-cart-item">
    <h5 class="mb-3 mt-0 text-dark">Summary <span class="small text-success">(<?= $hasil ?> Item)</span></h5>
    <div class="bg-white rounded shadow-sm mb-3">
        <?php if (!empty($this->cart->contents())) { ?>
            <?php
            if (!empty($cart)) {
                $data = $cart;
            } else {
                $data = $this->cart->contents();
            }

            $today = Date('Y-m-d', time());

            foreach ($data as $items) {

                $no++; ?>
                <div class="cart-list-product">
                    <input type="hidden" id="jum_cart" value="<?= count($data) ?>">
                    <input type="hidden" id="row_id<?= $no ?>" value="<?= $items['rowid'] ?>">
                    <input type="hidden" id="produk_id<?= $no ?>" value="<?= $items['id'] ?>">
                    <input type="hidden" id="produk_kd<?= $no ?>" value="<?= $items['produk_kd'] ?>">
                    <input type="hidden" id="produk_nm<?= $no ?>" value="<?= $items['name'] ?>">
                    <input type="hidden" id="produk_harga<?= $no ?>" value="<?= $items['price'] ?>">
                    <input type="hidden" id="produk_deskripsi<?= $no ?>" value="<?= $items['deskripsi'] ?>">
                    <input type="hidden" id="produk_foto<?= $no ?>" value="<?= $items['produk_foto'] ?>">
                    <a class="float-right remove-cart" id="<?= $items['rowid'] ?>" href="javascript:void(0)" style="font-size: 25px;"><i class="icofont icofont-close-circled"></i></a>
                    <img class="img-fluid" src="<?= base_url('assets/images/gallery_produk/' . $items['produk_foto']) ?>" style="height: 110%;" alt="">
                    <h5><a href="#"><?= ucfirst($items['name']) ?></a>
                    </h5>
                    <br>
                    <p class="f-14 mb-0 text-dark float-right"><?= format_rupiah($items['price']) ?> </p>
                    <span class="count-number float-left">
                        <button class="btn btn-outline-secondary btn-number<?= $no ?> btn-sm left dec" data-type="minus" data-field="query[<?= $no ?>]" <?= $items['qty'] == 1 ? "disabled" : '' ?>> <i class="icofont-minus"></i> </button>
                        <input class="count-number-input input-number<?= $no ?>" name="query[<?= $no ?>]" type="number" value="<?= $items['qty'] ?>" min="<?= $items['min_order'] ?>" max="1000" style="width: 52px;" readonly>
                        <button class="btn btn-outline-secondary btn-number<?= $no ?> btn-sm right inc" data-type="plus" data-field="query[<?= $no ?>]"> <i class="icofont-plus"></i> </button>
                    </span>
                </div>
                <div style="padding: 15px; padding-top: 0px;">
                    <div class="input-group mb-3">
                        <textarea name="produk_catatan" class="form-control produk_catatan<?= $no ?>" placeholder="Masukkan catatan" aria-label="Masukkan catatan" aria-describedby="basic-addon2"><?= $items['catatan'] ?></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary submit_catatan<?= $no ?>" type="button">Submit</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="cart-list-product">
                <center>
                    <h5>Sayang Sekali Keranjang Anda Kosong.</h5><br>
                    <a href="<?= base_url('main') ?>" class="btn btn-success btn-sm"><i class="fa fa-shopping-cart"></i> Yuk Belanja</a>
                </center>
            </div>
        <?php } ?>
    </div>
    <div class="mb-3 bg-white rounded shadow-sm p-3 clearfix" id="bagian_total_keranjang_checkout">
        <?php $this->load->view('catering/total_keranjang_checkout') ?>
    </div>
</div>