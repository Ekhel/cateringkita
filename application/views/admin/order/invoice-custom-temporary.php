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

        /* table,
        td,
        th {
            border: 2px solid black;
        } */

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

<body>
    <div class="bingkai">
        <table class="table-resi-kanan" style="float: left;">
            <!-- <thead> -->
            <tr>
                <td style="width: 35%;padding-top: 15px;" align="center" valign="center">
                    <img src="<?= base_url('assets/images/selera-mart.jpg') ?>" width="100px" alt="">
                    <center>
                        <label for="" class="text_resi">Taman Sari Persada Blok B2/5B</label>
                        <label for="" class="text_resi">Tanah Sareal - Bogor 15151</label>
                        <label for="" class="text_resi">Telp / WA : 08118883439</label>
                    </center>
                </td>
                <td style="width: 5%;"></td>
                <td colspan="6" style="width: 60%;" valign="left">
                    <h1>Kepada Pelanggan :</h1>
                    <label style="font-size:10px" for="" class="text_resi">Kode Pemesanan : <?= $temporary_order[0]['kd_temporary_order'] ?></label><br>
                    <label style="font-size:10px" for="" class="text_resi">Nama/NID : <?= $temporary_order[0]['cust_name'] ?></label><br>
                    <label style="font-size:10px" for="" class="text_resi">Nama Cust : <?= $temporary_order[0]['cust_name'] ?></label><br>
                    <label style="font-size:10px" for="" class="text_resi">No. Telp : <?= $temporary_order[0]['cust_phone'] ?></label><br>
                    <label style="font-size:10px" for="" class="text_resi">Alamat : <?= strip_tags(str_replace(substr($temporary_order[0]['cust_address'], 70), "...", $temporary_order[0]['cust_address']))  ?></label><br>
                    <label style="font-size:10px" for="" class="text_resi">Kecamatan : <?= ucfirst(str_replace(substr($temporary_order[0]['cust_subdistrict'], 40), "...", $temporary_order[0]['cust_subdistrict']))  ?></label><br>
                    <label style="font-size:10px" for="" class="text_resi">Kode Pos : <?= $temporary_order[0]['cust_office'] ?></label>
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
                            <td style="padding-top: 10px;">: <?= format_hari_tanggal($temporary_order[0]['tgl_order']) ?></td>
                        </tr>
                    </table>
                    <table style="width: 100%;">
                        <tr>
                            <th align="center" style="width: 5%; font-size: 10px ">No.</th>
                            <th style="width: 35%; font-size: 10px">Produk</th>
                            <th style="width: 10%; font-size: 10px">Jml</th>
                            <th style="width: 15%; font-size: 10px">Harga</th>
                            <th style="width: 25%; font-size: 10px">Sub Total</th>
                        </tr>
                        <?php $no = 1;
                        foreach ($temporary_order as $ord) { ?>
                            <tr>
                                <td align="center" style="font-size: 9px"><?= $no++ ?></td>
                                <td align="center" style="font-size: 9px"><?= str_replace(substr($ord['nm_produk'], 27), "...", $ord['nm_produk']) ?></td>
                                <td align="center" style="font-size: 9px"><?= $ord['qty'] ?></td>
                                <td align="center" style="font-size: 9px"><?= rupiah_resi($ord['harga_produk']) ?></td>
                                <td align="center" style="font-size: 9px;  font-weight: bold;"><?= rupiah_resi($ord['sub_total']) ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px;"></td>
            </tr>
            <tr>
                <td colspan="4"> </td>
                <td style="font-size: 10px;  font-weight: bold;" colspan="2" align="left">
                    Total Biaya
                </td>
                <td style="font-size: 9px; font-weight: bold;" colspan="2" align="left">
                    : <?= rupiah_resi($temporary_order[0]['total_harga']) ?>
                </td>
            </tr>

            <!-- </tbody> -->
        </table>
        <table class="footer">
            <tr>
                <td style="width: 100%;">
                    <table class="table-resi-kanan1" style=" width: 400px;padding-top: 15px;">
                        <tr>
                            <td colspan="8" align="left" valign="top" style="font-size: 10px;"><br><br><br><br>
                                <pre style="font-family: sans-serif;"><b>Catatan Pesanan</b> : <br><?= !empty($temporary_order[0]['catatan_order']) ? $temporary_order[0]['catatan_order'] : "Tidak Ada"; ?></pre>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="8" valign="top" style="font-size: 15px; font-weight:bold;">
                                <?= $temporary_order[0]['kd_temporary_order'] ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
    </div>
</body>

</html>
<?php
function rupiah_resi($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}
?>