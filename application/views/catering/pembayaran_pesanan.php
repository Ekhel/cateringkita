<section class="py-5 account-page bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="<?= base_url('catering/upload_bukti_pembayaran') ?>" method="post" enctype="multipart/form-data">
                                <div class="card-header">
                                    <div class="p-4">
                                        <div class="osahan-user text-center">
                                            <h4 class="text-dark mt-0 mb-0"><?= $judul ?></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="control-label">Kode Order<span class="required">*</span></label>
                                        <input class="form-control border-form-control" name="kd_order" value="<?= $order['kd_order'] ?>" placeholder="Masukkan Nama Anda" type="text" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Total Transfer<span class="required">*</span></label>
                                        <input class="form-control border-form-control rupiah-mask" name="nm_member" value="<?= $order['total_harga'] ?>" placeholder="Masukkan Nama Anda" type="text" readonly required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Bank Tujuan<span class="required">*</span></label>
                                        <select name="nama_bank" id="nama_bank" class="form-control">
                                            <option value="">Pilih Bank</option>
                                            <?php $get = $this->db->get('rekening')->result_array(); ?>
                                            <?php foreach ($get as $g) { ?>
                                                <option value="<?= $g['kd_rekening'] ?>"><?= $g['nama_bank'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group row" id="bagian_bank" style="display: none;">
                                        <div class="col-6 col.md-6">
                                            <label class="control-label">Nomor Rekening <span class="required">*</span></label>
                                            <input class="form-control border-form-control" name="nomor_rekening" id="nomor_rekening" placeholder="Nomor Rekening" type="text" readonly required>
                                        </div>
                                        <div class="col-6 col.md-6">
                                            <label class="control-label">Atas Nama <span class="required">*</span></label>
                                            <input class="form-control border-form-control" name="atas_nama" id="atas_nama" placeholder="Atas Nama Bank" type="text" readonly required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Bukti Transfer<span class="required">*</span></label>
                                        <input class="form-control border-form-control" name="bukti_transfer" id="bukti_transfer" placeholder="Masukkan Bukti Transfer" type="file">
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg" id="cek_pembayaran">Lakukan Pembayaran</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>