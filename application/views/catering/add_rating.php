<style>
    :root {
        --hue: 223;
        --bg: hsl(var(--hue), 10%, 100%);
        --fg: hsl(var(--hue), 10%, 10%);
        --primary1: hsl(var(--hue), 90%, 55%);
        --primary2: hsl(var(--hue), 90%, 65%);
        --trans-dur: 0.3s;
        font-size: calc(16px + (20 - 16) * (100vw - 320px) / (1280 - 320));
    }

    input {
        font: 1em/1.5 sans-serif;
    }

    .e-rating,
    .e-rating__faces {
        display: flex;
    }

    .e-rating {
        --animDur: 2s;
        flex-wrap: wrap;
        padding-top: 2em;
        width: 18em;
    }

    .e-rating__sr {
        clip: rect(1px, 1px, 1px, 1px);
        overflow: hidden;
        position: absolute;
        width: 1px;
        height: 1px;
    }

    .e-rating__range {
        background-color: hsl(var(--hue), 10%, 50%, 0.5);
        border-radius: 0.25em;
        margin: 0.5em 0.75em;
        order: 1;
        width: 100%;
        height: 0.5em;
        -webkit-appearance: none;
        appearance: none;
        -webkit-tap-highlight-color: transparent;
    }

    .e-rating__range:focus {
        outline: transparent;
    }

    .e-rating__range::-webkit-slider-thumb {
        background-color: var(--primary1);
        border: 0;
        border-radius: 50%;
        width: 1.5em;
        height: 1.5em;
        transition: background-color 0.15s linear;
        -webkit-appearance: none;
        appearance: none;
    }

    .e-rating__range:focus::-webkit-slider-thumb,
    .e-rating__range::-webkit-slider-thumb:hover {
        background-color: var(--primary2);
    }

    .e-rating__range::-moz-range-thumb {
        background-color: var(--primary1);
        border: 0;
        border-radius: 50%;
        width: 1.5em;
        height: 1.5em;
        transition: background-color 0.15s linear;
    }

    .e-rating__range:focus::-moz-range-thumb,
    .e-rating__range::-moz-range-thumb:hover {
        background-color: var(--primary2);
    }

    .e-rating__faces {
        justify-content: space-between;
        margin-bottom: 1.5em;
        width: 100%;
    }

    .e-rating__face,
    .e-rating__face:after {
        border-radius: 50%;
        transition:
            background-color var(--trans-dur),
            transform var(--trans-dur) cubic-bezier(0.42, 0, 0.58, 1);
    }

    .e-rating__face {
        background-color: hsl(50, 90%, 55%);
        position: relative;
        width: 3em;
        height: 3em;
    }

    .e-rating__face:after {
        background-color: hsla(0, 0%, 0%, 0.2);
        content: "";
        display: block;
        position: absolute;
        bottom: -0.125em;
        left: calc(50% - 1em);
        width: 2em;
        height: 0.25em;
        transform: translateY(0) scale(0);
        z-index: -1;
    }

    .e-rating__face-inner {
        position: relative;
        margin: 0.5em 0.75em;
        width: 1.5em;
        height: 2em;
    }

    .e-rating__eye,
    .e-rating__tear,
    .e-rating__mouth {
        position: absolute;
    }

    .e-rating__eye {
        background-color: hsl(0, 0%, 0%);
        border-radius: 50%;
        top: 0.5em;
        left: 0;
        width: 0.5em;
        height: 0.5em;
    }

    .e-rating__eye:nth-child(2) {
        right: 0;
        left: auto;
    }

    .e-rating__tear {
        background-color: hsl(210, 90%, 65%);
        border-radius: 0 50% 50% 50%;
        top: 1.5em;
        left: 0.5em;
        width: 0.5em;
        height: 0.5em;
        transform: scaleX(0) rotate(45deg);
        z-index: 1;
    }

    .e-rating__tear+.e-rating__tear {
        right: 0.5em;
        left: auto;
    }

    .e-rating__face--1 .e-rating__mouth {
        box-shadow: 0 0 0 0.125em hsla(0, 0%, 0%, 0.4) inset;
        border-radius: 0.75em;
        clip-path: polygon(0 0, 100% 0, 100% 30%, 50% 50%, 0 30%);
        top: 1.25em;
        width: 1.5em;
        height: 1.5em;
    }

    .e-rating__face--2 .e-rating__mouth {
        background-color: hsla(0, 0%, 0%, 0.4);
        border-radius: 0.125em;
        bottom: 0.25em;
        left: 0.25em;
        width: 1em;
        height: 0.125em;
    }

    .e-rating__face--3 .e-rating__eye,
    .e-rating__face--4 .e-rating__eye {
        background-color: transparent;
        box-shadow: 0 0.5em 0 hsl(0, 0%, 0%) inset;
    }

    .e-rating__face--3 .e-rating__mouth {
        box-shadow: 0 0 0 0.125em hsla(0, 0%, 0%, 0.4) inset;
        border-radius: 0.75em;
        clip-path: polygon(50% 50%, 100% 70%, 100% 100%, 0 100%, 0 70%);
        top: 0.5em;
        width: 1.5em;
        height: 1.5em;
    }

    .e-rating__face--4 .e-rating__mouth,
    .e-rating__face--5 .e-rating__mouth {
        clip-path: polygon(0 67%, 100% 67%, 100% 100%, 0 100%);
    }

    .e-rating__face--4 .e-rating__mouth {
        background-color: #fff;
        border-radius: 0.75em;
        top: 0.5em;
        width: 1.5em;
        height: 1.5em;
    }

    .e-rating__face--5 .e-rating__eye {
        background-color: transparent;
        transform: rotate(-20deg);
    }

    .e-rating__face--5 .e-rating__eye+.e-rating__eye {
        transform: rotate(20deg);
    }

    .e-rating__face--5 .e-rating__eye:before,
    .e-rating__face--5 .e-rating__eye:after {
        background-color: hsl(0, 90%, 55%);
        border-radius: 0.25em 0.25em 0 0;
        content: "";
        display: block;
        position: absolute;
        bottom: 0;
        width: 0.5em;
        height: 0.75em;
        transform-origin: 50% 0.5em;
    }

    .e-rating__face--5 .e-rating__eye:before {
        transform: rotate(45deg);
    }

    .e-rating__face--5 .e-rating__eye:after {
        transform: rotate(-45deg);
    }

    .e-rating__face--5 .e-rating__mouth {
        background-color: hsla(0, 0%, 0%, 0.4);
        border-radius: 0.75em;
        top: 0.5em;
        width: 1.5em;
        height: 1.5em;
    }

    .e-rating__range[value="1"]+.e-rating__faces .e-rating__face--1,
    .e-rating__range[value="2"]+.e-rating__faces .e-rating__face--2,
    .e-rating__range[value="3"]+.e-rating__faces .e-rating__face--3,
    .e-rating__range[value="4"]+.e-rating__faces .e-rating__face--4,
    .e-rating__range[value="5"]+.e-rating__faces .e-rating__face--5 {
        transform: translateY(-2em);
    }

    .e-rating__range[value="1"]+.e-rating__faces .e-rating__face--1 .e-rating__eye {
        animation: face1-1 var(--animDur) ease-in-out infinite;
    }

    .e-rating__range[value="1"]+.e-rating__faces .e-rating__face--1 .e-rating__eye:nth-child(2) {
        animation: face1-2 var(--animDur) ease-in-out infinite;
    }

    .e-rating__range[value="1"]+.e-rating__faces .e-rating__face--1 .e-rating__mouth {
        animation: face1-3 var(--animDur) ease-in-out infinite;
    }

    .e-rating__range[value="1"]+.e-rating__faces .e-rating__face--1 .e-rating__face-inner {
        animation: face1-4 var(--animDur) ease-in-out infinite;
    }

    .e-rating__range[value="1"]+.e-rating__faces .e-rating__face--1 .e-rating__tear {
        animation: face1-5 var(--animDur) ease-in-out infinite;
    }

    .e-rating__range[value="2"]+.e-rating__faces .e-rating__face--2 .e-rating__eye {
        animation: face2-1 var(--animDur) ease-in-out infinite;
    }

    .e-rating__range[value="2"]+.e-rating__faces .e-rating__face--2 .e-rating__mouth {
        animation: face2-2 var(--animDur) ease-in-out infinite;
    }

    .e-rating__range[value="3"]+.e-rating__faces .e-rating__face--3 .e-rating__eye {
        animation: face3-1 var(--animDur) ease-in-out infinite;
    }

    .e-rating__range[value="3"]+.e-rating__faces .e-rating__face--3 .e-rating__mouth {
        animation: face3-2 var(--animDur) ease-in-out infinite;
    }

    .e-rating__range[value="3"]+.e-rating__faces .e-rating__face--3 .e-rating__face-inner {
        animation: face3-3 var(--animDur) ease-in-out infinite;
    }

    .e-rating__range[value="4"]+.e-rating__faces .e-rating__face--4 .e-rating__eye {
        animation: face4-1 var(--animDur) ease-in-out infinite;
    }

    .e-rating__range[value="4"]+.e-rating__faces .e-rating__face--4 .e-rating__mouth {
        animation: face4-2 var(--animDur) ease-in-out infinite;
    }

    .e-rating__range[value="4"]+.e-rating__faces .e-rating__face--4 .e-rating__face-inner {
        animation: face4-3 var(--animDur) ease-in-out infinite;
    }

    .e-rating__range[value="5"]+.e-rating__faces .e-rating__face--5 .e-rating__eye {
        animation: face5-1 var(--animDur) ease-in-out infinite;
    }

    .e-rating__range[value="5"]+.e-rating__faces .e-rating__face--5 .e-rating__eye:nth-child(2) {
        animation: face5-2 var(--animDur) ease-in-out infinite;
    }

    .e-rating__range[value="5"]+.e-rating__faces .e-rating__face--5 .e-rating__mouth {
        animation: face5-3 var(--animDur) ease-in-out infinite;
    }

    .e-rating__range[value="1"]+.e-rating__faces .e-rating__face--1:after,
    .e-rating__range[value="2"]+.e-rating__faces .e-rating__face--2:after,
    .e-rating__range[value="3"]+.e-rating__faces .e-rating__face--3:after,
    .e-rating__range[value="4"]+.e-rating__faces .e-rating__face--4:after,
    .e-rating__range[value="5"]+.e-rating__faces .e-rating__face--5:after {
        transform: translateY(2em) scale(1);
    }

    /* Dark theme */
    @media (prefers-color-scheme: dark) {
        :root {
            --bg: hsl(var(--hue), 10%, 20%);
            --fg: hsl(var(--hue), 10%, 90%);
        }

        .e-rating__face:after {
            background-color: hsla(0, 0%, 0%, 0.5);
        }
    }

    /* `:focus-visible` support */
    @supports selector(:focus-visible) {
        .e-rating__range:focus::-webkit-slider-thumb {
            background-color: var(--primary1);
        }

        .e-rating__range:focus-visible::-webkit-slider-thumb,
        .e-rating__range::-webkit-slider-thumb:hover {
            background-color: var(--primary2);
        }

        .e-rating__range:focus::-moz-range-thumb {
            background-color: var(--primary1);
        }

        .e-rating__range:focus-visible::-moz-range-thumb,
        .e-rating__range::-moz-range-thumb:hover {
            background-color: var(--primary2);
        }
    }

    /* Animations */
    @keyframes face1-1 {

        from,
        75%,
        to {
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
        }

        25%,
        50% {
            clip-path: polygon(0 67%, 100% 0, 100% 100%, 0 100%);
        }
    }

    @keyframes face1-2 {

        from,
        75%,
        to {
            clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
        }

        25%,
        50% {
            clip-path: polygon(0 0, 100% 67%, 100% 100%, 0 100%);
        }
    }

    @keyframes face1-3 {

        from,
        75%,
        to {
            clip-path: polygon(0 0, 100% 0, 100% 30%, 50% 50%, 0 30%);
        }

        25%,
        50% {
            clip-path: polygon(0 0, 100% 0, 100% 40%, 50% 40%, 0 40%);
        }
    }

    @keyframes face1-4 {

        from,
        75%,
        to {
            transform: translateY(0);
        }

        25% {
            animation-timing-function: ease-in;
            transform: translateY(0.25em);
        }

        37.5% {
            animation-timing-function: ease-out;
            transform: translateY(0.125em);
        }

        50% {
            animation-timing-function: ease-in;
            transform: translateY(0.25em);
        }
    }

    @keyframes face1-5 {

        from,
        25% {
            opacity: 1;
            transform: translateY(0) scaleX(0) rotate(45deg);
        }

        to {
            opacity: 0;
            transform: translateY(2.5em) scaleX(1) rotate(45deg);
        }
    }

    @keyframes face2-1 {

        from,
        87.5% {
            transform: scaleY(1);
        }

        93.75% {
            transform: scaleY(0);
        }
    }

    @keyframes face2-2 {

        from,
        75%,
        to {
            transform: scaleX(1);
        }

        25%,
        50% {
            transform: scaleX(1.75);
        }
    }

    @keyframes face3-1 {

        from,
        75%,
        to {
            box-shadow: 0 0.5em 0 hsl(0, 0%, 0%) inset;
        }

        25%,
        50% {
            box-shadow: 0 0.375em 0 hsl(0, 0%, 0%) inset;
        }
    }

    @keyframes face3-2 {

        from,
        75%,
        to {
            clip-path: polygon(50% 50%, 100% 70%, 100% 100%, 0 100%, 0 70%);
        }

        25%,
        50% {
            clip-path: polygon(50% 50%, 100% 50%, 100% 100%, 0 100%, 0 50%);
        }
    }

    @keyframes face3-3 {

        from,
        75%,
        to {
            transform: translateY(0);
        }

        25%,
        50% {
            transform: translateY(-0.125em);
        }
    }

    @keyframes face4-1 {

        from,
        75%,
        to {
            box-shadow: 0 0.5em 0 hsl(0, 0%, 0%) inset;
        }

        25%,
        50% {
            box-shadow: 0 0.2em 0 hsl(0, 0%, 0%) inset;
        }
    }

    @keyframes face4-2 {

        from,
        75%,
        to {
            clip-path: polygon(0 67%, 100% 67%, 100% 100%, 0 100%);
            transform: scale(1);
        }

        25%,
        50% {
            clip-path: polygon(0 50%, 100% 50%, 100% 100%, 0 100%);
            transform: scale(1.25);
        }
    }

    @keyframes face4-3 {

        from,
        75%,
        to {
            transform: translateY(0);
        }

        25%,
        50% {
            transform: translateY(-0.25em);
        }
    }

    @keyframes face5-1 {
        from {
            animation-timing-function: ease-in;
            transform: rotate(-20deg) scale(1);
        }

        10%,
        30% {
            animation-timing-function: ease-out;
            transform: rotate(-20deg) scale(1.5);
        }

        20% {
            animation-timing-function: ease-in;
            transform: rotate(-20deg) scale(1.25);
        }

        40%,
        50% {
            animation-timing-function: ease-in;
            transform: rotate(-20deg) scale(1.5);
        }

        45% {
            animation-timing-function: ease-out;
            transform: rotate(5deg) scale(1.5);
        }

        75%,
        to {
            transform: rotate(-20deg) scale(1);
        }
    }

    @keyframes face5-2 {
        from {
            animation-timing-function: ease-in;
            transform: rotate(20deg) scale(1);
        }

        10%,
        30% {
            animation-timing-function: ease-out;
            transform: rotate(20deg) scale(1.5);
        }

        20% {
            animation-timing-function: ease-in;
            transform: rotate(20deg) scale(1.25);
        }

        40%,
        50% {
            animation-timing-function: ease-in;
            transform: rotate(20deg) scale(1.5);
        }

        45% {
            animation-timing-function: ease-out;
            transform: rotate(-5deg) scale(1.5);
        }

        75%,
        to {
            transform: rotate(20deg) scale(1);
        }
    }

    @keyframes face5-3 {
        from {
            animation-timing-function: ease-in;
            clip-path: polygon(0 67%, 100% 67%, 100% 100%, 0 100%);
            transform: scale(1, 1);
        }

        10%,
        30% {
            animation-timing-function: ease-out;
            clip-path: polygon(0 58%, 100% 58%, 100% 100%, 0 100%);
            transform: scale(1.25, 1.25);
        }

        20% {
            animation-timing-function: ease-in;
            clip-path: polygon(0 63%, 100% 63%, 100% 100%, 0 100%);
            transform: scale(1.375, 1);
        }

        40%,
        50% {
            animation-timing-function: ease-in-out;
            clip-path: polygon(0 58%, 100% 58%, 100% 100%, 0 100%);
            transform: scale(1.25, 1.25);
        }

        75%,
        to {
            clip-path: polygon(0 67%, 100% 67%, 100% 100%, 0 100%);
            transform: scale(1, 1);
        }
    }
</style>
<section class="py-5 account-page bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="p-4">
                            <div class="osahan-user text-center">
                                <h4 class="text-dark mt-0 mb-0"><?= $judul ?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" style="align-self: center;text-align: -webkit-center;">
                        <div class="heading-area">
                            <h4 class="title">
                                Rincian Pemesanan
                            </h4>
                        </div>
                        <div class="table-responsive-sm">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="hidden" name="kd_order" id="kd_order" value="<?= $order['kd_order'] ?>">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th class="45%" width="45%">Kode Order</th>
                                                <td width="10%">:</td>
                                                <td class="45%" width="45%"><?= $order['kd_order'] ?></td>
                                            </tr>
                                            <tr>
                                                <th width="45%">Total Pembayaran</th>
                                                <td width="10%">:</td>
                                                <td class="45% rupiah-mask txt_total_transfer" width="45%"><?= $order['total_transfer'] ?></td>
                                            </tr>
                                            <tr>
                                                <th width="45%">Tanggal Order</th>
                                                <td width="10%">:</td>
                                                <td class="45%" width="45%"><?= format_hari_tanggal($order['tgl_order']) ?></td>
                                            </tr>
                                            <tr>
                                                <th width="45%">Status Order</th>
                                                <td width="10%">:</td>
                                                <td class="45%" width="45%" id="status_order">
                                                    <?php
                                                    switch ($order['order_status']) {
                                                        case 'pending':
                                                            echo "Pending";
                                                            break;
                                                        case 'onprocess':
                                                            echo "Diproses";
                                                            break;
                                                        case 'ondelivery':
                                                            echo "Dikirim";
                                                            break;
                                                        case 'rejected':
                                                            echo "Ditolak";
                                                            break;
                                                        case 'done':
                                                            echo "Selesai";
                                                            break;
                                                    }
                                                    ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th width="45%">Status Pembayaran</th>
                                                <td width="10%">:</td>
                                                <?php $data_bukti_pembayaran = $this->db->get_where('bukti_pembayaran', ['kd_order' => $order['kd_order']])->result_array(); ?>
                                                <td class="45%" width="45%"><span class="badge <?= $order['payment_status'] == 0 ? 'badge-danger' : 'badge-success' ?>" id="status_bayar" style="padding: 5%;">
                                                        <?= $order['payment_status'] == 0 ? "Belum Dibayar" : "Sudah Dibayar"  ?> </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="45%">Keterangan Order</th>
                                                <th width="10%">:</th>
                                                <td width="45%" style="text-align: justify;"><?= $order['catatan_order'] ?></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-6">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th width="45%">Nama Pengirim</th>
                                                <td width="10%">:</td>
                                                <td width="45%"><?= !empty($order['nm_member']) ? $order['nm_member'] : $order['cust_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <th width="45%">Email</th>
                                                <td width="10%">:</td>
                                                <td width="45%"><?= !empty($order['email']) ? $order['email'] : $order['cust_email'] ?></td>
                                            </tr>
                                            <tr>
                                                <th width="45%">Telepon</th>
                                                <td width="10%">:</td>
                                                <td width="45%"><?= !empty($order['no_telp']) ? $order['no_telp'] : $order['cust_phone'] ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="45%">Kode Pos</th>
                                                <td width="10%">:</td>
                                                <td width="45%"><?= !empty($order['kodepos']) ? $order['kodepos'] : $order['cust_office'] ?></td>
                                            </tr>
                                            <tr>
                                                <th width="45%">Alamat</th>
                                                <td width="10%">:</td>
                                                <td width="45%" style="text-align: justify;"><?= $order['cust_address'] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="special-box">
                            <div class="heading-area">
                                <h4 class="title">
                                    Produk Yang Di Order
                                </h4>
                            </div>
                            <input type="hidden" name="kd_order" id="kd_order" value="<?= $order['kd_order'] ?>">
                            <input type="hidden" name="kd_member1" id="kd_member1" value="<?= $order['kd_member'] ?>">
                            <br>
                            <div class="table-responsive-sm">
                                <table class="table table-bordered table-hover" id="mytableOrderProduk">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="10%">Nomor</th>
                                            <th class="text-center">Nama Menu</th>
                                            <th class="text-center">Harga Menu</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        for ($i = 0; $i < count($detail_order); $i++) {
                                            $this->db->select("*, detail_order.qty as qtyy, produk.nm_produk as nm_produkk");
                                            $this->db->from("produk");
                                            $this->db->join("detail_order", "detail_order.kd_produk=produk.kd_produk");
                                            $this->db->where(['detail_order.kd_detail_order' => $detail_order[$i]['kd_detail_order']]);
                                            $data = $this->db->get()->row_array();

                                        ?>
                                            <tr>
                                                <td class="text-center" width="10%"><?= $no++ ?></td>
                                                <td class="text-center"><b><?= $data['nm_produkk'] ?></b> <br><?= $data['deskripsi'] ?> </td>
                                                <td class="text-center rupiah-mask"><?= $data["harga_produk"] ?></td>
                                                <td class="text-center"><?= $data['qtyy'] ?></td>
                                                <td class="text-center rupiah-mask"><?= $data["sub_total"] ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="heading-area">
                            <h4 class="title">
                                Berikan Rating Penilaianmu
                            </h4>
                        </div>
                        <div class="e-rating">
                            <label for="emoji" class="e-rating__sr">Emotion</label>
                            <input id="emoji" class="e-rating__range" type="range" value="1" min="1" max="5">
                            <div class="e-rating__faces">
                                <div class="e-rating__face e-rating__face--1">
                                    <div class="e-rating__face-inner">
                                        <div class="e-rating__eye"></div>
                                        <div class="e-rating__eye"></div>
                                        <div class="e-rating__mouth"></div>
                                    </div>
                                    <div class="e-rating__tear"></div>
                                    <div class="e-rating__tear"></div>
                                </div>
                                <div class="e-rating__face e-rating__face--2">
                                    <div class="e-rating__face-inner">
                                        <div class="e-rating__eye"></div>
                                        <div class="e-rating__eye"></div>
                                        <div class="e-rating__mouth"></div>
                                    </div>
                                </div>
                                <div class="e-rating__face e-rating__face--3">
                                    <div class="e-rating__face-inner">
                                        <div class="e-rating__eye"></div>
                                        <div class="e-rating__eye"></div>
                                        <div class="e-rating__mouth"></div>
                                    </div>
                                </div>
                                <div class="e-rating__face e-rating__face--4">
                                    <div class="e-rating__face-inner">
                                        <div class="e-rating__eye"></div>
                                        <div class="e-rating__eye"></div>
                                        <div class="e-rating__mouth"></div>
                                    </div>
                                </div>
                                <div class="e-rating__face e-rating__face--5">
                                    <div class="e-rating__face-inner">
                                        <div class="e-rating__eye"></div>
                                        <div class="e-rating__eye"></div>
                                        <div class="e-rating__mouth"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary btn-block btn-lg" id="tambahrating">Tambah Rating</button>
                    </div>
                </div>
            </div>
        </div>
</section>

<script>
    window.addEventListener("DOMContentLoaded", () => {
        const emojiRating = new EmojiRating("#emoji")
    });

    class EmojiRating {
        constructor(qs) {
            this.input = document.querySelector(qs);

            if (this.input) {
                this.input.addEventListener("input", this.refreshValue.bind(this));
                this.input.value = this.input.min;
                console.log(this.input.value);
            }
        }
        refreshValue(e) {
            this.input.defaultValue = e.target.value;
        }

    }
</script>