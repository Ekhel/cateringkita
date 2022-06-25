<p class="mb-1">Sub Total <span class="float-right text-dark" id="sub_total_txt"><?= format_rupiah($this->cart->total()) ?></span></p>
<input type="hidden" id="sub_total" value="<?= $this->cart->total() ?>">
<hr />
<h6 class="font-weight-bold text-danger mb-0">Total Pembayaran
    <span class="float-right" id="total_bayar_txt"><?= format_rupiah($this->cart->total()) ?></span>
    <span class="float-right" id="total_bayar_ambil" style="display: none;"><?= format_rupiah($this->cart->total()) ?></span>
</h6>
<input type="hidden" id="total_bayar" value="<?= $this->cart->total() - 0 ?>">