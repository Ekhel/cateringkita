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
                        <!-- <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div> -->
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <div class="col-md-12">
                                <h1>
                                    <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add" data-backdrop="static" data-keyboard="false"><span class="fa fa-plus"></span> Add Menu PO</a>
                                    <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" style="background-color: #20B2AA; color:white" data-target="#Modal_List" data-backdrop="static" data-keyboard="false"><span class="fa fa-copy"></span> Copy List Produk PO</a>
                                    <!-- <a href="javascript:void(0);" class="btn btn-primary" data-backdrop="static" data-keyboard="false" onclick="CopyToClipboard('divid')"><span class="fa fa-copy"></span> Copy List Produk PO</a> -->
                                    <div id="divid"></div>
                                </h1>
                            </div>
                            <br>
                            <table class="table table-hover text-nowrap table-striped table-bordered" id="mytablePo" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Waktu Mulai</th>
                                        <th>Waktu Selesai</th>
                                        <th>Banyak Produk</th>
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


<div class="modal fade" id="Modal_List" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Copy List Produk PO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-6 col-xs-6 col-6">
                        <label>Tanggal Mulai</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" name="copy_date_start" id="copy_datepickersingle" data-target="#reservationdate" />
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-6 col-6" id="bagian_tanggal_end">
                        <label>Tanggal Selesai</label>
                        <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" name="copy_date_end" id="copy_datepickersingle1" data-target="#reservationdate" />
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="btn_save_promo" class="btn btn-primary" onclick="CopyToClipboard('divid')">Save</button>
                <!-- <div id="divid" style="display:inline"></div> -->
            </div>
        </div>
    </div>
</div>

<form id="addPoProduct" autocomplete="off">
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Pre Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="display: none;">
                        <label>Jenis Promo</label>
                        <select name="jenis_promo" id="jenis_promo" class="form-control">
                            <option value="">Pilih Jenis Promo</option>
                            <option value="1">Promo Harian</option>
                            <option value="2">Promo Jangka Panjang</option>
                        </select>
                    </div>
                    <div class="form-group row" id="bagian_tanggal">
                        <div class="col-md-6 col-xs-6 col-6" id="bagian_tanggal_start">
                            <label>Tanggal Mulai</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="date_start" id="datepickersingle" data-target="#reservationdate" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6 col-6" id="bagian_tanggal_end">
                            <label>Tanggal Selesai</label>
                            <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="date_end" id="datepickersingle1" data-target="#reservationdate" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-11 col-xs-11 col-11">
                            <div class="form-group">
                                <label>Produk</label>
                                <select name="produk[]" class="form-control select2produkpo" id="produk_po" required>
                                    <option value="">Pilih Produk</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1 col-xs-1 col-1">
                            <label for="kd_supplier"></label><br>
                            <a href="javascript:void(0);" class="btn btn-success mt-2 " id="buttontambahpo"> <i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="tambah_poo">
                        <div id="bagiantambahpo"></div>
                    </div>
                    <input type="hidden" id="jmlbarang" value="100">
                    <!-- ini untuk perhitungan looping di for nya -->
                    <input type="hidden" id="jmlbarang1" value="1">
                    <!-- ini untuk index pada pertambahan -->
                    <input type="hidden" id="jmlbarangplus" value="1">
                    <!-- ini untuk index pada pengurangan -->
                    <input type="hidden" id="jmlbarangminus" value="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_save_promo" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="editPoProduct" autocomplete="off">
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Pre Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="display: none;">
                        <label>Jenis Promo</label>
                        <select name="jenis_promo" id="edit_jenis_promo" class="form-control">
                            <option value="">Pilih Jenis Promo</option>
                            <option value="1">Promo Harian</option>
                            <option value="2">Promo Jangka Panjang</option>
                        </select>
                    </div>
                    <div class="form-group row" id="edit_bagian_tanggal" style="display: none;">
                        <div class="col-md-6 col-xs-6 col-6" id="edit_bagian_tanggal_start">
                            <label>Tanggal Mulai</label>
                            <div class="input-group date" id="edit_reservationdate" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="date_start" id="edit_datepickersingle" data-target="#reservationdate" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6 col-6" id="edit_bagian_tanggal_end">
                            <label>Tanggal Selesai</label>
                            <div class="input-group date" id="edit_reservationdate1" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="date_end" id="edit_datepickersingle1" data-target="#reservationdate" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" id="edit_bagian_waktu" style="display: none;">
                        <div class="col-md-6 col-xs-6 col-6" id="edit_bagian_waktu_start">
                            <label>Waktu Mulai</label>
                            <input type="time" class="form-control" name="time_start" id="edit_time_start">
                        </div>
                        <div class="col-md-6 col-xs-6 col-6" id="edit_bagian_waktu_end">
                            <label>Waktu Selesai</label>
                            <input type="time" class="form-control" name="time_end" id="edit_time_end">
                        </div>
                    </div>
                    <div class="edit__poo">
                        <div id="edit_bagiantambahpo"></div>
                    </div>
                    <div class="edit_poo">
                        <div id="edit_bagiantambahpo1"></div>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-success mt-2 btn-block" id="editbuttontambahpo">Tambah Menu <i class="fa fa-plus"></i></a>
                    <input type="hidden" id="edit_jmlbarang" value="100">
                    <!-- ini untuk perhitungan looping di for nya -->
                    <input type="hidden" id="edit_jmlbarang1" value="1">
                    <!-- ini untuk index pada pertambahan -->
                    <input type="hidden" id="edit_jmlbarangplus" value="1">
                    <!-- ini untuk index pada pengurangan -->
                    <input type="hidden" id="edit_jmlbarangminus" value="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="edit_btn_save" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function CopyToClipboard(containerid) {
        var date_start = $("#copy_datepickersingle").val();
        var date_end = $("#copy_datepickersingle1").val();
        $.ajax({
            url: "<?php echo base_url("product/copy_produk_po") ?>",
            type: 'post',
            dataType: 'json',
            data: {
                date_start: date_start,
                date_end: date_end,
            },
            success: function(data) {
                $('#Modal_List').modal('hide');
                var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

                var hari = new Date().getDay();
                var tanggal = new Date().getDate();
                var bulan = new Date().getMonth();
                var tahun = new Date().getFullYear();
                var hari_ini = '*' + days[hari] + ', ' + tanggal + ' ' + months[bulan] + ' ' + tahun + '*';
                var html = '<span>https://www.instagram.com/p/CNRLwsOjlhV/?utm_medium=copy_link' + '<br>';
                html += '_Follow dan cek ig kita_' + '<br><br>';
                html += '*SELERA MART*' + '<br>';
                html += 'Open PO untuk ' + hari_ini + '<br><br>';
                html += '_kami close order jam 16.00 ya bund_ 🤗' + '<br>';

                var no = 1;
                var tampunganKategori = [];
                var tampunganSubKategori = [];

                for (let i = 0; i < data.length; i++) {

                    if (!tampunganKategori.includes(data[i].nm_kategori + data[i].kd_sub_kategori)) {
                        tampunganKategori.push(data[i].nm_kategori + data[i].kd_sub_kategori);
                        no = 1;

                        html += '<br> *' + data[i].nm_kategori + ' (' + data[i].nm_sub_kategori + ')* <br>';
                    }

                    html += '✅' + data[i].nm_produk + ' (' + data[i].berat + ' ' + data[i].satuan_berat + ') *' + data[i].harga_produk / 1000 + 'K* <br>';

                    no++;
                }
                html += 'Order di wa.me//628118880439' + '<br><br>';
                html += 'Masih banyak pilihan lain di :' + '<br>';
                html += 'https://wa.me/c/628118880439' + '<br><br>';
                html += 'atau di Website kami' + '<br><br>';
                html += 'https://CateringKita.com' + '<br><br>';
                html += 'Yuk, yuk, makan enak-enak 🤗';

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