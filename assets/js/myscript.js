const flashData = $(".flash-data").data("flashdata");
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

$(".tombol-hapus").on("click", function (e) {
	e.preventDefault();
	const href = $(this).attr("href");

	Swal.fire({
		title: "Are you sure?",
		text: "You won't be able to revert this!",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, delete it!",
	}).then((result) => {
		if (result.value) {
			document.location.href = href;
		}
	});
});

$(document).ready(function () {
	// membatasi jumlah inputan
	var maxGroup = $("#jml").val();
	var batas = maxGroup - 1;
	var x = 1;

	var base_url = baseurl();

	$(".tombol-logout").on("click", function (e) {
		e.preventDefault();
		const href = $(this).attr("href");

		Swal.fire({
			title: "Are you sure?",
			text: "",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, Logout!",
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: base_url + "/main/logout",
					type: "post",
					dataType: "json",

					success: function (data) {
						$(".flash-data1").html(data.message);
						$(".error-data1").html("");

						document.location.href = href;
					},
				});
			}
		});
	});

	//melakukan proses multiple input
	$("#tambahfield").click(function () {
		// if($('body').find('#fieldtambah').length < maxGroup){
		if (x < maxGroup) {
			x++;
			var fieldHTML =
				'<div class="form-group" id="fieldawal">' +
				$("#fieldtambah").html() +
				"</div>";
			$("body").find("#fieldawal:last").after(fieldHTML);
		} else {
			$.toast({
				heading: "Warning",
				text: "Hanya Boleh " + batas + " kali menambahkan.",
				showHideTransition: "plain",
				icon: "warning",
				hideAfter: 3000,
				position: "bottom-right",
				bgColor: "#FFC017",
			});
		}
	});

	//remove fields group
	$("body").on("click", "#hapusfield", function () {
		x--;
		$(this).parents("#fieldawal").remove();
	});
	// membatasi jumlah inputan
	var maxGroupbarang = $("#jmlbarang").val();
	var jenis = $("#jenis").val();

	$("#bulan").hide();
	$("#jam").hide();
	$("#perbulan").hide();
	$("#pertahun").hide();

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

	$(document).ready(function () {
		var jml_record = parseInt($("#jml_record").val()) + 1;

		if (jml_record > 0) {
			for (let i = 2; i <= jml_record; i++) {
				$(".select2kategori" + i).select2({
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

				$(".select2kategori" + i).on("select2:select", function (e) {
					var nm_produk_dipilih = $("#nm_produk" + i).html();

					giveCode(nm_produk_dipilih, "kd_kategori", e.params.data.id);
				});

				$(".select2subkategori" + i).select2({
					ajax: {
						url: base_url + "/kategori/get_json_sub",
						type: "post",
						dataType: "json",
						delay: 100,
						data: function (params) {
							return {
								searchTerm: params.term, // search term
								kd_kategori: $("#kd_kategori" + i).val(),
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

				$(".select2subkategori" + i).on("select2:select", function (e) {
					var nm_produk_dipilih = $("#nm_produk" + i).html();

					giveCode(nm_produk_dipilih, "kd_sub_kategori", e.params.data.id);
				});

				$(".select2supplier" + i).select2({
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

				$(".select2supplier" + i).on("select2:select", function (e) {
					var nm_produk_dipilih = $("#nm_produk" + i).html();

					giveCode(nm_produk_dipilih, "kd_supplier", e.params.data.id);
				});

				function giveCode(kode, path, value) {
					var jml_record = parseInt($("#jml_record").val()) + 1;

					for (let i = 2; i <= jml_record; i++) {
						var produkSamaTdkDiinput = $("#enm_produk" + i).val();
						if (produkSamaTdkDiinput == kode) {
							$("#e" + path + i).val(value);
						}
					}
				}
			}
		}
	});

	//melakukan proses multiple input
	$("#tambahfieldbarang").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());
			var jenistransaksi = $("#jenistransaksi").val();

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				var copy =
					'<div class="row mt-2" id="copybarang1"><div class="col-md-5"><select class="form-control select2barpembelian' +
					i +
					'" name="barang[]" id="barang1' +
					i +
					'" style="width: 100%;"><option selected="selected">Pilih Barang</option></select></div><div class="col-md-2"><input type="text" name="harga[]" id="harga' +
					i +
					'" class="form-control" placeholder="Harga" readonly></div><div class="col-md-1"><input type="text" onkeypress="return hanyaAngka(event)" min="0" max="1000" name="qty[]" id="qty' +
					i +
					'" class="form-control cek-qty' +
					i +
					'" placeholder="Qty" readonly></div><div class="col-md-3"><input type="text" name="sub_total[]" id="sub_total' +
					i +
					'" class="form-control" placeholder="Sub Total" readonly></div><div class="col-md-1"><a href="javascript:void(0)" class="btn btn-danger" id="hapusfieldbarang' +
					i +
					'"> <i class="fa fa-minus"></i> </a></div></div>';
				$("#fieldawalbarang").append(copy);

				if (jenistransaksi == "penjualan") {
					$(".select2barpembelian" + i).select2({
						ajax: {
							url: base_url + "/admin/barang/get_json_pri",
							type: "post",
							dataType: "json",
							delay: 100,
							data: function (params) {
								return {
									searchTerm: params.term, // search term
									pilihan: $("#supplier1").val(),
									click: $("#barang").val(),
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
				} else {
					$(".select2barpembelian" + i).select2({
						ajax: {
							url: base_url + "/admin/barang/get_jsonpembelian",
							type: "post",
							dataType: "json",
							delay: 100,
							data: function (params) {
								return {
									searchTerm: params.term, // search term
									pilihan: $("#supplier1").val(),
									click: $("#barang").val(),
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
				}

				$(".select2barpembelian" + i).on("select2:select", function (e) {
					var hargaModal = e.params.data.harga_modal;
					var hargaJual = e.params.data.harga_jual;

					var id = e.params.data.id;

					var kdBarang = id.substr(0, 3);

					var stok = e.params.data.stok;
					var indexPlus = parseInt($("#jmlbarangplus").val());
					var record = $("#jumrecord").val();
					var ceklokasi = $("#ceklokasi").val();
					if (ceklokasi == null) {
						if (stok == 0) {
							Toast.fire({
								icon: "error",
								title: "Stok Barang Kosong",
							});

							$("#qty" + i).val(null);
							$("#qty" + i).attr("readonly", true);
							$("#harga" + i).val(null);
							$("#sub_total" + i).val(null);
						} else {
							if (kdBarang == "BPR") {
								$("#qty" + i).val(1);
								$("#qty" + i).attr("readonly", false);
								$("#harga" + i).attr("readonly", true);

								$("#harga" + i).val(hargaModal);
								$("#sub_total" + i).val(hargaModal);
							} else if (kdBarang == "BSC") {
								$("#qty" + i).val(1);
								$("#qty" + i).attr("readonly", false);
								$("#harga" + i).attr("readonly", false);

								$("#harga" + i).val("");
								$("#sub_total" + i).val(0);
							}
						}
					} else {
						if (kdBarang == "BPR") {
							$("#qty" + i).val(1);
							$("#qty" + i).attr("readonly", false);
							$("#harga" + i).attr("readonly", true);

							$("#harga" + i).val(hargaModal);
							$("#sub_total" + i).val(hargaModal);
						} else if (kdBarang == "BSC") {
							$("#qty" + i).val(1);
							$("#qty" + i).attr("readonly", false);
							$("#harga" + i).attr("readonly", false);

							$("#harga" + i).val("");
							$("#sub_total" + i).val(0);
						}
					}
					var subTotal = $("#sub_total").val();
					var data = [];
					var data1 = [];

					for (let j = 2; j <= indexPlus; j++) {
						var obj = {};
						obj = $("#sub_total" + j).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						data.push(obj);
					}

					for (let i = 1; i <= record; i++) {
						var obj = {};
						obj = $("#esub_total" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						data1.push(obj);
					}

					var myTotal = 0;
					var myTotal1 = 0;
					for (var j = 0, len = data.length; j < len; j++) {
						myTotal += parseInt(data[j]);
					}
					for (var j = 0, len = data1.length; j < len; j++) {
						myTotal1 += parseInt(data1[j]);
					}

					var totalHarga = parseInt(myTotal) + parseInt(subTotal);
					$("#total_harga").val("Rp. " + totalHarga.toString());
					var totalHarga = parseInt(myTotal) + parseInt(myTotal1);
					$("#etotal_harga").val("Rp. " + totalHarga.toString());
				});

				$(".select2barn" + i).select2({
					ajax: {
						url: base_url + "/admin/barang/get_json",
						type: "post",
						dataType: "json",
						delay: 100,
						data: function (params) {
							return {
								searchTerm: params.term, // search term
								pilihan: $("#supplier1").val(),
								click: $("#barang").val(),
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

				$(".select2barn" + i).on("select2:select", function (e) {
					var hargaModal = e.params.data.harga_modal;
					var hargaJual = e.params.data.harga_jual;
					var stok = e.params.data.stok;
					var indexPlus = parseInt($("#jmlbarangplus").val());
					var record = $("#jumrecord").val();
					var ceklokasi = $("#ceklokasi").val();
					if (ceklokasi == null) {
						if (stok == 0) {
							Toast.fire({
								icon: "error",
								title: "Stok Barang Kosong",
							});

							$("#qty" + i).val(null);
							$("#qty" + i).attr("readonly", true);
							$("#harga" + i).val(null);
							$("#sub_total" + i).val(null);
						} else {
							$("#qty" + i).val(1);
							$("#qty" + i).attr("readonly", false);
							if (jenis == "modal") {
								$("#harga" + i).val(hargaModal);
								$("#sub_total" + i).val(hargaModal);
							} else if (jenis == "jual") {
								$("#harga" + i).val(hargaJual);
								$("#sub_total" + i).val(hargaJual);
							}
						}
					} else {
						$("#qty" + i).val(1);
						$("#qty" + i).attr("readonly", false);
						if (jenis == "modal") {
							$("#harga" + i).val(hargaModal);
							$("#sub_total" + i).val(hargaModal);
						} else if (jenis == "jual") {
							$("#harga" + i).val(hargaJual);
							$("#sub_total" + i).val(hargaJual);
						}
					}
					var subTotal = $("#sub_total").val();
					var data = [];
					var data1 = [];

					for (let j = 2; j <= indexPlus; j++) {
						var obj = {};
						obj = $("#sub_total" + j).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						data.push(obj);
					}

					for (let i = 1; i <= record; i++) {
						var obj = {};
						obj = $("#esub_total" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						data1.push(obj);
					}

					var myTotal = 0;
					var myTotal1 = 0;
					for (var j = 0, len = data.length; j < len; j++) {
						myTotal += parseInt(data[j]);
					}
					for (var j = 0, len = data1.length; j < len; j++) {
						myTotal1 += parseInt(data1[j]);
					}

					if (subTotal == "") {
						subTotal = 0;
					}

					var totalHarga = parseInt(myTotal) + parseInt(subTotal);
					$("#total_harga").val("Rp. " + totalHarga.toString());
					var totalHarga = parseInt(myTotal) + parseInt(myTotal1);
					$("#etotal_harga").val("Rp. " + totalHarga.toString());
				});

				$(".cek-qty" + i).on("change", function () {
					var cek = $("#barang" + i).val();
					var cek1 = $("#barang1" + i).val();
					var aksi = $("#aksi").val();
					var ceklokasi = $("#ceklokasi").val();
					if (ceklokasi == null) {
						if (aksi == "penjualan") {
							if (cek1 != null) {
								var barang = $("#barang1" + i).val();
							} else {
								var barang = $("#barang" + i).val();
							}
							var qty = $("#qty" + i).val();
							if (cek != null || cek1 != null) {
								$.ajax({
									url: base_url + "/admin/barang/getBarangById",
									type: "post",
									dataType: "json",
									data: {
										id: barang,
										qty: qty,
										tabel: "primary",
									},
									success: function (result) {
										if (result.no == 0) {
											Toast.fire({
												icon: "error",
												title: "Stok Hanya Tersisa " + result.qty,
											});
											$("#qty" + i).val(null);
										}
									},
								});
							}
						} else {
							if (cek1 != null) {
								var barang = $("#barang1" + i).val();
							} else {
								var barang = $("#barang" + i).val();
							}
							var qty = $("#qty" + i).val();
							if (cek != null || cek1 != null) {
								$.ajax({
									url: base_url + "/admin/barang/getBarangById",
									type: "post",
									dataType: "json",
									data: {
										id: barang,
										qty: qty,
										tabel: "primary",
									},
									success: function (result) {
										if (result.no == 0) {
											Toast.fire({
												icon: "error",
												title: "Stok Hanya Tersisa " + result.qty,
											});
											$("#qty" + i).val(null);
											$("#sub_total" + i).val(null);
										}
									},
								});
							}
						}
					}
				});

				$("#harga" + i).keyup(function () {
					var harga = parseInt($("#harga" + i).val());
					var qty = $("#qty" + i).val();
					var total = harga * parseInt(qty);
					var indexPlus = parseInt($("#jmlbarangplus").val());
					var record = $("#jumrecord").val();
					if (!isNaN(total)) {
						$("#sub_total" + i).val(total);
					}

					var subTotal = $("#sub_total").val();

					var data = [];
					var data1 = [];

					if (qty == "") {
						$("#sub_total" + i).val(parseInt(0));
					}

					if ($("#harga" + i).val() == "") {
						$("#sub_total" + i).val(0);
					}

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#sub_total" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						data.push(obj);
					}

					var myTotal = 0;
					for (let i = 1; i <= record; i++) {
						var obj = {};
						obj = $("#esub_total" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						data1.push(obj);
					}

					var myTotal = 0;
					var myTotal1 = 0;

					for (var a = 0, len = data.length; a < len; a++) {
						myTotal += parseInt(data[a]);
					}
					var totalHarga = parseInt(myTotal) + parseInt(subTotal);
					$("#total_harga").val("Rp. " + totalHarga.toString());

					for (var a = 0, len = data1.length; a < len; a++) {
						myTotal1 += parseInt(data1[a]);
					}
					var totalHarga = parseInt(myTotal) + parseInt(subTotal);
					$("#total_harga").val("Rp. " + totalHarga.toString());
					var totalHarga = parseInt(myTotal) + parseInt(myTotal1);
					$("#etotal_harga").val("Rp. " + totalHarga.toString());
				});

				$("#qty" + i).keyup(function () {
					var harga = parseInt($("#harga" + i).val());
					var qty = $("#qty" + i).val();
					var total = harga * parseInt(qty);
					var indexPlus = parseInt($("#jmlbarangplus").val());
					var record = $("#jumrecord").val();
					if (!isNaN(total)) {
						$("#sub_total" + i).val(total);
					}

					var subTotal = $("#sub_total").val();

					var data = [];
					var data1 = [];

					if (qty == "") {
						$("#sub_total" + i).val(parseInt(0));
					}

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#sub_total" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						data.push(obj);
					}

					var myTotal = 0;
					for (let i = 1; i <= record; i++) {
						var obj = {};
						obj = $("#esub_total" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						data1.push(obj);
					}

					var myTotal = 0;
					var myTotal1 = 0;

					for (var a = 0, len = data.length; a < len; a++) {
						myTotal += parseInt(data[a]);
					}
					var totalHarga = parseInt(myTotal) + parseInt(subTotal);
					$("#total_harga").val("Rp. " + totalHarga.toString());

					for (var a = 0, len = data1.length; a < len; a++) {
						myTotal1 += parseInt(data1[a]);
					}

					if (subTotal == "") {
						subTotal = 0;
					}

					var totalHarga = parseInt(myTotal) + parseInt(subTotal);
					$("#total_harga").val("Rp. " + totalHarga.toString());
					var totalHarga = parseInt(myTotal) + parseInt(myTotal1);
					$("#etotal_harga").val("Rp. " + totalHarga.toString());
				});

				$("#hapusfieldbarang" + i).click(function () {
					var subTotal = $("#sub_total" + i).val();
					var totHarga = $("#total_harga").val();
					if (totHarga != undefined) {
						var totalHarga = totHarga.replace("Rp. ", "");

						if (subTotal == "" || subTotal == undefined) {
							subTotal = 0;
						}

						var selisih = parseInt(totalHarga) - parseInt(subTotal);
						$("#total_harga").val("Rp. " + selisih.toString());
					} else {
						$("#jumrecord").val(parseInt($("#jumrecord").val()) - 1);
					}

					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);
					$("#jmlbarangminus").val(parseInt($("#jmlbarangminus").val()) - 1);
					$(this).parents("#copybarang1").remove();
				});

				// i = indexMinus;
			}
		} else {
			Toast.fire({
				icon: "error",
				title: "Tidak Bisa Menambah Lagi.",
			});
		}
	});

	$("body").on("click", "#deletefieldbarang", function () {
		x--;
		$(this).parents("#form-repeat").remove();
	});

	// membatasi jumlah inputan
	// membatasi jumlah inputan
	var maxGroupbarang = $("#jmlbarang").val();
	var jenis = $("#jenis").val();

	// proses multiple input produk masuk
	$("#tambahfieldprodukmasuk").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				$(document).ready(function () {
					$(".rupiah-mask" + i).inputmask({
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

					$(".input-rupiah-mask" + i).inputmask({
						alias: "numeric",
						groupSeparator: ",",
						autoGroup: true,
						digits: 0,
						digitsOptional: false,
						prefix: "Rp ",
						placeholder: "0",
						rightAlign: false,
						autoUnmask: true,
						removeMaskOnSubmit: true,
					});

					$("#datepickersingle" + i).daterangepicker(
						{
							singleDatePicker: true,
							showDropdowns: true,
							minYear: 1901,
							locale: {
								format: "YYYY-MM-DD",
							},
							maxYear: parseInt(moment().format("YYYY"), 10),
						},
						function (start, end, label) {
							var years = moment().diff(start, "years");
						}
					);
				});

				$("#bagianProdukMasuk").append(
					'<div id="bagianProdukhapus' +
						i +
						'"><hr id="hr"><div class="form-group row" id="detailProduk' +
						i +
						'"><div class="col-3 col-sm-3 col-md-3 mt-2" id="produkk"><label for="produk1">Nama Menu</label><select class="form-control select2produksup' +
						i +
						'" name="produk[]" id="produk' +
						i +
						'" style="width: 100%;" required><option value="">Pilih Produk</option></select></div><div class="col-3 col-sm-3 col-md-2 mt-2"><div class="form-group"><label for="jml_ukuran">Harga Modal <small>Per Pcs</small></label><input type="text" class="form-control" name="harga_modal[]" id="harga_modal' +
						i +
						'" placeholder="Masukan Harga Modal" required></div></div><div class="col-3 col-sm-3 col-md-2 mt-2"><div class="form-group"><label for="harga_produk">Harga Menu <small>Per Pcs</small></label><input type="text" class="form-control" name="harga_produk[]" id="harga_produk' +
						i +
						'" placeholder="Masukan Harga Menu" required></div></div><div class="col-3 col-sm-3 col-md-2 mt-2"><div class="form-group"><label for="jml_ukuran">Ujroh Reseller <small>Per Pcs</small></label><input type="text" class="form-control" name="ujroh_reseller[]" id="ujroh_reseller' +
						i +
						'" placeholder="Masukan Ujroh Reseller" required></div></div><div class="col-3 col-sm-3 col-md-2 mt-2"><div class="form-group"><label>Stok Masuk</label><input type="number" name="stok_masuk[]" id="stok_masuk" class="form-control" min="1" max="1000" placeholder="Stok Masuk" required></div></div><div class="col-md-1 col-1 col-sm-1"><label></label><br><a href="javascript:void(0)" class="btn btn-danger mt-3 btn-block" id="hapusfieldprodukmasuk' +
						i +
						'" required><i class="fa fa-minus"></i> </a></div></div></div>'
				);

				$("#modal-detail").append(
					'<div id="modall-detail' +
						i +
						'"><div class="modal fade" id="setperhitunganharga' +
						i +
						'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog modal-xl"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">Kalkulasi Detail Harga</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="row"><div class="col-md-4"><label for="hrg_modal1">Harga Modal</label><input type="text" name="hrg_modal[]" id="hrg_modal' +
						i +
						'" class="form-control" placeholder="Masukan Harga Modal" readonly></div><div class="col-md-4"><label for="biaya_lainnya1">Biaya Lainnya</label><input type="text" name="biaya_lainnya[]" id="biaya_lainnya' +
						i +
						'" class="form-control" placeholder="Masukan Biaya Lainnya"></div><div class="col-md-4"><label for="ttl_hrg_modal1">Total Harga Modal</label><input type="text" name="ttl_hrg_modal[]" id="ttl_hrg_modal" class="form-control" placeholder="Masukan Harga Modal" readonly></div></div><div class="row"><div class="col-md-3"><label for="margin1">Margin Produk</label><input type="text" name="margin[]" id="margin' +
						i +
						'" class="form-control" placeholder="Masukan Margin dalam Persen"></div><div class="col-md-3"><label for="hasil_margin1">Hasil Margin</label><input type="text" name="hasil_margin[]" id="hasil_margin' +
						i +
						'" class="form-control" placeholder="Masukan Biaya Lainnya" readonly></div><div class="col-md-3"><label for="harga_jual1">Harga Jual</label><input type="text" name="harga_jual[]" id="harga_jual" class="form-control" placeholder="Masukan Harga Modal" readonly></div><div class="col-md-3"><label for="harga_jual1">Harga Jual(Pembulatan)</label><input type="text" name="pembulatan_harga_jual[]" id="pembulatan_harga_jual" class="form-control" placeholder="Masukan Harga Modal" readonly></div></div><div class="row"><div class="col-md-6"><label for="harga_competitor1">Harga Kompetitor</label><input type="text" name="harga_competitor[]" id="harga_competitor' +
						i +
						'" class="form-control" placeholder="Masukan Biaya Lainnya"></div><div class="col-md-6"><label for="selisih_harga1">Selisih Harga</label><input type="text" name="selisih_harga[]" id="selisih_harga' +
						i +
						'" class="form-control" placeholder="Masukan Harga Modal" readonly></div></div><div class="row"><div class="col-md-4"><label for="margin1001">Margin 100%</label><input type="text" name="margin100[]" id="margin100' +
						i +
						'" class="form-control" placeholder="Masukan Margin"></div><div class="col-md-4"><label for="margin701">Margin 70% Selera</label><input type="text" name="margin70[]" id="margin70' +
						i +
						'" class="form-control" placeholder="Masukan Biaya Lainnya"></div><div class="col-md-4"><label for="margin301">Margin 30% Reseller</label><input type="text" name="margin30[]" id="margin30' +
						i +
						'" class="form-control" placeholder="Masukan Harga Modal"></div></div><div class="row"><div class="col-md-2"><label for="insentif1">Insentif 6%</label><input type="text" name="insentif[]" id="insentif' +
						i +
						'" class="form-control" placeholder="Masukan Margin" readonly></div><div class="col-md-2"><label for="hasil_insentif1">Hasil Harga Insentif</label><input type="text" name="hasil_insentif[]" id="hasil_insentif' +
						i +
						'" class="form-control" placeholder="Masukan Harga Modal" readonly></div><div class="col-md-3"><label for="harga_jual_reseller1">Harga Jual Reseller (Pembulatan)</label><input type="text" name="harga_jual_reseller[]" id="harga_jual_reseller' +
						i +
						'" class="form-control" placeholder="Masukan Biaya Lainnya"></div><div class="col-md-3"><label for="selisih_harga_jual1">Selisih Harga Jual</label><input type="text" name="selisih_harga_jual[]" id="selisih_harga_jual" class="form-control" placeholder="Masukan Biaya Lainnya" readonly></div><div class="col-md-2"><label for="kelebihan_bagi_hasil1">Kelebihan Margin Ujroh</label><input type="text" name="kelebihan_bagi_hasil[]" id="kelebihan_bagi_hasil" class="form-control" placeholder="Masukan Harga Modal" readonly></div></div><div class="row"><div class="col-md-4"><label for="hrg_competitor1">Harga Kompetitor</label><input type="text" name="hrg_competitor[]" id="hrg_competitor' +
						i +
						'" class="form-control" placeholder="Masukan Margin" readonly></div><div class="col-md-4"><label for="hrg_jual_umum1">Harga Jual Umum</label><input type="text" name="hrg_jual_umum[]" id="hrg_jual_umum' +
						i +
						'" class="form-control" placeholder="Masukan Biaya Lainnya" readonly></div><div class="col-md-4"><label for="hrg_jual_reseller1">Harga Jual Reseller</label><input type="text" name="hrg_jual_reseller[]" id="hrg_jual_reseller' +
						i +
						'" class="form-control" placeholder="Masukan Harga Modal" readonly></div></div></div><div class="modal-footer"><button type="button"  data-dismiss="modal" class="btn btn-primary">Save changes</button></div></div></div></div></div>'
				);

				$(".select2supplier" + i).select2({
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

				$(".select2produksup" + i).select2({
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

				$(".select2produksup" + i).on("select2:select", function (e) {
					var id = e.params.data.id;

					$.ajax({
						url: base_url + "/Product/getdetailprodukcalc",
						type: "post",
						dataType: "json",
						data: {
							kd_detail: id,
						},
						success: function (data) {
							$("#harga_modal" + i).val(data.harga_modal);
							$("#harga_produk" + i).val(data.harga_produk);
							$("#ujroh_reseller" + i).val(data.margin_reseller);
							$("#biaya_lainnya" + i).val(data.biaya_lainnya);
							$("#total_modal" + i).val(data.total_modal);
							$("#margin" + i).val(data.margin_produk);
							$("#hasil_margin" + i).val(data.hasil_margin);
							$("#harga_jual" + i).val(data.harga_jual);
							$("#pembulatan_harga_jual" + i).val(data.pembulatan_harga_jual);
							$("#harga_competitor" + i).val(data.harga_kompetitor);
							$("#selisih_harga" + i).val(data.selisih_harga);
							$("#margin100" + i).val(data.margin_keseluruhan);
							$("#margin70" + i).val(data.margin_selera);
							$("#margin30" + i).val(data.margin_reseller);
							$("#insentif" + i).val(data.insentif);
							$("#hasil_insentif" + i).val(data.hasil_harga_insentif);
							$("#harga_jual_reseller" + i).val(data.pembulatan_harga_reseller);
							$("#selisih_harga_jual" + i).val(data.selisih_harga_jual);
							$("#kelebihan_bagi_hasil" + i).val(data.kelebihan_margin_ujroh);
							$("#hrg_competitor" + i).val(data.harga_kompetitor);
							$("#hrg_jual_umum" + i).val(data.pembulatan_harga_jual);
							$("#hrg_jual_reseller" + i).val(data.pembulatan_harga_reseller);
						},
					});
				});

				$("#ujroh_reseller" + i).on("keyup", function () {
					var ujroh = $(this).val();

					var margin100 = $("#margin100" + i).val();
					var margin70 = $("#margin70" + i).val();
					var margin30 = $("#margin30" + i).val();

					if (margin100 == "" || margin100 == null) {
						Toast.fire({
							icon: "error",
							title: "Harap Memilih produk terlebih dahulu.",
						});
						$("#ujroh_reseller" + i).val(0);
					} else {
						if (parseInt(ujroh) > parseInt(margin100)) {
							$(".error-data1").html(
								"Maaf ujroh tidak bisa lebih dari Rp." + margin100
							);
							$(".flash-data1").html("");
							toast();
							$("#ujroh_reseller" + i).val(0);
						} else {
							var ujroh_selera = margin100 - ujroh;
							$("#margin30" + i).val(ujroh);
							$("#margin70" + i).val(ujroh_selera);
						}
					}
				});

				$("#checkboxbayarnanti" + i).click(function () {
					if ($(this).prop("checked") == true) {
						$(".bagian-pembayaran" + i).hide(500);
						$("#metode_pembayaran" + i).attr("required", false);
					} else {
						$(".bagian-pembayaran" + i).show(500);
						$("#metode_pembayaran" + i).attr("required", true);
					}
				});

				$("#metode_pembayaran" + i).change(function () {
					var val = $(this).val();

					if (val == "transfer") {
						$("#bagian-metode-pembayaran" + i).removeClass(
							"col-11 col-sm-11 col-md-11"
						);
						$("#bagian-metode-pembayaran" + i).addClass(
							"col-6 col-sm-6 col-md-6"
						);
						$(".bagian-bukti-pembayaran" + i).show(500);
					} else {
						$(".bagian-bukti-pembayaran" + i).hide();
						$("#bagian-metode-pembayaran" + i).removeClass(
							"col-6 col-sm-6 col-md-6"
						);
						$("#bagian-metode-pembayaran" + i).addClass(
							"col-11 col-sm-11 col-md-11"
						);
					}
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
								kd_produk: $("#produk1" + i).val(),
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

				$("#biaya_lainnya" + i).keyup(function () {
					$.ajax({
						url: base_url + "/konfigurasi/getKonfigurasi",
						type: "post",
						dataType: "json",
						success: function (data) {
							var hargaModal = parseInt($("#hrg_modal" + i).val());
							var biayaLainnya = parseInt($("#biaya_lainnya" + i).val());
							var hargaCompetitor = parseInt($("#harga_competitor" + i).val());

							if (isNaN(hargaCompetitor)) hargaCompetitor = 0;

							if (isNaN(hargaModal)) hargaModal = 0;
							if (isNaN(biayaLainnya)) biayaLainnya = 0;

							$("#ttl_hrg_modal" + i).val(hargaModal + biayaLainnya);

							var margin = parseInt($("#margin" + i).val());
							var ttlHargaModal = parseInt($("#ttl_hrg_modal" + i).val());

							if (isNaN(margin)) margin = 0;
							if (isNaN(ttlHargaModal)) ttlHargaModal = 0;

							$("#hasil_margin" + i).val((ttlHargaModal * margin) / 100);

							var hasilMargin = parseInt($("#hasil_margin" + i).val());
							if (isNaN(hasilMargin)) hasilMargin = 0;

							var hrgJual = ttlHargaModal + hasilMargin;

							var bagi = Math.round(hrgJual / 1000);
							var hargaJual = bagi * 1000;
							var margin30 = (hasilMargin * data.ujroh_reseller) / 100;

							$("#harga_produk" + i).attr("readonly", false);

							$("#harga_jual" + i).val(margin != 0 ? hrgJual : 0);
							$("#pembulatan_harga_jual" + i).val(margin != 0 ? hargaJual : 0);
							$("#harga_produk" + i).val(margin != 0 ? hargaJual : 0);
							$("#selisih_harga" + i).val(
								hargaCompetitor - (hargaModal + hasilMargin)
							);

							$("#margin100" + i).val(hasilMargin);
							$("#margin70" + i).val((hasilMargin * data.ujroh_selera) / 100);
							$("#margin30" + i).val(margin30);

							var pembulatanHarga = parseInt(
								$("#pembulatan_harga_jual" + i).val()
							);
							if (isNaN(pembulatanHarga)) pembulatanHarga = 0;

							var insentif = (pembulatanHarga * 6) / 100;
							var hasilInsentif = pembulatanHarga - insentif;

							$("#insentif" + i).val(insentif);
							$("#hasil_insentif" + i).val(hasilInsentif);

							var a = Math.round(hasilInsentif / 1000);
							var pembulatanHslInsentif = Math.round(a * 1000);
							$("#harga_jual_reseller" + i).val(pembulatanHslInsentif);

							var hargaJualReseller = $("#harga_jual_reseller" + i).val();

							if (isNaN(hargaJualReseller)) hargaJualReseller = 0;

							$("#selisih_harga_jual" + i).val(
								pembulatanHarga - hargaJualReseller
							);
							var selisih = $("#selisih_harga_jual" + i).val();

							$("#kelebihan_bagi_hasil" + i).val(margin30 - selisih);
							$("#hrg_competitor" + i).val(hargaCompetitor);
							$("#hrg_jual_umum" + i).val(
								parseInt($("#pembulatan_harga_jual" + i).val())
							);
							$("#hrg_jual_reseller" + i).val(hargaJualReseller);
						},
					});
				});

				$("#margin" + i).keyup(function () {
					$.ajax({
						url: base_url + "/konfigurasi/getKonfigurasi",
						type: "post",
						dataType: "json",
						success: function (data) {
							var ttlHargaModal = parseInt($("#ttl_hrg_modal" + i).val());
							var margin = $("#margin" + i).val();
							var hargaCompetitor = parseInt($("#harga_competitor" + i).val());
							var hargaModal = parseInt($("#hrg_modal" + i).val());

							if (isNaN(hargaModal)) hargaModal = 0;
							if (isNaN(hargaCompetitor)) hargaCompetitor = 0;

							if (isNaN(ttlHargaModal)) ttlHargaModal = 0;
							if (isNaN(margin)) margin = 0;

							var hasilMargin = (ttlHargaModal * margin) / 100;

							var hrgJual = ttlHargaModal + hasilMargin;

							var bagi = Math.round(hrgJual / 1000);
							var hargaJual = bagi * 1000;

							$("#harga_produk" + i).attr("readonly", false);

							$("#hasil_margin" + i).val(hasilMargin);
							$("#harga_jual" + i).val(hrgJual);
							$("#pembulatan_harga_jual" + i).val(hargaJual);
							$("#harga_produk" + i).val(hargaJual);

							var hasilMargin = parseInt($("#hasil_margin" + i).val());
							if (isNaN(hasilMargin)) hasilMargin = 0;

							var hrgJual = ttlHargaModal + hasilMargin;

							var bagi = Math.round(hrgJual / 1000);
							var hargaJual = bagi * 1000;
							var margin30 = (hasilMargin * data.ujroh_reseller) / 100;

							$("#harga_jual" + i).val(margin != 0 ? hrgJual : 0);
							$("#pembulatan_harga_jual" + i).val(margin != 0 ? hargaJual : 0);
							$("#harga_produk" + i).val(margin != 0 ? hargaJual : 0);
							$("#selisih_harga" + i).val(
								hargaCompetitor - (hargaModal + hasilMargin)
							);

							$("#margin100" + i).val(hasilMargin);
							$("#margin70" + i).val((hasilMargin * data.ujroh_selera) / 100);
							$("#margin30" + i).val(margin30);

							var pembulatanHarga = parseInt(
								$("#pembulatan_harga_jual" + i).val()
							);
							if (isNaN(pembulatanHarga)) pembulatanHarga = 0;

							var insentif = (pembulatanHarga * 6) / 100;
							var hasilInsentif = pembulatanHarga - insentif;

							$("#insentif" + i).val(insentif);
							$("#hasil_insentif" + i).val(hasilInsentif);

							var a = Math.round(hasilInsentif / 1000);
							var pembulatanHslInsentif = Math.round(a * 1000);
							$("#harga_jual_reseller" + i).val(pembulatanHslInsentif);

							var hargaJualReseller = $("#harga_jual_reseller" + i).val();

							if (isNaN(hargaJualReseller)) hargaJualReseller = 0;

							$("#selisih_harga_jual" + i).val(
								pembulatanHarga - hargaJualReseller
							);
							var selisih = $("#selisih_harga_jual" + i).val();

							$("#kelebihan_bagi_hasil" + i).val(margin30 - selisih);
							$("#hrg_competitor" + i).val(hargaCompetitor);
							$("#hrg_jual_umum" + i).val(
								parseInt($("#pembulatan_harga_jual" + i).val())
							);
							$("#hrg_jual_reseller" + i).val(hargaJualReseller);
						},
					});
				});

				$("#harga_competitor" + i).keyup(function () {
					var hargaCompetitor = parseInt($("#harga_competitor" + i).val());
					var pembulatanHarga = parseInt($("#pembulatan_harga_jual" + i).val());
					var hargaJual = parseInt($("#harga_jual" + i).val());
					var ttlHargaModal = parseInt($("#ttl_hrg_modal" + i).val());
					var margin30 = parseInt($("#margin30" + i).val());

					if (isNaN(margin30)) margin30 = 0;
					if (isNaN(hargaCompetitor)) hargaCompetitor = 0;
					if (isNaN(pembulatanHarga)) pembulatanHarga = 0;
					if (isNaN(hargaJual)) hargaJual = 0;
					if (isNaN(ttlHargaModal)) ttlHargaModal = 0;

					$("#selisih_harga" + i).val(hargaCompetitor - pembulatanHarga);
					var margin100 = hargaJual - ttlHargaModal;
					$("#margin100" + i).val(margin100);
					$("#margin70" + i).val((margin100 * data.ujroh_selera) / 100);
					$("#margin30" + i).val((margin100 * data.ujroh_reseller) / 100);

					var insentif = (pembulatanHarga * 6) / 100;
					var hasilInsentif = pembulatanHarga - insentif;

					$("#insentif" + i).val(insentif);
					$("#hasil_insentif" + i).val(hasilInsentif);

					var a = Math.round(hasilInsentif / 1000);
					var pembulatanHslInsentif = Math.round(a * 1000);
					$("#harga_jual_reseller" + i).val(pembulatanHslInsentif);

					var hargaJualReseller = $("#harga_jual_reseller" + i).val();

					if (isNaN(hargaJualReseller)) hargaJualReseller = 0;

					$("#selisih_harga_jual" + i).val(pembulatanHarga - hargaJualReseller);
					var selisih = $("#selisih_harga_jual" + i).val();

					$("#kelebihan_bagi_hasil" + i).val(margin30 - selisih);
					$("#hrg_competitor" + i).val(hargaCompetitor);
					$("#hrg_jual_umum" + i).val(pembulatanHarga);
					$("#hrg_jual_reseller" + i).val(hargaJualReseller);
				});

				$("body").on("click", "#hapusfieldprodukmasuk" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					$(this)
						.parents("#bagianProdukhapus" + i)
						.remove();
				});
			}
		}
	});
	// end proses multiple input produk masuk

	//melakukan proses multiple input
	$("#tambahfieldpenyewaan").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				var d = new Date();
				var tahun = d.getFullYear();

				$(".rupiah-mask" + i).inputmask({
					alias: "numeric",
					groupSeparator: ",",
					autoGroup: true,
					digits: 0,
					digitsOptional: false,
					prefix: "Rp ",
					placeholder: "-1",
					rightAlign: false,
					autoUnmask: true,
					removeMaskOnSubmit: false,
				});

				$(".input-rupiah-mask" + i).inputmask({
					alias: "numeric",
					groupSeparator: ",",
					autoGroup: true,
					digits: 0,
					digitsOptional: false,
					prefix: "Rp ",
					placeholder: "0",
					rightAlign: false,
					autoUnmask: true,
					removeMaskOnSubmit: false,
				});

				var copy =
					'<div id="modall-detail' +
					i +
					'"><div class="modal fade" id="setperhitunganharga' +
					i +
					'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog modal-xl"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">Kalkulasi Detail Harga</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="row"><div class="col-md-4"><label for="hrg_modal1">Harga Modal</label><input type="text" name="hrg_modal[]" id="hrg_modal' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Harga Modal" readonly></div><div class="col-md-4"><label for="biaya_lainnya1">Biaya Lainnya</label><input type="text" name="biaya_lainnya[]" id="biaya_lainnya' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Biaya Lainnya"></div><div class="col-md-4"><label for="ttl_hrg_modal1">Total Harga Modal</label><input type="text" name="ttl_hrg_modal[]" id="ttl_hrg_modal' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Harga Modal" readonly></div></div><div class="row"><div class="col-md-3"><label for="margin1">Margin Produk</label><input type="text" name="margin[]" id="margin' +
					i +
					'" class="form-control" placeholder="Masukan Margin dalam Persen"></div><div class="col-md-3"><label for="hasil_margin1">Hasil Margin</label><input type="text" name="hasil_margin[]" id="hasil_margin' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Biaya Lainnya" readonly></div><div class="col-md-3"><label for="harga_jual1">Harga Jual</label><input type="text" name="harga_jual[]" id="harga_jual' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Harga Modal" readonly></div><div class="col-md-3"><label for="harga_jual1">Harga Jual(Pembulatan)</label><input type="text" name="pembulatan_harga_jual[]" id="pembulatan_harga_jual' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Harga Modal" readonly></div></div><div class="row"><div class="col-md-6"><label for="harga_competitor1">Harga Kompetitor</label><input type="text" name="harga_competitor[]" id="harga_competitor' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Biaya Lainnya"></div><div class="col-md-6"><label for="selisih_harga1">Selisih Harga</label><input type="text" name="selisih_harga[]" id="selisih_harga' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Harga Modal" readonly></div></div><div class="row"><div class="col-md-4"><label for="margin1001">Margin 100%</label><input type="text" name="margin100[]" id="margin100' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Margin 100%"></div><div class="col-md-4"><label for="margin701">Margin <span id="persentaseselera' +
					i +
					'">70</span>% Selera</label><input type="text" name="margin70[]" id="margin70' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Margin Selera"></div><div class="col-md-4"><label for="margin301">Margin <span id="persentasereseller' +
					i +
					'">70</span>% Reseller</label><input type="text" name="margin30[]" id="margin30' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Margin Reseller"></div></div><div class="row"><div class="col-md-2"><label for="insentif1">Insentif 6%</label><input type="text" name="insentif[]" id="insentif' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Margin" readonly></div><div class="col-md-2"><label for="hasil_insentif1">Hasil Harga Insentif</label><input type="text" name="hasil_insentif[]" id="hasil_insentif' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Harga Modal" readonly></div><div class="col-md-3"><label for="harga_jual_reseller1">Harga Jual Reseller (Pembulatan)</label><input type="text" name="harga_jual_reseller[]" id="harga_jual_reseller' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Harga Jual Reseller"></div><div class="col-md-3"><label for="selisih_harga_jual1">Selisih Harga Jual</label><input type="text" name="selisih_harga_jual[]" id="selisih_harga_jual' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Biaya Lainnya" readonly></div><div class="col-md-2"><label for="kelebihan_bagi_hasil1">Kelebihan Margin Ujroh</label><input type="text" name="kelebihan_bagi_hasil[]" id="kelebihan_bagi_hasil' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Harga Modal" readonly></div></div><div class="row"><div class="col-md-4"><label for="hrg_competitor1">Harga Kompetitor</label><input type="text" name="hrg_competitor[]" id="hrg_competitor' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Margin" readonly></div><div class="col-md-4"><label for="hrg_jual_umum1">Harga Jual Umum</label><input type="text" name="hrg_jual_umum[]" id="hrg_jual_umum' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Biaya Lainnya" readonly></div><div class="col-md-4"><label for="hrg_jual_reseller1">Harga Jual Reseller</label><input type="text" name="hrg_jual_reseller[]" id="hrg_jual_reseller' +
					i +
					'" class="form-control ' +
					i +
					'" placeholder="Masukan Harga Modal" readonly></div></div></div><div class="modal-footer"><button type="button"  data-dismiss="modal" class="btn btn-primary">Save changes</button></div></div></div></div></div>';

				$("#modal-detail").append(copy);

				var copy1 =
					'<div id="bagianProdukhapus' +
					i +
					'"><hr id="hr"> <div class="form-group"><div class="row"><div class="col-md-3"><label for="harga_coret">Satuan Berat</label><select name="satuan[]" id="satuan' +
					i +
					'" class="form-control select2satuanBerat' +
					i +
					'"><option value="Pilih Satuan Produk">Pilih Satuan Produk</option></select></div><div class="col-md-4"><label for="harga_coret">Jumlah Berat</label><input type="text" name="jml_berat[]" id="jml_berat' +
					i +
					'" class="form-control" placeholder="Masukan Jumlah Berat"></div><div class="col-md-3" id="stokk"><label for="harga_coret">Jumlah Stok</label><input type="text" name="stok[]" id="stok' +
					i +
					'" class="form-control" placeholder="Masukan Stok"></div><div class="col-md-1"><label for="kd_supplier"></label><br><a href="javascript:void(0)" class="btn btn-danger mt-2" id="hapusfieldproduk' +
					i +
					'"> <i class="fa fa-minus"></i> </a></div></div><div class="row mt-2"><div class="col-md-4"><label for="jml_ukuran">Harga Modal</label><input type="text" class="form-control ' +
					i +
					'" name="harga_modal[]" id="harga_modal_detail' +
					i +
					'" placeholder="Masukan Harga Coret"></div><div class="col-md-4"><label for="harga_produk">Harga Menu</label><div class="input-group"><input type="text" class="form-control " name="harga_produk[]" id="harga_produk' +
					i +
					'" placeholder="Masukan Harga Menu" readonly><span class="input-group-append"><button type="button" class="btn btn-info btn-flat" id="detailkalkulasiharga' +
					i +
					'"><i class="fas fa-dollar-sign"></i> </button></span></div></div><div class="col-md-4"><label for="biaya_lebih">Diskon</label><input type="text" class="form-control ' +
					i +
					'" name="diskon[]" id="diskon' +
					i +
					'" placeholder="Masukan Diskon"></div></div>';

				$("#bagianProduk").append(copy1);

				$("#detailkalkulasiharga" + i).click(function () {
					var harga_modal = $("#harga_modal_detail" + i).val();
					$("#hrg_modal" + i).val(harga_modal);
					$("#ttl_hrg_modal" + i).val(harga_modal);

					if (harga_modal > 0) {
						$.ajax({
							url: base_url + "/konfigurasi/getKonfigurasi",
							type: "post",
							dataType: "json",
							success: function (data) {
								$("#persentaseselera" + i).html(data.ujroh_selera);
								$("#persentasereseller" + i).html(data.ujroh_reseller);
								$("#setperhitunganharga" + i).modal("show");
							},
						});
					} else {
						Toast.fire({
							icon: "error",
							title: "Harga Modal Harus Ditentukan Terlebih Dahulu",
						});
					}
				});

				$("#biaya_lainnya" + i).keyup(function () {
					$.ajax({
						url: base_url + "/konfigurasi/getKonfigurasi",
						type: "post",
						dataType: "json",
						success: function (data) {
							var hargaModal = parseInt($("#hrg_modal" + i).val());
							var biayaLainnya = parseInt($("#biaya_lainnya" + i).val());
							var hargaCompetitor = parseInt($("#harga_competitor" + i).val());

							if (isNaN(hargaCompetitor)) hargaCompetitor = 0;

							if (isNaN(hargaModal)) hargaModal = 0;
							if (isNaN(biayaLainnya)) biayaLainnya = 0;

							$("#ttl_hrg_modal" + i).val(hargaModal + biayaLainnya);

							var margin = parseInt($("#margin" + i).val());
							var ttlHargaModal = parseInt($("#ttl_hrg_modal" + i).val());

							if (isNaN(margin)) margin = 0;
							if (isNaN(ttlHargaModal)) ttlHargaModal = 0;

							$("#hasil_margin" + i).val((ttlHargaModal * margin) / 100);

							var hasilMargin = parseInt($("#hasil_margin" + i).val());
							if (isNaN(hasilMargin)) hasilMargin = 0;

							var hrgJual = ttlHargaModal + hasilMargin;

							var bagi = Math.round(hrgJual / 1000);
							var hargaJual = bagi * 1000;
							var margin30 = (hasilMargin * data.ujroh_reseller) / 100;

							$("#harga_jual" + i).val(margin != 0 ? hrgJual : 0);
							$("#pembulatan_harga_jual" + i).val(margin != 0 ? hargaJual : 0);
							$("#harga_produk" + i).val(margin != 0 ? hargaJual : 0);
							$("#selisih_harga" + i).val(
								hargaCompetitor - (hargaModal + hasilMargin)
							);

							$("#margin100" + i).val(hasilMargin);
							$("#margin70" + i).val((hasilMargin * data.ujroh_selera) / 100);
							$("#margin30" + i).val(margin30);

							var pembulatanHarga = parseInt(
								$("#pembulatan_harga_jual" + i).val()
							);
							if (isNaN(pembulatanHarga)) pembulatanHarga = 0;

							var insentif = (pembulatanHarga * 6) / 100;
							var hasilInsentif = pembulatanHarga - insentif;

							$("#insentif" + i).val(insentif);
							$("#hasil_insentif" + i).val(hasilInsentif);

							var a = Math.round(hasilInsentif / 1000);
							var pembulatanHslInsentif = Math.round(a * 1000);
							$("#harga_jual_reseller" + i).val(pembulatanHslInsentif);

							var hargaJualReseller = $("#harga_jual_reseller" + i).val();

							if (isNaN(hargaJualReseller)) hargaJualReseller = 0;

							$("#selisih_harga_jual" + i).val(
								pembulatanHarga - hargaJualReseller
							);
							var selisih = $("#selisih_harga_jual" + i).val();

							$("#kelebihan_bagi_hasil" + i).val(margin30 - selisih);
							$("#hrg_competitor" + i).val(hargaCompetitor);
							$("#hrg_jual_umum" + i).val(
								parseInt($("#pembulatan_harga_jual" + i).val())
							);
							$("#hrg_jual_reseller" + i).val(hargaJualReseller);
						},
					});
				});

				$("#margin" + i).keyup(function () {
					$.ajax({
						url: base_url + "/konfigurasi/getKonfigurasi",
						type: "post",
						dataType: "json",
						success: function (data) {
							var ttlHargaModal = parseInt($("#ttl_hrg_modal" + i).val());
							var margin = $("#margin" + i).val();
							var hargaCompetitor = parseInt($("#harga_competitor" + i).val());
							var hargaModal = parseInt($("#hrg_modal" + i).val());

							if (isNaN(hargaModal)) hargaModal = 0;
							if (isNaN(hargaCompetitor)) hargaCompetitor = 0;

							if (isNaN(ttlHargaModal)) ttlHargaModal = 0;
							if (isNaN(margin)) margin = 0;

							var hasilMargin = (ttlHargaModal * margin) / 100;

							var hrgJual = ttlHargaModal + hasilMargin;

							var bagi = Math.round(hrgJual / 1000);
							var hargaJual = bagi * 1000;

							$("#harga_produk" + i).attr("readonly", false);

							$("#hasil_margin" + i).val(hasilMargin);
							$("#harga_jual" + i).val(hrgJual);
							$("#pembulatan_harga_jual" + i).val(hargaJual);
							$("#harga_produk" + i).val(hargaJual);

							var hasilMargin = parseInt($("#hasil_margin" + i).val());
							if (isNaN(hasilMargin)) hasilMargin = 0;

							var hrgJual = ttlHargaModal + hasilMargin;

							var bagi = Math.round(hrgJual / 1000);
							var hargaJual = bagi * 1000;
							var margin30 = (hasilMargin * data.ujroh_reseller) / 100;

							$("#harga_jual" + i).val(margin != 0 ? hrgJual : 0);
							$("#pembulatan_harga_jual" + i).val(margin != 0 ? hargaJual : 0);
							$("#harga_produk" + i).val(margin != 0 ? hargaJual : 0);
							$("#selisih_harga" + i).val(
								hargaCompetitor - (hargaModal + hasilMargin)
							);

							$("#margin100" + i).val(hasilMargin);
							$("#margin70" + i).val((hasilMargin * data.ujroh_selera) / 100);
							$("#margin30" + i).val(margin30);

							var pembulatanHarga = parseInt(
								$("#pembulatan_harga_jual" + i).val()
							);
							if (isNaN(pembulatanHarga)) pembulatanHarga = 0;

							var insentif = (pembulatanHarga * 6) / 100;
							var hasilInsentif = pembulatanHarga - insentif;

							$("#insentif" + i).val(insentif);
							$("#hasil_insentif" + i).val(hasilInsentif);

							var a = Math.round(hasilInsentif / 1000);
							var pembulatanHslInsentif = Math.round(a * 1000);
							$("#harga_jual_reseller" + i).val(pembulatanHslInsentif);

							var hargaJualReseller = $("#harga_jual_reseller" + i).val();

							if (isNaN(hargaJualReseller)) hargaJualReseller = 0;

							$("#selisih_harga_jual" + i).val(
								pembulatanHarga - hargaJualReseller
							);
							var selisih = $("#selisih_harga_jual" + i).val();

							$("#kelebihan_bagi_hasil" + i).val(margin30 - selisih);
							$("#hrg_competitor" + i).val(hargaCompetitor);
							$("#hrg_jual_umum" + i).val(
								parseInt($("#pembulatan_harga_jual" + i).val())
							);
							$("#hrg_jual_reseller" + i).val(hargaJualReseller);
						},
					});
				});

				$("#harga_competitor" + i).keyup(function () {
					$.ajax({
						url: base_url + "/konfigurasi/getKonfigurasi",
						type: "post",
						dataType: "json",
						success: function (data) {
							var hargaCompetitor = parseInt($("#harga_competitor" + i).val());
							var pembulatanHarga = parseInt(
								$("#pembulatan_harga_jual" + i).val()
							);
							var hargaJual = parseInt($("#harga_jual" + i).val());
							var ttlHargaModal = parseInt($("#ttl_hrg_modal" + i).val());
							var margin30 = parseInt($("#margin30" + i).val());

							if (isNaN(margin30)) margin30 = 0;
							if (isNaN(hargaCompetitor)) hargaCompetitor = 0;
							if (isNaN(pembulatanHarga)) pembulatanHarga = 0;
							if (isNaN(hargaJual)) hargaJual = 0;
							if (isNaN(ttlHargaModal)) ttlHargaModal = 0;

							$("#selisih_harga" + i).val(hargaCompetitor - pembulatanHarga);
							var margin100 = hargaJual - ttlHargaModal;
							$("#margin100" + i).val(margin100);

							$("#margin70" + i).val((margin100 * data.ujroh_selera) / 100);
							$("#margin30" + i).val((margin100 * data.ujroh_reseller) / 100);

							var insentif = (pembulatanHarga * 6) / 100;
							var hasilInsentif = pembulatanHarga - insentif;

							$("#insentif" + i).val(insentif);
							$("#hasil_insentif" + i).val(hasilInsentif);

							var a = Math.round(hasilInsentif / 1000);
							var pembulatanHslInsentif = Math.round(a * 1000);
							$("#harga_jual_reseller" + i).val(pembulatanHslInsentif);

							var hargaJualReseller = $("#harga_jual_reseller" + i).val();

							if (isNaN(hargaJualReseller)) hargaJualReseller = 0;

							$("#selisih_harga_jual" + i).val(
								pembulatanHarga - hargaJualReseller
							);
							var selisih = $("#selisih_harga_jual" + i).val();

							$("#kelebihan_bagi_hasil" + i).val(margin30 - selisih);
							$("#hrg_competitor" + i).val(hargaCompetitor);
							$("#hrg_jual_umum" + i).val(pembulatanHarga);
							$("#hrg_jual_reseller" + i).val(hargaJualReseller);
						},
					});
				});

				$(".select2satuanBerat" + i).select2({
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

				$("#jenis_penyewaan" + i).change(function () {
					var jenis_penyewaan = $("#jenis_penyewaan" + i).val();
					var barang = $("#barang" + i).val();
					if (barang != "Pilih Barang") {
						$.ajax({
							url: base_url + "/admin/barang/getBarangById",
							type: "post",
							dataType: "json",
							data: {
								id: barang,
								tabel: "primary",
							},
							success: function (result) {
								if (jenis_penyewaan == "jam") {
									$("#jam1" + i).val("");
									var harga = result[0].harga_sewa_jam;

									$("#harga" + i).val(harga);
									$("#qty" + i).val("1");
									$("#sub_total" + i).val(
										$("#harga" + i).val() *
											$("#qty" + i).val() *
											$("#jam1" + i).val()
									);
								} else if (jenis_penyewaan == "bulan") {
									$("#blan1" + i).val("");
									var harga = result[0].harga_sewa_bulan;

									$("#harga" + i).val(harga);
									$("#qty" + i).val("1");
									$("#sub_total" + i).val(
										$("#harga" + i).val() *
											$("#qty" + i).val() *
											$("#blan1" + i).val()
									);
								}
							},
						});
					}
				});

				$("#jam1" + i).keyup(function () {
					var harga = parseInt($("#harga" + i).val());
					var jenis_penyewaan = $("#jenis_penyewaan" + i).val();
					var jam = $("#jam1" + i).val();
					var qty = $("#qty" + i).val();

					if (jenis_penyewaan == "jam") {
						var jam = $("#jam1" + i).val();
						var total = jam * harga * parseInt(qty);
					} else if (jenis_penyewaan == "bulan") {
					} else {
						var total = harga * parseInt(qty);
					}

					var record = $("#jumrecord").val();
					if (!isNaN(total)) {
						$("#sub_total" + i).val(total);
					}

					if ($("#sub_total" + i).val() == 0) {
						$("#diskon" + i).val("");
					}

					var diskon = $("#diskon").val();
					var biayaAngkut = $("#biaya_angkut").val();
					if (diskon == "" || diskon == undefined || diskon == null) {
						diskon = 0;
					}

					if (
						biayaAngkut == "" ||
						biayaAngkut == undefined ||
						biayaAngkut == null
					) {
						biayaAngkut = 0;
					}

					var subTotal = $("#sub_total").val();

					var data = [];
					var data1 = [];
					var dataDiskon = [];
					var dataBiayaAngkut = [];

					if (qty == "") {
						$("#sub_total" + i).val(parseInt(0));
					}

					if (qty != "" && harga != "") {
						subTotalBaru = jam * qty * harga - diskon;
						$("#sub_total" + i).val(subTotalBaru);
					}

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#sub_total" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						data.push(obj);
					}

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#diskon" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataDiskon.push(obj);
					}

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#biaya_angkut" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataBiayaAngkut.push(obj);
					}

					var myTotal = 0;
					for (let i = 1; i <= record; i++) {
						var obj = {};
						obj = $("#esub_total" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						data1.push(obj);
					}

					var myTotal = 0;
					var myTotal1 = 0;
					var myDiskon = 0;
					var myBiayaAngkut = 0;

					for (var a = 0, len = data.length; a < len; a++) {
						myTotal += parseInt(data[a]);
					}
					var totalHarga = parseInt(myTotal) + parseInt(subTotal);
					$("#total_harga").val("Rp. " + totalHarga.toString());

					for (var a = 0, len = data1.length; a < len; a++) {
						myTotal1 += parseInt(data1[a]);
					}

					for (var a = 0, len = dataDiskon.length; a < len; a++) {
						myDiskon += parseInt(dataDiskon[a]);
					}

					for (var a = 0, len = dataBiayaAngkut.length; a < len; a++) {
						myBiayaAngkut += parseInt(dataBiayaAngkut[a]);
					}

					if (subTotal == "") {
						subTotal = 0;
					}

					var totalHarga =
						parseInt(myTotal) +
						parseInt(subTotal) -
						(parseInt(myDiskon) + parseInt(diskon)) +
						(parseInt(myBiayaAngkut) + parseInt(biayaAngkut));
					$("#total_harga").val("Rp. " + totalHarga.toString());
					var totalHarga =
						parseInt(myTotal) +
						parseInt(myTotal1) -
						(parseInt(myDiskon) + parseInt(diskon)) +
						(parseInt(myBiayaAngkut) + parseInt(biayaAngkut));
					$("#etotal_harga").val("Rp. " + totalHarga.toString());
				});

				$("#blan1" + i).keyup(function () {
					var harga = parseInt($("#harga" + i).val());
					var jenis_penyewaan = $("#jenis_penyewaan" + i).val();
					var bulan = $("#blan1" + i).val();
					var qty = $("#qty" + i).val();

					if (bulan == "") {
						bulan = 0;
					}

					if (jenis_penyewaan == "bulan") {
						var bulan = $("#blan1" + i).val();
						var total = bulan * harga * parseInt(qty);
					} else if (jenis_penyewaan == "bulan") {
					} else {
						var total = harga * parseInt(qty);
					}

					var record = $("#jumrecord").val();
					if (!isNaN(total)) {
						$("#sub_total" + i).val(total);
					}

					if ($("#sub_total" + i).val() == 0) {
						$("#diskon" + i).val("");
					}

					var diskon = $("#diskon").val();
					var biayaAngkut = $("#biaya_angkut").val();
					if (diskon == "" || diskon == undefined || diskon == null) {
						diskon = 0;
					}

					if (
						biayaAngkut == "" ||
						biayaAngkut == undefined ||
						biayaAngkut == null
					) {
						biayaAngkut = 0;
					}

					var subTotal = $("#sub_total").val();

					var data = [];
					var data1 = [];
					var dataDiskon = [];
					var dataBiayaAngkut = [];

					if (qty == "") {
						$("#sub_total" + i).val(parseInt(0));
					}

					if (qty != "" && harga != "") {
						subTotalBaru = bulan * qty * harga - diskon;
						$("#sub_total" + i).val(subTotalBaru);
					}

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#sub_total" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						data.push(obj);
					}

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#diskon" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataDiskon.push(obj);
					}

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#biaya_angkut" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataBiayaAngkut.push(obj);
					}

					var myTotal = 0;
					for (let i = 1; i <= record; i++) {
						var obj = {};
						obj = $("#esub_total" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						data1.push(obj);
					}

					var myTotal = 0;
					var myTotal1 = 0;
					var myDiskon = 0;
					var myBiayaAngkut = 0;

					for (var a = 0, len = data.length; a < len; a++) {
						myTotal += parseInt(data[a]);
					}
					var totalHarga = parseInt(myTotal) + parseInt(subTotal);
					$("#total_harga").val("Rp. " + totalHarga.toString());

					for (var a = 0, len = data1.length; a < len; a++) {
						myTotal1 += parseInt(data1[a]);
					}

					for (var a = 0, len = dataDiskon.length; a < len; a++) {
						myDiskon += parseInt(dataDiskon[a]);
					}

					for (var a = 0, len = dataBiayaAngkut.length; a < len; a++) {
						myBiayaAngkut += parseInt(dataBiayaAngkut[a]);
					}

					if (subTotal == "") {
						subTotal = 0;
					}

					var totalHarga =
						parseInt(myTotal) +
						parseInt(subTotal) -
						(parseInt(myDiskon) + parseInt(diskon)) +
						(parseInt(myBiayaAngkut) + parseInt(biayaAngkut));
					$("#total_harga").val("Rp. " + totalHarga.toString());
					var totalHarga =
						parseInt(myTotal) +
						parseInt(myTotal1) -
						(parseInt(myDiskon) + parseInt(diskon)) +
						(parseInt(myBiayaAngkut) + parseInt(biayaAngkut));
					$("#etotal_harga").val("Rp. " + totalHarga.toString());
				});

				$("#qty" + i).keyup(function () {
					var harga = parseInt($("#harga" + i).val());
					var jenis_penyewaan = $("#jenis_penyewaan" + i).val();
					var qty = $("#qty" + i).val();
					var indexPlus = parseInt($("#jmlbarangplus").val());

					if (jenis_penyewaan == "jam") {
						var jam = $("#jam1" + i).val();
						var total = jam * harga * parseInt(qty);
					} else if (jenis_penyewaan == "bulan") {
						var bulan = $("#blan1" + i).val();
						var total = bulan * harga * parseInt(qty);
					} else {
						var total = harga * parseInt(qty);
					}

					var record = $("#jumrecord").val();
					if (!isNaN(total)) {
						$("#sub_total" + i).val(total);
					}

					var diskon = $("#diskon").val();
					var biayaAngkut = $("#biaya_angkut").val();
					if (diskon == "" || diskon == undefined || diskon == null) {
						diskon = 0;
					}

					if (
						biayaAngkut == "" ||
						biayaAngkut == undefined ||
						biayaAngkut == null
					) {
						biayaAngkut = 0;
					}

					var subTotal = $("#sub_total").val();

					var data = [];
					var data1 = [];
					var dataDiskon = [];
					var dataBiayaAngkut = [];

					if (qty == "") {
						$("#sub_total" + i).val(parseInt(0));
					}

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#sub_total" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						data.push(obj);
					}

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#diskon" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataDiskon.push(obj);
					}

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#biaya_angkut" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataBiayaAngkut.push(obj);
					}

					var myTotal = 0;
					for (let i = 1; i <= record; i++) {
						var obj = {};
						obj = $("#esub_total" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						data1.push(obj);
					}

					var myTotal = 0;
					var myTotal1 = 0;
					var myDiskon = 0;
					var myBiayaAngkut = 0;

					for (var a = 0, len = data.length; a < len; a++) {
						myTotal += parseInt(data[a]);
					}
					var totalHarga = parseInt(myTotal) + parseInt(subTotal);
					$("#total_harga").val("Rp. " + totalHarga.toString());

					for (var a = 0, len = data1.length; a < len; a++) {
						myTotal1 += parseInt(data1[a]);
					}

					for (var a = 0, len = dataDiskon.length; a < len; a++) {
						myDiskon += parseInt(dataDiskon[a]);
					}

					for (var a = 0, len = dataBiayaAngkut.length; a < len; a++) {
						myBiayaAngkut += parseInt(dataBiayaAngkut[a]);
					}

					if (subTotal == "") {
						subTotal = 0;
					}

					var totalHarga =
						parseInt(myTotal) +
						parseInt(subTotal) -
						(parseInt(myDiskon) + parseInt(diskon)) +
						(parseInt(myBiayaAngkut) + parseInt(biayaAngkut));
					$("#total_harga").val("Rp. " + totalHarga.toString());
					var totalHarga =
						parseInt(myTotal) +
						parseInt(myTotal1) -
						(parseInt(myDiskon) + parseInt(diskon)) +
						(parseInt(myBiayaAngkut) + parseInt(biayaAngkut));
					$("#etotal_harga").val("Rp. " + totalHarga.toString());
				});

				$("#diskon" + i).keyup(function () {
					var subTotal = $("#sub_total").val();
					var indexPlus = parseInt($("#jmlbarangplus").val());
					var diskon = $("#diskon").val();
					var diskonn = $("#diskon").val();
					var biayaAngkut = $("#biaya_angkut").val();

					if (parseInt(diskon) > parseInt(subTotal)) {
						Toast.fire({
							icon: "error",
							title: "Diskon Tidak Boleh Melebihi Sub Total",
						});
					}

					if (diskon == "" || diskon == undefined) {
						diskon = 0;
					}

					if (diskonn == "" || diskonn == undefined) {
						diskonn = 0;
					}

					if (biayaAngkut == "" || biayaAngkut == undefined) {
						biayaAngkut = 0;
					}

					if (qty == 0) {
						$("#diskon" + i).val(diskonn);
					} else {
						$("#diskon" + i).val(diskonn * qty);
					}

					var dataSubTotal = [];
					var dataDiskon = [];
					var dataBiayaAngkut = [];

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#sub_total" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataSubTotal.push(obj);
					}

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#diskon" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataDiskon.push(obj);
					}

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#biaya_angkut" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataBiayaAngkut.push(obj);
					}

					var mySubTotal = 0;
					var myDiskon = 0;
					var myBiayaAngkut = 0;

					for (var a = 0, len = dataSubTotal.length; a < len; a++) {
						mySubTotal += parseInt(dataSubTotal[a]);
					}

					for (var a = 0, len = dataDiskon.length; a < len; a++) {
						myDiskon += parseInt(dataDiskon[a]);
					}

					for (var a = 0, len = dataBiayaAngkut.length; a < len; a++) {
						myBiayaAngkut += parseInt(dataBiayaAngkut[a]);
					}

					if (subTotal == "") {
						subTotal = 0;
					}

					var hargaSetelahDiskon =
						parseInt(subTotal) +
						parseInt(mySubTotal) -
						(parseInt(myDiskon) + parseInt(diskon)) +
						(parseInt(myBiayaAngkut) + parseInt(biayaAngkut));
					$("#total_harga").val("Rp. " + hargaSetelahDiskon.toString());
				});

				$("#biaya_angkut" + i).keyup(function () {
					var subTotal = $("#sub_total").val();
					var indexPlus = parseInt($("#jmlbarangplus").val());
					var diskon = $("#diskon").val();
					var biayaAngkut = $("#biaya_angkut").val();

					if (parseInt(diskon) > parseInt(subTotal)) {
						Toast.fire({
							icon: "error",
							title: "Diskon Tidak Boleh Melebihi Sub Total",
						});
					}

					if (diskon == "" || diskon == undefined) {
						diskon = 0;
					}

					if (biayaAngkut == "" || biayaAngkut == undefined) {
						biayaAngkut = 0;
					}

					var dataSubTotal = [];
					var dataDiskon = [];
					var dataBiayaAngkut = [];

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#sub_total" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataSubTotal.push(obj);
					}

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#diskon" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataDiskon.push(obj);
					}

					for (let i = 2; i <= indexPlus; i++) {
						var obj = {};
						obj = $("#biaya_angkut" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataBiayaAngkut.push(obj);
					}

					var mySubTotal = 0;
					var myDiskon = 0;
					var myBiayaAngkut = 0;

					for (var a = 0, len = dataSubTotal.length; a < len; a++) {
						mySubTotal += parseInt(dataSubTotal[a]);
					}

					for (var a = 0, len = dataDiskon.length; a < len; a++) {
						myDiskon += parseInt(dataDiskon[a]);
					}

					for (var a = 0, len = dataBiayaAngkut.length; a < len; a++) {
						myBiayaAngkut += parseInt(dataBiayaAngkut[a]);
					}

					if (subTotal == "") {
						subTotal = 0;
					}

					var hargaSetelahDiskon =
						parseInt(subTotal) +
						parseInt(mySubTotal) -
						(parseInt(myDiskon) + parseInt(diskon)) +
						(parseInt(myBiayaAngkut) + parseInt(biayaAngkut));
					$("#total_harga").val("Rp. " + hargaSetelahDiskon.toString());
				});

				$("body").on("click", "#hapusfieldproduk" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					$(this)
						.parents("#bagianProdukhapus" + i)
						.remove();
				});
			}
		} else {
			Toast.fire({
				icon: "error",
				title: "Tidak Bisa Menambah Lagi.",
			});
		}
	});

	$("#editbuttontambahproduk").click(function () {
		var looping = parseInt($("#edit_jmlbarang1").val()) + 1;
		var record = $("#edit_jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#edit_jmlbarang1").val(looping);
			$("#edit_jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#edit_jmlbarangplus").val());
			var indexMinus = parseInt($("#edit_jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#edit_jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#edit_jmlbarangplus").val(i);

				var copy =
					'<div id="bagianhapusproduk' +
					i +
					'"><hr><div class="row"><div class="col-md-8 col-xs-8 col-8"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2produk' +
					i +
					'" id="promo_produk' +
					i +
					'" required><option value="">Pilih Produk</option></select></div></div><div class="col-md-4 col-xs-4 col-4"><label>Harga Menu</label><input type="text" class="form-control input-rupiah-mask' +
					i +
					'" name="harga_produk[]" id="harga_produk' +
					i +
					'" placeholder="Harga Menu" readonly required></div><div class="col-md-11 col-xs-10 col-10"><label>Harga Promo</label><input type="text" class="form-control input-rupiah-mask' +
					i +
					'" name="harga_promo[]" id="harga_promo' +
					i +
					'" placeholder="Harga Promo" required></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusproduk' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$("#edit_bagiantambahproduk1").append(copy);

				$("body").on("click", "#buttonhapusproduk" + i, function () {
					$("#edit_jmlbarang1").val(parseInt($("#edit_jmlbarang1").val()) - 1);

					$(this)
						.parents("#bagianhapusproduk" + i)
						.remove();
				});

				$(".select2produk" + i).select2({
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

				$(".select2produk" + i).on("select2:select", function (e) {
					var harga = e.params.data.harga;
					$("#harga_produk" + i).val(harga);
				});

				$(".input-rupiah-mask" + i).inputmask({
					alias: "numeric",
					groupSeparator: ",",
					autoGroup: true,
					digits: 0,
					digitsOptional: false,
					prefix: "Rp ",
					placeholder: "0",
					rightAlign: false,
					autoUnmask: true,
					removeMaskOnSubmit: true,
				});

				$("#harga_promo" + i).keyup(function () {
					var harga_promo = parseInt($("#harga_promo" + i).val());
					var harga_produk = parseInt($("#harga_produk" + i).val());
					if (harga_promo > harga_produk) {
						$(".error-data1").html(
							"Harga Promo tidak bisa lebih dari Harga Menu."
						);
						$(".flash-data1").html("");
						toast();
						$("#harga_promo" + i).val(0);
					}
				});
			}
		}
	});

	$("#editbuttontambahpo").click(function () {
		var looping = parseInt($("#edit_jmlbarang1").val()) + 1;
		var record = $("#edit_jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#edit_jmlbarang1").val(looping);
			$("#edit_jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#edit_jmlbarangplus").val());
			var indexMinus = parseInt($("#edit_jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#edit_jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#edit_jmlbarangplus").val(i);

				var copy =
					'<div id="bagianhapusprodukpo' +
					i +
					'"><div class="row"><div class="col-md-11 col-xs-11 col-11"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2produkpo' +
					i +
					'" id="promo_produk' +
					i +
					'" required><option value="">Pilih Produk</option></select></div></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapuspo' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$("#edit_bagiantambahpo1").append(copy);

				$("body").on("click", "#buttonhapuspo" + i, function () {
					$("#edit_jmlbarang1").val(parseInt($("#edit_jmlbarang1").val()) - 1);

					$(this)
						.parents("#bagianhapusprodukpo" + i)
						.remove();
				});

				$(".select2produkpo" + i).select2({
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

				$(".select2produk" + i).on("select2:select", function (e) {
					var harga = e.params.data.harga;
					$("#harga_produk" + i).val(harga);
				});

				$(".input-rupiah-mask" + i).inputmask({
					alias: "numeric",
					groupSeparator: ",",
					autoGroup: true,
					digits: 0,
					digitsOptional: false,
					prefix: "Rp ",
					placeholder: "0",
					rightAlign: false,
					autoUnmask: true,
					removeMaskOnSubmit: true,
				});
			}
		}
	});

	$("#buttontambahbanyakpelanggan").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				var copy =
					'<div id="bagianhapusproduk' +
					i +
					'"><div class="row" style="width: 100%;"><div class="form-group mt-2 col-md-11 col-xs-11 col-11"><label for="kd_member">Pilih Pelanggan</label><select class="form-control select2memberResNew' +
					i +
					'" id="member_banyak' +
					i +
					'" style="width: 100%;" required><option value="Pilih member">Pilih Pelanggan</option></select></div><div class="col-md-1 col-xs-1 col-1 mt-2"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusbanyakpelanggan' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$("#bagianpelangganbanyak").append(copy);

				$("body").on("click", "#buttonhapusbanyakpelanggan" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					$(this)
						.parents("#bagianhapusproduk" + i)
						.remove();
				});

				$(".select2memberResNew" + i).select2({
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

				$(".select2memberResNew" + i).on("select2:select", function (e) {
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
			}
		}
	});

	$("#buttontambahstokprodukkeluar").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				var copy =
					'<div id="bagianhapusproduk' +
					i +
					'"><hr><div class="row"><div class="col-md-5 col-xs-5 col-5"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2stokproduk' +
					i +
					'" id="kd_detail_produk_keluar' +
					i +
					'" required><option value="">Pilih Produk</option></select></div></div><div class="col-md-3 col-xs-3 col-3"><label>Stok Tersedia</label><input type="hidden" class="form-control" id="stok_produk_keluar1' +
					i +
					'" placeholder="Stok Produk" required readonly><input type="text" class="form-control" name="stok_produk[]" id="stok_produk_keluar' +
					i +
					'" placeholder="Stok Produk" required readonly></div><div class="col-md-3 col-xs-3 col-3"><label>Stok Akan Keluar</label><input type="text" class="form-control" name="stok_keluar[]" id="stok_keluar' +
					i +
					'" placeholder="Stok Produk" required></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusstokprodukkeluar' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$("#bagiantambahstokprodukkeluar").append(copy);

				$("body").on("click", "#buttonhapusstokprodukkeluar" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					$(this)
						.parents("#bagianhapusproduk" + i)
						.remove();
				});

				$("#stok_keluar" + i).keyup(function () {
					var stok = parseInt($("#stok_produk_keluar" + i).val());
					var stok2 = parseInt($("#stok_produk_keluar1" + i).val());
					var stok_baru = parseInt($("#stok_keluar" + i).val());
					if (isNaN(stok_baru)) {
						$("#stok_produk_keluar" + i).val(stok2);
					} else if (stok_baru > stok2) {
						$(".error-data1").html(
							"Stok Keluar Tidak Boleh melebihi stok yang ada."
						);
						$(".flash-data1").html("");
						toast();
						$("#stok_keluar" + i).val("");
						$("#stok_produk_keluar" + i).val(stok2);
					} else if (stok_baru <= stok2) {
						var total = stok2 - stok_baru;
						$("#stok_produk_keluar" + i).val(total);
					}
				});

				$(".select2stokproduk" + i).select2({
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

				$(".select2stokproduk" + i).on("select2:select", function (e) {
					var stok = e.params.data.stok;
					$("#stok_produk_keluar1" + i).val(stok);
					$("#stok_produk_keluar" + i).val(stok);
				});
			}
		}
	});

	$("#buttontambahstokproduk").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				var copy =
					'<div id="bagianhapusproduk' +
					i +
					'"><hr><div class="row"><div class="col-md-8 col-xs-8 col-8"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2produk' +
					i +
					'" id="promo_produk' +
					i +
					'" required><option value="">Pilih Produk</option></select></div></div><div class="col-md-3 col-xs-3 col-3"><label>Stok</label><input type="text" class="form-control" name="stok_produk[]" id="stok_produk' +
					i +
					'" placeholder="Stok Produk" required></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusstokproduk' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$("#bagiantambahstokproduk").append(copy);

				$("body").on("click", "#buttonhapusstokproduk" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					$(this)
						.parents("#bagianhapusproduk" + i)
						.remove();
				});

				$(".select2produk" + i).select2({
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
			}
		}
	});

	$("#buttontambahproduk").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				var copy =
					'<div id="bagianhapusproduk' +
					i +
					'"><hr><div class="row"><div class="col-md-8 col-xs-8 col-8"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2produk' +
					i +
					'" id="promo_produk' +
					i +
					'" required><option value="">Pilih Produk</option></select></div></div><div class="col-md-4 col-xs-4 col-4"><label>Harga Menu</label><input type="text" class="form-control input-rupiah-mask' +
					i +
					'" name="harga_produk[]" id="harga_produk' +
					i +
					'" placeholder="Harga Menu" readonly required></div><div class="col-md-11 col-xs-10 col-10"><label>Harga Promo</label><input type="text" class="form-control input-rupiah-mask' +
					i +
					'" name="harga_promo[]" id="harga_promo' +
					i +
					'" placeholder="Harga Promo" required></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusproduk' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$("#bagiantambahproduk").append(copy);

				$("body").on("click", "#buttonhapusproduk" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					$(this)
						.parents("#bagianhapusproduk" + i)
						.remove();
				});

				$(".select2produk" + i).select2({
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

				$(".select2produk" + i).on("select2:select", function (e) {
					var harga = e.params.data.harga;
					$("#harga_produk" + i).val(harga);
				});

				$(".input-rupiah-mask" + i).inputmask({
					alias: "numeric",
					groupSeparator: ",",
					autoGroup: true,
					digits: 0,
					digitsOptional: false,
					prefix: "Rp ",
					placeholder: "0",
					rightAlign: false,
					autoUnmask: true,
					removeMaskOnSubmit: true,
				});

				$("#harga_promo" + i).keyup(function () {
					var harga_promo = parseInt($("#harga_promo" + i).val());
					var harga_produk = parseInt($("#harga_produk" + i).val());
					if (harga_promo > harga_produk) {
						$(".error-data1").html(
							"Harga Promo tidak bisa lebih dari Harga Menu."
						);
						$(".flash-data1").html("");
						toast();
						$("#harga_promo" + i).val(0);
					}
				});
			}
		}
	});

	$("#buttontambahprodukPaket").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				var copy =
					'<div id="bagianhapusproduk' +
					i +
					'"><div class="row"><div class="col-md-6 col-xs-6 col-6"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2produkpaket' +
					i +
					'" id="promo_produk' +
					i +
					'" required><option value="">Pilih Produk</option></select></div></div><div class="col-md-1 col-xs-1 col-1"><label>QTY</label><input type="text" class="form-control" name="qty[]" id="qtypaket' +
					i +
					'" placeholder="QTY" required></div><div class="col-md-4 col-xs-4 col-4"><label for="harga_produk">Harga Menu</label><div class="input-group"><input type="text" class="form-control input-rupiah-mask" name="harga_produk[]" id="harga_produk' +
					i +
					'" placeholder="Harga Menu" readonly required><input type="hidden" class="form-control input-rupiah-mask" id="harga_produkk' +
					i +
					'" placeholder="Harga Menu" readonly required><span class="input-group-append"><button type="button" class="btn btn-info btn-flat" id="eujrohpaketan' +
					i +
					'"><i class="fas fa-dollar-sign"></i> </button></span></div></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusprodukpaket' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$("#bagiantambahprodukpaket").append(copy);

				var copy1 =
					'<div id="bagianhapusmodalproduk' +
					i +
					'"><div class="modal fade" id="Modal_ujroh_paketan' +
					i +
					'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">Detail Promo</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="row"><div class="col-xs-6 col-md-6"><div class="form-group"><label for="">Jumlah Ujroh Selera</label><input type="text" name="ujroh_selera[]" id="ujroh_selera' +
					i +
					'" class="form-control rupiah-mask"><input type="hidden" id="hid_ujroh_selera' +
					i +
					'" class="form-control rupiah-mask" readonly><input type="hidden" id="hid_ujroh' +
					i +
					'" class="form-control rupiah-mask" readonly></div></div><div class="col-xs-6 col-md-6"><div class="form-group"><label for="">Jumlah Ujroh Reseller</label><input type="text" name="ujroh[]" id="ujroh' +
					i +
					'" class="form-control rupiah-mask"></div></div></div></div></div></div></div></div>';
				$(".tmpt-ujroh-paket").append(copy1);

				$("#eujrohpaketan" + i).click(function () {
					var promo_produk = $("#promo_produk" + i).val();
					if (promo_produk == "") {
						Toast.fire({
							icon: "error",
							title: "Produk Harus Dipilih Terlebih Dahulu",
						});
					} else {
						$("#Modal_ujroh_paketan" + i).modal("show");
					}
				});

				$("body").on("click", "#buttonhapusprodukpaket" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					var hargaDihapus = parseInt($("#harga_produk" + i).val());
					var hargaModal = parseInt($("#harga_modal").val());

					if (isNaN(hargaDihapus)) hargaDihapus = 0;
					if (isNaN(hargaModal)) hargaModal = 0;

					$("#harga_modal").val(parseInt(hargaModal) - parseInt(hargaDihapus));

					$(this)
						.parents("#bagianhapusproduk" + i)
						.remove();

					$(this)
						.parents("#bagianhapusmodalproduk" + i)
						.remove();
				});

				$(".select2produkpaket" + i).select2({
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

				$(".select2produkpaket" + i).on("select2:select", function (e) {
					var harga = e.params.data.harga;
					var ujroh = e.params.data.jmlKomisi;
					var ujrohSelera = e.params.data.jmlKomisiSelera;
					var maxGroupbarang = $("#jmlbarang").val();
					$("#harga_produk" + i).val(harga);
					var qty = $("#qtypaket" + i).val();

					if (qty != "") {
						if (isNaN(qty)) qty = 0;
						$("#harga_produk" + i).val(harga * qty);
					} else {
						$("#harga_produk" + i).val(harga);
						$("#harga_produkk" + i).val(harga);
					}

					$("#hid_ujroh" + i).val(ujroh);
					$("#hid_ujroh_selera" + i).val(ujrohSelera);
					$("#ujroh" + i).val(ujroh);
					$("#ujroh_selera" + i).val(ujrohSelera);

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

				$("#qtypaket" + i).keyup(function () {
					var maxGroupbarang = $("#jmlbarang").val();
					var qty = $("#qtypaket" + i).val();
					var hargaProduk = $("#harga_produkk" + i).val();
					var ujroh = $("#hid_ujroh" + i).val();
					var ujrohSelera = $("#hid_ujroh_selera" + i).val();

					$("#harga_produk" + i).val(qty * hargaProduk);

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

					$("#ujroh" + i).val(parseInt(qty) * parseInt(ujroh));
					$("#ujroh_selera" + i).val(parseInt(qty) * parseInt(ujrohSelera));

					$("#harga_modal").val(myTotalModal);
				});

				$(".input-rupiah-mask" + i).inputmask({
					alias: "numeric",
					groupSeparator: ",",
					autoGroup: true,
					digits: 0,
					digitsOptional: false,
					prefix: "Rp ",
					placeholder: "0",
					rightAlign: false,
					autoUnmask: true,
					removeMaskOnSubmit: true,
				});

				$("#harga_promo" + i).keyup(function () {
					var harga_promo = parseInt($("#harga_promo" + i).val());
					var harga_produk = parseInt($("#harga_produk" + i).val());
					if (harga_promo > harga_produk) {
						$(".error-data1").html(
							"Harga Promo tidak bisa lebih dari Harga Menu."
						);
						$(".flash-data1").html("");
						toast();
						$("#harga_promo" + i).val(0);
					}
				});
			}
		}
	});

	$("#editbuttontambahprodukpaket").click(function () {
		var looping = parseInt($("#edit_jmlbarang1").val()) + 1;
		var record = $("#edit_jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#edit_jmlbarang1").val(looping);
			$("#edit_jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#edit_jmlbarangplus").val());
			var indexMinus = parseInt($("#edit_jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#edit_jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#edit_jmlbarangplus").val(i);

				copy =
					'<div id="bagiantambahprodukpaket' +
					i +
					'"><div class="row"><div class="col-md-6 col-xs-6 col-6"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2produkpaket' +
					i +
					'" id="edit_promo_produk' +
					i +
					'" required><option></option></select></div></div><div class="col-md-1 col-xs-1 col-1"><label>QTY</label><input type="text" class="form-control" name="qty[]" id="edit_qtypaket' +
					i +
					'" placeholder="QTY" required></div><div class="col-md-4 col-xs-4 col-4"><label for="harga_produk">Harga Menu</label><div class="input-group"><input type="text" class="form-control input-rupiah-mask' +
					i +
					'" name="harga_produk[]" id="edit_harga_produk' +
					i +
					'" placeholder="Harga Menu" readonly required><input type="hidden" class="form-control input-rupiah-mask' +
					i +
					'" id="edit_harga_produkk' +
					i +
					'" placeholder="Harga Menu" readonly required><span class="input-group-append"><button type="button" class="btn btn-info btn-flat" id="eujrohpaketan' +
					i +
					'"><i class="fas fa-dollar-sign"></i> </button></span></div></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusprodukpaket' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$("#edit_bagiantambahprodukgrosir1").append(copy);

				text1 =
					'<div id="bagiantambahujrohprodukpaket' +
					i +
					'"><div class="modal fade" id="Modal_ujroh_paketan' +
					i +
					'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">Detail Ujroh</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="row"><div class="col-xs-6 col-md-6"><div class="form-group"><label for="">Jumlah Ujroh Selera</label><input type="text" name="ujroh_selera[]"  id="ujroh_selera' +
					i +
					'" class="form-control rupiah-mask"><input type="hidden"  id="hid_ujroh_selera' +
					i +
					'" class="form-control rupiah-mask" readonly><input type="hidden" id="hid_ujroh' +
					i +
					'" class="form-control rupiah-mask" readonly></div></div><div class="col-xs-6 col-md-6"><div class="form-group"><label for="">Jumlah Ujroh Reseller</label><input type="text" name="ujroh[]" id="ujroh' +
					i +
					'" class="form-control rupiah-mask"></div></div></div></div></div></div></div>';

				$(".edit-tmpt-ujroh-grosir").append(text1);

				$("body").on("click", "#buttonhapusprodukpaket" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					var hargaDihapus = parseInt($("#edit_harga_produk" + i).val());
					var hargaModal = parseInt($("#edit_harga_modal").val());

					if (isNaN(hargaDihapus)) hargaDihapus = 0;
					if (isNaN(hargaModal)) hargaModal = 0;

					$("#edit_harga_modal").val(
						parseInt(hargaModal) - parseInt(hargaDihapus)
					);

					$(this)
						.parents("#bagiantambahprodukpaket" + i)
						.remove();

					$(this)
						.parents("#bagiantambahujrohprodukpaket" + i)
						.remove();
				});

				$("#eujrohpaketan" + i).click(function () {
					var promo_produk = $("#edit_promo_produk" + i).val();
					if (promo_produk == "") {
						Toast.fire({
							icon: "error",
							title: "Produk Harus Dipilih Terlebih Dahulu",
						});
					} else {
						$("#Modal_ujroh_paketan" + i).modal("show");
					}
				});

				$(".select2produkpaket" + i).select2({
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

				$(".select2produkpaket" + i).on("select2:select", function (e) {
					var harga = e.params.data.harga;
					var ujroh = e.params.data.jmlKomisi;
					var ujrohSelera = e.params.data.jmlKomisiSelera;
					var maxGroupbarang = $("#jmlbarang").val();
					$("#edit_harga_produk" + i).val(harga);
					var qty = $("#edit_qtypaket" + i).val();

					if (qty != "") {
						if (isNaN(qty)) qty = 0;
						$("#edit_harga_produk" + i).val(harga * qty);
						$("#edit_harga_produkk" + i).val(harga);
					} else {
						$("#edit_harga_produk" + i).val(harga);
						$("#edit_harga_produkk" + i).val(harga);
					}

					$("#hid_ujroh" + i).val(ujroh);
					$("#hid_ujroh_selera" + i).val(ujrohSelera);
					$("#ujroh" + i).val(ujroh);
					$("#ujroh_selera" + i).val(ujrohSelera);

					var dataModal = [];

					for (let j = 1; j <= maxGroupbarang; j++) {
						var obj = {};
						obj = $("#edit_harga_produk" + j).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataModal.push(obj);
					}

					var myTotalModal = 0;

					for (var j = 0, len = dataModal.length; j < len; j++) {
						myTotalModal += parseInt(dataModal[j]);
					}

					$("#edit_harga_modal").val(myTotalModal);
				});

				$("#edit_qtypaket" + i).keyup(function () {
					var maxGroupbarang = $("#jmlbarang").val();
					var qty = $("#edit_qtypaket" + i).val();
					var hargaProduk = $("#edit_harga_produkk" + i).val();
					var ujroh = $("#hid_ujroh" + i).val();
					var ujrohSelera = $("#hid_ujroh_selera" + i).val();

					$("#edit_harga_produk" + i).val(qty * hargaProduk);

					var dataModal = [];

					for (let j = 1; j <= maxGroupbarang; j++) {
						var obj = {};
						obj = $("#edit_harga_produk" + j).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataModal.push(obj);
					}

					var myTotalModal = 0;

					for (var j = 0, len = dataModal.length; j < len; j++) {
						myTotalModal += parseInt(dataModal[j]);
					}

					$("#ujroh" + i).val(parseInt(qty) * parseInt(ujroh));
					$("#ujroh_selera" + i).val(parseInt(qty) * parseInt(ujrohSelera));

					$("#edit_harga_modal").val(myTotalModal);
				});

				$(".input-rupiah-mask" + i).inputmask({
					alias: "numeric",
					groupSeparator: ",",
					autoGroup: true,
					digits: 0,
					digitsOptional: false,
					prefix: "Rp ",
					placeholder: "0",
					rightAlign: false,
					autoUnmask: true,
					removeMaskOnSubmit: true,
				});

				$("#harga_promo" + i).keyup(function () {
					var harga_promo = parseInt($("#harga_promo" + i).val());
					var harga_produk = parseInt($("#harga_produk" + i).val());
					if (harga_promo > harga_produk) {
						$(".error-data1").html(
							"Harga Promo tidak bisa lebih dari Harga Menu."
						);
						$(".flash-data1").html("");
						toast();
						$("#harga_promo" + i).val(0);
					}
				});
			}
		}
	});

	$("#editbuttontambahprodukpaketbonus").click(function () {
		var looping = parseInt($("#edit_jmlbarang1").val()) + 1;
		var record = $("#edit_jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#edit_jmlbarang1").val(looping);
			$("#edit_jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#edit_jmlbarangplus").val());
			var indexMinus = parseInt($("#edit_jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#edit_jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#edit_jmlbarangplus").val(i);

				var copy =
					'<div id="bagianhapusproduk' +
					i +
					'"><div class="row"><div class="col-md-6 col-xs-6 col-6"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2produkpaket' +
					i +
					'" id="promo_produk' +
					i +
					'" required><option value="">Pilih Produk</option></select></div></div><div class="col-md-2 col-xs-2 col-2"><label>QTY</label><input type="text" class="form-control" name="qty[]" id="qtypaket' +
					i +
					'" placeholder="QTY" required></div><div class="col-md-3 col-xs-3 col-3"><label>Harga Menu</label><input type="text" class="form-control input-rupiah-mask' +
					i +
					'" name="harga_produk[]" id="edit_harga_produk' +
					i +
					'" placeholder="Harga Menu" readonly required><input type="hidden" class="form-control input-rupiah-mask' +
					i +
					'" id="edit_harga_produkk' +
					i +
					'" placeholder="Harga Menu" readonly required></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusprodukpaket' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$("#edit_bagiantambahprodukpaketbonus1").append(copy);

				$("body").on("click", "#buttonhapusprodukpaket" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					var hargaDihapus = $("#edit_harga_produk" + i).val();
					var hargaModal = $("#edit_harga_modal").val();

					$("#edit_harga_modal").val(
						parseInt(hargaModal) - parseInt(hargaDihapus)
					);

					$(this)
						.parents("#bagianhapusproduk" + i)
						.remove();
				});

				$(".select2produkpaket" + i).select2({
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

				$(".select2produkpaket" + i).on("select2:select", function (e) {
					var harga = e.params.data.harga;
					var maxGroupbarang = $("#jmlbarang").val();
					$("#edit_harga_produk" + i).val(harga);
					var qty = $("#qtypaket" + i).val();

					if (qty != "") {
						if (isNaN(qty)) qty = 0;
						$("#edit_harga_produk" + i).val(harga * qty);
					} else {
						$("#edit_harga_produk" + i).val(harga);
						$("#edit_harga_produkk" + i).val(harga);
					}

					var dataModal = [];

					for (let j = 1; j <= maxGroupbarang; j++) {
						var obj = {};
						obj = $("#edit_harga_produk" + j).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataModal.push(obj);
					}

					var myTotalModal = 0;

					for (var j = 0, len = dataModal.length; j < len; j++) {
						myTotalModal += parseInt(dataModal[j]);
					}

					$("#edit_harga_modal").val(myTotalModal);
				});

				$("#qtypaket" + i).keyup(function () {
					var maxGroupbarang = $("#jmlbarang").val();
					var qty = $("#qtypaket" + i).val();
					var hargaProduk = $("#edit_harga_produkk" + i).val();

					$("#edit_harga_produk" + i).val(qty * hargaProduk);

					var dataModal = [];

					for (let j = 1; j <= maxGroupbarang; j++) {
						var obj = {};
						obj = $("#edit_harga_produk" + j).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataModal.push(obj);
					}

					var myTotalModal = 0;

					for (var j = 0, len = dataModal.length; j < len; j++) {
						myTotalModal += parseInt(dataModal[j]);
					}

					$("#edit_harga_modal").val(myTotalModal);
				});

				$(".input-rupiah-mask" + i).inputmask({
					alias: "numeric",
					groupSeparator: ",",
					autoGroup: true,
					digits: 0,
					digitsOptional: false,
					prefix: "Rp ",
					placeholder: "0",
					rightAlign: false,
					autoUnmask: true,
					removeMaskOnSubmit: true,
				});

				$("#harga_promo" + i).keyup(function () {
					var harga_promo = parseInt($("#harga_promo" + i).val());
					var harga_produk = parseInt($("#harga_produk" + i).val());
					if (harga_promo > harga_produk) {
						$(".error-data1").html(
							"Harga Promo tidak bisa lebih dari Harga Menu."
						);
						$(".flash-data1").html("");
						toast();
						$("#harga_promo" + i).val(0);
					}
				});
			}
		}
	});

	$("#editbuttontambahprodukgrosir").click(function () {
		var looping = parseInt($("#edit_jmlbarang1").val()) + 1;
		var record = $("#edit_jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#edit_jmlbarang1").val(looping);
			$("#edit_jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#edit_jmlbarangplus").val());
			var indexMinus = parseInt($("#edit_jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#edit_jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#edit_jmlbarangplus").val(i);

				copy =
					'<div id="bagianhapusproduk' +
					i +
					'"><div class="row"><div class="col-md-4 col-xs-4 col-4"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2produkgrosir' +
					i +
					'" id="promo_produk' +
					i +
					'" required><option value="">Pilih Produk</option></select></div></div><div class="col-md-3 col-xs-3 col-3"><label for="harga_produk">Harga Menu</label><div class="input-group"><input type="text" class="form-control input-rupiah-mask' +
					i +
					'" name="harga_produk[]" id="harga_produk' +
					i +
					'" placeholder="Harga Menu" readonly required><input type="hidden" class="form-control input-rupiah-mask' +
					i +
					'" id="harga_produkk' +
					i +
					'" placeholder="Harga Menu" readonly required></div></div><div class="col-md-1 col-xs-1 col-1"><label>QTY</label><input type="text" class="form-control" name="qty[]" id="qtypaket' +
					i +
					'" placeholder="QTY" required></div><div class="col-md-3 col-xs-3 col-3"><label for="harga_produk">Harga Grosir</label><div class="input-group"><input type="text" class="form-control input-rupiah-mask' +
					i +
					'" name="harga_grosir[]" id="harga_grosir' +
					i +
					'" placeholder="Harga Grosir" required><span class="input-group-append"><button type="button" class="btn btn-info btn-flat" id="eujrohpaketan' +
					i +
					'"><i class="fas fa-dollar-sign"></i> </button></span></div></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusprodukpaket' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$("#edit_bagiantambahprodukpaket").append(copy);

				text =
					'<div id="bagianhapusmodalproduk' +
					i +
					'"><div class="modal fade" id="Modal_ujroh_paketan' +
					i +
					'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">Detail Promo</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="row"><div class="col-xs-6 col-md-6"><div class="form-group"><label for="">Jumlah Ujroh Selera</label><input type="text" name="ujroh_selera[]" id="ujroh_selera' +
					i +
					'" class="form-control input-rupiah-mask' +
					i +
					'"></div></div><div class="col-xs-6 col-md-6"><div class="form-group"><label for="">Jumlah Ujroh Reseller</label><input type="text" name="ujroh[]" id="ujroh' +
					i +
					'" class="form-control input-rupiah-mask' +
					i +
					'"></div></div></div></div></div></div></div></div>';

				$(".edit-tmpt-ujroh-grosir").append(text);

				$("body").on("click", "#buttonhapusprodukpaket" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					var hargaDihapus = parseInt($("#edit_harga_produk" + i).val());
					var hargaModal = parseInt($("#edit_harga_modal").val());

					if (isNaN(hargaDihapus)) hargaDihapus = 0;
					if (isNaN(hargaModal)) hargaModal = 0;

					$("#edit_harga_modal").val(
						parseInt(hargaModal) - parseInt(hargaDihapus)
					);

					$(this)
						.parents("#bagiantambahprodukpaket" + i)
						.remove();

					$(this)
						.parents("#bagiantambahujrohprodukpaket" + i)
						.remove();
				});

				$("#eujrohpaketan" + i).click(function () {
					var promo_produk = $("#edit_promo_produk" + i).val();
					if (promo_produk == "") {
						Toast.fire({
							icon: "error",
							title: "Produk Harus Dipilih Terlebih Dahulu",
						});
					} else {
						$("#Modal_ujroh_paketan" + i).modal("show");
					}
				});

				$(".select2produkgrosir" + i).select2({
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

				$(".select2produkgrosir" + i).on("select2:select", function (e) {
					var harga = e.params.data.harga;
					var ujroh = e.params.data.jmlKomisi;
					var ujrohSelera = e.params.data.jmlKomisiSelera;
					var maxGroupbarang = $("#jmlbarang").val();
					$("#harga_produk" + i).val(harga);
					var qty = $("#qtypaket" + i).val();

					$("#harga_produk" + i).val(harga);
					$("#harga_produkk" + i).val(harga);

					$("#hid_ujroh" + i).val(ujroh);
					$("#hid_ujroh_selera" + i).val(ujrohSelera);
					$("#ujroh" + i).val(ujroh);
					$("#ujroh_selera" + i).val(ujrohSelera);

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

				$("#edit_qtypaket" + i).keyup(function () {
					var maxGroupbarang = $("#jmlbarang").val();
					var qty = $("#edit_qtypaket" + i).val();
					var hargaProduk = $("#edit_harga_produkk" + i).val();
					var ujroh = $("#hid_ujroh" + i).val();
					var ujrohSelera = $("#hid_ujroh_selera" + i).val();

					$("#edit_harga_produk" + i).val(qty * hargaProduk);

					var dataModal = [];

					for (let j = 1; j <= maxGroupbarang; j++) {
						var obj = {};
						obj = $("#edit_harga_produk" + j).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						dataModal.push(obj);
					}

					var myTotalModal = 0;

					for (var j = 0, len = dataModal.length; j < len; j++) {
						myTotalModal += parseInt(dataModal[j]);
					}

					$("#ujroh" + i).val(parseInt(qty) * parseInt(ujroh));
					$("#ujroh_selera" + i).val(parseInt(qty) * parseInt(ujrohSelera));

					$("#edit_harga_modal").val(myTotalModal);
				});

				$(".input-rupiah-mask" + i).inputmask({
					alias: "numeric",
					groupSeparator: ",",
					autoGroup: true,
					digits: 0,
					digitsOptional: false,
					prefix: "Rp ",
					placeholder: "0",
					rightAlign: false,
					autoUnmask: true,
					removeMaskOnSubmit: true,
				});

				$("#harga_promo" + i).keyup(function () {
					var harga_promo = parseInt($("#harga_promo" + i).val());
					var harga_produk = parseInt($("#harga_produk" + i).val());
					if (harga_promo > harga_produk) {
						$(".error-data1").html(
							"Harga Promo tidak bisa lebih dari Harga Menu."
						);
						$(".flash-data1").html("");
						toast();
						$("#harga_promo" + i).val(0);
					}
				});
			}
		}
	});

	$("#editbuttontambahprodukbonus").click(function () {
		var looping = parseInt($("#edit_jmlbarangbonus1").val()) + 1;
		var record = $("#edit_jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#edit_jmlbarangbonus1").val(looping);
			$("#edit_jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#edit_jmlbarangplusbonus").val());
			var indexMinus = parseInt($("#edit_jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#edit_jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#edit_jmlbarangplusbonus").val(i);

				var copy =
					'<div id="bagianhapusbonus' +
					i +
					'"><div class="row"><div class="col-md-8 col-xs-8 col-8"><div class="form-group"><label>Produk</label><select name="produk_bonus[]" class="form-control select2produkbonus' +
					i +
					'" id="promo_produk' +
					i +
					'" required><option value="">Pilih Produk</option></select></div></div><div class="col-md-3 col-xs-3 col-3"><label>QTY</label><input type="text" class="form-control" name="qty_bonus[]" id="qtybonus' +
					i +
					'" placeholder="QTY" required></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusprodukbonus' +
					i +
					'"><i class="fa fa-minus"></i></a></div></div></div>';

				$("#edit_bagiantambahprodukbonus1").append(copy);

				$("body").on("click", "#buttonhapusprodukbonus" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					var hargaDihapus = $("#edit_harga_produk" + i).val();
					var hargaModal = $("#edit_harga_modal").val();

					$("#edit_harga_modal").val(
						parseInt(hargaModal) - parseInt(hargaDihapus)
					);

					$(this)
						.parents("#bagianhapusbonus" + i)
						.remove();
				});

				$(".select2produkbonus" + i).select2({
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

				$("#harga_promo" + i).keyup(function () {
					var harga_promo = parseInt($("#harga_promo" + i).val());
					var harga_produk = parseInt($("#harga_produk" + i).val());
					if (harga_promo > harga_produk) {
						$(".error-data1").html(
							"Harga Promo tidak bisa lebih dari Harga Menu."
						);
						$(".flash-data1").html("");
						toast();
						$("#harga_promo" + i).val(0);
					}
				});
			}
		}
	});

	$(".buttontambahongkirkhususedit").click(function () {
		var looping = parseInt($("#edit_jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#edit_jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#edit_jmlbarangplus").val());
			var indexMinus = parseInt($("#edit_jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i == 1) continue;
				if (i != looping) continue;
				indexMinus = i;
				$("#edit_jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#edit_jmlbarangplus").val(i);

				var copy =
					'<div id="bagianhapusongkirkhusus' +
					i +
					'"><div class="row mt-3"><div class="col-md-3 col-12"><label for="judul_ongkir">Piih Kota</label><select name="kabupaten[]" id="kabupaten_edit' +
					i +
					'" class="form-control select2kota' +
					i +
					'"></select></div><div class="col-md-3 col-12"><label for="judul_ongkir">Pilih Kecamatan</label><select name="kecamatan[]" id="kecamatan_edit' +
					i +
					'" class="form-control select2kecamatan' +
					i +
					'"></select></div><div class="col-md-5 col-12"><label for="judul_ongkir">Pilih Kelurahan (Optional)</label><select name="kelurahan[]" id="kelurahan_edit' +
					i +
					'" class="form-control select2multiple-kelurahan' +
					i +
					'" multiple="multiple"></select></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusprodukpaketbonus' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$(".bagiantambahongkirkhususs").append(copy);

				$("body").on("click", "#buttonhapusprodukpaketbonus" + i, function () {
					$("#edit_jmlbarang1").val(parseInt($("#edit_jmlbarang1").val()) - 1);

					var hargaDihapus = $("#harga_produk" + i).val();
					var hargaModal = $("#harga_modal").val();

					$("#harga_modal").val(parseInt(hargaModal) - parseInt(hargaDihapus));

					$(this)
						.parents("#bagianhapusongkirkhusus" + i)
						.remove();
				});

				$(".select2kota" + i).select2({
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

				$(".select2kecamatan" + i).select2({
					placeholder: "Pilih Kecamatan",
					ajax: {
						url: base_url + "/order/get_json_kecamatan",
						type: "post",
						dataType: "json",
						delay: 100,
						data: function (params) {
							return {
								kabupaten: $("#kabupaten_edit" + i).val(),
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

				$(".select2multiple-kelurahan" + i).select2({
					placeholder: "Pilih Kelurahan",
					ajax: {
						url: base_url + "/order/get_json_kelurahan",
						type: "post",
						dataType: "json",
						delay: 100,
						data: function (params) {
							return {
								kabupaten: $("#kabupaten_edit" + i).val(),
								kecamatan: $("#kecamatan_edit" + i).val(),
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
			}
		}
	});

	$(".buttontambahreportkhusus").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				var copy =
					'<div id="bagianhapusongkirkhusus' +
					i +
					'"><div class="row mt-3"><div class="col-md-5 col-12"><label for="judul_ongkir">Pilih Kategori</label><select name="kategori[]" id="kategori' +
					i +
					'" class="form-control select2kategori' +
					i +
					'"></select></div><div class="col-md-6 col-12"><label for="judul_ongkir">Pilih Sub Kategori</label><select name="sub_kategori[]" id="subkategori' +
					i +
					'" class="form-control select2multiple-sub_kategori' +
					i +
					'" multiple="multiple"></select></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusreportkhusus' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$(".bagiantambahreportkhusus").append(copy);

				$("body").on("click", "#buttonhapusreportkhusus" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					var hargaDihapus = $("#harga_produk" + i).val();
					var hargaModal = $("#harga_modal").val();

					$("#harga_modal").val(parseInt(hargaModal) - parseInt(hargaDihapus));

					$(this)
						.parents("#bagianhapusongkirkhusus" + i)
						.remove();
				});

				$(".select2kategori" + i).select2({
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

				$(".select2multiple-sub_kategori" + i).select2({
					placeholder: "Pilih Sub Kategori",
					ajax: {
						url: base_url + "/kategori/get_json_multi_sub_kategori",
						type: "post",
						dataType: "json",
						delay: 100,
						data: function (params) {
							var kategori =
								$("#kategori" + i).val() ?? $("#kategori_edit" + i).val();
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
			}
		}
	});

	$(".buttontambahongkirkhusus").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				var copy =
					'<div id="bagianhapusongkirkhusus' +
					i +
					'"><div class="row mt-3"><div class="col-md-3 col-12"><label for="judul_ongkir">Piih Kota</label><select name="kabupaten[]" id="kabupaten' +
					i +
					'" class="form-control select2kota' +
					i +
					'"></select></div><div class="col-md-3 col-12"><label for="judul_ongkir">Pilih Kecamatan</label><select name="kecamatan[]" id="select2kecamatan' +
					i +
					'" class="form-control"></select></div><div class="col-md-5 col-12"><label for="judul_ongkir">Pilih Kelurahan (Optional)</label><select name="kelurahan[]" id="kelurahan' +
					i +
					'" class="form-control select2multiple-kelurahan' +
					i +
					'" multiple="multiple"></select></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusprodukpaketbonus' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$(".bagiantambahongkirkhusus").append(copy);

				$("body").on("click", "#buttonhapusprodukpaketbonus" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					var hargaDihapus = $("#harga_produk" + i).val();
					var hargaModal = $("#harga_modal").val();

					$("#harga_modal").val(parseInt(hargaModal) - parseInt(hargaDihapus));

					$(this)
						.parents("#bagianhapusongkirkhusus" + i)
						.remove();
				});

				$(".select2kota" + i).select2({
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

				$("#select2kecamatan" + i).select2({
					placeholder: "Pilih Kecamatan",
					ajax: {
						url: base_url + "/order/get_json_kecamatan",
						type: "post",
						dataType: "json",
						delay: 100,
						data: function (params) {
							return {
								kabupaten: $("#kabupaten" + i).val(),
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

				$(".select2multiple-kelurahan" + i).select2({
					placeholder: "Pilih Kelurahan",
					ajax: {
						url: base_url + "/order/get_json_kelurahan",
						type: "post",
						dataType: "json",
						delay: 100,
						data: function (params) {
							return {
								kabupaten: $("#kabupaten" + i).val(),
								kecamatan: $("#select2kecamatan" + i).val(),
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
			}
		}
	});

	$("#buttontambahprodukpaketbonus").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				var copy =
					'<div id="bagianhapusprodukbonus' +
					i +
					'"><div class="row"><div class="col-md-6 col-xs-6 col-6"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2produkpaket' +
					i +
					'" id="promo_produk' +
					i +
					'" required><option value="">Pilih Produk</option></select></div></div><div class="col-md-2 col-xs-2 col-2"><label>QTY</label><input type="text" class="form-control" name="qty[]" id="qtypaket' +
					i +
					'" placeholder="QTY" required></div><div class="col-md-3 col-xs-3 col-3"><label>Harga Menu</label><input type="text" class="form-control input-rupiah-mask' +
					i +
					'" name="harga_produk[]" id="harga_produk' +
					i +
					'" placeholder="Harga Menu" readonly required><input type="hidden" class="form-control input-rupiah-mask' +
					i +
					'" id="harga_produkk' +
					i +
					'" placeholder="Harga Menu" readonly required></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusprodukpaketbonus' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$("#bagiantambahprodukpaket").append(copy);

				$("body").on("click", "#buttonhapusprodukpaketbonus" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					var hargaDihapus = $("#harga_produk" + i).val();
					var hargaModal = $("#harga_modal").val();

					$("#harga_modal").val(parseInt(hargaModal) - parseInt(hargaDihapus));

					$(this)
						.parents("#bagianhapusprodukbonus" + i)
						.remove();
				});

				$(".select2produkpaket" + i).select2({
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

				$(".select2produkpaket" + i).on("select2:select", function (e) {
					var harga = e.params.data.harga;
					var maxGroupbarang = $("#jmlbarang").val();
					$("#harga_produk" + i).val(harga);
					var qty = $("#qtypaket" + i).val();

					if (qty != "") {
						if (isNaN(qty)) qty = 0;
						$("#harga_produk" + i).val(harga * qty);
					} else {
						$("#harga_produk" + i).val(harga);
						$("#harga_produkk" + i).val(harga);
					}

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

				$("#qtypaket" + i).keyup(function () {
					var maxGroupbarang = $("#jmlbarang").val();
					var qty = $("#qtypaket" + i).val();
					var hargaProduk = $("#harga_produkk" + i).val();

					$("#harga_produk" + i).val(qty * hargaProduk);

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

				$(".input-rupiah-mask" + i).inputmask({
					alias: "numeric",
					groupSeparator: ",",
					autoGroup: true,
					digits: 0,
					digitsOptional: false,
					prefix: "Rp ",
					placeholder: "0",
					rightAlign: false,
					autoUnmask: true,
					removeMaskOnSubmit: true,
				});

				$("#harga_promo" + i).keyup(function () {
					var harga_promo = parseInt($("#harga_promo" + i).val());
					var harga_produk = parseInt($("#harga_produk" + i).val());
					if (harga_promo > harga_produk) {
						$(".error-data1").html(
							"Harga Promo tidak bisa lebih dari Harga Menu."
						);
						$(".flash-data1").html("");
						toast();
						$("#harga_promo" + i).val(0);
					}
				});
			}
		}
	});

	$("#buttontambahprodukbonus").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				var copy =
					'<div id="bagianhapusbonus' +
					i +
					'"><hr><div class="row"><div class="col-md-8 col-xs-8 col-8"><div class="form-group"><label>Produk</label><select name="produk_bonus[]" class="form-control select2produkbonus' +
					i +
					'" id="promo_produk' +
					i +
					'" required><option value="">Pilih Produk</option></select></div></div><div class="col-md-3 col-xs-3 col-3"><label>QTY</label><input type="text" class="form-control" name="qty_bonus[]" id="qtybonus' +
					i +
					'" placeholder="QTY" required></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="bagiantambahprodukbonus' +
					i +
					'"><i class="fa fa-minus"></i></a></div></div></div>';
				$("#bagiantambahprodukbonus").append(copy);

				$("body").on("click", "#bagiantambahprodukbonus" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					$(this)
						.parents("#bagianhapusbonus" + i)
						.remove();
				});

				$(".select2produkbonus" + i).select2({
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

				$(".input-rupiah-mask" + i).inputmask({
					alias: "numeric",
					groupSeparator: ",",
					autoGroup: true,
					digits: 0,
					digitsOptional: false,
					prefix: "Rp ",
					placeholder: "0",
					rightAlign: false,
					autoUnmask: true,
					removeMaskOnSubmit: true,
				});
			}
		}
	});

	$("#buttontambahprodukGrosir").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				var copy =
					'<div id="bagianhapusproduk' +
					i +
					'"><div class="row"><div class="col-md-4 col-xs-4 col-4"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2produkgrosir' +
					i +
					'" id="promo_produk' +
					i +
					'" required><option value="">Pilih Produk</option></select></div></div><div class="col-md-3 col-xs-3 col-3"><label for="harga_produk">Harga Menu</label><div class="input-group"><input type="text" class="form-control input-rupiah-mask' +
					i +
					'" name="harga_produk[]" id="harga_produk' +
					i +
					'" placeholder="Harga Menu" readonly required><input type="hidden" class="form-control input-rupiah-mask' +
					i +
					'" id="harga_produkk' +
					i +
					'" placeholder="Harga Menu" readonly required></div></div><div class="col-md-1 col-xs-1 col-1"><label>QTY</label><input type="text" class="form-control" name="qty[]" id="qtypaket' +
					i +
					'" placeholder="QTY" required></div><div class="col-md-3 col-xs-3 col-3"><label for="harga_produk">Harga Grosir</label><div class="input-group"><input type="text" class="form-control input-rupiah-mask' +
					i +
					'" name="harga_grosir[]" id="harga_grosir' +
					i +
					'" placeholder="Harga Grosir" required><span class="input-group-append"><button type="button" class="btn btn-info btn-flat" id="eujrohpaketan' +
					i +
					'"><i class="fas fa-dollar-sign"></i> </button></span></div></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusprodukpaket' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$("#bagiantambahprodukpaket").append(copy);

				var copy1 =
					'<div id="bagianhapusmodalproduk' +
					i +
					'"><div class="modal fade" id="Modal_ujroh_paketan' +
					i +
					'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">Detail Promo</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="row"><div class="col-xs-6 col-md-6"><div class="form-group"><label for="">Jumlah Ujroh Selera</label><input type="text" name="ujroh_selera[]" id="ujroh_selera' +
					i +
					'" class="form-control rupiah-mask"><input type="hidden" id="hid_ujroh_selera' +
					i +
					'" class="form-control rupiah-mask" readonly><input type="hidden" id="hid_ujroh' +
					i +
					'" class="form-control rupiah-mask" readonly></div></div><div class="col-xs-6 col-md-6"><div class="form-group"><label for="">Jumlah Ujroh Reseller</label><input type="text" name="ujroh[]" id="ujroh' +
					i +
					'" class="form-control rupiah-mask"></div></div></div></div></div></div></div></div>';
				$(".edit-tmpt-ujroh-paket").append(copy1);

				$("#eujrohpaketan" + i).click(function () {
					var promo_produk = $("#promo_produk" + i).val();
					if (promo_produk == "") {
						Toast.fire({
							icon: "error",
							title: "Produk Harus Dipilih Terlebih Dahulu",
						});
					} else {
						$("#Modal_ujroh_paketan" + i).modal("show");
					}
				});

				$("body").on("click", "#buttonhapusprodukpaket" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					var hargaDihapus = parseInt($("#harga_produk" + i).val());
					var hargaModal = parseInt($("#harga_modal").val());

					if (isNaN(hargaDihapus)) hargaDihapus = 0;
					if (isNaN(hargaModal)) hargaModal = 0;

					$("#harga_modal").val(parseInt(hargaModal) - parseInt(hargaDihapus));

					$("#Modal_ujroh_paketan" + i).remove();

					$(this)
						.parents("#bagianhapusproduk" + i)
						.remove();

					$(this)
						.parents("#bagianhapusmodalproduk" + i)
						.remove();
				});

				$(".input-rupiah-mask" + i).inputmask({
					alias: "numeric",
					groupSeparator: ",",
					autoGroup: true,
					digits: 0,
					digitsOptional: false,
					prefix: "Rp ",
					placeholder: "0",
					rightAlign: false,
					autoUnmask: true,
					removeMaskOnSubmit: true,
				});

				$(".select2produkgrosir" + i).select2({
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

				$(".select2produkgrosir" + i).on("select2:select", function (e) {
					var harga = e.params.data.harga;
					var ujroh = e.params.data.jmlKomisi;
					var ujrohSelera = e.params.data.jmlKomisiSelera;
					var maxGroupbarang = $("#jmlbarang").val();
					$("#harga_produk" + i).val(harga);
					var qty = $("#qtypaket" + i).val();

					$("#harga_produk" + i).val(harga);
					$("#harga_produkk" + i).val(harga);

					$("#hid_ujroh" + i).val(ujroh);
					$("#hid_ujroh_selera" + i).val(ujrohSelera);
					$("#ujroh" + i).val(ujroh);
					$("#ujroh_selera" + i).val(ujrohSelera);

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

				$(".input-rupiah-mask" + i).inputmask({
					alias: "numeric",
					groupSeparator: ",",
					autoGroup: true,
					digits: 0,
					digitsOptional: false,
					prefix: "Rp ",
					placeholder: "0",
					rightAlign: false,
					autoUnmask: true,
					removeMaskOnSubmit: true,
				});

				$("#harga_promo" + i).keyup(function () {
					var harga_promo = parseInt($("#harga_promo" + i).val());
					var harga_produk = parseInt($("#harga_produk" + i).val());
					if (harga_promo > harga_produk) {
						$(".error-data1").html(
							"Harga Promo tidak bisa lebih dari Harga Menu."
						);
						$(".flash-data1").html("");
						toast();
						$("#harga_promo" + i).val(0);
					}
				});
			}
		}
	});

	$("#buttontambahpo").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				var copy =
					'<div id="bagianhapuspo' +
					i +
					'"><div class="row"><div class="col-md-11 col-xs-11 col-11"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2produkpo' +
					i +
					'" id="promo_produk' +
					i +
					'" required><option value="">Pilih Produk</option></select></div></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapuspo' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$("#bagiantambahpo").append(copy);

				$("body").on("click", "#buttonhapuspo" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					$(this)
						.parents("#bagianhapuspo" + i)
						.remove();
				});

				$(".select2produkpo" + i).select2({
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

				$(".select2produk" + i).on("select2:select", function (e) {
					var harga = e.params.data.harga;
					$("#harga_produk" + i).val(harga);
				});

				$(".input-rupiah-mask" + i).inputmask({
					alias: "numeric",
					groupSeparator: ",",
					autoGroup: true,
					digits: 0,
					digitsOptional: false,
					prefix: "Rp ",
					placeholder: "0",
					rightAlign: false,
					autoUnmask: true,
					removeMaskOnSubmit: true,
				});
			}
		}
	});

	$("#buttontambahmember").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				var copy =
					'<div id="bagianhapusmember' +
					i +
					'"><div class="row"><div class="col-md-11 col-xs-10 col-10"><div class="form-group"><select name="member[]" class="form-control select2member' +
					i +
					'" required><option value="">Pilih Member</option></select></div></div><div class="col-md-1 col-xs-1 col-1"><a href="javascript:void(0);" class="btn btn-danger" id="buttonhapusmember' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$("#bagiantambahmember").append(copy);

				$("body").on("click", "#buttonhapusmember" + i, function () {
					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					$(this)
						.parents("#bagianhapusmember" + i)
						.remove();
				});

				$(".select2member" + i).select2({
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

				$(".select2member" + i).on("select2:select", function (e) {
					var text = "";
					var id = e.params.data.id;
					$.ajax({
						url: base_url + "/reseller/getResellerMemberByIdMember",
						type: "post",
						dataType: "json",
						data: {
							kd_member: id,
						},
						success: function (data) {
							if (data.no == 1) {
								// itu ada
								$(".error-data1").html("Member Sudah Terdaftar");
								toast();
								text += "<option value=" + "selected>Pilih Member</option>";
								$(".select2member" + i).html(text);
							}
						},
					});
				});
			}
		}
	});

	$("#buttontambahmemberedit").click(function () {
		var looping = parseInt($("#jmlbarang1edit").val()) + 1;
		var record = $("#jumrecordedit").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1edit").val(looping);
			$("#jumrecordedit").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplusedit").val());
			var indexMinus = parseInt($("#jmlbarangminusedit").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminusedit").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplusedit").val(i);

				var copy =
					'<div id="bagianhapusmember' +
					i +
					'"><div class="row"><div class="col-md-11 col-xs-10 col-10"><div class="form-group"><select name="member[]" class="form-control select2member' +
					i +
					'" required><option value="">Pilih Member</option></select></div></div><div class="col-md-1 col-xs-1 col-1"><a href="javascript:void(0);" class="btn btn-danger" id="buttonhapusmember' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div>';
				$("#bagiantambahmemberedit").append(copy);

				$("body").on("click", "#buttonhapusmember" + i, function () {
					$("#jmlbarang1edit").val(parseInt($("#jmlbarang1edit").val()) - 1);

					$(this)
						.parents("#bagianhapusmember" + i)
						.remove();
				});

				$(".select2member" + i).select2({
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

				$(".select2member" + i).on("select2:select", function (e) {
					var text = "";
					var id = e.params.data.id;
					$.ajax({
						url: base_url + "/reseller/getResellerMemberByIdMember",
						type: "post",
						dataType: "json",
						data: {
							kd_member: id,
						},
						success: function (data) {
							if (data.no == 1) {
								// itu ada
								$(".error-data1").html("Member Sudah Terdaftar");
								toast();
								text += "<option value=" + "selected>Pilih Member</option>";
								$(".select2member" + i).html(text);
							}
						},
					});
				});
			}
		}
	});

	$("#tambahfieldorder").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				var copy =
					'<div id="bagianProdukhapus' +
					i +
					'"><hr id="hr"> <div class="form-group" id="detailProduk"><div class="row"><div class="col-md-4" id="produkk1"><label for="produk1">Nama Menu</label><select class="form-control select2produk' +
					i +
					'" name="produk[]" id="produk' +
					i +
					'" style="width: 100%;" required><option value="Pilih produk">Pilih Produk</option></select></div><div class="col-md-4" id="nominall"><label for="jmlkomisi1">Jumlah Ujroh (U/Reseller)</label><input type="text" name="jmlkomisi[]" id="jmlkomisi' +
					i +
					'" class="form-control rupiah-mask' +
					i +
					'" placeholder="Masukan Nominal" readonly><input type="hidden" name="jmlkomisii[]" id="jmlkomisii' +
					i +
					'" class="form-control" placeholder="Masukan Nominal" readonly></div><div class="col-md-4"><label for="diskon">Diskon</label><input type="text" class="form-control rupiah-mask' +
					i +
					'" name="diskon[]" id="diskon' +
					i +
					'" placeholder="Masukan Diskon" readonly><input type="hidden" class="form-control rupiah-mask' +
					i +
					'" name="diskonn[]" id="diskonn' +
					i +
					'" placeholder="Masukan Diskon" readonly></div></div><div class="row mt-2"><div class="col-md-4"><label for="harga_produk">Harga Menu</label><input type="text" class="form-control rupiah-mask' +
					i +
					'" name="harga_produk[]" id="harga_produk' +
					i +
					'" placeholder="Masukan Produk" readonly required></div><div class="col-md-2" id="stokk"><label for="qty' +
					i +
					'">Qty</label><input type="text" name="qty[]" id="qty' +
					i +
					'" class="form-control" placeholder="Masukan Stok" readonly required></div><div class="col-10 col-md-4"><label for="sub_total' +
					i +
					'">Sub Total</label><input type="text" name="sub_total[]" id="sub_total' +
					i +
					'" class="form-control rupiah-mask' +
					i +
					'" placeholder="Masukan Satuan Kilogram" readonly required></div><div class="col-1 col-md-2"><label for="kd_supplier"></label><br><a href="javascript:void(0)" class="btn btn-danger mt-2" id="hapusfieldorder' +
					i +
					'"> <i class="fa fa-minus"></i> </a></div></div></div></div>';

				$("#bagianProduk").append(copy);

				$(".rupiah-mask" + i).inputmask({
					alias: "numeric",
					groupSeparator: ",",
					autoGroup: true,
					digits: 0,
					digitsOptional: false,
					prefix: "Rp ",
					placeholder: "-1",
					rightAlign: false,
					autoUnmask: true,
					removeMaskOnSubmit: false,
				});

				$("body").on("click", "#hapusfieldorder" + i, function () {
					var subTotal = $("#sub_total" + i).val();
					var diskon = $("#diskon" + i).val();
					var totalHarga = $("#total_harga").val();

					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					$(this)
						.parents("#bagianProdukhapus" + i)
						.remove();

					hitungTotalHargaDariQty();
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
													var diskonn = $("#diskonn" + i).val();
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
														if (qty == 0) {
															$("#diskon" + i).val(diskonn);
														} else {
															$("#diskon" + i).val(diskonn * qty);
														}
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
														if (isNaN(ongkir)) ongkir = 0;
														var diskonTambahan = $("#diskon_tambahan").val();
														if (isNaN(diskonTambahan)) diskonTambahan = 0;
														var totalDiskon =
															parseInt(myTotalDiskon) +
															parseInt(diskonTambahan);
														$("#total_harga").val(
															parseInt(myTotal - totalDiskon) + parseInt(ongkir)
														);
														if (parseInt($("#total_harga").val()) < 0) {
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
										var diskonn = $("#diskonn" + i).val();
										if (data >= parseInt(qty) || $("#qty" + i).val() == "") {
											$("#sub_total" + i).val(hargaProduk * qty);
											$("#jmlkomisi" + i).val(
												qty == 0 ? jmlKomisi : jmlKomisi * qty
											);
											$("#jmlkomisii" + i).val(jmlKomisi);
											var data = [];
											var dataDiskon = [];
											if (qty == 0) {
												$("#diskon" + i).val(diskonn);
											} else {
												$("#diskon" + i).val(diskonn * qty);
											}
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
											if (isNaN(ongkir)) ongkir = 0;
											var diskonTambahan = $("#diskon_tambahan").val();
											if (isNaN(diskonTambahan)) diskonTambahan = 0;
											var totalDiskon =
												parseInt(myTotalDiskon) + parseInt(diskonTambahan);
											$("#total_harga").val(
												parseInt(myTotal - totalDiskon) + parseInt(ongkir)
											);
											if (parseInt($("#total_harga").val()) < 0) {
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

				$("#qty" + i).keyup(function () {
					var kd_produk = $("#produk" + i).val();

					if (kd_produk.substr(0, 2) == "PR") {
						$.ajax({
							url: base_url + "/select2/cekStokProductPromo",
							type: "post",
							dataType: "json",
							data: {
								kd_promo: kd_produk,
							},

							success: function (data) {
								var qty = $("#qty" + i).val();
								var sub_total = $("#sub_total" + i).val();

								if (data >= parseInt(qty) || $("#qty" + i).val() == "") {
									hitungTotalHargaDariQty();
								} else {
									$(".error-data1").html("Stok Tinggal Tersisa " + data);
									$(".flash-data1").html("");
									$("#qty" + i).val("");
									$("#sub_total" + i).val(0);
									toast();
									hitungTotalHargaDariQty();
								}
							},
						});
					} else {
						$.ajax({
							// url: base_url + "/product/getDetailProdukPoById",
							url: base_url + "/product/getProdukById",
							type: "post",
							dataType: "json",
							data: {
								kd_produk: $("#produk" + i).val(),
								tabel: "detail_produk",
							},
							success: function (data) {
								// 		if (data == null || data.jns_produk == "stock") {
								$.ajax({
									url: base_url + "/select2/cekStokProduct",
									type: "post",
									dataType: "json",
									data: {
										kd_detail_produk: $("#produk" + i).val(),
									},

									success: function (stok) {
										var qty = $("#qty" + i).val();
										if (data.jns_produk == "stock") {
											if (stok >= parseInt(qty) || $("#qty" + i).val() == "") {
												if (data.status_grosir == "ya") {
													$.ajax({
														url:
															base_url + "/product/getDetailProdukGrosirById",
														type: "post",
														dataType: "json",
														data: {
															kd_produk: $("#produk" + i).val(),
															tabel: "detail_produk",
														},
														success: function (grosir) {
															if (grosir) {
																if (
																	$("#qty" + i).val() >
																	grosir.min_pembelian_produk
																) {
																	$("#harga_produk" + i).val(
																		grosir.harga_grosir
																	);
																	$("#jmlkomisi" + i).val(
																		grosir.ujroh_grosir_reseller
																	);
																	$("#jmlkomisii" + i).val(
																		grosir.ujroh_grosir_reseller
																	);
																} else {
																	$("#harga_produk" + i).val(data.harga_produk);
																	$("#jmlkomisi" + i).val(data.nominal_komisi);
																	$("#jmlkomisii" + i).val(data.nominal_komisi);
																}
															} else {
																$("#harga_produk" + i).val(data.harga_produk);
																$("#jmlkomisi" + i).val(data.nominal_komisi);
																$("#jmlkomisii" + i).val(data.nominal_komisi);
															}

															hitungTotalHargaDariQty();
														},
													});
												} else {
													hitungTotalHargaDariQty();
												}
											} else {
												$("#harga_produk" + i).val(data.harga_produk);
												$("#jmlkomisi" + i).val(data.nominal_komisi);
												$("#jmlkomisii" + i).val(data.nominal_komisi);
												$(".error-data1").html("Stok Tinggal Tersisa " + stok);
												$(".flash-data1").html("");
												$("#qty" + i).val("");
												$("#diskon" + i).val($("#diskonn" + i).val());
												$("#sub_total" + i).val(0);
												$("#jmlkomisi" + i).val($("#jmlkomisii" + i).val());
												toast();
												hitungTotalHargaDariQty();
											}
										} else {
											if (data.status_grosir == "ya") {
												$.ajax({
													url: base_url + "/product/getDetailProdukGrosirById",
													type: "post",
													dataType: "json",
													data: {
														kd_produk: $("#produk" + i).val(),
														tabel: "detail_produk",
													},
													success: function (grosir) {
														if (grosir) {
															if (
																$("#qty" + i).val() >
																grosir.min_pembelian_produk
															) {
																$("#harga_produk1").val(grosir.harga_grosir);
																$("#jmlkomisi1").val(
																	grosir.ujroh_grosir_reseller
																);
																$("#jmlkomisii1").val(
																	grosir.ujroh_grosir_reseller
																);
															} else {
																$("#harga_produk1").val(data.harga_produk);
																$("#jmlkomisi1").val(data.nominal_komisi);
																$("#jmlkomisii1").val(data.nominal_komisi);
															}
														} else {
															$("#harga_produk1").val(data.harga_produk);
															$("#jmlkomisi1").val(data.nominal_komisi);
															$("#jmlkomisii1").val(data.nominal_komisi);
														}
														hitungTotalHargaDariQty();
													},
												});
											} else {
												hitungTotalHargaDariQty();
											}
										}
									},
								});
								// 	} else if (data.jns_produk == "po") {
								// 		hitungTotalHargaDariQty();
								// 	}
							},
						});
					}
				});

				$("#qty" + i).change(function () {
					$.ajax({
						url: base_url + "/product/getDetailProdukGrosirById",
						type: "post",
						dataType: "json",
						data: {
							kd_produk: $("#produk" + i).val(),
							tabel: "detail_produk",
						},
						success: function (grosir) {
							if (grosir) {
								if ($("#qty" + i).val() > grosir.min_pembelian_produk) {
									$(".flash-data1").html(
										"anda Sudah Membeli Diatas " +
											grosir.min_pembelian_produk +
											" Selamat Anda Menggunakan Harga Grosir"
									);
									$(".error-data1").html("");
									toast();
								}
							}
						},
					});
				});

				function hitungTotalHargaDariQty() {
					var harga = $("#harga_produk" + i).val();
					var diskon = $("#diskon" + i).val();
					var diskonn = $("#diskonn" + i).val();
					var qty = $("#qty" + i).val();
					var jmlkomisi = $("#jmlkomisii" + i).val();
					var maxGroupbarang = $("#jmlbarangplus").val();

					if (harga == "" || harga == undefined) {
						harga = 0;
					}

					if (diskon == "" || diskon == undefined) {
						diskon = 0;
					}

					if (diskonn == "" || diskonn == undefined) {
						diskonn = 0;
					}

					if (qty == "" || qty == undefined) {
						qty = 0;
					}

					if (jmlkomisi == "" || jmlkomisi == undefined) {
						jmlkomisi = 0;
					}

					if (qty == 0) {
						$("#diskon" + i).val(diskonn);
					} else {
						$("#diskon" + i).val(diskonn * qty);
					}

					$("#sub_total" + i).val(
						parseInt(harga * qty) - $("#diskon" + i).val()
					);

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

					var pilihan_kurir = $("#pilihan_kurir_res").val();
					if (pilihan_kurir == undefined) {
						pilihan_kurir = $("#pilihan_kurir").val();
					}
					var jrk = $("#jarak").val();
					var jarak = jrk.replace(" KM", "");

					if (jarak <= parseFloat(5) && pilihan_kurir == "CateringKita") {
						if (myTotal >= 30000) {
							$("#ongkir_utama").val(0);
						} else if (myTotal < 30000) {
							$("#ongkir_utama").val(5000);
						}
					} else if (myTotal >= 100000 && pilihan_kurir == "CateringKita") {
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
					} else if (myTotal < 100000 && pilihan_kurir == "CateringKita") {
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
					setTimeout(() => {
						ongkir = parseInt($("#ongkir_utama").val());
						var pathparts = location.pathname.split("/");
						var link1 = pathparts[2];
						var link2 = pathparts[3];

						if (
							link1 == "linkreseller" ||
							(link1 == "pesanan" && link2 == "reseller_login")
						) {
							ongkir = parseInt($("#ongkir_utama").val());
						}

						if (isNaN(ongkir)) ongkir = 0;
						$("#jmlkomisi" + i).val(parseInt(jmlkomisi) * parseInt(qty));
						var diskonTambahan = $("#diskon_tambahan").val();
						if (isNaN(diskonTambahan)) diskonTambahan = 0;
						var totalDiskon =
							parseInt(myTotalDiskon) + parseInt(diskonTambahan);
						$("#total_harga").val(
							parseInt(myTotal) - parseInt(diskonTambahan) + parseInt(ongkir)
						);
						if ($("#total_harga").val() < 0) {
							$("#total_harga").val(0);
						}
					}, 500);
				}
			}
		} else {
			Toast.fire({
				icon: "error",
				title: "Tidak Bisa Menambah Lagi.",
			});
		}
	});

	$("#tambahfieldprodukpaket").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			var indexPlus = parseInt($("#jmlbarangplus").val());
			var indexMinus = parseInt($("#jmlbarangminus").val());

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;
				indexMinus = i;
				$("#jmlbarangminus").val(indexMinus);
				i = ++indexPlus;
				$("#jmlbarangplus").val(i);

				var copy =
					'<div id="bagianProdukhapus' +
					i +
					'"> <div class="form-group" id="detailProduk"><div class="row"><div class="col-md-4"><label for="produk1">Nama Paket</label><select class="form-control select2productpaket' +
					i +
					'" name="produk[]" id="produk' +
					i +
					'" style="width: 100%;" required><option value="#">Pilih Produk</option></select></div><div class="col-md-3" id="nominall"><label for="jmlkomisi1">Qty</label><input type="text" name="qty[]" id="qty' +
					i +
					'" class="form-control" placeholder="Masukan Nominal"><input type="hidden" name="harga_produk[]" id="harga_produk' +
					i +
					'" class="form-control" placeholder="Masukan Nominal"></div><div class="col-md-3"><label for="harga_produk">Sub Total</label><div class="input-group"><input type="text" class="form-control input-rupiah-mask' +
					i +
					'" name="sub_total[]" id="sub_total' +
					i +
					'" placeholder="Masukan Harga Menu" readonly><span class="input-group-append"><button type="button" class="btn btn-info btn-flat" id="detailprodukpaket' +
					i +
					'"><i class="fas fa-eye"></i> </button></span></div></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusprodukpaket' +
					i +
					'"> <i class="fa fa-minus"></i></a></div></div></div></div>';

				$("#bagianProduk").append(copy);

				$(".rupiah-mask" + i).inputmask({
					alias: "numeric",
					groupSeparator: ",",
					autoGroup: true,
					digits: 0,
					digitsOptional: false,
					prefix: "Rp ",
					placeholder: "-1",
					rightAlign: false,
					autoUnmask: true,
					removeMaskOnSubmit: false,
				});

				$("body").on("click", "#buttonhapusprodukpaket" + i, function () {
					var subTotal = $("#sub_total" + i).val();
					var totalHarga = $("#total_harga").val();

					if (subTotal == "" || subTotal == undefined) {
						subTotal = 0;
					}

					var selisih = parseInt(totalHarga) - parseInt(subTotal);

					$("#total_harga").val(selisih);

					$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

					$(this)
						.parents("#bagianProdukhapus" + i)
						.remove();
				});

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

				$("#qty" + i).keyup(function () {
					$.ajax({
						url: base_url + "/select2/cekStokProductPromo",
						type: "post",
						dataType: "json",
						data: {
							kd_promo: $("#produk" + i).val(),
						},

						success: function (data) {
							var qty = $("#qty" + i).val();

							if (data >= parseInt(qty) || $("#qty" + i).val() == "") {
								hitungTotalHargaDariQtyPaket();
							} else {
								$(".error-data1").html("Stok Tinggal Tersisa " + data);
								$(".flash-data1").html("");
								$("#qty" + i).val("");
								$("#diskon" + i).val($("#diskonn" + i).val());
								$("#sub_total" + i).val(0);
								$("#jmlkomisi" + i).val($("#jmlkomisii" + i).val());
								toast();
							}
						},
					});
				});

				function hitungTotalHargaDariQtyPaket() {
					var harga = $("#harga_produk" + i).val();
					var qty = $("#qty" + i).val();
					var maxGroupbarang = $("#jmlbarang").val();

					if (harga == "" || harga == undefined) {
						harga = 0;
					}

					if (qty == "" || qty == undefined) {
						qty = 0;
					}

					$("#sub_total" + i).val(parseInt(harga * qty));

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

					if (isNaN(ongkir)) ongkir = 0;

					var diskonTambahan = $("#diskon_tambahan").val();

					if (isNaN(diskonTambahan)) diskonTambahan = 0;

					$("#total_harga").val(
						parseInt(myTotal - diskonTambahan) + parseInt(ongkir)
					);
					if (parseInt($("#total_harga").val()) < 0) {
						$("#total_harga").val(0);
					}
				}

				$("#detailprodukpaket" + i).click(function () {
					var kodePaket = $("#produk" + i).val();

					if (kodePaket == "#") {
						$(".error-data1").html("Pilih Produk Terlebih Dahulu !");
						$(".flash-data1").html("");
						toast();
					} else {
						$.ajax({
							url: base_url + "/product/getprodukpaket",
							type: "post",
							dataType: "json",
							data: {
								kode_paket: kodePaket,
							},
							success: function (data) {
								$("#detail-produk-paket").modal("show");
								var html = "";
								for (let i = 0; i < data.length; i++) {
									var j = 1;
									html +=
										"<tr><td>" +
										j +
										"</td><td>" +
										data[i].nm_produk +
										"</td><td>" +
										data[i].qty +
										"</td></tr>";
									j++;
								}
								$("#demo-produk-paket").html(html);
							},
						});
					}
				});
			}
		} else {
			Toast.fire({
				icon: "error",
				title: "Tidak Bisa Menambah Lagi.",
			});
		}
	});

	$("body").on("click", "#checkboxpro", function () {
		var jmlbarang = $("#jmlbarang").val();

		if ($(this).prop("checked") == true) {
			for (let i = 1; i <= jmlbarang; i++) {
				$("#bagianProdukhapus" + i).show();
			}
			$("#detailProduk").show(500);
			$("#stokk").hide(500);
			$("#kms").hide(500);
			$("#stn").hide(500);
			$("#diskonn").hide(500);
			$("#hrg_coret").hide(500);
		} else if ($(this).prop("checked") == false) {
			for (let i = 1; i <= jmlbarang; i++) {
				$("#ukuran" + i).val("");
				$("#jml_ukuran" + i).val("");
				$("#biaya_lebih" + i).val("");

				$("#bagianProdukhapus" + i).hide(500);
			}
			$("#detailProduk").hide(500);
			$("#stokk").show(500);
			$("#kms").show(500);
			$("#stn").show(500);
			$("#diskonn").show(500);
			$("#hrg_coret").show(500);
		}
	});

	//remove fields group

	$("body").on("click", "#deletefieldbarang", function () {
		x--;
		$(this).parents("#form-repeat").remove();
	});

	// membatasi jumlah inputan
	var maxGroupbarang = $("#jmlbarang").val();
	var maxGroupservice = $("#jmlservice").val();
	var batasbarang = maxGroupbarang - 1;

	var x = 1;

	//melakukan proses multiple input
	$("#tambahfieldbarangsec").click(function () {
		var looping = parseInt($("#jmlbarang1").val()) + 1;
		var record = $("#jumrecord").val();

		if (looping <= maxGroupbarang && record != maxGroupbarang) {
			$("#jmlbarang1").val(looping);
			$("#jumrecord").val(parseInt(record) + 1);

			for (let i = looping; i <= looping; i++) {
				if (i != looping) continue;

				var copy =
					'<div id="maintenance" class="mt-2"><div class="row mb-2"><div class="col-md-12"><select name="jenis_maintenance[]" id="jenis_maintenance' +
					i +
					'" class="form-control" required><option value="">Pilih Jenis Maintenance</option><option value="secondary">Secondary</option><option value="service">Service</option><option value="lain-lain">Lain-lain</option></select></div></div><div class="row mb-2 d-none" id="section_service' +
					i +
					'"><div class="col-md-4" id="sectionbar' +
					i +
					'"><select class="form-control select2barsecondary' +
					i +
					'" id="barangsec' +
					i +
					'" name="barang_sec[]" style="width: 100%;"><option value="" selected="selected">Pilih Barang Secondary</option></select></div><div class="col-md-4 d-none" id="sectionser' +
					i +
					'"><input type="text" min="0" max="1000" name="service[]" id="service' +
					i +
					'" class="form-control" placeholder="Service"></div><div class="col-md-3"><input type="text" min="0" max="1000" name="harga[]" id="harga' +
					i +
					'" class="form-control" placeholder="Harga" onkeypress="return hanyaAngka(event)" required readonly></div><div class="col-md-2"><input type="text" min="0" max="1000" name="qty[]" id="qty' +
					i +
					'" class="form-control qty-maintenance' +
					i +
					'" placeholder="Qty" readonly onkeypress="return hanyaAngka(event)" required></div><div class="col-md-3"><input type="text" min="0" max="1000" name="sub_total[]" id="sub_total' +
					i +
					'" class="form-control" placeholder="Sub Total" readonly></div></div><div class="row"><div class="col-md-11"><input type="text" min="0" max="1000" name="keterangan[]" id="keterangan' +
					i +
					'" class="form-control" placeholder="Keterangan"></div><div class="col-md-1"><a href="javascript:void(0)" class="btn btn-danger" id="hapusfieldbarangsec"> <i class="fa fa-minus"></i> </a></div></div></div>';
				$("#fieldawalbarangsec").append(copy);
				$(".select2barsecondary" + i).select2({
					placeholder: "Pilih Barang Secondary",
					ajax: {
						url: base_url + "/admin/barang/get_json_secondary",
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

				$(".select2barsecondary" + i).on("select2:select", function (e) {
					var barlam = $("#barangsec_a").val();
					var bar = $("#barangsec" + i).val();
					if (barlam == bar) {
						Toast.fire({
							icon: "error",
							title: "Barang Tidak Boleh Sama !",
						});
						$("#harga" + i).val(null);
						$("#qty" + i).val(null);
						$("#qty" + i).attr("readonly", true);
						$("#qty" + i).attr("required", true);
						$("#sub_total" + i).val(null);
					} else {
						var hargaModal = e.params.data.harga_modal;
						var hargaJual = e.params.data.harga_jual;
						var stok = e.params.data.stok;
						var maxGroupbarang = $("#jmlbarangplus").val();
						var record = $("#jumrecord").val();
						if (stok == 0) {
							Toast.fire({
								icon: "error",
								title: "Stok Barang Kosong",
							});
							$("#qty" + i).val(null);
							$("#qty" + i).attr("readonly", true);
							$("#harga" + i).val(null);
							$("#sub_total" + i).val(null);
						} else {
							$("#qty" + i).val(1);
							$("#qty" + i).attr("readonly", false);
							$("#harga" + i).val(hargaModal);
							$("#sub_total" + i).val(hargaModal);
						}
					}
					var subTotal = $("#sub_total").val();
					var data = [];

					for (let j = 2; j <= maxGroupbarang; j++) {
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

					var totalHarga = parseInt(myTotal) + parseInt(subTotal);
					$("#total_harga").val("Rp. " + totalHarga.toString());
				});

				$("#qty" + i).on("change", function () {
					var barang = $("#barangsec" + i).val();

					var qty = $("#qty" + i).val();
					$.ajax({
						url: base_url + "/admin/barang/getQtyBarangSec",
						type: "post",
						dataType: "json",
						data: {
							id: barang,
							qty: qty,
							tabel: "secondary",
						},
						success: function (result) {
							if (result.no == 0) {
								Toast.fire({
									icon: "error",
									title: "Stok Hanya Tersisa " + result.qty,
								});
								$("#qty" + i).val(null);
								var hargaModal = $("#harga" + i).val();
								$("#sub_total" + i).val(0);
							}
						},
					});
				});

				$("#qty" + i).keyup(function () {
					var harga = parseInt($("#harga" + i).val());
					var qty = $("#qty" + i).val();
					var total = harga * parseInt(qty);
					var record = $("#jumrecord").val();
					if (!isNaN(total)) {
						$("#sub_total" + i).val(total);
					}

					var subTotal = $("#sub_total").val();

					var data = [];

					if (qty == "") {
						$("#sub_total" + i).val(parseInt(0));
					}

					for (let i = 2; i <= maxGroupbarang; i++) {
						var obj = {};
						obj = $("#sub_total" + i).val();
						if (obj == undefined || obj == "") {
							obj = 0;
						}
						data.push(obj);
					}

					var myTotal = 0;

					for (var a = 0, len = data.length; a < len; a++) {
						myTotal += parseInt(data[a]);
					}
					var totalHarga = parseInt(myTotal) + parseInt(subTotal);
					$("#total_harga").val("Rp. " + totalHarga.toString());
				});

				$("#jenis_maintenance" + i).change(function () {
					var selected_option = $("#jenis_maintenance" + i).val();
					if (selected_option == "secondary") {
						$("#section_service" + i).removeClass("d-none");
						$("#sectionbar" + i).removeClass("d-none");
						$("#sectionser" + i).addClass("d-none");
						$("#barangsec" + i)
							.val(null)
							.trigger("change");
						$("#service" + i).val("");
						$("#harga" + i).attr("readonly", true);
						$("#harga" + i).val("");
						$("#qty" + i).val("");
						$("#sub_total" + i).val("");
					} else if (selected_option == "service") {
						$("#section_service" + i).removeClass("d-none");
						$("#sectionbar" + i).addClass("d-none");
						$("#sectionser" + i).removeClass("d-none");
						$("#barangsec" + i)
							.val(null)
							.trigger("change");
						$("#service" + i).val("");
						$("#harga" + i).val("");
						$("#qty" + i).val("");
						$("#sub_total" + i).val("");
					} else if (selected_option == "lain-lain") {
						$("#section_service" + i).removeClass("d-none");
						$("#sectionbar" + i).addClass("d-none");
						$("#sectionser" + i).removeClass("d-none");
						$("#barangsec" + i)
							.val(null)
							.trigger("change");
						$("#service" + i).val("");
						$("#harga" + i).val("");
						$("#qty" + i).val("");
						$("#sub_total" + i).val("");
					} else {
						$("#section_service" + i).addClass("d-none");
						$("#sectionbar" + i).addClass("d-none");
						$("#sectionser" + i).addClass("d-none");
						$("#barangsec" + i)
							.val(null)
							.trigger("change");
						$("#service" + i).val("");
						$("#harga" + i).val("");
						$("#qty" + i).val("");
						$("#sub_total" + i).val("");
					}
				});

				$("#service" + i).keyup(function () {
					$("#qty" + i).val(1);
					$("#harga" + i).attr("readonly", false);
					$("#qty" + i).attr("readonly", true);
				});
				$("#harga" + i).keyup(function () {
					var validasiAngka = /^[0-9]+$/;
					var qty = $("#qty" + i).val();
					var harga = $("#harga" + i).val();
					var total = qty * harga;
					if (harga.match(validasiAngka)) {
						$("#sub_total" + i).val(total);
					} else {
						$("#sub_total" + i).val(0);
					}
				});

				$("#keterangan" + i).keyup(function () {
					var validasiAngka = /^[0-9]+$/;
					var harga = $("#harga" + i).val();
					if (!harga.match(validasiAngka)) {
						$("#harga" + i).val("Harus Berupa Angka");
					}
				});
			}
		} else {
			Toast.fire({
				icon: "error",
				title: "Tidak Bisa Menambah Lagi.",
			});
		}
	});

	//remove fields group
	$("body").on("click", "#hapusfieldbarangsec", function () {
		$("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);
		$(this).parents("#maintenance").remove();
	});
	$("body").on("click", "#deletefieldbarang", function () {
		$(this).parents("#form-repeat").remove();
	});
	$("body").on("click", "#deletefieldbarangsec", function () {
		$(this).parents("#maintenance").remove();
	});

	var record = $("#jumrecord").val();
	for (let i = 1; i <= record; i++) {
		$("#ebarang" + i).on("select2:select", function (e) {
			var harga = e.params.data.harga;
			var maxGroupbarang = $("#jmlbarangplus").val();
			$("#eqty" + i).val(1);
			$("#eqty" + i).attr("readonly", false);
			$("#eharga" + i).val(harga);
			$("#esub_total" + i).val(harga);

			var subTotal = $("#sub_total").val();
			var data = [];
			var data1 = [];

			for (let j = 1; j <= record; j++) {
				var obj = {};
				obj = $("#esub_total" + j).val();
				if (obj == undefined || obj == "") {
					obj = 0;
				}
				data.push(obj);
			}
			for (let i = 2; i <= maxGroupbarang; i++) {
				var obj = {};
				obj = $("#sub_total" + i).val();
				if (obj == undefined || obj == "") {
					obj = 0;
				}
				data1.push(obj);
			}

			var myTotal = 0;
			var myTotal1 = 0;
			for (var j = 0, len = data.length; j < len; j++) {
				myTotal += parseInt(data[j]);
			}
			for (var j = 0, len = data1.length; j < len; j++) {
				myTotal1 += parseInt(data1[j]);
			}
			if (!isNaN(myTotal1)) {
				var totalHarga = parseInt(myTotal);
				$("#etotal_harga").val("Rp. " + totalHarga.toString());
			}
			var totalHarga = parseInt(myTotal + myTotal1);
			$("#etotal_harga").val("Rp. " + totalHarga.toString());
			// var totalHarga = parseInt(myTotal) + parseInt(subTotal);
		});

		$("#eqty" + i).keyup(function () {
			var harga = parseInt($("#eharga" + i).val());
			var qty = $("#eqty" + i).val();
			var total = harga * parseInt(qty);
			var maxGroupbarang = $("#jmlbarangplus").val();
			if (!isNaN(total)) {
				$("#esub_total" + i).val(total);
			}

			var subTotal = $("#sub_total").val();

			var data = [];
			var data1 = [];

			if (qty == "") {
				$("#esub_total" + i).val(parseInt(0));
			}
			if (qty == "") {
				$("#sub_total" + i).val(parseInt(0));
			}

			for (let i = 1; i <= record; i++) {
				var obj = {};
				obj = $("#esub_total" + i).val();
				if (obj == undefined || obj == "") {
					obj = 0;
				}
				data.push(obj);
			}

			for (let i = 2; i <= maxGroupbarang; i++) {
				var obj = {};
				obj = $("#sub_total" + i).val();
				if (obj == undefined || obj == "") {
					obj = 0;
				}
				data1.push(obj);
			}

			var myTotal = 0;
			var myTotal1 = 0;

			for (var a = 0, len = data.length; a < len; a++) {
				myTotal += parseInt(data[a]);
			}
			for (var a = 0, len = data1.length; a < len; a++) {
				myTotal1 += parseInt(data1[a]);
			}
			if (!isNaN(myTotal1)) {
				var totalHarga = parseInt(myTotal);
				$("#etotal_harga").val("Rp. " + totalHarga.toString());
			}
			var totalHarga = parseInt(myTotal + myTotal1);
			$("#etotal_harga").val("Rp. " + totalHarga.toString());
		});
	}

	var record = $("#jumrecord").val();
	for (let i = 1; i <= record; i++) {
		$("#ebarangsec" + i).on("select2:select", function (e) {
			var harga = e.params.data.harga_modal;
			var stok = e.params.data.stok;
			var maxGroupbarang = $("#jmlbarangplus").val();
			if (stok == 0) {
				Toast.fire({
					icon: "error",
					title: "Stok Barang Kosong",
				});
				$("#eqty" + i).val(null);
				$("#eqty" + i).attr("readonly", true);
				$("#eharga" + i).val(null);
				$("#esub_total" + i).val(null);
			} else {
				$("#eqty" + i).val(1);
				$("#eqty" + i).attr("readonly", false);
				$("#eharga" + i).val(harga);
				$("#esub_total" + i).val(harga);
			}

			var subTotal = $("#sub_total").val();
			var data = [];
			var data1 = [];

			for (let j = 1; j <= record; j++) {
				var obj = {};
				obj = $("#esub_total" + j).val();
				if (obj == undefined || obj == "") {
					obj = 0;
				}
				data.push(obj);
			}
			for (let i = 2; i <= maxGroupbarang; i++) {
				var obj = {};
				obj = $("#sub_total" + i).val();
				if (obj == undefined || obj == "") {
					obj = 0;
				}
				data1.push(obj);
			}

			var myTotal = 0;
			var myTotal1 = 0;
			for (var j = 0, len = data.length; j < len; j++) {
				myTotal += parseInt(data[j]);
			}
			for (var j = 0, len = data1.length; j < len; j++) {
				myTotal1 += parseInt(data1[j]);
			}
			if (!isNaN(myTotal1)) {
				var totalHarga = parseInt(myTotal);
				$("#etotal_harga").val("Rp. " + totalHarga.toString());
			}
			var totalHarga = parseInt(myTotal + myTotal1);
			$("#etotal_harga").val("Rp. " + totalHarga.toString());
			// var totalHarga = parseInt(myTotal) + parseInt(subTotal);
		});

		$("#eqty" + i).on("change", function () {
			var barang = $("#ebarangsec" + i).val();
			var qtylama = $("#eqtylama" + i).val();
			var qty1 = $("#eqty" + i).val();
			var baranglama = $("#ekdbaranglama" + i).val();
			var ceklokasi = $("#ceklokasi").val();
			if (ceklokasi == null) {
				if (barang == baranglama) {
					var qty = parseInt(qty1) - parseInt(qtylama);
				} else {
					var qty = parseInt(qty1);
				}
				$.ajax({
					url: base_url + "/admin/barang/getQtyBarangSec",
					type: "post",
					dataType: "json",
					data: {
						id: barang,
						qty: qty,
						tabel: "secondary",
					},
					success: function (result) {
						if (barang == baranglama) {
							var hasil = parseInt(result.qty) + parseInt(qtylama);
						} else {
							var hasil = result.qty;
						}
						if (result.no == 0) {
							Toast.fire({
								icon: "error",
								title: "Stok Hanya Tersisa " + hasil,
							});
							$("#eqty" + i).val(null);
							var hargaModal = $("#harga_a").val();
							$("#esub_total" + i).val(0);
						}
					},
				});
			}
		});

		$("#eqty" + i).keyup(function () {
			var harga = parseInt($("#eharga" + i).val());
			var qty = $("#eqty" + i).val();
			var total = harga * parseInt(qty);
			var maxGroupbarang = $("#jmlbarangplus").val();
			if (!isNaN(total)) {
				$("#esub_total" + i).val(total);
			}

			var subTotal = $("#sub_total").val();

			var data = [];
			var data1 = [];

			if (qty == "") {
				$("#esub_total" + i).val(parseInt(0));
			}
			if (qty == "") {
				$("#sub_total" + i).val(parseInt(0));
			}

			for (let i = 1; i <= record; i++) {
				var obj = {};
				obj = $("#esub_total" + i).val();
				if (obj == undefined || obj == "") {
					obj = 0;
				}
				data.push(obj);
			}

			for (let i = 2; i <= maxGroupbarang; i++) {
				var obj = {};
				obj = $("#sub_total" + i).val();
				if (obj == undefined || obj == "") {
					obj = 0;
				}
				data1.push(obj);
			}

			var myTotal = 0;
			var myTotal1 = 0;

			for (var a = 0, len = data.length; a < len; a++) {
				myTotal += parseInt(data[a]);
			}
			for (var a = 0, len = data1.length; a < len; a++) {
				myTotal1 += parseInt(data1[a]);
			}
			if (!isNaN(myTotal1)) {
				var totalHarga = parseInt(myTotal);
				$("#etotal_harga").val("Rp. " + totalHarga.toString());
			}
			var totalHarga = parseInt(myTotal + myTotal1);
			$("#etotal_harga").val("Rp. " + totalHarga.toString());
		});
		$("#ejenis_maintenance" + i).change(function () {
			var selected_option = $("#ejenis_maintenance" + i).val();
			if (selected_option == "secondary") {
				$("#esection_service" + i).removeClass("d-none");
				$("#esectionbar" + i).removeClass("d-none");
				$("#esectionser" + i).addClass("d-none");
				$("#ebarangsec" + i)
					.val(null)
					.trigger("change");
				$("#eservice" + i).val("");
				$("#eharga" + i).attr("readonly", true);
				$("#eharga" + i).val("");
				$("#eqty" + i).val("");
				$("#esub_total" + i).val("");
			} else if (selected_option == "service") {
				$("#esection_service" + i).removeClass("d-none");
				$("#esectionbar" + i).addClass("d-none");
				$("#esectionser" + i).removeClass("d-none");
				$("#ebarangsec" + i)
					.val(null)
					.trigger("change");
				$("#eservice" + i).val("");
				$("#eharga" + i).val("");
				$("#eqty" + i).val("");
				$("#esub_total" + i).val("");
			} else if (selected_option == "lain-lain") {
				$("#esection_service" + i).removeClass("d-none");
				$("#esectionbar" + i).addClass("d-none");
				$("#esectionser" + i).removeClass("d-none");
				$("#ebarangsec" + i)
					.val(null)
					.trigger("change");
				$("#eservice" + i).val("");
				$("#eharga" + i).val("");
				$("#eqty" + i).val("");
				$("#esub_total" + i).val("");
			} else {
				$("#esection_service" + i).addClass("d-none");
				$("#esectionbar" + i).addClass("d-none");
				$("#esectionser" + i).addClass("d-none");
				$("#ebarangsec" + i)
					.val(null)
					.trigger("change");
				$("#eservice" + i).val("");
				$("#eharga" + i).val("");
				$("#eqty" + i).val("");
				$("#esub_total" + i).val("");
			}
		});

		$("#eservice" + i).keyup(function () {
			$("#eqty" + i).val(1);
			$("#eharga" + i).attr("readonly", false);
			$("#eqty" + i).attr("readonly", true);
		});
		$("#eharga" + i).keyup(function () {
			var validasiAngka = /^[0-9]+$/;
			var qty = $("#eqty" + i).val();
			var harga = $("#eharga" + i).val();
			var total = qty * harga;
			if (harga.match(validasiAngka)) {
				$("#esub_total" + i).val(total);
			} else {
				$("#esub_total" + i).val(0);
			}
		});

		$("#eketerangan" + i).keyup(function () {
			var validasiAngka = /^[0-9]+$/;
			var harga = $("#eharga" + i).val();
			if (!harga.match(validasiAngka)) {
				$("#eharga" + i).val("Harus Berupa Angka");
			}
		});
	}
});

$("#jenis_penyewaan").change(function () {
	var selected_option = $("#jenis_penyewaan").val();
	if (selected_option == "jam") {
		$("#jam").show();
		$("#jam1").attr("required", true);
		$("#blan1").attr("required", false);
		$("#bulan").hide();
	} else if (selected_option == "bulan") {
		$("#jam").hide();
		$("#blan1").attr("required", true);
		$("#jam1").attr("required", false);
		$("#bulan").show();
	} else {
		$("#jam").hide();
		$("#bulan").hide();
		$("#blan1").attr("required", false);
		$("#jam1").attr("required", false);
	}
});

$("#jenis_maintenance_a").change(function () {
	var selected_option = $("#jenis_maintenance_a").val();
	if (selected_option == "secondary") {
		$("#section_service").removeClass("d-none");
		$("#sectionbar").removeClass("d-none");
		$("#sectionser").addClass("d-none");
		$("#barangsec_a").val(null).trigger("change");
		$("#barangsec_a").attr("required", true);
		$("#service_a").attr("required", false);
		$("#service_a").val("");
		$("#harga_a").attr("readonly", true);
		$("#harga_a").val("");
		$("#qty_a").val("");
		$("#sub_total_a").val("");
	} else if (selected_option == "service") {
		$("#section_service").removeClass("d-none");
		$("#sectionbar").addClass("d-none");
		$("#sectionser").removeClass("d-none");
		$("#barangsec_a").val(null).trigger("change");
		$("#barangsec_a").attr("required", false);
		$("#service_a").attr("required", true);
		$("#service_a").val("");
		$("#harga_a").val("");
		$("#qty_a").val("");
		$("#sub_total_a").val("");
	} else if (selected_option == "lain-lain") {
		$("#section_service").removeClass("d-none");
		$("#sectionbar").addClass("d-none");
		$("#sectionser").removeClass("d-none");
		$("#barangsec_a").val(null).trigger("change");
		$("#barangsec_a").attr("required", false);
		$("#service_a").attr("required", true);
		$("#service_a").val("");
		$("#harga_a").val("");
		$("#qty_a").val("");
		$("#sub_total_a").val("");
	} else {
		$("#section_service").addClass("d-none");
		$("#sectionbar").addClass("d-none");
		$("#sectionser").addClass("d-none");
		$("#barangsec_a").val(null).trigger("change");
		$("#barangsec_a").attr("required", false);
		$("#service_a").attr("required", false);
		$("#service_a").val("");
		$("#harga_a").val("");
		$("#qty_a").val("");
		$("#sub_total_a").val("");
	}
});

$("#jenis_report").change(function () {
	var selected_option = $("#jenis_report").val();
	if (selected_option == "bulan") {
		$("#perbulan").show();
		$("#perbulan").removeClass("d-none");
		$("#pertahun").hide();
		$("#pertahun").addClass("d-none");
	} else if (selected_option == "tahun") {
		$("#perbulan").hide();
		$("#perbulan").addClass("d-none");
		$("#pertahun").show();
		$("#pertahun").removeClass("d-none");
	} else {
		$("#perbulan").addClass("d-none");
		$("#perbulan").hide();
		$("#pertahun").addClass("d-none");
		$("#pertahun").hide();
	}
});

function hanyaAngka(evt) {
	var charCode = evt.which ? evt.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}
