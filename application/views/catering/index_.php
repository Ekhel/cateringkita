<?php $this->load->view('catering/slider'); ?>
<?php
$this->db->select('*');
$this->db->from('produk');
$this->db->join('kategori', 'kategori.kd_kategori=produk.kd_kategori');
$this->db->order_by('produk.harga', 'asc');
$product_kategori = $this->db->get()->result_array();
?>


<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mx-auto text-center">
                <h2 class="mt-4 mb-1">Tersedia Paket</h2>
                <div class="row mt-5">
                    <div class="col-lg-6 col-md-6 mb-2">
                        <div class="text-left bg-white p-4 shadow-lg rounded">
                            <h5 class="text-dark mt-0">Mingguan</h5>
                            <p class="text-dark mb-0">Memilih paket catering mingguan ini Anda bisa memperoleh pelayanan 7 hari. Bila Anda tertarik dengan layanan paket catering bulanan yang sehat dan murah, Yuk langsung saja pesan !</p>
                            <a href="<?= base_url('catering/mingguan') ?>" class="btn btn-primary mt-2 btn-block">Lihat Selengkapnya</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-2">
                        <div class="text-left bg-white p-4 shadow-lg rounded">
                            <h5 class="text-dark mt-0">Bulanan</h5>
                            <p class="text-dark mb-0">Memilih paket catering bulanan ini Anda bisa memperoleh pelayanan 30 hari. Bila Anda tertarik dengan layanan paket catering bulanan yang sehat dan murah, Yuk langsung saja pesan !</p>
                            <a href="<?= base_url('catering/bulanan') ?>" class="btn btn-primary mt-2 btn-block">Lihat Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="section-title text-center mb-5">
        <h2 class="text-dark">Mau Custom Menu Catering kamu sendiri ?</h2>
        <h4>Pasti Bisa Dong</h4>
    </div>
    <div class="row">
        <div class="col-lg-12 mx-auto text-center">
            <a href="<?= base_url('catering/custom_menu') ?>" class="btn btn-primary">Lihat Selengkapnya</a>
        </div>
    </div>
</section>

<section class="py-5" style="display: none;">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="offers-block"><a href="#">
                        <img class="img-fluid" src="<?= base_url() ?>assets/toko_/img/offer-1.png" alt=""></a>
                </div>
            </div>
            <div class="col-4">
                <div class="offers-block"> <a href="#"><img class="img-fluid mb-3" src="<?= base_url() ?>assets/toko_/img/offer-3.png" alt=""></a>
                </div>
                <div class="offers-block"><a href="#"><img class="img-fluid" src="<?= base_url() ?>assets/toko_/img/offer-4.png" alt=""></a></div>
            </div>
            <div class="col-4">
                <div class="offers-block"><a href="#"><img class="img-fluid" src="<?= base_url() ?>assets/toko_/img/offer-2.png" alt=""></a></div>
            </div>
        </div>
    </div>
</section>