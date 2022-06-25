<?php
if ($this->session->userdata('kd_role') == "1" || $this->session->userdata('kd_role') == "3") {
} else {
    $this->session->set_flashdata('error', 'Tidak Bisa Akses Menu Tersebut. Bukan Bagian Anda!');
    redirect(base_url('dashboard'));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <title>Document</title>
    <style>
        @page {
            size: legal;
        }

        body {
            margin: 0px;
            font-family: 'calibri';
            font-weight: bold;
        }

        .bingkai {
            width: 12.5cm;
            height: 18.5cm;
            /* background: red; */
            padding-left: 20px;
            padding-right: 20px;
            border: 1px solid #000000;
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
    </style>
</head>

<body>
    <div class="bingkai">
        <div class="row">
            <div class="col-md-5">
                <?php $data = $this->db->get('logo')->row_array(); ?>
                <img src="<?= !empty($data['nm_logo']) ? base_url('assets/images/logo_website/' . $data['nm_logo']) : base_url('assets/images/noimage.png') ?>" id="logo" height="50px" alt="" srcset="">
                <!-- <img src="" alt="AdminLTE Logo" id="logo" height="50px" alt="" srcset="" class="brand-image img-thumbnail bg-transparent border-transparent"> -->
                <p style="font-size: 12px; text-align:center; margin-top: 5px;">Tamansari Persada Blok B2/58 <br> Tanah Sareal-Bogor 15151 <br> Telp / WA : 08118883439</p>
            </div>
            <div class="col-md-7">
                <span style="font-weight: bold; font-size: 14px;">Kepada Pelanggan : </span>
                <table style="font-size: 12px;">
                    <tr>
                        <td class="view_invoice">Nama/NID</td>
                        <td class="view_invoice"> : </td>
                        <td class="view_invoice"><?= $order[0]['nm_member'] ?></td>
                    </tr>
                    <tr>
                        <td class="view_invoice">Nama Cust</td>
                        <td class="view_invoice"> : </td>
                        <td class="view_invoice"><?= $order[0]['cust_name'] ?></td>
                    </tr>
                    <tr>
                        <td class="view_invoice">No. Telp</td>
                        <td class="view_invoice"> : </td>
                        <td class="view_invoice"><?= $order[0]['cust_phone'] ?></td>
                    </tr>
                    <tr>
                        <td class="view_invoice">Alamat</td>
                        <td class="view_invoice"> : </td>
                        <td class="view_invoice"><?= str_replace(substr($order[0]['cust_address'], 70), "...", $order[0]['cust_address'])  ?></td>
                        <!-- <td class="view_invoice"><?= $order[0]['cust_address']  ?></td> -->
                    </tr>
                    <tr>
                        <td class="view_invoice">Kecamatan</td>
                        <td class="view_invoice"> : </td>
                        <td class="view_invoice"><?= str_replace(substr($order[0]['cust_subdistrict'], 40), "...", $order[0]['cust_subdistrict'])  ?></td>
                    </tr>
                    <tr>
                        <td class="view_invoice">Kode Pos</td>
                        <td class="view_invoice"> : </td>
                        <td class="view_invoice"><?= $order[0]['cust_office'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <table style="font-size: 12px;">
                    <tr>
                        <td class="view_invoice">No. Order / Tgl Kirim</td>
                        <td class="view_invoice"> : </td>
                        <td class="view_invoice"><?= $order[0]['kd_order'] . " / " . substr($order[0]['tgl_order'], 0, 10) ?></td>
                    </tr>
                    <tr>
                        <td class="view_invoice">No. / Tgl Pesanan</td>
                        <td class="view_invoice"> : </td>
                        <td class="view_invoice"><?= $order[0]['kd_order'] . " / " . substr($order[0]['tgl_order'], 0, 10) ?></td>
                    </tr>
                    <tr>
                        <td class="view_invoice">Produk</td>
                        <td class="view_invoice"> : </td>
                        <td class="view_invoice"></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-5">
                <table style="font-size: 12px;">
                    <tr>
                        <td class="view_invoice">Pembayaran</td>
                        <td class="view_invoice"> : </td>
                        <?php if ($order[0]['payment_type'] == "transfer") { ?>
                            <td class="view_invoice">Transfer</td>
                        <?php } else if ($order[0]['payment_type'] == "cod") { ?>
                            <td class="view_invoice">COD</td>
                        <?php } else { ?>
                            <td class="view_invoice">Diambil Langsung</td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td class="view_invoice">Nama / No. Ref</td>
                        <td class="view_invoice"> : </td>
                        <td class="view_invoice"><?= $order[0]['nm_reseller'] . " / " . $order[0]['kd_reseller'] ?></td>
                    </tr>
                    <tr>
                        <td class="view_invoice">Catatan</td>
                        <td class="view_invoice"> : </td>
                        <td class="view_invoice"><?= $order[0]['catatan_order'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- <hr> -->
        <div class="row" style="margin-top: -10px;">
            <div class="col-md-12">
                <table style="font-size: 12px;">
                    <tr>
                        <th align="center" width="5px">No.</th>
                        <th width="5px">Kode.</th>
                        <th>Produk</th>
                        <th width="15%" class="text-center">Jml</th>
                        <th width="25%" class="text-center">Harga</th>
                        <th width="25%" class="text-center">Total</th>
                    </tr>
                    <?php $no = 1;
                    foreach ($order as $ord) { ?>
                        <tr>

                            <td width="5px" class="text_invoice"><?= $no++ ?></td>
                            <td width="5px" class="text_invoice"><?= $ord['kd_detail_produk'] ?></td>
                            <td class="text_invoice"><?= str_replace(substr($ord['nm_produk'], 27), "...", $ord['nm_produk']) . " (" . $ord['berat_produk'] . " " . $ord['satuan_berat_produk'] . ")" ?></td>
                            <td width="15%" class="text_invoice text-center"><?= $ord['qty'] ?></td>
                            <td width="25%" class="text_invoice rupiah-mask"><?= $ord['harga_produk'] ?></td>
                            <td width="25%" class="text_invoice rupiah-mask"><?= $ord['sub_total'] ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <hr id="hapus1">
        <div class="row">
            <div class="col-md-6">
                <p style="font-size: 12px; text-align:justify; margin-top: 5px;">TERIMAKASIH ATAS PEMBELIANNYA SEMOGA MENJADI AMAL IBADAH DAN PAHALA, BAGI SEMUA YANG TERLIBAT DALAM TRANSAKSI INI</p>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <table style="font-size: 12px;margin-top: 5px;">
                    <tr>
                        <td class="view_invoice" width="50%" align="center" width="5px">Sub Total</td>
                        <td class="view_invoice" width="5px"> : </td>
                        <td class="rupiah-mask view_invoice" width="70%"><?= $order[0]['sub_total'] ?></td>
                    </tr>
                    <tr>
                        <td class="view_invoice" width="50%" align="center" width="5px">Diskon</td>
                        <td class="view_invoice" width="5px"> : </td>
                        <td class="view_invoice rupiah-mask" width="70%"><?= $order[0]['diskon'] ?></td>
                    </tr>
                    <tr>
                        <td class="view_invoice" width="50%" align="center" width="5px">Biaya Kirim</td>
                        <td class="view_invoice" width="5px"> : </td>
                        <td class="view_invoice rupiah-mask" width="70%"><?= $order[0]['ongkir'] ?></td>
                    </tr>
                    <tr>
                        <td class="view_invoice" width="50%" align="center" width="5px">Uang Muka</td>
                        <td class="view_invoice" width="5px"> : </td>
                        <td class="view_invoice rupiah-mask" width="70%"></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <hr id="hapus">
                        </td>
                    </tr>
                    <tr>
                        <td class="view_invoice" width="50%" align="center" width="5px">Total Bayar</td>
                        <td class="view_invoice" width="5px"> : </td>
                        <td class="view_invoice rupiah-mask" width="70%"><?= $order[0]['total_transfer'] ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <table style="font-size: 12px;">
                    <tr>
                        <td class="view_invoice">Penerima Pesanan</td>
                    </tr>
                    <tr>
                        <td style="height: 15px;"></td>
                    </tr>
                    <tr>
                        <td style="">Nama : </td>
                    </tr>
                    <tr>
                        <td>Tgl : </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table style="font-size: 12px;">
                    <tr>
                        <td class="view_invoice">Penjual</td>
                    </tr>
                    <tr>
                        <td style="height: 15px;"></td>
                    </tr>
                    <tr>
                        <td style="">Nama : </td>
                    </tr>
                    <tr>
                        <td>Tgl : </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table style="font-size: 12px;">
                    <tr>
                        <td class="view_invoice">Pengirim</td>
                    </tr>
                    <tr>
                        <td style="height: 15px;"></td>
                    </tr>
                    <tr>
                        <td style="">Nama : </td>
                    </tr>
                    <tr>
                        <td>Tgl : </td>
                    </tr>
                </table>
            </div>

        </div>

        <img src="<?= base_url('assets/images/qrcode/qr.png') ?>" width="100px" height="100px" />

        <center>
            <span style="font-size: 12px;">#SaungBelanjaBerkah &nbsp;&nbsp;&nbsp; #SemuaBisaBerinfak</span>
        </center>

    </div>
</body>

</html>