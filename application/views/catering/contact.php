<section class="py-4 bg-light inner-header">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-6 col-md-6">
                <h4 class="mt-0 mb-0 text-dark">
                    Contact Us
            </div>
            <div class="col-lg-6 col-md-6 text-right">
                <div class="breadcrumbs">
                    <p class="mb-0"><a href="<?= base_url('main') ?>"><i class="icofont-ui-home"></i> Home</a> / <span>Contact Us</span></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Us -->
<?php $get = $this->db->get('konfigurasi')->result_array(); ?>
<section class="py-5 bg-light border-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="p-4 h-100 bg-white rounded overflow-hidden position-relative shadow-sm">
                    <div class="bs-example">
                        <ul class="nav nav-tabs">
                            <?php
                            $no = 0;
                            foreach ($get as $g) {
                                $no++; ?>
                                <li class="nav-item">
                                    <a href="#<?= $g['kd_konfigurasi'] ?>" data-id="<?= $g['kd_konfigurasi'] ?>" class="button-nav nav-link <?= $no == 1 ? "active" : "" ?>" data-toggle="tab"><?= $g['nama_toko'] ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content">
                            <?php
                            $no = 0;
                            foreach ($get as $g) {
                                $no++; ?>
                                <div class="tab-pane <?= $no == 1 ? "fade show active" : ""; ?> test<?= $g['kd_konfigurasi'] ?>" id="<?= $g['kd_konfigurasi'] ?>">
                                    <div class="row">
                                        <div class="col-md-6" style="margin-top: 15px;">
                                            <h6 class="text-dark"><i class="icofont-smart-phone pr-1"></i> Nomor Telepon :</h6>
                                            <p class="pl-4"><?= $g['no_hp'] ?></p>
                                            <h6 class="text-dark"><i class="icofont-email pr-1"></i> Email :</h6>
                                            <p class="pl-4"><?= $g['email'] != "" ? $g['email'] : "-" ?></p>
                                            <h6 class="text-dark"><i class="icofont-email pr-1"></i> Facebook :</h6>
                                            <a href="<?= $g['facebook'] ?>" class="pl-4"><?= $g['facebook'] != "" ? $g['facebook'] : "-" ?></a>
                                            <h6 class="text-dark"><i class="icofont-email pr-1"></i> Twitter :</h6>
                                            <a href="<?= $g['twitter'] ?>" class="pl-4"><?= $g['twitter'] != "" ? $g['twitter'] : "-" ?></a>
                                            <h6 class="text-dark"><i class="icofont-email pr-1"></i> Instagram :</h6>
                                            <a href="<?= $g['instagram'] ?>" class="pl-4"><?= $g['instagram'] != "" ? $g['instagram'] : "-" ?></a>
                                        </div>
                                        <!-- <div class="col-md-6">
                                            <iframe src="<?= $g['map'] ?>" width="100%" height="370" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                                        </div> -->
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- <div class="tab-pane" id="brp">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-dark"><i class="icofont-location-pin pr-1"></i> Address :</h6>
                                        <p class="pl-4">86 Petersham town, New South wales Waedll Steet, Australia PA 6550</p>
                                        <h6 class="text-dark"><i class="icofont-smart-phone pr-1"></i> Phone :</h6>
                                        <p class="pl-4">+91 12345-67890, (+91) 123 456 7890</p>
                                        <h6 class="text-dark"><i class="icofont-mobile-phone pr-1"></i> Mobile :</h6>
                                        <p class="pl-4">(+20) 220 145 6589, +91 12345-67890</p>
                                        <h6 class="text-dark"><i class="icofont-email pr-1"></i> Email :</h6>
                                        <p class="pl-4">Chpoee@gmail.com, info@Chpoee.com</p>
                                        <h6 class="text-dark"><i class="icofont-link pr-1"></i> Website :</h6>
                                        <p class="pl-4">www.askbootstrap.com</p>
                                    </div>
                                    <div class="col-md-6">
                                        <iframe src="" width="100%" height="370" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>

                </div>
            </div>
            <!-- <div class="col-lg-4 col-md-4">

                <div class="h-100 p-4 bg-white rounded overflow-hidden position-relative shadow-sm">
                    <div class="bs-example">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#tsp" class="nav-link active" data-toggle="tab">CateringKita TSP</a>
                            </li>
                            <li class="nav-item">
                                <a href="#brp" class="nav-link" data-toggle="tab">CateringKita BRP</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tsp">

                            </div>
                            <div class="tab-pane fade" id="brp">
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="col-lg-4 col-md-4">
                <div class="p-4 bg-white rounded overflow-hidden position-relative shadow-sm">
                    <h4 class="mt-0 mb-4 text-dark">Saran dan Masukkan</h4>
                    <form id="addMasukanSaran" autocomplete="off">
                        <div class="control-group form-group">
                            <div class="controls">
                                <label>Nama Lengkap<span class="text-danger">*</span></label>
                                <input type="text" placeholder="Nama Lengkap" class="form-control" name="name" required>
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="control-group form-group col-md-6">
                                <label>Nomer Telepon <span class="text-danger">*</span></label>
                                <div class="controls">
                                    <input type="text" placeholder="Nomor Telepon" class="form-control" name="phone" required onkeypress="return hanyaAngka(event)">
                                </div>
                            </div>
                            <div class="control-group form-group col-md-6">
                                <div class="controls">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" placeholder="Email" class="form-control" name="email">
                                </div>
                            </div>
                        </div>
                        <div class="control-group form-group">
                            <div class="controls">
                                <label>Pesan <span class="text-danger">*</span></label>
                                <textarea rows="4" cols="100" placeholder="Pesan" class="form-control" name="message" maxlength="999" style="resize:none" required></textarea>
                            </div>
                        </div>
                        <!-- For success/fail messages -->
                        <button type="submit" class="btn btn-primary btn-sm float-right">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Us -->