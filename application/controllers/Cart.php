<?php

class Cart extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo count($this->cart->contents());
    }

    function add_to_cart()
    { //fungsi Add To Cart

        $kd_produk = $this->input->post('produk_kd');

        $dt = $this->db->get_where('produk', ['kd_produk' => $kd_produk])->row_array();

        $dataCart = [
            'id' => $kd_produk,
            'produk_kd' => $kd_produk,
            'name' => $this->input->post('produk_nm'),
            'price' => $this->input->post('produk_harga'),
            'deskripsi' => $this->input->post('produk_deskripsi'),
            'min_order' => $this->input->post('min_order'),
            'catatan' => "",
            'qty' => $this->input->post('quantity'),
            'produk_foto' => $this->input->post('produk_foto'),
        ];

        $this->cart->insert($dataCart);

        // pusher('cart');

        $count = count($this->cart->contents());
        if ($count <= 0) {
            $hasil = 0;
        } else {
            $hasil = $count;
        }

        $data = ['total_cart' => $hasil];

        echo json_encode(['data' => $data, 'dt' => $dt]);
    }

    function add_to_cart_items()
    { //fungsi Add To Cart
        if ($this->input->post('quantity') != 0) {
            $data = array(
                'id' => $this->input->post('produk_id'),
                'produk_kd' => $this->input->post('produk_kd'),
                'name' => $this->input->post('produk_nm'),
                'price' => $this->input->post('produk_harga'),
                'deskripsi' => $this->input->post('produk_deskripsi'),
                'catatan' => $this->input->post('produk_catatan'),
                'min_order' => $this->input->post('min_order'),
                'qty' => $this->input->post('quantity'),
                'produk_foto' => $this->input->post('produk_foto'),
            );

            $this->cart->insert($data);
        } else {
            $data = array(
                'id' => $this->input->post('produk_id'),
                'produk_kd' => $this->input->post('produk_kd'),
                'name' => $this->input->post('produk_nm'),
                'price' => $this->input->post('produk_harga'),
                'catatan' => $this->input->post('produk_catatan'),
                'deskripsi' => $this->input->post('produk_deskripsi'),
                'min_order' => $this->input->post('min_order'),
                'qty' => $this->input->post('quantity') + 1,
                'produk_foto' => $this->input->post('produk_foto'),
            );

            $this->cart->insert($data);

            $data = array(
                'id' => $this->input->post('produk_id'),
                'produk_kd' => $this->input->post('produk_kd'),
                'name' => $this->input->post('produk_nm'),
                'price' => $this->input->post('produk_harga'),
                'deskripsi' => $this->input->post('produk_deskripsi'),
                'catatan' => $this->input->post('produk_catatan'),
                'min_order' => $this->input->post('min_order'),
                'qty' => $this->input->post('quantity') - 1,
                'produk_foto' => $this->input->post('produk_foto'),
            );

            $this->cart->insert($data);
        }

        $count = count($this->cart->contents());
        if ($count <= 0) {
            $hasil = 0;
        } else {
            $hasil = $count;
        }

        $data = ['total_cart' => $hasil];
        echo json_encode($data);
    }

    public function keranjang()
    {
        $data['cart'] = $this->cart->contents();
        $data['angka'] = 1;
        $this->load->view('catering/keranjang', $data);
    }

    public function total_keranjang()
    {
        $data['cart'] = $this->cart->contents();
        $data['angka'] = 1;
        $this->load->view('catering/total_keranjang', $data);
    }

    public function keranjang_checkout()
    {
        $data['cart'] = $this->cart->contents();
        $data['angka'] = 1;
        $this->load->view('catering/keranjang_checkout', $data);
    }

    public function total_keranjang_checkout()
    {
        $data['cart'] = $this->cart->contents();
        $data['angka'] = 1;
        $this->load->view('catering/total_keranjang_checkout', $data);
    }

    public function tambah_qty()
    {
        $data = array(
            'rowid' => $this->input->post('produk_id'),
            'qty' => $this->input->post('quantity'),
        );
        $this->cart->update($data);

        pusher('cart');
        pusher('total_keranjang_checkout');

        $count = count($this->cart->contents());
        if ($count <= 0) {
            $hasil = 0;
        } else {
            $hasil = $count;
        }

        $data = ['total_cart' => $hasil];
        echo json_encode($data);
    }

    public function delete_cart()
    {
        $data = array(
            'rowid' => $this->input->post('row_id'),
            'qty' => 0,
        );
        $this->cart->update($data);

        // pusher('cart');
        // pusher('keranjang_checkout');

        $count = count($this->cart->contents());
        if ($count <= 0) {
            $hasil = 0;
        } else {
            $hasil = $count;
        }

        $data = ['total_cart' => $hasil];
        echo json_encode($data);
    }

    function add_to_checkout()
    { //fungsi Add To Cart
        $data = array(
            'id' => $this->input->post('produk_id'),
            'produk_kd' => $this->input->post('produk_kd'),
            'name' => $this->input->post('produk_nm'),
            'produk_stok' => $this->input->post('produk_stok'),
            'produk_berat' => $this->input->post('produk_berat'),
            'produk_satuan_berat' => $this->input->post('produk_satuan_berat'),
            'price' => $this->input->post('produk_harga'),
            'produk_harga_coret' => $this->input->post('produk_harga_coret'),
            'produk_diskon' => $this->input->post('produk_diskon'),
            'produk_jns_komisi' => $this->input->post('produk_jns_komisi'),
            'produk_nominal_komisi' => $this->input->post('produk_nominal_komisi'),
            'qty' => $this->input->post('quantity'),
            'produk_foto' => $this->input->post('produk_foto'),
        );
        $this->cart->insert($data);
        $no = "";
        echo $this->show_detail($no); //tampilkan cart setelah added
    }

    function show_cart()
    { //Fungsi untuk menampilkan Cart
        $count = count($this->cart->contents());
        if ($count <= 0) {
            $hasil = 0;
        } else {
            $hasil = $count;
        }
        $output = '';
        $no = 0;
        $output .= '
        <div class="cart-sidebar-header">
            <h5>
                My Cart <span class="text-info">(5 item)</span> <a data-toggle="offcanvas" class="float-right" href="#"><i class="icofont icofont-close-line"></i>
                </a>
            </h5>
        </div>
        ';


        foreach ($this->cart->contents() as $items) {
            $no++;
            $output .= '
                <div class="cart-sidebar-body">
                    <div class="cart-list-product">
                        <a class="float-right remove-cart" id="' . $items['rowid'] . '" href="#"><i class="icofont icofont-close-circled"></i></a>
                        <img class="img-fluid" src="' . base_url('assets/images/gallery_produk/' . $items['produk_foto']) . '" alt="">
                        <span class="badge badge-danger">55% OFF</span>
                        <h5><a href="#">' . $items['name'] . '</a></h5>
                        <p class="f-14 mb-0 text-dark float-right">' . format_rupiah($items['price']) . '<span class="bg-info rounded-sm pl-1 ml-1 pr-1 text-white small">NEW</span> </p>
                        <span class="count-number float-left">
                            <button class="btn btn-outline-secondary  btn-sm left dec"> <i class="icofont-minus"></i> </button>
                            <input class="count-number-input" type="text" value="' . $items['qty'] . '" readonly="">
                            <button class="btn btn-outline-secondary btn-sm <span class="badge badge-danger">55% OFF</span>right inc"> <i class="icofont-plus"></i> </button>
                        </span>
                    </div>
                </div>';
        }

        $output .= '
            <div class="cart-sidebar-footer">
                <div class="cart-store-details">
                    <p>Sub Total <strong class="float-right">' . format_rupiah($this->cart->total()) . '</strong></p>
                    <p>Delivery Charges <strong class="float-right text-danger">' . format_rupiah(5000) . '</strong></p>
                    </div>
                <a href="#"><button class="btn btn-primary btn-lg btn-block text-left" type="button"><span class="float-left"><i class="icofont icofont-cart"></i> Proceed to Checkout </span><span class="float-right"><strong>$1200.69</strong> <span class="icofont icofont-bubble-right"></span></span></button></a>
            </div>
            ';

        echo $output;
    }

    function load_cart()
    { //load data cart
        echo $this->show_cart();
    }

    function hapus_cart()
    { //fungsi untuk menghapus item cart
        $data = array(
            'rowid' => $this->input->post('row_id'),
            'qty' => 0,
        );
        $this->cart->update($data);
        echo $this->show_cart();
    }

    function hapus_checkout()
    { //fungsi untuk menghapus item cart
        $data = array(
            'rowid' => $this->input->post('row_id'),
            'qty' => 0,
        );
        $this->cart->update($data);
        $no = "";
        echo $this->show_detail($no);
    }

    function get_items()
    {
        $count = count($this->cart->contents());
        if ($count <= 0) {
            $hasil = 0;
        } else {
            $hasil = $count;
        }
        echo $count;
    }

    public function checkout()
    {
        $data['judul'] = 'Checkout';

        $this->load->view('base-toko/header');
        $this->load->view('base-toko/navbar');
        $this->load->view('catering/checkout', $data);
        $this->load->view('base-toko/footer');
    }

    function load_keranjang()
    {
        echo $this->show_keranjang();
    }

    function show_keranjang()
    {
        $output = "";
        $output .= '
        <div class="textancartaits textancartaits2 cart cart box_1">
            <button class="btn btn-sm btn-primary cart-tambah">
                <i class="fa" style="font-size:24px">&#xf07a;</i>
                <span class="badge badge-warning jumlah-cart lblCartCount">' . count($this->cart->contents()) . '</span>
            </button>
        </div>
        ';
        return $output;
    }

    function load_detail($uri)
    {
        echo $this->show_detail($uri);
    }

    function show_detail($data)
    {
        $output = "";
        $total = $this->cart->total() + 10000;
        $output .= '
        <div class="card" style="padding-bottom: 15px">
            <div class="ringkasan-belanja">
                Ringkasan Belanja
            </div>
            <div class="form-group row" style="margin-bottom: 0px;">
                <label for="staticEmail" class="col-sm-5 col-xs-6 col-form-label">Sub Total</label>
                <div class="col-sm-7 col-xs-6">
                    <input type="text" readonly class="form-control-plaintext input-harga rupiah-mask" value="' . 'Rp ' . number_format($this->cart->total()) . '">
                </div>
            </div>
            <div class="form-group row" style="margin-bottom: 0px;">
                <label for="staticEmail" class="col-sm-5 col-xs-6 col-form-label">Diskon</label>
                <div class="col-sm-7 col-xs-6">
                    <input type="text" readonly class="form-control-plaintext input-harga" value="Rp 0">
                </div>
            </div>
            <div class="form-group row" style="margin-bottom: 0px;">
                <label for="staticEmail" class="col-sm-5 col-xs-6 col-form-label">Biaya Kirim</label>
                <div class="col-sm-7 col-xs-6">
                    <input type="text" readonly class="form-control-plaintext input-harga" value="Rp 10,000">
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-5 col-xs-6 col-form-label">Total Bayar</label>
                <div class="col-sm-7 col-xs-6">
                    <input type="text" readonly class="form-control-plaintext input-harga rupiah-mask" value="' . 'Rp ' . number_format($total) . '">
                </div>
            </div>
        ';

        if ($data == "detail_checkout") {
            $output .= '
                    <a href="' . base_url('cart/checkout') . '"><button class="btn btn-primary" style="font-weight: bold;padding: 10px;border: 0;width: 49%;"><i class="fa fa-arrow-circle-left"></i> Kembali</button></a>
                    <a href="' . base_url('cart/detail_checkout') . '"><button class="btn btn-success button-checkout" style="font-weight: bold;padding: 10px;border: 0;width: 49%;">Lanjut Transaksi <i class="fa fa-arrow-circle-right"></i></button></a>
            </div>
            ';
        } else {

            $output .= '
                    <a href="' . base_url('main') . '"><button class="btn btn-primary" style="font-weight: bold;padding: 10px;border: 0;width: 49%;"><i class="fa fa-arrow-circle-left"></i> Lanjut Belanja</button></a>
                    <a href="' . base_url('cart/detail_checkout') . '"><button class="btn btn-success button-checkout" style="font-weight: bold;padding: 10px;border: 0;width: 49%;">Lanjut Transaksi <i class="fa fa-arrow-circle-right"></i></button></a>
            </div>
            ';
        }


        return $output;
    }

    function show_checkout()
    {
        $no = 0;
        $output = "";
        $output .= '
        <h4>Your shopping cart contains:
            <span>' . count($this->cart->contents()) . ' Products</span>
        </h4>
        <div class="table-responsive">
            <table class="timetable_sub bordered">
                <thead>
                    <tr>
                        <th style="width: 5%;">No.</th>
                        <th style="width: 20%;">Product</th>
                        <th style="width: 20%;">Product Name</th>
                        <th style="width: 25%;">Quantity</th>

                        <th style="width: 20%;">Price</th>
                        <th style="width: 10%;">Remove</th>
                    </tr>
                </thead>
                <tbody>
        ';
        if (count($this->cart->contents()) == 0) {
            $output .= '
                    <tr>
                        <td colspan="6" align="center"> <h5 style="font-weight: bold; font-size: 20px;">Your shopping cart is empty</h5><a href="' . base_url('main') . '" class="btn btn-sm btn-success" style="margin-top: 10px;">Buy Something ?</a></td>
                    </tr>';
        } else {
            foreach ($this->cart->contents() as $items) {
                $no++;
                $output .= '
                <tr class="rem1">
                    <td class="invert">' . $no . '</td>
                    <td class="invert-image">
                        <a href="single2.html">
                            <img src="' . base_url('assets/images/gallery_produk/' . $items['produk_foto']) . '" alt=" " width="100px" class="img-responsive">
                        </a>
                    </td>
                    <td class="invert">' . $items['name'] . '</td>
                    <td class="invert">
                        <div class="input-group lebar-input" width: 125px;>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-number' . $no . '" data-type="minus" data-field="quant[' . $no . ']">
                                    <span class="glyphicon glyphicon-minus"></span>
                                </button>
                            </span>
                            <input type="hidden" id="qtylama' . $no . '" value="' . $items['qty'] . '"></input>
                            <input type="text" name="quant[' . $no . ']" class="form-control input-number input-qty' . $no . ' text-center" id="' . $items['id'] . $no . '" value="' . $items['qty'] . '" min="1" max="1000" >
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-number' . $no . '" data-type="plus" data-field="quant[' . $no . ']">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </span>
                        </div>
                    </td>
                    <input type="hidden" value="' . $items['price'] . '" id="harga' . $no . '">
                    <td class="invert">' . 'Rp ' . number_format($items['price']) . '</td>
                    <td class="invert">
                        <div class="rem">
                            <button type="button" id="' . $items['rowid'] . '" class="hapus_checkout' . $no . ' btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                </tr>';
            }
        }

        $output .= '
                </tbody>
            </table>
        </div>
        <div class="row mt-5">
            <div class="col-md-8 col-xs-12"></div>
            <div class="col-md-4 col-xs-12">
                <div class="table-responsive-checkout">
                    <h5 style="font-weight: bold; font-size: 20px;">Total Harga : ' . 'Rp ' . number_format($this->cart->total()) . '</h5>
                </div>
            </div>
        </div>
        ';
        return $output;
    }

    public function detail_checkout()
    {
        $data['judul'] = 'Detail Checkout';

        $this->load->view('base-toko/header');
        $this->load->view('base-toko/navbar');
        $this->load->view('catering/detail_checkout', $data);
        $this->load->view('base-toko/footer');
    }
}
