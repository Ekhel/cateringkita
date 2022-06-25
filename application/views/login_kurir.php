<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $judul ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <!--===============================================================================================-->
    <!-- <link rel="icon" type="image/png" href="<?= base_url(); ?>assets/images/icons/favicon.ico" /> -->
    <link rel="icon" type="image/png" href="<?= base_url() ?>assets/images/logo_website/selera-mart.png" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/main.css">
    <!--===============================================================================================-->
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/toastr/toastr.min.css">
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-t-190 p-b-30">
                <?php if (validation_errors()) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?= validation_errors(); ?>
                    </div>
                <?php endif; ?>
                <div class="flash-data1" data-flashdata="<?= $this->session->flashdata('flash'); ?>" style="display:none"></div>
                <div class="error-data1" data-error="<?= $this->session->flashdata('error'); ?>" style="display:none"></div>

                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
                <div class="error-data" data-error="<?= $this->session->flashdata('error'); ?>"></div>

                <form class="login100-form validate-form" id="login" autocomplete="off">
                    <!-- <div class="login100-form-avatar">
                        <img src="<?= base_url(); ?>assets/images/avatar-01.jpg" alt="AVATAR">
                    </div> -->

                    <span class="login100-form-title p-t-20 p-b-45">
                        <?= $judul_login ?>
                    </span>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Username is required">
                        <input class="input100" type="hidden" name="level" id="level" value="kurir">
                        <input class="input100" type="text" name="username" id="username" placeholder="<?= $placeholder; ?>">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate="Password is required">
                        <input class="input100" type="password" id="password" name="password" placeholder="Password">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>

                    <div class="icheck-primary d-inline ml-3">
                        <input type="checkbox" id="checkboxpasslogin">
                        <label for="checkboxpasslogin" class="text-white">
                            Lihat Password
                        </label>
                    </div>

                    <?php if ($judul_login == "Login Admin") { ?>
                        <a href="javascript:void(0);" class="btn btn-success btn-sm float-right mb-2 refresh-captcha"><i class="fa fa-refresh"></i> Refresh Captcha</a>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control rounded-left" name="captcha" id="captcha" placeholder="Captcha">
                            <div class="input-group-append">
                                <span class="input-group-text captcha-img" id="basic-addon2"><?= $image; ?></span>
                            </div>
                        </div>
                    <?php }  ?>

                    <div class="container-login100-form-btn p-t-10">
                        <button class="login100-form-btn">
                            Login
                        </button>
                    </div>

                    <div class="text-center w-full p-t-25 p-b-230">
                        <!-- <a href="<?= base_url(); ?>assets/#" class="txt1">
                            Forgot Username / Password?
                        </a> -->
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!--===============================================================================================-->
    <script src="<?= base_url(); ?>assets/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url(); ?>assets/vendor/bootstrap/js/popper.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url(); ?>assets/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url(); ?>assets/js/main.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url(); ?>assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- Toastr -->
    <script src="<?= base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/myscript.js"></script>
    <script src="<?= base_url(); ?>assets/js/base_url.js"></script>

    <script>
        $("#login").submit(function(e) {
            e.preventDefault();
            let dataString = $('#login').serialize();

            $.ajax({
                url: "<?php echo base_url("Main/cekLogin") ?>",
                type: 'post',
                dataType: 'json',
                data: dataString,

                success: function(data) {
                    if (data.toast.response == "success") {
                        $(".flash-data1").html(data.toast.message);
                        $(".error-data1").html("");
                    } else {
                        $(".error-data1").html(data.toast.message);
                        $(".flash-data1").html("");
                    }
                    toast();

                    setTimeout(function() {
                        if (data.role != null) {
                            window.location.href = "<?php echo base_url() ?>dashboard";
                        }
                    }, 1000);

                }
            });
        })

        $('.refresh-captcha').click(function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo base_url("Main/refresh_captcha") ?>",
                dataType: "text",
                cache: false,
                success: function(data) {
                    $("#captcha").val("");
                    $("#captcha").focus();
                    $('.captcha-img').html(data);
                }
            });
        });

        $('#checkboxpasslogin').click(function() {
            var x = document.getElementById("password");
            if ($(this).prop("checked") == false) {
                x.type = "password";
            } else if ($(this).prop("checked") == true) {
                x.type = "text";
            }
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

            if (flashData == "Login" || flashData == "Logout" && errorData == "") {
                Toast.fire({
                    icon: "success",
                    title: "Anda Berhasil " + flashData,
                });
            } else if (flashData && errorData == "") {
                Toast.fire({
                    icon: "success",
                    title: flashData,
                });
            } else if (errorData && flashData == "") {
                Toast.fire({
                    icon: "error",
                    title: errorData,
                });
            }
        }
    </script>


</body>

</html>