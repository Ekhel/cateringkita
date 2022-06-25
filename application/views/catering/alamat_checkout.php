<?php if ($this->session->userdata('nama') && $this->session->userdata('telp')) { ?>
    <div class="col-md-4">
        <div class="bg-white card addresses-item mb-0  shadow-sm">
            <div class="gold-members p-3">
                <div class="media">
                    <div class="media-body">
                        <span class="badge badge-danger"><?= ucfirst($this->session->userdata('nama')) ?> - Home</span>
                        <h6 class="mb-3 mt-3 text-dark"><?= ucfirst($this->session->userdata('nama')) ?></h6>
                        <p><?= ucfirst($this->session->userdata('alamat')) ?>
                        </p>
                        <p class="text-secondary">Nomor Telepon: <span class="text-dark"><?= $this->session->userdata('telp') ?></span></p>
                        <!-- <button data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour" type="button" class="btn btn-primary btn-block">DELIVER HERE</button> -->
                        <hr>
                        <p class="mb-0 text-black">
                            <a class="text-success mr-3" data-toggle="modal" data-target="#edit-address-modal" href="#" id="edit_alamat_sess"><i class="icofont-ui-edit"></i> EDIT</a>
                            <a class="text-danger" data-toggle="modal" data-target="#delete-address-modal" href="#"><i class="icofont-ui-delete"></i> DELETE</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="col-md-4">
        <a data-toggle="modal" data-target="#add-address-modal" href="#" id="bagian_add_alamat_sess">
            <div class="bg-light p-4 border rounded  mb-0  shadow-sm text-center h-100 d-flex align-items-center">
                <h6 class="text-center m-0 w-100"><i class="icofont-plus-circle icofont-3x mb-5"></i><br><br>Add New Address</h6>
            </div>
        </a>
    </div>
<?php } ?>