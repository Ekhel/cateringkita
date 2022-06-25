<section class="section pt-5 pb-5 osahan-not-found-page">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center pt-5 pb-5">
                <img class="img-fluid mb-5" src="<?= base_url() ?>assets/toko_/img/thanks.png" alt="404">
                <h1 class="mt-2 mb-2 text-success">Selamat!</h1>
                <p class="<?= !$this->session->userdata('kd_member') ? "mb-2" : "mb-5" ?>">Kamu telah sukses melakukan pemesanan.</p>

                <?php if (!$this->session->userdata('kd_member')) { ?>
                    <?php $config = $this->db->get('konfigurasi')->row_array() ?>
                    <p class="mb-5">Segera Konfirmasi pesanan kepada admin. Jika melebihi <?= $config['batas_delete_temporary'] ?> Hari, Maka Transaksi Otomatis Terhapus.</p>
                    <a class="btn btn-primary btn-lg mb-2 mt-2" href="<?= base_url('catering/add_member') ?>"><i class="icofont-edit"></i> Daftar Member</a>
                <?php } ?>

                <?php $konfigurasi = $this->db->get('konfigurasi')->row_array(); ?>

                <a class="btn btn-success btn-lg mb-2 mt-2" target="_blank" href="https://api.whatsapp.com/send?phone=<?= $konfigurasi['no_hp'] ?>&text=<?= $isi ?>"><i class="icofont-whatsapp"></i> Konfirmasi Pemesanan</a>
            </div>
        </div>
    </div>
</section>