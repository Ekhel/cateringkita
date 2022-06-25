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

$(document).ready(function () {
	$(".rupiah-mask").inputmask({
		alias: "numeric",
		groupSeparator: ",",
		autoGroup: true,
		digits: 0,
		digitsOptional: false,
		prefix: "Rp ",
		placeholder: "-1",
		rightAlign: false,
		autoUnmask: true,
		removeMaskOnSubmit: true,
	});

	var base_url = baseurl();

	var record_produk = $("#record_produk").val();
	for (let i = 1; i <= record_produk; i++) {
		$(".berat_produk" + i).on("click", function (event) {
			$(this).addClass("active").siblings().removeClass("active");
			var id = $(".berat_produk" + i).data("id");
			$.ajax({
				url: base_url + "/product/getDetailProductById",
				type: "post",
				dataType: "json",
				data: {
					id: id,
				},
				success: function (result) {
					$(".item_price").val(result.harga_produk);
					$(".harga_coret").val(result.harga_coret);
					$("#produk_id").val(result.kd_detail_produk);
					$("#produk_kd").val(result.kd_produk);
					$("#produk_stok").val(result.stok);
					$("#produk_berat").val(result.berat);
					$("#produk_satuan_berat").val(result.satuan_berat);
					$("#produk_harga").val(result.harga_produk);
					$("#produk_harga_coret").val(result.harga_coret);
					$("#produk_diskon").val(result.diskon);
					$("#produk_jns_komisi").val(result.jns_komisi);
					$("#produk_nominal_komisi").val(result.nominal_komisi);
				},
			});
		});
	}

	//plugin bootstrap minus and plus
	$(".btn-number").click(function (e) {
		e.preventDefault();

		fieldName = $(this).attr("data-field");
		type = $(this).attr("data-type");
		var input = $("input[name='" + fieldName + "']");
		var currentVal = parseInt(input.val());
		if (!isNaN(currentVal)) {
			if (type == "minus") {
				if (currentVal > input.attr("min")) {
					var hasil = currentVal - 1;
					input.val(currentVal - 1).change();
				}
				if (parseInt(input.val()) == input.attr("min")) {
					$(this).attr("disabled", true);
				}
			} else if (type == "plus") {
				if (currentVal < input.attr("max")) {
					var hasil = currentVal + 1;
					input.val(currentVal + 1).change();
				}
				if (parseInt(input.val()) == input.attr("max")) {
					$(this).attr("disabled", true);
				}
			}
			var data = $(".input-number").val();
			$("#qty_produk").val(data);
		} else {
			input.val(0);
		}
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
			$(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr(
				"disabled"
			);
		} else {
			alert("Sorry, the minimum value was reached");
			$(this).val($(this).data("oldValue"));
		}
		if (valueCurrent <= maxValue) {
			$(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr(
				"disabled"
			);
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

	$("#sss").hover(function () {
		$("#menu1").remove();
		$("#sss").append('<ul id="menu1"></ul>');
		$.ajax({
			url: base_url + "/main/getDataKategori",
			type: "post",
			dataType: "json",
			success: function (result) {
				for (let i = 0; i < result.length; i++) {
					$("#menu1").append(
						'<li id="idmenu' +
							i +
							'" ><a href="#" id="link' +
							i +
							'">' +
							result[i].nm_kategori +
							"</a></li>" +
							""
					);

					$("#idmenu" + i).hover(function () {
						$.ajax({
							url: base_url + "/main/getDataSubKategori",
							type: "post",
							dataType: "json",
							data: {
								kd_kategori: result[i].kd_kategori,
							},
							success: function (data) {
								if (data.length > 0) {
									$("#ulmenu" + i).remove();

									$("#idmenu" + i).append(
										'<ul id="ulmenu' + i + '"></ul>' + ""
									);

									for (let j = 0; j < data.length; j++) {
										$("#ulmenu" + i).append(
											'<li><a href="' +
												base_url +
												"/product/getProductSubKategori/" +
												data[j].kd_sub_kategori +
												'">' +
												data[j].nm_sub_kategori +
												"</a></li>" +
												""
										);
									}
								}
							},
						});
					});
				}
			},
		});
	});
});
