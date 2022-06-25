<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Page Not Found</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900" rel="stylesheet">

    <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/404.css') ?>" />

    <style>
        .notfound .notfound-404 h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 230px;
            margin: 0px;
            font-weight: 900;
            position: absolute;
            left: 50%;
            -webkit-transform: translateX(-50%);
            -ms-transform: translateX(-50%);
            transform: translateX(-50%);
            background: url("<?= base_url('assets/images/bg.jpg') ?>") no-repeat;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: cover;
            background-position: center;
        }
    </style>


</head>

<body>

    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>Oops!</h1>
            </div>
            <h2>404 - Page not found</h2>
            <p style="text-align: justify;">Halaman yang Anda cari telah dipindahkan, dihapus, diganti namanya atau mungkin tidak pernah ada.</p>
            <?php if ($this->session->userdata('kd_role')) { ?>
                <a href="<?= base_url('dashboard') ?>">Kembali Ke Beranda</a>
            <?php } else { ?>
                <a href="<?= base_url('main') ?>">Kembali Ke Beranda</a>
            <?php } ?>
        </div>
    </div>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>