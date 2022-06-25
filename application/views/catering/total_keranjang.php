<div class="cart-store-details">
    <p>Sub Total <strong class="float-right"><?= format_rupiah($this->cart->total()) ?></strong></p><br>
    <!-- <p>Delivery Charges <strong class="float-right text-danger"><?= format_rupiah(5000) ?></strong></p> -->
</div>
<a href="<?= base_url('catering/checkout') ?>"><button class="btn btn-primary btn-lg btn-block text-left" type="button"><span class="float-left"><i class="icofont icofont-cart"></i> Proceed to Checkout </span><span class="float-right"><strong><?= format_rupiah($this->cart->total()) ?></strong> <span class="icofont icofont-bubble-right"></span></span></button></a>