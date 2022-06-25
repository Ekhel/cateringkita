<div class="py-2 btn-primary">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <header>
                    <div id="owl-carousel-one" class="owl-carousel">
                        <?php if (!empty($slider)) { ?>
                            <?php foreach ($slider as $s) { ?>
                                <div class="item"><img class="img-fluid mx-auto rounded shadow-sm" src="<?= base_url('assets/images/slider/' . $s['nm_slider']) ?>"></div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="item"><img class="img-fluid mx-auto rounded shadow-sm" src="<?= base_url('assets/images/slider/default.png') ?>"></div>
                        <?php } ?>
                    </div>
                </header>
            </div>
        </div>
    </div>
</div>