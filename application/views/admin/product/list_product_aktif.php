<?php
if (in_array('1', $dataTampunganRole)) {
} else {
    $this->session->set_flashdata('error', 'Tidak Bisa Akses Menu Tersebut. Bukan Bagian Anda!');
    redirect(base_url('dashboard'));
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $judul; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active"><?= $judul; ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <div class="col-md-12">
                                <h1>
                                    <a href="<?= base_url('product/add_produk') ?>" class="btn btn-primary"><span class="fa fa-plus"></span> Add Menu</a>
                                    <a href="<?= base_url('Product/export_excel_produk/1') ?>" class="btn btn-success"><i class="fa fa-file-excel"></i> Export Data Menu</a>
                                </h1>
                            </div>
                            <br>
                            <table class="table table-hover text-nowrap table-striped table-bordered" id="mytableProduk" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama Kategori</th>
                                        <th>Nama Menu</th>
                                        <th>Harga Menu</th>
                                        <th style="text-align: right;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Pilihan Stok Report Produk -->
<form action="<?= base_url('Product/export_excel_produk/1') ?>" method="POST">
    <div class="modal fade" id="exampleModalProd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih Jenis Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select name="pil_prodd" id="pil_prodd" class="form-control">
                        <option value="all">Semua Produk</option>
                        <option value="po">Produk Pre Order</option>
                        <option value="stock">Produk Stok</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary close-prod">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- View Detail Produk -->
<div class="modal fade view_detaill" id="setgallery" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Detail Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="modal-title mb-2 text-center">Data Produk</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Menu</th>
                                    <th>Kategori</th>
                                    <th>Nama Supplier</th>
                                </tr>
                            </thead>
                            <tbody id="demo">

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <h4 class="modal-title mb-2 text-center" style="margin-top: 20px;">Detail Data Produk</h4>
                        <table class=" table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Satuan Berat</th>
                                    <th>Harga Modal</th>
                                    <th>Harga Saat Ini</th>
                                    <th>Diskon</th>
                                    <th>Stok Barang</th>
                                    <th>Persentase Ujroh</th>
                                    <th>Total Ujroh</th>
                                    <th>Print QrCode</th>
                                </tr>
                            </thead>
                            <tbody id="demo1">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--END View Detail Produk-->

<!-- View Highlight -->
<form id="editHighlight">
    <div class="modal fade hightlight_product" id="hightlight_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hightlight Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <center>
                        <table cellpadding="10px">
                            <?php for ($i = 0; $i < count($promo); $i++) {  ?>
                                <tr>
                                    <?php
                                    $promoo[$i] = str_replace("_", " ", $promo[$i]['nm_promo']);
                                    ?>
                                    <td style="font-size: 25px;"><?= "Highlight " . $promoo[$i] ?></td>
                                    <td>
                                        <div class="switchToggle">
                                            <input type="hidden" name="kd_produk" id="kd_produk">
                                            <input type="checkbox" name="<?= strtolower($promo[$i]['nm_promo']) ?>" id="switch<?= $i ?>">
                                            <label for="switch<?= $i ?>" style="margin-top:4px">Toggle</label>
                                        </div>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </table>
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_save" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END View Highlight-->

<!--MODAL DELETE-->
<form id="hapusProduk">
    <div class="modal fade" id="hapusModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Are you sure to dssselete this record?</strong>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="product_code_delete" id="product_code_delete" class="form-control">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->

<!-- MODAL SCAN -->
<div class="modal fade" id="Modal_Scan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Scan Reseller</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center mt-0">
                    <div class="col-md-9">
                        <div class="card-header bg-transparent mb-0">
                            <h5 class="text-center">
                                <span class="font-weight-bold text-primary">Scan</span>
                            </h5>
                        </div>
                        <div class="card-body">
                            <center><video src="" id="preview" class="img-thumbnail bg-transparent border-transparent" width="350" height="350"></video></center>
                            <div class="form-group"></div><br>
                        </div>

                    </div>
                </div>
                <div class="col-md-12">
                    <div id="scanproduct" style="display: none;">
                        <center><span class="font-weight-bold text-primary" style="margin: auto; font-size:20px">Hasil Scan</span></center>
                        <table class="table table-striped mt-2">
                            <thead>
                                <tr>
                                    <th>Nama Menu</th>
                                    <th>Kategori</th>
                                    <th>Sub Kategori</th>
                                    <th>Nama Supplier</th>
                                </tr>
                            </thead>
                            <tbody id="bodyproduct1">

                            </tbody>
                        </table>

                        <table class="table table-striped mt-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Satuan Berat</th>
                                    <th>Harga Modal</th>
                                    <th>Harga Saat Ini</th>
                                    <th>Diskon</th>
                                    <th>Stok Barang</th>
                                    <th>Persentase Ujroh</th>
                                    <th>Total Ujroh</th>
                                </tr>
                            </thead>
                            <tbody id="bodyproduct2">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL SCAN-->

<!-- MODAL SCAN -->
<form id="updateStokProduk" autocomplete="off">
    <div class="modal fade" id="Modal_Stok" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Stok Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-7">
                            <div class="form-group">
                                <select name="update_stok[]" id="update_stok" class="select2produk form-control"></select>
                            </div>
                        </div>
                        <div class="col-sm-11 col-md-4">
                            <div class="form-group">
                                <input type="text" name="qty_stok[]" id="qty_stok" class="form-control" placeholder="Masukan Update Stok">
                            </div>
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <a href="javascript:void(0);" class="btn btn-success buttonupdatestokproduk"> <i class="fa fa-plus"></i></a>
                        </div>
                    </div>

                    <div class="bagiantambahstokproduk"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_save" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL SCAN-->

<!-- MODAL SCAN -->
<form id="updateKatProduk" autocomplete="off">
    <div class="modal fade" id="Modal_Kategori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Ketegori Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Pilih Kategori</label>
                                <select name="kategori" id="kategori" class="form-control select2kategori">
                                    <?php foreach ($subkategori as $sk) { ?>
                                        <option value="<?= $sk->kd_kategori ?>"><?= $sk->nm_kategori ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-11 col-md-6">
                            <div class="form-group">
                                <label>Pilih Sub Kategori</label>
                                <select name="sub_kategori" id="sub_kategori" class="form-control select2subkategori"></select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-11">
                            <div class="form-group">
                                <select name="produk[]" id="produk" class="select2produk form-control"></select>
                            </div>
                        </div>
                        <div class="col-sm-1 col-md-1">
                            <a href="javascript:void(0);" class="btn btn-success buttonupdatekatproduk"> <i class="fa fa-plus"></i></a>
                        </div>
                    </div>

                    <div class="bagiantambahkatproduk"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_save" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL SCAN-->

<!-- MODAL PRINT QRCODE -->
<div class="modal fade" id="Modal_Print" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labelProduk"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <center>
                    <div>
                        <div class="form-group mt-2">
                            <img src="" id="image-preview" alt="" class="img-thumbnail">
                        </div>

                        <a id="linkPrint" class="btn btn-primary" target="_blank">Print QrCode</a>
                    </div>
                </center>
            </div>
        </div>
    </div>
</div>
<!--END MODAL PRINT QRCODE-->

<script>
    function CopyToClipboard(containerid) {
        $.ajax({
            url: "<?php echo base_url("product/copy_produk") ?>",
            type: 'post',
            dataType: 'json',
            data: {
                pil_list_prod: 'stock',
            },
            success: function(data) {
                var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                var hari = new Date().getDay();
                var tanggal = new Date().getDate();
                var bulan = new Date().getMonth();
                var tahun = new Date().getFullYear();
                var hari_ini = tanggal + ' ' + months[bulan] + ' ' + tahun;
                var html = '<span>*UPDATE STOCK CateringKita*' + '<br>';

                html += 'Tanggal : ' + days[hari] + ', ' + hari_ini + '<br><br>';

                var no = 1;
                var tampunganKategori = [];
                var tampunganSubKategori = [];

                for (let i = 0; i < data.length; i++) {

                    if (!tampunganKategori.includes(data[i].nm_kategori + data[i].kd_sub_kategori)) {
                        tampunganKategori.push(data[i].nm_kategori + data[i].kd_sub_kategori);
                        no = 1;

                        html += '<br> *' + data[i].nm_kategori + ' (' + data[i].nm_sub_kategori + ')* <br>';
                    }

                    html += no + '. ' + data[i].nm_produk + ' (' + data[i].berat + ' ' + data[i].satuan_berat + ') *' + data[i].stok + '* <br>';

                    no++;
                }
                setTimeout(() => {
                    html += '</span>';
                    $("#divid").html(html);

                    if (document.selection) {
                        var range = document.body.createTextRange();
                        range.moveToElementText(document.getElementById(containerid));
                        range.select().createTextRange();
                        document.execCommand("copy");
                    } else if (window.getSelection) {
                        var range = document.createRange();
                        range.selectNode(document.getElementById(containerid));
                        window.getSelection().addRange(range);
                        document.execCommand("copy");
                        alert("Data was copied, please share to customers or resellers CateringKita")
                    }

                    $("#divid").html("");
                    $("#divid").show();
                }, 500);
            }
        });
    }
</script>