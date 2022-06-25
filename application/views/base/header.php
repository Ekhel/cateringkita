<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <?php
    if ($this->session->userdata('kd_admin')) {
        $title = "Admin";
    } else if ($this->session->userdata('kd_masak')) {
        $title = "Pemasak";
    } else if ($this->session->userdata('kd_kurir')) {
        $title = "Kurir";
    }
    ?>
    <!-- Data Tables -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

    <!-- daterange picker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- Table Bootstrap -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/tableCustom.css" />
    <!-- Upload Foto -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/upload_foto.css" />
    <title><?= $title . " | " . $judul; ?></title>
    <link rel="icon" type="image/png" href="<?= base_url() ?>assets/images/logo_website/selera-mart.png" />
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/summernote/summernote-bs4.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/ekko-lightbox/ekko-lightbox.css" />
    <!-- Switch Bootstrap -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/switch_bootstrap.css" />
    <!-- Cek Password -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/checkforce-style.css" />
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style type="text/css">
        .dropzone-wrapper {
            border: 2px dashed #91b0b3;
            color: #ffffff;
            position: absolute;
            height: 150px;
            width: 99%;
            z-index: 10;
            background-color: darkgrey;
        }

        .dropzone-desc {
            position: absolute;
            margin: 0 auto;
            left: 0;
            right: 0;
            text-align: center;
            width: 40%;
            top: 50px;
            font-size: 16px;
        }

        .dropzone,
        .dropzone:focus {
            position: absolute;
            outline: none !important;
            width: 100%;
            height: 150px;
            cursor: pointer;
            opacity: 0;
        }

        .dropzone-wrapper:hover,
        .dropzone-wrapper.dragover {
            background: #ecf0f5;
            color: black;
        }

        .fc-title {
            color: white;
            font-weight: bold;
        }

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

        .d-none {
            display: none;
        }

        @media (min-width: 200px) and (max-width: 500px) {

            .brrr {
                display: block;
            }

            .brrr:after {
                content: "\A";
                white-space: pre;
                word-wrap: break-word;
            }

            .reseller-search {
                display: block;
            }

            .reseller-search:after {
                content: "\A";
                white-space: pre;
                word-wrap: break-word;
            }

        }

        #imgView,
        #imgViewEdit,
        #imgViewBuktiTf,
        #review_bukti,
        #review_penerimaan {
            padding: 5px;
            width: 200px;
            height: 150px;
        }

        #hr {
            border: 0;
            height: 1px;
            border-top: 3px double #8c8c8c;
        }

        .setgallery .modal-body {
            max-height: 460px;
            overflow: hidden;
            overflow-y: auto;
        }

        .setgallery .modal-body .selected-image .img {
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .setgallery .modal-body .selected-image .img .remove-img {
            position: absolute;
            top: -12px;
            right: -12px;
            background: #fff;
            width: 20px;
            height: 20px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            font-size: 12px;
            color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            line-height: 20px;
            text-align: center;
            -webkit-box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        td.view_invoice {
            vertical-align: top;
            text-align: justify;
        }

        td.text_invoice {
            vertical-align: top;
            /* text-align: center; */
        }

        fieldset.scheduler-border {
            border: 1px groove #ddd !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
        }

        .loadAnimate {
            animation: setAnimate ease 2.5s infinite;
        }

        #deleteCache {
            cursor: pointer;
        }

        @keyframes setAnimate {
            0% {
                color: #000;
            }

            50% {
                color: transparent;
            }

            99% {
                color: transparent;
            }

            100% {
                color: #000;
            }
        }

        .custom-file-label {
            cursor: pointer;
        }

        .bkt_pembayaran:hover {
            cursor: pointer;
        }

        .bkt_penerimaan:hover {
            cursor: pointer;
        }
    </style>
</head>
<?php
function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

function rupiah_resi($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}
?>
<?php if ($this->uri->segment(1) == "pesanan" &&  $this->uri->segment(2) == "reseller" || $this->uri->segment(1) == "linkreseller") { ?>

    <body class="hold-transition layout-top-nav">
    <?php } else { ?>

        <body class="hold-transition sidebar-mini <?= $this->session->userdata('kd_role') == 7 ? 'sidebar-collapse' : '' ?> layout-fixed layout-navbar-fixed layout-footer-fixed">
        <?php } ?>

        <div class="preloader">
            <img src="<?= base_url('assets/images/loading.gif') ?>" alt="">
        </div>
        <div class="wrapper">
            <div style="display: none;" class="flash-data1" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
            <div style="display: none;" class="error-data1" data-error="<?= $this->session->flashdata('error'); ?>"></div>

            <div class="notice-data" data-flashdata="<?= $this->session->flashdata('notice_page'); ?>"></div>
            <div class="info-data" data-flashdata="<?= $this->session->flashdata('info_page'); ?>"></div>
            <div class="flash-data-sweet" data-flashdata="<?= $this->session->flashdata('flash_page'); ?>"></div>

            <div style="display: none;" class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
            <div style="display: none;" class="error-data" data-error="<?= $this->session->flashdata('error'); ?>"></div>