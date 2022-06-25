<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="CateringKita">
    <meta name="author" content="CateringKita">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title><?= "CateringKita | " . $judul ?></title>
    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="<?= base_url() ?>assets/images/logo_website/<?= $logo['nm_logo'] ?>" style="height: 10px;">
    <!-- Bootstrap core CSS -->
    <link href="<?= base_url() ?>assets/toko_/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Slider CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/toko_/vendor/slider/slider.css">
    <!-- Select2 CSS -->
    <link href="<?= base_url() ?>assets/toko_/vendor/select2/css/select2-bootstrap.css" />
    <link href="<?= base_url() ?>assets/toko_/vendor/select2/css/select2.min.css" rel="stylesheet" />
    <!-- Font Awesome-->
    <link href="<?= base_url() ?>assets/toko_/vendor/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/toko_/vendor/icofont/icofont.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?= base_url() ?>assets/toko_/css/style.css" rel="stylesheet">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/summernote/summernote-bs4.css">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/toko_/vendor/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/toko_/vendor/owl-carousel/owl.theme.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/toastr/toastr.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/checkforce-style.css" />
    <!-- Data Tables -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <style type="text/css">
        .preloader {
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #e5eff1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .preloader>img {
            width: 100px;
        }

        .pilihanJenisProduk:hover {
            cursor: pointer;
        }

        /*the container must be positioned relative:*/

        .autocomplete {
            position: relative;
            display: inline-block;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
            max-height: 400px !important;
            overflow: auto !important;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        /*when hovering an item:*/
        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

        /*when navigating through the items using the arrow keys:*/
        .autocomplete-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="preloader">
        <img src="<?= base_url('assets/images/loading.gif') ?>" alt="">
    </div>
    <div class="flash-data1" data-flashdata="<?= $this->session->flashdata('flash'); ?>" style="display: none;"></div>
    <div class="error-data1" data-error="<?= $this->session->flashdata('error'); ?>" style="display: none;"></div>
    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash_page'); ?>"></div>
    <div class="login-data" data-login="<?= $this->session->flashdata('login'); ?>"></div>
    <div class="error-data" data-error="<?= $this->session->flashdata('error_page'); ?>"></div>