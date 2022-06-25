    <?php
    $count = count($this->cart->contents());
    if ($count <= 0) {
        $hasil = 0;
    } else {
        $hasil = $count;
    }
    $no = 0;


    ?>
    <div class="cart-sidebar-header">
        <h5>
            Keranjang Saya <span class="text-info">(<?= $hasil ?> item)</span>
            <?php if (!empty($angka)) { ?>
                <a data-toggle="offcanvas" id="tombol_close" class="float-right" href="#">
                    <i class="icofont icofont-close-line"></i>
                </a>
            <?php } else { ?>
                <a data-toggle="offcanvas" class="float-right" href="#">
                    <i class="icofont icofont-close-line"></i>
                </a>
            <?php } ?>
        </h5>
    </div>

    <div class="cart-sidebar-body">
        <?php if (!empty($this->cart->contents())) { ?>
            <?php
            if (!empty($cart)) {
                $data = $cart;
            } else {
                $data = $this->cart->contents();
            }
            foreach ($data as $items) {
                $no++; ?>
                <input type="hidden" id="jum_cart" value="<?= count($data) ?>">
                <input type="hidden" id="row_id<?= $no ?>" value="<?= $items['rowid'] ?>">
                <input type="hidden" id="produk_id<?= $no ?>" value="<?= $items['id'] ?>">
                <input type="hidden" id="produk_kd<?= $no ?>" value="<?= $items['produk_kd'] ?>">
                <input type="hidden" id="produk_nm<?= $no ?>" value="<?= $items['name'] ?>">
                <input type="hidden" id="produk_harga<?= $no ?>" value="<?= $items['price'] ?>">
                <input type="hidden" id="produk_deskripsi<?= $no ?>" value="<?= $items['deskripsi'] ?>">
                <input type="hidden" id="min_order<?= $no ?>" value="<?= $items['min_order'] ?>">
                <input type="hidden" id="produk_foto<?= $no ?>" value="<?= $items['produk_foto'] ?>">
                <div class="cart-list-product" style="border-bottom: 0px;">
                    <a class="float-right remove-cart" id="<?= $items['rowid'] ?>" href="javascript:void(0)" style="font-size: 25px;"><i class="icofont icofont-close-circled"></i></a>
                    <img class="img-fluid" src="<?= base_url('assets/images/gallery_produk/' . $items['produk_foto']) ?>" style="height: 110%;" alt="">
                    <h5>
                        <a href="#"><?= ucfirst($items['name']) ?></a><br>
                    </h5>
                    <h6>
                        <?= $items['deskripsi'] ?><br>
                    </h6>
                    <br>
                    <p class="f-14 mb-0 text-dark float-right"><?= format_rupiah($items['price']) ?> </p>
                    <span class="count-number float-left">
                        <button class="btn btn-outline-secondary btn-numbers<?= $no ?> btn-sm left dec" data-type="minus" data-field="query[<?= $no ?>]" <?= $items['qty'] == 1 ? "disabled" : '' ?>> <i class="icofont-minus"></i> </button>
                        <input class="count-number-input input-number<?= $no ?>" name="query[<?= $no ?>]" type="number" value="<?= $items['qty'] ?>" min="<?= $items['min_order'] ?>" max="1000" style="width: 52px;" readonly>
                        <button class="btn btn-outline-secondary btn-numbers<?= $no ?> btn-sm right inc" data-type="plus" data-field="query[<?= $no ?>]"> <i class="icofont-plus"></i> </button>
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

    <div class="cart-sidebar-footer" id="bagian_total_keranjang">
        <?php $this->load->view('catering/total_keranjang') ?>
    </div>
    <!-- <script src="<?= base_url() ?>assets/toko_/vendor/jquery/jquery.min.js"></script> -->
    <!-- <script src="<?= base_url(); ?>assets/js/base_url.js"></script> -->
    <?php
    if (!empty($cart)) { ?>
        <script type="text/javascript">
            // $(document).ready(function() {

            var base_url = baseurl();

            var jum_cart = $('#jum_cart').val();

            for (let i = 1; i <= jum_cart; i++) {
                $(".btn-numbers" + i).on('click', function(e) {
                    e.preventDefault();

                    fieldName = $(this).attr("data-field");
                    type = $(this).attr("data-type");
                    var input = $("input[name='" + fieldName + "']");
                    var currentVal = parseInt(input.val());
                    if (!isNaN(currentVal)) {
                        if (type == "minus") {
                            if (parseInt(input.val()) == input.attr("min")) {
                                $(this).attr("disabled", true);
                                var qty = 0;
                            }
                            if (currentVal > input.attr("min")) {
                                var hasil = currentVal - 1;
                                input.val(currentVal - 1).change();
                                var qty = -1;
                            }
                        } else if (type == "plus") {
                            if (parseInt(input.val()) == input.attr("max")) {
                                $(this).attr("disabled", true);
                                var qty = 0;
                            }
                            if (currentVal < input.attr("max")) {
                                var hasil = currentVal + 1;
                                input.val(currentVal + 1).change();
                                var qty = 1;
                            }
                        }
                        var data = $(".input-number").val();
                        $("#qty_produk").val(data);
                    } else {
                        input.val(0);
                    }

                    var produk_id = $("#produk_id" + i).val();
                    var produk_kd = $("#produk_kd" + i).val();
                    var produk_nm = $("#produk_nm" + i).val();
                    var produk_harga = $("#produk_harga" + i).val();
                    var produk_deskripsi = $("#produk_deskripsi" + i).val();
                    var produk_catatan = $(".produk_catatan" + i).val();
                    var min_order = $("#min_order" + i).val();
                    var produk_foto = $("#produk_foto" + i).val();
                    var quantity = qty;
                    $.ajax({
                        url: base_url + "/cart/add_to_cart_items",
                        type: "post",
                        dataType: "json",
                        data: {
                            produk_id: produk_id,
                            produk_kd: produk_kd,
                            produk_nm: produk_nm,
                            produk_harga: produk_harga,
                            produk_deskripsi: produk_deskripsi,
                            produk_catatan: produk_catatan,
                            min_order: min_order,
                            produk_foto: produk_foto,
                            quantity: quantity,
                        },
                        success: function(data) {

                            $.ajax({
                                type: "post",
                                url: base_url + "/cart/total_keranjang",
                                success: function(response) {
                                    $('#bagian_total_keranjang').html(response);
                                    // button_keranjang();
                                }
                            });

                            $.ajax({
                                type: "post",
                                url: base_url + "/cart/total_keranjang_checkout",
                                success: function(response) {
                                    $('#bagian_total_keranjang_checkout').html(response);
                                    // button_keranjang();
                                }
                            });

                            // $(".flash-data1").html("Data Produk Berhasil Ditambahkan.");
                            // $(".error-data1").html("");
                            $("#total_cart").html(data.total_cart);
                            // toast();
                        },
                    });
                });

                $(".input-number" + i).change(function() {
                    minValue = parseInt($(this).attr("min"));
                    maxValue = parseInt($(this).attr("max"));
                    valueCurrent = parseInt($(this).val());

                    name = $(this).attr("name");
                    if (valueCurrent >= minValue) {
                        $(".btn-numbers" + i + "[data-type='minus']").removeAttr(
                            "disabled"
                        );
                    } else {
                        $(".flash-data1").html("");
                        $(".error-data1").html("Sorry, the minimum value was reached");
                        toast();
                        $(this).val($(this).data("oldValue"));
                    }
                    if (valueCurrent <= maxValue) {
                        $(".btn-numbers" + i + "[data-type='plus']").removeAttr(
                            "disabled"
                        );
                    } else {
                        $(".flash-data1").html("");
                        $(".error-data1").html("Sorry, the maximum value was reached");
                        toast();
                        // alert("");
                        $(this).val($(this).data("oldValue"));
                    }
                });

                $('.submit_catatan' + i).on('click', function(e) {
                    e.preventDefault();
                    var produk_id = $("#produk_id" + i).val();
                    var produk_kd = $("#produk_kd" + i).val();
                    var produk_nm = $("#produk_nm" + i).val();
                    var produk_harga = $("#produk_harga" + i).val();
                    var produk_deskripsi = $("#produk_deskripsi" + i).val();
                    var min_order = $("#min_order" + i).val();
                    var produk_catatan = $(".produk_catatan" + i).val();
                    var produk_foto = $("#produk_foto" + i).val();
                    var quantity = 0;
                    $.ajax({
                        url: base_url + "/cart/add_to_cart_items",
                        type: "post",
                        dataType: "json",
                        data: {
                            produk_id: produk_id,
                            produk_kd: produk_kd,
                            produk_nm: produk_nm,
                            produk_harga: produk_harga,
                            produk_deskripsi: produk_deskripsi,
                            produk_catatan: produk_catatan,
                            min_order: min_order,
                            produk_foto: produk_foto,
                            quantity: quantity,
                        },
                        success: function(data) {

                            $.ajax({
                                type: "post",
                                url: base_url + "/cart/total_keranjang",
                                success: function(response) {
                                    $('#bagian_total_keranjang').html(response);
                                    // button_keranjang();
                                }
                            });

                            $.ajax({
                                type: "post",
                                url: base_url + "/cart/total_keranjang_checkout",
                                success: function(response) {
                                    $('#bagian_total_keranjang_checkout').html(response);
                                    // button_keranjang();
                                }
                            });

                            $(".flash-data1").html("Catatan Berhasil Ditambahkan.");
                            $(".error-data1").html("");
                            toast();
                            $("#total_cart").html(data.total_cart);
                        },
                    });
                })
            }
            // });
        </script>
    <?php } ?>