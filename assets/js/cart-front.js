function toast() {
	const flashData = $(".flash-data1").html();
	const errorData = $(".error-data").data("error");

	const Toast = Swal.mixin({
		toast: true,
		position: "top-end",
		showConfirmButton: false,
		timer: 5000,
	});

	if (flashData == "Login" || flashData == "Logout") {
		Toast.fire({
			icon: "success",
			title: "Anda Berhasil " + flashData,
		});
	} else if (flashData) {
		Toast.fire({
			icon: "success",
			title: flashData,
		});
	} else if (errorData) {
		Toast.fire({
			icon: "error",
			title: errorData,
		});
	}
}

function preloader() {
	$("#preloader")
		.delay(100)
		.fadeOut("slow", function () {
			$(this).remove();
		});
}
$(document).ready(function () {
	var base_url = baseurl();

	// Load cart otomatis
	var uri = $("#uri_segment").val();
	$("#detail_cart").load(base_url + "/cart/load_cart");
	$("#detail_belanja").load(base_url + "/cart/load_detail/" + uri);
	$("#keranjang").load(base_url + "/cart/load_keranjang");
	if (uri == "checkout") {
		$("#keranjang").hide();
	}
	preloader();
	// end load cart

	// add cart basic
	$(".add_cart").click(function () {
		var produk_id = $("#produk_id").val();
		var produk_kd = $("#produk_kd").val();
		var produk_nm = $("#produk_nm").val();
		var produk_stok = $("#produk_stok").val();
		var produk_berat = $("#produk_berat").val();
		var produk_satuan_berat = $("#produk_satuan_berat").val();
		var produk_harga = $("#produk_harga").val();
		var produk_harga_coret = $("#produk_harga_coret").val();
		var produk_diskon = $("#produk_diskon").val();
		var produk_jns_komisi = $("#produk_jns_komisi").val();
		var produk_nominal_komisi = $("#produk_nominal_komisi").val();
		var produk_foto = $("#produk_foto").val();
		var quantity = $(".input-qty").val();
		$.ajax({
			url: base_url + "/cart/add_to_cart",
			method: "POST",
			data: {
				produk_id: produk_id,
				produk_kd: produk_kd,
				produk_nm: produk_nm,
				produk_stok: produk_stok,
				produk_berat: produk_berat,
				produk_satuan_berat: produk_satuan_berat,
				produk_harga: produk_harga,
				produk_harga_coret: produk_harga_coret,
				produk_diskon: produk_diskon,
				produk_jns_komisi: produk_jns_komisi,
				produk_nominal_komisi: produk_nominal_komisi,
				produk_foto: produk_foto,
				quantity: quantity,
			},
			success: function (data) {
				console.log(data);
				$("#detail_cart").html(data);
				$("#keranjang").load(base_url + "/cart/load_keranjang");
				$(".flash-data1").html("Produk Telah Ditambahkan");
				$(".error-data1").html("");
				toast();
				preloader();
			},
		});

		$.ajax({
			url: base_url + "/cart/get_items",
			method: "POST",
			success: function (data) {
				// $(".shopping-cart").fadeToggle("slow", "linear");
				$("#total_cart").html(data);
				// $('#detail_cart').html(data);
			},
		});
	});
	// end add cart basic

	// show keranjang
	$(document).on("click", ".cart-tambah", function () {
		$(".shopping-cart").fadeToggle("slow", "linear");
		$(".shopping-cart").show();
	});
	// end show keranjang

	// hapus cart pada keranjang atas
	$(document).on("click", ".delete_cart", function () {
		var row_id = $(this).attr("id"); //mengambil row_id dari artibut id
		$.ajax({
			url: base_url + "/cart/hapus_cart",
			method: "POST",
			data: {
				row_id: row_id,
			},
			success: function (data) {
				$("#detail_cart").html(data);
				$("#detail_belanja").load(base_url + "/cart/load_detail");
				$("#keranjang").load(base_url + "/cart/load_keranjang");
				// location.reload();
			},
		});
	});
	// end hapus cart pada keranjang atas

	// untuk halaman checkout
	var record = $("#jum_record").val();
	for (let i = 1; i <= record; i++) {
		// $('.btn-number' + i).click(function (e) {
		$(document).on("click", ".btn-number" + i, function (e) {
			e.preventDefault();
			fieldName = $(this).attr("data-field");
			type = $(this).attr("data-type");
			var input = $("input[name='" + fieldName + "']");
			var currentVal = parseInt(input.val());
			if (!isNaN(currentVal)) {
				if (type == "minus") {
					if (currentVal > input.attr("min")) {
						input.val(currentVal - 1).change();
					}
					if (parseInt(input.val()) == input.attr("min")) {
						$(this).attr("disabled", true);
					}
					var qty = -1;
				} else if (type == "plus") {
					if (currentVal < input.attr("max")) {
						input.val(currentVal + 1).change();
					}
					if (parseInt(input.val()) == input.attr("max")) {
						$(this).attr("disabled", true);
					}
					var qty = 1;
				}
				var data = $(".input-number").val();
				var harga = $("#harga" + i).val();
				$("#qty_produk").val(data);
			} else {
				input.val(0);
			}

			var produk_id = $("#produk_id" + i).val();
			var produk_kd = $("#produk_kd" + i).val();
			var produk_nm = $("#produk_nm" + i).val();
			var produk_stok = $("#produk_stok" + i).val();
			var produk_berat = $("#produk_berat" + i).val();
			var produk_satuan_berat = $("#produk_satuan_berat" + i).val();
			var produk_harga = $("#produk_harga" + i).val();
			var produk_harga_coret = $("#produk_harga_coret" + i).val();
			var produk_diskon = $("#produk_diskon" + i).val();
			var produk_jns_komisi = $("#produk_jns_komisi" + i).val();
			var produk_nominal_komisi = $("#produk_nominal_komisi" + i).val();
			var produk_foto = $("#produk_foto" + i).val();
			// var quantity = $('#' + produk_id + i).val();
			var quantity = qty;
			$.ajax({
				url: base_url + "/cart/add_to_checkout",
				method: "POST",
				data: {
					produk_id: produk_id,
					produk_kd: produk_kd,
					produk_nm: produk_nm,
					produk_stok: produk_stok,
					produk_berat: produk_berat,
					produk_satuan_berat: produk_satuan_berat,
					produk_harga: produk_harga,
					produk_harga_coret: produk_harga_coret,
					produk_diskon: produk_diskon,
					produk_jns_komisi: produk_jns_komisi,
					produk_nominal_komisi: produk_nominal_komisi,
					produk_foto: produk_foto,
					quantity: quantity,
				},
				success: function (data) {
					console.log(data);
					// $(".shopping-cart").fadeToggle("slow", "linear");
					// $(".shopping-cart").show();
					$("#detail_belanja").html(data);
					$("#detail_cart").load(base_url + "/cart/load_cart");
					$("#keranjang").load(base_url + "/cart/load_keranjang");
					// $(".flash-data1").html("Produk Telah Ditambahkan");
					// $(".error-data1").html("");
					// toast();
				},
			});
		});
		$(".input-number").focusin(function () {
			$(this).data("oldValue", $(this).val());
		});
		$(".input-number").change(function () {
			minValue = parseInt($(this).attr("min"));
			maxValue = parseInt($(this).attr("max"));
			valueCurrent = parseInt($(this).val());

			name = $(this).attr("name");
			if (valueCurrent >= minValue) {
				$(
					".btn-number" + i + "[data-type='minus'][data-field='" + name + "']"
				).removeAttr("disabled");
			} else {
				alert("Sorry, the minimum value was reached");
				$(this).val($(this).data("oldValue"));
			}
			if (valueCurrent <= maxValue) {
				$(
					".btn-number" + i + "[data-type='plus'][data-field='" + name + "']"
				).removeAttr("disabled");
			} else {
				alert("Sorry, the maximum value was reached");
				$(this).val($(this).data("oldValue"));
			}
		});
		$(".input-number").keydown(function (e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if (
				$.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
				// Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) ||
				// Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)
			) {
				// let it happen, don't do anything
				return;
			}
			// Ensure that it is a number and stop the keypress
			if (
				(e.shiftKey || e.keyCode < 48 || e.keyCode > 57) &&
				(e.keyCode < 96 || e.keyCode > 105)
			) {
				e.preventDefault();
			}
		});

		// $(document).on('change', '.input-qty' + i, function () {
		// 	var produk_id = $(this).data("produkid");
		// 	var produk_nama = $(this).data("produknama");
		// 	var produk_harga = $(this).data("produkharga");
		// 	var foto = $(this).data("produkfoto");
		// 	var qty = $('.input-qty' + i).val();
		// 	var qtylama = $('#qtylama' + i).val();
		// 	var quantity = qty - qtylama;
		// 	$.ajax({
		// 		url: base_url + "/cart/add_to_checkout",
		// 		method: "POST",
		// 		data: {
		// 			produk_id: produk_id,
		// 			produk_nama: produk_nama,
		// 			produk_harga: produk_harga,
		// 			quantity: quantity,
		// 			foto: foto
		// 		},
		// 		success: function (data) {
		// 			console.log(data);
		// 			$('#detail_belanja').html(data);
		// 			$('#detail_cart').load(base_url + "/cart/load_cart");
		// 		}
		// 	});
		// });

		$(document).on("click", ".hapus_detail" + i, function () {
			var row_id = $(this).attr("id"); //mengambil row_id dari artibut id
			$.ajax({
				url: base_url + "/cart/hapus_checkout",
				method: "POST",
				data: {
					row_id: row_id,
				},
				success: function (data) {
					$("#detail_belanja").html(data);
					$("#detail_cart").load(base_url + "/cart/load_cart");
					$("#keranjang").load(base_url + "/cart/load_keranjang");
					location.reload();
				},
			});
		});
	}
	// end untuk halaman checkout
});
