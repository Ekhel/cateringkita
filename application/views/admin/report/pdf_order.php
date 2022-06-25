<?php
if (in_array('1', $dataTampunganRole)) {
} else {
    $this->session->set_flashdata('error', 'Tidak Bisa Akses Menu Tersebut. Bukan Bagian Anda!');
    redirect(base_url('dashboard'));
}
?>

<!DOCTYPE html>
<html>

<head>

    <title><?= $judul ?></title>
    <style type="text/css">
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        td {
            font-size: 10px;
        }

        th {
            font-size: 10px;
        }
    </style>
    <link rel="stylesheet" href="<?= base_url(); ?>assets/dist/css/adminlte.min.css">
</head>

<body>

    <div class="page-content">
        <div class="container-fluid">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php if ($no == 1) { ?>
                            <div class="col-md-12 mt-2">
                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div align="center" class="header-mail">
                                        </div>
                                        <center>
                                            <h5>
                                                <?php
                                                $bulan = $this->uri->segment(4);
                                                $tahun = $this->uri->segment(5);
                                                ?>
                                                <b><?= $judul; ?> - Sederhana</b><br>
                                                <!-- ganti dengan bahasa arab yang sama kaya formatnya-->
                                            </h5>
                                        </center>
                                        <hr width="100%" color="orange" style="border:solid; color:#000080;">
                                        <table class="table">
                                            <thead>
                                                <tr style=" width: 100%;">
                                                    <th>Tanggal</th>
                                                    <th>Kode Order</th>
                                                    <th>Nama Pembeli</th>
                                                    <th>Nomor Telepon</th>
                                                    <th>Total</th>
                                                    <th>Metode Pembayaran</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1;
                                                foreach ($order as $p) { ?>
                                                    <tr>
                                                        <td><?= format_hari_tanggal($p['tgl_order']) ?></td>
                                                        <td><?= $p['kd_order'] ?></td>
                                                        <td><?= $p['cust_name'] ?></td>
                                                        <td><?= $p['cust_phone'] ?></td>
                                                        <td><?= rupiah($p['total_harga']) ?></td>
                                                        <td><?php
                                                            switch ($p['payment_type']) {
                                                                case 'ambil_langsung':
                                                                    echo "Tunai";
                                                                    break;
                                                                case 'cod':
                                                                    echo "COD";
                                                                    break;
                                                                case 'transfer':
                                                                    echo "Transfer";
                                                                    break;
                                                                case 'kredit':
                                                                    echo "Kredit";
                                                                    break;
                                                            }
                                                            ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-12 mt-2">
                                <div class="card">
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div align="center" class="header-mail">
                                        </div>
                                        <center>
                                            <h5>
                                                <?php
                                                $bulan = $this->uri->segment(4);
                                                $tahun = $this->uri->segment(5);
                                                ?>
                                                <b><?= $judul; ?> - Perincian</b><br>
                                                <!-- ganti dengan bahasa arab yang sama kaya formatnya-->
                                            </h5>
                                        </center>
                                        <hr width="100%" color="orange" style="border:solid; color:#000080;">
                                        <?php foreach ($order as $p) { ?>
                                            <table style="width: 70%;">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal Order </th>
                                                        <td>: <?= format_hari_tanggal($p['tgl_order']) ?></td>
                                                        <th>Nama Pembeli </th>
                                                        <td>: <?= $p['cust_name'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Kode Order </th>
                                                        <td>: <?= $p['kd_order'] ?></td>
                                                        <th>Nomor Telepon </th>
                                                        <td>: <?= $p['cust_phone'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Metode Pembayaran </th>
                                                        <td>: <?php
                                                                switch ($p['payment_type']) {
                                                                    case 'ambil_langsung':
                                                                        echo "Tunai";
                                                                        break;
                                                                    case 'cod':
                                                                        echo "COD";
                                                                        break;
                                                                    case 'transfer':
                                                                        echo "Transfer";
                                                                        break;
                                                                    case 'kredit':
                                                                        echo "Kredit";
                                                                        break;
                                                                }
                                                                ?></td>
                                                    </tr>
                                                </thead>
                                            </table>
                                            <br>
                                            <table class="table mb-5">
                                                <thead>
                                                    <tr style="width: 100%;">
                                                        <th>Nama Menu</th>
                                                        <th>Deskripsi Produk</th>
                                                        <th>Harga</th>
                                                        <th>Qty</th>
                                                        <th>Sub Total</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $this->db->select("*, detail_order.qty as qtyy, produk.nm_produk as nm_produkk");
                                                $this->db->from("detail_order");
                                                $this->db->join("produk", "detail_order.kd_produk=produk.kd_produk");
                                                $this->db->where(['detail_order.kd_order' => $p['kd_order']]);
                                                $get = $this->db->get()->result_array();
                                                ?>
                                                <tbody>
                                                    <?php foreach ($get as $b) { ?>
                                                        <tr>
                                                            <td><?= $b['nm_produk'] ?></td>
                                                            <td><?= $b['deskripsi'] ?></td>
                                                            <td><?= rupiah($b['harga_produk']) ?></td>
                                                            <td><?= $b['qtyy'] ?></td>
                                                            <td><?= rupiah($b['sub_total']) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <th>Total Harga</th>
                                                        <th><?= rupiah($p['total_harga']) ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <hr>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>

        </div>
    </div>

    <script>
        window.print();
    </script>

    <?php
    function rupiah($angka)
    {

        $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }
    ?>
</body>

</html>