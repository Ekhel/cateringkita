<?php
class Catering extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
    }

    public function deletecache($path, $arg = '')
    {
        foreach ($path as $p) {
            $arg != '' ? $this->cache->delete($p . $arg) : $this->cache->delete($p);
        }
    }

    public function about()
    {
        $data['judul'] = 'About Us';
        $data['logo'] = $this->db->get('logo')->row_array();

        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/about', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    public function FAQ()
    {
        $data['judul'] = 'FAQ';
        $data['logo'] = $this->db->get('logo')->row_array();

        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/faq', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    public function contact()
    {
        $data['judul'] = 'Contact Us';
        $data['logo'] = $this->db->get('logo')->row_array();

        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/contact', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    public function product()
    {

        $data['judul'] = 'Data Produk';
        $data['logo'] = $this->db->get('logo')->row_array();

        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/product', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    function fetch()
    {
        $output = '';
        $limit = $this->input->post('limit');
        $start = $this->input->post('start');
        $where = $this->input->post('where');
        $filter = $this->input->post('filter');
        $harga_min = $this->input->post('harga_min');
        $harga_max = $this->input->post('harga_max');
        $tampungan = [];

        $text = substr(decrypt(base64_decode($where)), 0, 3);
        $kategori = $this->db->get_where('kategori', ['nm_kategori' => "Custom"])->row_array();
        $kat = $this->db->get_where('kategori', ['nm_kategori' => "Paket Khusus"])->row_array();

        $this->db->select("*");
        $this->db->from("produk");
        if ($where != "") {
            if (in_array($where, $tampungan)) {
                $this->db->where(['is_' . strtolower($where) => 1]);
            } else if ($text == "KAT") {
                $this->db->where(['kd_kategori' => decrypt(base64_decode($where))]);
            } else if ($text == "KSB") {
                $this->db->where(['kd_sub_kategori' => decrypt(base64_decode($where))]);
            }
        }
        $this->db->where(['kd_kategori!=' => $kategori['kd_kategori']]);
        $this->db->where(['kd_kategori!=' => $kat['kd_kategori']]);

        if ($filter != "") {
            if ($filter == "abjadA-Z") {
                $this->db->order_by("nm_produk", "ASC");
            } else if ($filter == "abjadZ-A") {
                $this->db->order_by("nm_produk", "DESC");
            } else if ($filter == "pricelow") {
                $this->db->order_by('harga', "ASC");
            } else if ($filter == "pricehigh") {
                $this->db->order_by('harga', "DESC");
            }
        }

        if ($harga_min != "" && $harga_max != "") {
            $this->db->where('harga >=', $harga_min);
            $this->db->where('harga <=', $harga_max);
        }
        $this->db->where(['is_produk_hapus' => 1]);
        // $this->db->order_by("created_at", "DESC");
        $this->db->limit($limit, $start);
        $data = $this->db->get();

        if ($data->num_rows() > 0) {
            foreach ($data->result() as $row) {
                $output .= '
				<div class="col-6 col-md-3">
                    <div class="card list-item bg-white rounded overflow-hidden position-relative shadow-sm">
                        <a href="' . base_url('catering/productDetail/' . base64_encode(encrypt($row->kd_produk))) . '">';

                $output .= '<img src="' . base_url('assets/images/gallery_produk/' . $row->foto_produk) . '" class="card-img-top" alt="..."></a>
                        <div class="card-body">
                            <h6 class="card-title mb-1">' . ucfirst($row->nm_produk) . '</h6>';
                $output .= '<p class="mb-0 text-dark">' . format_rupiah($row->harga) . '/pax <span class="text-black-50"> </span></p>';
                if ($row->deskripsi != "") {
                    $output .= '<hr>';
                    $output .= '<p class="mb-0 text-dark"><b>Deskripsi</b> : <span class="text-black-50"> </span></p>';
                    $output .= '<p class="mb-0 text-dark">' . $row->deskripsi . ' <span class="text-black-50"> </span></p>';
                }
                $output .= '
                        </div>
                    </div>
                </div>
				';
            }
        }
        echo $output;
    }

    public function add_pemesanan_mingguan()
    {
        if (!$this->session->userdata('kd_member')) {
            $this->session->set_flashdata('error_page', 'Anda Harus Login terlebih dahulu.');
            redirect(base_url('main'));
        }

        $kd_produk = $this->input->post('kd_produk');
        $harga_produk = $this->input->post('harga_produk');
        $nm_produk = $this->input->post('nm_produk');
        $total_hari = $this->input->post('total_hari');
        $qty = $this->input->post('qty');
        $tgl_kirim = $this->input->post('tgl_kirim');
        $order_type = $this->input->post('order_type');

        $this->db->select("*");
        $this->db->from("produk");
        $this->db->where("kd_produk", $kd_produk);
        $dt = $this->db->get()->row_array();

        $tgl_order = Date('Y-m-d', time());
        $payment_type = $this->input->post('payment_type');
        $kd_order = $this->getKodeOtomatis("FS", "order");
        $key = kunci();

        $kd_member = $this->session->userdata('kd_member');
        $id = $this->session->userdata('kd_member');
        $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
        $this->db->from('member');
        $this->db->join("detail_sosmed", "member.kd_member=detail_sosmed.kd_member");
        $this->db->where(['member.kd_member' => $id]);
        $member = $this->db->get()->row_array();

        if ($member == null) {
            $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
            $this->db->from('member');
            $this->db->where(['member.kd_member' => $id]);
            $member = $this->db->get()->row_array();
        }

        $konfigurasi = $this->db->get('konfigurasi')->row_array();

        if ($payment_type == "ambil_langsung") {
            $order_status = "pending";
            $total_harga = $qty * $harga_produk * $total_hari;
            $total_transfer = $total_harga;
        } else if ($payment_type == "cod") {
            $order_status = "pending";
            $total_harga = $qty * $harga_produk * $total_hari;
            $total_transfer = $total_harga;
        } else if ($payment_type == "transfer") {
            $order_status = "pending";
            $total_harga = $qty * $harga_produk * $total_hari;
            $total_transfer = $total_harga - rand(0, 999);
        }

        $alamat_pengiriman = $this->session->userdata('alamat_pengiriman');
        if ($alamat_pengiriman == "alamat_utama") {
            $cust_name = $member['nm_member'];
            $cust_email = $member['email'];
            $cust_phone = $member['no_telp'];
            $cust_address = strip_tags(decrypt($member['alamat']));
            $cust_subdistrict = $member['kd_subdistricts'];
            $get_subdis = $this->db->get_where('kecamatan', ['id' => $cust_subdistrict])->row_array();

            $subdis = $get_subdis['provinsi'] . ', ' . $get_subdis['kabupaten'] . ', ' . $get_subdis['kecamatan'] . ', ' . $get_subdis['kelurahan'] . ', ' . $get_subdis['kodepos'];
            $cust_office = $member['kodepos'];
        } else {
            $member_alamat = $this->db->get_where('detail_alamat', ['kd_detail_alamat' => $alamat_pengiriman])->row_array();
            $cust_name = $member_alamat['nm_member_'];
            $cust_email = "";
            $cust_phone = $member_alamat['no_telp_'];
            $cust_address = strip_tags($member_alamat['alamat']);
            $cust_subdistrict = $member_alamat['subdistricts_'];
            $get_subdis = $this->db->get_where('kecamatan', ['id' => $cust_subdistrict])->row_array();

            $subdis = $get_subdis['provinsi'] . ', ' . $get_subdis['kabupaten'] . ', ' . $get_subdis['kecamatan'] . ', ' . $get_subdis['kelurahan'] . ', ' . $get_subdis['kodepos'];
            $cust_office = $member_alamat['kodepos_'];
        }

        $dataOrder = [
            'kd_order' => $kd_order,
            'kd_member' => $kd_member,
            'tgl_order' => $tgl_order,
            'tgl_kirim' => $tgl_kirim,
            'cust_name' => $cust_name,
            'cust_email' => $cust_email,
            'cust_phone' => $cust_phone,
            'cust_address' => $cust_address,
            'cust_subdistrict' => $subdis,
            'cust_office' => $cust_office,
            'payment_type' => $payment_type,
            'payment_status' => '0',
            'order_status' => $order_status,
            'order_type' => $order_type,
            'total_harga' => $total_harga,
            'total_transfer' => $total_harga,
            'catatan_order' => $this->input->post('catatan'),
            'created_at_admin' => $this->session->userdata('kd_member'),
            'updated_at_admin' => $this->session->userdata('kd_member'),
        ];

        $this->db->insert('order', $dataOrder);


        $kd_detail_order = $this->getKodeOtomatis("DFS", "detail_order");
        $dataDetailOrder = [
            'kd_detail_order' => $kd_detail_order,
            'kd_order' => $kd_order,
            'kd_produk' => $kd_produk,
            'nm_produk' => $nm_produk,
            'harga_produk' => $harga_produk,
            'qty' => $qty * $total_hari,
            'sub_total' => $harga_produk * $qty *  $total_hari,
        ];

        $this->db->insert('detail_order', $dataDetailOrder);

        $datacatatan = [
            'kd_detail_order' => $kd_detail_order,
            'catatan' => ""
        ];

        $this->db->insert('catatan_detail_order', $datacatatan);

        for ($i = 0; $i <= $total_hari - 1; $i++) {
            $date1 = str_replace('-', '/', $tgl_kirim);
            $tanggal = date('Y-m-d', strtotime($date1 . "+" . $i . " days"));
            $data_order_perhari = [
                'kd_order' => $kd_order,
                'status' => 0,
                'tanggal' => $tanggal,
                'hari' => format_hari_tanggal($tanggal, "hari"),
                'kd_produk' => $kd_produk,
            ];
            $this->db->insert('detail_order_perhari', $data_order_perhari);
        }


        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('flash_page', 'Terimakasih sudah melakukan pemesanan. Silahkan hubungi admin untuk mengkonfirmasi pesanan.');
        } else {
            $this->session->set_flashdata('error_page', 'Maaf, Gagal melakukan pemesanan.');
        }

        // $this->delete_session_alamat();
        $this->cart->destroy();

        $sess = [
            'kd_order' => $kd_order,
        ];

        $this->session->set_userdata($sess);

        redirect(base_url('catering/order_selesai'));
    }

    public function add_pemesanan_bulanan()
    {
        if (!$this->session->userdata('kd_member')) {
            $this->session->set_flashdata('error_page', 'Anda Harus Login terlebih dahulu.');
            redirect(base_url('main'));
        }

        $kd_produk = $this->input->post('kd_produk');
        $harga_produk = $this->input->post('harga_produk');
        $nm_produk = $this->input->post('nm_produk');
        $total_hari = $this->input->post('total_hari');
        $qty = $this->input->post('qty');
        $tgl_kirim = $this->input->post('tgl_kirim');
        $order_type = $this->input->post('order_type');

        $this->db->select("*");
        $this->db->from("produk");
        $this->db->where("kd_produk", $kd_produk);
        $dt = $this->db->get()->row_array();

        $tgl_order = Date('Y-m-d', time());
        $payment_type = $this->input->post('payment_type');
        $kd_order = $this->getKodeOtomatis("FS", "order");
        $key = kunci();

        $kd_member = $this->session->userdata('kd_member');
        $id = $this->session->userdata('kd_member');
        $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
        $this->db->from('member');
        $this->db->join("detail_sosmed", "member.kd_member=detail_sosmed.kd_member");
        $this->db->where(['member.kd_member' => $id]);
        $member = $this->db->get()->row_array();

        if ($member == null) {
            $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
            $this->db->from('member');
            $this->db->where(['member.kd_member' => $id]);
            $member = $this->db->get()->row_array();
        }

        $konfigurasi = $this->db->get('konfigurasi')->row_array();

        if ($payment_type == "ambil_langsung") {
            $order_status = "pending";
            $total_harga = $qty * $harga_produk * $total_hari;
            $total_transfer = $total_harga;
        } else if ($payment_type == "cod") {
            $order_status = "pending";
            $total_harga = $qty * $harga_produk * $total_hari;
            $total_transfer = $total_harga;
        } else if ($payment_type == "transfer") {
            $order_status = "pending";
            $total_harga = $qty * $harga_produk * $total_hari;
            $total_transfer = $total_harga - rand(0, 999);
        }

        $alamat_pengiriman = $this->session->userdata('alamat_pengiriman');
        if ($alamat_pengiriman == "alamat_utama") {
            $cust_name = $member['nm_member'];
            $cust_email = $member['email'];
            $cust_phone = $member['no_telp'];
            $cust_address = strip_tags(decrypt($member['alamat']));
            $cust_subdistrict = $member['kd_subdistricts'];
            $get_subdis = $this->db->get_where('kecamatan', ['id' => $cust_subdistrict])->row_array();

            $subdis = $get_subdis['provinsi'] . ', ' . $get_subdis['kabupaten'] . ', ' . $get_subdis['kecamatan'] . ', ' . $get_subdis['kelurahan'] . ', ' . $get_subdis['kodepos'];
            $cust_office = $member['kodepos'];
        } else {
            $member_alamat = $this->db->get_where('detail_alamat', ['kd_detail_alamat' => $alamat_pengiriman])->row_array();
            $cust_name = $member_alamat['nm_member_'];
            $cust_email = "";
            $cust_phone = $member_alamat['no_telp_'];
            $cust_address = strip_tags($member_alamat['alamat']);
            $cust_subdistrict = $member_alamat['subdistricts_'];
            $get_subdis = $this->db->get_where('kecamatan', ['id' => $cust_subdistrict])->row_array();

            $subdis = $get_subdis['provinsi'] . ', ' . $get_subdis['kabupaten'] . ', ' . $get_subdis['kecamatan'] . ', ' . $get_subdis['kelurahan'] . ', ' . $get_subdis['kodepos'];
            $cust_office = $member_alamat['kodepos_'];
        }

        $dataOrder = [
            'kd_order' => $kd_order,
            'kd_member' => $kd_member,
            'tgl_order' => $tgl_order,
            'tgl_kirim' => $tgl_kirim,
            'cust_name' => $cust_name,
            'cust_email' => $cust_email,
            'cust_phone' => $cust_phone,
            'cust_address' => $cust_address,
            'cust_subdistrict' => $subdis,
            'cust_office' => $cust_office,
            'payment_type' => $payment_type,
            'payment_status' => '0',
            'order_status' => $order_status,
            'order_type' => $order_type,
            'total_harga' => $total_harga,
            'total_transfer' => $total_harga,
            'catatan_order' => $this->input->post('catatan'),
            'created_at_admin' => $this->session->userdata('kd_member'),
            'updated_at_admin' => $this->session->userdata('kd_member'),
        ];

        $this->db->insert('order', $dataOrder);


        $kd_detail_order = $this->getKodeOtomatis("DFS", "detail_order");
        $dataDetailOrder = [
            'kd_detail_order' => $kd_detail_order,
            'kd_order' => $kd_order,
            'kd_produk' => $kd_produk,
            'nm_produk' => $nm_produk,
            'harga_produk' => $harga_produk,
            'qty' => $qty * $total_hari,
            'sub_total' => $harga_produk * $qty *  $total_hari,
        ];

        $this->db->insert('detail_order', $dataDetailOrder);

        $datacatatan = [
            'kd_detail_order' => $kd_detail_order,
            'catatan' => ""
        ];

        $this->db->insert('catatan_detail_order', $datacatatan);

        for ($i = 0; $i <= $total_hari - 1; $i++) {
            $date1 = str_replace('-', '/', $tgl_kirim);
            $tanggal = date('Y-m-d', strtotime($date1 . "+" . $i . " days"));
            $data_order_perhari = [
                'kd_order' => $kd_order,
                'status' => 0,
                'tanggal' => $tanggal,
                'hari' => format_hari_tanggal($tanggal, "hari"),
                'kd_produk' => $kd_produk,
            ];
            $this->db->insert('detail_order_perhari', $data_order_perhari);
        }


        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('flash_page', 'Terimakasih sudah melakukan pemesanan. Silahkan hubungi admin untuk mengkonfirmasi pesanan.');
        } else {
            $this->session->set_flashdata('error_page', 'Maaf, Gagal melakukan pemesanan.');
        }

        // $this->delete_session_alamat();
        $this->cart->destroy();

        $sess = [
            'kd_order' => $kd_order,
        ];

        $this->session->set_userdata($sess);

        redirect(base_url('catering/order_selesai'));
    }

    public function getSearchProduct()
    {
        $search = $this->input->post("data");
        $kategori = $this->db->get_where('kategori', ['nm_kategori' => "Custom"])->row_array();
        $kat = $this->db->get_where('kategori', ['nm_kategori' => "Paket Khusus"])->row_array();

        $this->db->select("*");
        $this->db->from("produk");
        $this->db->where(['is_produk_aktif' => '1', 'is_produk_hapus' => '1']);
        $this->db->where(['kd_kategori!=' => $kategori['kd_kategori']]);
        $this->db->where(['kd_kategori!=' => $kat['kd_kategori']]);
        $this->db->like("nm_produk", $search);
        $data = $this->db->get()->result_array();

        echo json_encode($data);
    }

    public function productDetail($kd = null)
    {
        if ($kd == null) {
            $this->session->set_flashdata('error_page', 'Tidak Bisa Akses Menu Tersebut.');
            redirect(base_url('main'));
        }
        $kd = decrypt(base64_decode($kd));
        $data['judul'] = 'Detail Produk';
        $data['logo'] = $this->db->get('logo')->row_array();

        $this->db->select('*');
        $this->db->from('produk');
        $this->db->where('produk.kd_produk', $kd);
        $this->db->order_by('produk.harga', 'asc');
        $data['product'] = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('produk');
        $this->db->join('kategori', 'kategori.kd_kategori=produk.kd_kategori');
        $this->db->where('produk.kd_kategori', $data['product'][0]['kd_kategori']);
        $this->db->order_by('produk.harga', 'asc');
        $data['product_kategori'] = $this->db->get()->result_array();

        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/detail_product', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    public function checkout()
    {
        if (!$this->session->userdata('kd_member')) {
            $this->session->set_flashdata('error_page', 'Anda Harus Login terlebih dahulu.');
            redirect(base_url('main'));
        }
        // $this->delete_session_alamat();
        $this->session->unset_userdata('alamat_pengiriman');
        $data['judul'] = 'Checkout';
        $data['logo'] = $this->db->get('logo')->row_array();

        if (!empty($this->session->userdata('kd_member'))) {
            $key = kunci();
            $id = $this->session->userdata('kd_member');
            $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
            $this->db->from('member');
            $this->db->join("detail_sosmed", "member.kd_member=detail_sosmed.kd_member");
            $this->db->where(['member.kd_member' => $id]);
            $data['user'] = $this->db->get()->row_array();

            if ($data['user'] == null) {
                $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
                $this->db->from('member');
                $this->db->where(['member.kd_member' => $id]);
                $data['user'] = $this->db->get()->row_array();
            }

            $data1 = [
                'alamat_pengiriman' => "alamat_utama"
            ];
            $this->session->set_userdata($data1);
        }

        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/checkout_', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    public function product_kategori()
    {
        $data['judul'] = 'Detail Produk';
        $data['logo'] = $this->db->get('logo')->row_array();

        $this->db->select('*');
        $this->db->from('produk');
        $this->db->join('detail_produk', 'detail_produk.kd_produk=produk.kd_produk');
        $this->db->where('produk.kd_produk');
        $this->db->order_by('detail_produk.harga_produk', 'asc');
        $data['product'] = $this->db->get()->result_array();

        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/detail_product', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    public function add_session_ongkir()
    {
        $data = [
            'ongkir' => $this->input->post('ongkir'),
        ];

        // pusher('total_keranjang_checkout');

        $this->session->set_userdata($data);
        $data = toast('success', 'Ongkir Berhasil Disimpan');

        echo json_encode($data);
    }

    public function add_session_ongkir_new()
    {
        $searchmap = $this->input->post('searchmap');
        $jarak = $this->input->post('jarak');
        if (empty($searchmap)) {
            $searchmap = "";
        }
        if (empty($jarak)) {
            $jarak = "";
        }
        $data = [
            'ongkir' => $this->input->post('ongkir'),
            'searchmap' => $searchmap,
            'jarak' => $jarak,
        ];

        // pusher('total_keranjang_checkout');

        $this->session->set_userdata($data);
        $data = toast('success', 'Ongkir Berhasil Disimpan');

        echo json_encode($data);
    }

    public function add_alamat_pelanggan()
    {
        $data = [
            'nama' => $this->input->post('nama_cust_temp'),
            'telp' => $this->input->post('telp_cust_temp'),
            'email' => $this->input->post('email_cust_temp'),
            'subdis' => $this->input->post('subdistrict_cust_temp'),
            'kd_pos' => $this->input->post('kdpos_cust_temp'),
            'searchmap' => $this->input->post('searchmap_cust_temp'),
            'jarak' => $this->input->post('jarak_cust_temp'),
            'latitude' => $this->input->post('latitude_cust_temp'),
            'longitude' => $this->input->post('longitude_cust_temp'),
            'alamat' => $this->input->post('alamat_cust_temp'),
            'patokan_alamat' => $this->input->post('patokan_cust_temp'),
        ];
        $this->session->set_userdata($data);

        // pusher('alamat_checkout');
        // pusher('total_keranjang_checkout');

        $data = toast('success', 'Alamat Berhasil Disimpan');

        echo json_encode($data);
    }

    public function edit_alamat_pelanggan()
    {
        $data = [
            'nama' => $this->input->post('nama_cust_temp'),
            'telp' => $this->input->post('telp_cust_temp'),
            'email' => $this->input->post('email_cust_temp'),
            'subdis' => $this->input->post('subdistrict_cust_temp'),
            'kd_pos' => $this->input->post('kdpos_cust_temp'),
            'searchmap' => $this->input->post('searchmap_cust_temp'),
            'jarak' => $this->input->post('jarak_cust_temp'),
            'latitude' => $this->input->post('latitude_cust_temp'),
            'longitude' => $this->input->post('longitude_cust_temp'),
            'alamat' => $this->input->post('alamat_cust_temp'),
            'patokan_alamat' => $this->input->post('patokan_cust_temp'),
        ];
        $this->session->set_userdata($data);

        // pusher('alamat_checkout');
        // pusher('total_keranjang_checkout');

        $data = toast('success', 'Alamat Berhasil Diubah');

        echo json_encode($data);
    }

    public function alamat_checkout()
    {
        $this->load->view('catering/alamat_checkout');
    }

    public function get_session_alamat()
    {
        $data = [
            'nama' => $this->session->userdata('nama'),
            'telp' => $this->session->userdata('telp'),
            'email' => $this->session->userdata('email'),
            'subdis' => $this->session->userdata('subdis'),
            'kd_pos' => $this->session->userdata('kd_pos'),
            'searchmap' => $this->session->userdata('searchmap'),
            'jarak' => $this->session->userdata('jarak'),
            'latitude' => $this->session->userdata('latitude'),
            'longitude' => $this->session->userdata('longitude'),
            'alamat' => $this->session->userdata('alamat'),
            'patokan_alamat' => $this->session->userdata('patokan_alamat')
        ];

        echo json_encode($data);
    }

    public function getKecamatan()
    {
        $kd = $this->input->post('kd_kecamatan');
        $data = $this->db->get_where('kecamatan', ['id' => $kd])->row_array();

        echo json_encode($data);
    }

    public function delete_alamat_pelanggan()
    {
        $this->delete_session_alamat();

        // pusher('alamat_checkout');
        // pusher('total_keranjang_checkout');

        $data = toast('success', 'Alamat Berhasil Dihapus');

        echo json_encode($data);
    }

    function delete_session_alamat()
    {
        $this->session->unset_userdata('nama');
        $this->session->unset_userdata('telp');
        //jangan lupa unset pada saat post order
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('subdis');
        $this->session->unset_userdata('kd_pos');
        $this->session->unset_userdata('searchmap');
        $this->session->unset_userdata('jarak');
        $this->session->unset_userdata('latitude');
        $this->session->unset_userdata('longitude');
        $this->session->unset_userdata('alamat');
        $this->session->unset_userdata('patokan_alamat');
        $this->session->unset_userdata('ongkir');
    }

    public function send()
    {
        $sl = $this->db->query("SELECT * FROM config WHERE id_user = '1'")->row();
        $string = $this->create_random(6);

        $data = [
            'no_telp' => replace_phone_number($this->input->post('nomer')),
            'kode_verifikasi' => $string
        ];

        $this->db->insert('verifikasi', $data);

        $host = $sl->host;
        $sg = $sl->signature;
        $nope = replace_phone_number($this->input->post('nomer'));
        $sess = [
            'telp' => $nope,
        ];

        $this->session->set_userdata($sess);

        $isi = urlencode("_*" . $string . "*_" . "\nBerikut Kode (OTP) Anda. JANGAN BERI kode ini ke siapa pun. \nKode Berlaku 1 menit.");
        $cp = urlencode("\n\n*_" . $sg . "_*");
        file_get_contents($host . "/msg?number=" . $nope . "&message=" . $isi);

        $data = toast('success', 'Pesan Berhasil Terkirim');

        echo json_encode($data);
    }

    public function verifikasi()
    {
        $kd_verif = $this->input->post('kd_verif');
        $telp = $this->session->userdata('telp');

        $get = $this->db->get_where('verifikasi', ['no_telp' => $telp, 'kode_verifikasi' => $kd_verif])->result_array();

        if (count($get) > 0) {
            $update = ['status' => 1];
            $this->db->update('verifikasi', $update, ['no_telp' => replace_phone_number($telp)]);
            $data = toast('success', 'Kode Berhasil Terverifikasi.');
        } else {
            $data = toast('error', 'Kode Salah, Harap Masukkan kode dengan benar.');
        }

        echo json_encode($data);
    }

    public function hapus_verifikasi()
    {
        $telp = $this->session->userdata('telp');
        $check = $this->db->get_where('verifikasi', ['no_telp' => $this->session->userdata('telp'), 'status' => 1])->result_array();
        if (count($check) > 0) {
            $data = toast('success', 'Kode Berhasil Terverifikasi.');
        } else {
            $this->db->delete('verifikasi', ['no_telp' => replace_phone_number($telp)]);
            $this->session->unset_userdata('telp');
            $data = toast('error', 'Waktu Habis, silahkan coba lagi.');
        }

        echo json_encode($data);
    }

    function create_random($length)
    {
        $data = '123456789';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $pos = rand(0, strlen($data) - 1);
            $string .= $data[$pos];
        }
        return $string;
    }

    public function custom_menu()
    {
        if (!$this->session->userdata('kd_member')) {
            $this->session->set_flashdata('error_page', 'Anda Harus Login terlebih dahulu.');
            redirect(base_url('main'));
        }
        $data['judul'] = 'Custon Menu';
        $data['logo'] = $this->db->get('logo')->row_array();
        $data['laukutama'] = $this->db->get_where('custom', ['jenis_custom' => 'laukutama'])->result_array();
        $data['laukpendamping'] = $this->db->get_where('custom', ['jenis_custom' => 'laukpendamping'])->result_array();
        $data['sayur'] = $this->db->get_where('custom', ['jenis_custom' => 'sayur'])->result_array();
        $data['buah'] = $this->db->get_where('custom', ['jenis_custom' => 'buah'])->result_array();
        $data['karbohidrat'] = $this->db->get_where('custom', ['jenis_custom' => 'karbohidrat'])->result_array();
        // $data['userCustomMenu'] = $this->ModelProduk->getUserCustomMenu();

        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/custom_menu', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    public function tambah_menu_custom()
    {
        $laukutama =  getnamecustom($this->input->post('laukutama')) != "" ? getnamecustom($this->input->post('laukutama')) . "<br>" : "";
        $laukpendamping =  getnamecustom($this->input->post('laukpendamping')) != "" ? getnamecustom($this->input->post('laukpendamping')) . "<br>" : "";
        $sayur =  getnamecustom($this->input->post('sayur')) != "" ? getnamecustom($this->input->post('sayur')) . "<br>" : "";
        $buah =  getnamecustom($this->input->post('buah')) != "" ? getnamecustom($this->input->post('buah')) . "<br>" : "";
        $karbohidrat =  getnamecustom($this->input->post('karbohidrat')) != "" ? getnamecustom($this->input->post('karbohidrat')) . "<br>" : "";
        $gambar_awal = "custom.jpg";
        $deskripsi = "<p>" . $laukutama . $laukpendamping . $sayur . $buah . $karbohidrat  . "</p>";

        $harga_laukutama =  gethargacustom($this->input->post('laukutama')) != 0 ? gethargacustom($this->input->post('laukutama')) : 0;
        $harga_laukpendamping =  gethargacustom($this->input->post('laukpendamping')) != 0 ? gethargacustom($this->input->post('laukpendamping')) : 0;
        $harga_sayur =  gethargacustom($this->input->post('sayur')) != 0 ? gethargacustom($this->input->post('sayur')) : 0;
        $harga_buah =  gethargacustom($this->input->post('buah')) != 0 ? gethargacustom($this->input->post('buah')) : 0;
        $harga_karbohidrat =  gethargacustom($this->input->post('karbohidrat')) != 0 ? gethargacustom($this->input->post('karbohidrat')) : 0;
        $custom = $this->input->post('custom');

        $harga = $harga_laukutama + $harga_laukpendamping + $harga_buah + $harga_sayur + $harga_karbohidrat;

        $dataProduk = [
            'kd_produk' => $this->getKodeOtomatis("PS", "produk"),
            'nm_produk' => "Menu Custom",
            'foto_produk' => $gambar_awal,
            'kd_kategori' => "KAT-017",
            'kd_sub_kategori' => "KSB-007",
            'deskripsi' => $deskripsi,
            'harga' =>  $harga,
            'min_order' => 1,
            'created_at_admin' => $this->session->userdata('kd_member'),
            'updated_at_admin' => $this->session->userdata('kd_member'),
            'custom'    => $custom
        ];

        $this->db->insert('produk', $dataProduk);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('flash_page', 'Berhasil tambah menu custom.');
        } else {
            $this->session->set_flashdata('error_page', 'Maaf, Gagal tambah menu custom.');
        }

        redirect(base_url('catering/custom_menu'));
    }

    public function add_pemesanan()
    {
        if (!$this->session->userdata('kd_member')) {
            $this->session->set_flashdata('error_page', 'Anda Harus Login terlebih dahulu.');
            redirect(base_url('catering/checkout'));
        }

        $data = $this->cart->contents();

        foreach ($data as $data) {
            $this->db->select("*");
            $this->db->from("produk");
            $this->db->where("kd_produk", $data['id']);
            $dt = $this->db->get()->row_array();
        }

        $tgl_kirim = $this->input->post('tgl_kirim');
        $tgl_order = Date('Y-m-d', time());
        $payment_type = $this->input->post('payment_type');
        $kd_order = $this->getKodeOtomatis("FS", "order");
        $key = kunci();

        $kd_member = $this->session->userdata('kd_member');
        $id = $this->session->userdata('kd_member');
        $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
        $this->db->from('member');
        $this->db->join("detail_sosmed", "member.kd_member=detail_sosmed.kd_member");
        $this->db->where(['member.kd_member' => $id]);
        $member = $this->db->get()->row_array();

        if ($member == null) {
            $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
            $this->db->from('member');
            $this->db->where(['member.kd_member' => $id]);
            $member = $this->db->get()->row_array();
        }

        $konfigurasi = $this->db->get('konfigurasi')->row_array();

        if ($payment_type == "ambil_langsung") {
            $order_status = "pending";
            $total_harga = $this->cart->total();
            $total_transfer = $total_harga;
        } else if ($payment_type == "cod") {
            $order_status = "pending";
            $total_harga = $this->cart->total();
            $total_transfer = $total_harga;
        } else if ($payment_type == "transfer") {
            $order_status = "pending";
            $total_harga = $this->cart->total();
            $total_transfer = $total_harga - rand(0, 999);
        }

        $alamat_pengiriman = $this->session->userdata('alamat_pengiriman');
        if ($alamat_pengiriman == "alamat_utama") {
            $cust_name = $member['nm_member'];
            $cust_email = $member['email'];
            $cust_phone = $member['no_telp'];
            $cust_address = strip_tags(decrypt($member['alamat']));
            $cust_subdistrict = $member['kd_subdistricts'];
            $get_subdis = $this->db->get_where('kecamatan', ['id' => $cust_subdistrict])->row_array();

            $subdis = $get_subdis['provinsi'] . ', ' . $get_subdis['kabupaten'] . ', ' . $get_subdis['kecamatan'] . ', ' . $get_subdis['kelurahan'] . ', ' . $get_subdis['kodepos'];
            $cust_office = $member['kodepos'];
        } else {
            $member_alamat = $this->db->get_where('detail_alamat', ['kd_detail_alamat' => $alamat_pengiriman])->row_array();
            $cust_name = $member_alamat['nm_member_'];
            $cust_email = "";
            $cust_phone = $member_alamat['no_telp_'];
            $cust_address = strip_tags($member_alamat['alamat']);
            $cust_subdistrict = $member_alamat['subdistricts_'];
            $get_subdis = $this->db->get_where('kecamatan', ['id' => $cust_subdistrict])->row_array();

            $subdis = $get_subdis['provinsi'] . ', ' . $get_subdis['kabupaten'] . ', ' . $get_subdis['kecamatan'] . ', ' . $get_subdis['kelurahan'] . ', ' . $get_subdis['kodepos'];
            $cust_office = $member_alamat['kodepos_'];
        }

        $dataOrder = [
            'kd_order' => $kd_order,
            'kd_member' => $kd_member,
            'tgl_order' => $tgl_order,
            'tgl_kirim' => $tgl_kirim,
            'cust_name' => $cust_name,
            'cust_email' => $cust_email,
            'cust_phone' => $cust_phone,
            'cust_address' => $cust_address,
            'cust_subdistrict' => $subdis,
            'cust_office' => $cust_office,
            'payment_type' => $payment_type,
            'payment_status' => '0',
            'order_status' => $order_status,
            'total_harga' => $total_harga,
            'total_transfer' => $total_harga,
            'catatan_order' => $this->input->post('catatan'),
            'created_at_admin' => $this->session->userdata('kd_member'),
            'updated_at_admin' => $this->session->userdata('kd_member'),
        ];

        $this->db->insert('order', $dataOrder);

        $data = $this->cart->contents();
        foreach ($data as $d) {
            $kd_detail_order = $this->getKodeOtomatis("DFS", "detail_order");
            $dataDetailOrder = [
                'kd_detail_order' => $kd_detail_order,
                'kd_order' => $kd_order,
                'kd_produk' => $d['produk_kd'],
                'nm_produk' => $d['name'],
                'harga_produk' => $d['price'],
                'qty' => $d['qty'],
                'sub_total' => $d['subtotal'],
            ];

            $this->db->insert('detail_order', $dataDetailOrder);

            $datacatatan = [
                'kd_detail_order' => $kd_detail_order,
                'catatan' => $d['catatan']
            ];

            $this->db->insert('catatan_detail_order', $datacatatan);
        }

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('flash_page', 'Terimakasih sudah melakukan pemesanan. Silahkan hubungi admin untuk mengkonfirmasi pesanan.');
        } else {
            $this->session->set_flashdata('error_page', 'Maaf, Gagal melakukan pemesanan.');
        }

        // $this->delete_session_alamat();
        $this->cart->destroy();

        $sess = [
            'kd_order' => $kd_order,
        ];

        $this->session->set_userdata($sess);

        redirect(base_url('catering/order_selesai'));
    }

    public function mingguan()
    {
        if (!$this->session->userdata('kd_member')) {
            $this->session->set_flashdata('error_page', 'Anda Harus Login terlebih dahulu.');
            redirect(base_url('main'));
        }
        // $this->delete_session_alamat();
        $this->session->unset_userdata('alamat_pengiriman');
        $data['judul'] = 'Add Paket Mingguan';
        $data['logo'] = $this->db->get('logo')->row_array();

        if (!empty($this->session->userdata('kd_member'))) {
            $key = kunci();
            $id = $this->session->userdata('kd_member');
            $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
            $this->db->from('member');
            $this->db->join("detail_sosmed", "member.kd_member=detail_sosmed.kd_member");
            $this->db->where(['member.kd_member' => $id]);
            $data['user'] = $this->db->get()->row_array();

            if ($data['user'] == null) {
                $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
                $this->db->from('member');
                $this->db->where(['member.kd_member' => $id]);
                $data['user'] = $this->db->get()->row_array();
            }

            $data1 = [
                'alamat_pengiriman' => "alamat_utama"
            ];
            $this->session->set_userdata($data1);
        }

        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/add_paketmingguan', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    public function bulanan()
    {
        if (!$this->session->userdata('kd_member')) {
            $this->session->set_flashdata('error_page', 'Anda Harus Login terlebih dahulu.');
            redirect(base_url('main'));
        }
        // $this->delete_session_alamat();
        $this->session->unset_userdata('alamat_pengiriman');
        $data['judul'] = 'Add Paket Bulanan';
        $data['logo'] = $this->db->get('logo')->row_array();

        if (!empty($this->session->userdata('kd_member'))) {
            $key = kunci();
            $id = $this->session->userdata('kd_member');
            $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
            $this->db->from('member');
            $this->db->join("detail_sosmed", "member.kd_member=detail_sosmed.kd_member");
            $this->db->where(['member.kd_member' => $id]);
            $data['user'] = $this->db->get()->row_array();

            if ($data['user'] == null) {
                $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
                $this->db->from('member');
                $this->db->where(['member.kd_member' => $id]);
                $data['user'] = $this->db->get()->row_array();
            }

            $data1 = [
                'alamat_pengiriman' => "alamat_utama"
            ];
            $this->session->set_userdata($data1);
        }

        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/add_paketbulanan', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    public function get_datatable_order()
    {
        $key = kunci();
        $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email");
        $this->db->from("member");
        $this->db->where('kd_member', $this->session->userdata('kd_member'));
        $get = $this->db->get()->row_array();

        $get_order = $this->db->get_where('order', ['cust_phone' => $get['no_telp']])->result_array();

        $this->datatables->select('kd_order, tgl_order, cust_name, cust_email, cust_phone, total_harga, payment_type, order_status, order_type, rating');
        $this->datatables->from('order');

        if ($this->session->userdata('kd_member')) {
            // $this->datatables->where('kd_member', $this->session->userdata('kd_member'));
            $this->datatables->where(['cust_phone' => $get['no_telp']]);
            $this->datatables->where(['order_type' => null]);
        }

        $this->db->order_by("created_at", "DESC");
        foreach ($get_order as $go) {
            if ($go['order_status'] == "pending" && $go['payment_type'] == "transfer") {
                $this->datatables->add_column(
                    'aksi',
                    '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="$1" data-toggle="modal" data-target="#editModal">
                        <i class="fas fa-eye"></i> </a> </span>
                    <span data-toggle="tooltip" data-placement="top" title="Pembayaran"><a href="javascript:void(0);" class="pembayaran_order btn btn-sm btn-dark" data-id="$1" data-toggle="modal" data-target="#editModal">
                        <i class="fas fa-money-check"></i> </a> </span>',
                    'kd_order'
                );
            } else {
                $this->datatables->add_column(
                    'aksi',
                    '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="$1" data-toggle="modal" data-target="#editModal">
                            <i class="fas fa-eye"></i> </a> </span>',
                    'kd_order'
                );
            }
        }
        // $this->datatables->add_column(
        //     'aksi',
        //     '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="$1" data-toggle="modal" data-target="#editModal">
        //         <i class="fas fa-eye"></i> </a> </span>',
        //     'kd_order'
        // );
        return print_r($this->datatables->generate());
    }

    public function get_datatable_order_khusus()
    {
        $key = kunci();
        $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email");
        $this->db->from("member");
        $this->db->where('kd_member', $this->session->userdata('kd_member'));
        $get = $this->db->get()->row_array();

        $get_order = $this->db->get_where('order', ['cust_phone' => $get['no_telp']])->result_array();

        $this->datatables->select('kd_order, tgl_order, cust_name, cust_email, cust_phone, total_harga, payment_type, order_status, order_type');
        $this->datatables->from('order');

        if ($this->session->userdata('kd_member')) {
            // $this->datatables->where('kd_member', $this->session->userdata('kd_member'));
            $this->datatables->where(['cust_phone' => $get['no_telp']]);
            $this->datatables->where(['order_type!=' => null]);
        }

        $this->db->order_by("created_at", "DESC");
        foreach ($get_order as $go) {
            if ($go['order_status'] == "pending" && $go['payment_type'] == "transfer") {
                $this->datatables->add_column(
                    'aksi',
                    '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="$1" data-toggle="modal" data-target="#editModal">
                        <i class="fas fa-eye"></i> </a> </span>
                    <span data-toggle="tooltip" data-placement="top" title="Pembayaran"><a href="javascript:void(0);" class="pembayaran_order btn btn-sm btn-dark" data-id="$1" data-toggle="modal" data-target="#editModal">
                        <i class="fas fa-money-check"></i> </a> </span>',
                    'kd_order'
                );
            } else {
                $this->datatables->add_column(
                    'aksi',
                    '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="$1" data-toggle="modal" data-target="#editModal">
                            <i class="fas fa-eye"></i> </a> </span>',
                    'kd_order'
                );
            }
        }
        // $this->datatables->add_column(
        //     'aksi',
        //     '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="$1" data-toggle="modal" data-target="#editModal">
        //         <i class="fas fa-eye"></i> </a> </span>',
        //     'kd_order'
        // );
        return print_r($this->datatables->generate());
    }

    public function get_datatable_order_nonmember()
    {
        if ($this->session->userdata('kd_member')) {
            $key = kunci();
            $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email");
            $this->db->from("member");
            $this->db->where('kd_member', $this->session->userdata('kd_member'));
            $get = $this->db->get()->row_array();

            // update order dengan menambahkan kd_member
            $data = ['kd_member' => $get['kd_member']];
            $where = ['cust_phone' => $get['no_telp']];
            $this->db->update('order', $data, $where);
        }

        $get_order = $this->db->get_where('order', ['cust_phone' => replace_phone_number($this->session->userdata('telp'))])->result_array();

        $this->datatables->select('kd_order, tgl_order, cust_name, cust_email, cust_phone, total_harga, payment_type, order_status');
        $this->datatables->from('order');

        $this->datatables->where('cust_phone', replace_phone_number($this->session->userdata('telp')));

        $this->db->order_by("created_at", "DESC");
        return print_r($this->datatables->generate());
    }

    public function order_selesai()
    {
        $data['isi'] = urlencode("Hallo, \n\nSaya mau konfirmasi pemesanan dengan kode : _*" . $this->session->userdata('kd_order') . "*_");
        $data['judul'] = 'Selesai Pemesanan';
        $data['logo'] = $this->db->get('logo')->row_array();

        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/checkout_selesai', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    public function password()
    {
        $data['judul'] = 'Ubah Password';
        $data['logo'] = $this->db->get('logo')->row_array();

        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/ubah_password', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    public function password_act()
    {
        $kd_member = $this->session->userdata('kd_member');
        $password = $this->input->post('password');
        $repassword = $this->input->post('retype_password');

        if ($password != null && $password == $repassword) {
            $this->db->set('password', encrypt($password));
            $this->db->set('created_at_admin', $kd_member);
            $this->db->set('updated_at_admin', $kd_member);
        }

        $this->db->where('kd_member', $kd_member);

        $this->db->update('member');

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('flash_page', 'Selamat Anda Berhasil ubah password.');
        } else {
            $this->session->set_flashdata('error_page', 'Maaf, Gagal melakukan perubahan.');
        }

        redirect(base_url('catering/profile'));
    }

    public function add_member()
    {
        $data['judul'] = 'Pendaftaran Member';
        $data['logo'] = $this->db->get('logo')->row_array();

        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/add_member', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    public function add_member_act()
    {
        $upload_image = $_FILES['userfile']['name'];
        $password = $this->input->post('password');
        $repassword = $this->input->post('retype_password');

        $kd_member = $this->getKodeOtomatis("MBR", "member");
        $nohp = $this->input->post('no_telp');
        $result = preg_replace("/[^0-9]/", "", $nohp);
        $hp = replace_phone_number($result);

        $nm_member = ucwords($this->input->post('nm_member'));
        $email = $this->session->userdata('email');
        $kodepos =  $this->input->post('kodepos');
        $alamat = $this->input->post('alamat');
        $subdis = $this->input->post('subdistrict_cust_temp');
        $jk = $this->input->post('jk');
        $username = $hp;

        $key = kunci();

        $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email");
        $this->db->from("member");
        $this->db->join("user_role", "member.kd_member=user_role.kd_user");
        $this->db->where(["user_role.kd_role" => '3']);
        $this->db->having("no_telp LIKE '%$hp%' ");
        $get = $this->db->get('')->result_array();

        if (count($get) > 0) {
            $this->session->set_flashdata('error_page', 'Maaf, Nomer Telepon Sudah terdaftar.');
            redirect(base_url('catering/add_member'));
        }

        if ($password == null && $password != $repassword) {
            $this->session->set_flashdata('error_page', 'Maaf, Password Tidak Sama.');
            redirect(base_url('catering/add_member'));
        }

        $this->db->set('kd_member', $kd_member);
        $this->db->set('kd_subdistricts', $subdis);
        $this->db->set('alamat', encrypt($alamat));
        $this->db->set('jenis_kelamin', $jk);
        $this->db->set('nm_member', $nm_member);

        if ($upload_image) { // variabel true
            $config['allowed_types'] = 'jpg|jpeg|png';
            // $config['max_size']     = '8192';
            $config['upload_path'] = './assets/images/user/';
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('userfile')) {
                $new_image = $this->upload->data('file_name');
                $this->db->set('image', $new_image);
            }
        }

        $this->db->escape($hp);
        $this->db->set('no_telp', "AES_ENCRYPT('{$hp}','{$key}')", FALSE);
        $this->db->escape($email);
        $this->db->set('email', "AES_ENCRYPT('{$email}','{$key}')", FALSE);
        $this->db->escape($kodepos);
        $this->db->set('kodepos', "AES_ENCRYPT('{$kodepos}','{$key}')", FALSE);
        $this->db->escape($username);
        $this->db->set('username', "AES_ENCRYPT('{$username}','{$key}')", FALSE);
        if ($password != null && $password == $repassword) {
            $this->db->set('password', encrypt($password));
        }
        $this->db->set('is_member_aktif', 0);
        $this->db->set('created_at_admin', $kd_member);
        $this->db->set('updated_at_admin', $kd_member);


        $this->db->insert('member');

        if ($this->db->affected_rows() >= 0) {
            $this->session->set_flashdata('flash_page', 'Selamat Anda Berhasil melakukan pendaftaran.');
            $this->session->set_flashdata('login', 'Login');
        } else {
            $this->session->set_flashdata('error_page', 'Maaf, Gagal melakukan pendaftaran.');
        }
        $this->delete_session_alamat();

        redirect(base_url('catering/add_member'));
    }

    public function profile()
    {
        $data['judul'] = 'Profile';
        $data['logo'] = $this->db->get('logo')->row_array();

        if (!empty($this->session->userdata('kd_member'))) {
            $key = kunci();
            $id = $this->session->userdata('kd_member');
            $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
            $this->db->from('member');
            $this->db->join("detail_sosmed", "member.kd_member=detail_sosmed.kd_member");
            $this->db->where(['member.kd_member' => $id]);
            $data['user'] = $this->db->get()->row_array();

            if ($data['user'] == null) {
                $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
                $this->db->from('member');
                $this->db->where(['member.kd_member' => $id]);
                $data['user'] = $this->db->get()->row_array();
            }
        }

        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/profile', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    public function edit_profile_act()
    {
        $upload_image = $_FILES['userfile']['name'];

        $nohp = $this->input->post('no_telp');
        $hp = replace_phone_number($nohp);

        $kd_member = $this->input->post('kd_member');
        $nm_member = ucwords($this->input->post('nm_member'));
        $email = $this->input->post('email');
        $username = $hp;

        $key = kunci();

        $this->db->set('jenis_kelamin', $this->input->post('jk'));
        $this->db->set('nm_member', $nm_member);

        $this->db->escape($hp);
        $this->db->set('no_telp', "AES_ENCRYPT('{$hp}','{$key}')", FALSE);
        $this->db->escape($email);
        $this->db->set('email', "AES_ENCRYPT('{$email}','{$key}')", FALSE);
        $this->db->escape($username);
        $this->db->set('username', "AES_ENCRYPT('{$username}','{$key}')", FALSE);

        $this->db->set('updated_at_admin', $this->session->userdata('kd_admin'));
        $this->db->set('updated_at', date('Y-m-d H:i:s', time()));

        if ($upload_image) { // variabel true
            $config['allowed_types'] = 'jpg|jpeg|png|svg';
            // $config['max_size']     = '8192';
            $config['upload_path'] = './assets/images/user/';
            $this->load->library('upload', $config);

            $data = $this->db->get_where('member', ['kd_member' => $this->input->post('kd_member')])->row_array();
            $old_image = $data['image'];
            if ($old_image != 'default.jpg') {
                unlink(FCPATH . '/assets/images/user/' . $old_image);
            }

            if ($this->upload->do_upload('userfile')) {
                $new_image = $this->upload->data('file_name');
                $this->db->set('image', $new_image);
            }
        }

        $this->db->where('kd_member', $kd_member);

        $this->db->update('member');

        if ($this->db->affected_rows() >= 0) {
            $this->session->set_flashdata('flash_page', 'Selamat Anda Berhasil melakukan edit profile.');
        } else {
            $this->session->set_flashdata('error_page', 'Maaf, Gagal melakukan edit profile.');
        }

        redirect(base_url('catering/profile'));
    }

    public function getMemberById()
    {
        $key = kunci();
        $id = $this->input->post('kd_member');
        $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
        $this->db->from('member');
        $this->db->join("detail_sosmed", "member.kd_member=detail_sosmed.kd_member");
        $this->db->where(['member.kd_member' => $id]);
        $data = $this->db->get()->row_array();

        if ($data == null) {
            // $data = $this->db->get_where('member', ['kd_member' => $id])->row_array();
            $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
            $this->db->from('member');
            $this->db->where(['member.kd_member' => $id]);
            $data = $this->db->get()->row_array();
        }
        echo json_encode($data);
    }

    public function edit_alamat_utama()
    {
        $key = kunci();

        $this->db->set('kd_subdistricts', $this->input->post('subdistrict'));
        $this->db->set('alamat', encrypt($this->input->post('alamat')));
        $this->db->escape($this->input->post('kode_pos'));
        $this->db->set('kodepos', "AES_ENCRYPT('{$this->input->post('kode_pos')}','{$key}')", FALSE);
        $this->db->set('updated_at_admin', $this->session->userdata('kd_member'));
        $this->db->set('updated_at', date('Y-m-d H:i:s', time()));
        $this->db->where('kd_member', $this->input->post('kd_member'));
        $this->db->update('member');

        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Alamat Utama Berhasil Diubah');
        } else {
            $data = toast('error', 'Maaf, Alamat Utama Tidak Berhasil Diubah');
        }

        echo json_encode($data);
    }

    public function delete_alamat_utama()
    {
        $kd = $this->input->post('kd_member');
        $data = [
            'alamat' => "",
            'kd_subdistricts' => "",
            'kodepos' => ""
        ];

        $this->db->update('member', $data, ['kd_member' => $kd]);

        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Alamat Utama Berhasil Dihapus');
        } else {
            $data = toast('error', 'Maaf, Alamat Utama Tidak Berhasil Dihapus');
        }

        echo json_encode($data);
    }

    public function add_alamat_lain()
    {
        $checkout_page = $this->input->post('checkout_page');
        $kd = $this->getKodeOtomatis('AL', 'detail_alamat');
        $kd_member = $this->session->userdata('kd_member');
        $nama_lengkap = $this->input->post('nama_lengkap');
        $no_handphone = replace_phone_number($this->input->post('no_handphone'));
        $subdistricts = $this->input->post('subdistrict');
        $kode_pos = $this->input->post('kode_pos');
        $alamat = $this->input->post('alamat');
        $label = $this->input->post('label');
        $label_name = $this->input->post('label_name');
        if ($label == "lainnya") {
            $lokasi = $label_name;
        } else {
            $lokasi = $label;
        }

        $data = [
            'kd_detail_alamat' => $kd,
            'kd_member' => $kd_member,
            'nm_member_' => $nama_lengkap,
            'no_telp_' => $no_handphone,
            'subdistricts_' => $subdistricts,
            'kodepos_' => $kode_pos,
            'lokasi_' => $lokasi,
            'alamat' => $alamat,
        ];

        $this->db->insert('detail_alamat', $data);

        echo $this->show_alamatlain($checkout_page);
    }

    public function show_alamatlain($checkout_page)
    {
        $output = '';
        $no = 0;

        $alamat_lain = $this->db->get_where('detail_alamat', ['kd_member' => $this->session->userdata('kd_member')])->result_array();
        foreach ($alamat_lain as $a) {
            $kec = $this->db->get_where('kecamatan', ['id' => $a['subdistricts_']])->row_array();
            $no++;
            if ($checkout_page == 1 || $checkout_page == "1") {
                $display = "";
            } else {
                $display = "display: none;";
            }
            $output .= '
            <div class="col-md-6">
                <div class="bg-white card addresses-item mb-3  shadow-sm">
                    <div class="gold-members p-3">
                        <div class="media">
                            <div class="media-body">
                                <span class="badge badge-danger">' . ucfirst($a['nm_member_']) . ' - ' . $a['lokasi_'] . '</span>
                                <h6 class="mb-3 mt-3 text-dark">' . ucfirst($a['nm_member_']) . '</h6>
                                <p>' . ucfirst(strip_tags($a['alamat'])) . '
                                </p>
                                <p> ' . $kec['provinsi'] . "," . $kec['kabupaten'] . ", " . $kec['kecamatan'] . ", " . $kec['kelurahan'] . '
                                </p>
                                <p class="text-secondary" id="txt_kodepos_lain"> <span class="text-dark">
                                    ' . $kec['kodepos'] . '
                                </p>
                                <button style="' . $display . '" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour" type="button" class="btn btn-outline-primary btn-block collapsed selected_alamat_lain" data-id="' . $a['kd_detail_alamat'] . '">PENGIRIMAN DISINI</button>
                                <hr>

                                <p class="mb-0 text-black">
                                    <a class="text-success mr-3 edit_alamat_lain" href="javascript:void(0)" data-id="' . $a['kd_detail_alamat'] . '"><i class="icofont-ui-edit"></i> EDIT</a>
                                    <a class="text-danger delete_alamat_lain" data-toggle="modal" data-target="#delete-alamat-lain" href="javascript:void(0)" data-id="' . $a['kd_detail_alamat'] . '"><i class="icofont-ui-delete"></i> DELETE</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }

        $output .= '
        <div class="col-md-6 pb-4">
            <a data-toggle="modal" data-target="#add-alamat-lain" href="#">
                <div class="bg-light border rounded  mb-3  shadow-sm text-center h-100 d-flex align-items-center">
                    <h6 class="text-center m-0 w-100"><i class="icofont-plus-circle icofont-3x mb-5"></i><br><br>Tambah Alamat Lain</h6>
                </div>
            </a>
        </div>
        ';

        echo $output;
    }

    public function getDetailAlamatById()
    {
        $kd = $this->input->post('kd_detail_alamat');
        $get = $this->db->get_where('detail_alamat', ['kd_detail_alamat' => $kd])->row_array();

        echo json_encode($get);
    }

    public function delete_alamat_lain()
    {
        $checkout_page = $this->input->post('checkout_page');
        $kd = $this->input->post('kd_detail_alamat');

        $this->db->delete('detail_alamat', ['kd_detail_alamat' => $kd]);

        echo $this->show_alamatlain($checkout_page);
    }

    public function edit_alamat_lain()
    {
        $checkout_page = $this->input->post('checkout_page');
        $kd = $this->input->post('kd_detail_alamat');
        $kd_member = $this->session->userdata('kd_member');
        $nama_lengkap = $this->input->post('nama_lengkap');
        $no_handphone = replace_phone_number($this->input->post('no_handphone'));
        $subdistricts = $this->input->post('subdistrict');
        $kode_pos = $this->input->post('kode_pos');
        $alamat = $this->input->post('alamat');
        $label = $this->input->post('label');
        $label_name = $this->input->post('label_name');
        if ($label == "lainnya") {
            $lokasi = $label_name;
        } else {
            $lokasi = $label;
        }

        $data = [
            'kd_member' => $kd_member,
            'nm_member_' => $nama_lengkap,
            'no_telp_' => $no_handphone,
            'subdistricts_' => $subdistricts,
            'kodepos_' => $kode_pos,
            'lokasi_' => $lokasi,
            'alamat' => $alamat,
        ];

        $this->db->update('detail_alamat', $data, ['kd_detail_alamat' => $kd]);

        echo $this->show_alamatlain($checkout_page);
    }

    public function getKodeOtomatis($kode = null, $tabel = null)
    {
        $this->db->select('*');
        $this->db->from("$tabel");
        $query = $this->db->get_compiled_select();
        $sql = $this->db->query($query . " where LEFT(kd_$tabel, " . strlen($kode) . ") = '$kode' ORDER BY kd_$tabel DESC ")->row_array();
        $tahun = date('y', time());
        $bulan = date('m', time());

        $kode = $kode;

        if ($kode == "62") {
            if ($sql != Null && substr($sql["kd_$tabel"], -7, 2) == $tahun) {

                $number = (int) substr($sql["kd_$tabel"], -5);
                $digit = intval($number) + 1;

                if ($digit >= 1 and $digit <= 9) {
                    $a = $kode . "-" . $bulan . $tahun . "0000" . $digit;
                } else if ($digit >= 10 and $digit <= 99) {
                    $a = $kode . "-" . $bulan . $tahun . "000" . $digit;
                } else if ($digit >= 100 and $digit <= 999) {
                    $a = $kode . "-" . $bulan . $tahun . "00" . $digit;
                } else if ($digit >= 1000 and $digit <= 9999) {
                    $a = $kode . "-" . $bulan . $tahun . "0" . $digit;
                } else {
                    $a = $kode . "-" . $bulan . $tahun . $digit;
                }
            } else {
                $kodedefault = $kode . "-" . $bulan . $tahun . "00001";
                $a = $kodedefault;
            }
        } else {
            if ($sql != Null && substr($sql["kd_$tabel"], -7, 2) == $tahun) {

                $number = (int) substr($sql["kd_$tabel"], -5);
                $digit = intval($number) + 1;

                if ($digit >= 1 and $digit <= 9) {
                    $a = $kode . "-" . $bulan . $tahun . "0000" . $digit;
                } else if ($digit >= 10 and $digit <= 99) {
                    $a = $kode . "-" . $bulan . $tahun . "000" . $digit;
                } else if ($digit >= 100 and $digit <= 999) {
                    $a = $kode . "-" . $bulan . $tahun . "00" . $digit;
                } else if ($digit >= 1000 and $digit <= 9999) {
                    $a = $kode . "-" . $bulan . $tahun . "0" . $digit;
                } else {
                    $a = $kode . "-" . $bulan . $tahun . $digit;
                }
            } else {
                $kodedefault = $kode . "-" . $bulan . $tahun . "00001";
                $a = $kodedefault;
            }
        }

        return $a;
    }

    public function addmasukkansaran()
    {
        $data = [
            'nm_pelanggan' => $this->input->post('name'),
            'notelp_pelanggan' => $this->input->post('phone'),
            'email_pelanggan' => $this->input->post('email'),
            'pesan' => $this->input->post('message'),
        ];

        $this->db->insert('masukkansaran', $data);

        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Saran dan Masukkan Berhasil Dikirim.');
        } else {
            $data = toast('error', 'Maaf, Saran dan Masukkan Tidak Berhasil Dikirim');
        }

        echo json_encode($data);
    }

    public function cek_notelp()
    {
        $notelp = $this->input->post('notelp');
        $no = replace_phone_number($notelp);

        $key = kunci();
        // Fetch users
        $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email");
        $this->db->from("member");
        $this->db->join("user_role", "member.kd_member=user_role.kd_user");
        $this->db->where(["user_role.kd_role" => '3']);
        $this->db->having("no_telp LIKE '%$no%' ");
        $get = $this->db->get('')->result_array();

        if (count($get) > 0) {
            $data = toast('error', 'Maaf, Nomer Telepon Sudah terdaftar.');
        } else {
            $data = toast('success', 'Nomer Telepon Bisa digunakan.');
        }

        echo json_encode($data);
    }

    public function daftar_pesanan()
    {
        $data['judul'] = 'Daftar Pesanan';
        $data['logo'] = $this->db->get('logo')->row_array();

        if (!$this->session->userdata('kd_member')) {
            $this->session->set_flashdata('error_page', 'Anda Harus Login terlebih dahulu.');
            redirect(base_url('main'));
        }


        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/daftar_pesanan', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    public function get_datatable_temporary_order()
    {
        $get = $this->db->get_where('order', ['cust_phone' => replace_phone_number($this->session->userdata('telp'))])->result_array();
        $this->datatables->select('kd_temporary_order, tgl_order, cust_name, cust_email, cust_phone, total_harga, payment_type, order_status');
        $this->datatables->from('temporary_order');
        $this->datatables->where('cust_phone', replace_phone_number($this->session->userdata('telp')));
        $this->db->order_by("created_at", "DESC");
        $this->datatables->add_column(
            'aksi',
            '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_order btn btn-sm btn-success" data-id="$1" data-toggle="modal" data-target="#editModal">
                <i class="fas fa-eye"></i> </a> </span>',
            'kd_temporary_order'
        );
        return print_r($this->datatables->generate());
    }

    public function pembayaran_pesanan($kd_order)
    {
        $kd = decrypt(base64_decode($kd_order));
        $data['order'] = $this->db->get_where('order', ['kd_order' => $kd])->row_array();
        $data['judul'] = 'Pembayaran Pesanan';
        $data['logo'] = $this->db->get('logo')->row_array();

        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/pembayaran_pesanan', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    public function add_rating($kd_order)
    {
        $kd = decrypt(base64_decode($kd_order));
        $data['order'] = $this->db->get_where('order', ['kd_order' => $kd])->row_array();
        $data['detail_order'] = $this->db->get_where('detail_order', ['kd_order' => $kd])->result_array();
        $data['judul'] = 'Rating Kepuasan Pelanggan';
        $data['logo'] = $this->db->get('logo')->row_array();


        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/add_rating', $data);
        $this->load->view('base-toko/footer_', $data);
    }
    public function add_rating_act()
    {
        $kd_order = $this->input->post('kd_order');
        $rating = $this->input->post('rating');

        $this->db->update('order', ['rating' => $rating], ['kd_order' => $kd_order]);

        $data = toast('success', 'Rating telah disimpan. Terimakasih!');

        echo json_encode($data);
    }

    public function upload_bukti_pembayaran()
    {
        $upload_image = $_FILES['bukti_transfer']['name'];
        $kd_order = $this->input->post('kd_order');

        if ($upload_image) { // variabel true
            $config['allowed_types'] = 'jpg|jpeg|png';
            // $config['max_size']     = '8192';
            $config['upload_path'] = './assets/images/bukti_pembayaran/';
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('bukti_transfer')) {

                $new_image = $this->upload->data('file_name'); // file name yaitu nama bawaan gambar

                $dt = $this->db->get_where('bukti_pembayaran', ['kd_order' => $kd_order]);

                if ($dt->num_rows() > 0) {

                    $dt = $dt->row_array();

                    $old_image = $dt['bukti_upload'];

                    if ($old_image != 'default.svg') {
                        unlink(FCPATH . '/assets/images/bukti_pembayaran/' . $old_image);
                    }

                    $where = ['kd_order'    => $kd_order];
                    $data = [
                        'bukti_upload'      => $new_image,
                        'updated_at_admin'  => empty($this->session->userdata('kd_member')) ? "" : $this->session->userdata('kd_member'),
                        'updated_at'        => date('Y-m-d H:i:s', time()),
                    ];

                    $this->db->update('bukti_pembayaran', $data, $where);

                    $data_order = ['payment_status' => 0];
                    $this->db->update('order', $data_order, $where);
                } else {
                    $data = [
                        'kd_bukti_pembayaran'     => $this->getKodeOtomatis("PEM", "bukti_pembayaran"),
                        'kd_order'          => $kd_order,
                        'bukti_upload'      => $new_image,
                        'status'            => 0,
                        'created_at_admin'  => empty($this->session->userdata('kd_member')) ? "" : $this->session->userdata('kd_member'),
                        'updated_at_admin'  => empty($this->session->userdata('kd_member')) ? "" : $this->session->userdata('kd_member'),
                    ];

                    $this->db->insert('bukti_pembayaran', $data);

                    $where = ['kd_order'    => $kd_order];
                    $data_order = ['payment_status' => 0];
                    $this->db->update('order', $data_order, $where);
                }


                $this->session->set_flashdata('flash_page', 'Terimakasih sudah melakukan pembayaran. Sedang Tahap Pengecekan Bukti Transfer.');

                if (!$this->session->userdata('kd_member')) {
                    redirect(base_url('catering/daftar_pesanan'));
                } else {
                    redirect(base_url('catering/profile'));
                }
            } else {
                $this->session->set_flashdata('error_page', 'Maaf, Gagal melakukan pembayaran.');
                if (!$this->session->userdata('kd_member')) {
                    redirect(base_url('catering/daftar_pesanan'));
                } else {
                    redirect(base_url('catering/profile'));
                }
            }
        }
    }

    public function delete_temporary_order()
    {
        $config = $this->db->get('konfigurasi')->row_array();

        $get = $this->db->get('temporary_order')->result_array();
        foreach ($get as $g) {
            $tgl_order = date('Y-m-d', strtotime("+" . $config['batas_delete_temporary'] . " day", strtotime($g['tgl_order'])));
            $tgl_now = date('Y-m-d');

            if ($tgl_now >= $tgl_order) {
                $this->db->delete('temporary_order', ['kd_temporary_order' => $g['kd_temporary_order']]);
                $this->db->delete('temporary_detail_order', ['kd_temporary_order' => $g['kd_temporary_order']]);
            }
        }
    }

    public function getOrderById()
    {
        $id = $this->input->post('kd_order');
        $data = $this->db->get_where('order', ['kd_order' => $id])->row_array();

        echo json_encode($data);
    }

    public function check_telp_order()
    {
        $telp = $this->input->post('telp');

        $temp_order = $this->db->get_where('temporary_order', ['cust_phone' => replace_phone_number($telp)])->num_rows();
        $order = $this->db->get_where('order', ['cust_phone' => replace_phone_number($telp)])->num_rows();

        if ($temp_order > 0) {
            $sess = ['telp' => replace_phone_number($telp)];
            $this->session->set_userdata($sess);
            $data = toast('success', 'Data pesanan ditemukan.');
        } else {
            if ($order > 0) {
                $sess = ['telp' => replace_phone_number($telp)];
                $this->session->set_userdata($sess);
                $data = toast('success', 'Data pesanan ditemukan.');
            } else {
                $data = toast('error', 'Maaf, data pesanan tidak ditemukan.');
            }
        }
        echo json_encode($data);
    }

    public function add_alamat_pengiriman()
    {
        $data = [
            'alamat_pengiriman' => $this->input->post('alamat')
        ];
        $this->session->set_userdata($data);


        $data = toast('success', 'Alamat Utama Berhasil Dipilih');

        echo json_encode($data);
    }

    public function get_tujuan()
    {
        $searchTerm = $this->input->post('searchTerm');

        $this->db->select('*');
        $this->db->from("kecamatan");
        $this->db->like("kecamatan", $searchTerm);
        $this->db->or_like("kelurahan", $searchTerm);
        $this->db->or_like("kabupaten", $searchTerm);
        $fetched_records = $this->db->get();
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['provinsi'] . ', ' . $user['kabupaten'] . ', ' . $user['kecamatan'] . ', ' . $user['kelurahan'] . ', ' . $user['kodepos'], "kodepos" => $user['kodepos']);
        }

        echo json_encode($data);
    }
}
