<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Load paper.css for happy printing -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"> -->
    <title>Document</title>
    <style>
        @page {
            margin: 0px;
            padding-top: 50px;
        }

        body {
            margin: 0px;
            font-family: 'calibri';
            /* font-weight: bold; */
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 30%;
            font-size: 10px;
        }

        .bingkai {
            position: absolute;
            z-index: 2;
            width: 95%;
            height: 95%;
            display: flex;
            /* width: 8cm;
            height: 8cm; */
            background: white;
            padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 10px;
            padding-right: 10px;
            /* border: 1px solid #000000; */
        }

        #watermark {
            position: relative;
            z-index: 1;
            margin-left: 7%;
            margin-top: 10%;
            width: 350px;
            height: 350px;
            opacity: .1;
        }

        #logo {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        #hapus {
            margin-top: 2px;
            margin-bottom: 2px;
        }

        #hapus1 {
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .table-resi {
            width: 49%;
            border-right: 2px solid #000000;
            height: 100%;
        }

        .table-resi-kanan {
            border-color: black;
            border-collapse: collapse;
            /* height: 100%; */
            /* width: 100%; */
            font-size: 8px;
            margin-top: 40px;
        }

        .table-resi-kanan1 {
            border-color: black;
            border-collapse: collapse;
            height: 100%;
            width: 100%;
            font-size: 8px;
        }

        .table-resi-kanan .height-td td {
            height: 10px;
        }

        .text_resi {
            font-size: 10px;
        }

        /* tr.border_bottom td {
            float: right;
            border-bottom: 1px solid black;
            border-top: 1px solid black;
        } */
    </style>
</head>

<?php if ($order[0]['payment_status'] == 0) {
    $status = "Belum Dibayar";
} else if ($order[0]['payment_status'] == 1) {
    $status = "Sudah Dibayar";
}

if ($order[0]['payment_type'] == "ambil_langsung") {
    $order[0]['payment_type'] = "Tunai";
}

$data = "";
?>

<body>
    <div class="bingkai">
        <table class="table-resi-kanan" style="float: left;">
            <!-- <thead> -->
            <tr>
                <td style="width: 35%;padding-top: 15px;" align="center" valign="center">
                    <img src="<?= base_url('assets/images/selera-mart.jpg') ?>" width="100px" alt="">
                    <center>
                        <?php if ($order[0]['order_toko'] == "tsp") { ?>
                            <label for="" class="text_resi">Taman Sari Persada Blok B2/5B</label>
                            <label for="" class="text_resi">Tanah Sareal - Bogor 15151</label>
                            <label for="" class="text_resi">Telp / WA : 08118880439</label><br><br>
                        <?php } else {  ?>
                            <label for="" class="text_resi">Jl. Sholeh Iskandar No. 282 RT 05/04</label>
                            <label for="" class="text_resi">(Samping Pintu Gerbang Perum Bogor Raya Permai)</label>
                            <label for="" class="text_resi">Telp / WA : 08119594477</label><br><br>
                        <?php }  ?>

                        <label for="" class="text_resi">Metode Pembayaran : <b><?= ucfirst($order[0]['payment_type']) ?></b></label><br>
                        <label for="" class="text_resi">Pembayaran : <b><?= $status  ?></b></label>
                    </center>
                </td>
                <td style="width: 5%;"></td>
                <td colspan="6" style="width: 60%;" valign="left">
                    <h1>Kepada Pelanggan :</h1>
                    <label style="font-size:10px" for="" class="text_resi">Kode Pemesanan : <?= $order[0]['kd_order'] ?></label><br>
                    <label style="font-size:10px" for="" class="text_resi">Nama/NID : <?= $order[0]['kd_reseller'] == "#" ? "Tidak ada Reseller" : $order[0]['nm_reseller']  ?></label><br>
                    <label style="font-size:10px" for="" class="text_resi">Nama Cust : <?= $order[0]['cust_name'] ?></label><br>
                    <label style="font-size:10px" for="" class="text_resi">No. Telp : <?= $order[0]['cust_phone'] ?></label><br>
                    <label style="font-size:10px" for="" class="text_resi">Alamat : <?= str_replace(substr(strip_tags($order[0]['cust_address']), 70), "...", strip_tags($order[0]['cust_address']))  ?></label><br>
                    <label style="font-size:10px" for="" class="text_resi">Kecamatan : <?= ucfirst(str_replace(substr($order[0]['cust_subdistrict'], 40), "...", $order[0]['cust_subdistrict']))  ?></label><br>
                    <label style="font-size:10px" for="" class="text_resi">Kode Pos : <?= $order[0]['cust_office'] ?></label>
                </td>
            </tr>
            <tr>
                <td colspan="8">
                    <hr>
                </td>
            </tr>
            <!-- </thead>
            <tbody> -->

            <tr>
                <td colspan="8">
                    <table style="width: 100%; margin-top: -10px;">
                        <tr style="font-weight: bold;">
                            <td style="padding-top: 10px;">Tanggal Order</td>
                            <td style="padding-top: 10px;">: <?= format_hari_tanggal($order[0]['tgl_order']) ?></td>
                            <td style="padding-top: 10px;">Tanggal Pesan</td>
                            <td style="padding-top: 10px;">: <?= format_hari_tanggal($order[0]['tgl_order']) ?></td>
                        </tr>
                    </table>
                    <table style="width: 100%;">
                        <tr>
                            <th align="center" style="width: 5%; font-size: 10px ">No.</th>
                            <th style="width: 35%; font-size: 10px">Produk</th>
                            <th style="width: 10%; font-size: 10px">Jml</th>
                            <th style="width: 15%; font-size: 10px">Harga</th>
                            <th style="width: 15%; font-size: 10px">Diskon</th>
                            <th style="width: 25%; font-size: 10px">Sub Total</th>
                        </tr>
                        <?php $no = 1;
                        $tampunganSubTotal = [];
                        $tampunganNama = [];

                        for ($i = 0; $i < count($order); $i++) {
                            if (substr($order[$i]['kd_produk'], 0, 2) == "PR") {
                                $this->db->select("*, detail_order.qty as qtyy, produk.nm_produk as nm_produkk");
                                $this->db->from("promo");
                                $this->db->join("detail_promo", "promo.kd_promo=detail_promo.kd_promo");
                                $this->db->join("detail_produk", "detail_promo.kd_detail_produk=detail_produk.kd_detail_produk");
                                $this->db->join("produk", "produk.kd_produk=detail_produk.kd_produk");
                                $this->db->join("detail_order", "detail_order.kd_produk=detail_promo.kd_promo");
                                $this->db->where(['detail_order.kd_detail_order' => $order[$i]['kd_detail_order']]);
                                $data = $this->db->get()->row_array();

                                $kdd = substr($order[$i]['kd_produk'], 0, 2);
                                array_push($tampunganNama, $data['nm_produkk']);
                        ?>
                                <tr>
                                    <td align="center" style="font-size: 9px"><?= $no++ ?></td>
                                    <td align="center" style="font-size: 9px"><?= str_replace(substr($kdd == "PR" ? $data['nama_promo'] : $data['nm_produkk'], 27), "...", $kdd == "PR" ? $data['nama_promo'] : $data['nm_produkk']) ?></td>
                                    <td align="center" style="font-size: 9px"><?= $data['qtyy'] ?></td>
                                    <td align="center" style="font-size: 9px"><?= rupiah_resi($data['harga_produk']) ?></td>
                                    <td align="center" style="font-size: 9px"><?= rupiah_resi($data['diskon']) ?></td>
                                    <td align="center" style="font-size: 9px;  font-weight: bold;"><?= rupiah_resi($data['sub_total']) ?></td>
                                </tr>
                                <?php array_push($tampunganSubTotal, $data['sub_total'])  ?>
                            <?php
                            }
                            if (substr($order[$i]['kd_produk'], 0, 2) == "PS") {
                            ?>
                                <tr>
                                    <td align="center" style="font-size: 9px"><?= $no++ ?></td>
                                    <td align="center" style="font-size: 9px"><?= str_replace(substr($order[$i]['nm_produk'], 27), "...", $order[$i]['nm_produk']) ?></td>
                                    <td align="center" style="font-size: 9px"><?= $order[$i]['qty'] ?></td>
                                    <td align="center" style="font-size: 9px"><?= rupiah_resi($order[$i]['harga_produk']) ?></td>
                                    <td align="center" style="font-size: 9px"><?= rupiah_resi($order[$i]['diskon']) ?></td>
                                    <td align="center" style="font-size: 9px;  font-weight: bold;"><?= rupiah_resi($order[$i]['sub_total']) ?></td>
                                </tr>
                                <?php array_push($tampunganSubTotal, $order[$i]['sub_total'])  ?>
                        <?php }
                        } ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px;"></td>
            </tr>
            <tr>
                <td colspan="4"> </td>
                <td style="font-size: 10px; font-weight: bold;" colspan="2" align="left">
                    Sub Total
                </td>
                <td style="font-size: 9px;  font-weight: bold;" colspan="2" align="left">
                    : <?= rupiah_resi(array_sum($tampunganSubTotal)) ?>
                </td>
            </tr>
            <tr>
                <td colspan="4"> </td>
                <td style="font-size: 10px; font-weight: bold;" colspan="2" align="left">
                    Biaya Kirim
                </td>
                <td style="font-size: 9px;  font-weight: bold;" colspan="2" align="left">
                    : <?= rupiah_resi($order[0]['ongkir']) ?>
                </td>
            </tr>
            <tr>
                <td colspan="4"> </td>
                <td style="font-size: 10px; font-weight: bold;" colspan="2" align="left">
                    Diskon Tambahan
                </td>
                <td style="font-size: 9px;  font-weight: bold;" colspan="2" align="left">
                    : <?= rupiah_resi($order[0]['diskon_tambahan']) ?>
                </td>
            </tr>
            <tr>
                <td colspan="4"> </td>
                <td style="font-size: 10px;  font-weight: bold;" colspan="2" align="left">
                    Total Biaya
                </td>
                <td style="font-size: 9px; font-weight: bold;" colspan="2" align="left">
                    : <?= rupiah_resi($order[0]['total_harga']) ?>
                </td>
            </tr>

            <!-- </tbody> -->
        </table>
        <table class="footer">
            <tr>
                <td style="width: 100%;">
                    <table class="table-resi-kanan1" style=" width: 400px;padding-top: 15px;">
                        <tr>
                            <td style="width: 100px;font-size: 15px; font-weight:bold;" align="left" valign="top">
                                <img src="<?= base_url('assets/images/qrcode/order/' . $order[0]['kd_order'] . '.png') ?>" width="100px" alt=""><br>
                                <!-- <label for="" style=" font-weight: bold; font-size: 15px;">#<?= $order[0]['no_resi'] ?></label><br> -->
                                <span style="margin-left: 7px;"><?= $order[0]['kd_order'] ?></span>

                            </td>
                            <td colspan="7" align="left" valign="top" style="font-size: 10px;"><br><br><br><br>
                                <p style="font-family: sans-serif;" style="width: 100%;"><b>Catatan Pesanan</b> : <br>
                                    <?php
                                    $no = 0;
                                    if ($data != "" && substr($data['kd_produk'], 0, 2) == "PR") {
                                        $prod = "";
                                        $cou = count($tampunganNama);

                                        for ($i = 0; $i < $cou; $i++) {
                                            $prod .= strip_tags($tampunganNama[$i]);
                                            if ($cou - $i >= 2) {
                                                $prod .= ", ";
                                            }
                                        }
                                        echo "Produk Paket : " . $prod;
                                        $no = 1;
                                    }
                                    if ($order[0]['catatan_order']) {
                                        echo $no == 1 ? "<br>" : "";
                                        echo strip_tags($order[0]['catatan_order']);
                                    } else if ($data == "" && !$order[0]['catatan_order']) {
                                        echo "Tidak Ada";
                                    }
                                    ?></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
    </div>
    <?php if ($order[0]['payment_status'] == 1) { ?>
        <img id="watermark" src="<?= base_url('assets/images/watermark/lunas.png') ?>" alt="">
    <?php } else {  ?>
        <img id="watermark" src="<?= base_url('assets/images/watermark/belum-lunas.png') ?>" alt="">
    <?php }  ?>
</body>

</html>
<?php
function rupiah_resi($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}
?>