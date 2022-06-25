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
                                    <a href="<?= base_url('member/export_excel_member/0') ?>" class="btn btn-success"><i class="fa fa-file-excel"></i> Export Data Member</a>
                                </h1>
                            </div>
                            <div id="mytableMember_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div id="mytableMember_filter" class="dataTables_filter mt-4" style="float: right;">
                                    Search:<input type="search" id="search_member2" class="form-control form-control-sm" aria-controls="mytableSupplier">
                                </div>
                            </div>
                            <br>
                            <table class="table table-hover text-nowrap table-striped table-bordered" id="mytableMemberTdkAktif">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama Member</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No Telepon</th>
                                        <th>Email</th>
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

<!-- MODAL EDIT -->
<form id="editMember">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-group">
                            <label for="nm_member">Nama Member</label>
                            <input type="text" name="nm_member" class="form-control" id="nm_member_edit" placeholder="">
                            <input type="hidden" name="kd_member" class="form-control" id="kd_member_edit" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="no_telp">Nomer Telepon (Whatsapp)</label>
                            <input type="text" name="no_telp" class="form-control" id="no_telp_edit" placeholder="" onkeypress="return hanyaAngka(event)" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email_edit" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="jk">Jenis Kelamin</label>
                            <select name="jk" id="jk_editt" class="form-control">
                                <option value="laki-laki">Laki Laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat_edit" class="textarea" placeholder="Place some text here" style="width: 100%; height: 10px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="kecamatan">Kecamatan</label>
                            <!-- <select class="form-control select2tujuan" name="pilihankecamatan" id="pilihankecamatan_edit" style="width: 100%;" required>
                                <option value="Pilih kecamatan">Pilih Kecamatan</option>
                            </select> -->
                            <select class="form-control select2tujuan" name="pilihankecamatan" id="pilihankecamatan_edit" required>
                                <option value="">Pilih Kecamatan</option>
                            </select>
                            <input type="hidden" class="form-control" name="kecamatan_baru_hid" id="kecamatan_baru_hid_edit">
                        </div>
                        <div class="form-group">
                            <label for="kode_pos">Kode Pos</label>
                            <input type="text" name="kode_pos" class="form-control" id="kode_pos_edit" placeholder="">
                        </div>
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" name="checkboxsosmed" id="checkboxsosmed_edit">
                            <label for="checkboxsosmed_edit">
                                Add Social Media?
                            </label>
                        </div>
                        <div id="socialmedia_edit" style="display: none;">
                            <div class="form-group">
                                <label for="instagram">Instagram</label>
                                <input type="text" name="instagram" class="form-control" id="instagram_edit" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="facebook">Facebook</label>
                                <input type="text" name="facebook" class="form-control" id="facebook_edit" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="twitter">Twitter</label>
                                <input type="text" name="twitter" class="form-control" id="twitter_edit" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status_member">Status Member</label>
                            <select class="form-control" name="status_member" id="status_member_edit" style="width: 100%;" required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                            <input type="hidden" class="form-control" name="kecamatan_baru_hid" id="kecamatan_baru_hid_edit">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_save" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->

<!--MODAL DELETE-->
<form id="hapusMember">
    <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <strong>Are you sure to delete this record?</strong>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="member_code_delete" id="member_code_delete" class="form-control">
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Scan Member</h5>
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
                    <div id="scanmember" style="display: none;">
                        <center><span class="font-weight-bold text-primary" style="margin: auto; font-size:20px">Hasil Scan</span></center>
                        <table class="table table-striped mt-2">
                            <thead>
                                <tr>
                                    <th>Nama Member</th>
                                    <th>No Telepon</th>
                                    <th>Email</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status Member</th>
                                </tr>
                            </thead>
                            <tbody id="bodymember1">

                            </tbody>
                        </table>

                        <table class="table table-striped mt-2">
                            <thead>
                                <tr>
                                    <th>Kecamatan</th>
                                    <th>Kodepos</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <tbody id="bodymember2">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!--END MODAL SCAN-->

<!-- MODAL PRINT QRCODE -->
<div class="modal fade" id="Modal_Print" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="labelMember"></h5>
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