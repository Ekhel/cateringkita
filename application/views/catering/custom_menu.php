<script src="<?php echo base_url()?>assets/js/jquery-1.11.3.min.js"></script>

<section id="bagian_modal_checkout">
    <?php $this->load->view('catering/modal_checkout') ?>
</section>
<section class="py-5 account-page bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <form action="<?= base_url('catering/add_member_act') ?>" method="post" enctype="multipart/form-data"> -->
                            <div class="card-header">
                                <div class="p-4">
                                    <div class="osahan-user text-center">
                                        <h4 class="text-dark mt-0 mb-0" style="font-weight: bold;">Tambah Pesanan Bulanan</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-12">
                                        <div class="shop-head mb-3">
                                            <h5 class="mb-1 text-dark text-center" style="font-weight: bold;">Daftar Menu Custom Yang Sudah dibuat</h5>
                                        </div>
                                        <?php
                                        $kat1 = $this->db->get_where('kategori', ['nm_kategori' => "Custom"])->row_array();
                                        $this->db->select('*');
                                        $this->db->from('produk');
                                        $this->db->where(['kd_kategori' => $kat1['kd_kategori']]);
                                        $this->db->where(['created_at_admin' => $this->session->userdata('kd_member')]);
                                        $this->db->where(['is_produk_hapus' => 1]);
                                        $data = $this->db->get();
                                        if ($data->num_rows() > 0) { ?>
                                            <div class="row">
                                                <?php foreach ($data->result() as $row) { ?>
                                                    <div class="col-6 col-md-3">
                                                        <div class="card list-item bg-white rounded overflow-hidden position-relative shadow-sm">
                                                            <a href="javascript:void(0)">

                                                                <img src="<?= base_url('assets/images/gallery_produk/' . $row->foto_produk) ?>" class="card-img-top" alt="..."></a>
                                                            <div class="card-body">
                                                                <h6 class="card-title mb-1"><?= ucfirst($row->nm_produk) ?> ( <?php echo $row->custom ?> )</h6>
                                                                <p class="mb-0 text-dark"><?= format_rupiah($row->harga) ?>/pax <span class="text-black-50"> </span></p>
                                                                <?php if ($row->deskripsi != "") { ?>
                                                                    <hr>
                                                                    <p class="mb-0 text-dark"><b>Deskripsi</b> : <span class="text-black-50"> </span></p>
                                                                    <p class="mb-0 text-dark"><?= $row->deskripsi ?> <span class="text-black-50"> </span></p>
                                                                <?php } ?>
                                                                <hr>
                                                                <a href="javascript:void(0)" class="btn btn-outline-primary mt-2 btn-block add_to_cart_custom" data-produk_deskripsi="<?= $row->deskripsi  ?>" data-min_order="<?= $row->min_order  ?>" data-produk_foto="<?= $row->foto_produk ?>" data-produk_id="<?= $row->kd_produk ?>" data-produk_kd="<?= $row->kd_produk ?>" data-produk_harga="<?= $row->harga ?>" data-produk_nm="<?= $row->nm_produk ?>">Pilih</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-md-12 text-center load-more"><button class="btn btn-primary btn-sm" type="button" disabled="">No Result Found</button></div>
                                        <?php } ?>
                                        <div id="load_data_message" class="row"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-body">
                                <form action="<?= base_url('catering/tambah_menu_custom') ?>" method="POST" autocomplete="off">
                                    <div class="shop-head mb-3">
                                        <h5 class="mb-1 text-dark text-center" style="font-weight: bold;">Buat Menu Custom</h5>
                                    </div>
                                    <div class="card-body osahan-payment">
                                        <!-- Penambahan Custom Pesanan !-->
                                        <div class="form-group">
                                            <label for="">Custom </label>
                                            <select name="custom" class="form-control">
                                                <option value="">Pilih Tipe</option>
                                                <option value="prasmanan">Prasmanan</option>
                                                <option value="nasi kotak">Nasi Kotak</option>
                                            </select>
                                        </div>
                                        <!-- Penambahan Custom Pesanan !-->
                                        <div class="form-group">
                                            <label for="">Lauk Utama </label>
                                            <select name="laukutama" class="form-control" id="laukutama">
                                                <option value="">Pilih Menu Custom</option>
                                                <?php if (count($laukutama) > 0) { ?>
                                                    <?php foreach ($laukutama as $key) { ?>
                                                        <option value="<?= $key['kd_custom'] ?>"><?= $key['nm_custom'] ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Lauk Pendamping </label>
                                            <select name="laukpendamping" class="form-control" id="laukpendamping">
                                                <option value="">Pilih Menu Custom</option>
                                                <?php if (count($laukpendamping) > 0) { ?>
                                                    <?php foreach ($laukpendamping as $key) { ?>
                                                        <option value="<?= $key['kd_custom'] ?>"><?= $key['nm_custom'] ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Karbohidrat </label>
                                            <select name="karbohidrat" class="form-control" id="karbohidrat">
                                                <option value="">Pilih Menu Custom</option>
                                                <?php if (count($karbohidrat) > 0) { ?>
                                                    <?php foreach ($karbohidrat as $key) { ?>
                                                        <option value="<?= $key['kd_custom'] ?>"><?= $key['nm_custom'] ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Buah </label>
                                            <select name="buah" class="form-control" id="buah">
                                                <option value="">Pilih Menu Custom</option>
                                                <?php if (count($buah) > 0) { ?>
                                                    <?php foreach ($buah as $key) { ?>
                                                        <option value="<?= $key['kd_custom'] ?>"><?= $key['nm_custom'] ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="">Sayur </label>
                                                    <select name="sayur" class="form-control" id="sayur">
                                                        <option value="">Pilih Menu Custom</option>
                                                        <?php if (count($sayur) > 0) { ?>
                                                            <?php foreach ($sayur as $key) { ?>
                                                                <option value="<?= $key['kd_custom'] ?>"><?= $key['nm_custom'] ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="">Sup </label>
                                                    <select name="sup" class="form-control" id="sayur">
                                                        <option value="">Pilih Menu Custom</option>
                                                        <?php if (count($sup) > 0) { ?>
                                                            <?php foreach ($sup as $key) { ?>
                                                                <option value="<?= $key['kd_custom'] ?>"><?= $key['nm_custom'] ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="">Kerupuk </label>
                                                    <select name="kerupuk" class="form-control" id="sayur">
                                                        <option value="">Pilih Menu Custom</option>
                                                        <?php if (count($kerupuk) > 0) { ?>
                                                            <?php foreach ($kerupuk as $key) { ?>
                                                                <option value="<?= $key['kd_custom'] ?>"><?= $key['nm_custom'] ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="">Sambal </label>
                                                    <select name="sambal" class="form-control" id="sayur">
                                                        <option value="">Pilih Menu Custom</option>
                                                        <?php if (count($sambal) > 0) { ?>
                                                            <?php foreach ($sambal as $key) { ?>
                                                                <option value="<?= $key['kd_custom'] ?>"><?= $key['nm_custom'] ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="">Minuman </label>
                                                    <select name="kerupuk" class="form-control" id="sayur">
                                                        <option value="">Pilih Menu Custom</option>
                                                        <?php if (count($minuman) > 0) { ?>
                                                            <?php foreach ($minuman as $key) { ?>
                                                                <option value="<?= $key['kd_custom'] ?>"><?= $key['nm_custom'] ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="">Snack </label>
                                                    <select name="snack" id="" class="form-control">
                                                        <option value="">Pilih Menu Custom</option>
                                                        <?php if (count($snack) > 0) { ?>
                                                            <?php foreach ($snack as $key) { ?>
                                                                <option value="<?= $key['kd_custom'] ?>"><?= $key['nm_custom'] ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <h2 class="text-center mb-0">
                                        <span class="mytooltip tooltip-effect-5">
                                            <button class="btn btn-primary btn-block btn-lg tooltip-item" id="button_submit" type="submit">
                                                <i class="icofont-simple-right float-right mt-1"></i>
                                                Buat Menu Custom
                                            </button>
                                        </span>
                                    </h2>
                                </form>
                            </div>
                            <!-- </form> -->
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <script>
    $('#xcustom').change(function() {
        var cus = $(this).val();
        $('#xminuman').prop('hidden', cus != 'prasmanan');
    });
</script> -->