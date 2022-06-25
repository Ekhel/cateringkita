<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Load paper.css for happy printing -->

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script> -->

    <title>Document</title>
    <style>
        @page {
            margin: 0px;
            padding-top: 20px;
        }

        body {
            margin: 0px;
            font-family: 'calibri';
            /* font-weight: bold; */
        }

        .bingkai {
            width: 21cm;
            height: 11cm;
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

        .table-resi {
            width: 25%;
            /* border-right: 2px solid #000000; */
            /* height: 100%; */
        }

        .table-resi1 {
            width: 25%;
            border-right: 2px solid #000000;
            /* height: 100%; */
        }

        .table-resi-kanan {
            border-color: black;
            border-collapse: collapse;
            /* height: 100%; */
            width: 100%;
            font-size: 8px;
        }

        .table-resi-kanan .height-td td {
            height: 20px;
        }

        .text_resi {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="bingkai">
        <table class="table-resi" align="left">
            <tr>
                <td style="padding-top: 50px;">
                    <center>
                        <img src="<?= base_url('assets/images/selera-mart.jpg') ?>" width="100px" alt=""><br>
                        <label for="" class="text_resi">Taman Sari Persada Blok B2/5B</label><br>
                        <label for="" class="text_resi">Tanah Sareal - Bogor 15151</label><br>
                        <label for="" class="text_resi">Telp / WA : 08118883439</label>
                    </center>
                </td>
            </tr>
        </table>
        <table class="table-resi-kanan" style="float: right;">
            <tr>
                <td style=" padding-left:12%;">
                    <pre style="margin-top:40px">
                    <h1 style="margin-left:16.5%">Kepada Pelanggan :</h1>
                        <label style="font-size:11px" for="" class="text_resi">Nama/NID  : <?= $order[0]['nm_member'] ?></label><br>
                        <label style="font-size:11px" for="" class="text_resi">Nama Cust : <?= $order[0]['cust_name'] ?></label><br>
                        <label style="font-size:11px" for="" class="text_resi">No. Telp  : <?= $order[0]['cust_phone'] ?></label><br>
                        <label style="font-size:11px" for="" class="text_resi">Alamat    : <?= str_replace(substr($order[0]['cust_address'], 70), "...", $order[0]['cust_address'])  ?></label><br>
                        <label style="font-size:11px" for="" class="text_resi">Kecamatan : <?= str_replace(substr($order[0]['cust_subdistrict'], 40), "...", $order[0]['cust_subdistrict'])  ?></label><br>
                        <label style="font-size:11px" for="" class="text_resi">Kode Pos  : <?= $order[0]['cust_office'] ?></label>
                    </pre>
                </td>
            </tr>
        </table>

        <pre>
        <br><br><br><br><br><br><br><br><br>
            <table style="font-size: 11px;" style="margin-top:30px">
                <tr>
                    <td class="view_invoice">No. Order/Tgl Kirim</td>
                    <td class="view_invoice">:</td>
                    <td class="view_invoice"><?= $order[0]['kd_order'] . "/" . date('d M Y', strtotime($order[0]['tgl_order'])) ?></td>
                    <td class="view_invoice">Pembayaran</td>
                    <td class="view_invoice">:</td>
                    <?php if ($order[0]['payment_type'] == "transfer") { ?>
                        <td class="view_invoice">Transfer</td>
                    <?php } else if ($order[0]['payment_type'] == "cod") { ?>
                        <td class="view_invoice">COD</td>
                    <?php } else { ?>
                        <td class="view_invoice">Tunai</td>
                    <?php } ?>
                </tr>
                <tr>
                    <td class="view_invoice">No. Order/Tgl Pesanan</td>
                    <td class="view_invoice"> : </td>
                    <td class="view_invoice"><?= $order[0]['kd_order'] . "/" . date('d M Y', strtotime($order[0]['tgl_order'])) ?></td>
                    <td class="view_invoice">Nama/No. Ref</td>
                    <td class="view_invoice"> : </td>
                    <td class="view_invoice"><?= str_replace(substr($order[0]['nm_reseller'], 15), "...", $order[0]['nm_reseller']) . "/" . $order[0]['kd_reseller'] ?></td>
                </tr>
                <tr>
                    <td class="view_invoice">Produk</td>
                    <td class="view_invoice"> : </td>
                    <td class="view_invoice"></td>
                    <td class="view_invoice">Catatan</td>
                    <td class="view_invoice"> : </td>
                    <td class="view_invoice"><?= strip_tags($order[0]['catatan_order']) ?></td>                
                </tr>
            </table>
        </pre>

        <pre>
        <br><br><br><br><br><br><br><br><br><br><br><br><br>
            <table class="table" style="font-size: 11px;" style="margin-top:30px">
                <tr>
                    <th align="center">No.</th>
                    <th>Kode.</th>
                    <th>Produk</th>
                    <th class="text-center">Jml</th>
                    <th class="text-center">Harga</th>
                    <th width="25%" class="text-center">Total</th>
                </tr>
                <?php $no = 1;
                foreach ($order as $ord) { ?>
                    <tr>

                        <td class="text_invoice"><?= $no++ ?></td>
                        <td class="text_invoice"><?= $ord['kd_detail_produk'] ?></td>
                        <td class="text_invoice"><?= str_replace(substr($ord['nm_produk'], 27), "...", $ord['nm_produk']) . " (" . $ord['berat_produk'] . " " . $ord['satuan_berat_produk'] . ")" ?></td>
                        <td class="text_invoice text-center"><?= $ord['qty'] ?></td>
                        <td class="text_invoice rupiah-mask"><?= $ord['harga_produk'] ?></td>
                        <td class="text_invoice rupiah-mask"><?= $ord['sub_total'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        </pre>

        <pre>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <table class="table-resi" style="font-size: 11px;" style="margin-top:30px">
                <tr>
                    <td>TERIMAKASIH ATAS PEMBELIAN NYA SEMOGA<br>MENJADI AMAL IBADAH DAN PAHALA BAGI<br>SEMUA YANG TERLIBAT DALAMTRANSAKSI INI</td>
                </tr>
            </table>
        </pre>

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