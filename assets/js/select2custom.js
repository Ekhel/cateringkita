$(document).ready(function () {
	function convertToRupiah(angka) {
		if (angka != "" && angka != null) {
			var rupiah = "";
			var angkarev = angka.toString().split("").reverse().join("");
			for (var i = 0; i < angkarev.length; i++)
				if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ",";
			return (
				"Rp. " +
				rupiah
					.split("", rupiah.length - 1)
					.reverse()
					.join("")
			);
		} else {
			return 0;
		}
	}

	function toast() {
		const flashData = $(".flash-data1").html();
		const errorData = $(".error-data1").html();

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

	var base_url = baseurl();

	$(".select2tujuan").select2({
		minimumInputLength: 3,
		placeholder: "Masukkan Kecamatan",
		ajax: {
			url: base_url + "/catering/get_tujuan",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2tujuan1").select2({
		minimumInputLength: 3,
		placeholder: "Masukkan Kecamatan",
		ajax: {
			url: base_url + "/catering/get_tujuan",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2tujuan1").on("select2:select", function (e) {
		var kodepos = e.params.data.kodepos;
		$("#kodepos").val(kodepos);
		$("#edit_kode_pos").html(kodepos);
		$("#edit_kode_pos").val(kodepos);
		$("#kode_pos_edit").val(kodepos);
		$("#kode_pos_lain").val(kodepos);
		$("#kode_pos_lain_edit").val(kodepos);
	});

	$(".select2tujuan").on("select2:select", function (e) {
		var kodepos = e.params.data.kodepos;
		var text = e.params.data.text;
		var id = e.params.data.id;
		var jnskecamatan = $("#jnskecamatan").val();
		$("#kode_pos").html(kodepos);
		$("#kode_pos").val(kodepos);
		$("#kode_pos_val").val(kodepos);
		$("#kode_pos_edit").val(kodepos);
		$("#kodepos_utama").val(kodepos);
		$("#kodepos_lain").val(kodepos);

		$("#kecamatan_baru_hid").val(id);

		if (jnskecamatan == "utama") {
			$("#kecamatan_utama").val(text);
			$("#kecamatan_utama_hid").val(id);
			$("#kodepos_utama").val(kodepos);

			$("#kecamatan_lain").val("");
			$("#kecamatan_lain_hid").val("");
			$("#kecamatan_baru").val("");
			$("#kecamatan_baru_hid").val("");
		} else if (jnskecamatan == "lainnya") {
			$("#kecamatan_lain").val(text);
			$("#kecamatan_lain_hid").val(id);
			$("#kodepos_lain").val(kodepos);

			$("#kecamatan_utama").val("");
			$("#kecamatan_utama_hid").val("");
			$("#kecamatan_baru").val("");
			$("#kecamatan_baru_hid").val("");
		} else if (jnskecamatan == "baru") {
			$("#kecamatan_baru").val(text);
			$("#kecamatan_baru_hid").val(id);
			$("#kodepos_baru").val(kodepos);

			$("#kecamatan_utama").val("");
			$("#kecamatan_utama_hid").val("");
			$("#kecamatan_lain").val("");
			$("#kecamatan_lain_hid").val("");
		}
	});

	$(".select2kurir").select2({
		placeholder: "Pilih Kurir",
		ajax: {
			url: base_url + "/Admin/get_kurir_json",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2kurir").on("select2:select", function (e) {
		var nama = e.params.data.text;
		$("#kurir_name_edit").val(nama);
		$("#kurir_name").html(nama);
	});

	$(".select2memberRes").select2({
		placeholder: "Pilih Member",
		ajax: {
			url: base_url + "/select2/get_json_member_res",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
					reseller: $("#reseller").val(),
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2memberResNew").select2({
		placeholder: "Pilih Member",
		ajax: {
			url: base_url + "/select2/get_json_member_res_new",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
					reseller: $("#reseller").val(),
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2memberResNew").on("select2:select", function (e) {
		var maxGroupbarang = $("#jmlbarang").val();

		var dataModal = [];

		for (let j = 1; j <= maxGroupbarang; j++) {
			var obj = {};
			obj = $("#member_banyak" + j).val();
			if (obj != undefined) {
				dataModal.push(obj);
			}
		}

		$("#catatan").summernote("code", dataModal.join());
	});

	$(".select2memberRes").on("select2:select", function (e) {
		var nama = e.params.data.nama;
		var no_telp = e.params.data.no_telp;
		var email = e.params.data.email;
		var kodepos = e.params.data.kodepos;
		var alamat = e.params.data.alamat;
		var kecamatan = e.params.data.kecamatan;
		var kec_text = e.params.data.kec_text;
		var searchmap = e.params.data.alamat_ongkir;
		var jarak = e.params.data.jarak;
		var lat_ongkir = e.params.data.lat_alamat;
		var lon_ongkir = e.params.data.lon_alamat;
		var subregion = e.params.data.subregion;
		var city = e.params.data.city;
		var nbrhd = e.params.data.nbrhd;

		$("#kecamatan_utama").val(kec_text);
		$("#kecamatan_utama_hid").val(kecamatan);
		$("#nm_penerima_utama").val(nama);
		$("#no_telp_utama").val(no_telp);
		$("#email_utama").val(email);
		$("#kodepos_utama").val(kodepos);
		$("#alamat_utama").summernote("code", decrypt(alamat));
		$(".alamat_member").val(searchmap);
		$(".jarak_member").val(jarak);
		$("#subregion").val(subregion);
		$("#city").val(city);
		$("#city1").val(city);
		$("#nbrhd").val(nbrhd);
		$("#latitude_order").val(lat_ongkir);
		$("#longitude_order").val(lon_ongkir);
	});

	$(".select2member").select2({
		placeholder: "Pilih Member",
		minimumInputLength: 3,
		ajax: {
			url: base_url + "/Member/get_json",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2member").on("select2:select", function (e) {
		var nama = e.params.data.nama;
		var no_telp = e.params.data.no_telp;
		var email = e.params.data.email;
		var kodepos = e.params.data.kodepos;
		var alamat = e.params.data.alamat;
		var kecamatan = e.params.data.kecamatan;
		var kec_text = e.params.data.kec_text;
		var searchmap = e.params.data.alamat_ongkir;
		var jarak = e.params.data.jarak;
		var lat_ongkir = e.params.data.lat_alamat;
		var lon_ongkir = e.params.data.lon_alamat;
		var subregion = e.params.data.subregion;
		var city = e.params.data.city;
		var nbrhd = e.params.data.nbrhd;

		$("#kecamatan_utama").val(kec_text);
		$("#kecamatan_utama_hid").val(kecamatan);
		$("#nm_penerima_utama").val(nama);
		$("#no_telp_utama").val(no_telp);
		$("#email_utama").val(email);
		$("#kodepos_utama").val(kodepos);
		$("#alamat_utama").summernote("code", decrypt(alamat));
		$(".alamat_member").val(searchmap);
		$(".jarak_member").val(jarak);
		$("#subregion").val(subregion);
		$("#city").val(city);
		$("#city1").val(city);
		$("#nbrhd").val(nbrhd);
		$("#latitude_order").val(lat_ongkir);
		$("#longitude_order").val(lon_ongkir);
	});

	$(".select2kary").select2();
	$(".select2multiple-tagss").select2({
		placeholder: "Jika tidak ada bisa di ketik saja",
		tags: true,
		tokenSeparators: [",", " "],
	});

	$(".select2memberlain").select2({
		placeholder: "Pilih Member",
		minimumInputLength: 3,
		ajax: {
			url: base_url + "/Member/get_json",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2memberlain").on("select2:select", function (e) {
		var nama = e.params.data.nama;
		var no_telp = e.params.data.no_telp;
		var email = e.params.data.email;
		var kodepos = e.params.data.kodepos;
		var alamat = e.params.data.alamat;
		var kecamatan = e.params.data.kecamatan;
		var kec_text = e.params.data.kec_text;

		$("#kecamatan_lain").val(kec_text);
		$("#kecamatan_lain_hid").val(kecamatan);
		$("#nm_penerima_lain_null").val(nama);
		$("#no_telp_lain").val(no_telp);
		$("#email_lain").val(email);
		$("#kodepos_lain").val(kodepos);
		$("#alamat_lain").summernote("code", decrypt(alamat));
	});

	$(".select2kategori").select2({
		placeholder: "Pilih Kategori",
		ajax: {
			url: base_url + "/kategori/get_json",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2kategori").on("select2:select", function (e) {
		$("#sub_kat").show(500);
		$("#sub_kategori").val("").trigger("change");
	});

	$(".select2subkategori").select2({
		placeholder: "Pilih Sub Kategori",
		ajax: {
			url: base_url + "/kategori/get_json_sub",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
					kd_kategori: $("#kategori").val(),
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2satuanBerat").select2({
		ajax: {
			url: base_url + "/Satuan_berat/get_json",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2supplier").select2({
		placeholder: "Pilih Supplier",
		ajax: {
			url: base_url + "/supplier/get_json",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2reseller").select2({
		placeholder: "Pilih Reseller",
		ajax: {
			url: base_url + "/reseller/get_json",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2produk").select2({
		placeholder: "Pilih Produk",
		ajax: {
			url: base_url + "/select2/get_json_detail_produk",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2produkmasuk").select2({
		placeholder: "Pilih Produk",
		ajax: {
			url: base_url + "/select2/get_json_detail_produk",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2produkmasuk").on("select2:select", function (e) {
		var id = e.params.data.id;

		$.ajax({
			url: base_url + "/Product/getdetailprodukcalc",
			type: "post",
			dataType: "json",
			data: {
				kd_detail: id,
			},
			success: function (data) {
				$("#harga_modal1").val(data.harga_modal);
				$("#harga_produk1").val(data.harga_produk);
				$("#ujroh_reseller1").val(data.margin_reseller);
				$("#biaya_lainnya1").val(data.biaya_lainnya);
				$("#total_modal1").val(data.total_modal);
				$("#margin1").val(data.margin_produk);
				$("#hasil_margin1").val(data.hasil_margin);
				$("#harga_jual1").val(data.harga_jual);
				$("#pembulatan_harga_jual1").val(data.pembulatan_harga_jual);
				$("#harga_competitor1").val(data.harga_kompetitor);
				$("#selisih_harga1").val(data.selisih_harga);
				$("#margin1001").val(data.margin_keseluruhan);
				$("#margin701").val(data.margin_selera);
				$("#margin301").val(data.margin_reseller);
				$("#insentif1").val(data.insentif);
				$("#hasil_insentif1").val(data.hasil_harga_insentif);
				$("#harga_jual_reseller1").val(data.pembulatan_harga_reseller);
				$("#selisih_harga_jual1").val(data.selisih_harga_jual);
				$("#kelebihan_bagi_hasil1").val(data.kelebihan_margin_ujroh);
				$("#hrg_competitor1").val(data.harga_kompetitor);
				$("#hrg_jual_umum1").val(data.pembulatan_harga_jual);
				$("#hrg_jual_reseller1").val(data.pembulatan_harga_reseller);
			},
		});
	});

	$("#ujroh_reseller1").on("keyup", function () {
		var ujroh = $(this).val();

		var margin100 = $("#margin1001").val();
		var margin70 = $("#margin701").val();
		var margin30 = $("#margin301").val();

		if (margin100 == "" || margin100 == null) {
			Toast.fire({
				icon: "error",
				title: "Harap Memilih produk terlebih dahulu.",
			});
			$("#ujroh_reseller1").val(0);
		} else {
			if (parseInt(ujroh) > parseInt(margin100)) {
				$(".error-data1").html(
					"Maaf ujroh tidak bisa lebih dari Rp." + margin100
				);
				$(".flash-data1").html("");
				toast();
				$("#ujroh_reseller1").val(0);
			} else {
				var ujroh_selera = margin100 - ujroh;
				$("#margin301").val(ujroh);
				$("#margin701").val(ujroh_selera);
			}
		}
	});

	$("#checkboxbayarnanti1").click(function () {
		if ($(this).prop("checked") == true) {
			$(".bagian-pembayaran").hide(500);
			$("#metode_pembayaran1").attr("required", false);
		} else {
			$(".bagian-pembayaran").show(500);
			$("#metode_pembayaran1").attr("required", true);
		}
	});

	$("#metode_pembayaran1").change(function () {
		var val = $(this).val();

		if (val == "transfer") {
			$("#bagian-metode-pembayaran").removeClass("col-12 col-sm-12 col-md-12");
			$("#bagian-metode-pembayaran").addClass("col-6 col-sm-6 col-md-6");
			$(".bagian-bukti-pembayaran").show(500);
		} else {
			$(".bagian-bukti-pembayaran").hide();
			$("#bagian-metode-pembayaran").removeClass("col-6 col-sm-6 col-md-6");
			$("#bagian-metode-pembayaran").addClass("col-12 col-sm-12 col-md-12");
		}
	});

	$(".select2stokproduk").select2({
		placeholder: "Pilih Produk",
		ajax: {
			url: base_url + "/select2/get_json_stok_produk",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
					lokasi: $("#lokasi_stok").val(),
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2stokproduk").on("select2:select", function (e) {
		var stok = e.params.data.stok;
		$("#stok_produk_keluar1").val(stok);
		$("#stok_produk_keluar").val(stok);
	});

	$(".select2produkpo").select2({
		placeholder: "Pilih Produk",
		ajax: {
			url: base_url + "/select2/get_json_detail_produkpo",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2produk").on("select2:select", function (e) {
		var harga = e.params.data.harga;
		$("#harga_produk").val(harga);
	});

	$("#promo_produk_bonus").select2({
		placeholder: "Pilih Produk",
		ajax: {
			url: base_url + "/select2/get_json_detail_produk_bonus",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2produkpaket").select2({
		placeholder: "Pilih Produk",
		ajax: {
			url: base_url + "/select2/get_json_detail_produk",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2produkpaket").on("select2:select", function (e) {
		var harga = e.params.data.harga;
		var ujroh = e.params.data.jmlKomisi;
		var ujrohSelera = e.params.data.jmlKomisiSelera;
		var maxGroupbarang = $("#jmlbarang").val();
		var qty = $("#qtypaket1").val();

		if (qty != "") {
			if (isNaN(qty)) qty = 0;
			$("#harga_produk1").val(harga * qty);
		} else {
			$("#harga_produk1").val(harga);
			$("#harga_produkk1").val(harga);
		}

		$("#hid_ujroh1").val(ujroh);
		$("#hid_ujroh_selera1").val(ujrohSelera);
		$("#ujroh1").val(ujroh);
		$("#ujroh_selera1").val(ujrohSelera);

		var dataModal = [];

		for (let j = 1; j <= maxGroupbarang; j++) {
			var obj = {};
			obj = $("#harga_produk" + j).val();
			if (obj == undefined || obj == "") {
				obj = 0;
			}
			dataModal.push(obj);
		}

		var myTotalModal = 0;

		for (var j = 0, len = dataModal.length; j < len; j++) {
			myTotalModal += parseInt(dataModal[j]);
		}

		$("#harga_modal").val(myTotalModal);
	});

	$(".select2produkgrosir").select2({
		placeholder: "Pilih Produk",
		ajax: {
			url: base_url + "/select2/get_json_detail_produk",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2produkgrosir").on("select2:select", function (e) {
		var harga = e.params.data.harga;
		var ujroh = e.params.data.jmlKomisi;
		var ujrohSelera = e.params.data.jmlKomisiSelera;
		var maxGroupbarang = $("#jmlbarang").val();

		$("#harga_produk1").val(harga);
		$("#harga_produkk1").val(harga);

		$("#hid_ujroh1").val(ujroh);
		$("#hid_ujroh_selera1").val(ujrohSelera);
		$("#ujroh1").val(ujroh);
		$("#ujroh_selera1").val(ujrohSelera);

		var dataModal = [];

		for (let j = 1; j <= maxGroupbarang; j++) {
			var obj = {};
			obj = $("#harga_produk" + j).val();
			if (obj == undefined || obj == "") {
				obj = 0;
			}
			dataModal.push(obj);
		}

		var myTotalModal = 0;

		for (var j = 0, len = dataModal.length; j < len; j++) {
			myTotalModal += parseInt(dataModal[j]);
		}

		$("#harga_modal").val(myTotalModal);
	});

	$(".select2productpaket").select2({
		placeholder: "Pilih Produk",
		ajax: {
			url: base_url + "/select2/get_json_produk_paket",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2productpaket").on("select2:select", function (e) {
		var harga = e.params.data.harga_promo;

		var maxGroupbarang = $("#jmlbarang").val();
		var qty = $("#qtyy1").val();

		var qty = $("#qtyy1").val();
		if (qty == "" || qty == undefined) {
			qty = 0;
		}
		// if (data >= parseInt(qty) || $("#qty" + i).val() == "") {
		// $("#sub_total1").val(harga * qty);
		if (qty != "") {
			if (isNaN(qty)) qty = 0;
			$("#sub_total1").val(harga * qty);
		} else {
			$("#sub_total1").val(harga);
		}

		$("#harga_produk1").val(harga);

		var data = [];
		for (let j = 1; j <= maxGroupbarang; j++) {
			var obj = {};
			obj = $("#sub_total" + j).val();
			if (obj == undefined || obj == "") {
				obj = 0;
			}
			data.push(obj);
		}
		var myTotal = 0;
		for (var j = 0, len = data.length; j < len; j++) {
			myTotal += parseInt(data[j]);
		}
		if (
			($("#checkboxmember").prop("checked") == true &&
				$("#checkboxalamat").prop("checked") == true) ||
			$("#checkboxalamat").prop("checked") == true
		) {
			ongkir = parseInt($("#ongkir_lain").val());
		} else if ($("#checkboxmember").prop("checked") == true) {
			ongkir = parseInt($("#ongkir_baru").val());
		} else {
			ongkir = parseInt($("#ongkir_utama").val());
		}
		var diskonTambahan = $("#diskon_tambahan").val();
		if (isNaN(diskonTambahan)) diskonTambahan = 0;
		if (isNaN(ongkir)) ongkir = 0;
		$("#total_harga").val(
			parseInt(myTotal - diskonTambahan) + parseInt(ongkir)
		);
		if (parseInt(myTotal - diskonTambahan) + parseInt(ongkir) < 0) {
			$("#total_harga").val(0);
		}
		// } else {
		// 	$(".error-data1").html("Stok Tinggal Tersisa " + data);
		// 	$(".flash-data1").html("");
		// 	$("#qty" + i).val("");
		// 	$("#sub_total" + i).val(0);
		// 	$("#jmlkomisi" + i).val(jmlKomisi);
		// 	toast();
		// }
	});

	var jml_record = $("#jml_record").val();

	for (let i = 1; i <= jml_record; i++) {
		$(".select2productpaket" + i).select2({
			placeholder: "Pilih Produk",
			ajax: {
				url: base_url + "/select2/get_json_produk_paket",
				type: "post",
				dataType: "json",
				delay: 100,
				data: function (params) {
					return {
						searchTerm: params.term, // search term
					};
				},
				processResults: function (response) {
					return {
						results: response,
					};
				},
				cache: true,
			},
		});

		$(".select2productpaket" + i).on("select2:select", function (e) {
			var harga = e.params.data.harga_promo;

			var maxGroupbarang = $("#jmlbarang").val();

			var qty = $("#qty" + i).val();
			if (qty == "" || qty == undefined) {
				qty = 0;
			}
			// if (data >= parseInt(qty) || $("#qty" + i).val() == "") {
			// $("#sub_total"+i).val(harga * qty);
			if (qty != "") {
				if (isNaN(qty)) qty = 0;
				$("#sub_total" + i).val(harga * qty);
			} else {
				$("#sub_total" + i).val(harga);
			}

			$("#harga_produk" + i).val(harga);

			var data = [];
			for (let j = 1; j <= maxGroupbarang; j++) {
				var obj = {};
				obj = $("#sub_total" + j).val();
				if (obj == undefined || obj == "") {
					obj = 0;
				}
				data.push(obj);
			}
			var myTotal = 0;
			for (var j = 0, len = data.length; j < len; j++) {
				myTotal += parseInt(data[j]);
			}
			if (
				($("#checkboxmember").prop("checked") == true &&
					$("#checkboxalamat").prop("checked") == true) ||
				$("#checkboxalamat").prop("checked") == true
			) {
				ongkir = parseInt($("#ongkir_lain").val());
			} else if ($("#checkboxmember").prop("checked") == true) {
				ongkir = parseInt($("#ongkir_baru").val());
			} else {
				ongkir = parseInt($("#ongkir_utama").val());
			}
			var diskonTambahan = $("#diskon_tambahan").val();
			if (isNaN(diskonTambahan)) diskonTambahan = 0;
			if (isNaN(ongkir)) ongkir = 0;
			$("#total_harga").val(
				parseInt(myTotal - diskonTambahan) + parseInt(ongkir)
			);
			if (parseInt(myTotal - diskonTambahan) + parseInt(ongkir) < 0) {
				$("#total_harga").val(0);
			}
			// } else {
			// 	$(".error-data1").html("Stok Tinggal Tersisa " + data);
			// 	$(".flash-data1").html("");
			// 	$("#qty" + i).val("");
			// 	$("#sub_total" + i).val(0);
			// 	$("#jmlkomisi" + i).val(jmlKomisi);
			// 	toast();
			// }
		});
	}

	$(".select2supplier").on("select2:select", function (e) {
		var text = "";
		$("#produk1_edit").select2().val(null).trigger("change");
		$("#jenis_produk1_edit").select2().val(null).trigger("change");

		$.ajax({
			url: base_url + "/select2/getProductBySup",
			type: "post",
			dataType: "json",
			data: {
				kd_supplier: $("#supplier_edit").val(),
			},
			success: function (response) {
				for (let i = 0; i < response.length; i++) {
					text +=
						"<option value=" +
						response[i].kd_produk +
						">" +
						response[i].nm_produk +
						"</option>";
				}
				$("#produk1_edit").html(text);
			},
		});
	});

	$(document).ready(function () {
		var jmlBarang = $("#jmlbarang1").val();

		if (jmlBarang > 0) {
			for (let i = 1; i <= jmlBarang; i++) {
				$("#detailkalkulasiharga" + i).click(function () {
					var harga_modal = $("#harga_modal" + i).val();
					$("#hrg_modal" + i).val(harga_modal);
					$("#ttl_hrg_modal" + i).val(harga_modal);

					if (harga_modal > 0) {
						$("#setperhitunganharga" + i).modal("show");
					} else {
						Toast.fire({
							icon: "error",
							title: "Harga Modal Harus Ditentukan Terlebih Dahulu",
						});
					}
				});

				$(".select2produk" + i).select2({
					placeholder: "Pilih Produk",
					ajax: {
						url: base_url + "/select2/get_json_produk",
						type: "post",
						dataType: "json",
						delay: 100,
						data: function (params) {
							return {
								searchTerm: params.term, // search term
							};
						},
						processResults: function (response) {
							return {
								results: response,
							};
						},
						cache: true,
					},
				});

				$(".select2produk" + i).on("select2:select", function (e) {
					var id = e.params.data.id;
					var idd = id.substr(0, 2);

					if (idd == "PR") {
						beliProdukPO(e);
					} else {
						if (e.params.data.jns_produk == "po") {
							$.ajax({
								url: base_url + "/product/getDetailProdukPoById",
								type: "post",
								dataType: "json",
								data: {
									kd_produk: e.params.data.id,
									tabel: "detail_produk",
								},
								success: function (data) {
									if (data) {
										const today = moment().format("YYYY-MM-DD");
										if (today >= data.date_start && today <= data.date_end) {
											beliProdukPO(e);
										} else {
											pesanErrorProdukPO();
										}
									} else {
										pesanErrorProdukPO();
									}
								},
							});
						} else {
							beliProdukPO(e);
						}
					}
				});

				function beliProdukPO(e) {
					var id = e.params.data.id;
					var harga = e.params.data.harga;
					var maxGroupbarang = $("#jmlbarang").val();

					if (id.substr(0, 2) == "PR") {
						$.ajax({
							url: base_url + "/product/cekSumUjrohPaketandStok",
							type: "post",
							dataType: "json",
							data: {
								kd_promo: id,
							},
							success: function (ujroh) {
								if (ujroh.stok >= parseInt(qty) || $("#qty" + i).val() == "") {
									$("#qty" + i).attr("readonly", false);
									$("#jmlkomisi" + i).val(ujroh.data.ujroh);
									$("#jmlkomisii" + i).val(ujroh.data.ujroh);
									$("#qty" + i).focus();

									var qty = $("#qty" + i).val();
									var diskonn = $("#diskon" + i).val();
									if (isNaN(qty)) qty = 0;
									if (isNaN(diskonn)) diskonn = 0;

									if (qty == 0) {
										$("#diskon" + i).val(diskonn);
									} else {
										$("#diskon" + i).val(diskonn * qty);
									}
									$("#diskonn" + i).val(diskon);
									// if (data >= parseInt(qty) || $("#qty" + i).val() == "") {
									// $("#sub_total1").val(harga * qty);
									if (qty != "") {
										if (isNaN(qty)) qty = 0;
										$("#sub_total" + i).val(
											parseInt(harga * qty) - $("#diskon" + i).val()
										);
									} else {
										$("#sub_total" + i).val(harga);
									}

									$("#diskon" + i).val(0);

									$("#harga_produk" + i).val(harga);

									var data = [];
									for (let j = 1; j <= maxGroupbarang; j++) {
										var obj = {};
										obj = $("#sub_total" + j).val();
										if (obj == undefined || obj == "") {
											obj = 0;
										}
										data.push(obj);
									}
									var myTotal = 0;
									for (var j = 0, len = data.length; j < len; j++) {
										myTotal += parseInt(data[j]);
									}

									$.ajax({
										url: base_url + "/konfigurasi/getKonfigurasi",
										type: "post",
										dataType: "json",
										success: function (dta) {
											var jrk = $("#jarak").val();
											var jarak = jrk.replace(" KM", "");
											var pilihan_kurir = $("#pilihan_kurir").val();
											if (
												jarak <= parseFloat(5) &&
												pilihan_kurir == "CateringKita"
											) {
												if (myTotal >= dta.max_harga_pesanan) {
													$("#ongkir_utama").val(0);
												} else if (myTotal < dta.max_harga_pesanan) {
													$("#ongkir_utama").val(dta.harga_ongkir_minimal);
												}
											} else if (
												myTotal >= dta.max_harga_pesanan_kedua &&
												pilihan_kurir == "CateringKita"
											) {
												var subregion = $("#subregion").val();
												var jrk = $("#jarak").val();
												var nbrhd = $("#nbrhd").val();
												var jarak = jrk.replace(" KM", "");
												var city = $("#city").val();

												$.ajax({
													url: base_url + "/konfigurasi/get_ongkir_khususs",
													type: "post",
													dataType: "json",
													data: {
														subregion: subregion,
														nbrhd: nbrhd,
														city: city,
													},
													success: function (data) {
														if (subregion == data.ongkir.nama_daerah) {
															if (data.ong_khusus) {
																ongkir = data.ong_khusus.nominal_ongkir2;
															} else {
																ongkir = data.ongkir.ongkir2;
															}
														} else {
															alert("ongkir Diluar Data Yang Disetting");
														}

														$("#ongkir_utama").val(ongkir);
													},
												});
											} else if (
												myTotal < dta.max_harga_pesanan_kedua &&
												pilihan_kurir == "CateringKita"
											) {
												var subregion = $("#subregion").val();
												var jrk = $("#jarak").val();
												var nbrhd = $("#nbrhd").val();
												var jarak = jrk.replace(" KM", "");
												var city = $("#city").val();

												$.ajax({
													url: base_url + "/konfigurasi/get_ongkir_khususs",
													type: "post",
													dataType: "json",
													data: {
														subregion: subregion,
														nbrhd: nbrhd,
														city: city,
													},
													success: function (data) {
														if (subregion == data.ongkir.nama_daerah) {
															if (data.ong_khusus) {
																ongkir = data.ong_khusus.nominal_ongkir1;
															} else {
																ongkir = data.ongkir.ongkir1;
															}
														} else {
															alert("ongkir Diluar Data Yang Disetting");
														}

														$("#ongkir_utama").val(ongkir);
													},
												});
											}
										},
									});
									setTimeout(() => {
										if (
											($("#checkboxmember").prop("checked") == true &&
												$("#checkboxalamat").prop("checked") == true) ||
											$("#checkboxalamat").prop("checked") == true
										) {
											ongkir = parseInt($("#ongkir_lain").val());
										} else if ($("#checkboxmember").prop("checked") == true) {
											ongkir = parseInt($("#ongkir_baru").val());
										} else {
											ongkir = parseInt($("#ongkir_utama").val());
										}
										var diskonTambahan = $("#diskon_tambahan").val();
										if (isNaN(diskonTambahan)) diskonTambahan = 0;
										if (isNaN(ongkir)) ongkir = 0;
										$("#total_harga").val(
											parseInt(myTotal - diskonTambahan) + parseInt(ongkir)
										);
										if (
											parseInt(myTotal - diskonTambahan) + parseInt(ongkir) <
											0
										) {
											$("#total_harga").val(0);
										}
									}, 500);
								} else {
									$(".error-data1").html("Stok Tinggal Tersisa " + ujroh.stok);
									$(".flash-data1").html("");
									$("#qty" + i).val("");
									$("#sub_total" + i).val(0);
									$("#jmlkomisi" + i).val(ujroh.data.ujroh);
									$("#jmlkomisii" + i).val(ujroh.data.ujroh);
									$("#harga_produk" + i).val(harga);
									$("#qty" + i).focus();
									toast();
								}
							},
						});
					} else {
						var diskon = e.params.data.diskon;
						var harga = e.params.data.harga;
						var komisi = e.params.data.komisi;
						var jmlKomisi = e.params.data.jmlKomisi;
						$.ajax({
							url: base_url + "/product/getProdukById",
							type: "post",
							dataType: "json",
							data: {
								kd_produk: id,
							},
							success: function (data) {
								if (data.jns_produk == "po") {
									$.ajax({
										url: base_url + "/product/getDetailProdukPoById",
										type: "post",
										dataType: "json",
										data: {
											kd_produk: id,
											tabel: "detail_produk",
										},
										success: function (data) {
											if (data) {
												var qty = parseInt($("#qty" + i).val());
												var hargaProduk = parseInt(
													$("#harga_produk" + i).val()
												);
												var diskonn = $("#diskon" + i).val();
												if (isNaN(hargaProduk)) hargaProduk = 0;
												if (isNaN(qty)) qty = 0;
												if (isNaN(diskonn)) diskonn = 0;
												$("#qty" + i).attr("readonly", false);
												$("#qty" + i).focus();
												if (qty == 0) {
													$("#diskon" + i).val(diskon);
												} else {
													$("#diskon" + i).val(diskon * qty);
												}
												$("#diskonn" + i).val(diskon);
												$("#harga_produk" + i).val(harga);
												$("#komisi" + i).val(komisi);
												$("#sub_total" + i).val(
													parseInt(harga * qty) - $("#diskon" + i).val()
												);
												$("#jmlkomisi" + i).val(
													qty == 0 ? jmlKomisi : jmlKomisi * qty
												);
												$("#jmlkomisii" + i).val(jmlKomisi);
												var data = [];
												var dataDiskon = [];
												for (let j = 1; j <= maxGroupbarang; j++) {
													var obj = {};
													obj = $("#sub_total" + j).val();
													if (obj == undefined || obj == "") {
														obj = 0;
													}
													data.push(obj);
												}
												for (let j = 1; j <= maxGroupbarang; j++) {
													var obj = {};
													obj = $("#diskon" + j).val();
													if (obj == undefined || obj == "") {
														obj = 0;
													}
													dataDiskon.push(obj);
												}
												var myTotal = 0;
												var myTotalDiskon = 0;
												for (var j = 0, len = data.length; j < len; j++) {
													myTotal += parseInt(data[j]);
												}
												for (var j = 0, len = dataDiskon.length; j < len; j++) {
													myTotalDiskon += parseInt(dataDiskon[j]);
												}

												$.ajax({
													url: base_url + "/konfigurasi/getKonfigurasi",
													type: "post",
													dataType: "json",
													success: function (dta) {
														var jrk = $("#jarak").val();
														var jarak = jrk.replace(" KM", "");
														var pilihan_kurir = $("#pilihan_kurir").val();
														if (
															jarak <= parseFloat(5) &&
															pilihan_kurir == "CateringKita"
														) {
															if (myTotal >= dta.max_harga_pesanan) {
																$("#ongkir_utama").val(0);
															} else if (myTotal < dta.max_harga_pesanan) {
																$("#ongkir_utama").val(
																	dta.harga_ongkir_minimal
																);
															}
														} else if (
															myTotal >= dta.max_harga_pesanan_kedua &&
															pilihan_kurir == "CateringKita"
														) {
															var subregion = $("#subregion").val();
															var jrk = $("#jarak").val();
															var nbrhd = $("#nbrhd").val();
															var jarak = jrk.replace(" KM", "");
															var city = $("#city").val();

															$.ajax({
																url:
																	base_url + "/konfigurasi/get_ongkir_khususs",
																type: "post",
																dataType: "json",
																data: {
																	subregion: subregion,
																	nbrhd: nbrhd,
																	city: city,
																},
																success: function (data) {
																	if (subregion == data.ongkir.nama_daerah) {
																		if (data.ong_khusus) {
																			ongkir = data.ong_khusus.nominal_ongkir2;
																		} else {
																			ongkir = data.ongkir.ongkir2;
																		}
																	} else {
																		alert("ongkir Diluar Data Yang Disetting");
																	}

																	$("#ongkir_utama").val(ongkir);
																},
															});
														} else if (
															myTotal < dta.max_harga_pesanan_kedua &&
															pilihan_kurir == "CateringKita"
														) {
															var subregion = $("#subregion").val();
															var jrk = $("#jarak").val();
															var nbrhd = $("#nbrhd").val();
															var jarak = jrk.replace(" KM", "");
															var city = $("#city").val();

															$.ajax({
																url:
																	base_url + "/konfigurasi/get_ongkir_khususs",
																type: "post",
																dataType: "json",
																data: {
																	subregion: subregion,
																	nbrhd: nbrhd,
																	city: city,
																},
																success: function (data) {
																	if (subregion == data.ongkir.nama_daerah) {
																		if (data.ong_khusus) {
																			ongkir = data.ong_khusus.nominal_ongkir1;
																		} else {
																			ongkir = data.ongkir.ongkir1;
																		}
																	} else {
																		alert("ongkir Diluar Data Yang Disetting");
																	}

																	$("#ongkir_utama").val(ongkir);
																},
															});
														}
													},
												});

												setTimeout(() => {
													if (
														($("#checkboxmember").prop("checked") == true &&
															$("#checkboxalamat").prop("checked") == true) ||
														$("#checkboxalamat").prop("checked") == true
													) {
														ongkir = parseInt($("#ongkir_lain").val());
													} else if (
														$("#checkboxmember").prop("checked") == true
													) {
														ongkir = parseInt($("#ongkir_baru").val());
													} else {
														ongkir = parseInt($("#ongkir_utama").val());
													}
													var diskonTambahan = $("#diskon_tambahan").val();
													if (isNaN(diskonTambahan)) diskonTambahan = 0;
													if (isNaN(ongkir)) ongkir = 0;
													$("#total_harga").val(
														parseInt(myTotal - diskonTambahan) +
															parseInt(ongkir)
													);
													if (
														parseInt(myTotal - diskonTambahan) +
															parseInt(ongkir) <
														0
													) {
														$("#total_harga").val(0);
													}
												}, 500);
											} else {
												$("#jenis_produk" + i)
													.val("")
													.trigger("change");
												pesanErrorProdukPO();
											}
										},
									});
								} else if (data.jns_produk == "stock") {
									var qty = parseInt($("#qty" + i).val());
									var hargaProduk = parseInt($("#harga_produk" + i).val());
									if (isNaN(hargaProduk)) hargaProduk = 0;
									if (isNaN(qty)) qty = 0;
									$("#qty" + i).attr("readonly", false);
									$("#qty" + i).focus();
									if (qty == 0) {
										$("#diskon" + i).val(diskon);
									} else {
										$("#diskon" + i).val(diskon * qty);
									}
									$("#diskonn" + i).val(diskon);
									$("#harga_produk" + i).val(harga);
									$("#komisi" + i).val(komisi);
									$.ajax({
										url: base_url + "/select2/cekStokProduct",
										type: "post",
										dataType: "json",
										data: {
											kd_detail_produk: id,
										},
										success: function (data) {
											var qty = $("#qty" + i).val();
											if (qty == "" || qty == undefined) {
												qty = 0;
											}
											if (data >= parseInt(qty) || $("#qty" + i).val() == "") {
												$("#sub_total" + i).val(
													parseInt(harga * qty) - $("#diskon" + i).val()
												);
												$("#jmlkomisi" + i).val(
													qty == 0 ? jmlKomisi : jmlKomisi * qty
												);
												$("#jmlkomisii" + i).val(jmlKomisi);
												var data = [];
												var dataDiskon = [];
												for (let j = 1; j <= maxGroupbarang; j++) {
													var obj = {};
													obj = $("#sub_total" + j).val();
													if (obj == undefined || obj == "") {
														obj = 0;
													}
													data.push(obj);
												}
												for (let j = 1; j <= maxGroupbarang; j++) {
													var obj = {};
													obj = $("#diskon" + j).val();
													if (obj == undefined || obj == "") {
														obj = 0;
													}
													dataDiskon.push(obj);
												}
												var myTotal = 0;
												var myTotalDiskon = 0;
												for (var j = 0, len = data.length; j < len; j++) {
													myTotal += parseInt(data[j]);
												}
												for (var j = 0, len = dataDiskon.length; j < len; j++) {
													myTotalDiskon += parseInt(dataDiskon[j]);
												}

												$.ajax({
													url: base_url + "/konfigurasi/getKonfigurasi",
													type: "post",
													dataType: "json",
													success: function (dta) {
														var jrk = $("#jarak").val();
														var jarak = jrk.replace(" KM", "");
														var pilihan_kurir = $("#pilihan_kurir").val();
														if (
															jarak <= parseFloat(5) &&
															pilihan_kurir == "CateringKita"
														) {
															if (myTotal >= dta.max_harga_pesanan) {
																$("#ongkir_utama").val(0);
															} else if (myTotal < dta.max_harga_pesanan) {
																$("#ongkir_utama").val(
																	dta.harga_ongkir_minimal
																);
															}
														} else if (
															myTotal >= dta.max_harga_pesanan_kedua &&
															pilihan_kurir == "CateringKita"
														) {
															var subregion = $("#subregion").val();
															var jrk = $("#jarak").val();
															var nbrhd = $("#nbrhd").val();
															var jarak = jrk.replace(" KM", "");
															var city = $("#city").val();

															$.ajax({
																url:
																	base_url + "/konfigurasi/get_ongkir_khususs",
																type: "post",
																dataType: "json",
																data: {
																	subregion: subregion,
																	nbrhd: nbrhd,
																	city: city,
																},
																success: function (data) {
																	if (subregion == data.ongkir.nama_daerah) {
																		if (data.ong_khusus) {
																			ongkir = data.ong_khusus.nominal_ongkir2;
																		} else {
																			ongkir = data.ongkir.ongkir2;
																		}
																	} else {
																		alert("ongkir Diluar Data Yang Disetting");
																	}

																	$("#ongkir_utama").val(ongkir);
																},
															});
														} else if (
															myTotal < dta.max_harga_pesanan_kedua &&
															pilihan_kurir == "CateringKita"
														) {
															var subregion = $("#subregion").val();
															var jrk = $("#jarak").val();
															var nbrhd = $("#nbrhd").val();
															var jarak = jrk.replace(" KM", "");
															var city = $("#city").val();

															$.ajax({
																url:
																	base_url + "/konfigurasi/get_ongkir_khususs",
																type: "post",
																dataType: "json",
																data: {
																	subregion: subregion,
																	nbrhd: nbrhd,
																	city: city,
																},
																success: function (data) {
																	if (subregion == data.ongkir.nama_daerah) {
																		if (data.ong_khusus) {
																			ongkir = data.ong_khusus.nominal_ongkir1;
																		} else {
																			ongkir = data.ongkir.ongkir1;
																		}
																	} else {
																		alert("ongkir Diluar Data Yang Disetting");
																	}

																	$("#ongkir_utama").val(ongkir);
																},
															});
														}
													},
												});

												setTimeout(() => {
													if (
														($("#checkboxmember").prop("checked") == true &&
															$("#checkboxalamat").prop("checked") == true) ||
														$("#checkboxalamat").prop("checked") == true
													) {
														ongkir = parseInt($("#ongkir_lain").val());
													} else if (
														$("#checkboxmember").prop("checked") == true
													) {
														ongkir = parseInt($("#ongkir_baru").val());
													} else {
														ongkir = parseInt($("#ongkir_utama").val());
													}
													var diskonTambahan = $("#diskon_tambahan").val();
													if (isNaN(diskonTambahan)) diskonTambahan = 0;
													if (isNaN(ongkir)) ongkir = 0;
													$("#total_harga").val(
														parseInt(myTotal - diskonTambahan) +
															parseInt(ongkir)
													);
													if (
														parseInt(myTotal - diskonTambahan) +
															parseInt(ongkir) <
														0
													) {
														$("#total_harga").val(0);
													}
												}, 500);
											} else {
												$(".error-data1").html("Stok Tinggal Tersisa " + data);
												$(".flash-data1").html("");
												$("#qty" + i).val("");
												$("#sub_total" + i).val(0);
												$("#jmlkomisi" + i).val(jmlKomisi);
												toast();
												var data = [];
												var dataDiskon = [];
												for (let j = 1; j <= maxGroupbarang; j++) {
													var obj = {};
													obj = $("#sub_total" + j).val();
													if (obj == undefined || obj == "") {
														obj = 0;
													}
													data.push(obj);
												}
												for (let j = 1; j <= maxGroupbarang; j++) {
													var obj = {};
													obj = $("#diskon" + j).val();
													if (obj == undefined || obj == "") {
														obj = 0;
													}
													dataDiskon.push(obj);
												}
												var myTotal = 0;
												var myTotalDiskon = 0;
												for (var j = 0, len = data.length; j < len; j++) {
													myTotal += parseInt(data[j]);
												}
												for (var j = 0, len = dataDiskon.length; j < len; j++) {
													myTotalDiskon += parseInt(dataDiskon[j]);
												}
												if (
													($("#checkboxmember").prop("checked") == true &&
														$("#checkboxalamat").prop("checked") == true) ||
													$("#checkboxalamat").prop("checked") == true
												) {
													ongkir = parseInt($("#ongkir_lain").val());
												} else if (
													$("#checkboxmember").prop("checked") == true
												) {
													ongkir = parseInt($("#ongkir_baru").val());
												} else {
													ongkir = parseInt($("#ongkir_utama").val());
												}
												var diskonTambahan = $("#diskon_tambahan").val();
												if (isNaN(diskonTambahan)) diskonTambahan = 0;
												if (isNaN(ongkir)) ongkir = 0;
												$("#total_harga").val(
													parseInt(myTotal - diskonTambahan) + parseInt(ongkir)
												);
												if (
													parseInt(myTotal - diskonTambahan) +
														parseInt(ongkir) <
													0
												) {
													$("#total_harga").val(0);
												}
											}
										},
									});
								}
							},
						});
					}
				}

				function pesanErrorProdukPO() {
					$(".error-data1").html(
						"Produk Belum Bisa Dipesan. Pre Order Belum Tersedia."
					);
					$(".flash-data1").html("");
					toast();

					$("#produk" + i)
						.val("")
						.trigger("change");
				}

				$(".select2produksup").select2({
					placeholder: "Pilih Produk",
					ajax: {
						url: base_url + "/select2/get_json_prosup",
						type: "post",
						dataType: "json",
						delay: 100,
						data: function (params) {
							return {
								searchTerm: params.term, // search term
								supplier: $("#supplier").val(),
							};
						},
						processResults: function (response) {
							return {
								results: response,
							};
						},
						cache: true,
					},
				});

				$(".select2produksup").on("select2:select", function (e) {
					var diskon = e.params.data.diskon;
					var harga = e.params.data.harga;
					var komisi = e.params.data.komisi;
					var jmlKomisi = e.params.data.jmlKomisi;
					var maxGroupbarang = $("#jmlbarang").val();

					$.ajax({
						url: base_url + "/product/getProdukById",
						type: "post",
						dataType: "json",
						data: {
							kd_produk: e.params.data.diskon,
						},
						success: function (data) {
							$("#qty" + i).attr("readonly", false);
							$("#qty" + i).focus();
							$("#diskon" + i).val(diskon);
							$("#diskonn" + i).val(diskon);
							$("#harga_produk" + i).val(harga);
							$("#komisi" + i).val(komisi);
							var hargaProduk = parseInt($("#harga_produk" + i).val());
							var qty = parseInt($("#qty" + i).val());
							if (isNaN(hargaProduk)) hargaProduk = 0;
							if (isNaN(qty)) qty = 0;

							$.ajax({
								url: base_url + "/select2/cekStokProduct",
								type: "post",
								dataType: "json",
								data: {
									kd_detail_produk: e.params.data.id,
								},
								success: function (data) {
									var qty = $("#qty" + i).val();
									if (qty == "" || qty == undefined) {
										qty = 0;
									}
									if (data >= parseInt(qty) || $("#qty" + i).val() == "") {
										$("#sub_total" + i).val(hargaProduk * qty);
										$("#jmlkomisi" + i).val(
											qty == 0 ? jmlKomisi : jmlKomisi * qty
										);
										$("#jmlkomisii" + i).val(jmlKomisi);
										var data = [];
										var dataDiskon = [];
										for (let j = 1; j <= maxGroupbarang; j++) {
											var obj = {};
											obj = $("#sub_total" + j).val();
											if (obj == undefined || obj == "") {
												obj = 0;
											}
											data.push(obj);
										}
										for (let j = 1; j <= maxGroupbarang; j++) {
											var obj = {};
											obj = $("#diskon" + j).val();
											if (obj == undefined || obj == "") {
												obj = 0;
											}
											dataDiskon.push(obj);
										}
										var myTotal = 0;
										var myTotalDiskon = 0;
										for (var j = 0, len = data.length; j < len; j++) {
											myTotal += parseInt(data[j]);
										}
										for (var j = 0, len = dataDiskon.length; j < len; j++) {
											myTotalDiskon += parseInt(dataDiskon[j]);
										}
										if (
											($("#checkboxmember").prop("checked") == true &&
												$("#checkboxalamat").prop("checked") == true) ||
											$("#checkboxalamat").prop("checked") == true
										) {
											ongkir = parseInt($("#ongkir_lain").val());
										} else if ($("#checkboxmember").prop("checked") == true) {
											ongkir = parseInt($("#ongkir_baru").val());
										} else {
											ongkir = parseInt($("#ongkir_utama").val());
										}
										var diskonTambahan = $("#diskon_tambahan").val();
										if (isNaN(diskonTambahan)) diskonTambahan = 0;
										if (isNaN(ongkir)) ongkir = 0;
										var totalDiskon =
											parseInt(myTotalDiskon) + parseInt(diskonTambahan);
										$("#total_harga").val(
											parseInt(myTotal - totalDiskon) + parseInt(ongkir)
										);
										if (
											parseInt(myTotal - totalDiskon) + parseInt(ongkir) <
											0
										) {
											$("#total_harga").val(0);
										}
									} else {
										$(".error-data1").html("Stok Tinggal Tersisa " + data);
										$(".flash-data1").html("");
										$("#qty" + i).val("");
										$("#sub_total" + i).val(0);
										$("#jmlkomisi" + i).val(jmlKomisi);
										toast();
									}
								},
							});
						},
					});
				});

				$(".select2jnsproduk" + i).select2({
					placeholder: "Pilih Jenis Produk",
					ajax: {
						url: base_url + "/select2/get_json_jnsproduk",
						type: "post",
						dataType: "json",
						delay: 100,
						data: function (params) {
							return {
								searchTerm: params.term, // search term
								kd_produk: $("#produk" + i).val(),
							};
						},
						processResults: function (response) {
							return {
								results: response,
							};
						},
						cache: true,
					},
				});
				$(".select2jnsproduk" + i).on("select2:select", function (e) {
					var diskon = e.params.data.diskon;
					var harga = e.params.data.harga;
					var komisi = e.params.data.komisi;
					var jmlKomisi = e.params.data.jmlKomisi;
					var maxGroupbarang = $("#jmlbarang").val();

					$.ajax({
						url: base_url + "/product/getProdukById",
						type: "post",
						dataType: "json",
						data: {
							kd_produk: $("#jenis_produk" + i).val(),
						},
						success: function (data) {
							if (data.jns_produk == "po") {
								$.ajax({
									url: base_url + "/product/getDetailProdukPoById",
									type: "post",
									dataType: "json",
									data: {
										kd_produk: $("#jenis_produk" + i).val(),
										tabel: "detail_produk",
									},
									success: function (data) {
										if (data) {
											$("#qty" + i).attr("readonly", false);
											$("#qty" + i).focus();
											$("#diskon" + i).val(diskon);
											$("#diskonn" + i).val(diskon);
											$("#harga_produk" + i).val(harga);
											$("#komisi" + i).val(komisi);
											var hargaProduk = parseInt($("#harga_produk" + i).val());
											var qty = parseInt($("#qty" + i).val());
											if (isNaN(hargaProduk)) hargaProduk = 0;
											if (isNaN(qty)) qty = 0;
											$.ajax({
												url: base_url + "/select2/cekStokProduct",
												type: "post",
												dataType: "json",
												data: {
													kd_detail_produk: $("#jenis_produk" + i).val(),
												},
												success: function (data) {
													var qty = $("#qty" + i).val();
													if (qty == "" || qty == undefined) {
														qty = 0;
													}
													if (
														data >= parseInt(qty) ||
														$("#qty" + i).val() == ""
													) {
														$("#sub_total" + i).val(hargaProduk * qty);
														$("#jmlkomisi" + i).val(
															qty == 0 ? jmlKomisi : jmlKomisi * qty
														);
														$("#jmlkomisii" + i).val(jmlKomisi);
														var data = [];
														var dataDiskon = [];
														for (let j = 1; j <= maxGroupbarang; j++) {
															var obj = {};
															obj = $("#sub_total" + j).val();
															if (obj == undefined || obj == "") {
																obj = 0;
															}
															data.push(obj);
														}
														for (let j = 1; j <= maxGroupbarang; j++) {
															var obj = {};
															obj = $("#diskon" + j).val();
															if (obj == undefined || obj == "") {
																obj = 0;
															}
															dataDiskon.push(obj);
														}
														var myTotal = 0;
														var myTotalDiskon = 0;
														for (var j = 0, len = data.length; j < len; j++) {
															myTotal += parseInt(data[j]);
														}
														for (
															var j = 0, len = dataDiskon.length;
															j < len;
															j++
														) {
															myTotalDiskon += parseInt(dataDiskon[j]);
														}
														if (
															($("#checkboxmember").prop("checked") == true &&
																$("#checkboxalamat").prop("checked") == true) ||
															$("#checkboxalamat").prop("checked") == true
														) {
															ongkir = parseInt($("#ongkir_lain").val());
														} else if (
															$("#checkboxmember").prop("checked") == true
														) {
															ongkir = parseInt($("#ongkir_baru").val());
														} else {
															ongkir = parseInt($("#ongkir_utama").val());
														}
														var diskonTambahan = $("#diskon_tambahan").val();
														if (isNaN(diskonTambahan)) diskonTambahan = 0;
														if (isNaN(ongkir)) ongkir = 0;
														var totalDiskon =
															parseInt(myTotalDiskon) +
															parseInt(diskonTambahan);
														$("#total_harga").val(
															parseInt(myTotal - totalDiskon) + parseInt(ongkir)
														);
														if (
															parseInt(myTotal - totalDiskon) +
																parseInt(ongkir) <
															0
														) {
															$("#total_harga").val(0);
														}
													} else {
														$(".error-data1").html(
															"Stok Tinggal Tersisa " + data
														);
														$(".flash-data1").html("");
														$("#qty" + i).val("");
														$("#sub_total" + i).val(0);
														$("#jmlkomisi" + i).val(jmlKomisi);
														toast();
													}
												},
											});
										} else {
											$("#jenis_produk" + i)
												.val("")
												.trigger("change");
											pesanErrorProdukPO();
										}
									},
								});
							} else if (data.jns_produk == "stock") {
								$("#qty" + i).attr("readonly", false);
								$("#qty" + i).focus();
								$("#diskon" + i).val(diskon);
								$("#diskonn" + i).val(diskon);
								$("#harga_produk" + i).val(harga);
								$("#komisi" + i).val(komisi);
								var hargaProduk = parseInt($("#harga_produk" + i).val());
								var qty = parseInt($("#qty" + i).val());
								if (isNaN(hargaProduk)) hargaProduk = 0;
								if (isNaN(qty)) qty = 0;

								$.ajax({
									url: base_url + "/select2/cekStokProduct",
									type: "post",
									dataType: "json",
									data: {
										kd_detail_produk: $("#jenis_produk" + i).val(),
									},
									success: function (data) {
										var qty = $("#qty" + i).val();
										if (qty == "" || qty == undefined) {
											qty = 0;
										}
										if (data >= parseInt(qty) || $("#qty" + i).val() == "") {
											$("#sub_total" + i).val(hargaProduk * qty);
											$("#jmlkomisi" + i).val(
												qty == 0 ? jmlKomisi : jmlKomisi * qty
											);
											$("#jmlkomisii" + i).val(jmlKomisi);
											var data = [];
											var dataDiskon = [];
											for (let j = 1; j <= maxGroupbarang; j++) {
												var obj = {};
												obj = $("#sub_total" + j).val();
												if (obj == undefined || obj == "") {
													obj = 0;
												}
												data.push(obj);
											}
											for (let j = 1; j <= maxGroupbarang; j++) {
												var obj = {};
												obj = $("#diskon" + j).val();
												if (obj == undefined || obj == "") {
													obj = 0;
												}
												dataDiskon.push(obj);
											}
											var myTotal = 0;
											var myTotalDiskon = 0;
											for (var j = 0, len = data.length; j < len; j++) {
												myTotal += parseInt(data[j]);
											}
											for (var j = 0, len = dataDiskon.length; j < len; j++) {
												myTotalDiskon += parseInt(dataDiskon[j]);
											}
											if (
												($("#checkboxmember").prop("checked") == true &&
													$("#checkboxalamat").prop("checked") == true) ||
												$("#checkboxalamat").prop("checked") == true
											) {
												ongkir = parseInt($("#ongkir_lain").val());
											} else if ($("#checkboxmember").prop("checked") == true) {
												ongkir = parseInt($("#ongkir_baru").val());
											} else {
												ongkir = parseInt($("#ongkir_utama").val());
											}
											var diskonTambahan = $("#diskon_tambahan").val();
											if (isNaN(diskonTambahan)) diskonTambahan = 0;
											if (isNaN(ongkir)) ongkir = 0;
											var totalDiskon =
												parseInt(myTotalDiskon) + parseInt(diskonTambahan);
											$("#total_harga").val(
												parseInt(myTotal - totalDiskon) + parseInt(ongkir)
											);
											if (
												parseInt(myTotal - totalDiskon) + parseInt(ongkir) <
												0
											) {
												$("#total_harga").val(0);
											}
										} else {
											$(".error-data1").html("Stok Tinggal Tersisa " + data);
											$(".flash-data1").html("");
											$("#qty" + i).val("");
											$("#sub_total" + i).val(0);
											$("#jmlkomisi" + i).val(jmlKomisi);
											toast();
										}
									},
								});
							}
						},
					});
				});
			}
		}
	});

	$(".select2daerah").select2({
		placeholder: "Pilih Daerah",
		ajax: {
			url: base_url + "/order/get_json_daerah",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2kota").select2({
		placeholder: "Pilih Kota",
		ajax: {
			url: base_url + "/order/get_json_kota",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$("#select2kecamatan").select2({
		placeholder: "Pilih Kecamatan",
		ajax: {
			url: base_url + "/order/get_json_kecamatan",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					kabupaten: $("#kabupaten").val(),
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2kecamatanedit").select2({
		placeholder: "Pilih Kecamatan",
		ajax: {
			url: base_url + "/order/get_json_kecamatan",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				return {
					kabupaten: $("#kabupaten_edit").val(),
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
	});

	$(".select2multiple-kelurahan").select2({
		placeholder: "Pilih Kelurahan",
		ajax: {
			url: base_url + "/order/get_json_kelurahan",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				var kabupaten = $("#kabupaten").val() ?? $("#kabupaten_edit").val();
				var kecamatan =
					$("#select2kecamatan").val() ?? $("#kecamatan_edit").val();

				return {
					kabupaten: kabupaten,
					kecamatan: kecamatan,
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
		tags: true,
		tokenSeparators: [",", " "],
	});

	$(".select2multiple-sub_kategori").select2({
		placeholder: "Pilih Sub Kategori",
		ajax: {
			url: base_url + "/kategori/get_json_multi_sub_kategori",
			type: "post",
			dataType: "json",
			delay: 100,
			data: function (params) {
				var kategori = $("#kategori").val() ?? $("#kategori_edit").val();
				return {
					kategori: kategori,
					searchTerm: params.term, // search term
				};
			},
			processResults: function (response) {
				return {
					results: response,
				};
			},
			cache: true,
		},
		tags: true,
		tokenSeparators: [",", " "],
	});

	// $(".select2kecamatan").on("select2:select", function (e) {
	// 	var id = e.params.data.id;
	// 	var text = e.params.data.text;
	// 	var jnskecamatan = $("#jnskecamatan").val();

	// 	$("#kecamatan_baru_hid").val(id);

	// 	if (jnskecamatan == "utama") {
	// 		$("#kecamatan_utama").val(text);
	// 		$("#kecamatan_utama_hid").val(id);

	// 		$("#kecamatan_lain").val("");
	// 		$("#kecamatan_lain_hid").val("");
	// 		$("#kecamatan_baru").val("");
	// 		$("#kecamatan_baru_hid").val("");
	// 	} else if (jnskecamatan == "lainnya") {
	// 		$("#kecamatan_lain").val(text);
	// 		$("#kecamatan_lain_hid").val(id);

	// 		$("#kecamatan_utama").val("");
	// 		$("#kecamatan_utama_hid").val("");
	// 		$("#kecamatan_baru").val("");
	// 		$("#kecamatan_baru_hid").val("");
	// 	} else if (jnskecamatan == "baru") {
	// 		$("#kecamatan_baru").val(text);
	// 		$("#kecamatan_baru_hid").val(id);

	// 		$("#kecamatan_utama").val("");
	// 		$("#kecamatan_utama_hid").val("");
	// 		$("#kecamatan_lain").val("");
	// 		$("#kecamatan_lain_hid").val("");
	// 	}
	// });
});
