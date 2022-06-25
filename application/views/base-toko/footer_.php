<!-- Footer -->
<footer class="bg-white border-bottom border-top">
   <div class="container">
      <div class="row no-gutters">
         <div class="col-md-8">
            <div class="border-right py-5 pr-5">
               <h6 class="mt-0 mb-4 f-14 text-dark font-weight-bold">KATEGORI TERATAS</h6>
               <div class="row no-gutters">
                  <div class="col-12">
                     <ul class="list-unstyled mb-0 row">
                        <?php
                        $kat = $this->db->get_where('kategori', ['nm_kategori' => "Custom"])->row_array();
                        $kat1 = $this->db->get_where('kategori', ['nm_kategori' => "Paket Khusus"])->row_array();
                        $this->db->select('*');
                        $this->db->from('kategori');
                        $this->db->where(['kd_kategori!=' => $kat['kd_kategori']]);
                        $this->db->where(['kd_kategori!=' => $kat1['kd_kategori']]);
                        $this->db->order_by("nm_kategori", "ASC");
                        $kategori = $this->db->get()->result_array(); ?>
                        <?php foreach ($kategori as $k) { ?>
                           <div class="col-md-4 col-xs-4 col-4">
                              <li><a href="javascript:void(0)" data-id="<?= base64_encode(encrypt($k['kd_kategori'])) ?>" class="produk_kategori">
                                    <?= $k['nm_kategori'] ?>
                                 </a>
                              </li>
                           </div>
                        <?php } ?>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-4">
            <div class="py-5 pl-5">
               <h6 class="mb-4 f-14 text-dark font-weight-bold">Social Media</h6>
               <?php
               $konfigurasi = $this->db->get('konfigurasi')->row_array();
               ?>
               <div class="footer-social">
                  <a class="btn-facebook" target="_blank" href="<?= $konfigurasi['facebook'] ?>"><i class="icofont-facebook"></i></a>
                  <a class="btn-twitter" target="_blank" href="<?= $konfigurasi['twitter'] ?>"><i class="icofont-twitter"></i></a>
                  <a class="btn-instagram" target="_blank" href="<?= $konfigurasi['instagram'] ?>"><i class="icofont-instagram"></i></a>
                  <a class="btn-whatsapp" target="_blank" href="https://api.whatsapp.com/send?phone=<?= $konfigurasi['no_hp'] ?>"><i class="icofont-whatsapp"></i></a>
               </div>
            </div>
         </div>
      </div>
   </div>
</footer>

<div class="copyright bg-light py-3">
   <div class="container">
      <div class="row">
         <div class="col-md-6 d-flex align-items-center">
            <p class="mb-0">© Copyright <?= date('Y') ?> <a href="<?= base_url('main') ?>"><?= $konfigurasi['nama_toko'] ?></a> . All Rights Reserved
            </p>
         </div>
      </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Search...</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <input class="form-control form-control-lg mb-3" type="text" id="searchProduct1" placeholder="Cari Nama Menu" autocomplete="off">
         </div>

      </div>
   </div>
</div>

<div class="footer-fix-nav shadow">
   <div class="row">
      <div class="col">
         <a href="<?= base_url('main') ?>"><i class="icofont icofont-home"></i></a>
      </div>
      <div class="col border-0">
         <a type="button" data-toggle="modal" data-target="#exampleModalCenter" href="#"><i class="icofont icofont-search"></i></a>
      </div>
      <div class="col active">
         <a href="<?= base_url('catering/profile') ?>"><i class="icofont icofont-user"></i></a>
      </div>
      <?php if (!$this->session->userdata('kd_member')) { ?>
         <div class="col">
            <a href="#" data-target="#login" data-toggle="modal" style="font-size: 16px; padding-top: 7px;"><i class="icofont icofont-login"></i> Login</a>
         </div>
      <?php } else { ?>
         <div class="col">
            <a href="<?= base_url('main/logout_pelanggan') ?>" class="tombol_logout" style="font-size: 16px; padding-top: 7px;"><i class="icofont icofont-logout"></i> Logout</a>
         </div>
      <?php } ?>
      <div class="col cart-nav">
         <a href="javascript:void(0)" data-toggle="offcanvas" class="nav-link">
            <i class="fa fa-shopping-cart"></i>
            <?php $count = count($this->cart->contents()); ?>
            <span class="badge badge-danger" id="total_cart_mbl"><?= $count ?></span>
         </a>
      </div>
   </div>
</div>
<nav id="main-nav">
   <ul class="second-nav">
      <li class="store">
         <span>Kategori</span>
         <ul>
            <?php
            $kat = $this->db->get_where('kategori', ['nm_kategori' => "Custom"])->row_array();
            $kat1 = $this->db->get_where('kategori', ['nm_kategori' => "Paket Khusus"])->row_array();
            $this->db->select('*');
            $this->db->from('kategori');
            $this->db->where(['kd_kategori!=' => $kat['kd_kategori']]);
            $this->db->where(['kd_kategori!=' => $kat1['kd_kategori']]);
            $this->db->order_by("nm_kategori", "ASC");
            $kategori = $this->db->get()->result_array(); ?>
            <?php foreach ($kategori as $k) { ?>
               <li class="store">
                  <a href="javascript:void(0)" class="produk_kategori" data-id="<?= base64_encode(encrypt($k['kd_kategori'])) ?>"><?= $k['nm_kategori'] ?></a>
               </li>
            <?php } ?>
         </ul>
      </li>

      <li class="magazines">
         <span>Halaman</span>
         <ul>
            <li><a href="<?= base_url('catering/product') ?>">Daftar Menu </a></li>
            <li><a href="<?= base_url('catering/about') ?>">Tentang Kami</a></li>
            <!-- <li><a href="<?= base_url('catering/FAQ') ?>">FAQ</a></li> -->
            <li><a href="<?= base_url('catering/contact') ?>">Kontak Kami</a></li>
         </ul>
      </li>

   </ul>
   <ul class="bottom-nav">
      <li class="github">
         <a class="btn-whatsapp" target="_blank" href="https://api.whatsapp.com/send?phone=<?= $konfigurasi['no_hp'] ?>"><i class="icofont-whatsapp"></i></a>
      </li>
      <li class="email">
         <a class="btn-instagram" target="_blank" href="<?= $konfigurasi['instagram'] ?>"><i class="icofont-instagram"></i></a>
      </li>
      <li class="email">
         <a class="" target="_blank" href="<?= $konfigurasi['facebook'] ?>"><i class="icofont-facebook"></i></a>
      </li>
   </ul>

</nav>

<div class="cart-sidebar" id="bagian_keranjang">
   <?php $this->load->view('catering/keranjang') ?>
</div>
<!-- Bootstrap core JavaScript -->
<script src="<?= base_url() ?>assets/toko_/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/toko_/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- select2 Js -->
<script src="<?= base_url() ?>assets/toko_/vendor/select2/js/select2.min.js"></script>
<!-- Owl Carousel -->
<script src="<?= base_url() ?>assets/toko_/vendor/owl-carousel/owl.carousel.js"></script>
<!-- Slider Js -->
<script src="<?= base_url() ?>assets/toko_/vendor/slider/slider.js"></script>
<!-- Custom scripts for all pages-->
<script src="<?= base_url() ?>assets/toko_/js/custom.js"></script>
<!-- Base Url-->
<script src="<?= base_url(); ?>assets/js/base_url.js"></script>
<!-- SweetAlert2 -->
<script src="<?= base_url(); ?>assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
<!-- Toastr -->
<script src="<?= base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>
<script src="<?= base_url() ?>assets/toko_/js/hc-offcanvas-nav.js?ver=4.1.1"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/toko_/js/demo.css?ver=3.4.0">
<!-- Select2 js custom -->
<script src="<?= base_url(); ?>assets/js/select2custom.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!-- date-range-picker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="<?= base_url(); ?>assets/js/checkforce.min.js"></script>
<script src="<?= base_url(); ?>assets/js/enkripsi.js"></script>
<!-- Summernote -->
<script src="<?= base_url(); ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?= base_url(); ?>assets/js/crypto-js.min.js"></script>
<!-- DataTables -->
<script src="<?= base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>

<script type="text/javascript">
   $('.add_to_cart_mingguan').click(function() {
      var kd_produk = $(this).data('id');
      var nm_produk = $(this).data('nama');
      var harga = $(this).data('harga');
      $('#kd_produk').val(kd_produk);
      $('#nm_produk').val(nm_produk);
      $('#harga_produk').val(harga);
      $('#txt_harga_menu').html(convertToRupiah(harga));
      $('.add_to_cart_mingguan').removeClass('btn-primary');
      $('.add_to_cart_mingguan').addClass('btn-outline-primary');

      $(".flash-data1").html("Berhasil memilih menu.");
      $(".error-data1").html("");
      toast();

      $(this).removeClass('btn-outline-primary');
      $(this).addClass('btn-primary');

      $('#bagian_data_alamat').show();
      $('#bagian_data_pesanan').show();
   })

   $('#qty_orang').keyup(function() {
      var total = 0;
      var orang = $(this).val();
      if (orang >= 1000) {
         $(this).val(1000);
         orang = 1000;
      } else {
         if (orang != "") {
            orang = $(this).val();
         } else {
            orang = 0;
         }
      }

      $('#txt_jumlah_orang').html(orang);

      var harga_produk = $('#harga_produk').val();
      var hari = $('#total_hari').val();

      total = harga_produk * hari * orang;
      $('#total_bayar_txt').html(convertToRupiah(total));

      if (total > 0) {
         $('#button_submit').attr('disabled', false);
      } else {
         $('#button_submit').attr('disabled', true);
      }

   })

   function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
         return false;
      }
      return true;
   }
</script>

<script>
   $(".rupiah-mask").inputmask({
      alias: 'numeric',
      groupSeparator: ',',
      autoGroup: true,
      digits: 0,
      digitsOptional: false,
      prefix: 'Rp ',
      placeholder: '0',
      rightAlign: false,
      autoUnmask: true,
      removeMaskOnSubmit: true
   });
   // end bagian promo

   const logindetected = $(".login-data").data("login");
   if (logindetected) {
      $('#login').modal({
         backdrop: 'static',
         keyboard: false
      })
   }
   const successalert = $(".flash-data").data("flashdata");
   const erroralert = $(".error-data").data("error");

   if (successalert) {
      Swal.fire({
         icon: 'success',
         text: successalert,
      });
   } else if (erroralert) {
      Swal.fire({
         icon: 'error',
         title: 'Oops...',
         text: erroralert,
      });
   }

   (function($) {
      var $main_nav = $('#main-nav');
      var $toggle = $('.toggle');

      var defaultOptions = {
         disableAt: false,
         customToggle: $toggle,
         levelSpacing: 40,
         navTitle: 'CateringKita',
         levelTitles: true,
         levelTitleAsBack: true,
         pushContent: '#container',
         insertClose: 4
      };

      // call our plugin
      var Nav = $main_nav.hcOffcanvasNav(defaultOptions);

      // add new items to original nav
      $main_nav.find('li.add').children('a').on('click', function() {
         var $this = $(this);
         var $li = $this.parent();
         var items = eval('(' + $this.attr('data-add') + ')');

         $li.before('<li class="new"><a href="#">' + items[0] + '</a></li>');

         items.shift();

         if (!items.length) {
            $li.remove();
         } else {
            $this.attr('data-add', JSON.stringify(items));
         }

         Nav.update(true);
      });

      // demo settings update

      const update = (settings) => {
         if (Nav.isOpen()) {
            Nav.on('close.once', function() {
               Nav.update(settings);
               Nav.open();
            });

            Nav.close();
         } else {
            Nav.update(settings);
         }
      };

      $('.actions').find('a').on('click', function(e) {
         e.preventDefault();

         var $this = $(this).addClass('active');
         var $siblings = $this.parent().siblings().children('a').removeClass('active');
         var settings = eval('(' + $this.data('demo') + ')');

         update(settings);
      });

      $('.actions').find('input').on('change', function() {
         var $this = $(this);
         var settings = eval('(' + $this.data('demo') + ')');

         if ($this.is(':checked')) {
            update(settings);
         } else {
            var removeData = {};
            $.each(settings, function(index, value) {
               removeData[index] = false;
            });

            update(removeData);
         }
      });
   })(jQuery);

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

   function toast() {
      const flashData = $(".flash-data1").html();
      const errorData = $(".error-data1").html();

      const Toast = Swal.mixin({
         toast: true,
         position: "top-left",
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

   $(window).on('load', function() {
      $('.preloader').fadeOut('slow');
   });

   $(document).ready(function() {
      //bagian pembayaran pesanan
      $('#nama_bank').on('change', function() {
         var kd = $('#nama_bank').val();
         if (kd != "") {
            $.ajax({
               url: "<?php echo base_url("konfigurasi/getContactById") ?>",
               type: 'post',
               dataType: 'json',
               data: {
                  "kd_rekening": kd
               },
               success: function(data) {
                  $('#bagian_bank').show(500);
                  $('#nomor_rekening').val(data.nomor_rekening);
                  $('#atas_nama').val(data.atas_nama);
               }
            });
         } else {
            $('#bagian_bank').hide(500);
            $('#nomor_rekening').val("");
            $('#atas_nama').val("");
         }
      })

      $('#cek_pembayaran').click(function() {
         var kd = $('#nama_bank').val();
         var bukti = $('#bukti_transfer').val();

         if (kd == "") {
            $(".error-data1").html("Pilih Bank terlebih dahulu !");
            $(".flash-data1").html("");
            toast();
            $('#nama_bank').removeClass('is-valid');
            $('#nama_bank').addClass('is-invalid');
            return false;
         } else {
            $('#nama_bank').removeClass('is-invalid');
            $('#nama_bank').addClass('is-valid');
         }

         if (bukti == "") {
            $(".error-data1").html("Upload Bukti transfer !");
            $(".flash-data1").html("");
            toast();
            $('#bukti_transfer').removeClass('is-valid');
            $('#bukti_transfer').addClass('is-invalid');
            return false;
         } else {
            $('#bukti_transfer').removeClass('is-invalid');
            $('#bukti_transfer').addClass('is-valid');
         }
      })
      //end bagian pembayaran pesanan

      function autocomplete(inp, arr, kd_produk) {
         /*the autocomplete function takes two arguments,
         the text field element and an array of possible autocompleted values:*/
         var currentFocus;
         /*execute a function when someone writes in the text field:*/
         inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) {
               return false;
            }
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
               /*check if the item starts with the same letters as the text field value:*/

               var record = arr[i].toUpperCase();
               var search = val.toUpperCase();

               if (record.match(search)) {

                  /*create a DIV element for each matching element:*/
                  b = document.createElement("DIV");
                  /*make the matching letters bold:*/
                  // b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                  b.innerHTML = arr[i].substr(0, val.length);
                  b.innerHTML += arr[i].substr(val.length);
                  /*insert a input field that will hold the current array item's value:*/
                  b.innerHTML += "<input type='hidden' value='" + btoa(encrypt(kd_produk[i])) + "'>";
                  /*execute a function when someone clicks on the item value (DIV element):*/
                  b.addEventListener("click", function(e) {
                     /*insert the value for the autocomplete text field:*/
                     inp.value = this.getElementsByTagName("input")[0].value;

                     window.location.href = "<?php echo base_url() ?>catering/productDetail/" + inp.value;

                     $("#searchProduct").val(null);
                     /*close the list of autocompleted values,
                     (or any other open lists of autocompleted values:*/
                     closeAllLists();
                  });
                  a.appendChild(b);
               }
            }
         });
         /*execute a function presses a key on the keyboard:*/
         inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
               /*If the arrow DOWN key is pressed,
               increase the currentFocus variable:*/
               currentFocus++;
               /*and and make the current item more visible:*/
               addActive(x);
            } else if (e.keyCode == 38) { //up
               /*If the arrow UP key is pressed,
               decrease the currentFocus variable:*/
               currentFocus--;
               /*and and make the current item more visible:*/
               addActive(x);
            } else if (e.keyCode == 13) {
               /*If the ENTER key is pressed, prevent the form from being submitted,*/
               e.preventDefault();
               if (currentFocus > -1) {
                  /*and simulate a click on the "active" item:*/
                  if (x) x[currentFocus].click();
               }
            }
         });

         function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
         }

         function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
               x[i].classList.remove("autocomplete-active");
            }
         }

         function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
               if (elmnt != x[i] && elmnt != inp) {
                  x[i].parentNode.removeChild(x[i]);
               }
            }
         }
         /*execute a function when someone clicks in the document:*/
         document.addEventListener("click", function(e) {
            closeAllLists(e.target);
         });
      }

      $("#searchProduct").keyup(function() {
         cariProduct("searchProduct");
      })

      $("#searchProduct1").keyup(function() {
         cariProduct("searchProduct1");
      })

      function cariProduct(path) {
         $.ajax({
            url: "<?php echo base_url("catering/getSearchProduct") ?>",
            type: 'post',
            data: {
               'data': $("#" + path).val()
            },
            dataType: 'json',
            success: function(data) {

               var countries = [];
               var kd_produk = [];
               for (let i = 0; i < data.length; i++) {
                  countries.push(data[i].nm_produk);
                  kd_produk.push(data[i].kd_produk);
               }

               autocomplete(document.getElementById(path), countries, kd_produk);

            }
         });
      }

      var base_url = baseurl();

      // bagian tambah Masukkan dan Saran
      $("#addMasukanSaran").submit(function(e) {
         e.preventDefault();

         let dataString = $('#addMasukanSaran').serialize();

         $.ajax({
            url: "<?php echo base_url("catering/addmasukkansaran") ?>",
            type: 'post',
            data: dataString,

            success: function(data) {
               $('#addMasukanSaran')[0].reset();
               $(".flash-data1").html("Saran dan Masukkan berhasil dikirim.");
               $(".error-data1").html("");
               toast();
            }
         });
      })

      $('.button-nav').on('click', function() {
         let id = $(this).data('id');
         if (id == 1) {
            $('.test1').addClass('fade show active');
            $('.test2').removeClass('fade show active');
         } else {
            $('.test1').removeClass('fade show active');
            $('.test2').addClass('fade show active');
         }
      });


      // end bagian tambah Masukkan dan Saran

      // bagian edit alamat utama
      $('#edit_alamat_utama').click(function() {
         let id = $(this).data('id');
         var text = "";
         $.ajax({
            url: "<?php echo base_url("Catering/getMemberById") ?>",
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
                  url: "<?php echo base_url("Catering/getKecamatan") ?>",
                  type: 'post',
                  dataType: 'json',
                  data: {
                     "kd_kecamatan": data.kd_subdistricts
                  },
                  success: function(result) {
                     if (result != null) {
                        text += "<option value=" + result.id + " selected>" +
                           result.provinsi + "," + result.kabupaten + ", " + result.kecamatan + ", " + result.kelurahan + ", " + result.kodepos + "</option>";
                     }
                     $('#pilihankecamatan_edit').html(text);
                  }
               });

               $('#alamat_edit').val(decrypt(data.alamat).replace(/(<([^>]+)>)/gi, ""));
            }
         });
         $('#edit-alamat-utama').modal('show');
      })

      $("#form_edit_alamat_utama").submit(function(e) {
         e.preventDefault();
         var kecamatan = $('#pilihankecamatan_edit').val();
         var text = "";
         $.ajax({
            url: "<?php echo base_url("Catering/getKecamatan") ?>",
            type: 'post',
            dataType: 'json',
            data: {
               "kd_kecamatan": kecamatan
            },
            success: function(result) {
               if (result != null) {
                  text += result.provinsi + "," + result.kabupaten + ", " + result.kecamatan + ", " + result.kelurahan;
               }
               $('#txt_kecamatan').html(text)
               $('#txt_kodepos').html(result.kodepos);
            }
         });
         var alamat = $('#alamat_edit').val();
         $('#txt_alamat').html(alamat);

         let dataString = $('#form_edit_alamat_utama').serialize();

         $.ajax({
            url: "<?php echo base_url("Catering/edit_alamat_utama") ?>",
            type: 'post',
            dataType: 'json',
            data: dataString,

            success: function(data) {
               if (data.response == "success") {
                  $('#edit-alamat-utama').modal('hide');
                  $('#form_edit_alamat_utama')[0].reset();
                  $(".flash-data1").html(data.message);
                  $(".error-data1").html("");
                  $('#bagiantambahalamatutama').hide();
                  $('#bagianalamatutama').show();
               } else {
                  $(".error-data1").html(data.message);
                  $(".flash-data1").html("");
               }
               toast();
            }
         });
      })

      $('#delete_alamat_utama').click(function() {
         let id = $(this).data('id');
         $.ajax({
            url: "<?php echo base_url("Catering/getMemberById") ?>",
            type: 'post',
            dataType: 'json',
            data: {
               "kd_member": id
            },
            success: function(data) {
               $('#kd_member_delete').val(data.kd_member);
            }
         });
         $('#delete-alamat-utama').modal('show');
      })

      $("#form_delete_alamat_utama").submit(function(e) {
         e.preventDefault();
         let dataString = $('#form_delete_alamat_utama').serialize();

         $.ajax({
            url: "<?php echo base_url("Catering/delete_alamat_utama") ?>",
            type: 'post',
            dataType: 'json',
            data: dataString,

            success: function(data) {
               if (data.response == "success") {
                  $('#delete-alamat-utama').modal('hide');
                  $('#form_delete_alamat_utama')[0].reset();
                  $('#form_edit_alamat_utama')[0].reset();
                  $('#pilihankecamatan_edit').val("").trigger('change');
                  $(".flash-data1").html(data.message);
                  $(".error-data1").html("");
                  $('#bagiantambahalamatutama').show();
                  $('#bagianalamatutama').hide();
               } else {
                  $(".error-data1").html(data.message);
                  $(".flash-data1").html("");
               }
               toast();
            }
         });
      });

      $("#label").change(function() {
         var label = $("#label").val();
         if (label == "lainnya") {
            $('#tandai_sebagai').removeClass('col-md-12');
            $('#tandai_sebagai').addClass('col-md-6');
            $('#input_tandai_sebagai').show(500);
         } else {
            $('#tandai_sebagai').addClass('col-md-12');
            $('#tandai_sebagai').removeClass('col-md-6');
            $('#input_tandai_sebagai').hide();
         }
      });

      $("#label_edit").change(function() {
         var label = $("#label_edit").val();
         if (label == "lainnya") {
            $('#tandai_sebagai_edit').removeClass('col-md-12');
            $('#tandai_sebagai_edit').addClass('col-md-6');
            $('#input_tandai_sebagai_edit').show(500);
         } else {
            $('#tandai_sebagai_edit').addClass('col-md-12');
            $('#tandai_sebagai_edit').removeClass('col-md-6');
            $('#input_tandai_sebagai_edit').hide();
         }
      });

      $("#form_add_alamat_lain").submit(function(e) {
         e.preventDefault();

         let dataString = $('#form_add_alamat_lain').serialize();

         $.ajax({
            url: "<?php echo base_url("Catering/add_alamat_lain") ?>",
            type: 'post',
            data: dataString,

            success: function(data) {
               $('#add-alamat-lain').modal('hide');
               $('#form_add_alamat_lain')[0].reset();
               $('#kecamatan_lain').val("").trigger('change');
               $('#bagian_alamat_lain').show();
               $('#bagian_alamat_lain').html(data);
               $(".flash-data1").html("Data Alamat Lain Berhasil Ditambahkan.");
               $(".error-data1").html("");
               toast();
            }
         });
      })

      $("#form_edit_alamat_lain").submit(function(e) {
         e.preventDefault();

         let dataString = $('#form_edit_alamat_lain').serialize();

         $.ajax({
            url: "<?php echo base_url("Catering/edit_alamat_lain") ?>",
            type: 'post',
            data: dataString,

            success: function(data) {
               $('#edit-alamat-lain').modal('hide');
               $('#form_edit_alamat_lain')[0].reset();
               $('#kecamatan_lain_edit').val("").trigger('change');
               $('#bagian_alamat_lain').show();
               $('#bagian_alamat_lain').html(data);
               $(".flash-data1").html("Data Alamat Lain Berhasil Diubah.");
               $(".error-data1").html("");
               toast();
            }
         });
      })

      $('#bagian_alamat_lain').on('click', '.edit_alamat_lain', function() {
         let id = $(this).data('id');
         $.ajax({
            url: "<?php echo base_url("Catering/getDetailAlamatById") ?>",
            type: 'post',
            dataType: 'json',
            data: {
               "kd_detail_alamat": id
            },
            success: function(data) {
               $('#kd_detail_alamat_edit').val(data.kd_detail_alamat);
               $('#nama_lengkap_edit').val(data.nm_member_);
               $('#no_handphone_edit').val(data.no_telp_);
               $('#kode_pos_lain_edit').val(data.kodepos_);
               $('#alamat_lain_edit').val(data.alamat);
               if (data.lokasi_ != "rumah" && data.lokasi_ != "kantor") {
                  $('#tandai_sebagai_edit').removeClass('col-md-12');
                  $('#tandai_sebagai_edit').addClass('col-md-6');
                  $('#input_tandai_sebagai_edit').show(500);
                  $('#label_edit').val("lainnya").trigger('change');
                  $('#label_name_edit').val(data.lokasi_);
               } else {
                  $('#tandai_sebagai_edit').addClass('col-md-12');
                  $('#tandai_sebagai_edit').removeClass('col-md-6');
                  $('#input_tandai_sebagai_edit').hide();
                  $('#label_edit').val(data.lokasi_).trigger('change');
               }
               var text = "";
               $.ajax({
                  url: "<?php echo base_url("Catering/getKecamatan") ?>",
                  type: 'post',
                  dataType: 'json',
                  data: {
                     "kd_kecamatan": data.subdistricts_
                  },
                  success: function(result) {
                     if (result != null) {
                        text += "<option value=" + result.id + " selected>" +
                           result.provinsi + "," + result.kabupaten + ", " + result.kecamatan + ", " + result.kelurahan + ", " + result.kodepos + "</option>";
                     }
                     $('#kecamatan_lain_edit').html(text)
                  }
               });

            }
         });
         $('#edit-alamat-lain').modal('show');
      })

      $('#bagian_alamat_lain').on('click', '.delete_alamat_lain', function() {
         let id = $(this).data('id');
         $.ajax({
            url: "<?php echo base_url("Catering/getDetailAlamatById") ?>",
            type: 'post',
            dataType: 'json',
            data: {
               "kd_detail_alamat": id
            },
            success: function(data) {
               $('#kd_detail_alamat_delete').val(data.kd_detail_alamat);
            }
         });
         $('#delete-alamat-lain').modal('show');
      })

      $('#form_delete_alamat_lain').submit(function(e) {
         e.preventDefault();
         let dataString = $('#form_delete_alamat_lain').serialize();

         $.ajax({
            url: "<?php echo base_url("Catering/delete_alamat_lain") ?>",
            type: 'post',
            data: dataString,

            success: function(data) {
               $('#delete-alamat-lain').modal('hide');
               $('#form_delete_alamat_lain')[0].reset();
               $('#form_add_alamat_lain')[0].reset();
               $('#kecamatan_lain').val("").trigger('change');
               $('#bagian_alamat_lain').show();
               $('#bagian_alamat_lain').html(data);
               $(".flash-data1").html("Data Alamat Lain Berhasil Dihapus.");
               $(".error-data1").html("");
               toast();
            }
         });
      });

      $('.selected_alamat_utama').on('click', function() {
         $('.selected_alamat_lain').removeClass('btn-primary');
         $('.selected_alamat_lain').addClass('btn-outline-primary');
         $('.selected_alamat_utama').removeClass('btn-primary');
         $('.selected_alamat_utama').addClass('btn-outline-primary');

         $.ajax({
            url: "<?php echo base_url("Catering/add_alamat_pengiriman") ?>",
            type: 'post',
            dataType: 'json',
            data: {
               "alamat": "alamat_utama"
            },

            success: function(data) {
               $(".flash-data1").html("Berhasil memilih alamat pengiriman.");
               $(".error-data1").html("");
               toast();
            }
         });

         $(this).removeClass('btn-outline-primary');
         $(this).addClass('btn-primary');
      });

      $('#bagian_alamat_lain').on('click', '.selected_alamat_lain', function() {
         $('.selected_alamat_lain').removeClass('btn-primary');
         $('.selected_alamat_lain').addClass('btn-outline-primary');
         $('.selected_alamat_utama').removeClass('btn-primary');
         $('.selected_alamat_utama').addClass('btn-outline-primary');
         let id = $(this).data('id');

         $.ajax({
            url: "<?php echo base_url("Catering/add_alamat_pengiriman") ?>",
            type: 'post',
            dataType: 'json',
            data: {
               "alamat": id
            },

            success: function(data) {
               $(".flash-data1").html("Berhasil memilih alamat pengiriman.");
               $(".error-data1").html("");
               toast();
            }
         });

         $(this).removeClass('btn-outline-primary');
         $(this).addClass('btn-primary');

      });

      $('#check_no_telp').on('click', function() {
         var telp = $('#telp_check').val();
         if (telp != "") {
            $.ajax({
               url: "<?php echo base_url("catering/check_telp_order") ?>",
               type: 'post',
               dataType: 'json',
               data: {
                  "telp": telp
               },
               success: function(data) {
                  if (data.response == "success") {
                     $(".flash-data1").html(data.message);
                     $(".error-data1").html("");

                     setTimeout(function() {
                        window.location.href = "<?php echo base_url() ?>catering/daftar_pesanan/";
                     }, 1000);
                  } else {
                     $(".flash-data1").html("");
                     $(".error-data1").html(data.message);
                  }
                  toast();
               }
            });
         } else {
            $(".flash-data1").html("");
            $(".error-data1").html("Masukkan Nomer Telepon terlebih dahulu");
            toast();
         }
      });

      var dataTable = $('#temporary_order_pelanggan').DataTable({
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
            url: "<?php echo base_url("catering/get_datatable_temporary_order") ?>",
            type: "POST",
         },
         "columns": [{
               data: "tgl_order",
               class: "text_center",
               render: function(data, type, row) {
                  return ubah_tanggal(data);
               },
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
               class: "text_center",
               render: function(data, type, row) {
                  return convertToRupiah(data);
               },
            },
            {
               data: "order_status",
               class: "text_center",
               render: function(data, type, row) {
                  if (data == "pending") {
                     return '<span class="badge badge-warning">Tertunda</span>';
                  } else if (data == "onprocess") {
                     return '<span class="badge badge-primary">Sedang Diproses</span>';
                  } else if (data == "ondelivery") {
                     return '<span class="badge badge-default">Sedang Dikirim</span>';
                  } else if (data == "rejected") {
                     return '<span class="badge badge-danger">Barang Dibatalkan</span>';
                  } else if (data == "complain") {
                     return '<span class="badge badge-dark">Barang Komplain</span>';
                  } else if (data == "done") {
                     return '<span class="badge badge-success">Sudah Selesai</span>';
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

      $('#temporary_order_pelanggan').on('click', '.detail_order', function() {
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

      var dataTable = $('#order_pelanggan_nonmember').DataTable({
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
            url: "<?php echo base_url("catering/get_datatable_order_nonmember") ?>",
            type: "POST",
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
               data: "order_status",
               class: "text_center",
               render: function(data, type, row) {
                  if (data == "pending") {
                     return '<span class="badge badge-warning">Tertunda</span>';
                  } else if (data == "onprocess") {
                     return '<span class="badge badge-primary">Sedang Diproses</span>';
                  } else if (data == "ondelivery") {
                     return '<span class="badge badge-default">Sedang Dikirim</span>';
                  } else if (data == "rejected") {
                     return '<span class="badge badge-danger">Barang Dibatalkan</span>';
                  } else if (data == "complain") {
                     return '<span class="badge badge-dark">Barang Komplain</span>';
                  } else if (data == "done") {
                     return '<span class="badge badge-success">Sudah Selesai</span>';
                  }
               },
            },
            {
               data: "order_status",
               class: "text_center",
               // orderable: false,
               render: function(data, type, row) {
                  if (data == "pending") {
                     return '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="' + row.kd_order + '" data-toggle="modal" data-target="#editModal"><i class="fas fa-eye"></i> </a> </span><span data-toggle="tooltip" data-placement="top" title="Pembayaran"><a href="javascript:void(0);" class="pembayaran_order btn btn-sm btn-dark" data-id="' + row.kd_order + '" data-toggle="modal" data-target="#editModal"><i class="fas fa-money-check"></i> </a> </span>';
                  } else {
                     return '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="' + row.kd_order + '" data-toggle="modal" data-target="#editModal"><i class="fas fa-eye"></i> </a> </span>';
                  }
               },
            }
         ],
      });

      $('#order_pelanggan_nonmember').on('click', '.detail_order', function() {
         let id = $(this).data('id');

         getDetailDataPesanan(id, "id");

         $('#detailModal').modal('show');
      });

      $('#order_pelanggan_nonmember').on('click', '.pembayaran_order', function() {
         let id = $(this).data('id');

         window.location.href = "<?php echo base_url() ?>catering/pembayaran_pesanan/" + btoa(encrypt(id));
      });

      var dataTable = $('#order_pelanggan').DataTable({
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
            url: "<?php echo base_url("catering/get_datatable_order") ?>",
            type: "POST",
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
               data: "order_status",
               class: "text_center",
               render: function(data, type, row) {
                  if (data == "pending") {
                     return '<span class="badge badge-warning">Tertunda</span>';
                  } else if (data == "onprocess") {
                     return '<span class="badge badge-primary">Sedang Diproses</span>';
                  } else if (data == "ondelivery") {
                     return '<span class="badge badge-default">Sedang Dikirim</span>';
                  } else if (data == "rejected") {
                     return '<span class="badge badge-danger">Barang Dibatalkan</span>';
                  } else if (data == "complain") {
                     return '<span class="badge badge-dark">Barang Komplain</span>';
                  } else if (data == "done") {
                     return '<span class="badge badge-success">Sudah Selesai</span>';
                  }
               },
            },
            {
               data: "order_status",
               class: "text_center",
               // orderable: false,
               render: function(data, type, row) {
                  if (data == "pending") {
                     return '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="' + row.kd_order + '" data-toggle="modal" data-target="#editModal"><i class="fas fa-eye"></i> </a> </span><span data-toggle="tooltip" data-placement="top" title="DetailOrder"> </span>' +
                        '<span data-toggle="tooltip" data-placement="top" title="Pembayaran"><a href="javascript:void(0);" class="pembayaran_order btn btn-sm btn-dark" data-id="' + row.kd_order + '" data-toggle="modal" data-target="#editModal"><i class="fas fa-money-check"></i> </a> </span>';
                  } else if (data == "done") {
                     if (row.rating == null) {
                        return '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="' + row.kd_order + '" data-toggle="modal" data-target="#editModal"><i class="fas fa-eye"></i> </a> </span><span data-toggle="tooltip" data-placement="top" title="DetailOrder"> </span>' +
                           '<span data-toggle="tooltip" data-placement="top" title="rating"><a href="javascript:void(0);" class="add_rating btn btn-sm btn-warning" data-id="' + row.kd_order + '" data-toggle="modal" data-target="#editModal"><i class="fas fa-star"></i> </a> </span>';
                     } else {
                        return '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="' + row.kd_order + '" data-toggle="modal" data-target="#editModal"><i class="fas fa-eye"></i> </a> </span><span data-toggle="tooltip" data-placement="top" title="DetailOrder"> </span>';
                     }

                  } else {
                     return '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="' + row.kd_order + '" data-toggle="modal" data-target="#editModal"><i class="fas fa-eye"></i> </a> </span><span data-toggle="tooltip" data-placement="top" title="DetailOrder"> </span>';
                  }
               },
            }
         ],
      });

      var dataTable = $('#order_pelanggan_khusus').DataTable({
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
            url: "<?php echo base_url("catering/get_datatable_order_khusus") ?>",
            type: "POST",
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
               data: "order_status",
               class: "text_center",
               // orderable: false,
               render: function(data, type, row) {
                  if (data == "pending") {
                     return '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="' + row.kd_order + '" data-toggle="modal" data-target="#editModal"><i class="fas fa-eye"></i> </a> </span><span data-toggle="tooltip" data-placement="top" title="DetailOrder"> </span><span data-toggle="tooltip" data-placement="top" title="Pembayaran"><a href="javascript:void(0);" class="pembayaran_order btn btn-sm btn-dark" data-id="' + row.kd_order + '" data-toggle="modal" data-target="#editModal"><i class="fas fa-money-check"></i> </a> </span>';
                  } else if (data == "done") {
                     if (row.rating == null) {
                        return '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="' + row.kd_order + '" data-toggle="modal" data-target="#editModal"><i class="fas fa-eye"></i> </a> </span><span data-toggle="tooltip" data-placement="top" title="DetailOrder"> </span>' +
                           '<span data-toggle="tooltip" data-placement="top" title="rating"><a href="javascript:void(0);" class="add_rating btn btn-sm btn-warning" data-id="' + row.kd_order + '" data-toggle="modal" data-target="#editModal"><i class="fas fa-star"></i> </a> </span>';
                     } else {
                        return '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="' + row.kd_order + '" data-toggle="modal" data-target="#editModal"><i class="fas fa-eye"></i> </a> </span><span data-toggle="tooltip" data-placement="top" title="DetailOrder"> </span>';
                     }
                  } else {
                     return '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="' + row.kd_order + '" data-toggle="modal" data-target="#editModal"><i class="fas fa-eye"></i> </a> </span><span data-toggle="tooltip" data-placement="top" title="DetailOrder"> </span>';
                  }
               },
            }
         ],
      });

      $('#tambahrating').on('click', function() {
         var rating = $('#emoji').val();
         var kd_order = $('#kd_order').val();

         $.ajax({
            url: "<?php echo base_url("Catering/add_rating_act") ?>",
            type: 'post',
            dataType: 'json',
            data: {
               "kd_order": kd_order,
               "rating": rating
            },
            success: function(data) {
               $(".error-data1").html("");
               $(".flash-data1").html(data.message);
               toast();
               setTimeout(function() {
                  window.location.href = "<?php echo base_url() ?>main/";
               }, 3000);
            }
         });
      });
      $('#order_pelanggan_khusus').on('click', '.detail_order', function() {
         let id = $(this).data('id');

         getDetailDataPesanan_khusus(id, "id");

         $('#detailModalKhusus').modal('show');
      });

      $('#order_pelanggan_khusus').on('click', '.pembayaran_order', function() {
         let id = $(this).data('id');

         window.location.href = "<?php echo base_url() ?>catering/pembayaran_pesanan/" + btoa(encrypt(id));
      });

      $('#order_pelanggan_khusus').on('click', '.add_rating', function() {
         let id = $(this).data('id');

         window.location.href = "<?php echo base_url() ?>catering/add_rating/" + btoa(encrypt(id));
      });

      $('#order_pelanggan').on('click', '.detail_order', function() {
         let id = $(this).data('id');

         getDetailDataPesanan(id, "id");

         $('#detailModalKhusus').modal('show');
      });

      $('#order_pelanggan').on('click', '.pembayaran_order', function() {
         let id = $(this).data('id');

         window.location.href = "<?php echo base_url() ?>catering/pembayaran_pesanan/" + btoa(encrypt(id));
      });

      $('#order_pelanggan').on('click', '.add_rating', function() {
         let id = $(this).data('id');

         window.location.href = "<?php echo base_url() ?>catering/add_rating/" + btoa(encrypt(id));
      });

      function getDetailDataPesanan_khusus(id, jenis) {
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

                  if (data.order_member.kd_member != "#") {
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
                        '<td width="45%">' + decrypt(data.order_member.cust_address) + '</td>' +
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
                     layout = '<img id = "review_bukti" style="width: 200px;" src = "' + base_url + '/assets/images/bukti_pembayaran/' + data.bukti_pembayaran.bukti_upload + '" alt = "" srcset = "" >';
                  } else {
                     layout = "Bukti Belum Diupload!";
                  }

                  Detail4 += '<tr>' +
                     '<th class="45%" width="45%">Metode Pembayaran</th>' +
                     '<td width="10%">:</td>' +
                     '<td class="45%" width="45%">' + data.order_member.payment_type + '</td>' +
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
                              '<td>' + parseInt(data[i].qty) / data.length + '</td>' +
                              '<td>' + status + '</td>' +
                              '</tr>';
                           j++;
                        }

                        $("#detail_order_kurir_5").html(Detail5);
                     }
                  });

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

      function getDetailDataPesanan(id, jenis) {
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

                  if (data.order_member.kd_member != "#") {
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
                        '<td width="45%">' + decrypt(data.order_member.cust_address) + '</td>' +
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
                     layout = '<img id = "review_bukti" style="width: 200px;" src = "' + base_url + '/assets/images/bukti_pembayaran/' + data.bukti_pembayaran.bukti_upload + '" alt = "" srcset = "" >';
                  } else {
                     layout = "Bukti Belum Diupload!";
                  }

                  Detail4 += '<tr>' +
                     '<th class="45%" width="45%">Metode Pembayaran</th>' +
                     '<td width="10%">:</td>' +
                     '<td class="45%" width="45%">' + data.order_member.payment_type + '</td>' +
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

      // end bagian edit alamat utama & alamat lain

      // bagian product 
      var limit = 12;
      var start = 0;
      var action = 'inactive';
      var where = $('#where_product').val();

      var filter = "";
      var harga_min = $('.harga_min').val();
      if (harga_min == "") {
         var harga_min = $('.harga_min_mobile').val();
      }
      var harga_max = $('.harga_max').val();
      if (harga_max == "") {
         var harga_max = $('.harga_max_mobile').val();
      }

      function lazzy_loader(limit) {
         var output = '';
         for (var count = 0; count < limit; count++) {
            output += '<div class="col-6 col-md-3 post_data">';
            output += '<p><span class="content-placeholder" style="width:100%; height: 100px;">&nbsp;</span></p>';
            output += '<p><span class="content-placeholder" style="width:100%; height: 30px;">&nbsp;</span></p>';
            output += '</div>';
         }
         $('#load_data_message').html(output);
      }

      lazzy_loader(limit);

      function load_data(limit, start, where, filter, harga_min, harga_max) {
         $.ajax({
            url: "<?php echo base_url(); ?>catering/fetch",
            method: "POST",
            data: {
               limit: limit,
               start: start,
               where: where,
               filter: filter,
               harga_min: harga_min,
               harga_max: harga_max,
            },
            cache: false,
            success: function(data) {
               $('#bagian_produk').append(data);
               if (data == '') {
                  $('#load_data_message').html('<div class="col-md-12 text-center load-more"><button class="btn btn-primary btn-sm" type="button" disabled="">No More Result Found</button></div>');
                  action = 'active';
               } else {
                  $('#load_data_message').html("");
                  action = "inactive";
               }
            }
         })
      }

      if (action == 'inactive') {
         action = 'active';
         load_data(limit, start, where, filter, harga_min, harga_max);
      }

      $(window).scroll(function() {
         if ($(window).scrollTop() + $(window).height() > $("#bagian_produk").height() && action == 'inactive') {
            lazzy_loader(limit);
            action = 'active';
            start = start + limit;
            setTimeout(function() {
               load_data(limit, start, where, filter, harga_min, harga_max);
            }, 1000);
         }
      });

      $('.batas_harga_mobile').on('click', function() {
         harga_min = $('.harga_min_mobile').val();
         harga_max = $('.harga_max_mobile').val();
         if (parseInt(harga_max) < parseInt(harga_min)) {
            $(".error-data1").html("Harga Max tidak boleh lebih kecil dari Harga Min.");
            $(".flash-data1").html("");
            toast();
         } else {
            $('#bagian_produk').html("");
            limit = 12;
            start = 0;
            lazzy_loader(limit);
            load_data(limit, start, where, filter, harga_min, harga_max);
         }
      })

      $('.batas_harga').on('click', function() {
         harga_min = $('.harga_min').val();
         if (harga_min == "") {
            harga_min = $('.harga_min_mobile').val();
         }
         harga_max = $('.harga_max').val();
         if (harga_max == "") {
            harga_max = $('.harga_max_mobile').val();
         }
         if (parseInt(harga_max) < parseInt(harga_min)) {
            $(".error-data1").html("Harga Max tidak boleh lebih kecil dari Harga Min.");
            $(".flash-data1").html("");
            toast();
         } else {
            $('#bagian_produk').html("");
            limit = 12;
            start = 0;
            lazzy_loader(limit);
            load_data(limit, start, where, filter, harga_min, harga_max);
         }
      })

      $('.abjadA-Z').on('click', function() {
         filter = "abjadA-Z";
         harga_min = $('.harga_min').val();
         if (harga_min == "") {
            harga_min = $('.harga_min_mobile').val();
         }
         harga_max = $('.harga_max').val();
         if (harga_max == "") {
            harga_max = $('.harga_max_mobile').val();
         }
         $('#bagian_produk').html("");
         limit = 12;
         start = 0;
         lazzy_loader(limit);
         load_data(limit, start, where, filter, harga_min, harga_max);
      })

      $('.abjadZ-A').on('click', function() {
         filter = "abjadZ-A";
         harga_min = $('.harga_min').val();
         if (harga_min == "") {
            harga_min = $('.harga_min_mobile').val();
         }
         harga_max = $('.harga_max').val();
         if (harga_max == "") {
            harga_max = $('.harga_max_mobile').val();
         }
         $('#bagian_produk').html("");
         limit = 12;
         start = 0;
         lazzy_loader(limit);
         load_data(limit, start, where, filter, harga_min, harga_max);
      })

      $('.preorder').on('click', function() {
         where = "preorder";
         $('.txt_kategori').html("Pre Order");
         harga_min = $('.harga_min').val();
         if (harga_min == "") {
            harga_min = $('.harga_min_mobile').val();
         }
         harga_max = $('.harga_max').val();
         if (harga_max == "") {
            harga_max = $('.harga_max_mobile').val();
         }
         $('#bagian_produk').html("");
         $('.bs-example').html("");
         limit = 12;
         start = 0;
         lazzy_loader(limit);
         load_data(limit, start, where, filter, harga_min, harga_max);
      });

      $('.stock').on('click', function() {
         where = "stock";
         $('.txt_kategori').html("Stok");
         harga_min = $('.harga_min').val();
         if (harga_min == "") {
            harga_min = $('.harga_min_mobile').val();
         }
         harga_max = $('.harga_max').val();
         if (harga_max == "") {
            harga_max = $('.harga_max_mobile').val();
         }
         $('#bagian_produk').html("");
         $('.bs-example').html("");
         limit = 12;
         start = 0;
         lazzy_loader(limit);
         load_data(limit, start, where, filter, harga_min, harga_max);
      });

      $('.diskon').on('click', function() {
         where = "diskon";
         $('.txt_kategori').html("Diskon");
         harga_min = $('.harga_min').val();
         if (harga_min == "") {
            harga_min = $('.harga_min_mobile').val();
         }
         harga_max = $('.harga_max').val();
         if (harga_max == "") {
            harga_max = $('.harga_max_mobile').val();
         }
         $('#bagian_produk').html("");
         $('.bs-example').html("");
         limit = 12;
         start = 0;
         lazzy_loader(limit);
         load_data(limit, start, where, filter, harga_min, harga_max);
      });

      $('.kategori_produk_promo').on('click', function() {
         let id = $(this).data('id');
         var text = id.replace("_", " ");
         var text1 = text.charAt(0).toUpperCase() + text.slice(1);
         where = id;
         $('.txt_kategori').html(text1);
         harga_min = $('.harga_min').val();
         if (harga_min == "") {
            harga_min = $('.harga_min_mobile').val();
         }
         harga_max = $('.harga_max').val();
         if (harga_max == "") {
            harga_max = $('.harga_max_mobile').val();
         }
         $('#bagian_produk').html("");
         $('.bs-example').html("");
         limit = 12;
         start = 0;
         lazzy_loader(limit);
         load_data(limit, start, where, filter, harga_min, harga_max);
      });

      $('.pricelow').on('click', function() {
         filter = "pricelow";
         harga_min = $('.harga_min').val();
         if (harga_min == "") {
            harga_min = $('.harga_min_mobile').val();
         }
         harga_max = $('.harga_max').val();
         if (harga_max == "") {
            harga_max = $('.harga_max_mobile').val();
         }
         $('#bagian_produk').html("");
         limit = 12;
         start = 0;
         lazzy_loader(limit);
         load_data(limit, start, where, filter, harga_min, harga_max);
      });

      $('.pricehigh').on('click', function() {
         filter = "pricehigh";
         harga_min = $('.harga_min').val();
         if (harga_min == "") {
            harga_min = $('.harga_min_mobile').val();
         }
         harga_max = $('.harga_max').val();
         if (harga_max == "") {
            harga_max = $('.harga_max_mobile').val();
         }
         $('#bagian_produk').html("");
         limit = 12;
         start = 0;
         lazzy_loader(limit);
         load_data(limit, start, where, filter, harga_min, harga_max);
      })
      // end bagian product 

      // bagian login pelanggan

      $(".tombol_logout").on("click", function(e) {
         e.preventDefault();
         const href = $(this).attr("href");

         Swal.fire({
            title: "Apa Kamu Yakin?",
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Logout!",
         }).then((result) => {
            if (result.value) {
               document.location.href = href;
            }
         });
      });

      $('#button_login').on('click', function(e) {
         e.preventDefault();

         var username = $('#username_pelanggan').val();
         var password = $('#password_pelanggan').val();
         var jum_cart = $('#jum_cart').val();

         if (username != "" && password != "") {
            $('#username_pelanggan').removeClass('is-invalid');
            $('#password_pelanggan').removeClass('is-invalid');
            $('#password_pelanggan').addClass('is-valid');
            $('#username_pelanggan').addClass('is-valid');

            $.ajax({
               url: "<?php echo base_url("main/login_pelanggan") ?>",
               type: 'post',
               dataType: 'json',
               data: {
                  username: username,
                  password: password
               },
               success: function(data) {
                  if (data.toast.response == "success") {
                     $(".flash-data1").html(data.toast.message);
                     $(".error-data1").html("");
                     $('#password_pelanggan').removeClass('is-invalid');
                     $('#username_pelanggan').removeClass('is-invalid');
                     $('#password_pelanggan').addClass('is-valid');
                     $('#username_pelanggan').addClass('is-valid');
                  } else {
                     $(".error-data1").html(data.toast.message);
                     $(".flash-data1").html("");
                     $('#password_pelanggan').removeClass('is-valid');
                     $('#username_pelanggan').removeClass('is-valid');
                     $('#password_pelanggan').addClass('is-invalid');
                     $('#username_pelanggan').addClass('is-invalid');
                  }
                  toast();

                  setTimeout(function() {

                     if (data.role != null) {
                        if (jum_cart > 0) {
                           window.location.href = "<?php echo base_url() ?>catering/checkout";
                        } else {
                           window.location.href = "<?php echo base_url() ?>main";
                        }
                     }
                  }, 1000);
               }
            });
         } else if (username == "" && password == "") {
            $('#password_pelanggan').removeClass('is-valid');
            $('#username_pelanggan').removeClass('is-valid');
            $('#username_pelanggan').addClass('is-invalid');
            $('#password_pelanggan').addClass('is-invalid');
         } else if (username == "") {
            $('#username_pelanggan').addClass('is-invalid');
            $('#password_pelanggan').removeClass('is-invalid');
            $('#password_pelanggan').addClass('is-valid');
         } else {
            $('#username_pelanggan').removeClass('is-invalid');
            $('#username_pelanggan').addClass('is-valid');
            $('#password_pelanggan').addClass('is-invalid');
         }

      })

      // End bagian login pelanggan

      // input alamat pengirim
      $("#form_add_alamat").submit(function(e) {
         e.preventDefault();
         let dataString = $('#form_add_alamat').serialize();

         $.ajax({
            url: "<?php echo base_url("catering/add_alamat_pelanggan") ?>",
            type: 'post',
            dataType: 'json',
            data: dataString,

            success: function(data) {
               if (data.response == "success") {
                  $('#add-address-modal').modal('hide');
                  $('#form_add_alamat')[0].reset();
                  $(".flash-data1").html(data.message);
                  $(".error-data1").html("");
               } else {
                  $(".error-data1").html(data.message);
                  $(".flash-data1").html("");
               }
               window.location.href = "<?php echo base_url() ?>catering/checkout";
               $('#collapseOne').removeClass('show');
               $('#collapsefour').addClass('show');
               toast();

            }
         });
      })

      $("#form_edit_alamat").submit(function(e) {
         e.preventDefault();
         let dataString = $('#form_edit_alamat').serialize();

         $.ajax({
            url: "<?php echo base_url("catering/edit_alamat_pelanggan") ?>",
            type: 'post',
            dataType: 'json',
            data: dataString,

            success: function(data) {
               if (data.response == "success") {
                  $('#edit-address-modal').modal('hide');
                  $('#form_edit_alamat')[0].reset();
                  $(".flash-data1").html(data.message);
                  $(".error-data1").html("");
               } else {
                  $(".error-data1").html(data.message);
                  $(".flash-data1").html("");
               }
               window.location.href = "<?php echo base_url() ?>catering/checkout";
               $('#collapseOne').removeClass('show');
               $('#collapsefour').addClass('show');
               toast();
            }
         });
      })

      $('#hapus_alamat_sess').on('click', function(e) {
         e.preventDefault();

         $.ajax({
            url: "<?php echo base_url("catering/delete_alamat_pelanggan") ?>",
            type: 'post',
            dataType: 'json',
            success: function(data) {
               if (data.response == "success") {
                  $('#delete-address-modal').modal('hide');
                  $(".flash-data1").html(data.message);
                  $(".error-data1").html("");
                  $('.tooltip-item').attr("disabled", true);
               } else {
                  $(".error-data1").html(data.message);
                  $(".flash-data1").html("");
               }
               window.location.href = "<?php echo base_url() ?>catering/checkout";
               $('#collapseOne').addClass('show');
               $('#collapsefour').removeClass('show');
               toast();
            }
         });
      })
      // end input alamat pengirim 

      // input pemesanan 
      $('#payment_type_checkout').change(function() {
         var metode = $('#payment_type_checkout').val();
         if (metode == "ambil_langsung") {
            $('#total_bayar_txt').hide();
            $('#total_bayar_ambil').show();
            $('#total_ongkir_txt').hide();
            $('#total_ongkir_ambil').show();
         } else {
            $('#total_bayar_txt').show();
            $('#total_bayar_ambil').hide();
            $('#total_ongkir_txt').show();
            $('#total_ongkir_ambil').hide();
         }

      })
      // end input pemesanan 

      $("#bagian_keranjang").load(base_url + "/cart/keranjang");

      var input_number = $('.input-number').val();
      if (input_number <= 1) {
         $(".btn-number[data-type='minus'][data-field='quant[1]']").attr(
            "disabled", true
         );
      }

      var jum_cart = $('#jum_cart').val();

      for (let i = 1; i <= jum_cart; i++) {
         $("#bagian_keranjang_checkout").on('click', ".btn-number" + i, function(e) {
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
                  var qty = -1;
               } else if (type == "plus") {
                  if (currentVal < input.attr("max")) {
                     var hasil = currentVal + 1;
                     input.val(currentVal + 1).change();
                  }
                  if (parseInt(input.val()) == input.attr("max")) {
                     $(this).attr("disabled", true);
                  }
                  var qty = 1;
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
            var min_order = $("#min_order" + i).val();
            var produk_catatan = $(".produk_catatan" + i).val();
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

                  setTimeout(() => {
                     $("#total_cart").html(data.total_cart);
                     $("#total_cart_mbl").html(data.total_cart);
                     if ($('#pilihan_kurir').val() != "") {
                        $.ajax({
                           url: "<?php echo base_url("selera_express/getDetailJenisPengirimanById") ?>",
                           type: 'post',
                           dataType: 'json',
                           data: {
                              jenis: $('#jenis_pengiriman').val()
                           },
                           success: function(result) {
                              var jarak_fix = parseFloat($('#total_jarak_').val());
                              var total = $('#total_bayar').val();
                              var sub_total = parseInt($('#sub_total').val());
                              var ongkir_lama = $('#total_ongkir').val();
                              var total_produk = parseInt(total) - parseInt(ongkir_lama);
                              $.ajax({
                                 url: "<?php echo base_url("konfigurasi/getKonfigurasi") ?>",
                                 type: 'post',
                                 dataType: 'json',
                                 success: function(dt) {
                                    for (let i = 0; i < result.length; i++) {
                                       if (parseInt(total_produk) < dt.max_harga_pesanan && jarak_fix <= parseFloat(result[0].jarak2) && $('#jenis_pengiriman').val() == "CateringKita") {
                                          $('#total_ongkir').val(result[0].harga_jarak);
                                          $('#total_ongkir_txt').html(convertToRupiah(result[0].harga_jarak));
                                          var jumlah = parseInt(total) - parseInt(ongkir_lama) + parseInt(result[0].harga_jarak);
                                          $.ajax({
                                             url: "<?php echo base_url("catering/add_session_ongkir_new") ?>",
                                             type: 'post',
                                             dataType: 'json',
                                             data: {
                                                ongkir: result[0].harga_jarak,
                                                searchmap: $('#searchmap_').val(),
                                                jarak: $('#total_jarak_').val()
                                             },
                                             success: function(data) {
                                                $.ajax({
                                                   type: "post",
                                                   url: base_url + "/cart/total_keranjang_checkout",
                                                   success: function(response) {
                                                      $('#bagian_total_keranjang_checkout').html(response);
                                                      // button_keranjang();
                                                   }
                                                });
                                             }
                                          });
                                          $('#total_bayar').val(jumlah);
                                          $('#total_bayar_txt').html(convertToRupiah(jumlah));
                                       } else if (parseInt(total_produk) >= dt.max_harga_pesanan && jarak_fix <= parseFloat(result[0].jarak2) && $('#jenis_pengiriman').val() == "CateringKita") {
                                          $('#total_ongkir').val(0);
                                          $('#total_ongkir_txt').html(convertToRupiah(0));
                                          var jumlah = parseInt(total) - parseInt(ongkir_lama) + parseInt(0);
                                          $.ajax({
                                             url: "<?php echo base_url("catering/add_session_ongkir_new") ?>",
                                             type: 'post',
                                             dataType: 'json',
                                             data: {
                                                ongkir: 0,
                                                searchmap: $('#searchmap_').val(),
                                                jarak: $('#total_jarak_').val()
                                             },
                                             success: function(data) {
                                                $.ajax({
                                                   type: "post",
                                                   url: base_url + "/cart/total_keranjang_checkout",
                                                   success: function(response) {
                                                      $('#bagian_total_keranjang_checkout').html(response);
                                                      // button_keranjang();
                                                   }
                                                });
                                             }
                                          });
                                          $('#total_bayar').val(jumlah);
                                          $('#total_bayar_txt').html(convertToRupiah(jumlah));
                                       } else if (parseInt(total_produk) >= dt.max_harga_pesanan_kedua && $('#jenis_pengiriman').val() == "CateringKita") {
                                          if (jarak_fix > parseFloat(result[i].jarak1) && jarak_fix <= parseFloat(result[i].jarak2)) {
                                             var subregion = $("#subregion").val();
                                             var jrk = $("#total_jarak_").val();
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

                                                   $('#total_ongkir').val(ongkir);
                                                   $('#total_ongkir_txt').html(convertToRupiah(ongkir));
                                                   var jumlah = parseInt(total) - parseInt(ongkir_lama) + parseInt(ongkir);
                                                   $.ajax({
                                                      url: "<?php echo base_url("catering/add_session_ongkir_new") ?>",
                                                      type: 'post',
                                                      dataType: 'json',
                                                      data: {
                                                         ongkir: ongkir,
                                                         searchmap: $('#searchmap_').val(),
                                                         jarak: $('#total_jarak_').val()
                                                      },
                                                      success: function(data) {
                                                         $.ajax({
                                                            type: "post",
                                                            url: base_url + "/cart/total_keranjang_checkout",
                                                            success: function(response) {
                                                               $('#bagian_total_keranjang_checkout').html(response);
                                                               // button_keranjang();
                                                            }
                                                         });
                                                      }
                                                   });
                                                   $('#total_bayar').val(jumlah);
                                                   $('#total_bayar_txt').html(convertToRupiah(jumlah));
                                                }
                                             });
                                          }
                                       } else {
                                          if (jarak_fix > parseFloat(result[i].jarak1) && jarak_fix <= parseFloat(result[i].jarak2)) {
                                             if ($('#jenis_pengiriman').val() == "CateringKita") {
                                                var subregion = $("#subregion").val();
                                                var jrk = $("#total_jarak_").val();
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

                                                      $('#total_ongkir').val(ongkir);
                                                      $('#total_ongkir_txt').html(convertToRupiah(ongkir));
                                                      var jumlah = parseInt(total) - parseInt(ongkir_lama) + parseInt(ongkir);
                                                      $.ajax({
                                                         url: "<?php echo base_url("catering/add_session_ongkir_new") ?>",
                                                         type: 'post',
                                                         dataType: 'json',
                                                         data: {
                                                            ongkir: ongkir,
                                                            searchmap: $('#searchmap_').val(),
                                                            jarak: $('#total_jarak_').val()
                                                         },
                                                         success: function(data) {
                                                            $.ajax({
                                                               type: "post",
                                                               url: base_url + "/cart/total_keranjang_checkout",
                                                               success: function(response) {
                                                                  $('#bagian_total_keranjang_checkout').html(response);
                                                                  // button_keranjang();
                                                               }
                                                            });
                                                         }
                                                      });
                                                      $('#total_bayar').val(jumlah);
                                                      $('#total_bayar_txt').html(convertToRupiah(jumlah));
                                                   }
                                                });
                                             } else {
                                                $('#total_ongkir').val(result[i].harga_jarak);
                                                $('#total_ongkir_txt').html(convertToRupiah(result[i].harga_jarak));
                                                var jumlah = parseInt(total) - parseInt(ongkir_lama) + parseInt(result[i].harga_jarak);
                                                $.ajax({
                                                   url: "<?php echo base_url("catering/add_session_ongkir_new") ?>",
                                                   type: 'post',
                                                   dataType: 'json',
                                                   data: {
                                                      ongkir: result[i].harga_jarak,
                                                      searchmap: $('#searchmap_').val(),
                                                      jarak: $('#total_jarak_').val()
                                                   },
                                                   success: function(data) {
                                                      $.ajax({
                                                         type: "post",
                                                         url: base_url + "/cart/total_keranjang_checkout",
                                                         success: function(response) {
                                                            $('#bagian_total_keranjang_checkout').html(response);
                                                            // button_keranjang();
                                                         }
                                                      });
                                                   }
                                                });
                                                $('#total_bayar').val(jumlah);
                                                $('#total_bayar_txt').html(convertToRupiah(jumlah));
                                             }
                                          }
                                       }
                                    }
                                 }
                              })
                           }
                        });
                     }
                     toast();
                  }, 50);
               },
            });
         });

         $(".input-number" + i).change(function() {
            minValue = parseInt($(this).attr("min"));
            maxValue = parseInt($(this).attr("max"));
            valueCurrent = parseInt($(this).val());

            name = $(this).attr("name");
            if (valueCurrent >= minValue) {
               $(".btn-number" + i + "[data-type='minus']").removeAttr(
                  "disabled"
               );
            } else {
               $(".flash-data1").html("");
               $(".error-data1").html("Sorry, the minimum value was reached");
               toast();
               $(this).val($(this).data("oldValue"));
            }
            if (valueCurrent <= maxValue) {
               $(".btn-number" + i + "[data-type='plus']").removeAttr(
                  "disabled"
               );
            } else {
               $(".flash-data1").html("");
               $(".error-data1").html("Sorry, the maximum value was reached");
               toast();
               $(this).val($(this).data("oldValue"));
            }
         });

         $("#bagian_keranjang_checkout").on('click', '.submit_catatan' + i, function(e) {
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

      var jumlah = $('#jumlah_produk').val();

      $(function() {

         $('input:radio').change(
            function() {
               var ele = document.getElementsByName('options');
               for (i = 0; i < ele.length; i++) {
                  if (ele[i].checked) {
                     var kd_detail = ele[i].value;
                     $.ajax({
                        url: base_url + "/product/getDetailProductById",
                        type: 'post',
                        dataType: 'json',
                        data: {
                           id: kd_detail
                        },
                        success: function(result) {
                           $('.btn-number').attr("disabled", false);
                           $('.input-number').val(1);
                           $('.input-number').attr('max', result.stok);
                           if (result.jns_produk == "stock") {
                              $('.stok_produk_v').html(result.stok);
                           }

                           $("#produk_id").val(result.kd_detail_produk);
                           $("#produk_kd").val(result.kd_produk);
                           $("#produk_stok").val(result.stok);
                           $("#produk_berat").val(result.berat);
                           $("#produk_satuan_berat").val(result.satuan_berat);
                           $("#produk_harga_coret").val(result.harga_coret);
                           if (result.diskon > 0) {
                              $('.bagian_diskon').show();
                              var persen = result.diskon / result.harga_produk * 100;
                              $('.bagian_diskon').html('HEMAT ' + Math.round(persen) + '%');
                              $('.product-price-del').show();
                              $('.product-price-del').html(convertToRupiah(result.harga_produk));
                              $(".product-price").html(convertToRupiah(result.harga_produk - result.diskon));
                              $("#produk_harga").val(result.harga_produk - result.diskon);
                           } else {
                              $('.bagian_diskon').hide();
                              $('.product-price-del').hide();
                              $(".product-price").html(convertToRupiah(result.harga_produk));
                              $("#produk_harga").val(result.harga_produk);
                           }
                           $("#produk_diskon").val(result.diskon);
                           $("#produk_jns_komisi").val(result.jns_komisi);
                           $("#produk_nominal_komisi").val(result.nominal_komisi);
                           if (result.stok > 0) {
                              $('.btn_cart').removeAttr('disabled');
                           } else {
                              $('.btn_cart').addAttr('disabled');
                           }
                        }
                     });
                  }
               }
            }
         );
      });

      $(".add_to_cart_custom").click(function() {
         var produk_id = $(this).data("produk_id");
         var produk_kd = $(this).data("produk_kd");
         var produk_nm = $(this).data("produk_nm");
         var produk_harga = $(this).data("produk_harga");
         var produk_foto = $(this).data("produk_foto");
         var produk_deskripsi = $(this).data("produk_deskripsi");
         var min_order = $(this).data("min_order");
         var quantity = 1;
         $.ajax({
            url: base_url + "/cart/add_to_cart",
            type: "post",
            dataType: "json",
            data: {
               produk_id: produk_id,
               produk_kd: produk_kd,
               produk_nm: produk_nm,
               produk_harga: produk_harga,
               produk_foto: produk_foto,
               produk_deskripsi: produk_deskripsi,
               min_order: min_order,
               quantity: quantity,
            },
            success: function(data) {
               if (data.data != 0) {
                  $.ajax({
                     url: base_url + "/cart/keranjang",
                     type: "post",
                     success: function(response) {
                        $('#bagian_keranjang').html(response);
                        // button_keranjang();

                        $("#total_cart").html(data.data.total_cart);
                        $("#total_cart_mbl").html(data.data.total_cart);
                        $(".flash-data1").html("Data Produk Berhasil Ditambahkan.");
                        $(".error-data1").html("");
                        toast();
                     }
                  });
               } else {
                  $(".flash-data1").html("");
                  $(".error-data1").html("Produk Belum Bisa Dipesan.");
                  toast();
               }
            },
         });
      });

      $(".btn_cart").click(function() {
         var produk_id = $("#produk_id").val();
         var produk_kd = $("#produk_kd").val();
         var produk_nm = $("#produk_nm").val();
         var produk_harga = $("#produk_harga").val();
         var produk_foto = $("#produk_foto").val();
         var produk_deskripsi = $("#produk_deskripsi").val();
         var min_order = $("#min_order").val();
         var quantity = $(".input-number").val();
         $.ajax({
            url: base_url + "/cart/add_to_cart",
            type: "post",
            dataType: "json",
            data: {
               produk_id: produk_id,
               produk_kd: produk_kd,
               produk_nm: produk_nm,
               produk_harga: produk_harga,
               produk_foto: produk_foto,
               produk_deskripsi: produk_deskripsi,
               min_order: min_order,
               quantity: quantity,
            },
            success: function(data) {
               if (data.data != 0) {
                  $.ajax({
                     url: base_url + "/cart/keranjang",
                     type: "post",
                     success: function(response) {
                        $('#bagian_keranjang').html(response);
                        // button_keranjang();

                        $("#total_cart").html(data.data.total_cart);
                        $("#total_cart_mbl").html(data.data.total_cart);
                        $(".flash-data1").html("Data Produk Berhasil Ditambahkan.");
                        $(".error-data1").html("");
                        toast();
                     }
                  });
               } else {
                  $(".flash-data1").html("");
                  $(".error-data1").html("Produk Belum Bisa Dipesan.");
                  toast();
               }
            },
         });
      });

      // $('#keranjang').on('click', function() {
      //    var text = "";
      //    $.ajax({
      //       url: base_url + "/cart/keranjang",
      //       type: "post",
      //       dataType: "json",
      //       success: function(data) {
      //          $('#bagian_keranjang').html(text);
      //       },
      //    });
      // });

      $(document).on("click", ".remove-cart", function() {
         var row_id = $(this).attr("id"); //mengambil row_id dari artibut id
         var map_sec = $('#map_section').val();
         $.ajax({
            url: base_url + "/cart/delete_cart",
            type: "post",
            dataType: "json",
            data: {
               row_id: row_id,
            },
            success: function(data) {
               $.ajax({
                  type: "post",
                  url: base_url + "/cart/total_keranjang_checkout",
                  success: function(response) {
                     $('#bagian_total_keranjang_checkout').html(response);
                     // button_keranjang();
                  }
               });

               $.ajax({
                  url: base_url + "/cart/keranjang",
                  type: "post",
                  success: function(response) {
                     $('#bagian_keranjang').html(response);
                     // button_keranjang();
                  }
               });

               $.ajax({
                  url: base_url + "/cart/keranjang_checkout",
                  type: "post",
                  success: function(response) {
                     $('#bagian_keranjang_checkout').html(response);
                     // button_keranjang();
                  }
               });

               $(".flash-data1").html("Item Keranjang Berhasil Dihapus.");
               $(".error-data1").html("");
               $("#total_cart").html(data.total_cart);
               $("#total_cart_mbl").html(data.total_cart);
               toast();
               var jum = parseInt($('#jum_cart').val() - 1);
               if (map_sec == "order_pelanggan") {
                  if (jum <= 0) {
                     window.location.href = "<?php echo base_url() ?>catering/checkout";
                  }
               }
            },
         });
      });

      $(".btn-number").click(function(e) {
         e.preventDefault();

         fieldName = $(this).attr("data-field");
         type = $(this).attr("data-type");
         var input = $("input[name='" + fieldName + "']");
         var currentVal = parseInt(input.val());
         var max = input.attr("max");
         if (max > 0) {
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
         } else {
            $(".flash-data1").html("");
            $(".error-data1").html("Maaf, Stok Tidak Tersedia.");
            toast();
         }
      });

      $(".input-number").focusin(function() {
         $(this).data("oldValue", $(this).val());
      });

      $(".input-number").change(function() {
         minValue = parseInt($(this).attr("min"));
         maxValue = parseInt($(this).attr("max"));
         valueCurrent = parseInt($(this).val());

         name = $(this).attr("name");
         if (valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr(
               "disabled"
            );
         } else {
            $(".flash-data1").html("");
            $(".error-data1").html("Maaf, sudah melewati batas minimum.");
            toast();
            $(this).val($(this).data("oldValue"));
         }
         if (valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr(
               "disabled"
            );
         } else {
            $(".flash-data1").html("");
            $(".error-data1").html("Maaf, sudah melewati batas maximum.");
            toast();
            $(this).val($(this).data("oldValue"));
         }
      });

      $(".input-number").keydown(function(e) {
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

      //bagian kategori

      $('.produk_kategori').on('click', function() {
         let id = $(this).data('id');
         window.location.href = "<?php echo base_url() ?>catering/product/" + id;
      })

      $('.produk_sub_kategori').on('click', function() {
         let id = $(this).data('id');
         window.location.href = "<?php echo base_url() ?>catering/product/" + id;
      })

      $('.produk_promo_choice').on('click', function() {
         let id = $(this).data('id');
         promo(id);
         // window.location.href = "<?php echo base_url() ?>catering/promo_product/" + id;
      })

      $('#check_phone').on('click', function() {
         var phone = $('#phone_number').val();
         if (phone != "") {
            $('#bagian_kode_1').hide(500);
            $('#bagian_kirim_ulang').hide(500);
            $('#bagian_kode_2').show(500);
            $.ajax({
               url: base_url + "/catering/send",
               type: "post",
               dataType: "json",
               data: {
                  nomer: phone,
               },
               success: function(data) {
                  $(".flash-data1").html(data.message + " Ke nomer " + phone);
                  $(".error-data1").html("");
                  toast();
                  CountDown(60, $('#display'));
               },
            });
         } else {
            Swal.fire({
               icon: 'error',
               title: 'Oops...',
               text: "Harap Masukkan Nomer Telepon Terlebih Dahulu.",
            });
         }
      });

      $('#check_phone_again').on('click', function() {
         $('#bagian_kode_2').hide(500);
         $('#bagian_kode_1').show(500);
         $('#bagian_kirim_ulang').hide(500);
      });

      $('#phone_number').keyup(function() {
         var telp = $('#phone_number').val()
         $('#add_telp_cust_temp').val(telp);
      })

      $('#kode_verifikasi').on('keyup', function() {
         var str = $('#kode_verifikasi').val();
         var n = str.length;
         if (n == 6) {
            $.ajax({
               url: base_url + "/catering/verifikasi",
               type: "post",
               dataType: "json",
               data: {
                  kd_verif: str,
               },
               success: function(data) {
                  if (data.response == "success") {
                     $(".flash-data1").html(data.message);
                     $(".error-data1").html("");
                     toast();
                     $('#bagian_verifikasi').show(500);
                     $('#bagian_belum_verifikasi').hide(500);
                     $('#collapseOne').removeClass('show');
                     $('#collapseTwo').addClass('show');
                  } else {
                     $(".flash-data1").html("");
                     $(".error-data1").html(data.message);
                     toast();
                     $('#bagian_verifikasi').hide(500);
                     $('#bagian_belum_verifikasi').show(500);
                     $('#collapseTwo').removeClass('show');
                     $('#collapseOne').addClass('show');
                  }
               },
            });
         }
      })

      var bagian_addmember = $('#bagian_addmember').val();
      if (bagian_addmember) {
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
      }

      $('#retype_password_edit').on('keyup', function() {
         var password = $('#password_edit1').val();
         var repassword = $('#retype_password_edit').val();
         if (password != null) {
            if (repassword == password) {
               $('#password_edit1').removeClass('is-invalid');
               $('#retype_password_edit').removeClass('is-invalid');
               $('#password_edit1').addClass('is-valid');
               $('#retype_password_edit').addClass('is-valid');
            } else {
               $('#password_edit1').removeClass('is-valid');
               $('#retype_password_edit').removeClass('is-valid');
               $('#password_edit1').addClass('is-invalid');
               $('#retype_password_edit').addClass('is-invalid');
            }
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

      $('#checkboxpasslogin').click(function() {
         var z = document.getElementById("password_pelanggan");
         if ($(this).prop("checked") == false) {
            z.type = "password";
         } else if ($(this).prop("checked") == true) {
            z.type = "text";
         }
      });

      $("#editProfile").click(function() {
         var password = $("#password_edit1").val();
         var repassword = $("#retype_password_edit").val();
         var notelp = $('#notelp').val();

         var pwd = /^(?=.*[a-z])/;
         var pwd1 = /^(?=.*[A-Z])/;
         var pwd2 = /^(?=.*[0-9])/;

         if (notelp) {
            $.ajax({
               url: base_url + "/catering/cek_notelp",
               type: "post",
               dataType: "json",
               data: {
                  notelp: notelp,
               },
               success: function(data) {
                  if (data.response == "error") {
                     $('#notelp').removeClass('is-valid');
                     $('#notelp').addClass('is-invalid');
                     $('#notelp').val("");
                     $(".error-data1").html(data.message);
                     $(".flash-data1").html("");
                     toast();
                     return false;
                  } else {
                     $('#notelp').removeClass('is-invalid');
                     $('#notelp').addClass('is-valid');
                  }
               },
            });
         }

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

   });

   function CountDown(duration, display) {
      if (!isNaN(duration)) {
         var timer = duration,
            days,
            hours,
            minutes, seconds;

         var interVal = setInterval(function() {
            days = parseInt(timer / 86400, 10);
            hours = parseInt((timer - 86400 * days) / 3600, 10);
            minutes = parseInt((timer - 86400 * days - 3600 * hours) / 60, 10);
            seconds = parseInt(timer % 60, 10);

            days = days < 10 ? "0" + days : days;
            hours = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;
            if (days != 00) {
               $(display).html("<b>" + days + "d : " + hours + "h : " + minutes + "m : " + seconds + "s" + "</b>");
            } else {
               $(display).html("<b>" + hours + "h : " + minutes + "m : " + seconds + "s" + "</b>");
            }

            if (--timer < 0) {
               timer = duration;
               $('#display').empty();
               clearInterval(interVal)
               $('#bagian_kirim_ulang').show(500);
               $.ajax({
                  url: base_url + "/catering/hapus_verifikasi",
                  type: "post",
                  dataType: "json",
                  success: function(data) {
                     if (data.response == "error") {
                        $(".flash-data1").html(data.message);
                        $(".error-data1").html("");
                        toast();
                     }
                  },
               });
            }
         }, 1000);
      }
   }

   function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
         return false;
      }
      return true;
   }

   $(function() {
      $('#datepickersingle').daterangepicker({
         singleDatePicker: true,
         showDropdowns: true,
         minYear: new Date('Y'),
         minDate: new Date(),
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
         minYear: new Date('Y'),
         minDate: new Date(),
         locale: {
            format: 'YYYY-MM-DD'
         },
         maxYear: parseInt(moment().format('YYYY'), 10)
      }, function(start, end, label) {
         var years = moment().diff(start, 'years');
      });
   });
</script>
</body>

</html>