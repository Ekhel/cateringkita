<!-- Main Footer -->
<?php if ($this->uri->segment('2') != "lihat_invoice") { ?>
    <footer class="main-footer">
        <strong>Copyright &copy; <?= date('Y') ?> <a href="<?= base_url() ?>">Template By Catering Kita</a>.</strong>
        All rights reserved.
        <!-- <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.0.5
    </div> -->
    </footer>
<?php } ?>
</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->

<?php $this->load->view('base/link_footer') ?>

<script>
    const successalert = $(".flash-data-sweet").data("flashdata");
    if (successalert) {
        Swal.fire({
            icon: 'success',
            title: "Berhasil Upload Bukti Transfer",
            text: successalert,
        });
    }

    const noticeealert = $(".notice-data").data("flashdata");
    const infoalert = $(".info-data").data("flashdata");

    if (noticeealert) {
        Swal.fire({
            icon: 'warning',
            title: 'Password Belum Diganti...',
            text: noticeealert,
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okee...'
        }).then((result) => {
            Swal.fire({
                icon: 'info',
                title: 'Information...',
                text: infoalert,
                confirmButtonText: 'Okee...',
            })
        });
    } else if (infoalert) {
        Swal.fire({
            icon: 'info',
            title: 'Information...',
            text: infoalert,
            confirmButtonText: 'Okee...'
        });
    }
</script>

<script>
    $(function() {
        // Summernote
        $('.textarea').summernote()
    })
</script>
<script>
    function hanyaAngka(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example1').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });

        $('#example').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });

        $("#test111").select2();

        const successalert = $(".flash-data").data("flashdata");
        const erroralert = $(".error-data").data("error");

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 5000,
        });

        if (successalert == "Login" || successalert == "Logout") {
            Toast.fire({
                icon: "success",
                title: "Anda Berhasil " + successalert,
            });
        } else if (successalert) {
            Toast.fire({
                icon: "success",
                title: successalert,
            });
        } else if (erroralert) {
            Toast.fire({
                icon: "error",
                title: erroralert,
            });
        }
    });

    $("#npwp").mask("99.999.999.9-999.999");

    $(window).on('load', function() {
        $('.preloader').fadeOut('slow');
    });

    function delete_and_backup(path = "") {
        $.ajax({
            url: base_url + path,
            type: 'post',
            dataType: 'json',
            success: function(data) {}
        });
    }

    setInterval(function() {
        delete_and_backup("/konfigurasi/backup")
    }, 900000);

    var base_url = baseurl();

    var pathparts = location.pathname.split('/');
    // if (location.host == '188.166.212.76') {
    if (location.host == 'localhost') {
        var base_url_stbaq = location.origin + '/STBAQ';
    } else {
        var base_url_stbaq = 'stbaq.com';
    }

    $(document).ready(function() {

        var lokasi_gambar = lokasigambar();

        function tanggal(tgl) {
            var tanggal = "";
            if (tgl != 0) {
                return ubah_tanggal(moment().subtract(tgl, 'day').toDate());
            } else {
                return ubah_tanggal(moment().toDate());
            }
        }

        // konfirmasi tolak pembayaran
        $('.button_konfirmasi').on('click', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Apa Kamu Yakin?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Saya Yakin!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: base_url + "/order/konfirmasi_pembayaran",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            kd_order: id
                        },
                        success: function(data) {
                            if (data.response == "success") {
                                $(".flash-data1").html(data.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                            window.location.href = "<?php echo base_url() ?>order/detail_pesanan/" + id;
                        }
                    });
                }
            });

        })

        $('.button_edit_bukti').on('click', function() {
            $('.button_edit_bukti').hide(500);
            $('.bagian_bukti_pembayaran').show(500);
        });

        $('.button_tolak').on('click', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Apa Kamu Yakin?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus saja!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {

                    $.ajax({
                        url: base_url + "/order/tolak_pembayaran",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            kd_order: id
                        },
                        success: function(data) {
                            if (data.response == "success") {
                                $(".flash-data1").html(data.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                            window.location.href = "<?php echo base_url() ?>order/detail_pesanan/" + id;
                        }
                    });
                }
            });
        })
        // end konfirmasi tolak pembayaran

        // konfirmasi ganti status pembayaran
        $(".btn-stat-pem").click(function() {
            var id = $("#kd_order").val();
            $.ajax({
                url: "<?php echo base_url("order/getOrderById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    kd_order: id
                },
                success: function(data) {
                    $('#update-status-pembayaran').modal('show');
                    $('#stat_pembayaran').val(data.payment_status);
                }
            });
        })

        // konfirmasi ganti metode pembayaran
        $(".btn-met-pem").click(function() {
            var id = $("#kd_order").val();
            $.ajax({
                url: "<?php echo base_url("order/getOrderById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    kd_order: id
                },
                success: function(data) {
                    $('#update-metode-pembayaran').modal('show');
                    $('#met_pembayaran').val(data.payment_type);
                }
            });
        })

        $("#edit_stat_pembayaran").submit(function(e) {
            e.preventDefault();
            let dataString = $('#edit_stat_pembayaran').serialize();

            $.ajax({
                url: "<?php echo base_url("order/edit_status_pembayaran") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,
                success: function(data) {
                    $('#update-status-pembayaran').modal('hide');

                    $(".flash-data1").html(data.toast.message);
                    $(".error-data1").html("");
                    toast();

                    if (data.status == 1) {
                        $('#status_bayar').addClass('badge-success');
                        $('#status_bayar').removeClass('badge-danger');
                        $('#status_bayar').html('');
                        $('#status_bayar').html('Sudah Dibayar');
                    } else {
                        $('#status_bayar').removeClass('badge-success');
                        $('#status_bayar').addClass('badge-danger');
                        $('#status_bayar').html('');
                        $('#status_bayar').html('Belum Dibayar');
                    }

                }
            });
        })

        $("#edit_met_pembayaran").submit(function(e) {
            e.preventDefault();
            let dataString = $('#edit_met_pembayaran').serialize();

            $.ajax({
                url: "<?php echo base_url("order/edit_metode_pembayaran") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,
                success: function(data) {
                    $('#update-metode-pembayaran').modal('hide');

                    if (data.metode == "cod") {
                        $('.met-pem-det').html("COD");
                        $("#buttoneditkredit").hide();
                    } else if (data.metode == "transfer") {
                        $('.met-pem-det').html("Transfer");
                        $("#buttoneditkredit").hide();
                    } else if (data.metode == "ambil_langsung") {
                        $('.met-pem-det').html("Tunai");
                        $("#buttoneditkredit").hide();
                    } else if (data.metode == "kredit") {
                        $('.met-pem-det').html("Kredit");
                        $("#buttoneditkredit").show();
                    }

                    $(".flash-data1").html(data.toast.message);
                    $(".error-data1").html("");
                    toast();
                }
            });
        })

        $("#deleteCache").click(function() {
            $.ajax({
                url: "<?php echo base_url("main/deleteAllCache") ?>",
                type: 'post',
                dataType: 'json',

                success: function(data) {
                    $(".flash-data1").html(data.message);
                    $(".flash-data1").hide();
                    $(".error-data1").html("");
                    toast();
                }
            });
        })

        $.ajax({
            type: "post",
            url: base_url + "/member/countmembernonaktif",
            dataType: 'json',
            success: function(response) {
                $('.txt_member_nonAktif').html(response);
            }
        });
        $.ajax({
            type: "post",
            url: base_url + "/order/count_bukti_tf",
            dataType: 'json',
            success: function(response) {
                $('.txt_kon_bukti_tf').html(response);
            }
        });
        $.ajax({
            type: "post",
            url: base_url + "/order/get_pesanan/semuapesanan",
            dataType: 'json',
            success: function(response) {
                $('.txt_semuapesanan').html(response.jumlah);
            }
        });
        $("#generate_referral").click(function() {
            $.ajax({
                url: "<?php echo base_url("main/generate_referral") ?>",
                type: 'post',
                dataType: 'json',

                success: function(data) {
                    $(".flash-data1").html(data.message);
                    $(".error-data1").html("");
                    toast();
                }
            });
        })

        $('.btn-copy-kode-referral').click(function() {
            var copyText = document.getElementById("kode_referral_txt");
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            document.execCommand("copy");

            $(".error-data1").html("");
            $(".flash-data1").html("Sukses Copy.");
            toast();
        })

        $('.copy-share-produk').click(function() {
            var copyText = document.getElementById("kode_referral_txt");
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            document.execCommand("copy");

            $(".error-data1").html("");
            $(".flash-data1").html("Sukses Copy.");
            toast();
        })

        // bagian pesanan reseller

        $('#cek_member_res').on('click', function() {
            var no_telp = $('#no_telp').val();
            if (no_telp != "") {
                $.ajax({
                    url: base_url + "/pesanan/cek_member_res",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        no_telp: no_telp
                    },
                    success: function(data) {
                        if (data == null) {
                            $(".flash-data1").html(null);
                            $(".error-data1").html("Data Member Tidak Ditemukan !");
                            $('#nm_member').val("");
                            $('#jk').val("").trigger('change');
                            $('#email').val("");
                            $('#alamat').summernote("code", "");
                            $('#informasi_member').show(500);
                        } else {
                            if (data.is_member_aktif == 1) {
                                $(".error-data1").html(null);
                                $(".flash-data1").html("Data Member Ditemukan !");
                                $('#nm_member').val(data.nm_member);
                                $('#nm_penerima_baru').val(data.nm_member);
                                $('#email').val(data.email);
                                $('#email_baru').val(data.email);
                                $('#alamat').summernote("code", decrypt(data.alamat));
                                $('#alamat1').summernote("code", decrypt(data.alamat));
                                $('#alamat_baru').summernote("code", decrypt(data.alamat));
                                $(".alamat_member").val(data.alamat_untuk_ongkir);
                                $(".jarak_member").val(data.jarak);
                                $("#subregion").val(data.subregion);
                                $("#city").val(data.city);
                                $("#nbrhd").val(data.nbrhd);
                                $("#latitude_order").val(data.lat_alamat);
                                $("#longitude_order").val(data.lon_alamat);
                                $('#jk').val(data.jenis_kelamin).trigger('change');
                                $('#informasi_member').show(500);
                            } else {
                                $(".error-data1").html("Data Member Ditemukan, Tapi Member Tidak Aktif, Harap Konfirmasi Admin!");
                                $(".flash-data1").html(null);
                                toast();
                                $('#no_telp').val("");
                            }
                        }
                        toast();
                        $(".flash-data1").html(null);
                        $(".error-data1").html(null);
                    }
                });
            } else {
                $(".error-data1").html("Masukkan Nomor Telepon Terlebih Dahulu !");
                $(".flash-data1").html(null);
                toast();
            }

        });

        $('#Modal_Lihat_rm').on('hidden.bs.modal', function(e) {
            $("#demo").html("");
            $("#demo1").html("");
        });

        $("#btn_Modal_Scan_resmem").click(function() {

            table = "reseller";
            path = "getResellerMemberById";

            $("#scan" + table).hide();

            let scanner = new Instascan.Scanner({
                video: document.getElementById('preview'),
                mirror: false,
            });
            scanner.addListener('scan', function(content) {
                $.ajax({
                    url: "<?php echo base_url("reseller/getResellerMemberById") ?>",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        "kd_reseller": content
                    },
                    success: function(data) {
                        text = "";
                        html = "";
                        if (data != null) {
                            $('#Modal_Scan').modal('hide');
                            scanner.stop();
                            text += '<tr>' +
                                '<td>' + data[0].kd_reseller + '</td>' +
                                '<td>' + data[0].nm_reseller + '</td>' +
                                '<td>' + data[0].no_telp_res + '</td>' +
                                '</tr>';
                            $('#demo').html(text);
                            for (let i = 0; i < data.length; i++) {
                                html += '<tr>' +
                                    '<td>' + data[i].kd_member + '</td>' +
                                    '<td>' + data[i].nm_member + '</td>' +
                                    '<td>' + data[i].no_telp_mem + '</td>' +
                                    '</tr>';
                            }
                            $('#demo1').html(html);
                        }
                    }
                });

                $('#Modal_Lihat_rm').modal({
                    backdrop: 'static',
                    keyboard: false
                })
            });

            Instascan.Camera.getCameras().then(function(cameras) {
                // if (cameras.length > 0) {
                //     scanner.start(cameras[0]);
                // } else {
                //     console.error('No Cameras Found');
                // }

                if (cameras.length > 0) {

                    // setting kamera belakang
                    var selectedCam = cameras[0];
                    $.each(cameras, (i, c) => {
                        if (c.name.indexOf('back') != -1) {
                            selectedCam = c;
                            return false;
                        }
                    });

                    scanner.start(selectedCam);
                    // end setting kamera belakang

                    // ini setting kamera depan
                    //     scanner.start(cameras[0]);
                    // end setting kamera depan

                } else {
                    console.error('No cameras found.');
                }

            }).catch(function(e) {
                console.error(e);
            })
        });

        $("#btn_Modal_Scan").click(function() {

            table = "reseller";
            path = "getResellerById";
            scanDataQrCode(table, path);
        })

        $("#btn_Modal_Scan_Supplier").click(function() {

            table = "supplier";
            path = "getSupplierById";
            scanDataQrCode(table, path);
        })

        $("#btn_Modal_Scan_Member").click(function() {

            table = "member";
            path = "getMemberKecById";
            scanDataQrCode(table, path);
        })

        $("#btn_Modal_Scan_Produk").click(function() {

            table = "product";
            path = "getDetailDataProduk/detail";
            scanDataQrCode(table, path);
        })

        $("#btn_Modal_Scan_Order").click(function() {

            table = "order";
            path = "get_list_detail_order_kurir";
            scanDataQrCode(table, path);
        })

        function scanDataQrCode(tabel, path) {
            $("#scan" + tabel).hide();
            let scanner = new Instascan.Scanner({
                video: document.getElementById('preview'),
                mirror: false,
            });
            scanner.addListener('scan', function(content) {
                if (tabel == "order") {
                    getDetailDataPesananKurir(content, "qr");
                    $("#scan" + tabel).show();

                } else {
                    $.ajax({
                        // url: "<?php echo base_url("/getSupplierById") ?>",
                        url: base_url + "/" + tabel + "/" + path,
                        type: 'post',
                        dataType: 'json',
                        data: {
                            tujuan: content
                        },
                        success: function(data) {
                            var html1 = "";
                            var html2 = "";
                            var html3 = "";
                            var status = "";

                            if (data != null) {

                                if (tabel == "reseller") {
                                    is_hapus = data.is_reseller_hapus;
                                } else if (tabel == "supplier") {
                                    is_hapus = data.is_supplier_hapus;
                                } else if (tabel == "member") {
                                    is_hapus = data.is_member_hapus;
                                } else if (tabel == "product") {
                                    is_hapus = data.is_detail_produk_hapus;
                                }

                                if (is_hapus == 1) {
                                    if (tabel == "reseller") {
                                        data.is_reseller_aktif == 1 ? status = "Aktif" : status = "Tidak Aktif";
                                        html1 += '<tr>' +
                                            '<td>' + data.nm_reseller + '</td>' +
                                            '<td>' + data.no_telp + '</td>' +
                                            '<td>' + data.email + '</td>' +
                                            '<td>' + data.jenis_kelamin + '</td>' +
                                            '</tr>';

                                        html3 += '<tr>' +
                                            '<td>' + data.ktp + '</td>' +
                                            '<td>' + data.npwp + '</td>' +
                                            '<td>' + data.atas_nama + '</td>' +
                                            '<td>' + data.bank + '</td>' +
                                            '<td>' + data.no_rekening + '</td>' +
                                            '</tr>';

                                        html2 += '<tr>' +
                                            '<td>' + decrypt(data.alamat) + '</td>' +
                                            '<td>' + status + '</td>' +
                                            '</tr>';

                                    } else if (tabel == "supplier") {
                                        data.is_supplier_aktif == 1 ? status = "Aktif" : status = "Tidak Aktif";
                                        html1 += '<tr>' +
                                            '<td>' + data.nm_supplier + '</td>' +
                                            '<td>' + data.contact_person + '</td>' +
                                            '<td>' + data.no_telp + '</td>' +
                                            '<td>' + data.email + '</td>' +
                                            '</tr>';

                                        html2 += '<tr>' +
                                            '<td>' + decrypt(data.alamat) + '</td>' +
                                            '<td>' + status + '</td>' +
                                            '</tr>';

                                    } else if (tabel == "member") {

                                        data.is_member_aktif == 1 ? status = "Aktif" : status = "Tidak Aktif";

                                        html1 += '<tr>' +
                                            '<td>' + data.nm_member + '</td>' +
                                            '<td>' + data.no_telp + '</td>' +
                                            '<td>' + data.email + '</td>' +
                                            '<td>' + data.jenis_kelamin + '</td>' +
                                            '<td>' + status + '</td>' +
                                            '</tr>';

                                        html2 += '<tr>' +
                                            '<td>' + data.kecamatan + '</td>' +
                                            '<td>' + data.kodepos + '</td>' +
                                            '<td>' + decrypt(data.alamat) + '</td>' +
                                            '</tr>';

                                    } else if (tabel == "product") {
                                        var angka = 1;

                                        html1 += '<tr>' +
                                            '<td>' + data.nm_produk + '</td>' +
                                            '<td>' + data.nm_kategori + '</td>' +
                                            '<td>' + data.nm_sub_kategori + '</td>' +
                                            '<td>' + data.nm_supplier + '</td>' +
                                            '</tr>';

                                        html2 += '<tr>' +
                                            '<td>' + angka++ + '</td>' +
                                            '<td>' + data.berat + " " + data.satuan_berat + '</td>' +
                                            '<td>' + convertToRupiah(data.harga_modal) + '</td>' +
                                            '<td>' + convertToRupiah(data.harga_produk) + '</td>' +
                                            '<td>' + convertToRupiah(data.diskon) + '</td>' +
                                            '<td>' + data.stok + '</td>' +
                                            '<td>' + data.jns_komisi + '</td>' +
                                            '<td>' + convertToRupiah(data.nominal_komisi) + '</td>' +
                                            '</tr>';
                                    }

                                    $("#body" + tabel + "1").html(html1);
                                    $("#body" + tabel + "2").html(html2);
                                    if (tabel == "reseller") {
                                        $("#body" + tabel + "3").html(html3);
                                    }
                                    $("#scan" + tabel).show();
                                } else {

                                    $("#scan" + tabel).hide();
                                    $("#body" + tabel + "1").hide();
                                    $("#body" + tabel + "2").hide();

                                    $(".error-data1").html("Data " + tabel + " Tidak Ditemukan !");
                                    $(".flash-data1").html("");
                                    toast();
                                }
                            } else {
                                $("#scan" + tabel).hide();
                                $("#body" + tabel + "1").hide();
                                $("#body" + tabel + "2").hide();

                                $(".error-data1").html("Data " + tabel + " Tidak Ditemukan !");
                                $(".flash-data1").html("");
                                toast();
                            }
                        }
                    });
                }

            });

            Instascan.Camera.getCameras().then(function(cameras) {
                // if (cameras.length > 0) {
                //     scanner.start(cameras[0]);
                // } else {
                //     console.error('No Cameras Found');
                // }

                if (cameras.length > 0) {

                    // setting kamera belakang
                    var selectedCam = cameras[0];
                    $.each(cameras, (i, c) => {
                        if (c.name.indexOf('back') != -1) {
                            selectedCam = c;
                            return false;
                        }
                    });

                    scanner.start(selectedCam);
                    // end setting kamera belakang

                    // ini setting kamera depan
                    //     scanner.start(cameras[0]);
                    // end setting kamera depan

                } else {
                    console.error('No cameras found.');
                }

            }).catch(function(e) {
                console.error(e);
            })
        }

        $("#multiFiles").change(function(event) {
            fadeInAdd();
            fadeInAdd();
            getURLMultiple(this, "multiFiles");
        });

        $("#multiFiles").on('click', function(event) {
            fadeInAdd();
        });

        $("#multiFiles_edit").change(function(event) {
            fadeInAdd();
            fadeInAdd();
            getURLMultiple(this, "multiFiles_edit");
        });

        $("#multiFiles_edit").on('click', function(event) {
            fadeInAdd();
        });

        function fadeInAdd() {
            fadeInAlert();
        }

        function fadeInAlert(text) {
            $(".alert").text(text).addClass("loadAnimate");
        }

        function getURLMultiple(input, id) {
            if (input.files && input.files[0]) {
                var length = input.files.length;

                var totalJmlReview = [];
                var j;
                for (let i = 0; i < length; i++) {
                    var reader = new FileReader();

                    var a = parseInt($("#totalimagereview").val());

                    var filename = $("#" + id).val();
                    filename = filename.substring(filename.lastIndexOf('\\') + 1);
                    reader.onload = function(e) {
                        // debugger;

                        j = parseInt(a + (i));

                        $('#selected-image_prev #row_prev_gallery').append('<div class="col-sm-4 col-md-4" id="rmreview' + j + '">' +
                            '<div class="img gallery-img">' +
                            '<div class="gallery-product">' +
                            '<a id="hapusGalleryDetaill' + j + '">' +
                            '<span class="remove-img"><i class="fas fa-times"></i>' +
                            '<input type="hidden" name="id_review" id="id_review' + j + '" value="' + j + '" >' +
                            '</span>' +
                            '</a>' +
                            '<img src="' + e.target.result + '" width="250px" height="250px" alt="" id="imgGallery' + i + '" srcset="">' +
                            '</div>' +
                            '</div>' +
                            '</div>');

                        $("#hapusGalleryDetaill" + parseInt(a + (i))).click(function() {
                            $("#rmreview" + parseInt(a + (i))).remove();
                            $("#totalimagereview").val(parseInt($("#totalimagereview").val()) - 1)
                        })
                    }
                    reader.readAsDataURL(input.files[i]);
                    totalJmlReview.push(i);
                }

                var totalImageReview = $("#totalimagereview").val();
                $("#totalimagereview").val(parseInt(totalImageReview) + (parseInt(totalJmlReview.length)));
            }
            var ketFoto = $("#ketfoto").val();
            var tampungan = [];
            if (ketFoto != "") {
                tampungan.push(ketFoto);
            }
            tampungan.push("gallery");
            $("#ketfoto").val(tampungan);
            $(".alert").removeClass("loadAnimate").hide();
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

        function convertToRupiah(angka) {
            if (angka != "" && angka != null) {

                var rupiah = '';
                var angkarev = angka.toString().split('').reverse().join('');
                for (var i = 0; i < angkarev.length; i++)
                    if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ',';
                return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
            } else {
                return 0;
            }
        }

        function distance(lat1, lon1, lat2, lon2, unit) {
            if ((lat1 == lat2) && (lon1 == lon2)) {
                return 0;
            } else {
                var radlat1 = Math.PI * lat1 / 180;
                var radlat2 = Math.PI * lat2 / 180;
                var theta = lon1 - lon2;
                var radtheta = Math.PI * theta / 180;
                var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
                if (dist > 1) {
                    dist = 1;
                }
                dist = Math.acos(dist);
                dist = dist * 180 / Math.PI;
                dist = dist * 60 * 1.1515;
                if (unit == "K") {
                    dist = dist * 1.609344
                }
                if (unit == "N") {
                    dist = dist * 0.8684
                }
                var jarak = Math.round(dist);
                return jarak;
            }
        }

        // Bagian Promo Per Produk
        $('#mytablePromo').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('product/get_product_promo') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nama_promo",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nama_promo",
                    class: "text-center",
                },
                {
                    data: "date_start",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return ubah_tanggal(data);
                    }
                },
                {
                    data: "time_start",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return data.slice(0, 5) + " - " + row.time_end.slice(0, 5) + " WIB";
                    }
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#jenis_promo').change(function() {
            var jenis_promo = $('#jenis_promo').val();

            if (jenis_promo == "1") {
                $('#bagian_tanggal').show(500);
                $('#bagian_tanggal_start').removeClass("col-md-6 col-xs-6 col-6");
                $('#bagian_tanggal_start').addClass("col-md-12 col-xs-12 col-12");
                $('#bagian_tanggal_end').hide();
                $('#bagian_waktu').show(500);
                $('#datepickersingle1').removeAttr("reqiured");
                $('#datepickersingle').attr("reqiured", true);
                $('#time_start').attr("reqiured", true);
                $('#time_end').attr("reqiured", true);
            } else if (jenis_promo == "2") {
                $('#bagian_tanggal').show(500);
                $('#bagian_tanggal_start').addClass("col-md-6 col-xs-6 col-6");
                $('#bagian_tanggal_start').removeClass("col-md-12 col-xs-12 col-12");
                $('#bagian_tanggal_end').show();
                $('#bagian_waktu').hide(500);
                $('#datepickersingle').attr("reqiured", true);
                $('#datepickersingle1').attr("reqiured", true);
                $('#time_start').removeAttr("reqiured");
                $('#time_end').removeAttr("reqiured");
            } else {
                $('#bagian_tanggal').hide(500);
                $('#bagian_waktu').hide(500);
                $('#datepickersingle').removeAttr("reqiured");
                $('#datepickersingle1').removeAttr("reqiured");
                $('#time_start').removeAttr("reqiured");
                $('#time_end').removeAttr("reqiured");
            }
        });

        $('#edit_jenis_promo').change(function() {
            var jenis_promo = $('#edit_jenis_promo').val();

            if (jenis_promo == "1") {
                $('#edit_bagian_tanggal').show(500);
                $('#edit_bagian_tanggal_start').removeClass("col-md-6 col-xs-6 col-6");
                $('#edit_bagian_tanggal_start').addClass("col-md-12 col-xs-12 col-12");
                $('#edit_bagian_tanggal_end').hide();
                $('#edit_bagian_waktu').show(500);
                $('#edit_datepickersingle1').removeAttr("reqiured");
                $('#edit_datepickersingle').attr("reqiured", true);
                $('#edit_time_start').attr("reqiured", true);
                $('#edit_time_end').attr("reqiured", true);
            } else if (jenis_promo == "2") {
                $('#edit_bagian_tanggal').show(500);
                $('#edit_bagian_tanggal_start').addClass("col-md-6 col-xs-6 col-6");
                $('#edit_bagian_tanggal_start').removeClass("col-md-12 col-xs-12 col-12");
                $('#edit_bagian_tanggal_end').show();
                $('#edit_bagian_waktu').hide(500);
                $('#edit_datepickersingle').attr("reqiured", true);
                $('#edit_datepickersingle1').attr("reqiured", true);
                $('#edit_time_start').removeAttr("reqiured");
                $('#edit_time_end').removeAttr("reqiured");
            } else {
                $('#edit_bagian_tanggal').hide(500);
                $('#edit_bagian_waktu').hide(500);
                $('#edit_datepickersingle').removeAttr("reqiured");
                $('#edit_datepickersingle1').removeAttr("reqiured");
                $('#edit_time_start').removeAttr("reqiured");
                $('#edit_time_end').removeAttr("reqiured");
            }
        });

        $('#Modal_Edit').on('hidden.bs.modal', function(e) {
            $("#edit_bagiantambahproduk").html("");
            $("#edit_bagiantambahproduk1").html("");

            $("#edit_bagiantambahprodukpaket").html("");
            $("#edit_bagiantambahprodukpaket1").html("");

            $("#edit_bagiantambahprodukpaketbonus").html("");
            $("#edit_bagiantambahprodukbonus").html("");
        })

        $('#mytablePromo').on('click', '.lihat_record', function() {
            let id = $(this).data('id');
            var text = "";

            $.ajax({
                url: "<?php echo base_url("Product/getDetailPromoById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_promo": id
                },
                success: function(data) {
                    for (let i = 0; i < data.length; i++) {
                        text +=
                            "<tr>" +
                            "<td>" +
                            data[i].nm_produk +
                            "</td>" +
                            "<td>" +
                            convertToRupiah(data[i].harga_produk) +
                            "</td>" +
                            "<td>" +
                            convertToRupiah(data[i].harga_promo) +
                            "</td>" +
                            "</tr>";
                    }
                    $('#Modal_Lihat').modal('show');
                    $("#demo").html(text);
                }
            });
        });
        $('#mytablePromo').on('click', '.edit_record', function() {
            let id = $(this).data('id');
            var text = "";

            $.ajax({
                url: "<?php echo base_url("Product/getPromoById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_promo": id
                },
                success: function(data) {
                    $('#edit_kode_promo').val(data.kd_promo);
                    $('#edit_nama_promo').val(data.nama_promo);
                    if (data.date_end == null) {
                        $('#edit_jenis_promo').val(1);
                        $('#edit_bagian_tanggal').show();
                        $('#edit_bagian_tanggal_start').removeClass("col-md-6 col-xs-6 col-6");
                        $('#edit_bagian_tanggal_start').addClass("col-md-12 col-xs-12 col-12");
                        $('#edit_bagian_tanggal_end').hide();
                        $('#edit_bagian_waktu').show();
                        $('#edit_datepickersingle1').removeAttr("reqiured");
                        $('#edit_datepickersingle').attr("reqiured", true);
                        $('#edit_time_start').attr("reqiured", true);
                        $('#edit_time_end').attr("reqiured", true);

                        $('#edit_datepickersingle').val(data.date_start);
                        $('#edit_time_start').val(data.time_start);
                        $('#edit_time_end').val(data.time_end);
                    } else if (data.time_start == null && data.time_end == null) {
                        $('#edit_jenis_promo').val(2);
                        $('#edit_bagian_tanggal').show();
                        $('#edit_bagian_tanggal_start').addClass("col-md-6 col-xs-6 col-6");
                        $('#edit_bagian_tanggal_start').removeClass("col-md-12 col-xs-12 col-12");
                        $('#edit_bagian_tanggal_end').show();
                        $('#edit_bagian_waktu').hide();
                        $('#edit_datepickersingle').attr("reqiured", true);
                        $('#edit_datepickersingle1').attr("reqiured", true);
                        $('#edit_time_start').removeAttr("reqiured");
                        $('#edit_time_end').removeAttr("reqiured");
                        $('#edit_datepickersingle').val(data.date_start);
                        $('#edit_datepickersingle1').val(data.date_end);
                    }

                    $.ajax({
                        url: "<?php echo base_url("Product/getDetailPromoById") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            kd_promo: data.kd_promo
                        },

                        success: function(result) {
                            $('#edit_jmlbarangplus').val(result.length);
                            $('#edit_jmlbarang1').val(result.length);
                            for (let i = 0; i < result.length; i++) {
                                text = '<div id="bagianhapusproduk' +
                                    i +
                                    '"><div class="row"><div class="col-md-8 col-xs-8 col-8"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2produk' + i + '" id="edit_promo_produk' + i + '" required><option value=' + result[i].kd_detail_produk + ' selected>' +
                                    result[i].nm_produk + " - " + result[i].berat + ' ' + result[i].satuan_berat + '</option></select></div></div><div class="col-md-4 col-xs-4 col-4"><label>Harga Menu</label><input type="text" class="form-control input-rupiah-mask' + i + '" name="harga_produk[]" id="edit_harga_produk' + i + '" value="' + result[i].harga_produk + '" placeholder="Harga Menu" readonly required></div><div class="col-md-11 col-xs-10 col-10"><label>Harga Promo</label><input type="text" class="form-control input-rupiah-mask' + i + '" name="harga_promo[]" id="edit_harga_promo' + i + '" value="' + result[i].harga_promo + '" placeholder="Harga Promo" required></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusproduk' + i + '"> <i class="fa fa-minus"></i></a></div></div><br></div>';

                                $('#edit_bagiantambahproduk').append(text);
                                $("body").on("click", "#buttonhapusproduk" + i, function() {
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
                                        data: function(params) {
                                            return {
                                                searchTerm: params.term, // search term
                                            };
                                        },
                                        processResults: function(response) {
                                            return {
                                                results: response,
                                            };
                                        },
                                        cache: true,
                                    },
                                });

                                $(".select2produk" + i).on("select2:select", function(e) {
                                    var harga = e.params.data.harga;
                                    $('#edit_harga_produk' + i).val(harga);
                                });

                                $(".input-rupiah-mask" + i).inputmask({
                                    alias: 'numeric',
                                    groupSeparator: ',',
                                    autoGroup: true,
                                    digits: 0,
                                    digitsOptional: false,
                                    prefix: 'Rp. ',
                                    placeholder: '0',
                                    rightAlign: false,
                                    autoUnmask: true,
                                    removeMaskOnSubmit: true
                                });

                                $('#edit_harga_promo' + i).keyup(function() {
                                    var harga_promo = parseInt($('#edit_harga_promo' + i).val());
                                    var harga_produk = parseInt($('#edit_harga_produk' + i).val());
                                    if (harga_promo > harga_produk) {
                                        $(".error-data1").html("Harga Promo tidak bisa lebih dari Harga Menu.");
                                        $(".flash-data1").html("");
                                        toast();
                                        $('#edit_harga_promo' + i).val(0);
                                    }
                                })
                            }
                        }
                    });
                }
            });
            $('#Modal_Edit').modal({
                backdrop: 'static',
                keyboard: false
            })
        })

        $('#mytablePromo').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Apa Kamu Yakin?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus saja!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url("product/delete_promo") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "kd_promo": id,
                        },
                        success: function(data) {
                            if (data.response == "success") {
                                $('#mytablePromo').DataTable().ajax.reload();
                                $(".flash-data1").html(data.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                        }
                    });
                }
            });
        });

        $("#addPromoProduct").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addPromoProduct').serialize();

            $.ajax({
                url: "<?php echo base_url("Product/add_promo") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytablePromo').DataTable().ajax.reload();
                        $('#addPromoProduct')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                        $("#bagiantambahproduk").html("");
                        $("#promo_produk").val("").trigger('change');
                        // $("#jenis_promo").val("").trigger('change');
                        // $('#bagian_tanggal').hide();
                        // $('#bagian_waktu').hide();
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $('#btn_save_promo').click(function() {
            var tanggal = $('#datepickersingle').val();
            var time_start = $('#time_start').val();
            var time_end = $('#time_end').val();
            var start = new Date(tanggal + " " + time_start).getTime();
            $.ajax({
                url: "<?php echo base_url("Product/getPromoByDate") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    tanggal: tanggal
                },

                success: function(data) {
                    for (let i = 0; i < data.length; i++) {
                        var promo_start = new Date(data[i].date_start + " " + data[i].time_start).getTime();
                        var promo_end = new Date(data[i].date_start + " " + data[i].time_end).getTime();
                        // if (promo_start >= start || promo_end <= start) {
                        //     $(".error-data1").html("Jam Sudah Terdaftar");
                        //     $(".flash-data1").html("");
                        //     toast();
                        //     $('#time_start').val("");
                        //     $('#time_start').addClass("is_invalid");
                        //     return false;
                        // }
                    }
                }
            });
        })

        $("#editPromoProduct").submit(function(e) {
            e.preventDefault();
            let dataString = $('#editPromoProduct').serialize();

            $.ajax({
                url: "<?php echo base_url("Product/edit_promo") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#mytablePo').DataTable().ajax.reload();
                        $('#editPromoProduct')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                        $("#edit_bagiantambahproduk").html("");
                        $("#edit_bagiantambahproduk1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $('#harga_promo').keyup(function() {
            var harga_promo = parseInt($('#harga_promo').val());
            var harga_produk = parseInt($('#harga_produk').val());
            if (harga_promo > harga_produk) {
                $(".error-data1").html("Harga Promo tidak bisa lebih dari Harga Menu.");
                $(".flash-data1").html("");
                toast();
                $('#harga_promo').val(0);
            }
        })
        // End Bagian Promo

        // bagian Promo Paket Aktif

        $('#mytablePromoPaket').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('product/get_product_promo_paket/1') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nama_promo",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nama_promo",
                    class: "text-center",
                },
                {
                    data: "date_start",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return ubah_tanggal(data);
                    }
                },
                {
                    data: "time_start",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return data.slice(0, 5) + " - " + row.time_end.slice(0, 5) + " WIB";
                    }
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytablePromoPaket').on('click', '.edit_record', function() {
            let id = $(this).data('id');
            var text = "";

            $.ajax({
                url: "<?php echo base_url("Product/getPromoById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_promo": id
                },
                success: function(data) {
                    $('#edit_kode_promo').val(data.kd_promo);
                    $('#edit_nama_promo').val(data.nama_promo);
                    $('#edit_harga_modal').val(data.harga_modal_promo);
                    $('#edit_harga_promo').val(data.harga_hasil_promo);
                    $('#edit_stok').val(data.stok_paket);
                    $('#edit_status_ujroh').val(data.status_ujroh);

                    $('#edit_datepickersingle').val(data.date_start);
                    $('#edit_datepickersingle1').val(data.date_end);
                    $('#edit_time_start').val(data.time_start);
                    $('#edit_time_end').val(data.time_end);

                    $.ajax({
                        url: "<?php echo base_url("Product/getDetailPromoById") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            kd_promo: data.kd_promo
                        },

                        success: function(result) {
                            $('#edit_jmlbarangplus').val(result.length);
                            $('#edit_jmlbarang1').val(result.length);
                            var j = 1;
                            for (let i = 0; i < result.length; i++) {
                                text = '<div id="bagiantambahprodukpaket' +
                                    i +
                                    '"><div class="row"><div class="col-md-6 col-xs-6 col-6"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2produkpaket' + j + '" id="edit_promo_produk' + j + '" required><option value=' + result[i].kd_detail_produk + ' selected>' +
                                    result[i].nm_produk + " - " + result[i].berat + ' ' + result[i].satuan_berat + '</option></select></div></div><div class="col-md-1 col-xs-1 col-1"><label>QTY</label><input type="text" class="form-control" name="qty[]" id="edit_qtypaket' + j + '" value="' + result[i].qty + '" placeholder="QTY" required></div><div class="col-md-4 col-xs-4 col-4"><label for="harga_produk">Harga Menu</label><div class="input-group"><input type="text" class="form-control input-rupiah-mask' + j + '" name="harga_produk[]" id="edit_harga_produk' + j + '" value="' + (result[i].harga_produk * result[i].qty) + '" placeholder="Harga Menu" readonly required><input type="hidden" class="form-control input-rupiah-mask' + j +
                                    '" id="edit_harga_produkk' +
                                    j +
                                    '" placeholder="Harga Menu" value="' + result[i].harga_produk + '" readonly required><span class="input-group-append"><button type="button" class="btn btn-info btn-flat eujrohpaketan' + j + '"><i class="fas fa-dollar-sign"></i> </button></span></div></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusprodukpaket' + i + '"> <i class="fa fa-minus"></i></a></div></div></div>';

                                $('#edit_bagiantambahprodukpaket').append(text);

                                text1 = '<div id="bagiantambahujrohprodukpaket' +
                                    i +
                                    '"><div class="modal fade" id="Modal_ujroh_paketann' + j + '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">Detail Ujroh</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="row"><div class="col-xs-6 col-md-6"><div class="form-group"><label for="">Jumlah Ujroh Selera</label><input type="text" name="ujroh_selera[]" value="' + result[i].ujroh_promo_selera + '" id="editt_ujroh_selera' + j + '" class="form-control rupiah-mask"><input type="hidden" value="' + result[i].ujroh_promo_selera + '" id="edit_hid_ujroh_selera' + j + '" class="form-control rupiah-mask" readonly><input type="hidden" value="' + result[i].ujroh_promo + '" id="edit_hid_ujroh' + j + '" class="form-control rupiah-mask" readonly></div></div><div class="col-xs-6 col-md-6"><div class="form-group"><label for="">Jumlah Ujroh Reseller</label><input type="text" name="ujroh[]" value="' + result[i].ujroh_promo + '" id="editt_ujroh' + j + '" class="form-control rupiah-mask"></div></div></div></div></div></div></div>';

                                $('.edit-tmpt-ujroh-paket').append(text1);

                                $(".eujrohpaketan" + j).click(function() {
                                    var j = i + 1;
                                    var promo_produk = $("#edit_promo_produk" + j).val();
                                    if (promo_produk == "") {
                                        Toast.fire({
                                            icon: "error",
                                            title: "Produk Harus Dipilih Terlebih Dahulu",
                                        });
                                    } else {
                                        $("#Modal_ujroh_paketann" + j).modal("show");
                                    }
                                })

                                $("body").on("click", "#buttonhapusprodukpaket" + i, function() {
                                    $("#edit_jmlbarang1").val(parseInt($("#edit_jmlbarang1").val()) - 1);

                                    var x = i + 1;
                                    var hargaDihapus = $("#edit_harga_produk" + x).val();
                                    var hargaModal = $("#edit_harga_modal").val();

                                    if (isNaN(hargaDihapus)) hargaDihapus = 0;

                                    $("#edit_harga_modal").val(parseInt(hargaModal) - parseInt(hargaDihapus));

                                    $(this)
                                        .parents("#bagiantambahprodukpaket" + i)
                                        .remove();

                                    $(this)
                                        .parents("#bagiantambahujrohprodukpaket" + i)
                                        .remove();
                                });

                                $("#edit_qtypaket" + j).keyup(function() {
                                    var j = i + 1;
                                    var maxGroupbarang = $("#jmlbarang").val();
                                    var qty = $("#edit_qtypaket" + j).val();
                                    var hargaProduk = $("#edit_harga_produkk" + j).val();
                                    var ujroh = $("#edit_hid_ujroh" + j).val();
                                    var ujrohSelera = $("#edit_hid_ujroh_selera" + j).val();

                                    $("#editt_ujroh" + j).val(parseInt(qty) * parseInt(ujroh));
                                    $("#editt_ujroh_selera" + j).val(parseInt(qty) * parseInt(ujrohSelera));
                                    var ujrohh = $("#editt_ujroh" + j).val();
                                    var ujrohhSelera = $("#editt_ujroh_selera" + j).val();

                                    $("#edit_harga_produk" + j).val(qty * hargaProduk);

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

                                $(".select2produkpaket" + j).select2({
                                    placeholder: "Pilih Produk",
                                    ajax: {
                                        url: base_url + "/select2/get_json_detail_produk",
                                        type: "post",
                                        dataType: "json",
                                        delay: 100,
                                        data: function(params) {
                                            return {
                                                searchTerm: params.term, // search term
                                            };
                                        },
                                        processResults: function(response) {
                                            return {
                                                results: response,
                                            };
                                        },
                                        cache: true,
                                    },
                                });

                                $(".select2produkpaket" + j).on("select2:select", function(e) {
                                    var j = i + 1;
                                    var harga = e.params.data.harga;
                                    var maxGroupbarang = $("#jmlbarang").val();
                                    var qty = $("#edit_qtypaket" + j).val();

                                    if (qty != "") {
                                        if (isNaN(qty)) qty = 0;
                                        $("#edit_harga_produk" + j).val(harga * qty);
                                    } else {
                                        $("#edit_harga_produk" + j).val(harga);
                                        $("#edit_harga_produkk" + j).val(harga);
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

                                $(".input-rupiah-mask" + j).inputmask({
                                    alias: 'numeric',
                                    groupSeparator: ',',
                                    autoGroup: true,
                                    digits: 0,
                                    digitsOptional: false,
                                    prefix: 'Rp. ',
                                    placeholder: '0',
                                    rightAlign: false,
                                    autoUnmask: true,
                                    removeMaskOnSubmit: true
                                });

                                $('#edit_harga_promo' + j).keyup(function() {
                                    var harga_promo = parseInt($('#edit_harga_promo' + j).val());
                                    var harga_produk = parseInt($('#edit_harga_produk' + j).val());
                                    if (harga_promo > harga_produk) {
                                        $(".error-data1").html("Harga Promo tidak bisa lebih dari Harga Menu.");
                                        $(".flash-data1").html("");
                                        toast();
                                        $('#edit_harga_promo' + j).val(0);
                                    }
                                })
                                j++;
                            }
                        }
                    });
                }
            });
            $('#Modal_Edit').modal({
                backdrop: 'static',
                keyboard: false
            })
        })

        $("#editPromoProductPaket").submit(function(e) {
            e.preventDefault();
            let dataString = $('#editPromoProductPaket').serialize();

            $.ajax({
                url: "<?php echo base_url("Product/edit_promo_paket") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#mytablePromoPaket').DataTable().ajax.reload();
                        $('#editPromoProductPaket')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                        $("#edit_bagiantambahproduk").html("");
                        $("#edit_bagiantambahproduk1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $('#mytablePromoPaket').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Apa Kamu Yakin?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus saja!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url("product/delete_promo_paket") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "kd_promo": id,
                        },
                        success: function(data) {
                            if (data.response == "success") {
                                $('#mytablePromoPaket').DataTable().ajax.reload();
                                $(".flash-data1").html(data.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                        }
                    });
                }
            });
        });

        $("#qtypaket1").keyup(function() {

            var maxGroupbarang = $("#jmlbarang").val();
            var qty = $("#qtypaket1").val();
            var hargaProduk = $("#harga_produkk1").val();
            var ujroh = $("#hid_ujroh1").val();
            var ujrohSelera = $("#hid_ujroh_selera1").val();

            $("#harga_produk1").val(qty * hargaProduk);

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

            $("#ujroh1").val(parseInt(qty) * parseInt(ujroh));
            $("#ujroh_selera1").val(parseInt(qty) * parseInt(ujrohSelera));

            $("#harga_modal").val(myTotalModal);
        })

        $("#addPromoProductPaket").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addPromoProductPaket').serialize();

            $.ajax({
                url: "<?php echo base_url("Product/add_promo_paket") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytablePromoPaket').DataTable().ajax.reload();
                        $('#addPromoProductPaket')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                        $("#bagiantambahproduk").html("");
                        $("#promo_produk").val("").trigger('change');
                        // $("#jenis_promo").val("").trigger('change');
                        // $('#bagian_tanggal').hide();
                        // $('#bagian_waktu').hide();
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })
        // End Bagian Promo Paket Aktif

        // bagian Promo Paket Non Aktif

        $('#mytablePromoPaketNonAktif').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('product/get_product_promo_paket/0') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nama_promo",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nama_promo",
                    class: "text-center",
                },
                {
                    data: "date_start",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return ubah_tanggal(data);
                    }
                },
                {
                    data: "time_start",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return data.slice(0, 5) + " - " + row.time_end.slice(0, 5) + " WIB";
                    }
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytablePromoPaketNonAktif').on('click', '.edit_record', function() {
            let id = $(this).data('id');
            var text = "";

            $.ajax({
                url: "<?php echo base_url("Product/getPromoById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_promo": id
                },
                success: function(data) {
                    $('#edit_kode_promo').val(data.kd_promo);
                    $('#edit_nama_promo').val(data.nama_promo);
                    $('#edit_harga_modal').val(data.harga_modal_promo);
                    $('#edit_harga_promo').val(data.harga_hasil_promo);
                    $('#edit_stok').val(data.stok_paket);
                    $('#edit_status_ujroh').val(data.status_ujroh);

                    $('#edit_datepickersingle').val(data.date_start);
                    $('#edit_datepickersingle1').val(data.date_end);
                    $('#edit_time_start').val(data.time_start);
                    $('#edit_time_end').val(data.time_end);

                    $.ajax({
                        url: "<?php echo base_url("Product/getDetailPromoById") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            kd_promo: data.kd_promo
                        },

                        success: function(result) {
                            $('#edit_jmlbarangplus').val(result.length);
                            $('#edit_jmlbarang1').val(result.length);
                            var j = 1;
                            for (let i = 0; i < result.length; i++) {
                                text = '<div id="bagiantambahprodukpaket' +
                                    i +
                                    '"><div class="row"><div class="col-md-6 col-xs-6 col-6"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2produkpaket' + j + '" id="edit_promo_produk' + j + '" required><option value=' + result[i].kd_detail_produk + ' selected>' +
                                    result[i].nm_produk + " - " + result[i].berat + ' ' + result[i].satuan_berat + '</option></select></div></div><div class="col-md-1 col-xs-1 col-1"><label>QTY</label><input type="text" class="form-control" name="qty[]" id="edit_qtypaket' + j + '" value="' + result[i].qty + '" placeholder="QTY" required></div><div class="col-md-4 col-xs-4 col-4"><label for="harga_produk">Harga Menu</label><div class="input-group"><input type="text" class="form-control input-rupiah-mask' + j + '" name="harga_produk[]" id="edit_harga_produk' + j + '" value="' + (result[i].harga_produk * result[i].qty) + '" placeholder="Harga Menu" readonly required><input type="hidden" class="form-control input-rupiah-mask' + j +
                                    '" id="edit_harga_produkk' +
                                    j +
                                    '" placeholder="Harga Menu" value="' + result[i].harga_produk + '" readonly required><span class="input-group-append"><button type="button" class="btn btn-info btn-flat eujrohpaketan' + j + '"><i class="fas fa-dollar-sign"></i> </button></span></div></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusprodukpaket' + i + '"> <i class="fa fa-minus"></i></a></div></div></div>';

                                $('#edit_bagiantambahprodukpaket').append(text);

                                text1 = '<div id="bagiantambahujrohprodukpaket' +
                                    i +
                                    '"><div class="modal fade" id="Modal_ujroh_paketann' + j + '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">Detail Ujroh</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="row"><div class="col-xs-6 col-md-6"><div class="form-group"><label for="">Jumlah Ujroh Selera</label><input type="text" name="ujroh_selera[]" value="' + result[i].ujroh_promo_selera + '" id="editt_ujroh_selera' + j + '" class="form-control rupiah-mask"><input type="hidden" value="' + result[i].ujroh_promo_selera + '" id="edit_hid_ujroh_selera' + j + '" class="form-control rupiah-mask" readonly><input type="hidden" value="' + result[i].ujroh_promo + '" id="edit_hid_ujroh' + j + '" class="form-control rupiah-mask" readonly></div></div><div class="col-xs-6 col-md-6"><div class="form-group"><label for="">Jumlah Ujroh Reseller</label><input type="text" name="ujroh[]" value="' + result[i].ujroh_promo + '" id="editt_ujroh' + j + '" class="form-control rupiah-mask"></div></div></div></div></div></div></div>';

                                $('.edit-tmpt-ujroh-paket').append(text1);

                                $(".eujrohpaketan" + j).click(function() {
                                    var j = i + 1;
                                    var promo_produk = $("#edit_promo_produk" + j).val();
                                    if (promo_produk == "") {
                                        Toast.fire({
                                            icon: "error",
                                            title: "Produk Harus Dipilih Terlebih Dahulu",
                                        });
                                    } else {
                                        $("#Modal_ujroh_paketann" + j).modal("show");
                                    }
                                })

                                $("body").on("click", "#buttonhapusprodukpaket" + i, function() {
                                    $("#edit_jmlbarang1").val(parseInt($("#edit_jmlbarang1").val()) - 1);

                                    var x = i + 1;
                                    var hargaDihapus = $("#edit_harga_produk" + x).val();
                                    var hargaModal = $("#edit_harga_modal").val();

                                    if (isNaN(hargaDihapus)) hargaDihapus = 0;

                                    $("#edit_harga_modal").val(parseInt(hargaModal) - parseInt(hargaDihapus));

                                    $(this)
                                        .parents("#bagiantambahprodukpaket" + i)
                                        .remove();

                                    $(this)
                                        .parents("#bagiantambahujrohprodukpaket" + i)
                                        .remove();
                                });

                                $("#edit_qtypaket" + j).keyup(function() {
                                    var j = i + 1;
                                    var maxGroupbarang = $("#jmlbarang").val();
                                    var qty = $("#edit_qtypaket" + j).val();
                                    var hargaProduk = $("#edit_harga_produkk" + j).val();
                                    var ujroh = $("#edit_hid_ujroh" + j).val();
                                    var ujrohSelera = $("#edit_hid_ujroh_selera" + j).val();

                                    $("#editt_ujroh" + j).val(parseInt(qty) * parseInt(ujroh));
                                    $("#editt_ujroh_selera" + j).val(parseInt(qty) * parseInt(ujrohSelera));
                                    var ujrohh = $("#editt_ujroh" + j).val();
                                    var ujrohhSelera = $("#editt_ujroh_selera" + j).val();

                                    $("#edit_harga_produk" + j).val(qty * hargaProduk);

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

                                $(".select2produkpaket" + j).select2({
                                    placeholder: "Pilih Produk",
                                    ajax: {
                                        url: base_url + "/select2/get_json_detail_produk",
                                        type: "post",
                                        dataType: "json",
                                        delay: 100,
                                        data: function(params) {
                                            return {
                                                searchTerm: params.term, // search term
                                            };
                                        },
                                        processResults: function(response) {
                                            return {
                                                results: response,
                                            };
                                        },
                                        cache: true,
                                    },
                                });

                                $(".select2produkpaket" + j).on("select2:select", function(e) {
                                    var j = i + 1;
                                    var harga = e.params.data.harga;
                                    var maxGroupbarang = $("#jmlbarang").val();
                                    var qty = $("#edit_qtypaket" + j).val();

                                    if (qty != "") {
                                        if (isNaN(qty)) qty = 0;
                                        $("#edit_harga_produk" + j).val(harga * qty);
                                    } else {
                                        $("#edit_harga_produk" + j).val(harga);
                                        $("#edit_harga_produkk" + j).val(harga);
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

                                $(".input-rupiah-mask" + j).inputmask({
                                    alias: 'numeric',
                                    groupSeparator: ',',
                                    autoGroup: true,
                                    digits: 0,
                                    digitsOptional: false,
                                    prefix: 'Rp. ',
                                    placeholder: '0',
                                    rightAlign: false,
                                    autoUnmask: true,
                                    removeMaskOnSubmit: true
                                });

                                $('#edit_harga_promo' + j).keyup(function() {
                                    var harga_promo = parseInt($('#edit_harga_promo' + j).val());
                                    var harga_produk = parseInt($('#edit_harga_produk' + j).val());
                                    if (harga_promo > harga_produk) {
                                        $(".error-data1").html("Harga Promo tidak bisa lebih dari Harga Menu.");
                                        $(".flash-data1").html("");
                                        toast();
                                        $('#edit_harga_promo' + j).val(0);
                                    }
                                })
                                j++;
                            }
                        }
                    });
                }
            });
            $('#Modal_Edit').modal({
                backdrop: 'static',
                keyboard: false
            })
        })

        $("#editPromoProductPaket").submit(function(e) {
            e.preventDefault();
            let dataString = $('#editPromoProductPaket').serialize();

            $.ajax({
                url: "<?php echo base_url("Product/edit_promo_paket") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#mytablePromoPaketNonAktif').DataTable().ajax.reload();
                        $('#editPromoProductPaket')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                        $("#edit_bagiantambahproduk").html("");
                        $("#edit_bagiantambahproduk1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $('#mytablePromoPaketNonAktif').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Apa Kamu Yakin?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus saja!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url("product/delete_promo_paket") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "kd_promo": id,
                        },
                        success: function(data) {
                            if (data.response == "success") {
                                $('#mytablePromoPaketNonAktif').DataTable().ajax.reload();
                                $(".flash-data1").html(data.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                        }
                    });
                }
            });
        });

        $("#addPromoProductPaket").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addPromoProductPaket').serialize();

            $.ajax({
                url: "<?php echo base_url("Product/add_promo_paket") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytablePromoPaket').DataTable().ajax.reload();
                        $('#addPromoProductPaket')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                        $("#bagiantambahproduk").html("");
                        $("#promo_produk").val("").trigger('change');
                        // $("#jenis_promo").val("").trigger('change');
                        // $('#bagian_tanggal').hide();
                        // $('#bagian_waktu').hide();
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })
        // End Bagian Promo Paket Non Aktif

        // Bagian Promo Harga Grosir
        $('#mytableHargaGrosir').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('product/get_product_harga_grosir') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nama_promo",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nama_promo",
                    class: "text-center",
                },
                {
                    data: "date_start",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return ubah_tanggal(data);
                    }
                },
                {
                    data: "time_start",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return data.slice(0, 5) + " - " + row.time_end.slice(0, 5) + " WIB";
                    }
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $("#addHargaGrosir").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addHargaGrosir').serialize();

            $.ajax({
                url: "<?php echo base_url("Product/add_harga_grosir") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytableHargaGrosir').DataTable().ajax.reload();
                        $('#addHargaGrosir')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                        $("#bagiantambahprodukpaket").html("");
                        $("#bagiantambahprodukbonus").html("");
                        $("#promo_produk").val("").trigger('change');
                        $("#promo_produk_bonus").val("").trigger('change');
                        // $("#jenis_promo").val("").trigger('change');
                        // $('#bagian_tanggal').hide();
                        // $('#bagian_waktu').hide();
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $('#mytableHargaGrosir').on('click', '.edit_record', function() {
            let id = $(this).data('id');
            var text = "";

            $.ajax({
                url: "<?php echo base_url("Product/getHargaGrosirById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_grosir": id
                },
                success: function(data) {
                    $('#edit_kode_grosir').val(data.kd_promo_harga_grosir);
                    $('#edit_nama_grosir').val(data.nama_promo);
                    $('#edit_datepickersingle').val(data.date_start);
                    $('#edit_datepickersingle1').val(data.date_end);
                    $('#edit_time_start').val(data.time_start);
                    $('#edit_time_end').val(data.time_end);
                    $('#edit_status_ujroh').val(data.status_ujroh);

                    $.ajax({
                        url: "<?php echo base_url("Product/getDetailGrosirById") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            kd_grosir: data.kd_promo_harga_grosir
                        },

                        success: function(result) {
                            $('#edit_jmlbarangplus').val(result.length);
                            $('#edit_jmlbarang1').val(result.length);
                            var j = 1;
                            for (let i = 0; i < result.length; i++) {
                                text = '<div id="bagiantambahprodukpaket' +
                                    i +
                                    '"><div class="row"><div class="col-md-4 col-xs-4 col-4"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2produkgrosir' + j + '" id="edit_promo_produk' + j + '" required><option value=' + result[i].kd_detail_grosir + ' selected>' + result[i].nm_produk + " - " + result[i].berat + ' ' + result[i].satuan_berat + '</option></select></div></div><div class="col-md-3 col-xs-3 col-3"><label for="harga_produk">Harga Menu</label><div class="input-group"><input type="text" class="form-control input-rupiah-mask' + j + '" value=' + result[i].harga_produk + ' name="harga_produk[]" id="edit_harga_produk' + j + '" placeholder="Harga Menu" readonly required><input type="hidden" class="form-control input-rupiah-mask" id="edit_harga_produkk' + j + '" placeholder="Harga Menu" readonly required></div></div><div class="col-md-1 col-xs-1 col-1"><label>QTY</label><input type="text" class="form-control" name="qty[]" id="edit_qtygrosir' + j + '" placeholder="QTY" value="' + result[i].min_pembelian_produk + '" required></div><div class="col-md-3 col-xs-3 col-3"><label for="harga_produk">Harga Grosir</label><div class="input-group"><input type="text" class="form-control input-rupiah-mask' + j + '" name="harga_grosir[]" value="' + result[i].harga_grosir + '" id="edit_harga_grosir' + j + '" placeholder="Harga Grosir" required><span class="input-group-append"><button type="button" class="btn btn-info btn-flat" id="eujrohgrosir' + i + '"><i class="fas fa-dollar-sign"></i> </button></span></div></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusprodukgrosir' + i + '"> <i class="fa fa-minus"></i></a></div></div></div>';

                                $('#edit_bagiantambahprodukpaket').append(text);

                                text1 = '<div id="bagiantambahujrohprodukpaket' +
                                    i +
                                    '"><div class="modal fade" id="Modal_ujroh_grosirr' + j + '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLabel">Detail Ujroh</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="row"><div class="col-xs-6 col-md-6"><div class="form-group"><label for="">Jumlah Ujroh Selera</label><input type="text" name="ujroh_selera[]" value="' + result[i].ujroh_grosir_selera + '" id="editt_ujroh_selera' + j + '" class="form-control input-rupiah-mask' + j + '"></div></div><div class="col-xs-6 col-md-6"><div class="form-group"><label for="">Jumlah Ujroh Reseller</label><input type="text" name="ujroh[]" value="' + result[i].ujroh_grosir_reseller + '" id="editt_ujroh' + j + '" class="form-control input-rupiah-mask' + j + '"></div></div></div></div></div></div></div>';

                                $('.edit-tmpt-ujroh-grosir').append(text1);

                                $("#eujrohgrosir" + i).click(function() {
                                    var j = i + 1;
                                    var promo_produk = $("#edit_promo_produk" + j).val();
                                    if (promo_produk == "") {
                                        Toast.fire({
                                            icon: "error",
                                            title: "Produk Harus Dipilih Terlebih Dahulu",
                                        });
                                    } else {
                                        $("#Modal_ujroh_grosirr" + j).modal("show");
                                    }
                                })

                                $("body").on("click", "#buttonhapusprodukgrosir" + i, function() {
                                    $("#edit_jmlbarang1").val(parseInt($("#edit_jmlbarang1").val()) - 1);

                                    var x = i + 1;
                                    var hargaDihapus = $("#edit_harga_produk" + x).val();
                                    var hargaModal = $("#edit_harga_modal").val();

                                    if (isNaN(hargaDihapus)) hargaDihapus = 0;

                                    $("#edit_harga_modal").val(parseInt(hargaModal) - parseInt(hargaDihapus));

                                    $(this)
                                        .parents("#bagiantambahprodukpaket" + i)
                                        .remove();

                                    $(this)
                                        .parents("#bagiantambahujrohprodukpaket" + i)
                                        .remove();
                                });

                                $("#edit_qtypaket" + j).keyup(function() {
                                    var j = i + 1;
                                    var maxGroupbarang = $("#jmlbarang").val();
                                    var qty = $("#edit_qtypaket" + j).val();
                                    var hargaProduk = $("#edit_harga_produkk" + j).val();
                                    var ujroh = $("#edit_hid_ujroh" + j).val();
                                    var ujrohSelera = $("#edit_hid_ujroh_selera" + j).val();

                                    $("#editt_ujroh" + j).val(parseInt(qty) * parseInt(ujroh));
                                    $("#editt_ujroh_selera" + j).val(parseInt(qty) * parseInt(ujrohSelera));
                                    var ujrohh = $("#editt_ujroh" + j).val();
                                    var ujrohhSelera = $("#editt_ujroh_selera" + j).val();

                                    $("#edit_harga_produk" + j).val(qty * hargaProduk);

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

                                $(".select2produkgrosir" + j).select2({
                                    placeholder: "Pilih Produk",
                                    ajax: {
                                        url: base_url + "/select2/get_json_detail_produk",
                                        type: "post",
                                        dataType: "json",
                                        delay: 100,
                                        data: function(params) {
                                            return {
                                                searchTerm: params.term, // search term
                                            };
                                        },
                                        processResults: function(response) {
                                            return {
                                                results: response,
                                            };
                                        },
                                        cache: true,
                                    },
                                });

                                $(".select2produkgrosir" + j).on("select2:select", function(e) {
                                    var j = i + 1;
                                    var harga = e.params.data.harga;
                                    var ujroh = e.params.data.jmlKomisi;
                                    var ujrohSelera = e.params.data.jmlKomisiSelera;
                                    var maxGroupbarang = $("#jmlbarang").val();
                                    $("#edit_harga_produk" + j).val(harga);
                                    var qty = $("#edit_qtypaket" + j).val();

                                    $("#edit_harga_produk" + j).val(harga);
                                    $("#edit_harga_produkk" + j).val(harga);

                                    $("#editt_ujroh" + j).val(ujroh);
                                    $("#editt_ujroh_selera" + j).val(ujrohSelera);

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

                                    $("#harga_modal").val(myTotalModal);
                                });

                                $(".input-rupiah-mask" + j).inputmask({
                                    alias: 'numeric',
                                    groupSeparator: ',',
                                    autoGroup: true,
                                    digits: 0,
                                    digitsOptional: false,
                                    prefix: 'Rp. ',
                                    placeholder: '0',
                                    rightAlign: false,
                                    autoUnmask: true,
                                    removeMaskOnSubmit: true
                                });

                                $('#edit_harga_promo' + j).keyup(function() {
                                    var harga_promo = parseInt($('#edit_harga_promo' + j).val());
                                    var harga_produk = parseInt($('#edit_harga_produk' + j).val());
                                    if (harga_promo > harga_produk) {
                                        $(".error-data1").html("Harga Promo tidak bisa lebih dari Harga Menu.");
                                        $(".flash-data1").html("");
                                        toast();
                                        $('#edit_harga_promo' + j).val(0);
                                    }
                                })
                                j++;
                            }
                        }
                    });
                }
            });
            $('#Modal_Edit').modal({
                backdrop: 'static',
                keyboard: false
            })
        })

        $("#editHargaGrosir").submit(function(e) {
            e.preventDefault();
            let dataString = $('#editHargaGrosir').serialize();

            $.ajax({
                url: "<?php echo base_url("Product/edit_harga_grosir") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#mytableHargaGrosir').DataTable().ajax.reload();
                        $('#editHargaGrosir')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                        $("#edit_bagiantambahproduk").html("");
                        $("#edit_bagiantambahproduk1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $('#mytableHargaGrosir').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Apa Kamu Yakin?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus saja!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url("product/delete_harga_grosir") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "kd_grosir": id,
                        },
                        success: function(data) {
                            if (data.response == "success") {
                                $('#mytableHargaGrosir').DataTable().ajax.reload();
                                $(".flash-data1").html(data.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                        }
                    });
                }
            });
        });

        $("#qtypaket1").keyup(function() {

            var maxGroupbarang = $("#jmlbarang").val();
            var qty = $("#qtypaket1").val();
            var hargaProduk = $("#harga_produkk1").val();
            var ujroh = $("#hid_ujroh1").val();
            var ujrohSelera = $("#hid_ujroh_selera1").val();

            $("#harga_produk1").val(qty * hargaProduk);

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

            $("#ujroh1").val(parseInt(qty) * parseInt(ujroh));
            $("#ujroh_selera1").val(parseInt(qty) * parseInt(ujrohSelera));

            $("#harga_modal").val(myTotalModal);
        })

        // End Bagian Promo Harga Grosir

        // End Bagian Promo Paket Bonus

        $('#mytablePromoBonus').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('product/get_product_promo_bonus') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nama_promo",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nama_promo",
                    class: "text-center",
                },
                {
                    data: "date_start",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return ubah_tanggal(data);
                    }
                },
                {
                    data: "time_start",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return data.slice(0, 5) + " - " + row.time_end.slice(0, 5) + " WIB";
                    }
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $("#addPromoProductBonus").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addPromoProductBonus').serialize();

            $.ajax({
                url: "<?php echo base_url("Product/add_promo_bonus") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytablePromoBonus').DataTable().ajax.reload();
                        $('#addPromoProductBonus')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                        $("#bagiantambahprodukpaket").html("");
                        $("#bagiantambahprodukbonus").html("");
                        $("#promo_produk").val("").trigger('change');
                        $("#promo_produk_bonus").val("").trigger('change');
                        // $("#jenis_promo").val("").trigger('change');
                        // $('#bagian_tanggal').hide();
                        // $('#bagian_waktu').hide();
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $("#editPromoProductBonus").submit(function(e) {
            e.preventDefault();
            let dataString = $('#editPromoProductBonus').serialize();

            $.ajax({
                url: "<?php echo base_url("Product/edit_promo_bonus") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#mytablePromoBonus').DataTable().ajax.reload();
                        $('#editPromoProductBonus')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");

                        $("#edit_bagiantambahprodukpaketbonus").html("");
                        $("#edit_bagiantambahprodukpaketbonus1").html("");
                        $("#edit_bagiantambahprodukbonus").html("");
                        $("#edit_bagiantambahprodukbonus1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $('#mytablePromoBonus').on('click', '.edit_record', function() {
            let id = $(this).data('id');
            var text = "";

            $.ajax({
                url: "<?php echo base_url("Product/getPromoById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_promo": id
                },
                success: function(data) {
                    $('#edit_kode_promo').val(data.kd_promo);
                    $('#edit_nama_promo').val(data.nama_promo);
                    $('#edit_harga_modal').val(data.harga_modal_promo);
                    $('#edit_harga_promo').val(data.harga_hasil_promo);

                    if (data.date_end == null) {
                        $('#edit_jenis_promo').val(1);
                        $('#edit_bagian_tanggal').show();
                        $('#edit_bagian_tanggal_start').removeClass("col-md-6 col-xs-6 col-6");
                        $('#edit_bagian_tanggal_start').addClass("col-md-12 col-xs-12 col-12");
                        $('#edit_bagian_tanggal_end').hide();
                        $('#edit_bagian_waktu').show();
                        $('#edit_datepickersingle1').removeAttr("reqiured");
                        $('#edit_datepickersingle').attr("reqiured", true);
                        $('#edit_time_start').attr("reqiured", true);
                        $('#edit_time_end').attr("reqiured", true);

                        $('#edit_datepickersingle').val(data.date_start);
                        $('#edit_time_start').val(data.time_start);
                        $('#edit_time_end').val(data.time_end);
                    } else if (data.time_start == null && data.time_end == null) {
                        $('#edit_jenis_promo').val(2);
                        $('#edit_bagian_tanggal').show();
                        $('#edit_bagian_tanggal_start').addClass("col-md-6 col-xs-6 col-6");
                        $('#edit_bagian_tanggal_start').removeClass("col-md-12 col-xs-12 col-12");
                        $('#edit_bagian_tanggal_end').show();
                        $('#edit_bagian_waktu').hide();
                        $('#edit_datepickersingle').attr("reqiured", true);
                        $('#edit_datepickersingle1').attr("reqiured", true);
                        $('#edit_time_start').removeAttr("reqiured");
                        $('#edit_time_end').removeAttr("reqiured");
                        $('#edit_datepickersingle').val(data.date_start);
                        $('#edit_datepickersingle1').val(data.date_end);
                    }

                    $.ajax({
                        url: "<?php echo base_url("Product/getDetailPromoBonusById") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            kd_promo: data.kd_promo
                        },

                        success: function(result) {
                            $('#edit_jmlbarangplus').val(result.promo.length);
                            $('#edit_jmlbarang1').val(result.promo.length);

                            $('#edit_jmlbarangplusbonus').val(result.bonus.length);
                            $('#edit_jmlbarangbonus1').val(result.bonus.length);
                            var j = 1;
                            for (let i = 0; i < result.promo.length; i++) {
                                text = '<div id="bagiantambahprodukpaket' +
                                    i +
                                    '"><div class="row"><div class="col-md-6 col-xs-6 col-6"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control select2produkpaket' + j + '" id="edit_promo_produk' + j + '" required><option value="' + result.promo[i].kd_detail_produk + '">' + result.promo[i].nm_produk + " - " + result.promo[i].berat + ' ' + result.promo[i].satuan_berat + '</option></select></div></div><div class="col-md-2 col-xs-2 col-2"><label>QTY</label><input type="text" class="form-control" name="qty[]" id="edit_qtypaket' + j + '" placeholder="QTY" value="' + result.promo[i].qty + '" required></div><div class="col-md-3 col-xs-3 col-3"><label>Harga Menu</label><input type="text" class="form-control input-rupiah-mask' + j + '" name="harga_produk[]" id="edit_harga_produk' + j + '" placeholder="Harga Menu" value="' + (result.promo[i].harga_produk * result.promo[i].qty) + '" readonly required><input type="hidden" class="form-control input-rupiah-mask' + j + '" id="edit_harga_produkk' + j + '" placeholder="Harga Menu"  value="' + result.promo[i].harga_produk + '" readonly required></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusprodukpaket' +
                                    i +
                                    '"> <i class="fa fa-minus"></i></a></div></div></div>';

                                $('#edit_bagiantambahprodukpaketbonus').append(text);

                                $("body").on("click", "#buttonhapusprodukpaket" + i, function() {
                                    $("#edit_jmlbarang1").val(parseInt($("#edit_jmlbarang1").val()) - 1);

                                    var x = i + 1;
                                    var hargaDihapus = $("#edit_harga_produk" + x).val();
                                    var hargaModal = $("#edit_harga_modal").val();

                                    if (isNaN(hargaDihapus)) hargaDihapus = 0;

                                    $("#edit_harga_modal").val(parseInt(hargaModal) - parseInt(hargaDihapus));

                                    $(this)
                                        .parents("#bagiantambahprodukpaket" + i)
                                        .remove();
                                });

                                $("#edit_qtypaket" + j).keyup(function() {
                                    var j = i + 1;
                                    var maxGroupbarang = $("#jmlbarang").val();
                                    var qty = $("#edit_qtypaket" + j).val();
                                    var hargaProduk = $("#edit_harga_produkk" + j).val();

                                    $("#edit_harga_produk" + j).val(qty * hargaProduk);

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

                                $(".select2produkpaket" + j).select2({
                                    placeholder: "Pilih Produk",
                                    ajax: {
                                        url: base_url + "/select2/get_json_detail_produk",
                                        type: "post",
                                        dataType: "json",
                                        delay: 100,
                                        data: function(params) {
                                            return {
                                                searchTerm: params.term, // search term
                                            };
                                        },
                                        processResults: function(response) {
                                            return {
                                                results: response,
                                            };
                                        },
                                        cache: true,
                                    },
                                });

                                $(".select2produkpaket" + j).on("select2:select", function(e) {
                                    var j = i + 1;
                                    var harga = e.params.data.harga;
                                    var maxGroupbarang = $("#jmlbarang").val();
                                    var qty = $("#edit_qtypaket" + j).val();

                                    if (qty != "") {
                                        if (isNaN(qty)) qty = 0;
                                        $("#edit_harga_produk" + j).val(harga * qty);
                                    } else {
                                        $("#edit_harga_produk" + j).val(harga);
                                        $("#edit_harga_produkk" + j).val(harga);
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

                                $(".input-rupiah-mask" + j).inputmask({
                                    alias: 'numeric',
                                    groupSeparator: ',',
                                    autoGroup: true,
                                    digits: 0,
                                    digitsOptional: false,
                                    prefix: 'Rp. ',
                                    placeholder: '0',
                                    rightAlign: false,
                                    autoUnmask: true,
                                    removeMaskOnSubmit: true
                                });

                                $('#edit_harga_promo' + j).keyup(function() {
                                    var harga_promo = parseInt($('#edit_harga_promo' + j).val());
                                    var harga_produk = parseInt($('#edit_harga_produk' + j).val());
                                    if (harga_promo > harga_produk) {
                                        $(".error-data1").html("Harga Promo tidak bisa lebih dari Harga Menu.");
                                        $(".flash-data1").html("");
                                        toast();
                                        $('#edit_harga_promo' + j).val(0);
                                    }
                                })
                                j++;
                            }

                            for (let i = 0; i < result.bonus.length; i++) {
                                text = '<div id="bagiantambahprodukpaket' +
                                    i +
                                    '"><div class="row"><div class="col-md-8 col-xs-8 col-8"><div class="form-group"><label>Produk</label><select name="produk_bonus[]" class="form-control select2produkbonus' + j + '" id="promo_produk_bonus' + j + '" required><option value="' + result.bonus[i].kd_detail_produk + '">' + result.bonus[i].nm_produk + " - " + result.bonus[i].berat + ' ' + result.bonus[i].satuan_berat + '</option></select></div></div><div class="col-md-3 col-xs-3 col-3"><label>QTY</label><input type="text" class="form-control" name="qty_bonus[]" id="qtybonus' + j + '" placeholder="QTY" value="' + result.bonus[i].qty + '" required></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapusprodukpaketbonus' + i + '"> <i class="fa fa-minus"></i></a></div></div></div>';

                                $('#edit_bagiantambahprodukbonus').append(text);

                                $("body").on("click", "#buttonhapusprodukpaketbonus" + i, function() {
                                    $("#edit_jmlbarang1").val(parseInt($("#edit_jmlbarang1").val()) - 1);

                                    var x = i + 1;
                                    var hargaDihapus = $("#edit_harga_produk" + x).val();
                                    var hargaModal = $("#edit_harga_modal").val();

                                    if (isNaN(hargaDihapus)) hargaDihapus = 0;

                                    $("#edit_harga_modal").val(parseInt(hargaModal) - parseInt(hargaDihapus));

                                    $(this)
                                        .parents("#bagiantambahprodukpaket" + i)
                                        .remove();
                                });

                                $("#edit_qtypaket" + j).keyup(function() {
                                    var j = i + 1;
                                    var maxGroupbarang = $("#jmlbarang").val();
                                    var qty = $("#edit_qtypaket" + j).val();
                                    var hargaProduk = $("#edit_harga_produkk" + j).val();

                                    $("#edit_harga_produk" + j).val(qty * hargaProduk);

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

                                $(".select2produkbonus" + j).select2({
                                    placeholder: "Pilih Produk",
                                    ajax: {
                                        url: base_url + "/select2/get_json_detail_produk",
                                        type: "post",
                                        dataType: "json",
                                        delay: 100,
                                        data: function(params) {
                                            return {
                                                searchTerm: params.term, // search term
                                            };
                                        },
                                        processResults: function(response) {
                                            return {
                                                results: response,
                                            };
                                        },
                                        cache: true,
                                    },
                                });

                                $(".input-rupiah-mask" + j).inputmask({
                                    alias: 'numeric',
                                    groupSeparator: ',',
                                    autoGroup: true,
                                    digits: 0,
                                    digitsOptional: false,
                                    prefix: 'Rp. ',
                                    placeholder: '0',
                                    rightAlign: false,
                                    autoUnmask: true,
                                    removeMaskOnSubmit: true
                                });

                                $('#edit_harga_promo' + j).keyup(function() {
                                    var harga_promo = parseInt($('#edit_harga_promo' + j).val());
                                    var harga_produk = parseInt($('#edit_harga_produk' + j).val());
                                    if (harga_promo > harga_produk) {
                                        $(".error-data1").html("Harga Promo tidak bisa lebih dari Harga Menu.");
                                        $(".flash-data1").html("");
                                        toast();
                                        $('#edit_harga_promo' + j).val(0);
                                    }
                                })
                                j++;
                            }
                        }
                    });
                }
            });
            $('#Modal_Edit').modal({
                backdrop: 'static',
                keyboard: false
            })
        })

        $("#editPromoProductPaket").submit(function(e) {
            e.preventDefault();
            let dataString = $('#editPromoProductPaket').serialize();

            $.ajax({
                url: "<?php echo base_url("Product/edit_promo_paket") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#mytablePromoPaket').DataTable().ajax.reload();
                        $('#editPromoProductPaket')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                        $("#edit_bagiantambahproduk").html("");
                        $("#edit_bagiantambahproduk1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $('#mytablePromoBonus').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Apa Kamu Yakin?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus saja!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url("product/delete_promo_bonus") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "kd_promo": id,
                        },
                        success: function(data) {
                            if (data.response == "success") {
                                $('#mytablePromoBonus').DataTable().ajax.reload();
                                $(".flash-data1").html(data.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                        }
                    });
                }
            });
        });

        $("#qtypaket1").keyup(function() {

            var maxGroupbarang = $("#jmlbarang").val();
            var qty = $("#qtypaket1").val();
            var hargaProduk = $("#harga_produkk1").val();

            $("#harga_produk1").val(qty * hargaProduk);

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
        })

        $("#addPromoPaket").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addPromoPaket').serialize();

            $.ajax({
                url: "<?php echo base_url("Product/add_promo_paket") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytablePromoPaket').DataTable().ajax.reload();
                        $('#addPromoPaket')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                        $("#bagiantambahproduk").html("");
                        $("#promo_produk").val("").trigger('change');
                        // $("#jenis_promo").val("").trigger('change');
                        // $('#bagian_tanggal').hide();
                        // $('#bagian_waktu').hide();
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })
        // End Bagian Promo Paket Bonus

        // Bagian Pre Order

        $('#mytablePo').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('product/get_product_po') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "kd_pre_order",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "date_start",
                    class: "text-center",
                    render: function(data, type, row) {
                        return ubah_tanggal(data);
                    },
                },
                {
                    data: "date_end",
                    class: "text-center",
                    render: function(data, type, row) {
                        return ubah_tanggal(data);
                    },
                },
                {
                    data: "jumlah",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return data + " Produk";
                    }
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $("#addPoProduct").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addPoProduct').serialize();

            $.ajax({
                url: "<?php echo base_url("Product/add_po") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytablePo').DataTable().ajax.reload();
                        $('#addPoProduct')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                        $("#bagiantambahproduk").html("");
                        $("#produk_po").val("").trigger('change');
                        $("#bagiantambahpo").remove();
                        $(".tambah_poo").append('<div id="bagiantambahpo"></div>');
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $('#mytablePo').on('click', '.copy_record', function() {
            let id = $(this).data('id');

            $.ajax({
                url: base_url + '/product/copy_produk_po/' + id,
                type: 'post',
                dataType: 'json',
                success: function(data) {

                    $('#Modal_List').modal('hide');
                    var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

                    var hari = new Date().getDay();
                    var tanggal = new Date().getDate();
                    var bulan = new Date().getMonth();
                    var tahun = new Date().getFullYear();
                    var hari_ini = '*' + days[hari] + ', ' + tanggal + ' ' + months[bulan] + ' ' + tahun + '*';
                    var html = '<span>https://www.instagram.com/p/CNRLwsOjlhV/?utm_medium=copy_link' + '<br>';
                    html += '_Follow dan cek ig kita_' + '<br><br>';
                    html += '*SELERA MART*' + '<br>';
                    html += 'Open PO untuk ' + hari_ini + '<br><br>';
                    html += '_kami close order jam 16.00 ya bund_ 🤗' + '<br>';

                    var no = 1;
                    var tampunganKategori = [];
                    var tampunganSubKategori = [];

                    for (let i = 0; i < data.length; i++) {

                        if (!tampunganKategori.includes(data[i].nm_kategori + data[i].kd_sub_kategori)) {
                            tampunganKategori.push(data[i].nm_kategori + data[i].kd_sub_kategori);
                            no = 1;

                            html += '<br> *' + data[i].nm_kategori + ' (' + data[i].nm_sub_kategori + ')* <br>';
                        }

                        html += '✅' + data[i].nm_produk + ' (' + data[i].berat + ' ' + data[i].satuan_berat + ') *' + data[i].harga_produk / 1000 + 'K* <br>';

                        no++;
                    }
                    html += 'Order di wa.me//628118880439' + '<br><br>';
                    html += 'Masih banyak pilihan lain di :' + '<br>';
                    html += 'https://wa.me/c/628118880439' + '<br><br>';
                    html += 'atau di Website kami' + '<br><br>';
                    html += 'https://CateringKita.com' + '<br><br>';
                    html += 'Yuk, yuk, makan enak-enak 🤗';

                    setTimeout(() => {
                        html += '</span>';
                        $("#divid").html(html);

                        if (document.selection) {
                            var range = document.body.createTextRange();
                            range.moveToElementText(document.getElementById('divid'));
                            range.select().createTextRange();
                            document.execCommand("copy");
                        } else if (window.getSelection) {
                            var range = document.createRange();
                            range.selectNode(document.getElementById('divid'));
                            window.getSelection().addRange(range);
                            document.execCommand("copy");
                            alert("Data was copied, please share to customers or resellers CateringKita")
                        }

                        $("#divid").html("");
                        $("#divid").show();
                    }, 500);
                }
            });
        })

        $('#mytablePo').on('click', '.edit_record', function() {
            let id = $(this).data('id');
            var text = "";

            $.ajax({
                url: "<?php echo base_url("Product/getPoById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_pre_order": id
                },
                success: function(data) {
                    $('#edit_kode_promo').val(data.kd_promo);
                    $('#edit_nama_promo').val(data.nama_promo);

                    $('#edit_jenis_promo').val(2);
                    $('#edit_bagian_tanggal').show();
                    $('#edit_bagian_tanggal_start').addClass("col-md-6 col-xs-6 col-6");
                    $('#edit_bagian_tanggal_start').removeClass("col-md-12 col-xs-12 col-12");
                    $('#edit_bagian_tanggal_end').show();
                    $('#edit_bagian_waktu').hide();
                    $('#edit_datepickersingle').attr("reqiured", true);
                    $('#edit_datepickersingle1').attr("reqiured", true);
                    $('#edit_time_start').removeAttr("reqiured");
                    $('#edit_time_end').removeAttr("reqiured");
                    $('#edit_datepickersingle').val(data.date_start);
                    $('#edit_datepickersingle1').val(data.date_end);

                    $.ajax({
                        url: "<?php echo base_url("Product/getDetailPoById") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            kd_po: data.kd_pre_order
                        },

                        success: function(result) {

                            $("#edit_bagiantambahpo1").remove();
                            $(".edit_poo").append('<div id="edit_bagiantambahpo1"></div>');

                            $("#edit_bagiantambahpo").remove();
                            $(".edit__poo").append('<div id="edit_bagiantambahpo"></div>');

                            $('#edit_jmlbarangplus').val(result.length);
                            $('#edit_jmlbarang1').val(result.length);

                            for (let i = 0; i < result.length; i++) {
                                text = '<div id="bagianhapuspo' +
                                    i +
                                    '"><div class="row"><div class="col-md-11 col-xs-11 col-11"><div class="form-group"><label>Produk</label><select name="produk[]" class="form-control" id="promo_produk' +
                                    i + '" required><option value="' + result[i].kd_detail_produk + '" selected>' + result[i].nm_produk + " - " + result[i].berat + ' ' + result[i].satuan_berat + '</option></select></div></div><div class="col-md-1 col-xs-1 col-1"><label for="kd_supplier"></label><br><a href="javascript:void(0);" class="btn btn-danger mt-2 " id="buttonhapuspo' +
                                    i + '"> <i class="fa fa-minus"></i></a></div></div>';

                                $('#edit_bagiantambahpo').append(text);
                                $("body").on("click", "#buttonhapuspo" + i, function() {
                                    $("#edit_jmlbarang1").val(parseInt($("#edit_jmlbarang1").val()) - 1);

                                    $(this)
                                        .parents("#bagianhapuspo" + i)
                                        .remove();
                                });

                                $("#promo_produk" + i).select2({
                                    placeholder: "Pilih Produk",
                                    ajax: {
                                        url: base_url + "/select2/get_json_detail_produk",
                                        type: "post",
                                        dataType: "json",
                                        delay: 100,
                                        data: function(params) {
                                            return {
                                                searchTerm: params.term, // search term
                                            };
                                        },
                                        processResults: function(response) {
                                            return {
                                                results: response,
                                            };
                                        },
                                        cache: true,
                                    },
                                });

                                // $(".select2produkpoo" + i).on("select2:select", function(e) {
                                //     var harga = e.params.data.harga;
                                //     $('#edit_harga_produk' + i).val(harga);
                                // });

                                $(".input-rupiah-mask" + i).inputmask({
                                    alias: 'numeric',
                                    groupSeparator: ',',
                                    autoGroup: true,
                                    digits: 0,
                                    digitsOptional: false,
                                    prefix: 'Rp. ',
                                    placeholder: '0',
                                    rightAlign: false,
                                    autoUnmask: true,
                                    removeMaskOnSubmit: true
                                });
                            }
                        }
                    });
                }
            });
            $('#Modal_Edit').modal({
                backdrop: 'static',
                keyboard: false
            })
        })

        $('#mytablePo').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Apa Kamu Yakin?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus saja!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url("product/delete_po") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "kd_pre_order": id,
                        },
                        success: function(data) {
                            if (data.response == "success") {
                                $('#mytablePo').DataTable().ajax.reload();
                                $(".flash-data1").html(data.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                        }
                    });
                }
            });
        });

        $("#editPoProduct").submit(function(e) {
            e.preventDefault();
            let dataString = $('#editPoProduct').serialize();

            $.ajax({
                url: "<?php echo base_url("Product/edit_po") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#mytablePo').DataTable().ajax.reload();
                        $('#editPoProduct')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                        $("#edit_bagiantambahproduk").html("");
                        $("#edit_bagiantambahproduk1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        // End Bagian Pre Order

        // ----------------------------------------- Kelola Pemasukan Keuangan CateringKita -----------------------------------------

        $('#mytableKeuanganSelera').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('keuangan/get_keuangan_selera/DIV00001') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_divisi",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_divisi",
                    class: "text_center"
                },
                {
                    data: "pendapatan_divisi",
                    class: "text_center",
                    render: function(data, type, row) {
                        return convertToRupiah(data);
                    },
                }
            ],
        });

        $('.tanggal_pemasukan').daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: true,
            showDropdowns: true,
            minYear: 1901,
            locale: {
                format: 'YYYY-MM-DD'
            },
        });

        $('#mytablePemasukanSelera').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('keuangan/get_pemasukan_selera/DIV00001') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_pemasukan_divisi",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "tanggal_pemasukan",
                    class: "text_center",
                    render: function(data, type, row) {
                        return ubah_tanggal(data);
                    },
                },
                {
                    data: "nm_admin",
                    class: "text_center"
                },
                {
                    data: "nominal_pemasukan",
                    class: "text_center",
                    render: function(data, type, row) {
                        return convertToRupiah(data);
                    },
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $("#addPemasukanCateringKita").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addPemasukanCateringKita').serialize();
            $.ajax({
                url: "<?php echo base_url("keuangan/add_pemasukan_selera") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,
                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytablePemasukanSelera').DataTable().ajax.reload();
                        $('#addPemasukanCateringKita')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();

                    setTimeout(function() {
                        window.location.href = "<?php echo base_url() ?>keuangan/pemasukan";
                    }, 300);
                }
            });
        });

        $('#mytablePemasukanSelera').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("keuangan/getpemasukanselerabyid") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_pemasukan_divisi": id
                },
                success: function(data) {

                    $("#kd_pemasukan_divisi").val(data.kd_pemasukan_divisi);
                    $("#edit_tanggal_pemasukan").val(data.tanggal_pemasukan);
                    $("#edit_nominal_pemasukan").val(data.nominal_pemasukan);
                    $("#edit_keterangan").html(data.keterangan);
                    $("#edit_nis").val(data.nis).trigger('change');
                }
            });
            $('#Modal_Edit').modal('show');
        });

        $("#editPemasukanCateringKita").submit(function(e) {
            e.preventDefault();
            let dataString = $('#editPemasukanCateringKita').serialize();
            $.ajax({
                url: "<?php echo base_url("keuangan/edit_pemasukan_selera") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,
                success: function(data) {
                    if (data.message.response == "success") {
                        var pendapatan = data.divisi.pendapatan_divisi;
                        $(".keuangan_selera").html(convertToRupiah(pendapatan));
                        $('#Modal_Edit').modal('hide');
                        $('#mytablePemasukanSelera').DataTable().ajax.reload();
                        $('#editPemasukanCateringKita')[0].reset();
                        $(".flash-data1").html(data.message.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        $('#mytablePemasukanSelera').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Apa Kamu Yakin?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus saja!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url("keuangan/delete_pemasukan_selera") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "kd_pemasukan_divisi": id
                        },
                        success: function(data) {
                            if (data.message.response == "success") {
                                var pendapatan = data.divisi.pendapatan_divisi;
                                $(".keuangan_selera").html(convertToRupiah(pendapatan));
                                $('#mytablePemasukanSelera').DataTable().ajax.reload();
                                $(".flash-data1").html(data.message.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data.message.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                        }
                    });
                }
            });
        });

        // ----------------------------------------- End Kelola Pemasukan Keuangan CateringKita -----------------------------------------

        // ----------------------------------------- Kelola Pengeluaran Keuangan CateringKita -----------------------------------------

        $('.tanggal_pengeluaran').daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: true,
            showDropdowns: true,
            minYear: 1901,
            locale: {
                format: 'YYYY-MM-DD'
            },
        });

        $('#mytablePengeluaranSelera').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('keuangan/get_pengeluaran_selera/DIV00001') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_pengeluaran_divisi",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "tanggal_pengeluaran",
                    class: "text_center",
                    render: function(data, type, row) {
                        return ubah_tanggal(data);
                    },
                },
                {
                    data: "nm_admin",
                    class: "text_center"
                },
                {
                    data: "nominal_pengeluaran",
                    class: "text_center",
                    render: function(data, type, row) {
                        return convertToRupiah(data);
                    },
                },
                {
                    data: "keperluan",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $(".pengeluaran_selera").click(function() {
            $.ajax({
                url: "<?php echo base_url("keuangan/saldo_selera") ?>",
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    $("#total_pendapatan").val(data.pendapatan_divisi);
                    $("#mod_pengeluaran_selera").modal("show");
                }
            });
        })

        $("#btn_add_pengeluaran").click(function() {
            var pndpt = parseInt($("#total_pendapatan").val());
            var nomin = parseInt($("#nominal_pengeluaran").val());

            if (nomin > pndpt) {
                $(".error-data1").html("Maaf, Nominal Lebih Besar Dari Dana Yang Tersedia!");
                $(".flash-data1").html("");
                toast();

                return false;
            }
        })

        $("#addPengeluaranCateringKita").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addPengeluaranCateringKita').serialize();
            $.ajax({
                url: "<?php echo base_url("keuangan/add_pengeluaran_selera") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,
                success: function(data) {
                    if (data.response == "success") {
                        $('#mod_pengeluaran_selera').modal('hide');
                        $('#mytablePengeluaranSelera').DataTable().ajax.reload();
                        $('#addPengeluaranCateringKita')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();

                    setTimeout(function() {
                        window.location.href = "<?php echo base_url() ?>keuangan/pengeluaran";
                    }, 300);
                }
            });
        });

        $('#mytablePengeluaranSelera').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("keuangan/getpengeluarandivisibyid") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_pengeluaran_divisi": id
                },
                success: function(data) {
                    $("#kd_pengeluaran_divisi").val(data.pengeluaran.kd_pengeluaran_divisi);
                    $("#edit_tanggal_pengeluaran").val(data.pengeluaran.tanggal_pengeluaran);
                    $("#edit_total_pendapatan").val(data.divisi.pendapatan_divisi);
                    $("#edit_nominal_pengeluaran").val(data.pengeluaran.nominal_pengeluaran);
                    $("#edit_keperluan").html(data.pengeluaran.keperluan);
                    var data1 = [];
                    for (let i = 0; i < 1; i++) {
                        var obj = {};
                        obj = data.pengeluaran.kd_divisi;
                        if (obj == undefined || obj == "") {
                            obj = 0;
                        }
                        data1.push(obj);
                    }
                    var test = JSON.parse("[" + JSON.stringify(data1) + "]");
                    $("#edit_kd_divisi_select")
                        .select2()
                        .val(
                            test
                        ).trigger("change");
                    var data2 = [];
                    for (let j = 0; j < 1; j++) {
                        var obj = {};
                        obj = data.pengeluaran.kd_akun;
                        if (obj == undefined || obj == "") {
                            obj = 0;
                        }
                        data2.push(obj);
                    }
                    var test2 = JSON.parse("[" + JSON.stringify(data2) + "]");
                    $("#edit_kd_akun")
                        .select2()
                        .val(
                            test2
                        ).trigger("change");
                    $("#edit_nis").val(data.pengeluaran.nis).trigger('change');
                }
            });
            $('#Modal_Edit').modal('show');
        });

        $('#editPengeluaranCateringKita').submit(function(e) {
            e.preventDefault();

            let dataString = $('#editPengeluaranCateringKita').serialize();
            $.ajax({
                url: "<?php echo base_url("keuangan/edit_pengeluaran_selera") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,
                success: function(data) {
                    if (data.message.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $(".keuangan_selera").html(convertToRupiah(data.divisi.pendapatan_divisi));
                        $('#mytablePengeluaranSelera').DataTable().ajax.reload();
                        $('#editPengeluaranCateringKita')[0].reset();
                        $(".flash-data1").html(data.message.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $('#mytablePengeluaranSelera').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Apa Kamu Yakin?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus saja!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url("keuangan/delete_pengeluaran_selera") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "kd_pengeluaran_divisi": id
                        },
                        success: function(data) {
                            if (data.message.response == "success") {
                                $('#mytablePengeluaranSelera').DataTable().ajax.reload();
                                $(".keuangan_selera").html(convertToRupiah(data.divisi.pendapatan_divisi));
                                $(".flash-data1").html(data.message.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data.message.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                        }
                    });
                }
            });
        });

        // ----------------------------------------- End Kelola Pengeluaran Keuangan CateringKita -----------------------------------------

        // ----------------------------------------- Kelola Report-----------------------------------------

        $('#tanggal_order').daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: true,
            showDropdowns: true,
            minYear: 1901,
            locale: {
                format: 'YYYY-MM-DD'
            },
            maxYear: parseInt(moment().format('YYYY'), 10)
        });

        $('#tanggal_order').val(null);

        $('#tanggal_ujroh').daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: true,
            showDropdowns: true,
            minYear: 1901,
            locale: {
                format: 'YYYY-MM-DD'
            },
            maxYear: parseInt(moment().format('YYYY'), 10)
        });

        $('#tanggal_ujroh').val(null);

        report_order();
        report_ujroh();
        report_produk_masuk();
        report_efektivitas();
        report_selera();
        report_efektivitas_kurir_lain();

        function report_selera(is_date_search = '', bulan = '', tahun = '') {
            var dataTable = $('#report_selera').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo base_url("report/get_datatable_selera") ?>",
                    type: "POST",
                    data: {
                        bulan: bulan,
                        tahun: tahun,
                    }
                },
                "columns": [{
                        data: "created_at",
                        class: "text_center",
                        render: function(data, type, row) {
                            return ubah_tanggal(data);
                        },
                    },
                    {
                        data: "kd_order",
                        class: "text_center"
                    },
                    {
                        data: "jml_margin",
                        class: "text_center",
                        render: function(data, type, row) {
                            return convertToRupiah(data);
                        },
                    },
                    {
                        data: "deskripsi",
                        class: "text_center"
                    }
                ],
            });
        }

        $('#bulan_selera').on('change', function() {
            var bulan = $('#bulan_selera').val();
            var tahun = $('#tahun_selera').val();
            $('#report_selera').DataTable().destroy();
            report_selera('yes', bulan, tahun);
        });

        $('#tahun_selera').on('change', function() {
            var bulan = $('#bulan_selera').val();
            var tahun = $('#tahun_selera').val();
            $('#report_selera').DataTable().destroy();
            report_selera('yes', bulan, tahun);
        });

        $('#buttonprintselera').on('click', function() {
            var bulan = $('#bulan_selera').val();
            if (bulan == "") {
                bulan = "0";
            }
            var tahun = $('#tahun_selera').val();
            if (tahun == "") {
                tahun = "0";
            }
            window.location.href = "<?php echo base_url() ?>report/print_selera/" + bulan + "/" + tahun;
        });

        $('#buttonpdfselera').on('click', function() {
            var bulan = $('#bulan_selera').val();
            if (bulan == "") {
                bulan = "0";
            }
            var tahun = $('#tahun_selera').val();
            if (tahun == "") {
                tahun = "0";
            }
            window.location.href = "<?php echo base_url() ?>report/pdf_selera/" + bulan + "/" + tahun;
        });

        $('#buttonexcelselera').on('click', function() {
            var bulan = $('#bulan_selera').val();
            if (bulan == "") {
                bulan = "0";
            }
            var tahun = $('#tahun_selera').val();
            if (tahun == "") {
                tahun = "0";
            }
            window.location.href = "<?php echo base_url() ?>report/excel_selera/" + bulan + "/" + tahun;
        });

        function report_efektivitas(bulan = '', tahun = '', kurir = '') {
            var dataTable = $('#report_efektivitas').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo base_url("report/get_datatable_efektivitas") ?>",
                    type: "POST",
                    data: {
                        bulan: bulan,
                        tahun: tahun,
                        kurir: kurir
                    }
                },
                "columns": [{
                        data: "nm_admin",
                        class: "text_center",
                        orderable: true,
                    },
                    {
                        data: "total_selesai",
                        class: "text_center",
                        orderable: true,
                        render: function(data, type, row, meta) {
                            if (data != null) {
                                return '<a href="javascript:void(0);" class="modal-lihat-pengiriman btn btn-sm btn-success" data-id="' + row.kd_kurir + '" data-aktif="done" data-toggle="modal" data-toggle="modal" data-target="#modal-lihat-pengiriman"><i class="fas fa-eye"></i> </a> ' + data;
                            } else {
                                return '<span class="badge badge-pill badge-warning">Belum Ada Data Pengiriman</span>';
                            }
                        }
                    },
                    {
                        data: "total_dikirim",
                        class: "text_center",
                        orderable: true,
                        render: function(data, type, row, meta) {
                            if (data != null) {
                                return '<a href="javascript:void(0);" class="modal-lihat-pengiriman btn btn-sm btn-success" data-id="' + row.kd_kurir + '" data-aktif="ondelivery" data-toggle="modal" data-toggle="modal" data-target="#modal-lihat-pengiriman"><i class="fas fa-eye"></i> </a> ' + data;
                            } else {
                                return '<span class="badge badge-pill badge-warning">Belum Ada Data Pengiriman</span>';
                            }
                        }
                    },
                ],
            });
        }

        function report_efektivitas_kurir_lain(bulan = '', tahun = '', kurir = '') {
            var dataTable = $('#report_efektivitas_kurir_lain').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo base_url("report/get_datatable_efektivitas_kurir_lain") ?>",
                    type: "POST",
                },
                "columns": [{
                        data: "kd_order",
                        class: "text_center",
                        orderable: true,
                        render: function(data, type, row, meta) {
                            return "Ekspedisi Lain"
                        }
                    },
                    {
                        data: "total_selesai",
                        class: "text_center",
                        orderable: true,
                        render: function(data, type, row, meta) {
                            if (data != null) {
                                return '<a href="javascript:void(0);" class="modal-lihat-ekspedisi_lain btn btn-sm btn-success" data-id="ekpedisi_yang_lain" data-aktif="done" data-toggle="modal" data-toggle="modal" data-target="#modal-lihat-ekspedisi_lain"><i class="fas fa-eye"></i> </a> ' + data;
                            } else {
                                return '<span class="badge badge-pill badge-warning">Belum Ada Data Pengiriman</span>';
                            }
                        }
                    },
                    {
                        data: "total_dikirim",
                        class: "text_center",
                        orderable: true,
                        render: function(data, type, row, meta) {
                            if (data != null) {
                                return '<a href="javascript:void(0);" class="modal-lihat-ekspedisi_lain btn btn-sm btn-success" data-id="ekpedisi_yang_lain" data-aktif="tdk_done" data-toggle="modal" data-toggle="modal" data-target="#modal-lihat-ekspedisi_lain"><i class="fas fa-eye"></i> </a> ' + data;
                            } else {
                                return '<span class="badge badge-pill badge-warning">Belum Ada Data Pengiriman</span>';
                            }
                        }
                    },
                ],
            });
        }

        $('#bulan_efektivitas').on('change', function() {
            var bulan = $('#bulan_efektivitas').val();
            var tahun = $('#tahun_efektivitas').val();
            var kurir = $('#kurir_efektivitas').val();
            $('#report_efektivitas').DataTable().destroy();
            report_efektivitas(bulan, tahun, kurir);
        });

        $('#tahun_efektivitas').on('change', function() {
            var bulan = $('#bulan_efektivitas').val();
            var tahun = $('#tahun_efektivitas').val();
            var kurir = $('#kurir_efektivitas').val();
            $('#report_efektivitas').DataTable().destroy();
            report_efektivitas(bulan, tahun, kurir);
        });

        $('#kurir_efektivitas').on('change', function() {
            var bulan = $('#bulan_efektivitas').val();
            var tahun = $('#tahun_efektivitas').val();
            var kurir = $('#kurir_efektivitas').val();
            $('#report_efektivitas').DataTable().destroy();
            report_efektivitas(bulan, tahun, kurir);
        });

        $('#buttonprintefektivitas').on('click', function() {
            var bulan = $('#bulan_efektivitas').val();
            if (bulan == "") {
                bulan = "0";
            }
            var tahun = $('#tahun_efektivitas').val();
            if (tahun == "") {
                tahun = "0";
            }
            var kurir = $('#kurir_efektivitas').val();
            if (kurir == "") {
                kurir = "0";
            }
            window.location.href = "<?php echo base_url() ?>report/print_efektivitas/" + bulan + "/" + tahun + "/" + kurir;
        });

        $('#buttonpdfefektivitas').on('click', function() {
            var bulan = $('#bulan_efektivitas').val();
            if (bulan == "") {
                bulan = "0";
            }
            var tahun = $('#tahun_efektivitas').val();
            if (tahun == "") {
                tahun = "0";
            }
            var kurir = $('#kurir_efektivitas').val();
            if (kurir == "") {
                kurir = "0";
            }
            window.location.href = "<?php echo base_url() ?>report/pdf_efektivitas/" + bulan + "/" + tahun + "/" + kurir;
        });

        $("#modal-lihat-pengiriman").on("show.bs.modal", function(event) {
            var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
            var modal = $(this);
            var id = div.data("id");
            var aktif = div.data("aktif");
            var bulan = $('#bulan_efektivitas').val();
            var tahun = $('#tahun_efektivitas').val();
            var text = "";

            $.ajax({
                url: base_url + "/report/get_pengiriman_detail/",
                type: "post",
                dataType: "json",
                data: {
                    id: id,
                    bulan: bulan,
                    tahun: tahun,
                    aktif: aktif
                },
                success: function(result) {
                    for (let i = 0; i < result.length; i++) {
                        text +=
                            "<tr>" +
                            "<td>" +
                            result[i].kd_pengiriman +
                            "</td>" +
                            "<td>" +
                            result[i].cust_name +
                            "</td>" +
                            "<td>" +
                            result[i].cust_phone +
                            "</td>" +
                            "<td>" +
                            result[i].cust_address.replace(/(<([^>]+)>)/gi, " ") +
                            "</td>" +
                            "<td>" +
                            convertToRupiah(result[i].ongkir) +
                            "</td>" +
                            "<td>" +
                            ubah_tanggal(result[i].tgl_order) +
                            "</td>" +
                            "<td>" +
                            "<a href='" + base_url + "/order/detail_pesanan/" + result[i].kd_order + "' target=_blank class='modal-lihat-pengiriman btn btn-success btn-sm'><i class='fas fa-eye'></i></a>" +
                            "</td>" +
                            "</tr>";
                    }
                    $("#demo").html(text);

                    $("#table-lihat-pengiriman").DataTable();
                },
            });
        });

        $('#modal-lihat-pengiriman').on('hidden.bs.modal', function(e) {
            $("#demo").html("");
            var table = $('#table-lihat-pengiriman').DataTable();
            table.destroy();
        })

        $("#modal-lihat-ekspedisi_lain").on("show.bs.modal", function(event) {
            var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
            var modal = $(this);
            var id = div.data("id");
            var aktif = div.data("aktif");
            var text = "";

            $.ajax({
                url: base_url + "/report/get_pengiriman_detail_ekspedisi_lain/",
                type: "post",
                dataType: "json",
                data: {
                    id: id,
                    aktif: aktif
                },
                success: function(result) {
                    for (let i = 0; i < result.length; i++) {
                        text +=
                            "<tr>" +
                            "<td>" +
                            result[i].kd_order +
                            "</td>" +
                            "<td>" +
                            result[i].cust_name +
                            "</td>" +
                            "<td>" +
                            result[i].cust_phone +
                            "</td>" +
                            "<td>" +
                            result[i].cust_address.replace(/(<([^>]+)>)/gi, " ") +
                            "</td>" +
                            "<td>" +
                            convertToRupiah(result[i].ongkir) +
                            "</td>" +
                            "<td>" +
                            ubah_tanggal(result[i].tgl_order) +
                            "</td>" +
                            "<td>" +
                            "<a href='" + base_url + "/order/detail_pesanan/" + result[i].kd_order + "' target=_blank class='modal-lihat-ekspedisi_lain btn btn-success btn-sm'><i class='fas fa-eye'></i></a>" +
                            "</td>" +
                            "</tr>";
                    }
                    $("#demo_yg_lain").html(text);

                    $("#table-lihat-pengiriman_yang_lain").DataTable();
                },
            });
        });

        $('#modal-lihat-ekspedisi_lain').on('hidden.bs.modal', function(e) {
            $("#demo").html("");
            var table = $('#table-lihat-pengiriman_yang_lain').DataTable();
            table.destroy();
        })

        function report_produk_masuk(is_date_search, bulan = '', tahun = '', reseller = '') {
            var dataTable = $('#report_produk_masuk').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo base_url("report/get_datatable_produkmasuk") ?>",
                    type: "POST",
                    data: {
                        is_date_search: is_date_search,
                        bulan: bulan,
                        tahun: tahun
                    }
                },
                "columns": [{
                        data: "tgl_produk_masuk",
                        class: "text_center",
                        render: function(data) {
                            return ubah_tanggal(data);
                        }
                    },
                    {
                        data: "nm_supplier",
                        class: "text_center"
                    },
                    {
                        data: "nominal_bayar",
                        class: "text_center",
                        render: function(data) {
                            if (data != null) {
                                return convertToRupiah(data);
                            } else {
                                return "-";
                            }
                        }
                    },
                    {
                        data: "jenis_pembayaran",
                        class: "text_center",
                        render: function(data) {
                            return data;
                        }
                    },
                    {
                        data: "status_pembayaran",
                        class: "text_center",
                        render: function(data) {
                            if (data == 1) {
                                return '<span class="badge badge-success">Sudah Dibayar</span>';
                            } else {
                                return '<span class="badge badge-danger">Belum Dibayar</span>';
                            }
                        }
                    },
                    {
                        data: "bukti_pembayaran",
                        class: "text_center",
                        render: function(data, type, row, meta) {
                            if (data != null) {
                                return '<a href="javascript:void(0)" class="lihat_bukti_pembayaran" data-id="' + row.kd_produk_masuk + '">' + data + '</a>';
                            } else {
                                return "-";
                            }
                        }
                    },
                    {
                        data: "aksi",
                        class: "text-center",
                        width: 150,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            if (row.status_pembayaran == 1) {
                                return data;
                            } else {
                                return data + '<span data-toggle="tooltip" data-placement="top" title="Hapus Supplier"><a href="javascript:void(0);" class="hapus_record btn btn-sm btn-danger ml-1" data-id="' + row.kd_produk_masuk + '" data-toggle="modal" data-target="#hapusModal"><i class="fas fa-trash"></i> </a>';
                            }
                        },
                    }
                ],
            });
        }

        $('#report_produk_masuk').on('click', '.lihat_bukti_pembayaran', function() {
            let id = $(this).data('id');
            $.ajax({
                url: "<?php echo base_url("product/getProdukMasukById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_produk_masuk": id
                },
                success: function(data) {
                    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                        $(".error-data1").html("Maaf, untuk versi mobile belum tersedia.");
                        $(".flash-data1").html("");
                        toast();
                    } else {
                        $('#lihatbukti').modal('show');
                        if (data.path == "selera") {
                            $('#bagian_embed').html('<embed src="' + base_url + '/assets/images/bukti_pembayaran_supplier/' + data.bukti_pembayaran + '" frameborder="0" width="100%" height="400px">');
                        } else {
                            $('#bagian_embed').html('<embed src="' + base_url_stbaq + '/assets/images/bukti_pembayaran_supplier/' + data.bukti_pembayaran + '" frameborder="0" width="100%" height="400px">');
                        }
                    }
                }
            });
        });

        $('#report_produk_masuk').on('click', '.lihat_detail_pm', function() {
            let id = $(this).data('id');

            $('#mytableDetailProductMasuk').DataTable({
                "searching": false,
                "paging": false,
                "info": false,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo base_url('Product/get_detail_produk_masuk') ?>",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        "kd_produk_masuk": id
                    }
                },
                "columns": [{
                        data: "kd_produk_masuk",
                        class: "text_center",
                        render: function(data, type, row, meta) {
                            return row.nm_produk + " - " + row.jenis_produk;
                        }
                    },
                    {
                        data: "stok_masuk",
                        class: "text_center"
                    },
                ],
            });

            $('#Modal_Detail_ProdukMasuk').modal('show');
        });

        $('#Modal_Detail_ProdukMasuk').on('hidden.bs.modal', function(e) {
            $('#mytableDetailProductMasuk').DataTable().destroy();
        })

        $('#bulan_produk_masuk').on('change', function() {
            var bulan = $('#bulan_produk_masuk').val();
            var tahun = $('#tahun_produk_masuk').val();
            $('#report_produk_masuk').DataTable().destroy();
            report_produk_masuk('yes', bulan, tahun);
        });

        $('#tahun_produk_masuk').on('change', function() {
            var bulan = $('#bulan_produk_masuk').val();
            var tahun = $('#tahun_produk_masuk').val();
            $('#report_produk_masuk').DataTable().destroy();
            report_produk_masuk('yes', bulan, tahun);
        });

        $('#buttonprintproduk_masuk').on('click', function() {
            var bulan = $('#bulan_produk_masuk').val();
            if (bulan == "") {
                bulan = "0";
            }
            var tahun = $('#tahun_produk_masuk').val();
            if (tahun == "") {
                tahun = "0";
            }
            window.location.href = "<?php echo base_url() ?>report/print_produk_masuk/" + bulan + "/" + tahun;
        });

        $('#buttonpdfproduk_masuk').on('click', function() {
            var bulan = $('#bulan_produk_masuk').val();
            if (bulan == "") {
                bulan = "0";
            }
            var tahun = $('#tahun_produk_masuk').val();
            if (tahun == "") {
                tahun = "0";
            }
            window.location.href = "<?php echo base_url() ?>report/pdf_produk_masuk/" + bulan + "/" + tahun;
        });

        $('#buttonexcelproduk_masuk').on('click', function() {
            var bulan = $('#bulan_produk_masuk').val();
            if (bulan == "") {
                bulan = "0";
            }
            var tahun = $('#tahun_produk_masuk').val();
            if (tahun == "") {
                tahun = "0";
            }
            window.location.href = "<?php echo base_url() ?>report/excel_produk_masuk/" + bulan + "/" + tahun;
        });

        function report_ujroh(is_date_search, tgl = '', bulan = '', tahun = '', reseller = '') {
            var dataTable = $('#report_ujroh').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo base_url("report/get_datatable_ujroh") ?>",
                    type: "POST",
                    data: {
                        is_date_search: is_date_search,
                        bulan: bulan,
                        tahun: tahun,
                        tgl: tgl,
                        reseller: reseller,
                    }
                },
                "columns": [{
                        data: "tgl_order",
                        class: "text_center",
                        render: function(data, type, row) {
                            return ubah_tanggal(data);
                        },
                    },
                    {
                        data: "kd_order",
                        class: "text_center"
                    },
                    {
                        data: "kd_reseller",
                        class: "text_center"
                    },
                    {
                        data: "nm_reseller",
                        class: "text_center"
                    },
                    {
                        data: "no_telp",
                        class: "text_center"
                    },
                    {
                        data: "jml_ujroh",
                        class: "text_center",
                        render: function(data, type, row) {
                            return convertToRupiah(data);
                        },
                    },
                    {
                        data: "aksi",
                        class: "text-center",
                        width: 150,
                        orderable: false
                    }
                ],
            });
        }

        $('#tanggal_ujroh').on('apply.daterangepicker', function(ev, picker) {
            var bulan = $('#bulan_ujroh').val();
            var tahun = $('#tahun_ujroh').val();
            var status = $('#order_status').val();
            var reseller = $('#reseller1').val();
            var tgl = $('#tanggal_ujroh').val();
            $('#report_ujroh').DataTable().destroy();
            report_ujroh('yes', tgl, bulan, tahun, reseller);
        });

        $('#tanggal_ujroh').on('cancel.daterangepicker', function(ev, picker) {
            $('#tanggal_ujroh').val('');
            var bulan = $('#bulan_ujroh').val();
            var tahun = $('#tahun_ujroh').val();
            var status = $('#order_status').val();
            var reseller = $('#reseller1').val();
            var tgl = null;
            $('#report_ujroh').DataTable().destroy();
            report_ujroh('yes', tgl, bulan, tahun, reseller);
        });

        $('#bulan_ujroh').on('change', function() {
            var bulan = $('#bulan_ujroh').val();
            var tahun = $('#tahun_ujroh').val();
            var reseller = $('#reseller1').val();
            var tgl = $('#tanggal_ujroh').val();
            $('#report_ujroh').DataTable().destroy();
            report_ujroh('yes', tgl, bulan, tahun, reseller);
        });

        $('#tahun_ujroh').on('change', function() {
            var bulan = $('#bulan_ujroh').val();
            var tahun = $('#tahun_ujroh').val();
            var reseller = $('#reseller1').val();
            var tgl = $('#tanggal_ujroh').val();
            $('#report_ujroh').DataTable().destroy();
            report_ujroh('yes', tgl, bulan, tahun, reseller);
        });

        $('#reseller1').on('change', function() {
            var bulan = $('#bulan_ujroh').val();
            var tahun = $('#tahun_ujroh').val();
            var reseller = $('#reseller1').val();
            var tgl = $('#tanggal_ujroh').val();
            $('#report_ujroh').DataTable().destroy();
            report_ujroh('yes', tgl, bulan, tahun, reseller);
        });

        $('#buttonprintujroh').on('click', function() {
            var bulan = $('#bulan_ujroh').val();
            if (bulan == "") {
                bulan = "0";
            }
            var tahun = $('#tahun_ujroh').val();
            if (tahun == "") {
                tahun = "0";
            }
            var reseller = $('#reseller1').val();
            if (reseller == "") {
                reseller = "0";
            }
            window.location.href = "<?php echo base_url() ?>report/print_ujroh/" + bulan + "/" + tahun;
        });

        $('#buttonpdfujroh').on('click', function() {
            var bulan = $('#bulan_ujroh').val();
            if (bulan == "") {
                bulan = "0";
            }
            var tahun = $('#tahun_ujroh').val();
            if (tahun == "") {
                tahun = "0";
            }
            var reseller = $('#reseller1').val();
            if (reseller == "") {
                reseller = "0";
            }
            window.location.href = "<?php echo base_url() ?>report/pdf_ujroh/" + bulan + "/" + tahun;
        });

        $('#buttonexcelujroh').on('click', function() {
            var bulan = $('#bulan_ujroh').val();
            if (bulan == "") {
                bulan = "0";
            }
            var tahun = $('#tahun_ujroh').val();
            if (tahun == "") {
                tahun = "0";
            }
            var reseller = $('#reseller1').val();
            if (reseller == "") {
                reseller = "0";
            }
            var tgl = $('#tanggal_ujroh').val();
            if (tgl == "") {
                tgl = "0";
            }
            window.location.href = "<?php echo base_url() ?>report/excel_ujroh/" + tgl + "/" + bulan + "/" + tahun;
        });

        $("#modal-lihat-ujroh").on("show.bs.modal", function(event) {
            var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
            var modal = $(this);
            var id = div.data("id");
            var text = "";

            $.ajax({
                url: base_url + "/report/get_ujroh_detail/",
                type: "post",
                dataType: "json",
                data: {
                    id: id,
                },
                success: function(result) {

                    for (let i = 0; i < result.length; i++) {
                        if (result[i].kd_promo) {
                            result[i].kd_produk = result[i].kd_promo
                            result[i].berat_produk = result[i].berat
                            result[i].satuan_berat_produk = result[i].satuan_berat
                            result[i].harga_produk = result[i].harga_hasil_promo
                            result[i].nominal_komisi = result[i].ujroh_promo
                        }

                        text +=
                            "<tr>" +
                            "<td>" +
                            result[i].kd_produk +
                            "</td>" +
                            "<td>" +
                            result[i].nm_produk + "  (" + result[i].berat_produk + ' ' + result[i].satuan_berat_produk + ")" +
                            "</td>" +
                            "<td>" +
                            convertToRupiah(result[i].nominal_komisi) +
                            "</td>" +
                            "<td>" +
                            result[i].qtyy +
                            "</td>" +
                            "<td>" +
                            convertToRupiah(result[i].jml_komisi) +
                            "</td>" +
                            "</tr>";
                    }
                    $("#demo_ujroh").html(text);
                },
            });
        });

        function report_order(is_date_search, bulan = '', tahun = '', status = '', bayar = '', tgl = '', reseller = '') {
            var dataTable = $('#report_order').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo base_url("order/get_datatable_order") ?>",
                    type: "POST",
                    data: {
                        is_date_search: is_date_search,
                        bulan: bulan,
                        tahun: tahun,
                        status: status,
                        bayar: bayar,
                        tgl: tgl,
                        reseller: reseller
                    }
                },
                "columns": [{
                        data: "tgl_order",
                        class: "text_center",
                        render: function(data, type, row) {
                            return ubah_tanggal(data);
                        },
                    },
                    {
                        data: "kd_order",
                        class: "text_center"
                    },
                    {
                        data: "cust_name",
                        class: "text_center"
                    },
                    {
                        data: "cust_phone",
                        class: "text_center"
                    },
                    {
                        data: "total_harga",
                        class: "text_center",
                        render: function(data, type, row) {
                            return convertToRupiah(data);
                        },
                    },
                    {
                        data: "payment_type",
                        class: "text_center",
                        render: function(data, type, row) {
                            if (data == "ambil_langsung") {
                                return "Tunai";
                            } else if (data == "cod") {
                                return "COD";
                            } else if (data == "transfer") {
                                return "Transfer";
                            } else if (data == "kredit") {
                                return "Kredit";
                            }
                        },
                    },
                    {
                        data: "aksi",
                        class: "text-center",
                        width: 150,
                        orderable: false
                    }
                ],
            });
        }

        $('#report_order').on('click', '.download-invoice-report-order', function() {
            let id = $(this).data('id');

            window.location.href = "<?php echo base_url() ?>order/lihat_invoice/" + id + "/1";
        });

        function ubah_tanggal(tgl, ket) {
            var hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            var tanggal = new Date(tgl).getDate();
            var xhari = new Date(tgl).getDay();
            var xbulan = new Date(tgl).getMonth();
            var xtahun = new Date(tgl).getYear();
            var jam = new Date(tgl).getHours().toString();
            var menit = new Date(tgl).getMinutes().toString();
            var detik = new Date(tgl).getSeconds().toString();

            if (jam.length == 1) {
                jam = "0" + jam;
            }

            if (menit.length == 1) {
                menit = "0" + menit;
            }

            if (detik.length == 1) {
                detik = "0" + detik;
            }

            var hari = hari[xhari];
            var bulan = bulan[xbulan];
            var tahun = (xtahun < 1000) ? xtahun + 1900 : xtahun;

            if (ket == "jam") {
                var hasil = hari + ', ' + tanggal + ' ' + bulan + ' ' + tahun + " " + jam + ":" + menit + ":" + detik;
            } else {
                var hasil = hari + ', ' + tanggal + ' ' + bulan + ' ' + tahun;
            }

            return hasil;
        }

        $('#tanggal_order').on('apply.daterangepicker', function(ev, picker) {
            var bulan = $('#bulan_order').val();
            var tahun = $('#tahun_order').val();
            var status = $('#order_status').val();
            var bayar = $('#payment_status').val();
            var tgl = $('#tanggal_order').val();
            var reseller = $('#reseller_order').val();
            $('#report_order').DataTable().destroy();
            report_order('yes', bulan, tahun, status, bayar, tgl, reseller);
        });

        $('#tanggal_order').on('cancel.daterangepicker', function(ev, picker) {
            $('#tanggal_order').val('');
            var bulan = $('#bulan_order').val();
            var tahun = $('#tahun_order').val();
            var status = $('#order_status').val();
            var bayar = $('#payment_status').val();
            var tgl = null;
            var reseller = $('#reseller_order').val();
            $('#report_order').DataTable().destroy();
            report_order('yes', bulan, tahun, status, bayar, tgl, reseller);
        });

        $('#bulan_order').on('change', function() {
            var bulan = $('#bulan_order').val();
            var tahun = $('#tahun_order').val();
            var status = $('#order_status').val();
            var bayar = $('#payment_status').val();
            var tgl = $('#tanggal_order').val();
            var reseller = $('#reseller_order').val();
            $('#report_order').DataTable().destroy();
            report_order('yes', bulan, tahun, status, bayar, tgl, reseller);
        });

        $('#tahun_order').on('change', function() {
            var bulan = $('#bulan_order').val();
            var tahun = $('#tahun_order').val();
            var status = $('#order_status').val();
            var bayar = $('#payment_status').val();
            var tgl = $('#tanggal_order').val();
            var reseller = $('#reseller_order').val();
            $('#report_order').DataTable().destroy();
            report_order('yes', bulan, tahun, status, bayar, tgl, reseller);
        });

        $('#order_status').on('change', function() {
            var bulan = $('#bulan_order').val();
            var tahun = $('#tahun_order').val();
            var status = $('#order_status').val();
            var bayar = $('#payment_status').val();
            var tgl = $('#tanggal_order').val();
            var reseller = $('#reseller_order').val();
            $('#report_order').DataTable().destroy();
            report_order('yes', bulan, tahun, status, bayar, tgl, reseller);
        });

        $('#payment_status').on('change', function() {
            var bulan = $('#bulan_order').val();
            var tahun = $('#tahun_order').val();
            var status = $('#order_status').val();
            var bayar = $('#payment_status').val();
            var tgl = $('#tanggal_order').val();
            var reseller = $('#reseller_order').val();
            $('#report_order').DataTable().destroy();
            report_order('yes', bulan, tahun, status, bayar, tgl, reseller);
        });

        $('#reseller_order').on('change', function() {
            var bulan = $('#bulan_order').val();
            var tahun = $('#tahun_order').val();
            var status = $('#order_status').val();
            var bayar = $('#payment_status').val();
            var tgl = $('#tanggal_order').val();
            var reseller = $('#reseller_order').val();
            $('#report_order').DataTable().destroy();
            report_order('yes', bulan, tahun, status, bayar, tgl, reseller);
        });

        $('#buttonpdforder1').on('click', function() {
            var bulan = $('#bulan_order').val();
            if (bulan == "") {
                bulan = "0";
            }
            var tahun = $('#tahun_order').val();
            if (tahun == "") {
                tahun = "0";
            }
            var status = $('#order_status').val();
            if (status == "") {
                status = "0";
            }
            var bayar = $('#payment_status').val();
            if (bayar == "") {
                bayar = "0";
            }
            var tgl = $('#tanggal_order').val();
            if (tgl == "") {
                tgl = "0";
            }
            var pembayaran = $('#payment_status').val();
            if (pembayaran == "") {
                pembayaran = "-";
            }

            window.location.href = "<?php echo base_url() ?>report/pdf_order/1/" + bulan + "/" + tahun + "/" + status + "/" + bayar + "/" + tgl + "/" + pembayaran;
        });

        $('#buttonpdforder2').on('click', function() {
            var bulan = $('#bulan_order').val();
            if (bulan == "") {
                bulan = "0";
            }
            var tahun = $('#tahun_order').val();
            if (tahun == "") {
                tahun = "0";
            }
            var status = $('#order_status').val();
            if (status == "") {
                status = "0";
            }
            var bayar = $('#payment_status').val();
            if (bayar == "") {
                bayar = "0";
            }
            var tgl = $('#tanggal_order').val();
            if (tgl == "") {
                tgl = "0";
            }
            var pembayaran = $('#payment_status').val();
            if (pembayaran == "") {
                pembayaran = "-";
            }

            window.location.href = "<?php echo base_url() ?>report/pdf_order/2/" + bulan + "/" + tahun + "/" + status + "/" + bayar + "/" + tgl + "/" + pembayaran;
        });

        $('#buttonprintorder1').on('click', function() {
            var bulan = $('#bulan_order').val();
            if (bulan == "") {
                bulan = "0";
            }
            var tahun = $('#tahun_order').val();
            if (tahun == "") {
                tahun = "0";
            }
            var status = $('#order_status').val();
            if (status == "") {
                status = "0";
            }
            var bayar = $('#payment_status').val();
            if (bayar == "") {
                bayar = "0";
            }
            var tgl = $('#tanggal_order').val();
            if (tgl == "") {
                tgl = "0";
            }
            var pembayaran = $('#payment_status').val();
            if (pembayaran == "") {
                pembayaran = "-";
            }

            window.location.href = "<?php echo base_url() ?>report/print_order/1/" + bulan + "/" + tahun + "/" + status + "/" + bayar + "/" + tgl + "/" + pembayaran;
        });

        $('#buttonprintorder2').on('click', function() {
            var bulan = $('#bulan_order').val();
            if (bulan == "") {
                bulan = "0";
            }
            var tahun = $('#tahun_order').val();
            if (tahun == "") {
                tahun = "0";
            }
            var status = $('#order_status').val();
            if (status == "") {
                status = "0";
            }
            var bayar = $('#payment_status').val();
            if (bayar == "") {
                bayar = "0";
            }
            var tgl = $('#tanggal_order').val();
            if (tgl == "") {
                tgl = "0";
            }
            var pembayaran = $('#payment_status').val();
            if (pembayaran == "") {
                pembayaran = "-";
            }

            window.location.href = "<?php echo base_url() ?>report/print_order/2/" + bulan + "/" + tahun + "/" + status + "/" + bayar + "/" + tgl + "/" + pembayaran;
        });

        $('#buttonexcelorder').on('click', function() {
            var bulan = $('#bulan_order').val();
            if (bulan == "") {
                bulan = "0";
            }
            var tahun = $('#tahun_order').val();
            if (tahun == "") {
                tahun = "0";
            }
            var status = $('#order_status').val();
            if (status == "") {
                status = "0";
            }
            var bayar = $('#payment_status').val();
            if (bayar == "") {
                bayar = "0";
            }
            var tgl = $('#tanggal_order').val();
            if (tgl == "") {
                tgl = "0";
            }
            var pembayaran = $('#payment_status').val();
            if (pembayaran == "") {
                pembayaran = "-";
            }

            window.location.href = "<?php echo base_url() ?>report/excel_order/" + bulan + "/" + tahun + "/" + status + "/" + bayar + "/" + tgl + "/" + pembayaran;
        });

        $("#modal-lihat-reportorder").on("show.bs.modal", function(event) {
            var div = $(event.relatedTarget); // Tombol dimana modal di tampilkan
            var modal = $(this);
            var id = div.data("id");
            var text = "";

            $.ajax({
                url: base_url + "/report/get_order_detail/",
                type: "post",
                dataType: "json",
                data: {
                    id: id,
                },
                success: function(result) {
                    for (let i = 0; i < result.length; i++) {

                        if (result[i].kd_promo) {
                            result[i].kd_produk = result[i].kd_promo
                            result[i].harga_produk = result[i].harga_hasil_promo
                        }

                        text +=
                            "<tr>" +
                            "<td>" +
                            result[i].kd_produk +
                            "</td>" +
                            "<td>" +
                            result[i].nm_produk +
                            "</td>" +
                            "<td>" +
                            convertToRupiah(result[i].harga_produk) +
                            "</td>" +
                            "<td>" +
                            result[i].qtyy +
                            "</td>" +
                            "<td>" +
                            convertToRupiah(result[i].sub_total) +
                            "</td>" +
                            "</tr>";
                    }
                    $("#demo").html(text);
                },
            });

            $.ajax({
                url: "<?php echo base_url("order/getOrderById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    'kd_order': id
                },

                success: function(data) {
                    $('.bagian_ongkir').html(convertToRupiah(data.ongkir));
                    $('.bagian_diskon_tambahan').html(convertToRupiah(data.diskon_tambahan));
                    $('.bagian_total').html(convertToRupiah(data.total_harga));
                    if (data.payment_type == "kredit") {
                        $.ajax({
                            url: "<?php echo base_url("order/get_pembayaran_kredit") ?>",
                            type: 'post',
                            dataType: 'json',
                            data: {
                                'kd_order': data.kd_order
                            },

                            success: function(data) {
                                if (data.length > 0) {
                                    $('#table_kredit').show();
                                    var home = "";
                                    for (let i = 0; i < data.length; i++) {
                                        home +=
                                            "<tr>" +
                                            "<td>" +
                                            convertToRupiah(data[i].nominal_kredit) +
                                            "</td>" +
                                            "<td>" +
                                            ubah_tanggal(data[i].created_at) +
                                            "</td>" +
                                            "</tr>";
                                    }
                                    $("#demo1").html(home);
                                }
                            }
                        });
                    } else {
                        $('#table_kredit').hide();
                    }
                }
            });
        });
        // --------------------------------------- End Kelola Report-----------------------------------------

        // ----------------------------------------- Kelola Custom Aktif-----------------------------------------

        $('#mytableCustom').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('custom/get_custom/1') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_custom",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_custom",
                    class: "text_center"
                },
                {
                    data: "harga_custom",
                    class: "text_center",
                    render: function(data, type, row, meta) {
                        return convertToRupiah(data);
                    }
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytableCustom').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            getCustomById(id, "Edit")
        });

        $('#mytableCustom').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            getCustomById(id, "Delete");
        });

        function getCustomById(id, action) {
            $.ajax({
                url: "<?php echo base_url("custom/getCustomById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_custom": id
                },
                success: function(data) {
                    if (action == "Edit") {
                        $("#kd_custom_edit").val(data.kd_custom);
                        $("#nm_custom_edit").val(data.nm_custom);
                        $("#harga_custom_edit").val(data.harga_custom);
                        $("#jenis_custom_edit").val(data.jenis_custom).trigger('change');
                    }
                }
            });
            $('#Modal_' + action).modal({
                backdrop: 'static',
                keyboard: false
            })
        }

        $("#addCustom").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addCustom').serialize();

            $.ajax({
                url: "<?php echo base_url("Custom/add_custom") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytableCustom').DataTable().ajax.reload();
                        $('#addCustom')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $("#editCustom").submit(function(e) {

            e.preventDefault();
            let dataString = $('#editCustom').serialize();

            $.ajax({
                url: "<?php echo base_url("custom/edit_custom") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#mytableCustom').DataTable().ajax.reload();
                        $('#editCustom')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $("#hapusCustom").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo base_url("custom/delete_custom") ?>",
                type: 'post',
                dataType: 'json',
                data: {},
                success: function(data) {

                    if (data.response == "success") {
                        $('#mytableCustom').DataTable().ajax.reload();
                        $('#Modal_Delete').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        // ---------------------------------------- End Kelola Custom Aktif----------------------------------------
        // ----------------------------------------- Kelola Kategori Aktif-----------------------------------------

        $('#mytableKategori').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Kategori/get_kategori/1') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_kategori",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_kategori",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytableKategori').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            getKategoriById(id, "Edit")
        });

        $('#mytableKategori').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            getKategoriById(id, "Delete");
        });

        // ---------------------------------------- End Kelola Kategori Aktif----------------------------------------

        // ----------------------------------------- Kelola Kategori Tidak Aktif -----------------------------------------

        $('#mytableKategoriTdkAktif').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Kategori/get_kategori/0') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_kategori",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_kategori",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytableKategoriTdkAktif').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            getKategoriById(id, "Edit");
        });

        $('#mytableKategoriTdkAktif').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            getKategoriById(id, "Delete");
        });

        // ---------------------------------------- End Kelola Kategori Tidak Aktif ----------------------------------------

        // ---------------------------------------- Kelola Kategori ----------------------------------------

        $("#addKategori").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addKategori').serialize();

            $.ajax({
                url: "<?php echo base_url("Kategori/add_kategori") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytableKategori').DataTable().ajax.reload();
                        $('#mytableKategoriTdkAktif').DataTable().ajax.reload();
                        $('#addKategori')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $("#editKategori").submit(function(e) {

            e.preventDefault();
            let dataString = $('#editKategori').serialize();

            $.ajax({
                url: "<?php echo base_url("kategori/edit_kategori") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#mytableKategori').DataTable().ajax.reload();
                        $('#mytableKategoriTdkAktif').DataTable().ajax.reload();
                        $('#editKategori')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $("#hapusKategori").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo base_url("kategori/delete_kategori") ?>",
                type: 'post',
                dataType: 'json',
                data: {},
                success: function(data) {

                    if (data.response == "success") {
                        $('#mytableKategori').DataTable().ajax.reload();
                        $('#mytableKategoriTdkAktif').DataTable().ajax.reload();
                        $('#Modal_Delete').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        function getKategoriById(id, action) {
            $.ajax({
                url: "<?php echo base_url("kategori/getKategoriById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_kategori": id
                },
                success: function(data) {
                    if (action == "Edit") {
                        $("#kd_kategori_edit").val(data.kd_kategori);
                        $("#nm_kategori_edit").val(data.nm_kategori);
                    }
                }
            });
            $('#Modal_' + action).modal({
                backdrop: 'static',
                keyboard: false
            })
        }

        // ---------------------------------------- End Kelola Kategori ----------------------------------------

        // ----------------------------------------- Kelola Sub Kategori Aktif-----------------------------------------

        $('#mytableSubKategori').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Kategori/get_sub_kategori/1') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_sub_kategori",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_kategori",
                    class: "text_center"
                },
                {
                    data: "nm_sub_kategori",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytableSubKategori').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            getSubKategoriById(id, "Edit");
        });

        $('#mytableSubKategori').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            getSubKategoriById(id, "Delete");
        });

        // ---------------------------------------- End Kelola Sub Kategori Aktif ----------------------------------------

        // ----------------------------------------- Kelola Sub Kategori Tidak Aktif -----------------------------------------

        $('#mytableSubKategoriTdkAktif').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Kategori/get_sub_kategori/0') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_sub_kategori",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_kategori",
                    class: "text_center"
                },
                {
                    data: "nm_sub_kategori",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytableSubKategoriTdkAktif').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            getSubKategoriById(id, "Edit");
        });

        $('#mytableSubKategoriTdkAktif').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            getSubKategoriById(id, "Delete");
        });

        // ---------------------------------------- End Kelola Sub Kategori Tidak Aktif ----------------------------------------

        // ------------------------------------------------ Kelola Sub Kategori ------------------------------------------------
        $("#addSubKategori").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addSubKategori').serialize();

            $.ajax({
                url: "<?php echo base_url("Kategori/add_sub_kategori") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytableSubKategori').DataTable().ajax.reload();
                        $('#mytableSubKategoriTdkAktif').DataTable().ajax.reload();
                        $('#addSubKategori')[0].reset();

                        $("#kategori")
                            .select2()
                            .val(data.kd_kategori)
                            .trigger("change");

                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        function getSubKategoriById(id, action) {
            $.ajax({
                url: "<?php echo base_url("kategori/getSubKategoriById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_sub_kategori": id
                },
                success: function(data) {
                    if (action == "Edit") {
                        $("#kd_sub_kategori_edit").val(data.kd_sub_kategori);
                        $("#nm_sub_kategori_edit").val(data.nm_sub_kategori);

                        $(".sub_kategori_edit")
                            .select2()
                            .val(data.kd_kategori)
                            .trigger("change");
                    }
                }
            });
            $('#Modal_' + action).modal({
                backdrop: 'static',
                keyboard: false
            })
        }

        $("#editSubKategori").submit(function(e) {

            e.preventDefault();
            let dataString = $('#editSubKategori').serialize();

            $.ajax({
                url: "<?php echo base_url("kategori/edit_sub_kategori") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#mytableSubKategori').DataTable().ajax.reload();
                        $('#mytableSubKategoriTdkAktif').DataTable().ajax.reload();
                        $('#editSubKategori')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $("#hapusSubKategori").submit(function(e) {
            e.preventDefault();
            let id = $('#product_code_delete').val();

            $.ajax({
                url: "<?php echo base_url("kategori/delete_sub_kategori") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_sub_kategori": id,
                },
                success: function(data) {

                    if (data.response == "success") {
                        $('#mytableSubKategori').DataTable().ajax.reload();
                        $('#mytableSubKategoriTdkAktif').DataTable().ajax.reload();
                        $('#Modal_Delete').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        // --------------------------------------------- End Kelola Sub Kategori ---------------------------------------------

        // ----------------------------------------- Kelola Member Aktif -----------------------------------------

        var excel_member = $('#total_excel_member').val();
        if (excel_member != "") {
            for (let i = 2; i < excel_member + 2; i++) {
                $(".select2tujuan" + i).select2({
                    minimumInputLength: 3,
                    placeholder: "Pilih Kecamatan",
                    ajax: {
                        url: base_url + "/catering/get_tujuan",
                        type: "post",
                        dataType: "json",
                        delay: 100,
                        data: function(params) {
                            return {
                                searchTerm: params.term, // search term
                            };
                        },
                        processResults: function(response) {
                            return {
                                results: response,
                            };
                        },
                        cache: true,
                    },
                });

                $(".select2tujuan" + i).on("select2:select", function(e) {
                    var kodepos = e.params.data.kodepos;
                    $('#kode_pos_member' + i).val(kodepos);
                });
            }
        }

        $('#mytableMember').DataTable({
            "serverSide": true,
            "searching": false,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Member/get_member/1') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_member",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_member",
                    class: "text_center"
                },
                {
                    data: "jenis_kelamin",
                    class: "text_center"
                },
                {
                    data: "no_telp",
                    class: "text_center"
                },
                {
                    data: "email",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        function search_member(key, no, path) {
            $('#' + path).DataTable({
                "searching": false,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo base_url("Member/get_search_member/") ?>",
                    type: "POST",
                    data: {
                        key: key,
                        no: no
                    }
                },
                "columns": [{
                        data: "nm_member",
                        class: "text-center",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "nm_member",
                        class: "text_center"
                    },
                    {
                        data: "jenis_kelamin",
                        class: "text_center"
                    },
                    {
                        data: "no_telp",
                        class: "text_center"
                    },
                    {
                        data: "email",
                        class: "text_center"
                    },
                    {
                        data: "aksi",
                        class: "text-center",
                        width: 150,
                        orderable: false
                    }
                ],
            });
        }

        $('#search_member1').keyup(function() {
            var key = $('#search_member1').val();
            $('#mytableMember').DataTable().destroy();
            search_member(key, 1, "mytableMember");
        })

        $('#search_member2').keyup(function() {
            var key = $('#search_member2').val();
            $('#mytableMemberTdkAktif').DataTable().destroy();
            search_member(key, 0, "mytableMemberTdkAktif");
        })

        $("#add_member_modal").click(function() {
            $("#Modal_Add_Member").modal("show");
        })

        $("#addMember").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addMember').serialize();

            $.ajax({
                url: "<?php echo base_url("Member/add_member") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add_Member').modal('hide');
                        $('#mytableMember').DataTable().ajax.reload();
                        $('#mytableMemberTdkAktif').DataTable().ajax.reload();
                        $('#addMember')[0].reset();
                        $('#alamat').summernote('reset');

                        $('#pilihankecamatan').val(null).trigger('change');

                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        if (data.message == "Nomor HP Sudah Terdaftar!") {
                            $("#no_telp").focus();
                        } else if (data.message == "Email Sudah Terdaftar!") {
                            $("#email").focus();
                        }
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $('#mytableMember').on('click', '.edit_record', function() {
            let id = $(this).data('id');
            var text = "";
            $.ajax({
                url: "<?php echo base_url("member/getMemberById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_member": id
                },
                success: function(data) {
                    $("#kd_member_edit").val(data.kd_member);
                    $("#nm_member_edit").val(data.nm_member);
                    $("#username_edit").val(data.username);
                    $("#kode_pos_edit").val(data.kodepos);
                    $("#jk_edit").val(data.jenis_kelamin);
                    $("#no_telp_edit").val(data.no_telp);
                    $("#email_edit").val(data.email);

                    $.ajax({
                        url: "<?php echo base_url("member/getKecamatan") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "kd_kecamatan": data.kd_subdistricts
                        },
                        success: function(result) {
                            text += "<option value=" + result.id + " selected>" +
                                result.provinsi + "," + result.kabupaten + ", " + result.kecamatan + ", " + result.kelurahan + ", " + result.kodepos + "</option>";
                            $('#pilihankecamatan_edit').html(text);
                        }
                    });
                    $('#alamat_edit').summernote("code", decrypt(data.alamat));

                    if ((data.twitter == "" && data.instagram == "" && data.facebook == "") || (data.twitter == null && data.instagram == null && data.facebook == null)) {
                        $("#checkboxsosmed_edit").prop("checked", false);
                        $("#socialmedia_edit").hide();
                        $("#instagram_edit").val(data.instagram);
                        $("#facebook_edit").val(data.facebook);
                        $("#twitter_edit").val(data.twitter);
                        $("#status_member_edit").val(data.is_member_aktif);
                    } else {
                        $("#checkboxsosmed_edit").prop("checked", true);
                        $("#socialmedia_edit").show();
                        $("#instagram_edit").val(data.instagram);
                        $("#facebook_edit").val(data.facebook);
                        $("#twitter_edit").val(data.twitter);
                        $("#status_member_edit").val(data.is_member_aktif);
                    }
                }
            });
            $('#Modal_Edit').modal('show');
        });

        $("#editMember").submit(function(e) {

            e.preventDefault();
            let dataString = $('#editMember').serialize();

            $.ajax({
                url: "<?php echo base_url("member/edit_member") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#editModal').modal('hide');
                        $('#editModalMember').modal('hide');
                        $('#mytableMember').DataTable().ajax.reload();
                        $('#mytableMemberTdkAktif').DataTable().ajax.reload();
                        $('#mytableResellerMemberRs').DataTable().ajax.reload();
                        $('#editMember')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        if (data.message == "Nomor HP Sudah Terdaftar!") {
                            $("#no_telp_edit").focus();
                        } else if (data.message == "Email Sudah Terdaftar!") {
                            $("#email_edit").focus();
                        }
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $('#mytableMember').on('click', '.qr_member', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("member/getMemberById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_member": id
                },
                success: function(data) {

                    $('#linkPrint').attr('href', base_url + '/main/print_QrCode/' + id);

                    $("#labelMember").html("QrCode Member " + data.nm_member);

                    $('#image-preview').attr('src', base_url + '/assets/images/qrcode/member/' + id + ".png");
                    $('#image-preview').hide();
                    $('#image-preview').fadeIn(650);
                }
            });
            $('#Modal_Print').modal('show');

        });

        $('#mytableMember').on('click', '.rst_pass', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("member/getMemberById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_member": id
                },
                success: function(data) {
                    $("#member_code_delete").val(data.kd_member);
                }
            });
            $('#resetModal').modal('show');
        });

        $("#ResetPasswordMember").submit(function(e) {
            e.preventDefault();
            let id = $('#member_code_delete').val();

            $.ajax({
                url: "<?php echo base_url("member/reset_password_member") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_member": id,
                },
                success: function(data) {

                    if (data.response == "success") {
                        $('#mytableMember').DataTable().ajax.reload();
                        $('#mytableMemberTdkAktif').DataTable().ajax.reload();
                        $('#resetModal').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $('#resetModal').modal('hide');
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        $('#mytableMember').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("member/getMemberById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_member": id
                },
                success: function(data) {
                    $("#member_code_delete").val(data.kd_member);
                }
            });
            $('#Modal_Delete').modal('show');
        });

        $('#mytableMember').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("member/getMemberById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_member": id
                },
                success: function(data) {
                    $("#member_code_delete").val(data.kd_member);
                }
            });
            $('#Modal_Delete').modal('show');
        });

        $("#hapusMember").submit(function(e) {
            e.preventDefault();
            let id = $('#member_code_delete').val();

            $.ajax({
                url: "<?php echo base_url("member/delete_member") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_member": id,
                },
                success: function(data) {

                    if (data.response == "success") {
                        $('#mytableMember').DataTable().ajax.reload();
                        $('#mytableMemberTdkAktif').DataTable().ajax.reload();
                        $('#hapusModal').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $('#hapusModal').modal('hide');
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        // ---------------------------------------- End Member Aktif ----------------------------------------

        // ----------------------------------------- Kelola Member Tidak Aktif -----------------------------------------

        $('#mytableMemberTdkAktif').DataTable({
            "serverSide": true,
            "searching": false,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Member/get_member/0') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_member",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_member",
                    class: "text_center"
                },
                {
                    data: "jenis_kelamin",
                    class: "text_center"
                },
                {
                    data: "no_telp",
                    class: "text_center"
                },
                {
                    data: "email",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytableMemberTdkAktif').on('click', '.edit_record', function() {
            let id = $(this).data('id');
            var text = "";
            $.ajax({
                url: "<?php echo base_url("member/getMemberById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_member": id
                },
                success: function(data) {
                    $("#kd_member_edit").val(data.kd_member);
                    $("#nm_member_edit").val(data.nm_member);
                    $("#kode_pos_edit").val(data.kodepos);
                    $("#jk_editt").val(data.jenis_kelamin);
                    $("#no_telp_edit").val(data.no_telp);
                    $("#email_edit").val(data.email);
                    $('#alamat_edit').summernote("code", decrypt(data.alamat));
                    $("#status_member_edit").val(data.is_member_aktif);
                    $.ajax({
                        url: "<?php echo base_url("member/getKecamatan") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "kd_kecamatan": data.kd_subdistricts
                        },
                        success: function(result) {
                            text += "<option value=" + result.id + " selected>" +
                                result.provinsi + "," + result.kabupaten + ", " + result.kecamatan + ", " + result.kelurahan + ", " + result.kodepos + "</option>";
                            $('#pilihankecamatan_edit').html(text);
                        }
                    });

                    if ((data.twitter == "" && data.instagram == "" && data.facebook == "") || (data.twitter == null && data.instagram == null && data.facebook == null)) {
                        $("#checkboxsosmed_edit").prop("checked", false);
                        $("#socialmedia_edit").hide();
                        $("#instagram_edit").val(data.instagram);
                        $("#facebook_edit").val(data.facebook);
                        $("#twitter_edit").val(data.twitter);
                    } else {
                        $("#checkboxsosmed_edit").prop("checked", true);
                        $("#socialmedia_edit").show();
                        $("#instagram_edit").val(data.instagram);
                        $("#facebook_edit").val(data.facebook);
                        $("#twitter_edit").val(data.twitter);
                    }
                }
            });
            $('#Modal_Edit').modal('show');
        });

        $('#mytableMemberTdkAktif').on('click', '.qr_member', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("member/getMemberById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_member": id
                },
                success: function(data) {

                    $('#linkPrint').attr('href', base_url + '/main/print_QrCode/' + id);

                    $("#labelMember").html("QrCode Member " + data.nm_member);

                    $('#image-preview').attr('src', base_url + '/assets/images/qrcode/member/' + id + ".png");
                    $('#image-preview').hide();
                    $('#image-preview').fadeIn(650);
                }
            });
            $('#Modal_Print').modal('show');

        });

        $('#mytableMemberTdkAktif').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("member/getMemberById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_member": id
                },
                success: function(data) {
                    $("#member_code_delete").val(data.kd_member);
                }
            });
            $('#Modal_Delete').modal('show');
        });

        // ---------------------------------------- End Member Tidak Aktif ----------------------------------------

        // ----------------------------------------- Stok Produk -----------------------------------------
        var lokasi_produk = $("#lokasi_produk").val();
        $('#mytableStokProduk').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: base_url + "/stok_produk/get_stok_produk/" + lokasi_produk,
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_produk",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_produk",
                    class: "text_center",
                    render: function(data, type, row, meta) {
                        return data + " - " + row.berat + " " + row.satuan_berat;
                    }
                },
                {
                    data: "lokasi",
                    class: "text_center",
                    render: function(data, type, row, meta) {
                        return data.toUpperCase();
                    }
                },
                {
                    data: "stok",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $("#buttonupdatestok").click(function() {
            Swal.fire({
                title: "Apa Kamu Yakin?",
                text: "Stok Produk akan di update sesuai dengan data Stok Produk di semua lokasi!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Saya Setuju!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url("Stok_produk/update_detail_stok_produk") ?>",
                        type: 'post',
                        dataType: 'json',

                        success: function(data) {
                            if (data.response == "success") {
                                $(".flash-data1").html(data.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                        }
                    });
                }
            });
        })

        $("#addStokProduk").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addStokProduk').serialize();

            $.ajax({
                url: "<?php echo base_url("stok_produk/add_stok_produk_act") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#addStokProduk')[0].reset();
                        $('#mytableStokProduk').DataTable().ajax.reload();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        $('#stok_keluar').keyup(function() {
            var stok = parseInt($("#stok_produk_keluar").val());
            var stok2 = parseInt($("#stok_produk_keluar1").val());
            var stok_baru = parseInt($('#stok_keluar').val());
            if (isNaN(stok_baru)) {
                $('#stok_produk_keluar').val(stok2);
            } else if (stok_baru > stok2) {
                $(".error-data1").html("Stok Keluar Tidak Boleh melebihi stok yang ada.");
                $(".flash-data1").html("");
                toast();
                $('#stok_keluar').val("")
                $('#stok_produk_keluar').val(stok2);
            } else if (stok_baru <= stok2) {
                var total = stok2 - stok_baru;
                $('#stok_produk_keluar').val(total);
            }
        })

        $('#mytableStokProduk').on('click', '.lihat_record', function() {
            let id = $(this).data('id');
            var text = "";

            $.ajax({
                url: "<?php echo base_url("stok_produk/getDetailProductByLokasi") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    kd_detail_produk: id,
                    lokasi: $('#lokasi_stok').val()
                },
                success: function(data) {
                    $('#produk_txt').html(data[0].nm_produk + " - " + data[0].berat + " " + data[0].satuan_berat);
                    for (let i = 0; i < data.length; i++) {
                        text +=
                            "<tr>" +
                            "<td>" +
                            data[i].stok_lokasi +
                            "</td>" +
                            "<td>" +
                            ubah_tanggal(data[i].tanggal_masuk) +
                            "</td>" +
                            "</tr>";
                    }
                    $('#Modal_Lihat').modal('show');
                    $("#demo").html(text);
                }
            })
        })

        $('#Modal_Edit').on('hidden.bs.modal', function(e) {
            $("#bagian_edit_stok_produk").html("");
        })

        $('#Modal_Add').on('hidden.bs.modal', function(e) {
            $("#bagiantambahstokproduk").html("");
            $('.select2produk').val("").trigger('change');
            $('#stok_produk').val("");
        })

        $('#Modal_StokKeluar').on('hidden.bs.modal', function(e) {
            $("#bagiantambahstokprodukkeluar").html("");
            $('#kd_detail_produk_keluar').val("").trigger('change');
            $('#stok_produk_keluar').val("");
            $('#stok_keluar').val("");
        })

        $("#addStokKeluar").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addStokKeluar').serialize();

            $.ajax({
                url: "<?php echo base_url("stok_produk/stok_keluar_act") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_StokKeluar').modal('hide');
                        $('#addStokKeluar')[0].reset();
                        $('#mytableStokProduk').DataTable().ajax.reload();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        $('#mytableStokProduk').on('click', '.edit_record', function() {
            let id = $(this).data('id');
            var text = "";

            $.ajax({
                url: "<?php echo base_url("stok_produk/getDetailProductByLokasiGroup") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    kd_detail_produk: id,
                    lokasi: $('#lokasi_stok').val()
                },
                success: function(data) {
                    $('#kd_detail_produk_edit').val(data[0].kd_detail_produk);
                    $('#nm_produk_edit').val(data[0].nm_produk + " - " + data[0].berat + " " + data[0].satuan_berat);
                    for (let i = 0; i < data.length; i++) {
                        text = '<div class="form-group col-md-6 col-xs-6 col-6"><label>Stok Produk</label><input type="hidden" name="kd_stok_produk[]" value="' + data[i].kd_stok_produk + '" class="form-control" placeholder="Stok Produk"><input type="text" name="stok[]" value="' + data[i].stok_lokasi + '" class="form-control" placeholder="Stok Produk"></div><div class="form-group col-md-6 col-xs-6 col-6"><label>Tanggal Masuk</label><input type="text" name="tanggal_masuk[]" value="' + ubah_tanggal(data[i].tanggal_masuk) + '" class="form-control" placeholder="Stok Produk" readonly></div>';
                        $('#bagian_edit_stok_produk').append(text);
                    }

                    $('#Modal_Edit').modal('show');
                }
            })
        })

        $("#editStokProduk").submit(function(e) {
            e.preventDefault();
            let dataString = $('#editStokProduk').serialize();

            $.ajax({
                url: "<?php echo base_url("stok_produk/edit_stok_produk_act") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#editStokProduk')[0].reset();
                        $('#mytableStokProduk').DataTable().ajax.reload();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        $('#mytableStokProduk').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Apa Kamu Yakin?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus saja!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url("Stok_produk/hapus_stok_produk") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            kd_detail_produk: id,
                            lokasi: $('#lokasi_stok').val()
                        },

                        success: function(data) {
                            if (data.response == "success") {
                                $('#mytableStokProduk').DataTable().ajax.reload();
                                $(".flash-data1").html(data.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                        }
                    });
                }
            });
        })

        // ----------------------------------------- End Stok Produk -----------------------------------------
        // ----------------------------------------- Kelola Menu Masuk -----------------------------------------

        $('#mytableProductMasuk').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Product/get_produk_masuk') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "tgl_produk_masuk",
                    class: "text_center",
                    render: function(data) {
                        return ubah_tanggal(data);
                    }
                },
                {
                    data: "nm_supplier",
                    class: "text_center"
                },
                {
                    data: "nominal_bayar",
                    class: "text_center",
                    render: function(data) {
                        if (data != null) {
                            return convertToRupiah(data);
                        } else {
                            return "-";
                        }
                    }
                },
                {
                    data: "jenis_pembayaran",
                    class: "text_center",
                    render: function(data) {
                        return data;
                    }
                },
                {
                    data: "status_pembayaran",
                    class: "text_center",
                    render: function(data) {
                        if (data == 1) {
                            return '<span class="badge badge-success">Sudah Dibayar</span>';
                        } else {
                            return '<span class="badge badge-danger">Belum Dibayar</span>';
                        }
                    }
                },
                {
                    data: "bukti_pembayaran",
                    class: "text_center",
                    render: function(data, type, row, meta) {
                        if (data != null) {
                            return '<a href="javascript:void(0)" class="lihat_bukti_pembayaran" data-id="' + row.kd_produk_masuk + '">' + data + '</a>';
                        } else {
                            return "-";
                        }
                    }
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        if (row.status_pembayaran == 1) {
                            return data;
                        } else {
                            return data + '<span data-toggle="tooltip" data-placement="top" title="Hapus Supplier"><a href="javascript:void(0);" class="hapus_record btn btn-sm btn-danger ml-1" data-id="' + row.kd_produk_masuk + '" data-toggle="modal" data-target="#hapusModal"><i class="fas fa-trash"></i> </a>';
                        }
                    },
                }
            ],
        });

        $("#addProdukMasuk").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo base_url("Product/add_produk_masuk_act") ?>",
                type: 'post',
                dataType: 'json',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.response == "success") {
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                    window.location.href = "<?php echo base_url() ?>Product/produk_masuk";
                }
            });
        })

        $('#mytableProductMasuk').on('click', '.lihat_bukti_pembayaran', function() {
            let id = $(this).data('id');
            $.ajax({
                url: "<?php echo base_url("product/getProdukMasukById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_produk_masuk": id
                },
                success: function(data) {
                    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                        $(".error-data1").html("Maaf, untuk versi mobile belum tersedia.");
                        $(".flash-data1").html("");
                        toast();
                    } else {
                        $('#lihatbukti').modal('show');
                        if (data.path == "selera") {
                            $('#bagian_embed').html('<embed src="' + base_url + '/assets/images/bukti_pembayaran_supplier/' + data.bukti_pembayaran + '" frameborder="0" width="100%" height="400px">');
                        } else {
                            $('#bagian_embed').html('<embed src="' + base_url_stbaq + '/assets/images/bukti_pembayaran_supplier/' + data.bukti_pembayaran + '" frameborder="0" width="100%" height="400px">');
                        }
                    }
                }
            });
        });

        $('#mytableProductMasuk').on('click', '.lihat_detail_pm', function() {
            let id = $(this).data('id');

            $('#mytableDetailProductMasuk').DataTable({
                "searching": false,
                "paging": false,
                "info": false,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo base_url('Product/get_detail_produk_masuk') ?>",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        "kd_produk_masuk": id
                    }
                },
                "columns": [{
                        data: "kd_produk_masuk",
                        class: "text_center",
                        render: function(data, type, row, meta) {
                            return row.nm_produk + " - " + row.jenis_produk;
                        }
                    },
                    {
                        data: "stok_masuk",
                        class: "text_center"
                    },
                    {
                        data: "aksi",
                        class: "text-center",
                        width: 150,
                        orderable: false
                    }
                ],
            });

            $('#Modal_Detail_ProdukMasuk').modal('show');
        });

        $('#Modal_Detail_ProdukMasuk').on('hidden.bs.modal', function(e) {
            $('#mytableDetailProductMasuk').DataTable().destroy();
        })

        $('#mytableDetailProductMasuk').on('click', '.stok_keluar', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("product/getDetailProdukMasuk") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_detail_produk_masuk": id
                },
                success: function(data) {
                    $("#kd_produk_masuk_edit1").val(data.kd_produk_masuk);
                    $("#detail_produk_edit1").val(data.nm_produk);
                    $("#kd_detail_produk_edit1").val(data.kd_detail_produk);
                    if (data.lokasi == "tsp") {
                        $.ajax({
                            url: "<?php echo base_url("stok_produk/getStokproduktspbrp") ?>",
                            type: 'post',
                            dataType: 'json',
                            data: {
                                "kd_produk_masuk": data.kd_produk_masuk,
                                "kd_detail": data.kd_detail_produk,
                                "lokasi": "tsp"
                            },
                            success: function(result) {
                                $("#stok_produk_edit1").val(result.stok);
                                $("#stok_produk_edit2").val(result.stok);
                            }
                        });
                        $.ajax({
                            url: "<?php echo base_url("stok_produk/getStokproduktspbrp") ?>",
                            type: 'post',
                            dataType: 'json',
                            data: {
                                "kd_produk_masuk": data.kd_produk_masuk,
                                "kd_detail": data.kd_detail_produk,
                                "lokasi": "brp"
                            },
                            success: function(result) {
                                if (result != null) {
                                    var stok_awal = parseInt($("#stok_produk_edit1").val());
                                    var total = stok_awal + parseInt(result.stok);
                                    $("#stok_produk_edit2").val(total);
                                    $("#stok_keluar_edit1").val(result.stok);
                                } else {
                                    $("#stok_keluar_edit1").val(0);
                                }
                            }
                        });
                    } else {
                        $.ajax({
                            url: "<?php echo base_url("stok_produk/getStokproduktspbrp") ?>",
                            type: 'post',
                            dataType: 'json',
                            data: {
                                "kd_produk_masuk": data.kd_produk_masuk,
                                "kd_detail": data.kd_detail_produk,
                                "lokasi": "brp"
                            },
                            success: function(result) {
                                $("#stok_produk_edit1").val(result.stok);
                                $("#stok_produk_edit2").val(result.stok);
                            }
                        });
                        $.ajax({
                            url: "<?php echo base_url("stok_produk/getStokproduktspbrp") ?>",
                            type: 'post',
                            dataType: 'json',
                            data: {
                                "kd_produk_masuk": data.kd_produk_masuk,
                                "kd_detail": data.kd_detail_produk,
                                "lokasi": "tsp"
                            },
                            success: function(result) {
                                if (result != null) {
                                    var stok_awal = parseInt($("#stok_produk_edit1").val());
                                    var total = stok_awal + parseInt(result.stok);
                                    $("#stok_produk_edit2").val(total);
                                    $("#stok_keluar_edit1").val(result.stok);
                                } else {
                                    $("#stok_keluar_edit1").val(0);
                                }
                            }
                        });
                    }
                }
            });
            $('#Modal_Stok_keluar').modal('show');
        });

        $('#stok_keluar_edit1').keyup(function() {
            var stok = parseInt($("#stok_produk_edit1").val());
            var stok2 = parseInt($("#stok_produk_edit2").val());
            var stok_baru = parseInt($('#stok_keluar_edit1').val());
            if (isNaN(stok_baru)) {
                $('#stok_produk_edit1').val(stok2);
            } else if (stok_baru > stok2) {
                $(".error-data1").html("Stok Keluar Tidak Boleh melebihi stok yang ada.");
                $(".flash-data1").html("");
                toast();
                $('#stok_keluar_edit1').val("")
                $('#stok_produk_edit1').val(stok2);
            } else if (stok_baru <= stok2) {
                var total = stok2 - stok_baru;
                $('#stok_produk_edit1').val(total);
            }
        })

        $("#AddStokKeluar").submit(function(e) {

            e.preventDefault();
            let dataString = $('#AddStokKeluar').serialize();

            $.ajax({
                url: "<?php echo base_url("stok_produk/add_stok_keluar") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Stok_keluar').modal('hide');
                        $('#AddStokKeluar')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            })
        })

        $('#mytableProductMasuk').on('click', '.edit_record', function() {
            let id = $(this).data('id');
            $("#showbagianprodukmasuk").html("");
            $("#bagianProdukMasuk").html("");
            $("#modal-detail").html("");

            $.ajax({
                url: "<?php echo base_url("product/getDetailProdukMasukById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_produk_masuk": id
                },
                success: function(data1) {
                    $('#jmlbarangplus').val(data1.length);
                    $('#jmlbarang1').val(data1.length);
                    var text = "";
                    for (let i = 1; i <= data1.length; i++) {

                        $("body").on("click", "#hapusfieldprodukmasuk" + i, function() {
                            $("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

                            $(this)
                                .parents("#bagianProdukhapus" + i)
                                .remove();
                        });

                        $(document).ready(function() {
                            $(".rupiah-mask" + i).inputmask({
                                alias: "numeric",
                                groupSeparator: ",",
                                autoGroup: true,
                                digits: 0,
                                digitsOptional: false,
                                prefix: "Rp. ",
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
                                prefix: "Rp. ",
                                placeholder: "0",
                                rightAlign: false,
                                autoUnmask: true,
                                removeMaskOnSubmit: true,
                            });

                            $("#datepickersingle" + i).daterangepicker({
                                    singleDatePicker: true,
                                    showDropdowns: true,
                                    minYear: 1901,
                                    locale: {
                                        format: "YYYY-MM-DD",
                                    },
                                    maxYear: parseInt(moment().format("YYYY"), 10),
                                },
                                function(start, end, label) {
                                    var years = moment().diff(start, "years");
                                }
                            );
                        });

                        $("#showbagianprodukmasuk").append(
                            '<div id="bagianProdukhapus' +
                            i + '"><hr id="hr"><div class="form-group row" id="detailProduk' +
                            i + '"><div class="col-3 col-sm-3 col-md-3 mt-2" id="produkk"><label for="produk1">Nama Menu</label><select class="form-control select2produksup' +
                            i + '" name="produk[]" id="produk' +
                            i + '" style="width: 100%;" required><option value="">Pilih Produk</option></select></div><div class="col-3 col-sm-3 col-md-2 mt-2"><div class="form-group"><label for="jml_ukuran">Harga Modal <small>Per Pcs</small></label><input type="text" class="form-control input-rupiah-mask" name="harga_modal[]" id="harga_modal' +
                            i + '" placeholder="Masukan Harga Modal" required></div></div><div class="col-3 col-sm-3 col-md-2 mt-2"><div class="form-group"><label for="harga_produk">Harga Menu <small>Per Pcs</small></label><input type="text" class="form-control input-rupiah-mask" name="harga_produk[]" id="harga_produk' +
                            i + '" placeholder="Masukan Harga Menu" required></div></div><div class="col-3 col-sm-3 col-md-2 mt-2"><div class="form-group"><label for="jml_ukuran">Ujroh Reseller <small>Per Pcs</small></label><input type="text" class="form-control input-rupiah-mask" name="ujroh_reseller[]" id="ujroh_reseller' +
                            i + '" placeholder="Masukan Ujroh Reseller" required></div></div><div class="col-3 col-sm-3 col-md-2 mt-2"><div class="form-group"><label>Stok Masuk</label><input type="number" name="stok_masuk[]" id="stok_masuk' + i + '" class="form-control" min="1" max="1000" placeholder="Stok Masuk" required></div></div><div class="col-md-1 col-1 col-sm-1"><label></label><br><a href="javascript:void(0)" class="btn btn-danger mt-3 btn-block" id="hapusfieldprodukmasuk' +
                            i + '" required><i class="fa fa-minus"></i> </a></div></div></div>'
                        );

                        $('#stok_masuk' + i).val(data1[i - 1].stok_masuk)

                        $.ajax({
                            url: "<?php echo base_url("product/getDetailProductAll") ?>",
                            type: 'post',
                            dataType: 'json',
                            success: function(response) {
                                for (let j = 0; j < response.length; j++) {
                                    if (data1[i - 1].kd_detail_produk == response[j].kd_detail_produk) {
                                        $('#harga_modal' + i).val(response[j].harga_modal);
                                        $('#harga_produk' + i).val(response[j].harga_produk);
                                        text +=
                                            "<option value=" +
                                            response[j].kd_detail_produk + " selected>" +
                                            response[j].nm_produk + " - " + response[j].berat + " " + response[j].satuan_berat + "</option>";
                                    } else {
                                        text +=
                                            "<option value=" +
                                            response[j].kd_detail_produk + ">" +
                                            response[j].nm_produk + " - " + response[j].berat + " " + response[j].satuan_berat + "</option>";
                                    }
                                }
                                $('#produk' + i).html(text);
                            }
                        });

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

                        $.ajax({
                            url: base_url + "/Product/getdetailprodukcalc",
                            type: 'post',
                            dataType: 'json',
                            data: {
                                "kd_detail": data1[i - 1].kd_detail_produk,
                            },
                            success: function(data) {
                                $('#harga_modal' + i).val(data.harga_modal)
                                $('#harga_produk' + i).val(data.harga_produk)
                                $('#ujroh_reseller' + i).val(data.margin_reseller)
                                $('#biaya_lainnya' + i).val(data.biaya_lainnya)
                                $('#total_modal' + i).val(data.total_modal)
                                $('#margin' + i).val(data.margin_produk)
                                $('#hasil_margin' + i).val(data.hasil_margin)
                                $('#harga_jual' + i).val(data.harga_jual)
                                $('#pembulatan_harga_jual' + i).val(data.pembulatan_harga_jual)
                                $('#harga_competitor' + i).val(data.harga_kompetitor)
                                $('#selisih_harga' + i).val(data.selisih_harga)
                                $('#margin100' + i).val(data.margin_keseluruhan)
                                $('#margin70' + i).val(data.margin_selera)
                                $('#margin30' + i).val(data.margin_reseller)
                                $('#insentif' + i).val(data.insentif)
                                $('#hasil_insentif' + i).val(data.hasil_harga_insentif)
                                $('#harga_jual_reseller' + i).val(data.pembulatan_harga_reseller)
                                $('#selisih_harga_jual' + i).val(data.selisih_harga_jual)
                                $('#kelebihan_bagi_hasil' + i).val(data.kelebihan_margin_ujroh)
                                $('#hrg_competitor' + i).val(data.harga_kompetitor)
                                $('#hrg_jual_umum' + i).val(data.pembulatan_harga_jual)
                                $('#hrg_jual_reseller' + i).val(data.pembulatan_harga_reseller)
                            }
                        });

                        $(".select2produksup" + i).select2({
                            placeholder: "Pilih Produk",
                            ajax: {
                                url: base_url + "/select2/get_json_detail_produk",
                                type: "post",
                                dataType: "json",
                                delay: 100,
                                data: function(params) {
                                    return {
                                        searchTerm: params.term, // search term
                                    };
                                },
                                processResults: function(response) {
                                    return {
                                        results: response,
                                    };
                                },
                                cache: true,
                            },
                        });

                        $(".select2produksup" + i).on("select2:select", function(e) {
                            var id = e.params.data.id;

                            $.ajax({
                                url: base_url + "/Product/getdetailprodukcalc",
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    "kd_detail": id,
                                },
                                success: function(data) {
                                    $('#harga_modal' + i).val(data.harga_modal)
                                    $('#harga_produk' + i).val(data.harga_produk)
                                    $('#ujroh_reseller' + i).val(data.margin_reseller)
                                    $('#biaya_lainnya' + i).val(data.biaya_lainnya)
                                    $('#total_modal' + i).val(data.total_modal)
                                    $('#margin' + i).val(data.margin_produk)
                                    $('#hasil_margin' + i).val(data.hasil_margin)
                                    $('#harga_jual' + i).val(data.harga_jual)
                                    $('#pembulatan_harga_jual' + i).val(data.pembulatan_harga_jual)
                                    $('#harga_competitor' + i).val(data.harga_kompetitor)
                                    $('#selisih_harga' + i).val(data.selisih_harga)
                                    $('#margin100' + i).val(data.margin_keseluruhan)
                                    $('#margin70' + i).val(data.margin_selera)
                                    $('#margin30' + i).val(data.margin_reseller)
                                    $('#insentif' + i).val(data.insentif)
                                    $('#hasil_insentif' + i).val(data.hasil_harga_insentif)
                                    $('#harga_jual_reseller' + i).val(data.pembulatan_harga_reseller)
                                    $('#selisih_harga_jual' + i).val(data.selisih_harga_jual)
                                    $('#kelebihan_bagi_hasil' + i).val(data.kelebihan_margin_ujroh)
                                    $('#hrg_competitor' + i).val(data.harga_kompetitor)
                                    $('#hrg_jual_umum' + i).val(data.pembulatan_harga_jual)
                                    $('#hrg_jual_reseller' + i).val(data.pembulatan_harga_reseller)
                                }
                            });
                        });

                        $('#ujroh_reseller' + i).on('keyup', function() {
                            var ujroh = $(this).val();

                            var margin100 = $('#margin100' + i).val();
                            var margin70 = $('#margin70' + i).val();
                            var margin30 = $('#margin30' + i).val();

                            if (margin100 == "" || margin100 == null) {
                                Toast.fire({
                                    icon: "error",
                                    title: "Harap Memilih produk terlebih dahulu.",
                                });
                                $('#ujroh_reseller' + i).val(0)
                            } else {
                                if (parseInt(ujroh) > parseInt(margin100)) {
                                    $(".error-data1").html("Maaf ujroh tidak bisa lebih dari Rp." + margin100);
                                    $(".flash-data1").html("");
                                    toast();
                                    $('#ujroh_reseller' + i).val(0)
                                } else {
                                    var ujroh_selera = margin100 - ujroh;
                                    $('#margin30' + i).val(ujroh);
                                    $('#margin70' + i).val(ujroh_selera);
                                }
                            }
                        })
                    }
                }
            });

            $.ajax({
                url: "<?php echo base_url("product/getProdukMasukById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_produk_masuk": id
                },
                success: function(data) {
                    $("#tanggal_produk_masuk").val(data.tgl_produk_masuk);
                    $("#nominal_bayar").val(data.nominal_bayar);
                    $("#supplier_edit")
                        .select2()
                        .val(data.kd_supplier)
                        .trigger("change");
                    if (data.jenis_pembayaran == null && data.bukti_pembayaran == null) {
                        $("#checkboxbayarnanti1").prop("checked", true);
                        $("#metode_pembayaran1").attr("required", false);
                        $('.bagian-pembayaran').hide();
                    } else {
                        $("#checkboxbayarnanti1").prop("checked", false);
                        $("#metode_pembayaran1").attr("required", true);
                        $('.bagian-pembayaran').show();
                    }
                    $('#metode_pembayaran1').val(data.jenis_pembayaran).trigger('change');
                }
            });

            $('#Modal_Edit').modal('show');
        });

        $("#editProdukMasuk").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo base_url("product/edit_produk_masuk") ?>",
                type: 'post',
                dataType: 'json',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.response == "success") {
                        $('#editModal').modal('hide');
                        $('#mytableProductMasuk').DataTable().ajax.reload();
                        $('#editProdukMasuk')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $('#mytableProductMasuk').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("product/getProdukMasukById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_produk_masuk": id
                },
                success: function(data) {
                    $("#kd_produk_masuk_delete").val(data.kd_produk_masuk);
                }
            });
            $('#Modal_Delete').modal('show');
        });

        $("#hapusProdukMasuk").submit(function(e) {
            e.preventDefault();
            let id = $('#kd_produk_masuk_delete').val();

            $.ajax({
                url: "<?php echo base_url("product/delete_produk_masuk") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_produk_masuk": id,
                },
                success: function(data) {

                    if (data.response == "success") {
                        $('#mytableProductMasuk').DataTable().ajax.reload();
                        $('#hapusModal').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        // ----------------------------------------- End Kelola Menu Masuk -----------------------------------------

        // ----------------------------------------- Kelola Reseller Aktif -----------------------------------------

        $('#mytableResellerMemberRs').DataTable({
            "serverSide": true,
            "searching": false,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Reseller/get_resellermember_rs') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_member",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_member",
                    class: "text_center"
                },
                {
                    data: "no_telp",
                    class: "text_center"
                },
                {
                    data: "is_member_aktif",
                    class: "text_center",
                    render: function(data, type, row, meta) {
                        if (data == 1) {
                            return '<span class="badge badge-pill badge-success">Aktif</span>';
                        } else {
                            return '<span class="badge badge-pill badge-danger">Non Aktif</span>';
                        }
                    },
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ]
        });
        $('#mytableResellerMemberRs').on('click', '.edit_record', function() {
            let id = $(this).data('id');
            var text = "";
            $.ajax({
                url: "<?php echo base_url("member/getMemberById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_member": id
                },
                success: function(data) {
                    $("#kd_member_edit").val(data.kd_member);
                    $("#nm_member_edit").val(data.nm_member);
                    $("#username_edit").val(data.username);
                    $("#kode_pos_edit").val(data.kodepos);
                    $("#jk_edit").val(data.jenis_kelamin);
                    $("#no_telp_edit").val(data.no_telp);
                    $("#email_edit").val(data.email);

                    $.ajax({
                        url: "<?php echo base_url("member/getKecamatan") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "kd_kecamatan": data.kd_subdistricts
                        },
                        success: function(result) {
                            text += "<option value=" + result.id + " selected>" +
                                result.provinsi + "," + result.kabupaten + ", " + result.kecamatan + ", " + result.kelurahan + ", " + result.kodepos + "</option>";
                            $('#pilihankecamatan_edit').html(text);
                        }
                    });
                    $('#alamat_edit').summernote("code", decrypt(data.alamat));

                    if ((data.twitter == "" && data.instagram == "" && data.facebook == "") || (data.twitter == null && data.instagram == null && data.facebook == null)) {
                        $("#checkboxsosmed_edit").prop("checked", false);
                        $("#socialmedia_edit").hide();
                        $("#instagram_edit").val(data.instagram);
                        $("#facebook_edit").val(data.facebook);
                        $("#twitter_edit").val(data.twitter);
                        $("#status_member_edit").val(data.is_member_aktif);
                    } else {
                        $("#checkboxsosmed_edit").prop("checked", true);
                        $("#socialmedia_edit").show();
                        $("#instagram_edit").val(data.instagram);
                        $("#facebook_edit").val(data.facebook);
                        $("#twitter_edit").val(data.twitter);
                        $("#status_member_edit").val(data.is_member_aktif);
                    }
                }
            });
            $('#editModalMember').modal('show');
        });

        function search_reseller_member_rs(key, path) {
            $('#' + path).DataTable({
                "searching": false,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo base_url('Reseller/get_reseller_member_rs') ?>",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        key: key,
                    }
                },
                "columns": [{
                        data: "nm_member",
                        class: "text-center",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "nm_member",
                        class: "text_center"
                    },
                    {
                        data: "no_telp",
                        class: "text_center"
                    },
                    {
                        data: "is_member_aktif",
                        class: "text_center",
                        render: function(data, type, row, meta) {
                            if (data == 1) {
                                return '<span class="badge badge-pill badge-success">Aktif</span>';
                            } else {
                                return '<span class="badge badge-pill badge-danger">Non Aktif</span>';
                            }
                        },
                    },
                    {
                        data: "aksi",
                        class: "text-center",
                        width: 150,
                        orderable: false
                    }
                ]
            });

        }

        $('#search_reseller_member_rs').keyup(function() {
            var key = $('#search_reseller_member_rs').val();
            $('#mytableResellerMemberRs').DataTable().destroy();
            search_reseller_member_rs(key, "mytableResellerMemberRs");
        })

        $('#mytableResellerMember').DataTable({
            "serverSide": true,
            "searching": false,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Reseller/get_resellermember') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_reseller",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_reseller",
                    class: "text_center"
                },
                {
                    data: "no_telp",
                    class: "text_center"
                },
                {
                    data: "jumlah_member",
                    class: "text_center",
                    render: function(data, type, row) {
                        return data + " Member";
                    },
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        function search_reseller_member(key, path) {
            $('#' + path).DataTable({
                "searching": false,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo base_url("Reseller/get_reseller_member/") ?>",
                    type: "POST",
                    data: {
                        key: key,
                    }
                },
                "columns": [{
                        data: "nm_reseller",
                        class: "text-center",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "nm_reseller",
                        class: "text_center"
                    },
                    {
                        data: "no_telp",
                        class: "text_center"
                    },
                    {
                        data: "jumlah_member",
                        class: "text_center",
                        render: function(data, type, row) {
                            return data + " Member";
                        },
                    },
                    {
                        data: "aksi",
                        class: "text-center",
                        width: 150,
                        orderable: false
                    }
                ],
            });
        }

        $('#search_reseller_member').keyup(function() {
            var key = $('#search_reseller_member').val();
            $('#mytableResellerMember').DataTable().destroy();
            search_reseller_member(key, "mytableResellerMember");
        })

        $("#addResellerMember").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addResellerMember').serialize();

            $.ajax({
                url: "<?php echo base_url("Reseller/add_reseller_member") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#pilihreselleract').val("").trigger('change');
                        $('#pilihmemberact').val("").trigger('change');
                        $('#bagiantambahmember').html("");
                        $('#mytableResellerMember').DataTable().ajax.reload();
                        $('#addResellerMember')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        $('#Modal_Edit_rm').on('hidden.bs.modal', function(e) {
            $("#bagianresellermemberedit").html("");
            $("#bagiantambahmemberedit").html("");
        })

        $('#mytableResellerMember').on('click', '.edit_record_rm', function() {
            let id = $(this).data('id');
            var text = "";
            var html = "";

            $.ajax({
                url: "<?php echo base_url("reseller/getResellerMemberById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_reseller": id
                },
                success: function(data) {
                    $('#jmlbarangplusedit').val(data.length);
                    $('#jmlbarang1edit').val(data.length);
                    $('#resellermemberedit').val(data[0].kd_reseller);
                    text += "<option value=" + data[0].kd_reseller + " selected>" +
                        data[0].nm_reseller + " - " + data[0].no_telp_res + "</option>";
                    $('#resellermember').html(text);
                    for (let i = 0; i < data.length; i++) {
                        html = '<div id="bagianhapusmemberedit' + i + '"><div class="row"><div class="col-md-11 col-xs-10 col-10"><div class="form-group"><select name="member[]" class="form-control select2member' + i + '" id="buttonmember' + i + '" required><option value=' + data[i].kd_member + ' selected>' +
                            data[i].nm_member + " - " + data[i].no_telp_mem + '</option></select><input type="hidden" id="datamemberlama' + i + '" value="' + data[i].kd_member + '"></div></div><div class="col-md-1 col-xs-1 col-1"><a href="javascript:void(0);" class="btn btn-danger" id="buttonhapusmemberedit' + i + '"> <i class="fa fa-minus"></i></a></div></div></div>';

                        $("#bagianresellermemberedit").append(html);

                        $("body").on("click", "#buttonhapusmemberedit" + i, function() {
                            $(this)
                                .parents("#bagianhapusmemberedit" + i)
                                .remove();
                        });

                        $('#buttonmember' + i).on('change', function() {
                            var id = $('#buttonmember' + i).val();
                            var memberlama = $('#datamemberlama' + i).val();
                            if (id != memberlama) {
                                var text = "";
                                $.ajax({
                                    url: base_url + "/reseller/getResellerMemberByIdMember",
                                    type: 'post',
                                    dataType: 'json',
                                    data: {
                                        "kd_member": id
                                    },
                                    success: function(data) {
                                        if (data.no == 1) {
                                            // itu ada
                                            $(".error-data1").html("Member Sudah Terdaftar");
                                            toast();
                                            text += "<option value=" + "selected>Pilih Member</option>";
                                            $('#buttonmember' + i).html(text);
                                        }
                                    }
                                });
                            }
                        })

                        $(".select2member" + i).select2({
                            minimumInputLength: 3,
                            ajax: {
                                url: base_url + "/Member/get_json",
                                type: "post",
                                dataType: "json",
                                delay: 100,
                                data: function(params) {
                                    return {
                                        searchTerm: params.term, // search term
                                    };
                                },
                                processResults: function(response) {
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
            $('#Modal_Edit_rm').modal({
                backdrop: 'static',
                keyboard: false
            })
        });

        $('#editResellerMember').submit(function(e) {
            e.preventDefault();
            let dataString = $('#editResellerMember').serialize();

            $.ajax({
                url: "<?php echo base_url("reseller/edit_reseller_member") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit_rm').modal('hide');
                        $('#mytableResellerMember').DataTable().ajax.reload();
                        $('#editResellerMember')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        $('#mytableResellerMember').on('click', '.lihat_record', function() {
            let id = $(this).data('id');
            var text = "";
            var html = "";

            $.ajax({
                url: "<?php echo base_url("reseller/getResellerMemberById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_reseller": id
                },
                success: function(data) {
                    text += '<tr>' +
                        '<td>' + data[0].kd_reseller + '</td>' +
                        '<td>' + data[0].nm_reseller + '</td>' +
                        '<td>' + data[0].no_telp_res + '</td>' +
                        '</tr>';
                    $('#demo').html(text);
                    for (let i = 0; i < data.length; i++) {
                        html += '<tr>' +
                            '<td>' + data[i].kd_member + '</td>' +
                            '<td>' + data[i].nm_member + '</td>' +
                            '<td>' + data[i].no_telp_mem + '</td>' +
                            '</tr>';
                    }
                    $('#demo1').html(html);
                }
            });

            $('#Modal_Lihat_rm').modal({
                backdrop: 'static',
                keyboard: false
            })
        });

        $('#pilihmemberact').on('change', function() {
            var id = $('#pilihmemberact').val();
            var text = "";
            $.ajax({
                url: base_url + "/reseller/getResellerMemberByIdMember",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_member": id
                },
                success: function(data) {
                    if (data.no == 1) {
                        // itu ada
                        $(".flash-data1").html("");
                        $(".error-data1").html("Member Sudah Terdaftar");
                        toast();
                        text += "<option value=" + "selected>Pilih Member</option>";
                        $('#pilihmemberact').html(text);
                    }
                }
            });
        })

        $('#pilihreselleract').on('change', function() {
            var id = $('#pilihreselleract').val();
            var text = "";
            $.ajax({
                url: base_url + "/reseller/getResellerMemberByIdReseller",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_reseller": id
                },
                success: function(data) {
                    if (data.no == 1) {
                        // itu ada
                        $(".flash-data1").html("");
                        $(".error-data1").html("Reseller Sudah Terdaftar");
                        toast();
                        text += "<option value=" + "selected>Pilih Reseller</option>";
                        $('#pilihreselleract').html(text);
                    }
                }
            });
        })

        $('#mytableResellerMember').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("reseller/getResellerUtamaById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_reseller": id
                },
                success: function(data) {}
            });
            $('#Modal_Delete').modal({
                backdrop: 'static',
                keyboard: false
            })
        });

        $("#hapusResellerUtama").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo base_url("reseller/delete_reseller_utama") ?>",
                type: 'post',
                dataType: 'json',
                success: function(data) {

                    if (data.response == "success") {
                        $('#mytableResellerMember').DataTable().ajax.reload();
                        $('#mytableResellerHapus').DataTable().ajax.reload();
                        $('#Modal_Delete').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        $('#mytableResellerHapus').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Reseller/get_resellermemberhapus') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_reseller",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_reseller",
                    class: "text_center"
                },
                {
                    data: "no_telp",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytableResellerHapus').on('click', '.revive_record_rm', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("reseller/getResellerUtamaById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_reseller": id
                },
                success: function(data) {}
            });
            $('#Modal_Revive').modal({
                backdrop: 'static',
                keyboard: false
            })
        });

        $("#reviveResellerUtama").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo base_url("reseller/revive_reseller_utama") ?>",
                type: 'post',
                dataType: 'json',
                success: function(data) {

                    if (data.response == "success") {
                        $('#mytableResellerHapus').DataTable().ajax.reload();
                        $('#mytableResellerMember').DataTable().ajax.reload();
                        $('#Modal_Revive').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        $('#mytableReseller').DataTable({
            "serverSide": true,
            "searching": false,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Reseller/get_reseller/1') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_reseller",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_reseller",
                    class: "text_center"
                },
                {
                    data: "jenis_kelamin",
                    class: "text_center"
                },
                {
                    data: "no_telp",
                    class: "text_center"
                },
                {
                    data: "alamat",
                    class: "text_center",
                    render: function(data, type, row) {
                        var data = decrypt(data);
                        var res = data.slice(0, 45);
                        var res1 = data.slice(46);
                        if (res1 != "") {
                            var res = res + res1.replace(res1, "...");
                        }
                        return res;
                    },
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        function search_reseller(key, no, path) {
            $('#' + path).DataTable({
                "searching": false,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo base_url("Reseller/get_search_reseller/") ?>",
                    type: "POST",
                    data: {
                        key: key,
                        no: no
                    }
                },
                "columns": [{
                        data: "nm_reseller",
                        class: "text-center",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "nm_reseller",
                        class: "text_center"
                    },
                    {
                        data: "jenis_kelamin",
                        class: "text_center"
                    },
                    {
                        data: "no_telp",
                        class: "text_center"
                    },
                    {
                        data: "alamat",
                        class: "text_center",
                        render: function(data, type, row) {
                            var data = decrypt(data);
                            var res = data.slice(0, 45);
                            var res1 = data.slice(46);
                            if (res1 != "") {
                                var res = res + res1.replace(res1, "...");
                            }
                            return res;
                        },
                    },
                    {
                        data: "aksi",
                        class: "text-center",
                        width: 150,
                        orderable: false
                    }
                ],
            });
        }

        $('#search_reseller1').keyup(function() {
            var key = $('#search_reseller1').val();
            $('#mytableReseller').DataTable().destroy();
            search_reseller(key, 1, "mytableReseller");
        })

        $('#search_reseller2').keyup(function() {
            var key = $('#search_reseller2').val();
            $('#mytableResellerTdkAktif').DataTable().destroy();
            search_reseller(key, 0, "mytableResellerTdkAktif");
        })

        $('#mytableReseller').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            getResellerById(id, "Edit");
        });

        $('#mytableReseller').on('click', '.qr_reseller', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("reseller/getResellerById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_reseller": id
                },
                success: function(data) {
                    $('#linkPrint').attr('href', base_url + '/main/print_QrCode/' + id);

                    $("#labelReseller").html("QrCode Reseller " + data.nm_reseller);

                    $('#image-preview').attr('src', base_url + '/assets/images/qrcode/reseller/' + id + ".png");
                    $('#image-preview').hide();
                    $('#image-preview').fadeIn(650);
                }
            });
            $('#Modal_Print').modal('show');

        });

        $('#mytableReseller').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            getResellerById(id, "Delete");
        });

        $('#mytableReseller').on('click', '.rst_pass', function() {
            let id = $(this).data('id');

            getResellerById(id, "Reset");
        });

        $("#ResetPasswordReseller").submit(function(e) {
            e.preventDefault();
            let id = $('#reseller_code_delete').val();

            $.ajax({
                url: "<?php echo base_url("reseller/reset_password_reseller") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_reseller": id,
                },
                success: function(data) {

                    if (data.response == "success") {
                        $('#mytableReseller').DataTable().ajax.reload();
                        $('#mytableResellerTdkAktif').DataTable().ajax.reload();
                        $('#Modal_Reset').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $('#Modal_Reset').modal('hide');
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        // ---------------------------------------- End Klola Reseller Aktif ----------------------------------------

        // ----------------------------------------- Kelola Reseller Tidak Aktif -----------------------------------------

        $('#mytableResellerTdkAktif').DataTable({
            "serverSide": true,
            "searching": false,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Reseller/get_reseller/0') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_reseller",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_reseller",
                    class: "text_center"
                },
                {
                    data: "jenis_kelamin",
                    class: "text_center"
                },
                {
                    data: "no_telp",
                    class: "text_center"
                },
                {
                    data: "alamat",
                    class: "text_center",
                    render: function(data, type, row) {
                        var data = decrypt(data);
                        var res = data.slice(0, 45);
                        var res1 = data.slice(46);
                        if (res1 != "") {
                            var res = res + res1.replace(res1, "...");
                        }
                        return res;
                    },
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytableResellerTdkAktif').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            getResellerById(id, "Edit");
        });

        $('#mytableResellerTdkAktif').on('click', '.qr_reseller', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("reseller/getResellerById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_reseller": id
                },
                success: function(data) {
                    $('#linkPrint').attr('href', base_url + '/main/print_QrCode/' + id);

                    $("#labelReseller").html("QrCode Reseller " + data.nm_reseller);

                    $('#image-preview').attr('src', base_url + '/assets/images/qrcode/reseller/' + id + ".png");
                    $('#image-preview').hide();
                    $('#image-preview').fadeIn(650);
                }
            });
            $('#Modal_Print').modal('show');

        });

        $('#mytableResellerTdkAktif').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            getResellerById(id, "Delete");
        });

        // ---------------------------------------- End Kelola Reseller Tidak Aktif ----------------------------------------

        // ---------------------------------------- Kelola Reseller ----------------------------------------
        $("#addReseller").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addReseller').serialize();

            $.ajax({
                url: "<?php echo base_url("Reseller/add_reseller") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytableReseller').DataTable().ajax.reload();
                        $('#mytableResellerTdkAktif').DataTable().ajax.reload();
                        $('#addReseller')[0].reset();
                        $('#alamat').summernote("code", "");
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        if (data.message == "Nomor HP Sudah Terdaftar!") {
                            $("#no_telp").focus();
                        } else if (data.message == "Email Sudah Terdaftar!") {
                            $("#email").focus();
                        }
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        function getResellerById(id, action) {
            $.ajax({
                url: "<?php echo base_url("reseller/getResellerById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_reseller": id
                },
                success: function(data) {
                    if (action == "Edit") {
                        $("#kd_reseller_edit").val(data.kd_reseller);
                        $("#nm_reseller_edit").val(data.nm_reseller);
                        $("#jenis_kelamin_edit").val(data.jenis_kelamin);
                        $("#jk_edit").val(data.jenis_kelamin);
                        $("#jk_editt").val(data.jenis_kelamin);
                        $("#no_telp_edit").val(data.no_telp);
                        $("#email_edit").val(data.email);
                        $('#alamat_edit').summernote("code", decrypt(data.alamat));
                        $("#status_edit").val(data.is_reseller_aktif);
                        $("#ktp_edit").val(data.ktp);
                        $("#npwp_edit").val(data.npwp);
                        $("#atas_nama_edit").val(data.atas_nama);
                        $("#bank_edit").val(data.bank);
                        $("#no_rekening_edit").val(data.no_rekening);
                    }
                }
            });
            $('#Modal_' + action).modal({
                backdrop: 'static',
                keyboard: false
            })
        }

        $("#editReseller").submit(function(e) {

            e.preventDefault();
            let dataString = $('#editReseller').serialize();

            $.ajax({
                url: "<?php echo base_url("reseller/edit_reseller") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#mytableReseller').DataTable().ajax.reload();
                        $('#mytableResellerTdkAktif').DataTable().ajax.reload();
                        $('#editReseller')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        if (data.message == "Nomor HP Sudah Terdaftar!") {
                            $("#no_telp_edit").focus();
                        } else if (data.message == "Email Sudah Terdaftar!") {
                            $("#email_edit").focus();
                        }
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $("#hapusReseller").submit(function(e) {
            e.preventDefault();
            let id = $('#reseller_code_delete').val();

            $.ajax({
                url: "<?php echo base_url("reseller/delete_reseller") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_reseller": id,
                },
                success: function(data) {

                    if (data.response == "success") {
                        $('#mytableReseller').DataTable().ajax.reload();
                        $('#mytableResellerTdkAktif').DataTable().ajax.reload();
                        $('#Modal_Delete').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        // ---------------------------------------- End Kelola Reseller ----------------------------------------

        // ----------------------------------------- Kelola Supplier Tidak Aktif -----------------------------------------

        $('#mytableSupplierTidakAktif').DataTable({
            "serverSide": true,
            "order": [],
            "searching": false,
            "ajax": {
                url: "<?php echo base_url('Supplier/get_supplier_tidakaktif') ?>",
                type: 'post',
                tableSuppdataType: 'json'
            },
            "columns": [{
                    data: "nm_supplier",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_supplier",
                    class: "text_center"
                },
                {
                    data: "contact_person",
                    class: "text_center"
                },
                {
                    data: "no_telp",
                    class: "text_center"
                },
                {
                    data: "email",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        function search_supplier_tidak_aktif(key) {
            $('#mytableSupplierTidakAktif').DataTable({
                "searching": false,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo base_url("Supplier/get_search_supplier_tidakaktif") ?>",
                    type: "POST",
                    data: {
                        key: key,
                    }
                },
                "columns": [{
                        data: "nm_supplier",
                        class: "text-center",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "nm_supplier",
                        class: "text_center"
                    },
                    {
                        data: "contact_person",
                        class: "text_center"
                    },
                    {
                        data: "no_telp",
                        class: "text_center"
                    },
                    {
                        data: "email",
                        class: "text_center"
                    },
                    {
                        data: "aksi",
                        class: "text-center",
                        width: 150,
                        orderable: false
                    }
                ],
            });
        }

        $('#search_supplier_tidakaktif').keyup(function() {
            var key = $('#search_supplier_tidakaktif').val();
            $('#mytableSupplierTidakAktif').DataTable().destroy();
            search_supplier_tidak_aktif(key);
        })

        $('#mytableSupplierTidakAktif').on('click', '.acc_record', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Apa Kamu Yakin ingin menyetujui ini?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Setuju!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url("Supplier/acc_supplier") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "id": id
                        },
                        success: function(data) {
                            if (data.response == "success") {
                                $('#mytableSupplierTidakAktif').DataTable().ajax.reload();
                                $(".flash-data1").html(data.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                        }
                    });
                }
            });

        });
        // ----------------------------------------- Kelola Supplier Tidak Aktif -----------------------------------------
        // ----------------------------------------- Kelola Supplier Aktif -----------------------------------------

        $('#mytableSupplier').DataTable({
            "serverSide": true,
            "order": [],
            "searching": false,
            "ajax": {
                url: "<?php echo base_url('Supplier/get_supplier') ?>",
                type: 'post',
                tableSuppdataType: 'json'
            },
            "columns": [{
                    data: "nm_supplier",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_supplier",
                    class: "text_center"
                },
                {
                    data: "contact_person",
                    class: "text_center"
                },
                {
                    data: "no_telp",
                    class: "text_center"
                },
                {
                    data: "email",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        function search_supplier(key) {
            $('#mytableSupplier').DataTable({
                "searching": false,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "<?php echo base_url("Supplier/get_search_supplier") ?>",
                    type: "POST",
                    data: {
                        key: key,
                    }
                },
                "columns": [{
                        data: "nm_supplier",
                        class: "text-center",
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "nm_supplier",
                        class: "text_center"
                    },
                    {
                        data: "contact_person",
                        class: "text_center"
                    },
                    {
                        data: "no_telp",
                        class: "text_center"
                    },
                    {
                        data: "email",
                        class: "text_center"
                    },
                    {
                        data: "aksi",
                        class: "text-center",
                        width: 150,
                        orderable: false
                    }
                ],
            });
        }

        $('#search_supplier').keyup(function() {
            var key = $('#search_supplier').val();
            $('#mytableSupplier').DataTable().destroy();
            search_supplier(key);
        })

        $('#mytableSupplier').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            getSupplierById(id, "Edit")
        });

        $('#mytableSupplier').on('click', '.qr_supplier', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("supplier/getSupplierById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_supplier": id
                },
                success: function(data) {
                    $('#linkPrint').attr('href', base_url + '/main/print_QrCode/' + id);

                    $("#labelSupplier").html("QrCode Supplier " + data.nm_supplier);

                    $('#image-preview').attr('src', base_url + '/assets/images/qrcode/supplier/' + id + ".png");
                    $('#image-preview').hide();
                    $('#image-preview').fadeIn(650);
                }
            });
            $('#Modal_Print').modal('show');

        });

        $('#mytableSupplier').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            getSupplierById(id, "Delete")
        });

        // ---------------------------------------- End Kelola Supplier Aktif ----------------------------------------

        // ---------------------------------------- Kelola Supplier ----------------------------------------

        $("#addSupplier").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addSupplier').serialize();

            $.ajax({
                url: "<?php echo base_url("Supplier/add_supplier") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytableSupplier').DataTable().ajax.reload();
                        $('#addSupplier')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        function getSupplierById(id, action) {
            $.ajax({
                url: "<?php echo base_url("supplier/getSupplierById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_supplier": id
                },
                success: function(data) {
                    if (action == "Edit") {
                        $("#kd_supplier_edit").val(data.kd_supplier);
                        $("#nm_supplier_edit").val(data.nm_supplier);
                        $("#contact_person_edit").val(data.contact_person);
                        $("#no_telp_edit").val(data.no_telp);
                        $("#email_edit").val(data.email);
                        $("#ktp_edit").val(data.ktp);
                        $("#npwp_edit").val(data.npwp);
                        $("#atas_nama_edit").val(data.atas_nama);
                        $("#bank_edit").val(data.bank);
                        $("#no_rekening_edit").val(data.no_rekening);

                        $('#alamat_edit').summernote("code", decrypt(data.alamat));
                    }
                }
            });
            $('#Modal_' + action).modal({
                backdrop: 'static',
                keyboard: false
            })
        }


        $("#editSupplier").submit(function(e) {

            e.preventDefault();
            let dataString = $('#editSupplier').serialize();

            $.ajax({
                url: "<?php echo base_url("supplier/edit_supplier") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#mytableSupplier').DataTable().ajax.reload();
                        $('#editSupplier')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $("#hapusSupplier").submit(function(e) {
            e.preventDefault();
            let id = $('#product_code_delete').val();

            $.ajax({
                url: "<?php echo base_url("supplier/delete_supplier") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_supplier": id,
                },
                success: function(data) {

                    if (data.response == "success") {
                        $('#mytableSupplier').DataTable().ajax.reload();
                        $('#Modal_Delete').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });


        // ---------------------------------------- End Kelola Supplier ----------------------------------------

        // ----------------------------------------- Kelola Satuan Aktif -----------------------------------------

        $('#mytableSatuanBerat').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Satuan_berat/get_satuan_berat/1') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_satuan",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_satuan",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytableSatuanBerat').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            getSatuanBeratById(id, "Edit");
        });

        $('#mytableSatuanBerat').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            getSatuanBeratById(id, "Delete");

        });

        // ---------------------------------------- End Kelola Satuan Aktif ----------------------------------------

        // ----------------------------------------- Kelola Satuan Tidak Aktif -----------------------------------------

        $('#mytableSatuanBeratTdkAktif').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Satuan_berat/get_satuan_berat/0') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_satuan",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_satuan",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytableSatuanBeratTdkAktif').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            getSatuanBeratById(id, "Edit");

        });

        $('#mytableSatuanBeratTdkAktif').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            getSatuanBeratById(id, "Delete");

        });

        // ---------------------------------------- End Kelola Satuan Tidak Aktif ----------------------------------------

        // ---------------------------------------- Kelola Satuan  ----------------------------------------

        $("#addSatuan").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addSatuan').serialize();

            $.ajax({
                url: "<?php echo base_url("Satuan_berat/add_satuan_berat") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytableSatuanBerat').DataTable().ajax.reload();
                        $('#mytableSatuanBeratTdkAktif').DataTable().ajax.reload();
                        $('#addSatuan')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        function getSatuanBeratById(id, action) {
            $.ajax({
                url: "<?php echo base_url("satuan_berat/getSatuanBeratById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_satuan_berat": id
                },
                success: function(data) {
                    if (action == "Edit") {
                        $("#nm_satuan_berat_edit").val(data.nm_satuan);
                        $("#satuan_edit").val(data.is_satuan_aktif);
                    }
                }
            });
            $('#Modal_' + action).modal({
                backdrop: 'static',
                keyboard: false
            })
        }

        $("#editSatuanBerat").submit(function(e) {

            e.preventDefault();
            let dataString = $('#editSatuanBerat').serialize();

            $.ajax({
                url: "<?php echo base_url("Satuan_berat/edit_satuan_berat") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#mytableSatuanBerat').DataTable().ajax.reload();
                        $('#mytableSatuanBeratTdkAktif').DataTable().ajax.reload();
                        $('#editSatuanBerat')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $("#hapusSatuanBerat").submit(function(e) {
            e.preventDefault();
            let id = $('#satuan_berat_code_delete').val();

            $.ajax({
                url: "<?php echo base_url("Satuan_berat/delete_satuan_berat") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_satuan_berat": id,
                },
                success: function(data) {

                    if (data.response == "success") {
                        $('#mytableSatuanBerat').DataTable().ajax.reload();
                        $('#mytableSatuanBeratTdkAktif').DataTable().ajax.reload();
                        $('#Modal_Delete').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        // ---------------------------------------- End Kelola Satuan  ----------------------------------------

        // ---------------------------------------- Kelola Product ----------------------------------------

        $(document).ready(function() {
            var jmlbarangplus = $("#jmlbarangplus").val();

            if (jmlbarangplus != undefined) {
                for (let i = 1; i <= jmlbarangplus; i++) {
                    $("#detailkalkulasiharga" + i).click(function() {

                        var harga_modal = $("#harga_modal" + i).val();
                        $("#hrg_modal" + i).val(harga_modal);
                        $("#ttl_hrg_modal" + i).val(harga_modal);

                        if (harga_modal > 0) {
                            $("#setperhitunganharga").modal('show');
                        } else {
                            Toast.fire({
                                icon: "error",
                                title: "Harga Modal Harus Ditentukan Terlebih Dahulu",
                            });
                        }
                    })

                    $("#harga_modal" + i).keyup(function() {
                        $.ajax({
                            url: "<?php echo base_url("konfigurasi/getKonfigurasi") ?>",
                            type: 'post',
                            dataType: 'json',
                            success: function(data) {
                                var hargaModal = parseInt($("#harga_modal" + i).val());
                                var biayaLainnya = parseInt($("#biaya_lainnya" + i).val());
                                var hargaCompetitor = parseInt($("#harga_competitor" + i).val());

                                if (isNaN(hargaCompetitor)) hargaCompetitor = 0;

                                if (isNaN(hargaModal)) hargaModal = 0;
                                if (isNaN(biayaLainnya)) biayaLainnya = 0;

                                $("#hrg_modal" + i).val(hargaModal);

                                $("#ttl_hrg_modal" + i).val(hargaModal + biayaLainnya)

                                var margin = parseInt($("#margin" + i).val());
                                var ttlHargaModal = parseInt($("#ttl_hrg_modal" + i).val());

                                if (isNaN(margin)) margin = 0;
                                if (isNaN(ttlHargaModal)) ttlHargaModal = 0;

                                $("#hasil_margin" + i).val(ttlHargaModal * margin / 100);

                                var hasilMargin = parseInt($("#hasil_margin" + i).val());
                                if (isNaN(hasilMargin)) hasilMargin = 0;

                                var hrgJual = ttlHargaModal + hasilMargin;

                                var bagi = Math.round(hrgJual / 1000);
                                var hargaJual = bagi * 1000;
                                var margin30 = hasilMargin * data.ujroh_reseller / 100;

                                $("#harga_jual" + i).val(margin != 0 ? hrgJual : 0);
                                $("#pembulatan_harga_jual" + i).val(margin != 0 ? hargaJual : 0);
                                $("#harga_produk" + i).val(margin != 0 ? hargaJual : 0);

                                $("#margin100" + i).val(hasilMargin);
                                $("#margin70" + i).val(hasilMargin * data.ujroh_selera / 100);
                                $("#margin30" + i).val(margin30);

                                var pembulatanHarga = parseInt($("#pembulatan_harga_jual" + i).val());
                                if (isNaN(pembulatanHarga)) pembulatanHarga = 0;

                                var insentif = pembulatanHarga * 6 / 100;
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

                                $("#selisih_harga" + i).val(hargaCompetitor - hargaJual);
                                $("#eharga_produk" + i).val($("#pembulatan_harga_jual" + i).val());
                                $("#kelebihan_bagi_hasil" + i).val(margin30 - selisih);
                                $("#hrg_competitor" + i).val(hargaCompetitor);
                                $("#hrg_jual_umum" + i).val(parseInt($("#pembulatan_harga_jual" + i).val()));
                                $("#hrg_jual_reseller" + i).val(hargaJualReseller);
                            }
                        });
                    })

                    $("#eharga_modal" + i).keyup(function() {
                        $.ajax({
                            url: "<?php echo base_url("konfigurasi/getKonfigurasi") ?>",
                            type: 'post',
                            dataType: 'json',
                            success: function(data) {
                                var hargaModal = parseInt($("#eharga_modal" + i).val());
                                var biayaLainnya = parseInt($("#biaya_lainnya" + i).val());
                                var hargaCompetitor = parseInt($("#harga_competitor" + i).val());

                                if (isNaN(hargaCompetitor)) hargaCompetitor = 0;

                                if (isNaN(hargaModal)) hargaModal = 0;
                                if (isNaN(biayaLainnya)) biayaLainnya = 0;

                                $("#hrg_modal" + i).val(hargaModal);

                                $("#ttl_hrg_modal" + i).val(hargaModal + biayaLainnya)

                                var margin = parseInt($("#margin" + i).val());
                                var ttlHargaModal = parseInt($("#ttl_hrg_modal" + i).val());

                                if (isNaN(margin)) margin = 0;
                                if (isNaN(ttlHargaModal)) ttlHargaModal = 0;

                                $("#hasil_margin" + i).val(ttlHargaModal * margin / 100);

                                var hasilMargin = parseInt($("#hasil_margin" + i).val());
                                if (isNaN(hasilMargin)) hasilMargin = 0;

                                var hrgJual = ttlHargaModal + hasilMargin;

                                var bagi = Math.round(hrgJual / 1000);
                                var hargaJual = bagi * 1000;
                                var margin30 = hasilMargin * data.ujroh_reseller / 100;

                                $("#harga_jual" + i).val(margin != 0 ? hrgJual : 0);
                                $("#pembulatan_harga_jual" + i).val(margin != 0 ? hargaJual : 0);
                                $("#harga_produk" + i).val(margin != 0 ? hargaJual : 0);

                                $("#margin100" + i).val(hasilMargin);
                                $("#margin70" + i).val(hasilMargin * data.ujroh_selera / 100);
                                $("#margin30" + i).val(margin30);

                                var pembulatanHarga = parseInt($("#pembulatan_harga_jual" + i).val());
                                if (isNaN(pembulatanHarga)) pembulatanHarga = 0;

                                var insentif = pembulatanHarga * 6 / 100;
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

                                $("#selisih_harga" + i).val(hargaCompetitor - hargaJual);
                                $("#eharga_produk" + i).val($("#pembulatan_harga_jual" + i).val());
                                $("#kelebihan_bagi_hasil" + i).val(margin30 - selisih);
                                $("#hrg_competitor" + i).val(hargaCompetitor);
                                $("#hrg_jual_umum" + i).val(parseInt($("#pembulatan_harga_jual" + i).val()));
                                $("#hrg_jual_reseller" + i).val(hargaJualReseller);
                            }
                        });
                    })

                    $("#biaya_lainnya" + i).keyup(function() {
                        $.ajax({
                            url: "<?php echo base_url("konfigurasi/getKonfigurasi") ?>",
                            type: 'post',
                            dataType: 'json',
                            success: function(data) {
                                var hargaModal = parseInt($("#hrg_modal" + i).val());
                                var biayaLainnya = parseInt($("#biaya_lainnya" + i).val());
                                var hargaCompetitor = parseInt($("#harga_competitor" + i).val());

                                if (isNaN(hargaCompetitor)) hargaCompetitor = 0;

                                if (isNaN(hargaModal)) hargaModal = 0;
                                if (isNaN(biayaLainnya)) biayaLainnya = 0;

                                $("#ttl_hrg_modal" + i).val(hargaModal + biayaLainnya)

                                var margin = parseInt($("#margin" + i).val());
                                var ttlHargaModal = parseInt($("#ttl_hrg_modal" + i).val());

                                if (isNaN(margin)) margin = 0;
                                if (isNaN(ttlHargaModal)) ttlHargaModal = 0;

                                $("#hasil_margin" + i).val(ttlHargaModal * margin / 100);

                                var hasilMargin = parseInt($("#hasil_margin" + i).val());
                                if (isNaN(hasilMargin)) hasilMargin = 0;

                                var hrgJual = ttlHargaModal + hasilMargin;

                                var bagi = Math.round(hrgJual / 1000);
                                var hargaJual = bagi * 1000;
                                var margin30 = hasilMargin * data.ujroh_reseller / 100;

                                $("#harga_jual" + i).val(margin != 0 ? hrgJual : 0);
                                $("#pembulatan_harga_jual" + i).val(margin != 0 ? hargaJual : 0);
                                $("#harga_produk" + i).val(margin != 0 ? hargaJual : 0);
                                $("#selisih_harga" + i).val(hargaCompetitor - (hargaModal + hasilMargin));

                                $("#margin100" + i).val(hasilMargin);
                                $("#margin70" + i).val(hasilMargin * data.ujroh_selera / 100);
                                $("#margin30" + i).val(margin30);

                                var pembulatanHarga = parseInt($("#pembulatan_harga_jual" + i).val());
                                if (isNaN(pembulatanHarga)) pembulatanHarga = 0;

                                var insentif = pembulatanHarga * 6 / 100;
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
                                $("#hrg_jual_umum" + i).val(parseInt($("#pembulatan_harga_jual" + i).val()));
                                $("#hrg_jual_reseller" + i).val(hargaJualReseller);
                            }
                        });
                    })

                    $("#margin" + i).keyup(function() {
                        $.ajax({
                            url: "<?php echo base_url("konfigurasi/getKonfigurasi") ?>",
                            type: 'post',
                            dataType: 'json',
                            success: function(data) {
                                var ttlHargaModal = parseInt($("#ttl_hrg_modal" + i).val());
                                var margin = $("#margin" + i).val();
                                var hargaCompetitor = parseInt($("#harga_competitor" + i).val());
                                var hargaModal = parseInt($("#hrg_modal" + i).val());
                                var biayaLainnya = parseInt($("#biaya_lainnya" + i).val());

                                if (isNaN(biayaLainnya)) biayaLainnya = 0;
                                if (isNaN(hargaModal)) hargaModal = 0;
                                if (isNaN(hargaCompetitor)) hargaCompetitor = 0;
                                if (isNaN(ttlHargaModal)) ttlHargaModal = 0;
                                if (isNaN(margin)) margin = 0;

                                var hasilMargin = ttlHargaModal * margin / 100;
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
                                var margin30 = hasilMargin * data.ujroh_reseller / 100;

                                $("#harga_jual" + i).val(margin != 0 ? hrgJual : 0);
                                $("#pembulatan_harga_jual" + i).val(margin != 0 ? hargaJual : 0);
                                $("#harga_produk" + i).val(margin != 0 ? hargaJual : 0);
                                $("#selisih_harga" + i).val(hargaCompetitor - (hargaModal + hasilMargin));

                                $("#margin100" + i).val(hasilMargin);
                                $("#margin70" + i).val(hasilMargin * data.ujroh_selera / 100);
                                $("#margin30" + i).val(margin30);

                                var pembulatanHarga = parseInt($("#pembulatan_harga_jual" + i).val());
                                if (isNaN(pembulatanHarga)) pembulatanHarga = 0;

                                var insentif = pembulatanHarga * 6 / 100;
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
                                $("#hrg_jual_umum" + i).val(parseInt($("#pembulatan_harga_jual" + i).val()));
                                $("#hrg_jual_reseller" + i).val(hargaJualReseller);
                            }
                        });
                    })

                    $("#harga_competitor" + i).keyup(function() {
                        $.ajax({
                            url: "<?php echo base_url("konfigurasi/getKonfigurasi") ?>",
                            type: 'post',
                            dataType: 'json',
                            success: function(data) {
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
                                $("#margin70" + i).val(margin100 * data.ujroh_selera / 100);
                                $("#margin30" + i).val(margin100 * data.ujroh_reseller / 100);

                                var insentif = pembulatanHarga * 6 / 100;
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
                            }
                        });
                    })

                }
            }
        })

        $("#addProduct").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addProduct').serialize();

            var multiFiles = $("#multiFiles").val();

            if (multiFiles != "") {
                $("#valuegallery").val("1");
            }

            var form_data = new FormData(this);
            var ins = document.getElementById('multiFiles').files.length;
            for (var x = 0; x < ins; x++) {
                form_data.append("gallery[]", document.getElementById('multiFiles').files[x]);
            }

            $.ajax({
                url: "<?php echo base_url("Product/add_product") ?>",
                type: 'post',
                data: form_data,
                // data: dataString,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,

                success: function(data) {
                    window.location.href = "<?php echo base_url() ?>product/daftar_produk";
                }
            });
        })

        $(".buttonupdatestokproduk").click(function() {
            var looping = parseInt($("#jmlbarang1").val()) + 1;
            var record = $("#jumrecord").val();
            var maxGroupbarang = $("#jmlbarang").val();

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
                        '"><div class="row"><div class="col-sm-12 col-md-7"><div class="form-group"><select name="update_stok[]" id="update_stok' +
                        i +
                        '" class="select2produk' +
                        i +
                        ' form-control"></select></div></div><div class="col-sm-11 col-md-4"><div class="form-group"><input type="text" name="qty_stok[]" id="qty_stok' +
                        i +
                        '" class="form-control" placeholder="Masukan Update Stok"></div></div><div class="col-sm-1 col-md-1"><a href="javascript:void(0);" class="btn btn-danger " id="buttonhapuspo' +
                        i +
                        '"> <i class="fa fa-minus"></i></a></div></div></div>';
                    $(".bagiantambahstokproduk").append(copy);

                    $("body").on("click", "#buttonhapuspo" + i, function() {
                        $("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

                        $(this)
                            .parents("#bagianhapuspo" + i)
                            .remove();
                    });

                    $(".select2produk" + i).select2({
                        placeholder: "Pilih Produk",
                        ajax: {
                            url: base_url + "/select2/get_json_detail_produk",
                            type: "post",
                            dataType: "json",
                            delay: 100,
                            data: function(params) {
                                return {
                                    searchTerm: params.term, // search term
                                };
                            },
                            processResults: function(response) {
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

        $(".buttonupdatekatproduk").click(function() {
            var looping = parseInt($("#jmlbarang1").val()) + 1;
            var record = $("#jumrecord").val();
            var maxGroupbarang = $("#jmlbarang").val();

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
                        '<div id="bagianhapuskat' +
                        i +
                        '"><div class="row"><div class="col-sm-12 col-md-11"><div class="form-group"><select name="produk[]" id="produk' +
                        i +
                        '" class="select2produk' +
                        i +
                        ' form-control"></select></div></div><div class="col-sm-1 col-md-1"><a href="javascript:void(0);" class="btn btn-danger" id="buttonhapuskat' +
                        i +
                        '"> <i class="fa fa-minus"></i></a></div></div></div>';
                    $(".bagiantambahkatproduk").append(copy);

                    $("body").on("click", "#buttonhapuskat" + i, function() {
                        $("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

                        $(this)
                            .parents("#bagianhapuskat" + i)
                            .remove();
                    });

                    $(".select2produk" + i).select2({
                        placeholder: "Pilih Produk",
                        ajax: {
                            url: base_url + "/select2/get_json_detail_produk",
                            type: "post",
                            dataType: "json",
                            delay: 100,
                            data: function(params) {
                                return {
                                    searchTerm: params.term, // search term
                                };
                            },
                            processResults: function(response) {
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
        $("#updateStokProduk").submit(function(e) {
            e.preventDefault();
            let dataString = $("#updateStokProduk").serialize();

            $.ajax({
                url: base_url + "/product/update_stok_produk",
                type: "post",
                dataType: "json",
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $("#Modal_Stok").modal("hide");
                        $(".bagiantambahstokproduk").remove();
                        $("#update_stok").val("").trigger('change');
                        $("#qty_stok").val("");

                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                },
            });
        });

        $("#updateKatProduk").submit(function(e) {
            e.preventDefault();
            let dataString = $("#updateKatProduk").serialize();

            $.ajax({
                url: base_url + "/product/update_kat_produk",
                type: "post",
                dataType: "json",
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $("#Modal_Kategori").modal("hide");
                        $(".bagiantambahkatproduk").html("");

                        $("#kategori").val("").trigger('change');
                        $("#sub_kategori").val("").trigger('change');
                        $("#produk").val("").trigger('change');
                        $("#update_stok").val("").trigger('change');

                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                },
            });
        });

        $('#mytableProduk').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {

                url: "<?php echo base_url('Product/get_product/1') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_produk",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_kategori",
                    class: "text_center"
                },
                {
                    data: "nm_produk",
                    class: "text_center"
                },
                {
                    data: "harga",
                    class: "text_center",
                    render: function(data, type, row, meta) {
                        return convertToRupiah(data);
                    }
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $(".close-prod").click(function() {
            $("#pil_prod").val("all");
            $("#exampleModalProd").modal("hide");
        })

        $('#mytableProduk').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("product/getProductById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_produk": id
                },
                success: function(data) {
                    $("#product_code_delete").val(data.kd_produk)
                }
            });
            $('#hapusModal3').modal('show');
        });

        $("#hapusProduk").submit(function(e) {
            e.preventDefault();
            let id = $('#product_code_delete').val();

            $.ajax({
                url: "<?php echo base_url("product/delete_product") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_produk": id,
                },
                success: function(data) {

                    if (data.response == "success") {
                        $('#mytableProduk').DataTable().ajax.reload();
                        $('#hapusModal3').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        $("#set-gallery").click(function() {
            var kd_produk = $("#kd_produk").val();

            $.ajax({
                url: "<?php echo base_url("Product/getGalleryById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_produk": kd_produk
                },
                success: function(data) {

                    // script untuk remove review foto yang lama
                    var gallery = $("#row_awal_gallery");
                    gallery.remove();
                    $("#selected-image_awal").append('<div class="row" id="row_awal_gallery"></div>');
                    // end

                    if (data.length > 1) {
                        for (let i = 1; i < data.length; i++) {
                            // $('#imgViewGallery').append('<img src="'+base_url+'/assets/images/gallery_produk/'+data[i].foto+'" alt="" id="imgGallery'+i+'" srcset="">');
                            $('#selected-image_awal #row_awal_gallery').append('<div class="col-sm-4 col-md-4">' +
                                '<div class="img gallery-img">' +
                                '<div class="gallery-product">' +
                                '<a id="hapusGalleryDetaill' + i + '">' +
                                '<span class="remove-img"><i class="fas fa-times"></i>' +
                                '<input type="hidden" name="kd_gallery" id="kd_galleryy' + i + '">' +
                                '</span>' +
                                '</a>' +
                                '<img src="' + base_url + '/assets/images/gallery_produk/' + data[i].foto + '" width="250px" height="250px" alt="" id="imgGallery' + i + '" srcset="">' +
                                '</div>' +
                                '</div>' +
                                '</div>');

                            $("#kd_galleryy" + i).val(data[i].kd_gallery);


                            $("#hapusGalleryDetaill" + i).click(function() {
                                var kdGallery = $("#kd_galleryy" + i).val();

                                $("#product_code_delete").val(kdGallery);
                                $('#hapusModal').modal('show');
                            });
                        }
                    } else {
                        $("#selected-image_awal #row_awal_gallery").append(`<div style="margin: auto;"><span style="font-size: 25px;">this product doesn't have a photo gallery</span></div>`)
                    }
                }
            });
            $('#setgallery').modal('show');
        });

        $('#mytableProduk').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            window.location.href = "<?php echo base_url() ?>product/edit_product/" + id;

        });

        $(document).ready(function() {
            var jmlbarangplus = $("#jmlbarangplus").val();

            if (jmlbarangplus != undefined) {
                for (let i = 1; i <= jmlbarangplus; i++) {
                    $("#edetailkalkulasiharga" + i).click(function() {

                        var hargaModal = $("#eharga_modal" + i).val();
                        if (hargaModal > 0) {
                            $("#setperhitunganhargaedit" + i).modal("show");
                        } else {
                            Toast.fire({
                                icon: "error",
                                title: "Harga Modal Harus Ditentukan Terlebih Dahulu",
                            });
                        }

                    })
                }
            }
        })

        $("#editProduct").submit(function(e) {
            e.preventDefault();
            let dataString = $('#editProduct').serialize();

            var multiFiles = $("#multiFiles_edit").val();

            if (multiFiles != "") {
                $("#valuegallery").val("1");
            }

            var form_data = new FormData(this);
            var ins = document.getElementById('multiFiles_edit').files.length;
            for (var x = 0; x < ins; x++) {
                form_data.append("gallery[]", document.getElementById('multiFiles_edit').files[x]);
            }

            $.ajax({
                url: "<?php echo base_url("Product/update_product") ?>",
                type: 'post',
                data: form_data,
                // data: dataString,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,

                success: function(data) {
                    if (data.response == "success") {
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                    setTimeout(function() {
                        window.location.href = "<?php echo base_url() ?>product/daftar_produk";
                    }, 300);
                },
            });
        })

        $("#hapusGallery").submit(function(e) {
            e.preventDefault();
            let dataString = $('#hapusGallery').serialize();

            $.ajax({
                url: "<?php echo base_url("product/hapus_galery_foto") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#hapusModal').modal('hide');
                        $('#hapusModal3').modal('hide');
                        $('#setgallery').modal('hide');
                        $('#hapusGallery')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        // ---------------------------------------- End Kelola Product ----------------------------------------

        // ---------------------------------------- End Kelola Product Tidak Aktif ----------------------------------------

        $('#mytableProdukTdkAktif').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Product/get_product/0') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_produk",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_kategori",
                    class: "text_center"
                },
                {
                    data: "nm_sub_kategori",
                    class: "text_center"
                },
                {
                    data: "nm_produk",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytableProdukTdkAktif').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            window.location.href = "<?php echo base_url() ?>product/edit_product/" + id;

        });

        $('#mytableProdukTdkAktif').on('click', '.view_detail', function() {
            var id = $(this).data('id');
            var html = "";
            var html1 = "";
            var angka = 1;
            var angka1 = 1;

            $.ajax({
                url: "<?php echo base_url("Product/getDetailDataProduk") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_produk": id
                },
                success: function(data) {
                    var dtProduk = "";
                    var dtDetailProduk = "";

                    if (data.length > 0) {

                        html += '<tr>' +
                            '<td>' + angka++ + '</td>' +
                            '<td>' + data[0].nm_produk + '</td>' +
                            '<td>' + data[0].nm_kategori + '</td>' +
                            '<td>' + data[0].nm_sub_kategori + '</td>' +
                            '<td>' + data[0].nm_supplier + '</td>' +
                            '</tr>';

                        for (let i = 0; i < data.length; i++) {

                            html1 += '<tr>' +
                                '<td>' + angka1++ + '</td>' +
                                '<td>' + data[i].berat + " " + data[i].satuan_berat + '</td>' +
                                '<td>' + convertToRupiah(data[i].harga_modal) + '</td>' +
                                '<td>' + convertToRupiah(data[i].harga_produk) + '</td>' +
                                '<td>' + convertToRupiah(data[i].diskon) + '</td>' +
                                '<td>' + data[i].stok + '</td>' +
                                '<td>' + data[i].jns_komisi + '</td>' +
                                '<td>' + convertToRupiah(data[i].nominal_komisi) + '</td>' +
                                '</tr>';
                            $("#demo1").html(html1);
                        }
                    } else {
                        html += '<tr class="odd">' +
                            '<td colspan="5" class="dataTables_empty text-center">No data available in table</td>' +
                            '</tr>';

                        html1 += '<tr class="odd">' +
                            '<td colspan="8" class="dataTables_empty text-center">No data available in table</td>' +
                            '</tr>';
                        $("#demo1").html(html1);

                    }

                    $("#demo").html(html);

                    $('.view_detaill').modal('show');
                }
            });
        });

        $('#mytableProdukTdkAktif').on('click', '.highlight', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("Product/getProductById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_produk": id
                },
                success: function(data) {
                    $("#kd_produk").val(data.kd_produk)
                    $("#switch1").prop("checked", data.is_featured == 1 ? true : false);
                    $("#switch2").prop("checked", data.is_best_seller == 1 ? true : false);
                    $("#switch3").prop("checked", data.is_top_rated == 1 ? true : false);
                    $("#switch4").prop("checked", data.is_big_saved == 1 ? true : false);
                }
            });
            $('.hightlight_product').modal('show');
        });

        $('#mytableProdukTdkAktif').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("product/getProductById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_produk": id
                },
                success: function(data) {
                    $("#product_code_delete").val(data.kd_produk)
                }
            });
            $('#hapusModal3').modal('show');
        });

        // ---------------------------------------- End Kelola Product Tidak Aktif ----------------------------------------

        // ---------------------------------------- Kelola Pesanan ----------------------------------------

        $(document).ready(function() {
            var jmlBarang = $("#jmlbarang1").val();

            if (jmlBarang > 0) {
                for (let i = 1; i <= jmlBarang; i++) {

                    $("#qty" + i).keyup(function() {

                        var kd_produk = $("#produk" + i).val();

                        if (kd_produk.substr(0, 2) == "PR") {
                            $.ajax({
                                url: "<?php echo base_url("select2/cekStokProductPromo") ?>",
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    'kd_promo': kd_produk
                                },
                                success: function(data) {
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
                                }
                            });
                        } else {
                            $.ajax({
                                // url: "<?php echo base_url("product/getDetailProdukPoById") ?>",
                                url: "<?php echo base_url("product/getProdukById") ?>",
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    kd_produk: $("#produk" + i).val(),
                                    tabel: "detail_produk",
                                },
                                success: function(data) {
                                    //         if (data == null) {
                                    $.ajax({
                                        url: "<?php echo base_url("select2/cekStokProduct") ?>",
                                        type: 'post',
                                        dataType: 'json',
                                        data: {
                                            'kd_detail_produk': $("#produk" + i).val()
                                        },

                                        success: function(stok) {
                                            var qty = $("#qty" + i).val();
                                            if (data.jns_produk == "stock") {
                                                if (stok >= parseInt(qty) || $("#qty" + i).val() == "") {
                                                    if (data.status_grosir == "ya") {

                                                        $.ajax({
                                                            url: "<?php echo base_url("product/getDetailProdukGrosirById") ?>",
                                                            type: 'post',
                                                            dataType: 'json',
                                                            data: {
                                                                kd_produk: $("#produk" + i).val(),
                                                                tabel: "detail_produk",
                                                            },
                                                            success: function(grosir) {
                                                                if (grosir) {

                                                                    if ($("#qty" + i).val() > grosir.min_pembelian_produk) {
                                                                        $("#harga_produk1").val(grosir.harga_grosir);
                                                                        $("#jmlkomisi1").val(grosir.ujroh_grosir_reseller);
                                                                        $("#jmlkomisii1").val(grosir.ujroh_grosir_reseller);
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
                                                            }
                                                        })
                                                    } else {
                                                        hitungTotalHargaDariQty();
                                                    }

                                                } else {
                                                    $("#harga_produk1").val(data.harga_produk);
                                                    $("#jmlkomisi1").val(data.nominal_komisi);
                                                    $("#jmlkomisii1").val(data.nominal_komisi);
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
                                                        url: "<?php echo base_url("product/getDetailProdukGrosirById") ?>",
                                                        type: 'post',
                                                        dataType: 'json',
                                                        data: {
                                                            kd_produk: $("#produk" + i).val(),
                                                            tabel: "detail_produk",
                                                        },
                                                        success: function(grosir) {
                                                            if (grosir) {
                                                                if ($("#qty" + i).val() > grosir.min_pembelian_produk) {
                                                                    $("#harga_produk1").val(grosir.harga_grosir);
                                                                    $("#jmlkomisi1").val(grosir.ujroh_grosir_reseller);
                                                                    $("#jmlkomisii1").val(grosir.ujroh_grosir_reseller);
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
                                                        }
                                                    })
                                                } else {
                                                    hitungTotalHargaDariQty();
                                                }
                                            }
                                        }
                                    });
                                }
                            });
                        }
                    })

                    $("#qty" + i).change(function() {
                        $.ajax({
                            url: "<?php echo base_url("product/getDetailProdukGrosirById") ?>",
                            type: 'post',
                            dataType: 'json',
                            data: {
                                kd_produk: $("#produk" + i).val(),
                                tabel: "detail_produk",
                            },
                            success: function(grosir) {
                                if (grosir) {
                                    if ($("#qty" + i).val() > grosir.min_pembelian_produk) {
                                        $(".flash-data1").html("anda Sudah Membeli Diatas " + grosir.min_pembelian_produk + " Selamat Anda Menggunakan Harga Grosir");
                                        $(".error-data1").html("");
                                        toast();
                                    }
                                }
                            }
                        });

                    })

                    function hitungTotalHargaDariQty() {
                        var harga = $("#harga_produk" + i).val();
                        var diskon = $("#diskon" + i).val();
                        var diskonn = $("#diskonn" + i).val();
                        var qty = $("#qty" + i).val();
                        var jmlkomisi = $("#jmlkomisii" + i).val();
                        var maxGroupbarang = $("#jmlbarang").val();

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

                        $("#sub_total" + i).val(parseInt(harga * qty) - $("#diskon" + i).val());

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

                        $.ajax({
                            url: "<?php echo base_url("konfigurasi/getKonfigurasi") ?>",
                            type: 'post',
                            dataType: 'json',
                            success: function(dta) {
                                var jrk = $("#jarak").val();
                                var jarak = jrk.replace(" KM", "");
                                if (jarak <= parseFloat(5) && pilihan_kurir == "CateringKita") {
                                    if (myTotal >= dta.max_harga_pesanan) {
                                        $("#ongkir_utama").val(0);
                                    } else if (myTotal < dta.max_harga_pesanan) {
                                        $("#ongkir_utama").val(dta.harga_ongkir_minimal);
                                    }
                                } else if (myTotal >= dta.max_harga_pesanan_kedua && pilihan_kurir == "CateringKita") {
                                    var subregion = $("#subregion").val();
                                    var jrk = $("#jarak").val();
                                    var nbrhd = $("#nbrhd").val();
                                    var jarak = jrk.replace(" KM", "");
                                    var city = $("#city").val();

                                    $.ajax({
                                        url: "<?php echo base_url("konfigurasi/get_ongkir_khususs") ?>",
                                        type: 'post',
                                        dataType: 'json',
                                        data: {
                                            subregion: subregion,
                                            nbrhd: nbrhd,
                                            city: city,
                                        },
                                        success: function(data) {

                                            if (subregion == data.ongkir.nama_daerah) {
                                                if (data.ong_khusus) {
                                                    ongkir = data.ong_khusus.nominal_ongkir2;
                                                } else {
                                                    ongkir = data.ongkir.ongkir2;
                                                }
                                            } else {
                                                alert("ongkir Diluar Data Yang Disetting");
                                            }

                                            $('#ongkir_utama').val(ongkir);
                                        }
                                    });
                                } else if (myTotal < dta.max_harga_pesanan_kedua && pilihan_kurir == "CateringKita") {
                                    var subregion = $("#subregion").val();
                                    var jrk = $("#jarak").val();
                                    var nbrhd = $("#nbrhd").val();
                                    var jarak = jrk.replace(" KM", "");
                                    var city = $("#city").val();

                                    $.ajax({
                                        url: "<?php echo base_url("konfigurasi/get_ongkir_khususs") ?>",
                                        type: 'post',
                                        dataType: 'json',
                                        data: {
                                            subregion: subregion,
                                            nbrhd: nbrhd,
                                            city: city,
                                        },
                                        success: function(data) {

                                            if (subregion == data.ongkir.nama_daerah) {
                                                if (data.ong_khusus) {
                                                    ongkir = data.ong_khusus.nominal_ongkir1;
                                                } else {
                                                    ongkir = data.ongkir.ongkir1;
                                                }
                                            } else {
                                                alert("ongkir Diluar Data Yang Disetting");
                                            }

                                            $('#ongkir_utama').val(ongkir);
                                        }
                                    });
                                }
                            }
                        })

                        setTimeout(() => {
                            ongkir = parseInt($("#ongkir_utama").val());
                            var pathparts = location.pathname.split("/");
                            var link1 = pathparts[2];
                            var link2 = pathparts[3];

                            if (link1 == "linkreseller" || (link1 == "pesanan" && link2 == "reseller_login")) {
                                ongkir = parseInt($("#ongkir_utama").val());
                            }

                            if (isNaN(ongkir)) ongkir = 0;
                            $("#jmlkomisi" + i).val(parseInt(jmlkomisi) * parseInt(qty));
                            var diskonTambahan = $("#diskon_tambahan").val();
                            if (isNaN(diskonTambahan)) diskonTambahan = 0;
                            var totalDiskon = parseInt(myTotalDiskon) + parseInt(diskonTambahan);
                            $("#total_harga").val(parseInt(myTotal - diskonTambahan) + parseInt(ongkir));
                            if (parseInt($("#total_harga").val()) < 0) {
                                $("#total_harga").val(0);
                            }
                        }, 500);
                    }
                }
            }
        })

        $('#cek_member_reseller').on('click', function() {
            var reseller = $('#reseller1').val();
            var html = "";
            if (reseller == "#") {
                $(".error-data1").html("Mohon pilih Reseller Terlebih Dahulu.");
                toast();
            } else {
                $.ajax({
                    url: "<?php echo base_url("order/get_list_member") ?>",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'reseller': reseller
                    },

                    success: function(data) {
                        $("#modal-member-reseller").modal('show');
                        if (data.length > 0) {
                            for (let i = 0; i < data.length; i++) {
                                html += '<tr>' +
                                    '<td>' + data[i].kd_member + '</td>' +
                                    '<td>' + data[i].nm_member + '</td>' +
                                    '<td>' + data[i].no_telp + '</td>' +
                                    '</tr>';
                            }
                        } else {
                            html += '<tr>' +
                                '<td colspan=3 align=center>Tidak Ada Member.</td>' +
                                '</tr>';
                        }

                        $('#demo').html(html);
                    }
                });
            }
        });

        $("#pilihan_kurir").change(function() {
            if ($("#pilihan_kurir").val() == "selera_express") {
                $("#ongkir_utamaa").show(500);
                $("#ongkir_paxell").hide();
                $('#jenis_pengiriman').val('seleraexpress');

                var total = $("#total_harga").val();
                var ongkir = $("#ongkir_utama").val();
                var ongkir_paxel = $("#ongkir_paxel").val();

                if (isNaN(total)) total = 0;
                if (isNaN(ongkir)) ongkir = 0;
                if (isNaN(ongkir_paxel)) ongkir_paxel = 0;

                var ttl = total - ongkir - ongkir_paxel;
                $("#total_harga").val(ttl);

                // $("#searchmap").val(null);
                $("#ongkir_utama").val(0);
                $("#ongkir_paxel").val(0);

            } else if ($("#pilihan_kurir").val() == "ekpedisi_yang_lain") {
                $("#ongkir_utamaa").hide();
                $("#ongkir_paxell").show(500);
                $('#jenis_pengiriman').val('');

                var total = $("#total_harga").val();
                var ongkir = $("#ongkir_utama").val();
                var ongkir_paxel = $("#ongkir_paxel").val();

                if (isNaN(total)) total = 0;
                if (isNaN(ongkir)) ongkir = 0;
                if (isNaN(ongkir_paxel)) ongkir_paxel = 0;

                var ttl = total - ongkir - ongkir_paxel;
                $("#total_harga").val(ttl);

                // $("#searchmap").val(null);
                $("#ongkir_utama").val(0);
                $("#ongkir_paxel").val(0);

            } else if ($("#pilihan_kurir").val() == "CateringKita") {
                $("#ongkir_utamaa").show(500);
                $("#ongkir_paxell").hide();
                $('#jenis_pengiriman').val('CateringKita');

                var total = $("#total_harga").val();
                var ongkir = $("#ongkir_utama").val();
                var ongkir_paxel = $("#ongkir_paxel").val();

                if (isNaN(total)) total = 0;
                if (isNaN(ongkir)) ongkir = 0;
                if (isNaN(ongkir_paxel)) ongkir_paxel = 0;

                var ttl = total - ongkir - ongkir_paxel;
                $("#total_harga").val(ttl);

                // $("#searchmap").val(null);
                $("#ongkir_utama").val(0);
                $("#ongkir_paxel").val(0);

            } else {
                $('#jenis_pengiriman').val("");
            }

            $.ajax({
                url: "<?php echo base_url("selera_express/getDetailJenisPengirimanById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    jenis: $('#jenis_pengiriman').val()
                },
                success: function(result) {
                    var city = $("#city").val();
                    var total = $('#total_harga').val();
                    var ongkir_lama = $('#ongkir_utama').val();
                    var total_produk = parseInt(total) - parseInt(ongkir_lama);
                    var jarak = $("#jarak").val();
                    var fix_jarak = jarak.replace(" KM", "");

                    if (city != "") {
                        $.ajax({
                            url: "<?php echo base_url("konfigurasi/getKonfigurasi") ?>",
                            type: 'post',
                            dataType: 'json',
                            success: function(dt) {
                                for (let i = 0; i < result.length; i++) {
                                    if (parseInt(total_produk) < dt.max_harga_pesanan && fix_jarak <= parseFloat(result[0].jarak2) && $('#jenis_pengiriman').val() == "CateringKita") {
                                        $('#ongkir_utama').val(result[0].harga_jarak);
                                        var jumlah = parseInt(total) - parseInt(ongkir_lama) + parseInt(result[0].harga_jarak);
                                        $.ajax({
                                            url: "<?php echo base_url("catering/add_session_ongkir") ?>",
                                            type: 'post',
                                            dataType: 'json',
                                            data: {
                                                ongkir: result[0].harga_jarak
                                            },
                                            success: function(data) {}
                                        });
                                        $('#total_harga').val(jumlah);
                                    } else if (parseInt(total_produk) >= dt.max_harga_pesanan && fix_jarak <= parseFloat(result[0].jarak2) && $('#jenis_pengiriman').val() == "CateringKita") {
                                        $('#ongkir_utama').val(0);
                                        var jumlah = parseInt(total) - parseInt(ongkir_lama) + parseInt(0);
                                        $.ajax({
                                            url: "<?php echo base_url("catering/add_session_ongkir") ?>",
                                            type: 'post',
                                            dataType: 'json',
                                            data: {
                                                ongkir: 0
                                            },
                                            success: function(data) {}
                                        });
                                        $('#total_harga').val(jumlah);

                                    } else if (parseInt(total_produk) >= dt.max_harga_pesanan_kedua && $('#jenis_pengiriman').val() == "CateringKita") {
                                        if (fix_jarak > parseFloat(result[i].jarak1) && fix_jarak <= parseFloat(result[i].jarak2)) {

                                            var subregion = $("#subregion").val();
                                            var jrk = $("#jarak").val();
                                            var nbrhd = $("#nbrhd").val();
                                            var jarak = jrk.replace(" KM", "");
                                            var city = $("#city").val();

                                            $.ajax({
                                                url: "<?php echo base_url("konfigurasi/get_ongkir_khususs") ?>",
                                                type: 'post',
                                                dataType: 'json',
                                                data: {
                                                    subregion: subregion,
                                                    nbrhd: nbrhd,
                                                    city: city,
                                                },
                                                success: function(data) {

                                                    if (subregion == data.ongkir.nama_daerah) {
                                                        if (data.ong_khusus) {
                                                            ongkir = data.ong_khusus.nominal_ongkir2;
                                                        } else {
                                                            ongkir = data.ongkir.ongkir2;
                                                        }
                                                    } else {
                                                        alert("ongkir Diluar Data Yang Disetting");
                                                    }

                                                    $('#ongkir_utama').val(ongkir);
                                                    var jumlah = parseInt(total) - parseInt(ongkir_lama) + parseInt(ongkir);
                                                    $.ajax({
                                                        url: "<?php echo base_url("catering/add_session_ongkir") ?>",
                                                        type: 'post',
                                                        dataType: 'json',
                                                        data: {
                                                            ongkir: ongkir
                                                        },
                                                        success: function(data) {}
                                                    });
                                                    $('#total_harga').val(jumlah);
                                                }
                                            });
                                        }
                                    } else {
                                        if (fix_jarak > parseFloat(result[i].jarak1) && fix_jarak <= parseFloat(result[i].jarak2)) {
                                            if ($('#jenis_pengiriman').val() == "CateringKita") {

                                                var subregion = $("#subregion").val();
                                                var jrk = $("#jarak").val();
                                                var nbrhd = $("#nbrhd").val();
                                                var jarak = jrk.replace(" KM", "");
                                                var city = $("#city").val();

                                                $.ajax({
                                                    url: "<?php echo base_url("konfigurasi/get_ongkir_khususs") ?>",
                                                    type: 'post',
                                                    dataType: 'json',
                                                    data: {
                                                        subregion: subregion,
                                                        nbrhd: nbrhd,
                                                        city: city,
                                                    },
                                                    success: function(data) {

                                                        if (subregion == data.ongkir.nama_daerah) {
                                                            if (data.ong_khusus) {
                                                                ongkir = data.ong_khusus.nominal_ongkir1;
                                                            } else {
                                                                ongkir = data.ongkir.ongkir1;
                                                            }
                                                        } else {
                                                            alert("ongkir Diluar Data Yang Disetting");
                                                        }

                                                        $('#ongkir_utama').val(ongkir);
                                                        var jumlah = parseInt(total) - parseInt(ongkir_lama) + parseInt(ongkir);
                                                        $.ajax({
                                                            url: "<?php echo base_url("catering/add_session_ongkir") ?>",
                                                            type: 'post',
                                                            dataType: 'json',
                                                            data: {
                                                                ongkir: ongkir
                                                            },
                                                            success: function(data) {}
                                                        });
                                                        $('#total_harga').val(jumlah);
                                                    }
                                                });
                                            } else {
                                                $('#ongkir_utama').val(result[i].harga_jarak);
                                                var jumlah = parseInt(total) - parseInt(ongkir_lama) + parseInt(result[i].harga_jarak);
                                                $.ajax({
                                                    url: "<?php echo base_url("catering/add_session_ongkir") ?>",
                                                    type: 'post',
                                                    dataType: 'json',
                                                    data: {
                                                        ongkir: result[i].harga_jarak
                                                    },
                                                    success: function(data) {}
                                                });
                                                $('#total_harga').val(jumlah);
                                            }
                                        }
                                    }
                                }
                            }
                        })
                    } else {
                        $(".error-data1").html("Mohon Pilih Alamat Yang Lebih Detail");
                        toast();
                        $("#searchmap").val(null);
                        $("#jarak").val("0 KM");
                        $("#searchmap").focus();
                    }
                    $('.btn-submit-reseller').removeAttr('disabled');
                }
            });
        })

        $("#pilihan_kurir_res").change(function() {
            if ($("#pilihan_kurir_res").val() == "selera_express") {
                $("#ongkirKelurahan").show(500);
                $('#searchmap').prop('required', true);
                $('#jarak').prop('required', true);
                // $('.btn-submit-reseller').attr('disabled', true);
                $('#jenis_pengiriman').val('seleraexpress');
                var total = parseInt($('#total_harga').val());
                if (total > 0) {
                    var ongkir = parseInt($('#ongkir_utama').val());
                    $('#total_harga').val(total - ongkir);
                    $('#ongkir_utama').val(0);
                    // $('.btn-submit-reseller').attr('disabled', true);
                } else {
                    $(".flash-data1").html("");
                    $(".error-data1").html("Mohon Pilih Produk untuk dibeli");
                    toast();
                    // $('#searchmap').val(null);
                }
                // $('#searchmap').val("");
                // $('#jarak').val("");
            } else if ($("#pilihan_kurir_res").val() == "ekpedisi_yang_lain") {
                Swal.fire({
                    title: 'Ekspedisi Lain',
                    text: "Harap Konfirmasi Kepada Admin untuk mendapatkan harga ongkir Ekspedisi Lain.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Baik, Saya Mengerti!'
                }).then((result) => {
                    if (result.value) {
                        Swal.fire(
                            'Terimakasih!',
                            'Harap Konfirmasi admin.',
                            'success'
                        )
                        $("#ongkirKelurahan").hide(500);
                        $('#searchmap').prop('required', false);
                        // $('#searchmap').val("");
                        $('#jarak').prop('required', false);
                        // $('#jarak').val("");
                        var total = parseInt($('#total_harga').val()) - parseInt($('#ongkir_utama').val());
                        $("#ongkir_utama").val(0);
                        $("#total_harga").val(total);
                        $('.btn-submit-reseller').removeAttr('disabled');
                    }
                })

            } else if ($('#pilihan_kurir_res').val() == "CateringKita") {
                $("#ongkirKelurahan").show(500);
                $('#searchmap').prop('required', true);
                $('#jarak').prop('required', true);
                // $('.btn-submit-reseller').attr('disabled', true);
                $('#jenis_pengiriman').val('CateringKita');
                var total = parseInt($('#total_harga').val());
                if (total > 0) {
                    var ongkir = parseInt($('#ongkir_utama').val());
                    $('#total_harga').val(total - ongkir);
                    $('#ongkir_utama').val(0);
                    // $('.btn-submit-reseller').attr('disabled', true);
                } else {
                    $(".flash-data1").html("");
                    $(".error-data1").html("Mohon Pilih Produk untuk dibeli");
                    toast();
                    // $('#searchmap').val(null);
                }
                // $('#searchmap').val("");
                // $('#jarak').val("");
            } else {
                $("#ongkirKelurahan").hide(500);
                $('#searchmap').prop('required', false);
                $('#jarak').prop('required', false);
                $('.btn-submit-reseller').attr('disabled', false);
                $('#jenis_pengiriman').val('seleraexpress');
                var total = parseInt($('#total_harga').val());
                if (total > 0) {
                    var ongkir = parseInt($('#ongkir_utama').val());
                    $('#total_harga').val(total - ongkir);
                    $('#ongkir_utama').val(0);
                    $('.btn-submit-reseller').attr('disabled', false);
                } else {
                    $(".flash-data1").html("");
                    $(".error-data1").html("Mohon Pilih Produk untuk dibeli");
                    toast();
                    // $('#searchmap').val(null);
                }
                // $('#searchmap').val("");
                // $('#jarak').val("");
            }

            $.ajax({
                url: "<?php echo base_url("selera_express/getDetailJenisPengirimanById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    jenis: $('#jenis_pengiriman').val()
                },
                success: function(result) {
                    var city = $("#city").val();
                    var total = $('#total_harga').val();
                    var ongkir_lama = $('#ongkir_utama').val();
                    var total_produk = parseInt(total) - parseInt(ongkir_lama);
                    var jarak = $("#jarak").val();
                    var fix_jarak = jarak.replace(" KM", "");

                    if (city != "") {
                        $.ajax({
                            url: "<?php echo base_url("konfigurasi/getKonfigurasi") ?>",
                            type: 'post',
                            dataType: 'json',
                            success: function(dt) {
                                for (let i = 0; i < result.length; i++) {
                                    if (parseInt(total_produk) < dt.max_harga_pesanan && fix_jarak <= parseFloat(result[0].jarak2) && $('#jenis_pengiriman').val() == "CateringKita") {
                                        $('#ongkir_utama').val(result[0].harga_jarak);
                                        var jumlah = parseInt(total) - parseInt(ongkir_lama) + parseInt(result[0].harga_jarak);
                                        $.ajax({
                                            url: "<?php echo base_url("catering/add_session_ongkir") ?>",
                                            type: 'post',
                                            dataType: 'json',
                                            data: {
                                                ongkir: result[0].harga_jarak
                                            },
                                            success: function(data) {}
                                        });
                                        $('#total_harga').val(jumlah);
                                    } else if (parseInt(total_produk) >= dt.max_harga_pesanan && fix_jarak <= parseFloat(result[0].jarak2) && $('#jenis_pengiriman').val() == "CateringKita") {
                                        $('#ongkir_utama').val(0);
                                        var jumlah = parseInt(total) - parseInt(ongkir_lama) + parseInt(0);
                                        $.ajax({
                                            url: "<?php echo base_url("catering/add_session_ongkir") ?>",
                                            type: 'post',
                                            dataType: 'json',
                                            data: {
                                                ongkir: 0
                                            },
                                            success: function(data) {}
                                        });
                                        $('#total_harga').val(jumlah);

                                    } else if (parseInt(total_produk) >= dt.max_harga_pesanan_kedua && $('#jenis_pengiriman').val() == "CateringKita") {
                                        if (fix_jarak > parseFloat(result[i].jarak1) && fix_jarak <= parseFloat(result[i].jarak2)) {

                                            var subregion = $("#subregion").val();
                                            var jrk = $("#jarak").val();
                                            var nbrhd = $("#nbrhd").val();
                                            var jarak = jrk.replace(" KM", "");
                                            var city = $("#city").val();

                                            $.ajax({
                                                url: "<?php echo base_url("konfigurasi/get_ongkir_khususs") ?>",
                                                type: 'post',
                                                dataType: 'json',
                                                data: {
                                                    subregion: subregion,
                                                    nbrhd: nbrhd,
                                                    city: city,
                                                },
                                                success: function(data) {

                                                    if (subregion == data.ongkir.nama_daerah) {
                                                        if (data.ong_khusus) {
                                                            ongkir = data.ong_khusus.nominal_ongkir2;
                                                        } else {
                                                            ongkir = data.ongkir.ongkir2;
                                                        }
                                                    } else {
                                                        alert("ongkir Diluar Data Yang Disetting");
                                                    }

                                                    $('#ongkir_utama').val(ongkir);
                                                    var jumlah = parseInt(total) - parseInt(ongkir_lama) + parseInt(ongkir);
                                                    $.ajax({
                                                        url: "<?php echo base_url("catering/add_session_ongkir") ?>",
                                                        type: 'post',
                                                        dataType: 'json',
                                                        data: {
                                                            ongkir: ongkir
                                                        },
                                                        success: function(data) {}
                                                    });
                                                    $('#total_harga').val(jumlah);
                                                }
                                            });
                                        }
                                    } else {
                                        if (fix_jarak > parseFloat(result[i].jarak1) && fix_jarak <= parseFloat(result[i].jarak2)) {
                                            if ($('#jenis_pengiriman').val() == "CateringKita") {

                                                var subregion = $("#subregion").val();
                                                var jrk = $("#jarak").val();
                                                var nbrhd = $("#nbrhd").val();
                                                var jarak = jrk.replace(" KM", "");
                                                var city = $("#city").val();

                                                $.ajax({
                                                    url: "<?php echo base_url("konfigurasi/get_ongkir_khususs") ?>",
                                                    type: 'post',
                                                    dataType: 'json',
                                                    data: {
                                                        subregion: subregion,
                                                        nbrhd: nbrhd,
                                                        city: city,
                                                    },
                                                    success: function(data) {

                                                        if (subregion == data.ongkir.nama_daerah) {
                                                            if (data.ong_khusus) {
                                                                ongkir = data.ong_khusus.nominal_ongkir1;
                                                            } else {
                                                                ongkir = data.ongkir.ongkir1;
                                                            }
                                                        } else {
                                                            alert("ongkir Diluar Data Yang Disetting");
                                                        }

                                                        $('#ongkir_utama').val(ongkir);
                                                        var jumlah = parseInt(total) - parseInt(ongkir_lama) + parseInt(ongkir);
                                                        $.ajax({
                                                            url: "<?php echo base_url("catering/add_session_ongkir") ?>",
                                                            type: 'post',
                                                            dataType: 'json',
                                                            data: {
                                                                ongkir: ongkir
                                                            },
                                                            success: function(data) {}
                                                        });
                                                        $('#total_harga').val(jumlah);
                                                    }
                                                });
                                            } else {
                                                $('#ongkir_utama').val(result[i].harga_jarak);
                                                var jumlah = parseInt(total) - parseInt(ongkir_lama) + parseInt(result[i].harga_jarak);
                                                $.ajax({
                                                    url: "<?php echo base_url("catering/add_session_ongkir") ?>",
                                                    type: 'post',
                                                    dataType: 'json',
                                                    data: {
                                                        ongkir: result[i].harga_jarak
                                                    },
                                                    success: function(data) {}
                                                });
                                                $('#total_harga').val(jumlah);
                                            }
                                        }
                                    }
                                }
                            }
                        })
                    } else {
                        if ($("#stat_ongkir").val() == "1") {
                            $(".error-data1").html("Mohon Pilih Alamat Yang Lebih Detail");
                            toast();
                            $("#searchmap").val(null);
                            $("#jarak").val("0 KM");
                            $("#searchmap").focus();
                        }
                    }
                    $('.btn-submit-reseller').removeAttr('disabled');
                }
            });
        })

        $("#kecamatan_utama").click(function() {
            $("#jnskecamatan").val("utama");
            $('#exampleModal').modal('show');
        })

        $("#kecamatan_lain").click(function() {
            $("#jnskecamatan").val("lainnya");
            $('#exampleModal').modal('show');
        })

        $("#kecamatan_baru").click(function() {
            $("#jnskecamatan").val("baru");
            $('#exampleModal').modal('show');
        })

        $("#nm_member").keyup(function() {
            var nmMember = $("#nm_member").val();

            $("#nm_penerima_baru").val(nmMember);
        })

        $("#no_telp").keyup(function() {
            var noTelp = $("#no_telp").val();

            $("#no_telp_baru").val(noTelp);
        })

        $("#email").keyup(function() {
            var email = $("#email").val();

            $("#email_baru").val(email);
        })

        $("#alamat1").on("summernote.keyup", function() {
            var alamat = $("#alamat1").val();
            $("#alamat_baru").summernote("code", alamat);
        });

        $("#alamat").on("summernote.keyup", function() {
            var alamat = $("#alamat").val();
            $("#alamat_baru").summernote("code", alamat);
        });

        $("#payment_type").change(function() {
            var paymentType = $("#payment_type").val();

            if (paymentType == "ambil_langsung") {
                HitungOngkirdanSubTotal(0);

                // $('#bagian_pilihjeniskurir').hide(500);
                $("#ongkir_lain").val(0);
                $("#ongkir_utama").val(0);
                $("#ongkir_baru").val(0);

                // $("#ongkirKelurahan").hide(500);
                // $("#tampilanMap").hide(500);
                // $("#pilihan_kurirr").hide(500);
                // $("#onggkirr").removeClass("col-md-6");
                // $("#onggkirr").addClass("col-md-12");

                // $("#ongkir_lain").attr("readonly", true);
                // $("#ongkir_utama").attr("readonly", true);
                // $("#ongkir_baru").attr("readonly", true);

            } else {
                // $('#bagian_pilihjeniskurir').show(500);
                // $("#ongkirKelurahan").show(500);
                // $("#tampilanMap").show(500);
                // $("#pilihan_kurirr").show(500);
                // $("#onggkirr").addClass("col-md-6");
                // $("#onggkirr").removeClass("col-md-12");

                if (($("#checkboxmember").prop("checked") == true && $("#checkboxalamat").prop("checked") == true) || $("#checkboxalamat").prop("checked") == true) {
                    $("#checkboxalamat1").show(500);
                    $("#alamatbaru").hide(500);
                    $("#alamatutama").hide(500);
                    $("#alamatlain").show(500);

                    $("#checkboxmemberr").removeClass("d-none");
                    $("#checkboxmemberr").addClass("d-inline");

                    // $("#ongkir_lain").attr("readonly", false);
                    // $("#ongkir_utama").attr("readonly", false);
                    // $("#ongkir_baru").attr("readonly", true);
                } else if ($("#checkboxmember").prop("checked") == true) {
                    $("#checkboxalamat1").show(500);
                    $("#alamatbaru").show(500);
                    $("#alamatutama").hide(500);
                    $("#alamatlain").hide(500);

                    $("#checkboxmemberr").addClass("d-none");
                    $("#checkboxmemberr").removeClass("d-inline");

                    // $("#ongkir_lain").attr("readonly", true);
                    // $("#ongkir_utama").attr("readonly", false);
                    // $("#ongkir_baru").attr("readonly", false);
                } else {
                    $("#checkboxalamat1").show(500);
                    $("#alamatbaru").hide(500);
                    $("#alamatutama").show(500);
                    $("#alamatlain").hide(500);

                    $("#checkboxmemberr").addClass("d-none");
                    $("#checkboxmemberr").removeClass("d-inline");

                    // $("#ongkir_lain").attr("readonly", true);
                    // $("#ongkir_utama").attr("readonly", false);
                    // $("#ongkir_baru").attr("readonly", true);
                }
            }
        })

        $("#ongkir_utama").keyup(function() {
            HitungOngkirdanSubTotal($("#ongkir_utama").val())
        });

        $("#ongkir_paxel").keyup(function() {
            HitungOngkirdanSubTotal($("#ongkir_paxel").val())
        });

        $("#diskon_tambahan").keyup(function() {
            var payment_type = $("#payment_type").val();
            var pilihan_kurir = $("#pilihan_kurir").val();

            if (payment_type == "ambil_langsung") {
                HitungOngkirdanSubTotal(0);
            } else {
                if (pilihan_kurir == "selera_express") {
                    HitungOngkirdanSubTotal($("#ongkir_utama").val());
                } else {
                    var ongkir_paxel = $("#ongkir_paxel").val();
                    if (ongkir_paxel == undefined) {
                        HitungOngkirdanSubTotal($("#ongkir_utama").val());
                    } else {
                        HitungOngkirdanSubTotal(ongkir_paxel);
                    }
                }
            }
        });

        function HitungOngkirdanSubTotal(ongkir) {

            if (ongkir == "" || ongkir == undefined) {
                ongkir = 0;
            }

            var ongkir = parseInt(ongkir);
            var jmlbarang = $("#jmlbarang1").val();
            var maxGroupbarang = $("#jmlbarangplus").val();

            for (let i = 1; i <= jmlbarang; i++) {
                var dataSubtotal = [];

                for (let j = 1; j <= maxGroupbarang; j++) {
                    var obj = {};
                    obj = $("#sub_total" + j).val();
                    if (obj == undefined || obj == "") {
                        obj = 0;
                    }
                    dataSubtotal.push(obj);
                }

                var myTotalSubTotal = 0;

                for (var j = 0, len = dataSubtotal.length; j < len; j++) {
                    myTotalSubTotal += parseInt(dataSubtotal[j]);
                }

                var diskonTambahan = $("#diskon_tambahan").val();

                if (isNaN(diskonTambahan)) diskonTambahan = 0;

                var totalHarga = $("#total_harga").val();

                if (totalHarga - diskonTambahan < 0) {
                    $(".error-data1").html("Diskon Tambahan Tidak Boleh Lebih Dari Besar Total Harga !");
                    $(".flash-data1").html("");
                    toast();
                    $("#diskon_tambahan").val(0);
                }

                var diskonTambahan = parseInt($("#diskon_tambahan").val());
                if (isNaN(diskonTambahan)) diskonTambahan = 0;

                var totalHarga = parseInt(myTotalSubTotal - diskonTambahan + ongkir);

                $("#total_harga").val(totalHarga);
            }
        }

        $("#checkOrder").click(function() {
            var maxGroupbarang = $("#jmlbarangplus").val();
            var tampunganProduk = [];
            for (let i = 1; i <= maxGroupbarang; i++) {
                var produk = $("#produk" + i).val();
                if (produk != undefined) {
                    if (tampunganProduk.includes(produk) == false) {
                        tampunganProduk.push(produk);
                    } else {
                        $(".error-data1").html("Maaf, Produk Ada Yang Dipilih 2kali. Harap Hapus Salah Satu");
                        $(".flash-data1").html("");
                        toast();
                        return false;
                    }
                }
            }
        })

        $("#addOrder").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addOrder').serialize();
            var pelanggan = $('#member1').val();
            var no_telp = $('#no_telp').val();
            var checktnpmember = $("#checktnpmember").val();

            if (checktnpmember == "ya") {
                if (pelanggan == "Pilih member" && no_telp == "") {
                    $('#member1').addClass('is-invalid');
                    $(".error-data1").html("Maaf, Pilih pelanggan terlebih dahulu");
                    $(".flash-data1").html("");
                    toast();
                } else {
                    addOrder(dataString);
                }
            } else {
                addOrder(dataString);
            }

        })

        function addOrder(dataString) {
            $.ajax({
                url: "<?php echo base_url("order/add_order") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#addOrder')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();

                    window.location.href = "<?php echo base_url() ?>order/semua_pesanan";
                }
            });
        }

        $("#addOrderPaket").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addOrderPaket').serialize();
            var pelanggan = $('#member1').val();
            var no_telp = $('#no_telp').val();
            var checktnpmember = $("#checktnpmember").val();

            if (checktnpmember == "ya") {
                if (pelanggan == "Pilih member" && no_telp == "") {
                    $('#member1').addClass('is-invalid');
                    $(".error-data1").html("Maaf, Pilih pelanggan terlebih dahulu");
                    $(".flash-data1").html("");
                    toast();
                } else {
                    addOrderPaket(dataString);
                }
            } else {
                addOrderPaket(dataString);
            }

        })

        function addOrderPaket(dataString) {
            $.ajax({
                url: "<?php echo base_url("order/add_order_paket") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#addOrderPaket')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();

                    window.location.href = "<?php echo base_url() ?>order/semua_pesanan";
                }
            });
        }

        $('#checkboxmembernull').click(function() {
            if ($(this).prop("checked") == true) {
                $("#nm_penerima_lain").val("").trigger('change');
                $("#no_telp_lain").val("");
                $("#email_lain").val("");
                $("#kecamatan_lain").val("");
                $("#nm_penerima_lain_null").val("");
                $("#kodepos_lain").val("");

                $(".nm_penerimaa").hide(500);
                $("#nm_penerima_lain_null").show(500);
            } else {
                $(".nm_penerimaa").show(500);
                $("#nm_penerima_lain_null").hide(500);

                $("#email_lain").val("");
                $("#no_telp_lain").val("");
                $("#nm_penerima_lain").val("").trigger('change');
                $("#kecamatan_lain").val("");
                $("#kodepos_lain").val("");
            }
        })

        $('.btn-submit-reseller').click(function() {
            var banyak_pelanggan = $('.banyak_pelanggan').val();
            var pelanggan_baru = $('.pelanggan_baru').val();
            var alamat_lain = $('.alamat_lain').val();
            var jarak = $("#jarak").val();
            var pilihan_kurir = $("#pilihan_kurir_res").val();

            if ((jarak == "" && pilihan_kurir == "CateringKita") || jarak == "" && pilihan_kurir == "selera_express") {
                $(".error-data1").html("Maaf, Cek Ongkir Terlebih Dahulu.");
                $(".flash-data1").html("");
                toast();
                $('#searchmap').addClass('is-invalid');
                $('#searchmap').focus();
                return false;
            }

            if (banyak_pelanggan == 1 && pelanggan_baru == 0 && alamat_lain == 0) {
                var member_banyak = $('#member_banyak1').val();
                var pilihan_kurir_res = $('#pilihan_kurir_res').val();
                var pelanggan = $('#member1').val();
                var produk = $('#produk1').val();
                var qty1 = $('#qty1').val();
                var nm_penerima_utama = $('#nm_penerima_utama').val();
                var no_telp_utama = $('#no_telp_utama').val();
                var kecamatan_utama = $('#kecamatan_utama').val();
                var alamat_utama = $('#alamat_utama').val();

                if (member_banyak == "Pilih member") {
                    $('#member_banyak1').addClass('is-invalid');
                    $('#member_banyak1').focus();
                    $(".error-data1").html("Maaf, Pilih pelanggan terlebih dahulu");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                }

                if (pilihan_kurir_res == "") {
                    $('#pilihan_kurir_res').addClass('is-invalid');
                    $('#pilihan_kurir_res').focus();
                    $(".error-data1").html("Maaf, Pilih Jenis Kurir terlebih dahulu");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                }

                if (pelanggan == "Pilih member") {
                    $('#member1').addClass('is-invalid');
                    $('#member1').focus();
                    $(".error-data1").html("Maaf, Pilih pelanggan terlebih dahulu");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                }

                if (produk == "Pilih produk") {
                    $('#produk1').addClass('is-invalid');
                    $('#produk1').focus();
                    $(".error-data1").html("Maaf, Pilih produk terlebih dahulu.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                }

                if (qty1 == "") {
                    $('#qty1').addClass('is-invalid');
                    $('#qty1').focus();
                    $(".error-data1").html("Maaf, Masukkan qty terlebih dahulu.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#qty1').removeClass('is-invalid');
                }

                if (nm_penerima_utama == "") {
                    $('#nm_penerima_utama').addClass('is-invalid');
                    $('#nm_penerima_utama').focus();
                    $(".error-data1").html("Maaf, masukkan nama penerima.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#nm_penerima_utama').removeClass('is-invalid');
                }

                if (no_telp_utama == "") {
                    $('#no_telp_utama').addClass('is-invalid');
                    $('#no_telp_utama').focus();
                    $(".error-data1").html("Maaf, masukkan nomor telepon.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#no_telp_utama').removeClass('is-invalid');
                }

                if (kecamatan_utama == "") {
                    $("#jnskecamatan").val("utama");
                    $('#exampleModal').modal('show');
                    $('#kecamatan_utama').addClass('is-invalid');
                    $('#kecamatan_utama').focus();
                    $(".error-data1").html("Maaf, masukkan kecamatan.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#kecamatan_utama').removeClass('is-invalid');
                }

                if (alamat_utama == "") {
                    $('#alamat_utama').addClass('is-invalid');
                    $('#alamat_utama').focus();
                    $(".error-data1").html("Maaf, masukkan alamat.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#alamat_utama').removeClass('is-invalid');
                }
            }
            if (pelanggan_baru == 1 && alamat_lain == 1) {
                var no_telp = $('#no_telp').val();
                var nm_member = $('#nm_member').val();
                var alamat1 = $('#alamat1').val();
                var nm_penerima_lain = $('#nm_penerima_lain').val();
                var no_telp_lain = $('#no_telp_lain').val();
                var kecamatan_lain = $('#kecamatan_lain').val();
                var alamat_lain1 = $('#alamat_lain').val();

                if (no_telp == "" || nm_member == "" || alamat1 == "") {
                    $('#informasi_member').show(500);
                    $('#no_telp').focus();
                    $(".error-data1").html("Maaf, harap masukkan data pelanggan baru dengan lengkap.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                }

                if (nm_penerima_lain == "" || no_telp_lain == "" || kecamatan_lain == "" || alamat_lain1 == "") {
                    $('#nm_penerima_lain').focus();
                    $(".error-data1").html("Maaf, harap masukkan data pelanggan dengan lengkap.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                }

                if (kecamatan_lain == "") {
                    $("#jnskecamatan").val("lainnya");
                    $('#exampleModal').modal('show');
                    $('#nm_penerima_lain').focus();
                    $(".error-data1").html("Maaf, harap masukkan data pelanggan dengan lengkap.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                }

            }
            if (pelanggan_baru == 1 && alamat_lain == 0) {
                var no_telp = $('#no_telp').val();
                var nm_member = $('#nm_member').val();
                var alamat1 = $('#alamat1').val();
                var kecamatan_baru = $('#kecamatan_baru').val();
                var produk = $('#produk1').val();
                var qty1 = $('#qty1').val();

                if (no_telp == "") {
                    $('#no_telp').addClass('is-invalid');
                    $('#no_telp').focus();
                    $(".error-data1").html("Maaf, harap masukkan nomor telepon.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#no_telp').removeClass('is-invalid');
                    if (no_telp != "" && nm_member == "") {
                        $.ajax({
                            url: base_url + "/pesanan/cek_member_res",
                            type: 'post',
                            dataType: 'json',
                            data: {
                                no_telp: no_telp
                            },
                            success: function(data) {
                                if (data == null) {
                                    $('#informasi_member').show(500);
                                } else {
                                    if (data.is_member_aktif == 1) {
                                        $(".error-data1").html(null);
                                        $(".flash-data1").html("Data Member Ditemukan !");
                                        $('#nm_member').val(data.nm_member);
                                        $('#nm_penerima_baru').val(data.nm_member);
                                        $('#email').val(data.email);
                                        $('#email_baru').val(data.email);
                                        $('#alamat').summernote("code", decrypt(data.alamat));
                                        $('#alamat1').summernote("code", decrypt(data.alamat));
                                        $('#alamat_baru').summernote("code", decrypt(data.alamat));
                                        $('#jk').val(data.jenis_kelamin).trigger('change');
                                        $('#informasi_member').show(500);
                                    } else {
                                        $(".error-data1").html("Data Member Ditemukan, Tapi Member Tidak Aktif, Harap Konfirmasi Admin!");
                                        $(".flash-data1").html(null);
                                        toast();
                                        $('#no_telp').val("");
                                    }
                                }
                                toast();
                                $(".flash-data1").html(null);
                                $(".error-data1").html(null);
                                return false;
                            }
                        });
                    }
                }

                if (nm_member == "") {
                    $('#nm_member').addClass('is-invalid');
                    $('#informasi_member').show(500);
                    $('#nm_member').focus();
                    $(".error-data1").html("Maaf, harap masukkan nama pelanggan.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#nm_member').removeClass('is-invalid');
                }

                if (alamat1 == "") {
                    $('#alamat1').addClass('is-invalid');
                    $('#informasi_member').show(500);
                    $('#email').focus();
                    $(".error-data1").html("Maaf, harap masukkan alamat.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#alamat1').removeClass('is-invalid');
                }

                if (produk == "Pilih produk") {
                    $('#produk1').addClass('is-invalid');
                    $('#produk1').focus();
                    $(".error-data1").html("Maaf, Pilih produk terlebih dahulu.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                }

                if (qty1 == "") {
                    $('#qty1').addClass('is-invalid');
                    $('#qty1').focus();
                    $(".error-data1").html("Maaf, Masukkan qty terlebih dahulu.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#qty1').removeClass('is-invalid');
                }

                if (kecamatan_baru == "") {
                    $("#jnskecamatan").val("baru");
                    $('#exampleModal').modal('show');
                    $('#kecamatan_baru').addClass('is-invalid');
                    $('#informasi_member').show(500);
                    $('#kecamatan_baru').focus();
                    $(".error-data1").html("Maaf, harap masukkan Kecamatan.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#kecamatan_baru').removeClass('is-invalid');
                }

            }
            if (alamat_lain == 1 && pelanggan_baru == 0) {
                var nm_penerima_lain = $('#nm_penerima_lain').val();
                var no_telp_lain = $('#no_telp_lain').val();
                var kecamatan_lain = $('#kecamatan_lain').val();
                var alamat_lain1 = $('#alamat_lain').val();

                if (nm_penerima_lain == "") {
                    $('#nm_penerima_lain').addClass('is-invalid');
                    $('#nm_penerima_lain').focus();
                    $(".error-data1").html("Maaf, harap masukkan data pelanggan dengan lengkap.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#nm_penerima_lain').removeClass('is-invalid');
                }

                if (no_telp_lain == "") {
                    $('#no_telp_lain').addClass('is-invalid');
                    $('#no_telp_lain').focus();
                    $(".error-data1").html("Maaf, harap masukkan data pelanggan dengan lengkap.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#no_telp_lain').removeClass('is-invalid');
                }

                if (kecamatan_lain == "") {
                    $('#exampleModal').modal('show');
                    $('#kecamatan_lain').addClass('is-invalid');
                    $('#kecamatan_lain').focus();
                    $(".error-data1").html("Maaf, harap masukkan data pelanggan dengan lengkap.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#kecamatan_lain').removeClass('is-invalid');
                }

                if (alamat_lain1 == "") {
                    $('#alamat_lain1').addClass('is-invalid');
                    $('#alamat_lain1').focus();
                    $(".error-data1").html("Maaf, harap masukkan data pelanggan dengan lengkap.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#alamat_lain1').removeClass('is-invalid');
                }
            }

            if (alamat_lain == 0 && pelanggan_baru == 0 && banyak_pelanggan == 0) {
                var pelanggan = $('#member1').val();
                var produk = $('#produk1').val();
                var qty1 = $('#qty1').val();
                var nm_penerima_utama = $('#nm_penerima_utama').val();
                var no_telp_utama = $('#no_telp_utama').val();
                var kecamatan_utama = $('#kecamatan_utama').val();
                var alamat_utama = $('#alamat_utama').val();

                if (pelanggan == "Pilih member") {
                    $('#member1').addClass('is-invalid');
                    $('#member1').focus();
                    $(".error-data1").html("Maaf, Pilih pelanggan terlebih dahulu");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                }

                if (produk == "Pilih produk") {
                    $('#produk1').addClass('is-invalid');
                    $('#produk1').focus();
                    $(".error-data1").html("Maaf, Pilih produk terlebih dahulu.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                }

                if (qty1 == "") {
                    $('#qty1').addClass('is-invalid');
                    $('#qty1').focus();
                    $(".error-data1").html("Maaf, Masukkan qty terlebih dahulu.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#qty1').removeClass('is-invalid');
                }

                if (nm_penerima_utama == "") {
                    $('#nm_penerima_utama').addClass('is-invalid');
                    $('#nm_penerima_utama').focus();
                    $(".error-data1").html("Maaf, masukkan nama penerima.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#nm_penerima_utama').removeClass('is-invalid');
                }

                if (no_telp_utama == "") {
                    $('#no_telp_utama').addClass('is-invalid');
                    $('#no_telp_utama').focus();
                    $(".error-data1").html("Maaf, masukkan nomor telepon.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#no_telp_utama').removeClass('is-invalid');
                }

                if (kecamatan_utama == "") {
                    $('#exampleModal').modal('show');
                    $('#kecamatan_utama').addClass('is-invalid');
                    $('#kecamatan_utama').focus();
                    $(".error-data1").html("Maaf, masukkan kecamatan.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#kecamatan_utama').removeClass('is-invalid');
                }

                if (alamat_utama == "") {
                    $('#alamat_utama').addClass('is-invalid');
                    $('#alamat_utama').focus();
                    $(".error-data1").html("Maaf, masukkan alamat.");
                    $(".flash-data1").html("");
                    toast();
                    return false;
                } else {
                    $('#alamat_utama').removeClass('is-invalid');
                }
            }

            if ($("#pilihan_kurir_res").val() == "" && $('#payment_type').val() != "ambil_langsung") {
                $('#pilihan_kurir_res').addClass('is-invalid');
                $('#pilihan_kurir_res').focus();
                $(".error-data1").html("Maaf, Pilih jenis kurir terlebih dahulu.");
                $(".flash-data1").html("");
                toast();
                return false;
            }
        })

        $("#addOrderReseller").submit(function(e) {
            var pathparts = location.pathname.split("/");
            var link1 = pathparts[2];
            var link2 = pathparts[3];
            e.preventDefault();

            // $('.preloader').show();
            let dataString = $('#addOrderReseller').serialize();

            $.ajax({
                url: "<?php echo base_url("pesanan/add_order") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,
                success: function(data) {
                    if (data.toast.response == "success") {
                        $('.preloader').hide();
                        $("#produk1").val("").trigger('change');
                        $('#bagianProduk').html("");
                        $("#ongkirKelurahan").show(500);
                        $('#addOrderReseller')[0].reset();
                        $(".flash-data1").html(data.toast.message);
                        $(".error-data1").html("");
                        toastaa();
                    } else {
                        $(".flash-data1").html("");
                        $(".error-data1").html(data.toast.message + " Halaman Akan Di Refresh, Silahkan Diisi Kembali !");
                        toastaa();

                        setTimeout(() => {
                            window.location.href = base_url + "/linkreseller/" + data.no_telp;
                        }, 4000);

                        return false;
                    }

                    if (link1 == "pesanan" && link2 == "reseller_login") {
                        setTimeout(function() {
                            window.location.href = base_url + "/pesanan/reseller_login/";
                        }, 1000);
                    } else {

                        Swal.fire({
                            title: 'Selamat!',
                            html: 'Kamu telah sukses melakukan pemesanan.',
                            icon: "success",
                            timer: 5000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                        }).then((result) => {
                            /* Read more about handling dismissals below */
                            if (result.dismiss === Swal.DismissReason.timer) {
                                window.location.href = base_url + "/linkreseller/" + data.no_telp;
                            }
                        })
                    }
                }
            });
        })

        function toastaa() {
            const flashData = $(".flash-data1").html();
            const errorData = $(".error-data1").html();
            // const errorData1 = $(".error-data").html();

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

        $("#editOrder").submit(function(e) {
            e.preventDefault();
            let dataString = $('#editOrder').serialize();

            $.ajax({
                url: "<?php echo base_url("order/edit_order") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#editOrder')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();

                    window.location.href = "<?php echo base_url() ?>order/semua_pesanan";
                }
            });
        })

        $("#editOrderNonMember").submit(function(e) {
            e.preventDefault();
            let dataString = $('#editOrderNonMember').serialize();

            $.ajax({
                url: "<?php echo base_url("order/edit_order_non_member") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#editOrderNonMember')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();

                    window.history.go(-1);
                }
            });
        })

        $('#pengiriman').click(function() {
            var kd_order = $('#kd_order').val();

            $.ajax({
                url: "<?php echo base_url("order/get_pengiriman") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    'kd_order': kd_order
                },

                success: function(data) {
                    $("#modal_edit_pengiriman").modal('show');
                    $("#edit_kurir")
                        .select2()
                        .val(data[0].kd_kurir)
                        .trigger("change");
                    $('#kd_pengiriman').val(data[0].kd_pengiriman);
                }
            });
        });

        $("#addOngkirLain").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addOngkirLain').serialize();
            var ongkir = parseInt($('#ongkir').val());
            var ongkir_lama = parseInt($('#ongkir_lama').val());
            var total = parseInt($('#total_transfer').val()) - ongkir_lama;

            $.ajax({
                url: "<?php echo base_url("order/add_ongkir_lain") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,
                success: function(data) {

                    if (data.response == "success") {
                        $('.txt_total_transfer').html(convertToRupiah(total + ongkir))
                        $('.txt_ongkir').html(convertToRupiah(ongkir))
                        $('#Modal_Add_Ongkir').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                        $("#bagian_ekspedisi_lain").hide(500);
                        $("#buttoneditongkir").show(500);
                        $("#ongkir").val(ongkir);
                        $("#total_transfer").val(total + ongkir);
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        $("#buttoneditkredit").click(function() {
            var kd_order = $('#kd_order').val();
            var text = "";
            $.ajax({
                url: "<?php echo base_url("order/get_pembayaran_kredit") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    'kd_order': kd_order
                },

                success: function(data) {
                    if (data.length > 0) {
                        $('.bagian_cicil').show();
                        var tot = 0;
                        for (let i = 0; i < data.length; i++) {
                            text += '<div class="col-md-5 col-xs-5 col-5"><input type="text" class="form-control" value="' + convertToRupiah(data[i].nominal_kredit) + '" placeholder="Nominal Bayar" required readonly></div><div class="col-md-5 col-xs-5 col-5"><input type="text" class="form-control input-rupiah-mask" value="' + ubah_tanggal(data[i].created_at) + '" placeholder="Sisa Kredit" required readonly></div><div class="col-md-2 col-xs-2 col-2"><a href="javascript:;" data-id="' + data[i].kd_pembayaran_kredit + '" data-kd_order="' + data[i].kd_order + '" class="btn btn-danger hapus_pembayaran_kredit"> <i class="fa fa-minus"></i></a></div><br><br>';
                            tot += parseInt(data[i].nominal_kredit);
                        }
                        var total = parseInt($("#kredit").val());
                        $("#sisa_total_kredit").val(total - tot)
                        $("#sisa_kredit").val(total - tot)
                        $("#bagian_form_cicil").html(text)
                    } else {
                        $('.bagian_cicil').hide();
                    }

                    $.ajax({
                        url: "<?php echo base_url("order/getOrderById") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            'kd_order': kd_order
                        },

                        success: function(data) {
                            $('#status_bayar').removeClass(data.payment_status == "1" ? 'badge-danger' : 'badge-success');
                            $('#status_bayar').addClass(data.payment_status == "1" ? 'badge-success' : 'badge-danger');
                            $('#status_bayar').html('');
                            $('#status_bayar').html(data.payment_status == "1" ? 'Sudah Dibayar' : 'Belum Dibayar');
                        }
                    });
                }
            });
        })

        $("#bagian_form_cicil").on('click', '.hapus_pembayaran_kredit', function() {
            let id = $(this).data('id');
            let kd_order = $(this).data('kd_order');

            Swal.fire({
                title: "Apa Kamu Yakin?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus saja!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url("order/hapus_pembayaran_kredit") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            'kd_pembayaran_kredit': id,
                            'kd_order': kd_order
                        },
                        success: function(data1) {
                            if (data1.response == "success") {
                                $(".flash-data1").html(data1.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data1.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                            $('#bagian_form_cicil').html("");
                            var text = "";
                            $.ajax({
                                url: "<?php echo base_url("order/get_pembayaran_kredit") ?>",
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    'kd_order': kd_order
                                },

                                success: function(data) {
                                    if (data.length > 0) {
                                        $('.bagian_cicil').show();
                                        var tot = 0;
                                        for (let i = 0; i < data.length; i++) {
                                            text += '<div class="col-md-5 col-xs-5 col-5"><input type="text" class="form-control" value="' + convertToRupiah(data[i].nominal_kredit) + '" placeholder="Nominal Bayar" required readonly></div><div class="col-md-5 col-xs-5 col-5"><input type="text" class="form-control input-rupiah-mask" value="' + ubah_tanggal(data[i].created_at) + '" placeholder="Sisa Kredit" required readonly></div><div class="col-md-2 col-xs-2 col-2"><a href="javascript:;" data-id="' + data[i].kd_pembayaran_kredit + '" data-kd_order="' + data[i].kd_order + '" class="btn btn-danger hapus_pembayaran_kredit"> <i class="fa fa-minus"></i></a></div><br><br>';
                                            tot += parseInt(data[i].nominal_kredit);
                                        }
                                        var total = parseInt($("#kredit").val());
                                        $("#sisa_total_kredit").val(total - tot)
                                        $("#sisa_kredit").val(total - tot)
                                        $("#bagian_form_cicil").html(text)
                                    } else {
                                        var total = parseInt($("#kredit").val());
                                        $("#sisa_total_kredit").val(total)
                                        $("#sisa_kredit").val(total)
                                        $('.bagian_cicil').hide();
                                    }

                                    $.ajax({
                                        url: "<?php echo base_url("order/getOrderById") ?>",
                                        type: 'post',
                                        dataType: 'json',
                                        data: {
                                            'kd_order': kd_order
                                        },

                                        success: function(data) {
                                            $('#status_bayar').removeClass(data.payment_status == "1" ? 'badge-danger' : 'badge-success');
                                            $('#status_bayar').addClass(data.payment_status == "1" ? 'badge-success' : 'badge-danger');
                                            $('#status_bayar').html('');
                                            $('#status_bayar').html(data.payment_status == "1" ? 'Sudah Dibayar' : 'Belum Dibayar');
                                        }
                                    });
                                }
                            });

                        }
                    });
                }
            });
        })

        $("#nominal_kredit").keyup(function() {
            var nominal = parseInt($("#nominal_kredit").val());
            var total = parseInt($("#sisa_total_kredit").val());

            if (nominal <= total) {
                var sisa = total - nominal;
                $("#sisa_kredit").val(sisa);
            } else {
                $(".error-data1").html("Nominal bayar tidak boleh lebih dari Total Kredit.");
                $(".flash-data1").html("");
                toast();
                $("#sisa_kredit").val(0);
                $("#nominal_kredit").val(0);
            }
        })

        $("#addKredit").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addKredit').serialize();
            var kd_order = $("#kd_order").val();

            $.ajax({
                url: "<?php echo base_url("order/addKredit") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,
                success: function(data) {
                    if (data.response == "success") {
                        $('#addKredit')[0].reset();
                        $('#Modal_Add_Kredit').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $('#Modal_Add_Kredit').modal('hide');
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();

                    $.ajax({
                        url: "<?php echo base_url("order/getOrderById") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            'kd_order': kd_order
                        },

                        success: function(data) {
                            $('#status_bayar').removeClass(data.payment_status == "1" ? 'badge-danger' : 'badge-success');
                            $('#status_bayar').addClass(data.payment_status == "1" ? 'badge-success' : 'badge-danger');
                            $('#status_bayar').html('');
                            $('#status_bayar').html(data.payment_status == "1" ? 'Sudah Dibayar' : 'Belum Dibayar');
                        }
                    });
                }
            });
        });

        $("#edit_pengiriman").submit(function(e) {
            e.preventDefault();
            var kd_pengiriman = $('#kd_pengiriman').val();
            var kurir = $('#edit_kurir').val();
            let dataString = $('#edit_pengiriman').serialize();
            var kurir_name = $('#kurir_name_edit').val();

            $.ajax({
                url: "<?php echo base_url("order/edit_pengiriman") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,
                success: function(data) {

                    if (data.response == "success") {
                        $('#kurir_name').html(kurir_name);
                        $('#modal_edit_pengiriman').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $('#modal_edit_pengiriman').modal('hide');
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        var jmlDeleteTracking = [0];

        $("#tracking").click(function() {

            var kd_order = $("#kd_order").val();

            $.ajax({
                url: "<?php echo base_url("order/get_order_tracking") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    'kd_order': kd_order
                },

                success: function(data) {
                    var html = "";
                    var angka = 1;

                    if (data.length > 0) {
                        for (let i = 0; i < data.length; i++) {

                            $(".Tracking").append('<input type="hidden" name="kd_tracking" value=' + data[i].kd_track + ' id="kd_tracking' + i + '">');

                            switch (data[i].status) {
                                case "pending":
                                    data[i].status = "Pending";
                                    break;
                                case "onprocess":
                                    data[i].status = "Diproses";
                                    break;
                                case 'ondelivery':
                                    data[i].status = "Dikirim";
                                    break;
                                case 'rejected':
                                    data[i].status = "Ditolak";
                                    break;
                                case 'done':
                                    data[i].status = "Selesai";
                                    break;
                            }

                            html += '<tr>' +
                                '<td>' + angka++ + '</td>' +
                                '<td>' + data[i].status + '</td>' +
                                '<td>' + ubah_tanggal(data[i].created_at, "jam") + '</td>' +
                                '<td>' + data[i].nm_reseller + '</td>' +
                                '<td><button id="btnTracking' + i + '" class="btn btn-danger"><i class="fas fa-trash"></i></button></td>' +
                                '</tr>';
                        }
                    } else {
                        html += '<tr class="odd">' +
                            '<td colspan="4" class="dataTables_empty text-center">No data available in table</td>' +
                            '</tr>';
                    }

                    $("#bodyTracking").html(html);
                    $("#ModalOrderTracking").modal('show');

                    for (let i = 0; i < data.length; i++) {
                        $("#btnTracking" + i).click(function() {
                            $("#tracking_code_delete").val($("#kd_tracking" + (i + jmlDeleteTracking[0])).val());
                            $("#hapusModalTacking").modal('show');
                        })
                    }
                }
            });
        })

        $("#upload_bayar").click(function() {
            var kd_order = $("#kd_order").val();
            $.ajax({
                url: "<?php echo base_url("order/get_upload_pembayaran") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    'kd_order': kd_order
                },

                success: function(data) {

                    $("#kd_orderr").val(kd_order);
                    $("#kd_reseller").val($("#kd_reseller1").val());
                    $("#ModalUploadPembayaran").modal('show');

                    if (data != null) {
                        $('#imgView').attr('src', base_url + '/assets/images/bukti_pembayaran/' + data.bukti_upload);
                    }
                }
            });
        })

        $("#hapusTracking").submit(function(e) {
            e.preventDefault();
            let id = $('#tracking_code_delete').val();

            $.ajax({
                url: "<?php echo base_url("order/delete_tracking") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_tracking": id,
                },
                success: function(data) {

                    if (data.response == "success") {
                        jmlDeleteTracking[0] += 1;
                        $('#hapusModalTacking').modal('hide');
                        $('#ModalOrderTracking').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        // ---------------------------------------- End Kelola Pesanan ----------------------------------------

        // ---------------------------------------- Kelola Pesanan Paket ----------------------------------------

        $("#qtyy1").keyup(function() {
            $.ajax({
                url: "<?php echo base_url("select2/cekStokProductPromo") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    'kd_promo': $("#produk1").val()
                },

                success: function(data) {

                    var qty = $("#qtyy1").val();
                    var sub_total = $("#sub_total1").val();

                    if (data >= parseInt(qty) || $("#qtyy1").val() == "") {
                        hitungTotalHargaDariQtyPaket();

                    } else {
                        $(".error-data1").html("Stok Tinggal Tersisa " + data);
                        $(".flash-data1").html("");
                        $("#qtyy1").val("");
                        toast();
                    }
                }
            });
        })

        function hitungTotalHargaDariQtyPaket() {
            var harga = $("#harga_produk1").val();
            var qty = $("#qtyy1").val();
            var maxGroupbarang = $("#jmlbarang").val();

            if (harga == "" || harga == undefined) {
                harga = 0;
            }

            if (qty == "" || qty == undefined) {
                qty = 0;
            }

            $("#sub_total1").val(parseInt(harga * qty));

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

            if ($("#checkboxmember").prop("checked") == true && $("#checkboxalamat").prop("checked") == true || $("#checkboxalamat").prop("checked") == true) {
                ongkir = parseInt($("#ongkir_lain").val());
            } else if ($("#checkboxmember").prop("checked") == true) {
                ongkir = parseInt($("#ongkir_baru").val());
            } else {
                ongkir = parseInt($("#ongkir_utama").val());
            }

            if (isNaN(ongkir)) ongkir = 0;

            var diskonTambahan = $("#diskon_tambahan").val();

            if (isNaN(diskonTambahan)) diskonTambahan = 0;

            $("#total_harga").val(parseInt(myTotal - diskonTambahan) + parseInt(ongkir));
            if (parseInt($("#total_harga").val()) < 0) {
                $("#total_harga").val(0);
            }
        }

        var jml_record = $("#jml_record").val();

        for (let i = 1; i <= jml_record; i++) {
            $("#qty" + i).keyup(function() {
                // $.ajax({
                //     url: "<?php echo base_url("select2/cekStokProduct") ?>",
                //     type: 'post',
                //     dataType: 'json',
                //     data: {
                //         'kd_detail_produk': $("#produk" + i).val()
                //     },

                //     success: function(data) {

                // var qty = $("#qty1").val();

                // if (data >= parseInt(qty) || $("#qty" + i).val() == "") {        
                hitungTotalHargaDariQtyPakett();

                // } else {
                //     $(".error-data1").html("Stok Tinggal Tersisa " + data);
                //     $(".flash-data1").html("");
                //     $("#qty" + i).val("");
                //     $("#diskon" + i).val($("#diskonn" + i).val());
                //     $("#sub_total" + i).val(0);
                //     $("#jmlkomisi" + i).val($("#jmlkomisii" + i).val());
                //     toast();
                // }
                //     }
                // });
            })

            function hitungTotalHargaDariQtyPakett() {
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

                if ($("#checkboxmember").prop("checked") == true && $("#checkboxalamat").prop("checked") == true || $("#checkboxalamat").prop("checked") == true) {
                    ongkir = parseInt($("#ongkir_lain").val());
                } else if ($("#checkboxmember").prop("checked") == true) {
                    ongkir = parseInt($("#ongkir_baru").val());
                } else {
                    ongkir = parseInt($("#ongkir_utama").val());
                }

                if (isNaN(ongkir)) ongkir = 0;

                var diskonTambahan = $("#diskon_tambahan").val();

                if (isNaN(diskonTambahan)) diskonTambahan = 0;

                $("#total_harga").val(parseInt(myTotal - diskonTambahan) + parseInt(ongkir));
                if (parseInt($("#total_harga").val()) < 0) {
                    $("#total_harga").val(0);
                }
            }
        }

        $("#detailprodukpaket1").click(function() {
            var kodePaket = $("#produk1").val();

            if (kodePaket == "#") {
                $(".error-data1").html("Pilih Produk Terlebih Dahulu !");
                $(".flash-data1").html("");
                toast();
            } else {
                $.ajax({
                    url: "<?php echo base_url("product/getprodukpaket") ?>",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'kode_paket': kodePaket
                    },
                    success: function(data) {
                        $('#detail-produk-paket').modal('show');
                        var html = "";
                        var j = 1;
                        for (let i = 0; i < data.length; i++) {
                            html += '<tr><td>' + j + '</td><td>' + data[i].nm_produk + '</td><td>' + data[i].qty + '</td></tr>';
                            j++;
                        }
                        $("#demo-produk-paket").html(html);
                    }
                })
            }
        })

        var jml_record = $("#jml_record").val();

        for (let i = 2; i <= jml_record; i++) {
            $("#detailprodukpaket" + i).click(function() {
                var kodePaket = $("#produk" + i).val();

                if (kodePaket == "#") {
                    $(".error-data1").html("Pilih Produk Terlebih Dahulu !");
                    $(".flash-data1").html("");
                    toast();
                } else {
                    $.ajax({
                        url: "<?php echo base_url("product/getprodukpaket") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            'kode_paket': kodePaket
                        },
                        success: function(data) {
                            $('#detail-produk-paket' + i).modal('show');
                            var html = "";
                            var j = 1;
                            for (let i = 0; i < data.length; i++) {
                                html += '<tr><td>' + j + '</td><td>' + data[i].nm_produk + '</td><td>' + data[i].qty + '</td></tr>';
                                j++;
                            }
                            $("#demo-produk-paket" + i).html(html);
                        }
                    })
                }
            })

            $("#buttonhapusprodukpakett" + i).click(function() {
                $("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

                var subTotal = $("#sub_total" + i).val();
                var totalHarga = $("#total_harga").val();
                var kd_detail = $("#produk" + i).val();
                var tampunganData = [];

                $("#total_harga").val(
                    parseInt(totalHarga) - parseInt(subTotal)
                );

                tampunganData.push(kd_detail);

                $("#tampunganDataHapus").val(tampunganData);

                $("#bagianProdukhapus" + i).remove();
            })
        }
        $("#editOrderPaket").submit(function(e) {
            e.preventDefault();
            let dataString = $('#editOrderPaket').serialize();

            $.ajax({
                url: "<?php echo base_url("order/edit_order_paket") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#editOrderPaket')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();

                    window.history.go(-1);
                }
            });
        })

        $("#eujrohpaketan1").click(function() {

            var promo_produk = $("#promo_produk").val();
            if (promo_produk == "") {
                Toast.fire({
                    icon: "error",
                    title: "Produk Harus Dipilih Terlebih Dahulu",
                });
            } else {
                $("#Modal_ujroh_paketan").modal("show");
            }
        })

        // ---------------------------------------- End Kelola Pesanan Paket ----------------------------------------

        // ---------------------------------------- Pesanan Non Member ----------------------------------------
        $('#mytablePesananNonMember').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Order/get_pesanan_non_member') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "kd_temporary_order",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "kd_temporary_order",
                    class: "text_center"
                },
                {
                    data: "cust_name",
                    class: "text_center"
                },
                {
                    data: "cust_phone",
                    class: "text_center"
                },
                {
                    data: "total_harga",
                    render: function(data, type, row) {
                        return convertToRupiah(data);
                    },
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytablePesananNonMember').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            window.location.href = "<?php echo base_url() ?>order/edit_pesanan_non_member/" + id;

        });

        $('#mytablePesananNonMember').on('click', '.detail_order', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("order/get_list_detail_order_nonmember") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_temporary_order": id,
                },
                success: function(data) {
                    var keterangan, warna, ket, Detail1 = "",
                        Detail2 = "",
                        Detail3 = "",
                        Detail4 = "",
                        Detail5 = "";

                    if (data != null) {
                        switch (data.order_member.order_status) {
                            case 'pending':
                                keterangan = "Pending";
                                break;
                            case 'onprocess':
                                keterangan = "Diproses";
                                break;
                            case 'ondelivery':
                                keterangan = "Dikirim";
                                break;
                            case 'rejected':
                                keterangan = "Ditolak";
                                break;
                            case 'done':
                                keterangan = "Selesai";
                                break;
                        }

                        if (data.order_member.payment_status == 0) {
                            warna = "badge badge-danger";
                            ket = "Belum";
                        } else {
                            warna = "badge badge-success";
                            ket = "Sudah";
                        }


                        Detail1 += '<tr>' +
                            '<th class="45%" width="45%">Kode Order</th>' +
                            '<td width="10%">:</td>' +
                            '<td class="45%" width="45%">' + data.order_member.kd_temporary_order + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Total Pembayaran</th>' +
                            '<td width="10%">:</td>' +
                            '<td class="45% rupiah-mask" width="45%">' + convertToRupiah(data.order_member.total_transfer) + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Tanggal Order</th>' +
                            '<td width="10%">:</td>' +
                            '<td class="45%" width="45%">' + ubah_tanggal(data.order_member.tgl_order) + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Status Order</th>' +
                            '<td width="10%">:</td>' +
                            '<td class="45%" width="45%" id="status_order_kurir">' + keterangan + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Status Pembayaran</th>' +
                            '<td width="10%">:</td>' +
                            '<td class="45%" width="45%"><span class="' + warna + '" style="padding: 5%;">' + ket + ' Dibayar</span></td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Keterangan Order</th>' +
                            '<th width="10%">:</th>' +
                            '<td width="45%">' + data.order_member.catatan_order + '</td>' +
                            '</tr>';

                        $("#detail_order_kurir_1_semua_pesanan").html(Detail1);
                        $("#detail_order_kurir_1_pesanan_dikirim").html(Detail1);
                        $("#detail_order_kurir_1_pesanan_selesai").html(Detail1);
                        $("#detail_order_kurir_1_pesanan_tertunda").html(Detail1);
                        $("#detail_order_kurir_1_pesanan_diproses").html(Detail1);
                        $("#detail_order_kurir_1").html(Detail1);

                        Detail2 += '<tr>' +
                            '<th width="45%">Nama Pengirim</th>' +
                            '<td width="10%">:</td>' +
                            '<td width="45%">' + data.order_member.cust_name + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Email</th>' +
                            '<td width="10%">:</td>' +
                            '<td width="45%">' + data.order_member.cust_email + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Telepon</th>' +
                            '<td width="10%">:</td>' +
                            '<td width="45%">' + data.order_member.cust_phone + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Kode Pos</th>' +
                            '<td width="10%">:</td>' +
                            '<td width="45%">' + data.order_member.cust_office + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Alamat</th>' +
                            '<td width="10%">:</td>' +
                            '<td width="45%">' + data.order_member.cust_address + '</td>' +
                            '</tr>';

                        $("#detail_order_kurir_2_semua_pesanan").html(Detail2);
                        $("#detail_order_kurir_2_pesanan_dikirim").html(Detail2);
                        $("#detail_order_kurir_2_pesanan_selesai").html(Detail2);
                        $("#detail_order_kurir_2_pesanan_tertunda").html(Detail2);
                        $("#detail_order_kurir_2_pesanan_diproses").html(Detail2);
                        $("#detail_order_kurir_2").html(Detail2);

                        Detail3 += '<tr>' +
                            '<th width="45%">Nama Penerima</th>' +
                            '<td width="10%">:</td>' +
                            '<td width="45%">' + data.order_member.cust_name + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Email Penerima</th>' +
                            '<td width="10%">:</td>' +
                            '<td width="45%">' + data.order_member.cust_email + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">No. Telepon Penerima</th>' +
                            '<td width="10%">:</td>' +
                            '<td width="45%">' + data.order_member.cust_phone + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Kode Pos Penerima</th>' +
                            '<td width="10%">:</td>' +
                            '<td width="45%">' + data.order_member.cust_office + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Alamat Penerima</th>' +
                            '<td width="10%">:</td>' +
                            '<td width="45%">' + data.order_member.cust_address + '</td>' +
                            '</tr>';

                        $("#detail_order_kurir_3_semua_pesanan").html(Detail3);
                        $("#detail_order_kurir_3_pesanan_dikirim").html(Detail3);
                        $("#detail_order_kurir_3_pesanan_selesai").html(Detail3);
                        $("#detail_order_kurir_3_pesanan_tertunda").html(Detail3);
                        $("#detail_order_kurir_3_pesanan_diproses").html(Detail3);
                        $("#detail_order_kurir_3").html(Detail3);

                        var layout;
                        layout = "Bukti Belum Diupload!";

                        if (data.order_member.payment_type == "ambil_langsung") {
                            data.order_member.payment_type = "Tunai";
                        }

                        Detail4 += '<tr>' +
                            '<th class="45%" width="45%">Metode Pembayaran</th>' +
                            '<td width="10%">:</td>' +
                            '<td class="45%" width="45%">' + data.order_member.payment_type + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Biaya Pengiriman</th>' +
                            '<td width="10%">:</td>' +
                            '<td class="45% rupiah-mask" width="45%">' + convertToRupiah(data.order_member.ongkir) + '</td>' +
                            '</tr>';

                        if (data.order_member.payment_type == "transfer") {
                            Detail4 += '<tr>' +
                                '<th width="45%">Bukti Transfer</th>' +
                                '<td width="10%">:</td>' +
                                '<td>' + layout + '</td>' +
                                '</tr>';
                        }

                        if (data.order_member.order_status == "done") {

                            var display1, display2;
                            data.pengiriman.bukti_barang_diterima != null ? display1 = "" : display1 = "display:none";
                            data.pengiriman.bukti_barang_diterima == null ? display2 = "" : display2 = "display:none";

                            Detail4 += '<tr>' +
                                '<th width="45%">Tanggal Penerimaan</th>' +
                                '<td width="10%">:</td>' +
                                '<td class="45%" width="45%">' + ubah_tanggal(data.pengiriman.updated_at, "jam") + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th width="45%">Bukti Penerimaan Barang</th>' +
                                '<td width="10%">:</td>' +
                                '<td id="bukti_penerimaan" style="' + display1 + '">' +
                                '<img id="review_penerimaan" src="' + base_url + '/assets/images/bukti_penerimaan/' + data.pengiriman.bukti_barang_diterima + '" alt="" srcset="">' +
                                '</td>' +
                                '<td id="bukti_penerimaan_1" style="' + display2 + '">' +
                                '<span id="bukti_penerimaan_1">' + "Bukti Belum Diupload!" + '</span>' +
                                '</td>' +
                                '</tr>';
                        }

                        $("#detail_order_kurir_4_semua_pesanan").html(Detail4);
                        $("#detail_order_kurir_4_pesanan_dikirim").html(Detail4);
                        $("#detail_order_kurir_4_pesanan_selesai").html(Detail4);
                        $("#detail_order_kurir_4_pesanan_tertunda").html(Detail4);
                        $("#detail_order_kurir_4_pesanan_diproses").html(Detail4);
                        $("#detail_order_kurir_4").html(Detail4);

                        var j = 1;
                        for (let i = 0; i < data.detail_order.length; i++) {
                            Detail5 += '<tr>' +
                                '<td width="3%">' + j + '</td>' +
                                '<td width="35%">' + data.detail_order[i].nm_produk + '</td>' +
                                '<td width="10%">' + (data.detail_order[i].berat_produk + " " + data.detail_order[i].satuan_berat_produk) + '</td>' +
                                '<td width="22%">' + convertToRupiah(data.detail_order[i].harga_produk) + '</td>' +
                                '<td width="8%">' + data.detail_order[i].qty + '</td>' +
                                '<td width="22%">' + convertToRupiah(data.detail_order[i].sub_total) + '</td>' +
                                '</tr>';
                            j++;
                        }

                        $("#detail_order_kurir_5_semua_pesanan").html(Detail5);
                        $("#detail_order_kurir_5_pesanan_dikirim").html(Detail5);
                        $("#detail_order_kurir_5_pesanan_selesai").html(Detail5);
                        $("#detail_order_kurir_5_pesanan_tertunda").html(Detail5);
                        $("#detail_order_kurir_5_pesanan_diproses").html(Detail5);
                        $("#detail_order_kurir_5").html(Detail5);
                    } else {
                        $("#scanorder").hide();
                        $(".error-data1").html("Data Tidak Ditemukan !");
                        $(".flash-data1").html("");
                        toast();
                    }

                }
            });

            $('#detailModal').modal('show');
        });

        $('#mytablePesananNonMember').on('click', '.approve', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: "Apa Kamu Yakin?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Setuju!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    window.location.href = "<?php echo base_url() ?>order/approve_order/" + id;
                }
            });


        });

        $('#mytablePesananNonMember').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("order/getOrderById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_order": id
                },
                success: function(data) {}
            });
            $('#hapusmodalPesananSelesai').modal('show');
        });
        // ---------------------------------------- End Kelola Pesanan Non Member ----------------------------------------

        // ---------------------------------------- Kelola Konfirmasi Bukti TF ----------------------------------------
        $('#mytableKonBuktiTF').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Order/get_kon_bukti_tf') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "kd_order",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "kd_order",
                    class: "text_center"
                },
                {
                    data: "nm_member",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytableKonBuktiTF').on('click', '.detail_bukti_tf', function() {
            let id = $(this).data('id');
            window.open("<?php echo base_url() ?>order/detail_pesanan/" + id, "href");
        });
        // ---------------------------------------- End Kelola Konfirmasi Bukti TF ----------------------------------------

        // ---------------------------------------- Kelola Semua Pesanan ----------------------------------------

        $('#mytableSemuaPesanan').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Order/get_semua_pesanan') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "kd_order",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "tgl_order",
                    class: "text_center",
                    render: function(data, type, row) {
                        return ubah_tanggal(data);
                    },
                },
                {
                    data: "tgl_kirim",
                    class: "text_center",
                    render: function(data, type, row) {
                        if (data == "") {
                            return "-";
                        } else {
                            return ubah_tanggal(data);
                        }
                    },
                },
                {
                    data: "kd_order",
                    class: "text_center"
                },
                {
                    data: "cust_name",
                    class: "text_center"
                },
                {
                    data: "cust_phone",
                    class: "text_center"
                },
                {
                    data: "total_harga",
                    render: function(data, type, row) {
                        return convertToRupiah(data);
                    },
                    class: "text_center"
                },
                {
                    data: "payment_type",
                    class: "text_center",
                    render: function(data, type, row) {
                        if (data == "transfer") {
                            return 'Transfer';
                        } else if (data == "cod") {
                            return 'COD';
                        } else if (data == "ambil_langsung") {
                            return 'Tunai';
                        } else if (data == "kredit") {
                            return 'Kredit';
                        }
                    },
                },
                {
                    data: "order_status",
                    class: "text_center",
                    render: function(data, type, row) {
                        if (data == "done") {
                            return '<span class="badge badge-success">Selesai</span>';
                        } else if (data == "onprocess") {
                            return '<span class="badge badge-primary">Proses</span>';
                        } else if (data == "pending") {
                            return '<span class="badge badge-danger">Tertunda</span>';
                        } else if (data == "ondelivery") {
                            return '<span class="badge badge-warning">Dikirim</span>';
                        }
                    },
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        if (row.payment_status != 0) {
                            if (row.order_type == 'mingguan' || row.order_type == "bulanan") {
                                return '<span data-toggle="tooltip" data-placement="top" title="Lihat Perincian Pesanan Harian"><a href="javascript:void(0);" class="lihat_perincian btn btn-sm btn-success" data-id="' + row.kd_order + '"> <i class = "fas fa-list" > </i> </a> </span>' + data;
                            } else {
                                return '<span data-toggle="tooltip" data-placement="top" title="Update Status"><a href="javascript:void(0);" class="edit_status btn btn-sm btn-primary" data-id="' + row.kd_order + '"> <i class = "fas fa-edit" > </i> </a> </span>' + data;
                            }
                        } else {
                            if (row.order_type == 'mingguan' || row.order_type == "bulanan") {
                                return data;
                            } else {
                                return '<span data-toggle="tooltip" data-placement="top" title="Update Status"><a href="javascript:void(0);" class="edit_status btn btn-sm btn-primary" data-id="' + row.kd_order + '"> <i class = "fas fa-edit" > </i> </a> </span>' + data;
                            }
                        }
                    }
                }
            ],
        });

        $('#mytableSemuaPesanan').on('click', '.whatsapp', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("order/getOrderByyId") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_order": id
                },
                success: function(data) {
                    window.open('https://api.whatsapp.com/send?phone=' + data.cust_phone + '')
                }
            });

        });

        $('#mytableSemuaPesanan').on('click', '.detail_record', function() {
            let id = $(this).data('id');
            window.open("<?php echo base_url() ?>order/detail_pesanan/" + id, "href");
        });

        $("#btnStatus").change(function() {
            $("#detail_order_code_edit").val($("#kd_order").val());
            $("#status_edit").val($("#btnStatus").val());
            var status = $("#btnStatus").val();
            var ekspedisi = $("#ekspedisi").val();
            if (status == "ondelivery" && ekspedisi == "selera_express" || status == "ondelivery" && ekspedisi == "CateringKita") {
                $('#kurir').show();
            } else {
                $('#kurir').hide();
            }
            $("#kd_reseller").val($("#kd_reseller1").val());
            $("#kd_member").val($("#kd_member1").val());
            $('#modal_edit_status_order').modal('show');
        })

        $('#mytableSemuaPesanan').on('click', '.edit_status', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("order/getOrderById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_order": id
                },
                success: function(data) {}
            });
            $('#editmodalSemuaPesanan').modal('show');
        });

        $('#mytableSemuaPesanan').on('click', '.lihat_perincian', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("order/getOrderPerhariById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_order": id
                },
                success: function(data) {
                    var j = 1;
                    var Detail5 = "";
                    for (let i = 0; i < data.length; i++) {
                        if (data[i].status == 0) {
                            var status = '<span class="badge badge-pill badge-warning">Pending</span>';
                            var button = '<a href="javascript:void(0);" class="edit_status btn btn-sm btn-primary" data-status="2" data-tanggal="' + data[i].tanggal + '" data-order="' + data[i].kd_order + '" data-id="' + data[i].kd_detail_order_perhari + '"> Proses</a>'
                        } else if (data[i].status == 1) {
                            var status = '<span class="badge badge-pill badge-success">Done</span>';
                            var button = '<a href="javascript:void(0);" class="edit_status btn btn-sm btn-warning" data-status="0" data-tanggal="' + data[i].tanggal + '" data-order="' + data[i].kd_order + '" data-id="' + data[i].kd_detail_order_perhari + '"> Pending</a>'
                        } else if (data[i].status == 2) {
                            var status = '<span class="badge badge-pill badge-primary">Proses</span>';
                            var button = '<a href="javascript:void(0);" class="edit_status btn btn-sm btn-secondary" data-status="3" data-tanggal="' + data[i].tanggal + '" data-order="' + data[i].kd_order + '" data-id="' + data[i].kd_detail_order_perhari + '"> Dikirim</a>'
                        } else {
                            var status = '<span class="badge badge-pill badge-secondary">Dikirim</span>';
                            var button = '<a href="javascript:void(0);" class="edit_status btn btn-sm btn-success" data-status="1" data-tanggal="' + data[i].tanggal + '" data-order="' + data[i].kd_order + '" data-id="' + data[i].kd_detail_order_perhari + '"> Selesai</a>'
                        }
                        Detail5 += '<tr>' +
                            '<td>' + j + '</td>' +
                            '<td>' + data[i].nm_produk + '</td>' +
                            '<td>' + ubah_tanggal(data[i].tanggal) + '</td>' +
                            '<td>' + status + '</td>' +
                            '<td>' + parseInt(data[i].qty) / data.length + '</td>' +
                            '<td>' + button + '</td>' +
                            '</tr>';
                        j++;
                    }

                    $('#tbody_orderperhari').html(Detail5);
                }
            });
            $('#modalOrderPerhari').modal('show');
        });

        $.ajax({
            url: "<?php echo base_url("order/get_pesanan_khusus") ?>",
            type: 'post',
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    var j = 1;
                    var Detail5 = "";
                    for (let i = 0; i < data.length; i++) {
                        if (data[i].order_type == "mingguan") {
                            var hari = 7;
                        } else if (data[i].order_type == "bulanan") {
                            var hari = 30;
                        }

                        if (data[i].status == 0) {
                            var status = '<span class="badge badge-pill badge-warning">Pending</span>';
                            var button = '<a href="javascript:void(0);" class="edit_status btn btn-sm btn-primary" data-status="2" data-tanggal="' + data[i].tanggal + '" data-order="' + data[i].kd_order + '" data-id="' + data[i].kd_detail_order_perhari + '"> Proses</a>'
                        } else if (data[i].status == 1) {
                            var status = '<span class="badge badge-pill badge-success">Done</span>';
                            var button = '<a href="javascript:void(0);" class="edit_status btn btn-sm btn-warning" data-status="0" data-tanggal="' + data[i].tanggal + '" data-order="' + data[i].kd_order + '" data-id="' + data[i].kd_detail_order_perhari + '"> Pending</a>'
                        } else if (data[i].status == 2) {
                            var status = '<span class="badge badge-pill badge-primary">Proses</span>';
                            var button = '<a href="javascript:void(0);" class="edit_status btn btn-sm btn-secondary" data-status="3" data-tanggal="' + data[i].tanggal + '" data-order="' + data[i].kd_order + '" data-id="' + data[i].kd_detail_order_perhari + '"> Dikirim</a>'
                        } else {
                            var status = '<span class="badge badge-pill badge-secondary">Dikirim</span>';
                            var button = '<a href="javascript:void(0);" class="edit_status btn btn-sm btn-success" data-status="1" data-tanggal="' + data[i].tanggal + '" data-order="' + data[i].kd_order + '" data-id="' + data[i].kd_detail_order_perhari + '"> Selesai</a>'
                        }
                        Detail5 += '<tr>' +
                            '<td>' + j + '</td>' +
                            '<td>' + data[i].nm_produk + '</td>' +
                            '<td>' + ubah_tanggal(data[i].tanggal) + '</td>' +
                            '<td>' + status + '</td>' +
                            '<td>' + parseInt(data[i].qty) / hari + '</td>' +
                            '<td>' + button + '</td>' +
                            '</tr>';
                        j++;
                    }

                } else {
                    Detail5 += '<tr>' +
                        '<td colspan="6">Data Kososng</td>' +
                        '</tr>';
                }

                $('#tbody_pesanankhusus').html(Detail5);
            }
        });

        $('#tbody_pesanankhusus').on('click', '.edit_status', function() {
            let kd = $(this).data('id');
            let id = $(this).data('order');
            let status = $(this).data('status');
            let tanggal = $(this).data('tanggal');

            $.ajax({
                url: "<?php echo base_url("order/updatestatusperhari") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_detail_order_perhari": kd,
                    "status": status,
                    "tanggal": tanggal
                },
                success: function(data) {
                    if (data.response == "success") {
                        $('#tbody_pesanankhusus').html("");
                        $.ajax({
                            url: "<?php echo base_url("order/get_pesanan_khusus") ?>",
                            type: 'post',
                            dataType: 'json',
                            data: {
                                "kd_order": id
                            },
                            success: function(data) {
                                if (data.length > 0) {
                                    var j = 1;
                                    var Detail5 = "";
                                    for (let i = 0; i < data.length; i++) {
                                        if (data[i].order_type == "mingguan") {
                                            var hari = 7;
                                        } else if (data[i].order_type == "bulanan") {
                                            var hari = 30;
                                        }
                                        if (data[i].status == 0) {
                                            var status = '<span class="badge badge-pill badge-warning">Pending</span>';
                                            var button = '<a href="javascript:void(0);" class="edit_status btn btn-sm btn-primary" data-status="2" data-tanggal="' + data[i].tanggal + '" data-order="' + data[i].kd_order + '" data-id="' + data[i].kd_detail_order_perhari + '"> Proses</a>'
                                        } else if (data[i].status == 1) {
                                            var status = '<span class="badge badge-pill badge-success">Done</span>';
                                            var button = '<a href="javascript:void(0);" class="edit_status btn btn-sm btn-warning" data-status="0" data-tanggal="' + data[i].tanggal + '" data-order="' + data[i].kd_order + '" data-id="' + data[i].kd_detail_order_perhari + '"> Pending</a>'
                                        } else if (data[i].status == 2) {
                                            var status = '<span class="badge badge-pill badge-primary">Proses</span>';
                                            var button = '<a href="javascript:void(0);" class="edit_status btn btn-sm btn-secondary" data-status="3" data-tanggal="' + data[i].tanggal + '" data-order="' + data[i].kd_order + '" data-id="' + data[i].kd_detail_order_perhari + '"> Dikirim</a>'
                                        } else {
                                            var status = '<span class="badge badge-pill badge-secondary">Dikirim</span>';
                                            var button = '<a href="javascript:void(0);" class="edit_status btn btn-sm btn-success" data-status="1" data-tanggal="' + data[i].tanggal + '" data-order="' + data[i].kd_order + '" data-id="' + data[i].kd_detail_order_perhari + '"> Selesai</a>'
                                        }
                                        Detail5 += '<tr>' +
                                            '<td>' + j + '</td>' +
                                            '<td>' + data[i].nm_produk + '</td>' +
                                            '<td>' + ubah_tanggal(data[i].tanggal) + '</td>' +
                                            '<td>' + status + '</td>' +
                                            '<td>' + parseInt(data[i].qty) / hari + '</td>' +
                                            '<td>' + button + '</td>' +
                                            '</tr>';
                                        j++;
                                    }
                                } else {
                                    Detail5 += '<tr>' +
                                        '<td colspan="6">Data Kososng</td>' +
                                        '</tr>';
                                }

                                $('#tbody_pesanankhusus').html(Detail5);
                            }
                        });

                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });

            $('#editmodalperhari').modal('show');
        })

        $('#tbody_orderperhari').on('click', '.edit_status', function() {
            let kd = $(this).data('id');
            let id = $(this).data('order');
            let status = $(this).data('status');
            let tanggal = $(this).data('tanggal');

            $.ajax({
                url: "<?php echo base_url("order/updatestatusperhari") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_detail_order_perhari": kd,
                    "status": status,
                    "tanggal": tanggal
                },
                success: function(data) {
                    if (data.response == "success") {
                        $('#tbody_orderperhari').html("");
                        $.ajax({
                            url: "<?php echo base_url("order/getOrderPerhariById") ?>",
                            type: 'post',
                            dataType: 'json',
                            data: {
                                "kd_order": id
                            },
                            success: function(data) {
                                var j = 1;
                                var Detail5 = "";
                                for (let i = 0; i < data.length; i++) {
                                    if (data[i].status == 0) {
                                        var status = '<span class="badge badge-pill badge-warning">Pending</span>';
                                        var button = '<a href="javascript:void(0);" class="edit_status btn btn-sm btn-primary" data-status="2" data-tanggal="' + data[i].tanggal + '" data-order="' + data[i].kd_order + '" data-id="' + data[i].kd_detail_order_perhari + '"> Proses</a>'
                                    } else if (data[i].status == 1) {
                                        var status = '<span class="badge badge-pill badge-success">Done</span>';
                                        var button = '<a href="javascript:void(0);" class="edit_status btn btn-sm btn-warning" data-status="0" data-tanggal="' + data[i].tanggal + '" data-order="' + data[i].kd_order + '" data-id="' + data[i].kd_detail_order_perhari + '"> Pending</a>'
                                    } else if (data[i].status == 2) {
                                        var status = '<span class="badge badge-pill badge-primary">Proses</span>';
                                        var button = '<a href="javascript:void(0);" class="edit_status btn btn-sm btn-secondary" data-status="3" data-tanggal="' + data[i].tanggal + '" data-order="' + data[i].kd_order + '" data-id="' + data[i].kd_detail_order_perhari + '"> Dikirim</a>'
                                    } else {
                                        var status = '<span class="badge badge-pill badge-secondary">Dikirim</span>';
                                        var button = '<a href="javascript:void(0);" class="edit_status btn btn-sm btn-success" data-status="1" data-tanggal="' + data[i].tanggal + '" data-order="' + data[i].kd_order + '" data-id="' + data[i].kd_detail_order_perhari + '"> Selesai</a>'
                                    }
                                    Detail5 += '<tr>' +
                                        '<td>' + j + '</td>' +
                                        '<td>' + data[i].nm_produk + '</td>' +
                                        '<td>' + ubah_tanggal(data[i].tanggal) + '</td>' +
                                        '<td>' + status + '</td>' +
                                        '<td>' + parseInt(data[i].qty) / data.length + '</td>' +
                                        '<td>' + button + '</td>' +
                                        '</tr>';
                                    j++;
                                }

                                $('#tbody_orderperhari').html(Detail5);
                            }
                        });

                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });

            $('#editmodalperhari').modal('show');
        })

        $("#editStatusPesanan").submit(function(e) {
            e.preventDefault();
            let dataString = $('#editStatusPesanan').serialize();

            $.ajax({
                url: "<?php echo base_url("order/editStatusPesanan") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,
                success: function(data) {

                    if (data.response == "success") {
                        $('#mytableSemuaPesanan').DataTable().ajax.reload();

                        $('#editmodalSemuaPesanan').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        $('#mytableSemuaPesanan').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("order/getOrderById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_order": id
                },
                success: function(data) {}
            });
            $('#hapusmodalSemuaPesanan').modal('show');
        });

        $("#hapusOrder").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo base_url("order/delete_order") ?>",
                type: 'post',
                dataType: 'json',
                data: {},
                success: function(data) {

                    if (data.response == "success") {
                        $('#mytableSemuaPesanan').DataTable().ajax.reload();
                        $('#mytablePesananTertunda').DataTable().ajax.reload();
                        $('#mytablePesananDiproses').DataTable().ajax.reload();
                        $('#mytablePesananDikirim').DataTable().ajax.reload();
                        $('#mytablePesananSelesai').DataTable().ajax.reload();

                        $('#mytableSemuaPesananReseller').DataTable().ajax.reload();
                        $('#mytablePesananTertundaReseller').DataTable().ajax.reload();
                        $('#mytablePesananDiprosesReseller').DataTable().ajax.reload();
                        $('#mytablePesananDikirimReseller').DataTable().ajax.reload();
                        $('#mytablePesananSelesaiReseller').DataTable().ajax.reload();

                        $('#hapusmodalSemuaPesanan').modal('hide');
                        $('#hapusmodalPesananTertunda').modal('hide');
                        $('#hapusmodalPesananDiproses').modal('hide');
                        $('#hapusmodalPesananDikirim').modal('hide');
                        $('#hapusmodalPesananSelesai').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        // ---------------------------------------- End Kelola Semua Pesanan ----------------------------------------

        // ---------------------------------------- konfigurasi ----------------------------------------

        // Toko

        $('#mytableTokoSelera').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Konfigurasi/get_toko') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_toko",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_toko",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    render: function(data, type, row, meta) {
                        if (row.status_aktif_link_pemesanan == '1') {
                            return '<span data-toggle="tooltip" data-placement="top" title="Edit Kategori"><div class=" text-center switchToggle"><input type="hidden" name="kd_produk" id="kd_produk"><input data-id="' + row.kd_toko + '" type="checkbox" class="edit_link_toko" id="switch' + row.kd_toko + '" checked><label for="switch' + row.kd_toko + '" style="margin-top:4px">Toggle</label></div> </span>'
                        } else {
                            return '<span data-toggle="tooltip" data-placement="top" title="Edit Kategori"><div class=" text-center switchToggle"><input type="hidden" name="kd_produk" id="kd_produk"><input data-id="' + row.kd_toko + '" type="checkbox" class="edit_link_toko" id="switch' + row.kd_toko + '"><label for="switch' + row.kd_toko + '" style="margin-top:4px">Toggle</label></div> </span>'
                        }
                    }
                }
            ],
        });

        $('#mytableTokoSelera').on('click', '.edit_link_toko', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("konfigurasi/ganti_link_toko") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    kd_toko: id,
                    id: $("#switch" + id).prop("checked"),
                },
                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytableTokoSelera').DataTable().ajax.reload();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            })
        });

        // ------- Kelola Daerah Ongkir ------

        $('#mytableDaerahOngkir').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Konfigurasi/get_daerah_ongkir') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nama_daerah",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nama_daerah",
                    class: "text_center"
                },
                {
                    data: "ongkir1",
                    class: "text_center",
                    render: function(data, type, row) {
                        return convertToRupiah(data);
                    },
                },
                {
                    data: "ongkir2",
                    class: "text_center",
                    render: function(data, type, row) {
                        return convertToRupiah(data);
                    },
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $("#addDaerahOngkir").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addDaerahOngkir').serialize();

            $.ajax({
                url: "<?php echo base_url("konfigurasi/add_daerah_ongkir") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytableDaerahOngkir').DataTable().ajax.reload();
                        $('#daerah').val("").trigger('change');
                        $('#addDaerahOngkir')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $('#mytableDaerahOngkir').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            getDaerahById(id, "Edit")
        });

        $('#mytableDaerahOngkir').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            getDaerahById(id, "Delete");
        });

        function getDaerahById(id, action) {
            $.ajax({
                url: "<?php echo base_url("konfigurasi/getDaerahById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "id": id
                },
                success: function(data) {
                    if (action == "Edit") {
                        $('#daerah_edit').val(data.nama_daerah).trigger('change');
                        $('#daerah_edit').html('<option value="' + data.nama_daerah + '">' + data.nama_daerah + '</option>');
                        $("#ongkir1_edit").val(data.ongkir1);
                        $("#ongkir2_edit").val(data.ongkir2);
                    }
                }
            });
            $('#Modal_' + action).modal({
                backdrop: 'static',
                keyboard: false
            })
        }

        $("#editDaerahOngkir").submit(function(e) {
            e.preventDefault();
            let dataString = $('#editDaerahOngkir').serialize();

            $.ajax({
                url: "<?php echo base_url("konfigurasi/edit_daerah_ongkir") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#mytableDaerahOngkir').DataTable().ajax.reload();
                        $('#editDaerahOngkir')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $("#hapusDaerahOngkir").submit(function(e) {
            e.preventDefault();
            let dataString = $('#hapusDaerahOngkir').serialize();

            $.ajax({
                url: "<?php echo base_url("konfigurasi/delete_daerah_ongkir") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Delete').modal('hide');
                        $('#mytableDaerahOngkir').DataTable().ajax.reload();
                        $('#hapusDaerahOngkir')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        // ------- End Kelola Daerah Ongkir ------

        // ------- Kelola Ongkir Khusus ------

        $('#mytableOngkirKhusus').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Konfigurasi/get_ongkir_khusus') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "nm_daerah_ongkir",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nm_daerah_ongkir",
                    class: "text_center"
                },
                // {
                //     data: "kota",
                //     class: "text_center"
                // },
                {
                    data: "nominal_ongkir1",
                    class: "text_center",
                    render: function(data, type, row) {
                        return convertToRupiah(data);
                    },
                },
                {
                    data: "nominal_ongkir2",
                    class: "text_center",
                    render: function(data, type, row) {
                        return convertToRupiah(data);
                    },
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $("#addOngkirKhusus").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addOngkirKhusus').serialize();

            $.ajax({
                url: "<?php echo base_url("konfigurasi/add_ongkir_khusus") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytableOngkirKhusus').DataTable().ajax.reload();
                        $('#addOngkirKhusus')[0].reset();
                        $(".bagiantambahongkirkhusus").html("");
                        $('#kabupaten').val("").trigger('change');
                        $('#select2kecamatan').val("").trigger('change');
                        $('#kelurahan').val("").trigger('change');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $('#mytableOngkirKhusus').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            getOngkirById(id, "Edit")
        });

        $('#mytableOngkirKhusus').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            getOngkirById(id, "Delete");
        });

        function getOngkirById(id, action) {
            $.ajax({
                url: "<?php echo base_url("konfigurasi/getOngkirKhususById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "id": id
                },
                success: function(data) {
                    if (action == "Edit") {
                        $("#edit_jmlbarang1").val(data.length - 1 == 0 ? 1 : data.length - 1);
                        $("#edit_jmlbarangplus").val(data.length - 1 == 0 ? 1 : data.length - 1);
                        $("#edit_jmlbarangminus").val(data.length - 1 == 0 ? 1 : data.length - 1);

                        $("#kd_ongkir_edit").val(data[0].kd_daerah_ongkir_khusus);
                        $("#kd_detail_edit").val(data[0].kd_detail_ongkir_khusus);
                        $("#judul_ongkir_edit").val(data[0].nm_daerah_ongkir);
                        $("#nominal_ongkir1_edit").val(data[0].nominal_ongkir1);
                        $("#nominal_ongkir2_edit").val(data[0].nominal_ongkir2);

                        $('#kabupaten_edit').val(data[0].kota).trigger('change');
                        $('#kabupaten_edit').html('<option value="' + data[0].kota + '">' + data[0].kota + '</option>');
                        $('#kecamatan_edit').val(data[0].kecamatan).trigger('change');
                        $('#kecamatan_edit').html('<option value="' + data[0].kecamatan + '">' + data[0].kecamatan + '</option>');

                        var kel = data[0].kelurahan;
                        if (kel != "") {
                            var arr = kel.split(",");

                            for (let k = 0; k < arr.length; k++) {
                                if (arr[k] != "") {
                                    var $newOption = $("<option selected='selected'></option>").val(arr[k]).text(arr[k]);
                                    $("#kelurahan_edit").append($newOption).trigger('change');
                                }
                            }
                        }

                        html = '';
                        for (let j = 1; j < data.length; j++) {
                            html = '<div class="divhapusongkir' + j + '">' +
                                '<div class="row mt-3">' +
                                '<div class="col-md-3 col-12">' +
                                '<label for="judul_ongkir">Pilih Kota</label>' +
                                '<input type="hidden" id="kd_detail' + j + '" name="kd_detail[]" class="form-control"></input>' +
                                '<select name="kabupaten_edit[]" id="kabupaten_edit' + j + '" class="form-control select2kota' + j + '"></select>' +
                                '</div>' +
                                '<div class="col-md-3 col-12">' +
                                '<label for="judul_ongkir">Pilih Kecamatan</label>' +
                                '<select name="kecamatan_edit[]" id="kecamatan_edit' + j + '" class="form-control select2kecamatanedit' + j + '"></select>' +
                                '</div>' +
                                '<div class="col-md-5 col-12">' +
                                '<label for="judul_ongkir">Pilih Kelurahan (Optional)</label>' +
                                '<select name="kelurahan_edit[]" id="kelurahan_edit' + j + '" class="form-control select2multiple-kelurahan' + j + '" multiple="multiple">' +
                                '<option value="1">1</option>' +
                                '<option value="2">2</option>' +
                                '</select>' +
                                '</div>' +
                                '<div class="col-md-1 col-12">' +
                                '<label for="kd_supplier"></label><br>' +
                                '<a href="javascript:void(0);" class="btn btn-danger mt-2" id="buttondeleteongkirkhusus' + j + '"> <i class="fa fa-minus"></i></a>' +
                                '</div></div></div>';
                            $("#bagiantambahongkirkhusus_edit").append(html);

                            $('#kabupaten_edit' + j).val(data[j].kota).trigger('change');
                            $('#kabupaten_edit' + j).html('<option value="' + data[j].kota + '">' + data[j].kota + '</option>');
                            $('#kecamatan_edit' + j).val(data[j].kecamatan).trigger('change');
                            $('#kecamatan_edit' + j).html('<option value="' + data[j].kecamatan + '">' + data[j].kecamatan + '</option>');
                            $("#kd_detail" + j).val(data[j].kd_detail_ongkir_khusus);

                            var tampungan_del = [];
                            var kel = data[j].kelurahan;
                            if (kel != "") {
                                var arr = kel.split(",");
                                for (let k = 0; k < arr.length; k++) {
                                    if (arr[k] != "") {
                                        var $newOption = $("<option selected='selected'></option>").val(arr[k]).text(arr[k]);
                                        $("#kelurahan_edit" + j).append($newOption).trigger('change');
                                    }
                                }
                            }
                            $("body").on("click", "#buttondeleteongkirkhusus" + j, function() {
                                tampungan_del.push($("#kd_detail" + j).val());
                                $("#tampungan").val(tampungan_del);

                                $(this)
                                    .parents(".divhapusongkir" + j)
                                    .remove();
                            });

                            $(".select2kota" + j).select2({
                                placeholder: "Pilih Kota",
                                ajax: {
                                    url: base_url + "/order/get_json_kota",
                                    type: "post",
                                    dataType: "json",
                                    delay: 100,
                                    data: function(params) {
                                        return {
                                            searchTerm: params.term, // search term
                                        };
                                    },
                                    processResults: function(response) {
                                        return {
                                            results: response,
                                        };
                                    },
                                    cache: true,
                                },
                            });

                            $(".select2kecamatanedit" + j).select2({
                                placeholder: "Pilih Kecamatan",
                                ajax: {
                                    url: base_url + "/order/get_json_kecamatan",
                                    type: "post",
                                    dataType: "json",
                                    delay: 100,
                                    data: function(params) {
                                        return {
                                            kabupaten: $("#kabupaten_edit" + j).val(),
                                            searchTerm: params.term, // search term
                                        };
                                    },
                                    processResults: function(response) {
                                        return {
                                            results: response,
                                        };
                                    },
                                    cache: true,
                                },
                            });

                            $("#select2kecamatan" + j).select2({
                                placeholder: "Pilih Kecamatan",
                                ajax: {
                                    url: base_url + "/order/get_json_kecamatan",
                                    type: "post",
                                    dataType: "json",
                                    delay: 100,
                                    data: function(params) {
                                        return {
                                            kabupaten: $("#kabupaten_edit" + j).val(),
                                            searchTerm: params.term, // search term
                                        };
                                    },
                                    processResults: function(response) {
                                        return {
                                            results: response,
                                        };
                                    },
                                    cache: true,
                                },
                            });

                            $(".select2multiple-kelurahan" + j).select2({
                                placeholder: "Pilih Kelurahan",
                                ajax: {
                                    url: base_url + "/order/get_json_kelurahan",
                                    type: "post",
                                    dataType: "json",
                                    delay: 100,
                                    data: function(params) {
                                        return {
                                            kabupaten: $("#kabupaten_edit" + j).val(),
                                            kecamatan: $("#kecamatan_edit" + j).val(),
                                            searchTerm: params.term, // search term
                                        };
                                    },
                                    processResults: function(response) {
                                        return {
                                            results: response,
                                        };
                                    },
                                    cache: true,
                                },
                                tags: true,
                                tokenSeparators: [',', ' ']
                            });
                        }
                    }
                }
            });
            $('#Modal_' + action).modal({
                backdrop: 'static',
                keyboard: false
            })
        }

        $('#Modal_Edit').on('hidden.bs.modal', function(e) {
            $("#bagiantambahongkirkhusus_edit").html("");
            $(".bagiantambahongkirkhususs").html("");
            $("#kelurahan_edit").html("");
            $("#sub_kategori_edit").html("");
        })

        $("#editOngkirKhusus").submit(function(e) {
            e.preventDefault();
            let dataString = $('#editOngkirKhusus').serialize();

            $.ajax({
                url: "<?php echo base_url("konfigurasi/edit_ongkir_khusus") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#mytableOngkirKhusus').DataTable().ajax.reload();
                        $('#editOngkirKhusus')[0].reset();
                        $(".bagiantambahongkirkhususs").html("");
                        $("#bagiantambahongkirkhusus_edit").html("");
                        $('#kabupaten_edit').val("").trigger('change');
                        $('#kecamatan_edit').val("").trigger('change');
                        $('#kelurahan_edit').val("").trigger('change');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $("#hapusOngkirKhusus").submit(function(e) {
            e.preventDefault();
            let dataString = $('#hapusOngkirKhusus').serialize();

            $.ajax({
                url: "<?php echo base_url("konfigurasi/delete_ongkir_khusus") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Delete').modal('hide');
                        $('#mytableOngkirKhusus').DataTable().ajax.reload();
                        $('#hapusOngkirKhusus')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        // ------- End Kelola Ongkir Khusus ------

        // Contact Selera

        $('#mytableContactSelera').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Konfigurasi/get_contact') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "kd_rekening",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nama_bank",
                    class: "text_center"
                },
                {
                    data: "nomor_rekening",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytableContactSelera').on('click', '.edit_record', function() {
            let id = $(this).data('id');

            getContactById(id, "Edit")
        });

        $('#mytableContactSelera').on('click', '.hapus_record', function() {
            let id = $(this).data('id');

            getContactById(id, "Delete");
        });

        $("#addContactSelera").submit(function(e) {
            e.preventDefault();
            let dataString = $('#addContactSelera').serialize();

            $.ajax({
                url: "<?php echo base_url("konfigurasi/add_contact_selera") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Add').modal('hide');
                        $('#mytableContactSelera').DataTable().ajax.reload();
                        $('#addContactSelera')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        function getContactById(id, action) {
            $.ajax({
                url: "<?php echo base_url("konfigurasi/getContactById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_rekening": id
                },
                success: function(data) {
                    if (action == "Edit") {
                        $("#nama_bank_edit").val(data.nama_bank);
                        $("#atas_nama_edit").val(data.atas_nama);
                        $("#nomor_rekening_edit").val(data.nomor_rekening);
                    }
                }
            });
            $('#Modal_' + action).modal({
                backdrop: 'static',
                keyboard: false
            })
        }

        $("#cont").click(function() {
            $('#alamat').summernote("code", null);
        })

        $("#editContactSelera").submit(function(e) {

            e.preventDefault();
            let dataString = $('#editContactSelera').serialize();

            $.ajax({
                url: "<?php echo base_url("konfigurasi/edit_contact_selera") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#Modal_Edit').modal('hide');
                        $('#mytableContactSelera').DataTable().ajax.reload();
                        $('#editContactSelera')[0].reset();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $("#hapusContactSelera").submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?php echo base_url("konfigurasi/delete_contact_selera") ?>",
                type: 'post',
                dataType: 'json',
                success: function(data) {

                    if (data.response == "success") {
                        $('#mytableContactSelera').DataTable().ajax.reload();
                        $('#Modal_Delete').modal('hide');
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        });

        // ---------------------------------------- End konfigurasi ----------------------------------------
        $('#ujroh_reseller').on('keyup', function() {
            var reseller = parseInt($('#ujroh_reseller').val());

            var selera = 100 - reseller;

            if (isNaN(reseller)) {
                selera = 0;
            }

            if (reseller > 100) {
                $('#ujroh_reseller').val(100)
                selera = 0;
            }

            $('#ujroh_selera').val(selera);
        });

        $(".tombol_hapus").on("click", function(e) {
            e.preventDefault();
            const href = $(this).attr("href");

            Swal.fire({
                title: "Apa Kamu Yakin?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus saja!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    document.location.href = href;
                }
            });
        });

        // ---------------------------------------- Kelola Upload Foto Website ----------------------------------------
        $("#uploadLogoSelera").submit(function(e) {
            e.preventDefault();
            let dataString = $('#uploadLogoSelera').serialize();

            var form_data = new FormData(this);

            var image_form = $("#file-input-logo").prop("files")[0];
            form_data.append("image_form", image_form);

            $.ajax({
                url: "<?php echo base_url("Konfigurasi/ganti_logo_website") ?>",
                type: 'post',
                data: form_data,
                // data: dataString,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,

                success: function(data) {
                    if (data.message.response == "success") {
                        $("#logo-seleraa").attr("src", base_url + "/assets/images/logo_website/" + data.logo);
                        $(".flash-data1").html(data.message.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })
        // ---------------------------------------- End Kelola Upload Foto  Website----------------------------------------

        // ---------------------------------------- Kelola Upload Foto Invoice ----------------------------------------
        $("#uploadInvoiceSelera").submit(function(e) {
            e.preventDefault();
            let dataString = $('#uploadInvoiceSelera').serialize();

            var form_data = new FormData(this);

            var image_form = $("#file-input-invoice").prop("files")[0];
            form_data.append("image_form", image_form);

            $.ajax({
                url: "<?php echo base_url("Konfigurasi/ganti_invoice_website") ?>",
                type: 'post',
                data: form_data,
                // data: dataString,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,

                success: function(data) {
                    if (data.message.response == "success") {
                        $(".flash-data1").html(data.message.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })
        // ---------------------------------------- End Kelola Upload Foto Invoice----------------------------------------

        // ---------------------------------------- Kelola Bukti Pembayaran ----------------------------------------

        $("#inputFile").change(function(event) {
            fadeInAdd();
            getURL(this);
        });

        $("#inputFile").on('click', function(event) {
            fadeInAdd();
        });

        function getURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var filename = $("#inputFile").val();
                filename = filename.substring(filename.lastIndexOf('\\') + 1);
                reader.onload = function(e) {

                    $('#imgView').attr('src', e.target.result);
                    $('#imgView').hide();
                    $('#imgView').fadeIn(500);
                    $('#custom-file-label').text(filename);
                }
                reader.readAsDataURL(input.files[0]);
            }
            $(".alert").removeClass("loadAnimate").hide();
        }

        function fadeInAdd() {
            fadeInAlert();
        }

        $("#bukti_transfer").change(function(event) {
            fadeInAdd();
            getURL(this);
        });

        $("#bukti_transfer").on('click', function(event) {
            fadeInAdd();
        });

        function getURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var filename = $("#bukti_transfer").val();

                if (filename == undefined) {
                    var filename = $("#inputFile").val();
                }

                filename = filename.substring(filename.lastIndexOf('\\') + 1);
                reader.onload = function(e) {

                    $('#imgViewBuktiTf').attr('src', e.target.result);
                    $('#imgViewBuktiTf').hide();
                    $('#imgViewBuktiTf').fadeIn(500);
                    $('#custom-file-label-tf').text(filename);
                }
                reader.readAsDataURL(input.files[0]);
            }
            $(".alert").removeClass("loadAnimate").hide();
        }

        function fadeInAdd() {
            fadeInAlert();
        }

        function fadeInAlert(text) {
            $(".alert").text(text).addClass("loadAnimate");
        }

        $("#uploadBuktiPembayaran").submit(function(e) {
            e.preventDefault();
            let dataString = $('#uploadBuktiPembayaran').serialize();

            var form_data = new FormData(this);
            // form_data.append("userFile", document.getElementById('inputFile').files[0]);
            var ins = document.getElementById('multiFiles').files.length;
            for (var x = 0; x < ins; x++) {
                form_data.append("gallery[]", document.getElementById('multiFiles').files[x]);
            }

            $.ajax({
                url: "<?php echo base_url("Order/upload_bukti_pembayaran") ?>",
                type: 'post',
                data: form_data,
                // data: dataString,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,

                success: function(data) {
                    if (data.toast.response == "success") {
                        $("#ModalUploadPembayaran").modal('hide');
                        $('#bagian_bukti').show();
                        $('#bagian_bukti_1').hide();
                        $('.bkt_pembayaran').attr('src', base_url + '/assets/images/bukti_pembayaran/' + data.bukti_transfer);

                        $('#status_bayar').removeClass('badge-danger');
                        $('#status_bayar').addClass('badge-success');
                        $('#status_bayar').html('');
                        $('#status_bayar').html('Sudah Dibayar');

                        $(".flash-data1").html(data.toast.message);
                        $(".error-data1").html("");

                        $("#row_prev_gallery").html('');
                    } else {
                        $('#bagian_bukti').hide();
                        $('#bagian_bukti_1').show();
                        $(".error-data1").html(data.toast.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        $(".bkt_pembayaran").click(function() {
            // var path = $(".bkt_pembayaran").attr('src');
            $(".bukti-foto").html("Bukti Pembayaran");
            var kd_order = $("#kd_order").val();
            var html = '<div class="row">';
            var path = $(".bkt_pembayaran").attr('src');

            $.ajax({
                url: "<?php echo base_url("order/select_bukti_transfer") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    'kd_order': kd_order,
                },
                success: function(data) {
                    var lokasi = lokasigambar();
                    var lnght = data.length > 1 ? 6 : 12;
                    var display = data.length <= 1 ? "style=display:none" : "";

                    for (let i = 0; i < data.length; i++) {
                        html += '<div class="position-relative mb-2 col-md-' + lnght + ' col-sm-12 col-12">' +
                            '<img id="muncul_foto_penerimaan" src="' + base_url + "/assets/images/bukti_pembayaran/" + data[i].bukti_upload + '" class="img-fluid rounded mx-auto d-block" alt="...">' +
                            '<div class="ribbon-wrapper ribbon-sm">' +
                            '<a ' + display + ' href="javascript:void(0);" class="tombol_hapus_transfer_satuan' + i + '">' +
                            '<div class="ribbon bg-light text-lg">' +
                            '<span aria-hidden="true" class="fa fa-minus-circle"></span>' +
                            '</div>' +
                            '</a>' +
                            '<input type="hidden" name="bukti_tf_satuan" value="' + data[i].kd_bukti_pembayaran + '" id="bukti_tf_satuan' + i + '">' +
                            '</div>' +
                            '</div>';
                    }
                    html += '</div>';
                    $(".gmbr").html(html);

                    for (let i = 0; i < data.length; i++) {
                        $(".tombol_hapus_transfer_satuan" + i).click(function() {
                            var kd_pembayaran = $("#bukti_tf_satuan" + i).val();
                            var kd_order = $("#kd_order").val();
                            var kd_reseller = $("#kd_reseller").val();
                            var kd_member = $("#kd_member1").val();

                            Swal.fire({
                                title: "Apa Kamu Yakin Menghapus Bukti Pembayaran ini?",
                                text: "Anda tidak akan dapat mengembalikan ini!",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Ya, Hapus saja!",
                                cancelButtonText: "Batal!",
                            }).then((result) => {
                                if (result.value) {
                                    $.ajax({
                                        url: "<?php echo base_url("order/del_bukti_transfer_satuan") ?>",
                                        type: 'post',
                                        dataType: 'json',
                                        data: {
                                            'kd_pembayaran': kd_pembayaran,
                                            'kd_order': kd_order,
                                            'kd_reseller': kd_reseller,
                                            'kd_member': kd_member,
                                        },
                                        success: function(data) {
                                            if (data.data.response == "success") {

                                                $('#status_bayar').removeClass(data.status == 0 ? 'badge-success' : 'badge-danger');
                                                $('#status_bayar').addClass(data.status == 0 ? 'badge-danger' : 'badge-success');
                                                $('#status_bayar').html('');
                                                $('#status_bayar').html(data.status == 0 ? 'Belum Dibayar' : 'Sudah Dibayar');

                                                data.status == 0 ? $(".button_edit_bukti").hide() : $(".button_edit_bukti").show();
                                                data.status == 0 ? $('#bagian_bukti').hide() : $('#bagian_bukti').show();
                                                data.status == 0 ? $('#bagian_bukti_1').show() : $('#bagian_bukti_1').hide();

                                                $(".flash-data1").html(data.data.message);
                                                $(".error-data1").html("");

                                                $("#modal_bukti_penerimaan").modal('hide');
                                            } else {
                                                $(".error-data1").html(data.data.message);
                                                $(".flash-data1").html("");
                                            }
                                            toast();
                                        }
                                    })
                                }
                            });
                        })
                    }
                }
            })

            // $("#muncul_foto_penerimaan").attr("src", path);
            $("#modal_bukti_penerimaan").modal('show');
        })

        $(".tombol_hapus_transfer_satuan").click(function() {
            var kd_order = $("#kd_order").val();

            Swal.fire({
                title: "Apa Kamu Yakin Menghapus Bukti Pembayaran?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus saja!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url("order/del_bukti_transfer_satuan") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            'kd_order': kd_order,
                        },
                        success: function(data) {
                            if (data.response == "success") {
                                $('#status_bayar').removeClass('badge-success');
                                $('#status_bayar').addClass('badge-danger');
                                $('#status_bayar').html('');
                                $('#status_bayar').html('Belum Dibayar');

                                $(".button_edit_bukti").hide();

                                $('#bagian_bukti').hide();
                                $('#bagian_bukti_1').show();

                                $(".flash-data1").html(data.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                        }
                    })
                }
            });

        })

        $(".tombol_hapus_transfer").click(function() {
            var kd_order = $("#kd_order").val();
            var kd_reseller = $("#kd_reseller").val();
            var kd_member = $("#kd_member1").val();

            Swal.fire({
                title: "Apa Kamu Yakin Menghapus Bukti Pembayaran?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus saja!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url("order/del_bukti_transfer") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            'kd_order': kd_order,
                            'kd_reseller': kd_reseller,
                            'kd_member': kd_member,
                        },
                        success: function(data) {
                            if (data.response == "success") {
                                $('#status_bayar').removeClass('badge-success');
                                $('#status_bayar').addClass('badge-danger');
                                $('#status_bayar').html('');
                                $('#status_bayar').html('Belum Dibayar');

                                $(".button_edit_bukti").hide();

                                $('#bagian_bukti').hide();
                                $('#bagian_bukti_1').show();

                                $(".flash-data1").html(data.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                        }
                    })
                }
            });

        })

        $(".bkt_penerimaan").click(function() {
            var path = $(".bkt_penerimaan").attr('src');

            $(".bukti-foto").html("Bukti Penerimaan");

            $("#muncul_foto_penerimaan").attr("src", path);
            $("#modal_bukti_penerimaan").modal('show');
        })
        // ---------------------------------------- End Kelola Bukti Pembayaran ----------------------------------------

        // ---------------------------------------- Kelola Scan Kurir ----------------------------------------
        var paramscan = $("#paramscan").html();

        if (paramscan != undefined) {
            let scanner = new Instascan.Scanner({
                video: document.getElementById('preview'),
                mirror: false,
            });
            scanner.addListener('scan', function(content) {
                window.location.href = "<?php echo base_url() ?>order/detail_pesanan_kurir/" + content;
            });

            Instascan.Camera.getCameras().then(function(cameras) {
                // if (cameras.length > 0) {
                //     scanner.start(cameras[0]);
                // } else {
                //     console.error('No Cameras Found');
                // }

                if (cameras.length > 0) {

                    // setting kamera belakang
                    var selectedCam = cameras[0];
                    $.each(cameras, (i, c) => {
                        if (c.name.indexOf('back') != -1) {
                            selectedCam = c;
                            return false;
                        }
                    });

                    scanner.start(selectedCam);
                    // end setting kamera belakang

                    // ini setting kamera depan
                    //     scanner.start(cameras[0]);
                    // end setting kamera depan

                } else {
                    console.error('No cameras found.');
                }

            }).catch(function(e) {
                console.error(e);
            })
        }

        $("#cariDetailOrderKurir").click(function() {
            var kd_order = $("#kd_order").val();

            window.location.href = "<?php echo base_url() ?>order/detail_pesanan_kurir/" + kd_order;
        })
        // ---------------------------------------- End Kelola Scan Kurir ----------------------------------------

        // ---------------------------------------- Kelola Upload Bukti Penerimaan ----------------------------------------

        $("#upload_bukti_penerima").click(function() {

            var kd_order = $("#kd_order").val();
            $("#kd_orderr").val(kd_order);
            $("#ModalUploadPenerimaan").modal("show");

        })

        $("#uploadBuktiPenerimaan").submit(function(e) {
            e.preventDefault();
            let dataString = $('#uploadBuktiPenerimaan').serialize();

            var form_data = new FormData(this);
            form_data.append("userFile", document.getElementById('inputFile').files[0]);

            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = ((evt.loaded / evt.total) * 100);
                            $(".progress-bar").width(Math.round(percentComplete) + '%');
                            $(".progress-bar").html(Math.round(percentComplete) + '%');
                        }
                    }, false);
                    return xhr;
                },
                url: "<?php echo base_url("Order/upload_bukti_penerimaan_barang") ?>",
                type: 'post',
                data: form_data,
                // data: dataString,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $(".progress-bar").width('0%');
                },
                success: function(data) {
                    if (data.toast.response == "success") {
                        $("#ModalUploadPenerimaan").modal('hide');

                        $("#status_order_kurir").html("Selesai");
                        $('#bukti_penerimaan_1').hide();
                        $('#bukti_penerimaan').show();
                        $('#review_penerimaan').attr('src', base_url + '/assets/images/bukti_penerimaan/' + data.bukti_penerimaan);

                        $(".flash-data1").html(data.toast.message);
                        $(".error-data1").html("");
                        toast();

                        setTimeout(function() {
                            window.location.href = "<?php echo base_url() ?>order/list_order_selesai";
                        }, 500);
                    } else {
                        // $('#bagian_bukti').hide();
                        // $('#bagian_bukti_1').show();
                        $(".error-data1").html(data.toast.message);
                        $(".flash-data1").html("");
                        toast();
                    }
                }
            });
        })

        $(".tombol_hapus_penerimaan").click(function() {
            var kd_order = $("#kd_order").val();

            Swal.fire({
                title: "Apa Kamu Yakin Menghapus Bukti Penerimaan?",
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus saja!",
                cancelButtonText: "Batal!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "<?php echo base_url("order/del_bukti_penerimaan") ?>",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            'kd_order': kd_order,
                        },
                        success: function(data) {
                            if (data.response == "success") {
                                var lokasi = lokasi_gambar();

                                $('.bkt_penerimaan').attr('src', lokasi + null);

                                $(".flash-data1").html(data.message);
                                $(".error-data1").html("");
                            } else {
                                $(".error-data1").html(data.message);
                                $(".flash-data1").html("");
                            }
                            toast();
                        }
                    })
                }
            });

        })
        // ---------------------------------------- End Kelola Upload Bukti Penerimaan ----------------------------------------

        // ---------------------------------------- Kelola List Order Kurir ----------------------------------------
        $('#mytableListOrderanKurir').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Order/get_list_order_kurir/ondelivery') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "kd_order",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "cust_name",
                    class: "text_center"
                },
                {
                    data: "cust_phone",
                    class: "text_center"
                },
                {
                    data: "cust_subdistrict",
                    class: "text_center"
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('.list_notifikasi_pengiriman').on('click', '.detail_order', function() {
            let id = $(this).data('id');

            getDetailDataPesananKurir(id, "id");

            $('#detailModal').modal('show');
        });

        $('#mytableListOrderanKurir').on('click', '.detail_order', function() {
            let id = $(this).data('id');

            getDetailDataPesananKurir(id, "id");

            $('#detailModal').modal('show');
        });
        // ---------------------------------------- End Kelola List Order Kurir ----------------------------------------

        // ---------------------------------------- Kelola List Order Kurir Selesai ----------------------------------------
        $('#mytableListOrderanKurirSelesai').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('Order/get_list_order_kurir/done') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "kd_order",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "cust_name",
                    class: "text_center"
                },
                {
                    data: "cust_phone",
                    class: "text_center"
                },
                {
                    data: "cust_subdistrict",
                    class: "text_center"
                },
                {
                    data: "updated_at",
                    class: "text_center",
                    render: function(data, type, row) {
                        return ubah_tanggal(data);
                    },
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytableListOrderanKurirSelesai').on('click', '.edit_order', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("order/get_penerimaan_barang") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_order": id
                },
                success: function(data) {
                    $("#status").val(data.order_status);
                    $("#kd_order").val(data.kd_order);
                    $("#kd_orderr").val(data.kd_order);
                    $('#imgView').attr('src', base_url + "/assets/images/bukti_penerimaan/" + data.bukti_barang_diterima);
                    $('#imgView').hide();
                    $('#imgView').fadeIn(650);
                }
            });

            $('#EditPenerimaan').modal('show');
        });

        $('#mytableListOrderanKurirSelesai').on('click', '.detail_order', function() {
            let id = $(this).data('id');

            getDetailDataPesananKurir(id, "id");

            $('#detailModal').modal('show');
        });

        $("#EditUploadPenerimaan").submit(function(e) {
            e.preventDefault();
            let dataString = $('#EditUploadPenerimaan').serialize();

            $.ajax({
                url: "<?php echo base_url("order/edit_upload_penerimaan") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.response == "success") {
                        $('#EditPenerimaan').modal('hide');
                        $('#mytableListOrderanKurirSelesai').DataTable().ajax.reload();
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.message);
                        $(".flash-data1").html("");
                    }
                    toast();
                }
            });
        })

        // ---------------------------------------- End Kelola List Order Kurir Selesai ----------------------------------------

        // ---------------------------------------- Kelola Detail Data Pesanan Kurir ----------------------------------------

        function getDetailDataPesananKurir(id, jenis) {
            $.ajax({
                url: "<?php echo base_url("order/get_list_detail_order_kurir") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    "kd_order": id,
                    "jenis": jenis
                },
                success: function(data) {
                    var keterangan, warna, ket, Detail1 = "",
                        Detail2 = "",
                        Detail3 = "",
                        Detail4 = "",
                        Detail5 = "";

                    if (data != null) {
                        switch (data.order_member.order_status) {
                            case 'pending':
                                keterangan = "Pending";
                                break;
                            case 'onprocess':
                                keterangan = "Diproses";
                                break;
                            case 'ondelivery':
                                keterangan = "Dikirim";
                                break;
                            case 'rejected':
                                keterangan = "Ditolak";
                                break;
                            case 'done':
                                keterangan = "Selesai";
                                break;
                        }

                        if (data.order_member.payment_status == 0) {
                            warna = "badge badge-danger";
                            ket = "Belum";
                        } else {
                            warna = "badge badge-success";
                            ket = "Sudah";
                        }


                        Detail1 += '<tr>' +
                            '<th class="45%" width="45%">Kode Order</th>' +
                            '<td width="10%">:</td>' +
                            '<td class="45%" width="45%">' + data.order_member.kd_order + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Total Pembayaran</th>' +
                            '<td width="10%">:</td>' +
                            '<td class="45% rupiah-mask" width="45%">' + convertToRupiah(data.order_member.total_transfer) + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Tanggal Order</th>' +
                            '<td width="10%">:</td>' +
                            '<td class="45%" width="45%">' + ubah_tanggal(data.order_member.tgl_order) + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Status Order</th>' +
                            '<td width="10%">:</td>' +
                            '<td class="45%" width="45%" id="status_order_kurir">' + keterangan + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Status Pembayaran</th>' +
                            '<td width="10%">:</td>' +
                            '<td class="45%" width="45%"><span class="' + warna + '" style="padding: 5%;">' + ket + ' Dibayar</span></td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Keterangan Order</th>' +
                            '<th width="10%">:</th>' +
                            '<td width="45%">' + data.order_member.catatan_order + '</td>' +
                            '</tr>';

                        $("#detail_order_kurir_1_semua_pesanan").html(Detail1);
                        $("#detail_order_kurir_1_pesanan_dikirim").html(Detail1);
                        $("#detail_order_kurir_1_pesanan_selesai").html(Detail1);
                        $("#detail_order_kurir_1_pesanan_tertunda").html(Detail1);
                        $("#detail_order_kurir_1_pesanan_diproses").html(Detail1);
                        $("#detail_order_kurir_1").html(Detail1);

                        if (data.order_member.nm_member != null) {
                            Detail2 += '<tr>' +
                                '<th width="45%">Nama Pengirim</th>' +
                                '<td width="10%">:</td>' +
                                '<td width="45%">' + data.order_member.nm_member + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th width="45%">Email</th>' +
                                '<td width="10%">:</td>' +
                                '<td width="45%">' + data.order_member.email + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th width="45%">Telepon</th>' +
                                '<td width="10%">:</td>' +
                                '<td width="45%">' + data.order_member.no_telp + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th width="45%">Kode Pos</th>' +
                                '<td width="10%">:</td>' +
                                '<td width="45%">' + data.order_member.kodepos + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th width="45%">Alamat</th>' +
                                '<td width="10%">:</td>' +
                                '<td width="45%">' + decrypt(data.order_member.alamat) + '</td>' +
                                '</tr>';
                        } else {
                            Detail2 += '<tr>' +
                                '<th width="45%">Nama Pengirim</th>' +
                                '<td width="10%">:</td>' +
                                '<td width="45%">' + data.order_member.cust_name + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th width="45%">Email</th>' +
                                '<td width="10%">:</td>' +
                                '<td width="45%">' + data.order_member.cust_email + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th width="45%">Telepon</th>' +
                                '<td width="10%">:</td>' +
                                '<td width="45%">' + data.order_member.cust_phone + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th width="45%">Kode Pos</th>' +
                                '<td width="10%">:</td>' +
                                '<td width="45%">' + data.order_member.cust_office + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<th width="45%">Alamat</th>' +
                                '<td width="10%">:</td>' +
                                '<td width="45%">' + data.order_member.cust_address + '</td>' +
                                '</tr>';
                        }


                        $("#detail_order_kurir_2_semua_pesanan").html(Detail2);
                        $("#detail_order_kurir_2_pesanan_dikirim").html(Detail2);
                        $("#detail_order_kurir_2_pesanan_selesai").html(Detail2);
                        $("#detail_order_kurir_2_pesanan_tertunda").html(Detail2);
                        $("#detail_order_kurir_2_pesanan_diproses").html(Detail2);
                        $("#detail_order_kurir_2").html(Detail2);

                        Detail3 += '<tr>' +
                            '<th width="45%">Nama Penerima</th>' +
                            '<td width="10%">:</td>' +
                            '<td width="45%">' + data.order_member.cust_name + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Email Penerima</th>' +
                            '<td width="10%">:</td>' +
                            '<td width="45%">' + data.order_member.cust_email + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">No. Telepon Penerima</th>' +
                            '<td width="10%">:</td>' +
                            '<td width="45%">' + data.order_member.cust_phone + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Kode Pos Penerima</th>' +
                            '<td width="10%">:</td>' +
                            '<td width="45%">' + data.order_member.cust_office + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Alamat Penerima</th>' +
                            '<td width="10%">:</td>' +
                            '<td width="45%">' + data.order_member.cust_address + '</td>' +
                            '</tr>';

                        $("#detail_order_kurir_3_semua_pesanan").html(Detail3);
                        $("#detail_order_kurir_3_pesanan_dikirim").html(Detail3);
                        $("#detail_order_kurir_3_pesanan_selesai").html(Detail3);
                        $("#detail_order_kurir_3_pesanan_tertunda").html(Detail3);
                        $("#detail_order_kurir_3_pesanan_diproses").html(Detail3);
                        $("#detail_order_kurir_3").html(Detail3);

                        var layout;
                        if (data.rows_bukti_pembayaran > 0) {
                            layout = '<img id = "review_bukti" src = "' + base_url + '/assets/images/bukti_pembayaran/' + data.bukti_pembayaran.bukti_upload + '" alt = "" srcset = "" >';
                        } else {
                            layout = "Bukti Belum Diupload!";
                        }

                        if (data.order_member.payment_type == "ambil_langsung") {
                            data.order_member.payment_type = "Tunai";
                        }

                        Detail4 += '<tr>' +
                            '<th class="45%" width="45%">Metode Pembayaran</th>' +
                            '<td width="10%">:</td>' +
                            '<td class="45%" width="45%">' + data.order_member.payment_type + '</td>' +
                            '</tr>' +
                            '<tr>' +
                            '<th width="45%">Biaya Pengiriman</th>' +
                            '<td width="10%">:</td>' +
                            '<td class="45% rupiah-mask" width="45%">' + convertToRupiah(data.order_member.ongkir) + '</td>' +
                            '</tr>';

                        if (data.order_member.payment_type == "transfer") {
                            Detail4 += '<tr>' +
                                '<th width="45%">Bukti Transfer</th>' +
                                '<td width="10%">:</td>' +
                                '<td>' + layout + '</td>' +
                                '</tr>';
                        }

                        if (data.order_member.order_status == "done") {

                            if (data.pengiriman) {
                                var display1, display2;
                                data.pengiriman.bukti_barang_diterima != null ? display1 = "" : display1 = "display:none";
                                data.pengiriman.bukti_barang_diterima == null ? display2 = "" : display2 = "display:none";

                                Detail4 += '<tr>' +
                                    '<th width="45%">Tanggal Penerimaan</th>' +
                                    '<td width="10%">:</td>' +
                                    '<td class="45%" width="45%">' + ubah_tanggal(data.pengiriman.updated_at, "jam") + '</td>' +
                                    '</tr>' +
                                    '<tr>' +
                                    '<th width="45%">Bukti Penerimaan Barang</th>' +
                                    '<td width="10%">:</td>' +
                                    '<td id="bukti_penerimaan" style="' + display1 + '">' +
                                    '<img id="review_penerimaan" src="' + lokasi_gambar + data.pengiriman.bukti_barang_diterima + '" alt="" srcset="">' +
                                    '</td>' +
                                    '<td id="bukti_penerimaan_1" style="' + display2 + '">' +
                                    '<span id="bukti_penerimaan_1">' + "Bukti Belum Diupload!" + '</span>' +
                                    '</td>' +
                                    '</tr>';
                            }
                        }

                        $("#detail_order_kurir_4_semua_pesanan").html(Detail4);
                        $("#detail_order_kurir_4_pesanan_dikirim").html(Detail4);
                        $("#detail_order_kurir_4_pesanan_selesai").html(Detail4);
                        $("#detail_order_kurir_4_pesanan_tertunda").html(Detail4);
                        $("#detail_order_kurir_4_pesanan_diproses").html(Detail4);
                        $("#detail_order_kurir_4").html(Detail4);

                        var j = 1;
                        for (let i = 0; i < data.detail_order.length; i++) {
                            Detail5 += '<tr>' +
                                '<td width="3%">' + j + '</td>' +
                                '<td width="35%">' + data.detail_order[i].nm_produk + '</td>' +
                                '<td width="10%">' + (data.detail_order[i].berat_produk + " " + data.detail_order[i].satuan_berat_produk) + '</td>' +
                                '<td width="22%">' + convertToRupiah(data.detail_order[i].harga_produk) + '</td>' +
                                '<td width="8%">' + data.detail_order[i].qty + '</td>' +
                                '<td width="22%">' + convertToRupiah(data.detail_order[i].sub_total) + '</td>' +
                                '</tr>';
                            j++;
                        }

                        $("#detail_order_kurir_5_semua_pesanan").html(Detail5);
                        $("#detail_order_kurir_5_pesanan_dikirim").html(Detail5);
                        $("#detail_order_kurir_5_pesanan_selesai").html(Detail5);
                        $("#detail_order_kurir_5_pesanan_tertunda").html(Detail5);
                        $("#detail_order_kurir_5_pesanan_diproses").html(Detail5);
                        $("#detail_order_kurir_5").html(Detail5);
                    } else {
                        $("#scanorder").hide();
                        $(".error-data1").html("Data Tidak Ditemukan !");
                        $(".flash-data1").html("");
                        toast();
                    }

                }
            });
        }

        // ---------------------------------------- End Kelola Detail Data Pesanan Kurir ----------------------------------------

        $(document).ready(function() {
            var tampungan = [];

            var jmlbarang1 = $("#jmlbarang1").val()
            for (let i = 1; i <= jmlbarang1; i++) {

                $("#ehapusfieldproduk" + i).on("click", function() {
                    $("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

                    var bagianProdukhapus = ($("#bagianProdukhapus" + i));
                    var kd_detail_produk = $("#kd_detail_produk" + i).val();

                    tampungan.push(kd_detail_produk);

                    $("#tampungan_data").val(tampungan);
                    bagianProdukhapus.remove();
                });
            }
        });

        $(document).ready(function() {

            var jmlRecord = $("#jmlRecord").val();
            var tampunganData = [];

            for (let i = 1; i <= jmlRecord; i++) {

                $("#ehapusfieldorder" + i).on("click", function() {
                    var kd_detail = $("#kd_detail" + i).val();
                    tampunganData.push(kd_detail);
                    $("#tampunganDataHapus").val(tampunganData);

                    // var subTotal = $("#sub_total" + i).val();
                    // var diskon = $("#diskon" + i).val();
                    // var totalHarga = $("#total_harga").val();

                    // if (subTotal == "" || subTotal == undefined) {
                    //     subTotal = 0;
                    // }

                    // var selisih = parseInt(totalHarga) - parseInt(subTotal - diskon);
                    // $("#total_harga").val(selisih);

                    $("#jmlbarang1").val(parseInt($("#jmlbarang1").val()) - 1);

                    $(this).parents("#bagianProdukhapus" + i).remove();

                    hitungTotalHargaDariQty();
                });

                function hitungTotalHargaDariQty() {
                    var harga = $("#harga_produk" + i).val();
                    var diskon = $("#diskon" + i).val();
                    var diskonn = $("#diskonn" + i).val();
                    var qty = $("#qty" + i).val();
                    var jmlkomisi = $("#jmlkomisii" + i).val();
                    var maxGroupbarang = $("#jmlbarang").val();

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

                    $("#sub_total" + i).val(parseInt(harga * qty) - $("#diskon" + i).val());

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

                    $.ajax({
                        url: "<?php echo base_url("konfigurasi/getKonfigurasi") ?>",
                        type: 'post',
                        dataType: 'json',
                        success: function(dta) {
                            var jrk = $("#jarak").val();
                            var jarak = jrk.replace(" KM", "");
                            if (jarak <= parseFloat(5) && pilihan_kurir == "CateringKita") {
                                if (myTotal >= dta.max_harga_pesanan) {
                                    $("#ongkir_utama").val(0);
                                } else if (myTotal < dta.max_harga_pesanan) {
                                    $("#ongkir_utama").val(dta.harga_ongkir_minimal);
                                }
                            } else if (myTotal >= dta.max_harga_pesanan_kedua && pilihan_kurir == "CateringKita") {
                                var subregion = $("#subregion").val();
                                var jrk = $("#jarak").val();
                                var nbrhd = $("#nbrhd").val();
                                var jarak = jrk.replace(" KM", "");
                                var city = $("#city").val();

                                $.ajax({
                                    url: "<?php echo base_url("konfigurasi/get_ongkir_khususs") ?>",
                                    type: 'post',
                                    dataType: 'json',
                                    data: {
                                        subregion: subregion,
                                        nbrhd: nbrhd,
                                        city: city,
                                    },
                                    success: function(data) {

                                        if (subregion == data.ongkir.nama_daerah) {
                                            if (data.ong_khusus) {
                                                ongkir = data.ong_khusus.nominal_ongkir2;
                                            } else {
                                                ongkir = data.ongkir.ongkir2;
                                            }
                                        } else {
                                            alert("ongkir Diluar Data Yang Disetting");
                                        }

                                        $('#ongkir_utama').val(ongkir);
                                    }
                                });
                            } else if (myTotal < dta.max_harga_pesanan_kedua && pilihan_kurir == "CateringKita") {
                                var subregion = $("#subregion").val();
                                var jrk = $("#jarak").val();
                                var nbrhd = $("#nbrhd").val();
                                var jarak = jrk.replace(" KM", "");
                                var city = $("#city").val();

                                $.ajax({
                                    url: "<?php echo base_url("konfigurasi/get_ongkir_khususs") ?>",
                                    type: 'post',
                                    dataType: 'json',
                                    data: {
                                        subregion: subregion,
                                        nbrhd: nbrhd,
                                        city: city,
                                    },
                                    success: function(data) {

                                        if (subregion == data.ongkir.nama_daerah) {
                                            if (data.ong_khusus) {
                                                ongkir = data.ong_khusus.nominal_ongkir1;
                                            } else {
                                                ongkir = data.ongkir.ongkir1;
                                            }
                                        } else {
                                            alert("ongkir Diluar Data Yang Disetting");
                                        }

                                        $('#ongkir_utama').val(ongkir);
                                    }
                                });
                            }
                        }
                    })

                    setTimeout(() => {
                        ongkir = parseInt($("#ongkir_utama").val());
                        var pathparts = location.pathname.split("/");
                        var link1 = pathparts[2];
                        var link2 = pathparts[3];

                        if (link1 == "linkreseller" || (link1 == "pesanan" && link2 == "reseller_login")) {
                            ongkir = parseInt($("#ongkir_utama").val());
                        }

                        if (isNaN(ongkir)) ongkir = 0;
                        $("#jmlkomisi" + i).val(parseInt(jmlkomisi) * parseInt(qty));
                        var diskonTambahan = $("#diskon_tambahan").val();
                        if (isNaN(diskonTambahan)) diskonTambahan = 0;
                        var totalDiskon = parseInt(myTotalDiskon) + parseInt(diskonTambahan);
                        $("#total_harga").val(parseInt(myTotal - diskonTambahan) + parseInt(ongkir));
                        if (parseInt($("#total_harga").val()) < 0) {
                            $("#total_harga").val(0);
                        }
                    }, 500);
                }

            }
        })


        $('#checkbox_stok').hide();
        $('#checkboxpelanggan').click(function() {
            var pelanggan_baru = $('.pelanggan_baru').val();
            if ($(this).prop("checked") == true) {
                $('#pelanggansatu').hide(500);
                $('#pelangganbanyak').show(500);
                $('#member1').prop('required', false);
                $('#member_banyak1').prop('required', true);
                $('#member1').val("").trigger('change');
                $('.banyak_pelanggan').val(1);
                if (pelanggan_baru == 1) {
                    $('.pelanggan_baru').val(0);
                    $('#checkboxmember').prop("checked", false);
                }
            } else {
                $('#bagianpelangganbanyak').html("");
                $('#pelangganbanyak').hide(500);
                $('#pelanggansatu').show(500);
                $('#member_banyak1').prop('required', false);
                $('#member1').prop('required', true);
                $('#member_banyak1').val("").trigger('change');
                $('.banyak_pelanggan').val(0);
                if (pelanggan_baru == 1) {
                    $('.pelanggan_baru').val(0);
                    $('#checkboxmember').prop("checked", false);
                }
            }
        });

        $('#checkboxmember').click(function() {
            if ($(this).prop("checked") == true && $("#checkboxalamat").prop("checked") == true) {
                $('#memberselect2').hide(500);
                $('#tnpmember').hide(500);
                $('#newmember').show(500);
                $("#checkmembervalue").prop('required', true);

                $("#alamatbaru").hide(500);
                $("#alamatutama").hide(500);
                $("#alamatlain").show(500);

                $("#checkboxmemberr").removeClass("d-none");
                $("#checkboxmemberr").addClass("d-inline");

                $("#kecamatan_baru").prop('required', true);
                $('.pelanggan_baru').val(1);
                $('.alamat_lain').val(1);

                HitungOngkirdanSubTotal($("#ongkir_lain").val());
            } else if ($(this).prop("checked") == true) {
                $('#memberselect2').hide(500);
                $('#tnpmember').hide(500);
                $('#newmember').show(500);
                $("#checkmembervalue").prop('required', true);

                $("#alamatbaru").show(500);
                $("#alamatutama").hide(500);
                $("#alamatlain").hide(500);

                $("#checkboxmemberr").addClass("d-none");
                $("#checkboxmemberr").removeClass("d-inline");

                $("#kecamatan_baru").prop('required', true);
                $('.pelanggan_baru').val(1);
                $('.alamat_lain').val(0);

                HitungOngkirdanSubTotal($("#ongkir_baru").val());
            } else if ($("#checkboxalamat").prop("checked") == true) {
                $('#memberselect2').show(500);
                $('#tnpmember').show(500);
                $('#newmember').hide(500);
                $("#checkmembervalue").prop('required', false);

                $("#alamatbaru").hide(500);
                $("#alamatutama").hide(500);
                $("#alamatlain").show(500);

                $("#checkboxmemberr").removeClass("d-none");
                $("#checkboxmemberr").addClass("d-inline");

                $("#kecamatan_baru").prop('required', false);

                HitungOngkirdanSubTotal($("#ongkir_lain").val());
                $('.pelanggan_baru').val(0);
                $('.alamat_lain').val(1);

            } else {
                $('#memberselect2').show(500);
                $('#tnpmember').show(500);
                $('#newmember').hide(500);
                $("#checkmembervalue").prop('required', false);

                $("#alamatbaru").hide(500);
                $("#alamatutama").show(500);
                $("#alamatlain").hide(500);

                $("#checkboxmemberr").addClass("d-none");
                $("#checkboxmemberr").removeClass("d-inline");

                $("#kecamatan_baru").prop('required', false);

                $('.pelanggan_baru').val(0);
                $('.alamat_lain').val(0);

                HitungOngkirdanSubTotal($("#ongkir_utama").val());

            }
        });

        $('#checkboxalamat').click(function() {
            var pelanggan_baru = $('.pelanggan_baru').val();
            if ($("#checkboxmember").prop("checked") == true && $(this).prop("checked") == true || $(this).prop("checked") == true) {
                $("#alamatbaru").hide(500);
                $("#alamatutama").hide(500);
                $("#alamatlain").show(500);

                $("#checkboxmemberr").removeClass("d-none");
                $("#checkboxmemberr").addClass("d-inline");

                if (pelanggan_baru == 1) {
                    $('.pelanggan_baru').val(1);
                }
                $('.alamat_lain').val(1);

                HitungOngkirdanSubTotal($("#ongkir_lain").val());
            } else if ($("#checkboxmember").prop("checked") == true) {
                $("#alamatbaru").show(500);
                $("#alamatutama").hide(500);
                $("#alamatlain").hide(500);

                $("#checkboxmemberr").addClass("d-none");
                $("#checkboxmemberr").removeClass("d-inline");
                $('.pelanggan_baru').val(1);
                $('.alamat_lain').val(0);

                HitungOngkirdanSubTotal($("#ongkir_baru").val());
            } else {
                $("#alamatbaru").hide(500);
                $("#alamatutama").show(500);
                $("#alamatlain").hide(500);

                $("#checkboxmemberr").addClass("d-none");
                $("#checkboxmemberr").removeClass("d-inline");

                $('.pelanggan_baru').val(0);
                $('.alamat_lain').val(0);

                HitungOngkirdanSubTotal($("#ongkir_utama").val());
            }
        });

        $('#checkboxsosmed').click(function() {
            if ($(this).prop("checked") == true) {
                $('#socialmedia').show(500);
            } else if ($(this).prop("checked") == false) {
                $('#socialmedia').hide(500);
            }
        });

        $('#checkboxsosmed_edit').click(function() {
            if ($(this).prop("checked") == true) {
                $('#socialmedia_edit').show(500);
            } else if ($(this).prop("checked") == false) {
                $('#socialmedia_edit').hide(500);
            }
        });

        $('#kd_pengirim').on('click', function() {
            $.ajax({
                url: base_url + "/selera_express/get_kd_pengirim",
                type: "post",
                dataType: "json",
                success: function(result) {
                    $('#kd_member_pengirim').val(result.kd_member);
                }
            });
        });

        $("#checktnpmember").change(function() {
            var checktnpmember = $("#checktnpmember").val();
            if (checktnpmember == "ya") {
                $('#tnpmember').addClass("col-md-6 col-xs-6 col-6");
                $('#tnpmember').removeClass("col-md-12 col-xs-12 col-12");

                $("#dgnmember").show(500);
            } else {
                $("#dgnmember").hide();

                $('#tnpmember').removeClass("col-md-6 col-xs-6 col-6");
                $('#tnpmember').addClass("col-md-12 col-xs-12 col-12");


            }
        })

        $('#kd_penerima').on('click', function() {
            $.ajax({
                url: base_url + "/selera_express/get_kd_penerima",
                type: "post",
                dataType: "json",
                success: function(result) {
                    $('#kd_member_penerima').val(result.kd_member);
                }
            });
        });

        $('#asuransi_check').click(function() {
            var total = $('#total').val();
            $.ajax({
                url: base_url + "/selera_express/get_konfigurasi",
                type: "post",
                dataType: "json",
                success: function(result) {
                    if ($('#asuransi_check').prop("checked") == true) {
                        $('#asuransi').val(result.asuransi);
                        var total_harga = parseInt(total) + parseInt(result.asuransi);
                        $('#total_harga').html(convertToRupiah(total_harga));
                        $('#asuransi_view').html(convertToRupiah(result.asuransi));
                        $('#total').val(total_harga);
                    } else if ($('#asuransi_check').prop("checked") == false) {
                        $('#asuransi').val(0);
                        $('#asuransi_view').html('-');
                        var total_harga = parseInt(total) - parseInt(result.asuransi);
                        $('#total').val(total_harga);
                        $('#total_harga').html(convertToRupiah(total_harga));
                    }
                }
            });


        });

        $('#berat').on('keyup', function() {
            var berat = $('#berat').val();
            var panjang = $('#panjang').val();
            var lebar = $('#lebar').val();
            var tinggi = $('#tinggi').val();
            if (panjang != "" || lebar != "" || tinggi != "") {
                var total = panjang * tinggi * lebar / 6000;
                if (berat <= total) {
                    var hasil = Math.round(total);
                } else {
                    var hasil = berat;
                }
            } else {
                var hasil = berat;
            }
            $('#berat_terhitung').html(Math.round(hasil) + " Kg");
            $('#total_berat').val(Math.round(hasil));
            $.ajax({
                url: base_url + "/selera_express/get_konfigurasi",
                type: "post",
                dataType: "json",
                success: function(result) {
                    var harga = result.harga_per_kg;
                    var ongkos_kirim = Math.round(hasil) * harga;
                    $('#ongkos_kirim').html(convertToRupiah(ongkos_kirim));
                    $('#ongkos_kirim_val').val(ongkos_kirim);
                    var asuransi = $('#asuransi').val();
                    var total_harga = parseInt(ongkos_kirim) + parseInt(asuransi);
                    $('#total_harga').html(convertToRupiah(total_harga));
                    $('#total').val(total_harga);
                    if (parseInt(berat) > parseInt(result.max_berat)) {
                        $(".error-data1").html("Max Berat Tidak Boleh Lebih Dari " + result.max_berat);
                        toast();
                        $('#berat').val(null);
                        $('#berat_terhitung').html('-');
                        $('#ongkos_kirim').html('-');
                        $('#total_harga').html('-');
                    }
                }
            });
        });

        $('#panjang').on('keyup', function() {
            var berat = $('#berat').val();
            var panjang = $('#panjang').val();
            var lebar = $('#lebar').val();
            var tinggi = $('#tinggi').val();
            if (panjang != "") {
                if (panjang != "" && lebar == "" && tinggi == "") {
                    var total = panjang * 1 * 1 / 6000;
                    if (berat <= total) {
                        var hasil = Math.round(total);
                    } else {
                        var hasil = berat;
                    }
                } else if (panjang != "" && lebar != "" && tinggi == "") {
                    var total = panjang * lebar * 1 / 6000;
                    if (berat <= total) {
                        var hasil = Math.round(total);
                    } else {
                        var hasil = berat;
                    }
                } else if (panjang != "" && lebar == "" && tinggi != "") {
                    var total = panjang * tinggi * 1 / 6000;
                    if (berat <= total) {
                        var hasil = Math.round(total);
                    } else {
                        var hasil = berat;
                    }
                } else if (panjang != "" && lebar != "" && tinggi != "") {
                    var total = panjang * lebar * tinggi / 6000;
                    if (berat <= total) {
                        var hasil = Math.round(total);
                    } else {
                        var hasil = berat;
                    }
                }
            } else {
                var hasil = berat;
            }
            $('#berat_terhitung').html(Math.round(hasil) + " Kg");
            $('#total_berat').val(Math.round(hasil));
            $.ajax({
                url: base_url + "/selera_express/get_konfigurasi",
                type: "post",
                dataType: "json",
                success: function(result) {
                    var harga = result.harga_per_kg;
                    var ongkos_kirim = Math.round(hasil) * harga;
                    $('#ongkos_kirim').html(convertToRupiah(ongkos_kirim));
                    $('#ongkos_kirim_val').val(ongkos_kirim);
                    var asuransi = $('#asuransi').val();
                    var total_harga = parseInt(ongkos_kirim) + parseInt(asuransi);
                    $('#total_harga').html(convertToRupiah(total_harga));
                    $('#total').val(total_harga);
                    if (parseInt(panjang) > parseInt(result.max_panjang)) {
                        $(".error-data1").html("Max Panjang Tidak Boleh Lebih Dari " + result.max_panjang);
                        toast();
                        $('#panjang').val(null);
                        $('#berat_terhitung').html('-');
                        $('#ongkos_kirim').html('-');
                        $('#total_harga').html('-');
                    }
                }
            });
        });

        $('#lebar').on('keyup', function() {
            var berat = $('#berat').val();
            var panjang = $('#panjang').val();
            var lebar = $('#lebar').val();
            var tinggi = $('#tinggi').val();
            if (lebar != "") {
                if (panjang == "" && lebar != "" && tinggi == "") {
                    var total = lebar * 1 * 1 / 6000;
                    if (berat <= total) {
                        var hasil = Math.round(total);
                    } else {
                        var hasil = berat;
                    }
                } else if (panjang != "" && lebar != "" && tinggi == "") {
                    var total = panjang * lebar * 1 / 6000;
                    if (berat <= total) {
                        var hasil = Math.round(total);
                    } else {
                        var hasil = berat;
                    }
                } else if (panjang == "" && lebar != "" && tinggi != "") {
                    var total = tinggi * lebar * 1 / 6000;
                    if (berat <= total) {
                        var hasil = Math.round(total);
                    } else {
                        var hasil = berat;
                    }
                } else if (panjang != "" && lebar != "" && tinggi != "") {
                    var total = panjang * lebar * tinggi / 6000;
                    if (berat <= total) {
                        var hasil = Math.round(total);
                    } else {
                        var hasil = berat;
                    }
                }
            } else {
                var hasil = berat;
            }

            $('#berat_terhitung').html(Math.round(hasil) + " Kg");
            $('#total_berat').val(Math.round(hasil));
            $.ajax({
                url: base_url + "/selera_express/get_konfigurasi",
                type: "post",
                dataType: "json",
                success: function(result) {
                    var harga = result.harga_per_kg;
                    var ongkos_kirim = Math.round(hasil) * harga;
                    $('#ongkos_kirim').html(convertToRupiah(ongkos_kirim));
                    $('#ongkos_kirim_val').val(ongkos_kirim);
                    var asuransi = $('#asuransi').val();
                    var total_harga = parseInt(ongkos_kirim) + parseInt(asuransi);
                    $('#total_harga').html(convertToRupiah(total_harga));
                    $('#total').val(total_harga);
                    if (parseInt(lebar) > parseInt(result.max_lebar)) {
                        $(".error-data1").html("Max Lebar Tidak Boleh Lebih Dari " + result.max_lebar);
                        toast();
                        $('#lebar').val(null);
                        $('#berat_terhitung').html('-');
                        $('#ongkos_kirim').html('-');
                        $('#total_harga').html('-');
                    }
                }
            });
        });

        $('#tinggi').on('keyup', function() {
            var berat = $('#berat').val();
            var panjang = $('#panjang').val();
            var lebar = $('#lebar').val();
            var tinggi = $('#tinggi').val();
            if (tinggi != "") {
                if (panjang == "" && lebar == "" && tinggi != "") {
                    var total = tinggi * 1 * 1 / 6000;
                    if (berat <= total) {
                        var hasil = Math.round(total);
                    } else {
                        var hasil = berat;
                    }
                } else if (panjang == "" && lebar != "" && tinggi != "") {
                    var total = tinggi * lebar * 1 / 6000;
                    if (berat <= total) {
                        var hasil = Math.round(total);
                    } else {
                        var hasil = berat;
                    }
                } else if (panjang != "" && lebar == "" && tinggi != "") {
                    var total = tinggi * panjang * 1 / 6000;
                    if (berat <= total) {
                        var hasil = Math.round(total);
                    } else {
                        var hasil = berat;
                    }
                } else if (panjang != "" && lebar != "" && tinggi != "") {
                    var total = panjang * lebar * tinggi / 6000;
                    if (berat <= total) {
                        var hasil = Math.round(total);
                    } else {
                        var hasil = berat;
                    }
                }
            } else {
                var hasil = berat;
            }

            $('#berat_terhitung').html(Math.round(hasil) + " Kg");
            $('#total_berat').val(Math.round(hasil));
            $.ajax({
                url: base_url + "/selera_express/get_konfigurasi",
                type: "post",
                dataType: "json",
                success: function(result) {
                    var harga = result.harga_per_kg;
                    var ongkos_kirim = Math.round(hasil) * harga;
                    $('#ongkos_kirim').html(convertToRupiah(ongkos_kirim));
                    $('#ongkos_kirim_val').val(ongkos_kirim);
                    var asuransi = $('#asuransi').val();
                    var total_harga = parseInt(ongkos_kirim) + parseInt(asuransi);
                    $('#total_harga').html(convertToRupiah(total_harga));
                    $('#total').val(total_harga);
                    if (parseInt(tinggi) > parseInt(result.max_tinggi)) {
                        $(".error-data1").html("Max Tinggi Tidak Boleh Lebih Dari " + result.max_tinggi);
                        toast();
                        $('#tinggi').val(null);
                        $('#berat_terhitung').html('-');
                        $('#ongkos_kirim').html('-');
                        $('#total_harga').html('-');
                    }
                }
            });
        })

        // ------------------------------------------ Bagian Reseller -------------------------------------------

        // ---------------------------------------- Kelola Upload Bukti Transfer Reseller ----------------------------------------

        $('#mytableUploadBuktiTransfer').DataTable({
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?php echo base_url('order/get_upload_bukti_tf') ?>",
                type: 'post',
                dataType: 'json'
            },
            "columns": [{
                    data: "kd_order",
                    class: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "tgl_order",
                    class: "text_center",
                    render: function(data, type, row) {
                        return ubah_tanggal(data);
                    },
                },
                {
                    data: "kd_order",
                    class: "text_center"
                },
                {
                    data: "cust_name",
                    class: "text_center"
                },
                {
                    data: "cust_phone",
                    class: "text_center"
                },
                {
                    data: "total_harga",
                    class: "text_center",
                    render: function(data, type, row) {
                        return convertToRupiah(data);
                    },
                },
                {
                    data: "aksi",
                    class: "text-center",
                    width: 150,
                    orderable: false
                }
            ],
        });

        $('#mytableUploadBuktiTransfer').on('click', '.detail_bukti', function() {
            let id = $(this).data('id');

            getDetailDataPesananKurir(id, "id");

            $('#detailModaltf').modal('show');
        });

        $('#mytableUploadBuktiTransfer').on('click', '.upload_bukti', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "<?php echo base_url("order/getOrderById") ?>",
                type: 'post',
                dataType: 'json',
                data: {
                    kd_order: id,
                },
                success: function(data) {
                    if (data.bukti_upload) {
                        $("#status_tf").val("Menunggu Konfirmasi Admin!");
                        $('#imgViewBuktiTf').attr('src', base_url + '/assets/images/bukti_pembayaran/' + data.bukti_upload);
                    } else {
                        $("#status_tf").val("Belum Diupload!");
                        $('#imgViewBuktiTf').attr('src', base_url + '/assets/images/no-image.png');
                    }
                    $("#kd_order").val(id);
                    $("#total_tf").val(data.total_transfer);
                }
            })
        });

        // ---------------------------------------- End Kelola Upload Bukti Transfer Reseller ----------------------------------------
    });

    $(function() {
        $('#rangepicker').daterangepicker({
            opens: 'right'
        }, function(start, end, label) {});
    });
    $(function() {
        $('#copy_datepickersingle').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            locale: {
                format: 'YYYY-MM-DD'
            },
            maxYear: parseInt(moment().format('YYYY'), 10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
        });
        $('#copy_datepickersingle1').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            locale: {
                format: 'YYYY-MM-DD'
            },
            maxYear: parseInt(moment().format('YYYY'), 10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
        });
        $('#datepickersingle').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            locale: {
                format: 'YYYY-MM-DD'
            },
            maxYear: parseInt(moment().format('YYYY'), 10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
        });

        $('#datepickersingle1').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            locale: {
                format: 'YYYY-MM-DD'
            },
            maxYear: parseInt(moment().format('YYYY'), 10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
        });

        $('#edit_datepickersingle').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            locale: {
                format: 'YYYY-MM-DD'
            },
            maxYear: parseInt(moment().format('YYYY'), 10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
        });

        $('#edit_datepickersingle1').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            locale: {
                format: 'YYYY-MM-DD'
            },
            maxYear: parseInt(moment().format('YYYY'), 10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
        });

        $('#tanggal_produk_masuk').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            locale: {
                format: 'YYYY-MM-DD'
            },
            maxYear: parseInt(moment().format('YYYY'), 10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
        });

        //Datemask dd/mm/yyyy
        $('.datemask').inputmask('yyyy-mm-dd', {
            'placeholder': 'yyyy-mm-dd'
        })

    });

    $(function() {
        $('#datepickercoba').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            locale: {
                format: 'YYYY-MM-DD'
            },
            maxYear: parseInt(moment().format('YYYY'), 10)
        }, function(start, end, label) {
            var years = moment().diff(start, 'years');
        });
    });


    $('#btn-upload-logo').on('click', function() {
        $('#file-input-logo').click();
    });

    $("#file-input-logo").change(function() {
        readURL(this, "logo");
    });

    $('#btn-upload-invoice').on('click', function() {
        $('#file-input-invoice').click();
    });

    $("#file-input-invoice").change(function() {
        readURL(this, "invoice");
    });

    $('#btn-uploadimg').on('click', function() {
        $('#file-input-produk').click();
    });

    $('#file-input-produk').change(function() {
        readURL(this, "produk");
    });

    function bacaGambar(input) {
        var maxW = 400;
        var maxH = 400;
        var ratio = 0;
        var dratio = 0;
        var mtop = 0;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var gambar = $('<img/>');

            reader.onload = function(e) {
                var image = new Image();
                image.src = e.target.result;
                image.onload = function() {
                    $('.imgcroparea').empty();
                    var width = this.width;
                    var height = this.height;

                    if ((width > height) && (width > maxW)) {
                        // horizontal persegi panjang
                        ratio = maxW / width;
                        this.width = (width * ratio) - 3;
                        this.height = (this.width * (height / width)) - 3;
                        mtop = (400 - this.height) / 2;
                    }
                    if ((height > width) && (height > maxH)) {
                        // vertical persegi panjang
                        ratio = maxH / height;
                        this.height = (height * ratio) - 3;
                        this.width = (this.height * (width / height)) - 3;
                    }
                    $('.imgcroparea').append(this);
                    // $('#imgwidth').val(this.width);
                    // $('#imgheight`').val(this.height);
                    $(this).attr('style', 'margin-top: ' + mtop + 'px !important');

                }
                $('#feature_photo').val(e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            var ketFoto = $("#ketfoto").val();
            var tampungan = [];
            if (ketFoto != "") {
                tampungan.push(ketFoto);
            }
            tampungan.push("utama");
            $("#ketfoto").val(tampungan);
        }
    }

    function readURL(input, param) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview-' + param).attr('src', e.target.result);
                $('#image-preview-' + param).hide();
                $('#image-preview-' + param).fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    var render = document.querySelector('.feedback');
    CheckForce('#password_edit1').checkPassword(function(response) {
        render.innerHTML = response.content;
    });

    CheckForce('#password_edit1', {
        BootstrapTheme: true
    }).checkPassword(function(response) {
        render.innerHTML = response.content;
    });

    CheckForce('#password_edit1', {
        MaterializeTheme: true
    }).checkPassword(function(response) {
        render.innerHTML = response.content;
    });

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

    $('#retype_password_edit').on('keyup', function() {
        var password = $('#password_edit1').val();
        var repassword = $('#retype_password_edit').val();
        if (password != null) {
            repassword == password ? $('#password_edit1').removeClass('is-invalid') : $('#password_edit1').removeClass('is-valid');
            repassword == password ? $('#retype_password_edit').removeClass('is-invalid') : $('#retype_password_edit').removeClass('is-valid');
            repassword == password ? $('#password_edit1').addClass('is-valid') : $('#password_edit1').addClass('is-invalid');
            repassword == password ? $('#retype_password_edit').addClass('is-valid') : $('#retype_password_edit').addClass('is-invalid');
        }
    });

    $('#checkboxpass').click(function() {
        var x = document.getElementById("password_edit1");
        var y = document.getElementById("retype_password_edit");
        if ($(this).prop("checked") == false) {
            x.type = "password";
            y.type = "password";
        } else if ($(this).prop("checked") == true) {
            x.type = "text";
            y.type = "text";
        }
    });

    $("#editProfile").click(function() {
        var password = $("#password_edit1").val();
        var repassword = $("#retype_password_edit").val();

        var pwd = /^(?=.*[a-z])/;
        var pwd1 = /^(?=.*[A-Z])/;
        var pwd2 = /^(?=.*[0-9])/;

        if (password.length > 0) {
            if (password.length > 0 && password.length < 8) {
                $(".error-data1").html("Password Minimal Harus Tidak Kurang Dari 8 Karakter !");
                toast();
                return false;
            }
            if (pwd.test(password) == false) {
                $(".error-data1").html("Password Harus Disertai Huruf Kecil !");
                toast();
                return false;
            } else if (pwd1.test(password) == false) {
                $(".error-data1").html("Password Harus Disertai Huruf Besar/Kapital !");
                toast();
                return false;
            } else if (pwd2.test(password) == false) {
                $(".error-data1").html("Password Harus Disertai Dengan Number !");
                toast();
                return false;
            } else if (password != repassword) {
                $(".error-data1").html("New Password dan Retype New Password Tidak Sama !");
                toast();
                return false;
            }
        }
    })
</script>