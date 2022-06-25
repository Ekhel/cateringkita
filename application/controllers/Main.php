<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
    }

    public function cekorder()
    {
        $order = $this->db->get_where('order', ['is_order_hapus' => '1'])->result_array();

        foreach ($order as $ord) {
            $detail = $this->db->get_where('detail_order', ['kd_order' => $ord['kd_order']])->row_array();

            var_dump($ord['kd_order']);
            var_dump($detail['kd_detail_order']);
            echo "<br>";
            echo "<br>";
        }
        die;
    }

    public function order($tgl)
    {
        $this->db->select('*');
        $this->db->from('order');
        $this->db->join("detail_order", "order.kd_order=detail_order.kd_order");
        $this->db->where(['order.tgl_order' => $tgl]);
        $data = $this->db->get()->result_array();

        for ($i = 0; $i < count($data); $i++) {

            $produk = $this->db->get_where('detail_produk', ['kd_detail_produk' => $data[$i]['kd_detail_produk']])->row_array();

            $dataa = [
                'nominal_komisi_selera' => $produk['nominal_komisi_selera'],
                'nominal_komisi' => $produk['nominal_komisi'],
                'jml_komisi_selera' => $produk['nominal_komisi_selera'] * $data[$i]['qty'],
                'jml_komisi' => $produk['nominal_komisi'] * $data[$i]['qty']
            ];

            $this->db->update('detail_order', $dataa, ['kd_detail_order' => $data[$i]['kd_detail_order']]);

            $this->db->update('order', ['payment_status' => '1'], ['kd_order' => $data[$i]['kd_order']]);
        }
    }

    public function cekChartHarianDanBulanan($waktu = null, $jns = null)
    {
        $admin  = $this->db->get_where('admin', ['kd_admin' => $this->session->userdata('kd_admin')])->row_array();

        $this->db->select("sum(total_transfer) as total");
        $this->db->from("order");
        if ($jns == "bulan") {
            $this->db->where(['month(order.tgl_order)' => "$waktu", 'year(order.tgl_order)' => date("Y", time())]);
        } else if ($jns == "hari") {
            if ($waktu != "0") {
                $hari = date('Y-m-d', strtotime("-$waktu day", strtotime(date("Y-m-d"))));
            } else {
                $hari = date('Y-m-d', time());
            }
            $this->db->where(['order.tgl_order' => "$hari"]);
        }

        $this->db->where(['is_order_hapus' => '1', 'order_toko' => $admin['toko']]);

        $data =  $this->db->get()->row_array();

        if ($data['total'] == null) {
            $data['total'] = 0;
        }

        return $data['total'];
    }

    public function chartBulanan()
    {
        echo json_encode(['jan' => $this->cekChartHarianDanBulanan("01", "bulan"), 'feb' => $this->cekChartHarianDanBulanan("02", "bulan"), 'mar' => $this->cekChartHarianDanBulanan("03", "bulan"), 'apr' => $this->cekChartHarianDanBulanan("04", "bulan"), 'mei' => $this->cekChartHarianDanBulanan("05", "bulan"), 'jun' => $this->cekChartHarianDanBulanan("06", "bulan"), 'jul' => $this->cekChartHarianDanBulanan("07", "bulan"), 'ags' => $this->cekChartHarianDanBulanan("08", "bulan"), 'sep' => $this->cekChartHarianDanBulanan("09", "bulan"), 'okt' => $this->cekChartHarianDanBulanan("10", "bulan"), 'nov' => $this->cekChartHarianDanBulanan("11", "bulan"), 'des' => $this->cekChartHarianDanBulanan("12", "bulan")]);
    }

    public function chartHarian()
    {
        echo json_encode(["hariH" => $this->cekChartHarianDanBulanan("0", "hari"), "hari1" => $this->cekChartHarianDanBulanan("01", "hari"), "hari2" => $this->cekChartHarianDanBulanan("02", "hari"), "hari3" => $this->cekChartHarianDanBulanan("03", "hari"), "hari4" => $this->cekChartHarianDanBulanan("04", "hari"), "hari5" => $this->cekChartHarianDanBulanan("05", "hari"), "hari6" => $this->cekChartHarianDanBulanan("06", "hari")]);
    }

    public function cekHariMinggu()
    {
        var_dump(date('D', time()));
        if (date('H:i', time()) > "21:29") {
            var_dump("benar");
            var_dump(date('H:i', time()));
        } else {
            var_dump("salah");
        }
    }

    public function deleteAllCache()
    {
        $this->cache->clean();

        $data = toast('success', 'Berhasil Delete Cache!');

        echo json_encode($data);
    }

    function random_strings($length_of_string)
    {
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }

    public function createQrCode($kode, $path)
    {
        $data['data'] = $kode;
        $data['size'] = 7;
        $data['savename'] = FCPATH . 'assets/images/qrcode/' . $path;
        $this->ciqrcode->generate($data);
    }

    public function generate_qr()
    {
        $admin = $this->db->get_where('admin', ['nis!=' => null])->result_array();
        for ($i = 0; $i < count($admin); $i++) {
            $this->createQrCode(base64_encode(encrypt($admin[$i]['nis'])), "absen/Karyawan/" . $admin[$i]['nis'] . ".png");
        }

        echo "berhasil";
    }

    public function krip()
    {

        $data = [
            'nis' => $this->input->post('nis'),
            'nama_santri' => $this->input->post('nama'),
            'jenis_kelamin' => $this->input->post('jk'),
            'divisi' => $this->input->post('divisi'),
            'jabatan' => $this->input->post('jabatan'),
            'tahun_bergabung' => $this->input->post('tahun'),
            'lembaga_perusahaan' => $this->input->post('lembaga'),
            'status' => $this->input->post('status'),
        ];

        $this->db->insert('santri_mukim', $data);

        $this->createQrCode(base64_encode(encrypt($this->input->post('nis'))), "absen/" . $this->input->post('nama') . ".png");
    }

    public function generate_kecamatan()
    {
        $members = $this->db->get('member')->result_array();

        foreach ($members as $member) {
            if ($member['kd_subdistricts'] == "" || $member['kd_subdistricts'] == null) {
                var_dump($member['kd_member']);
                $data = [
                    'kd_subdistricts' => '783'
                ];
                $this->db->update('member', $data, ['kd_member' => $member['kd_member']]);
            }
        }
        $data = toast('success', 'Berhasil Generate Kecamatan!');

        echo json_encode($data);
    }

    public function generate_referral()
    {
        $reseller = $this->db->get('reseller')->result_array();

        for ($i = 0; $i < count($reseller); $i++) {
            $kode = $this->random_strings(5);
            $get_reseller = $this->db->get_where('reseller', ['kode_referral' => $kode])->result_array();
            if (count($get_reseller) == 0) {
                $data = [
                    'kode_referral' => $kode
                ];

                $this->db->update('reseller', $data, ['kd_reseller' => $reseller[$i]['kd_reseller']]);
            }
        }

        $data = toast('success', 'Berhasil Delete Cache!');

        echo json_encode($data);
    }

    function _cek_hak_akses()
    {
        $sess_masak = $this->session->userdata('kd_masak');
        $sess_kurir = $this->session->userdata('kd_kurir');
        $sess_admin = $this->session->userdata('kd_admin');

        if ($sess_masak) {
            $tabel = "masak";
            $sess = "masak";
        } else if ($sess_admin) {
            $tabel = "admin";
            $sess = "admin";
        } else if ($sess_kurir) {
            $tabel = "kurir";
            $sess = "kurir";
        }

        $this->db->select("kd_role");
        if ($sess_masak) {
            $this->db->from("masak");
        } else if ($sess_admin) {
            $this->db->from("admin");
        } else if ($sess_kurir) {
            $this->db->from("kurir");
        }
        $this->db->join("user_role", "$tabel.kd_$tabel=user_role.kd_user");
        if ($sess_masak) {
            $this->db->where("$tabel.kd_$tabel", $this->session->userdata("kd_$sess"));
        } else if ($sess_admin) {
            $this->db->where("$tabel.kd_$tabel", $this->session->userdata("kd_$sess"));
        } else if ($sess_kurir) {
            $this->db->where("$tabel.kd_$tabel", $this->session->userdata("kd_$sess"));
        }
        $role = $this->db->get()->result_array();

        $dt = [];

        for ($i = 0; $i < count($role); $i++) {
            array_push($dt, $role[$i]['kd_role']);
        };

        return $dt;
    }

    public function index()
    {

        $this->db->select("*");
        $this->db->from("produk");
        $this->db->where(['is_produk_hapus' => 1]);
        $this->db->order_by('updated_at', 'ASC');
        $data['produk_All_Item'] = $this->db->get()->result_array();

        $data['judul'] = "Beranda";
        $data['logo'] = $this->db->get('logo')->row_array();
        $data['slider'] = $this->db->get('slider')->result_array();
        $data['kategori'] = $this->db->get('kategori')->result_array();

        $this->load->view('base-toko/header_', $data);
        $this->load->view('base-toko/navbar_', $data);
        $this->load->view('catering/index_', $data);
        $this->load->view('base-toko/footer_', $data);
    }

    function _createCaptcha()
    {
        $vals = array(
            'img_path'     => './assets/images/captcha/',
            'img_url'     => base_url() . 'assets/images/captcha/',
            'img_width'     => '130',
            'img_height' => 40,
            'border' => 10,
            'word_length'   => 5,
            'expiration' => 7200,
            'font_size'     => 100,
            'img_id'        => 'Imageid',
            'pool'          => '123456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ',
            'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(235, 0, 0),
                'grid' => array(210, 210, 210)
            )
        );

        // create captcha image
        $cap = create_captcha($vals);
        // store the captcha word in a session
        $this->session->set_userdata('mycaptcha', $cap['word']);
        $this->session->set_userdata('filecaptcha', $cap['filename']);

        return $cap['image'];
    }

    public function refresh_captcha()
    {
        unlink(FCPATH . '/assets/images/captcha/' . $this->session->userdata('filecaptcha'));
        // Captcha configuration
        $vals = array(
            'img_path'     => './assets/images/captcha/',
            'img_url'     => base_url() . 'assets/images/captcha/',
            'img_width'     => '130',
            'img_height' => 40,
            'border' => 10,
            'word_length'   => 5,
            'expiration' => 7200,
            'font_size'     => 100,
            'img_id'        => 'Imageid',
            'pool'          => '123456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ',
            'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(235, 0, 0),
                'grid' => array(210, 210, 210)
            )
        );

        $captcha = create_captcha($vals);

        // Unset previous captcha and store new captcha word
        $this->session->unset_userdata('filecaptcha');
        $this->session->unset_userdata('mycaptcha');
        $this->session->set_userdata('filecaptcha', $captcha['filename']);
        $this->session->set_userdata('mycaptcha', $captcha['word']);

        // Display captcha image
        echo $captcha['image'];
    }

    public function login_masak()
    {
        if ($this->session->userdata('kd_masak')) {
            $this->session->flashdata('flash', 'test');
            redirect('Dashboard');
        }

        $data['image'] = $this->_createCaptcha();

        $data['judul'] = "Pemaasak | Halaman Login";
        $data['judul_login'] = "Login Pemasak";
        $data['placeholder'] = "Username";
        $this->load->view('login_masak', $data);
    }

    public function login_kurir()
    {
        if ($this->session->userdata('kd_kurir')) {
            $this->session->flashdata('flash', 'test');
            redirect('Dashboard');
        }

        $data['image'] = $this->_createCaptcha();

        $data['judul'] = "Kurir | Halaman Login";
        $data['judul_login'] = "Login Kurir";
        $data['placeholder'] = "Username";
        $this->load->view('login_kurir', $data);
    }

    public function login()
    {
        if ($this->session->userdata('kd_admin')) {
            $this->session->flashdata('flash', 'test');
            redirect('Dashboard');
        }
        $this->session->unset_userdata('login');

        $data['image'] = $this->_createCaptcha();
        $this->session->set_userdata('login', $this->uri->segment('1'));

        $data['judul'] = "Admin | Halaman Login";
        $data['judul_login'] = "Login Admin";
        $data['placeholder'] = "Username";
        $this->load->view('login', $data);
    }

    public function cekLogin()
    {
        $key = kunci();
        $tampungan_role = [];
        $password = $this->input->post('password');
        $username = $this->input->post('username');
        $captcha = $this->input->post('captcha');
        $level = $this->input->post('level');

        $username = replace_phone_number($username);

        if ($level == "admin") {
            if ($captcha == "") {
                $data = ['toast' => toast('error', 'Captcha Harap Diisi Terlebih Dahulu!'), 'role' => null];
                echo json_encode($data);
                die;
            } else if (($captcha != $this->session->userdata('mycaptcha'))) {
                $data = ['toast' => toast('error', 'Kode Captcha Anda Salah!'), 'role' => null];
                echo json_encode($data);
                die;
            }

            $this->db->select("*");
            $this->db->from("admin");
            $this->db->join("user_role", "admin.kd_admin=user_role.kd_user");
            $this->db->join("role", "role.kd_role=user_role.kd_role");
            $this->db->where(['admin.username' => $username]);
            $admin = $this->db->get()->result_array();

            foreach ($admin as $admin) {
                array_push($tampungan_role, $admin['kd_role']);
            }

            if ($admin) {
                if ($admin['password'] == encrypt($password)) {

                    $this->session->set_userdata('kd_admin', $admin['kd_admin']);
                    $this->session->set_userdata('kd_role', $admin['kd_role']);

                    $data = ['toast' => toast('success', 'Hallo, Selamat Datang ' . $admin['nm_admin'] . '!'), 'role' => $admin['kd_role']];
                    unlink(FCPATH . '/assets/images/captcha/' . $this->session->userdata('filecaptcha'));
                } else {
                    $data = ['toast' => toast('error', 'Password Anda Salah!'), 'role' => null];
                }
            } else {
                $data = ['toast' => toast('error', 'User Tidak Ditemukan!'), 'role' => null];
            }
        } else if ($level == "masak") {
            $this->db->select("*");
            $this->db->from("masak");
            $this->db->join("user_role", "masak.kd_masak=user_role.kd_user");
            $this->db->join("role", "role.kd_role=user_role.kd_role");
            $this->db->where(['masak.username' => $username]);
            $masak = $this->db->get()->result_array();

            foreach ($masak as $masak) {
                array_push($tampungan_role, $masak['kd_role']);
            }

            if ($masak) {
                if ($masak['password'] == encrypt($password)) {

                    $this->session->set_userdata('kd_masak', $masak['kd_masak']);
                    $this->session->set_userdata('kd_role', $masak['kd_role']);

                    $data = ['toast' => toast('success', 'Hallo, Selamat Datang ' . $masak['nm_masak'] . '!'), 'role' => $masak['kd_role']];
                    unlink(FCPATH . '/assets/images/captcha/' . $this->session->userdata('filecaptcha'));
                } else {
                    $data = ['toast' => toast('error', 'Password Anda Salah!'), 'role' => null];
                }
            } else {
                $data = ['toast' => toast('error', 'User Tidak Ditemukan!'), 'role' => null];
            }
        } else {
            $this->db->select("*");
            $this->db->from("kurir");
            $this->db->join("user_role", "kurir.kd_kurir=user_role.kd_user");
            $this->db->join("role", "role.kd_role=user_role.kd_role");
            $this->db->where(['kurir.username' => $username]);
            $kurir = $this->db->get()->result_array();

            foreach ($kurir as $kurir) {
                array_push($tampungan_role, $kurir['kd_role']);
            }

            if ($kurir) {
                if ($kurir['password'] == encrypt($password)) {

                    $this->session->set_userdata('kd_kurir', $kurir['kd_kurir']);
                    $this->session->set_userdata('kd_role', $kurir['kd_role']);

                    $data = ['toast' => toast('success', 'Hallo, Selamat Datang ' . $kurir['nm_kurir'] . '!'), 'role' => $kurir['kd_role']];
                    unlink(FCPATH . '/assets/images/captcha/' . $this->session->userdata('filecaptcha'));
                } else {
                    $data = ['toast' => toast('error', 'Password Anda Salah!'), 'role' => null];
                }
            } else {
                $data = ['toast' => toast('error', 'User Tidak Ditemukan!'), 'role' => null];
            }
        }

        echo json_encode($data);
    }

    public function login_pelanggan()
    {
        $key = kunci();
        $password = $this->input->post('password');
        $username = replace_phone_number($this->input->post('username'));

        $member = $this->db->query("SELECT *, CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) decrypt FROM member HAVING decrypt = '$username' ")->row_array();

        if ($member) {

            if ($member['password'] == encrypt($password)) {

                if ($member['is_member_aktif'] == 1) {
                    $data = [
                        'kd_member' => $member['kd_member'],
                    ];
                    $this->session->set_userdata($data);

                    $data = ['toast' => toast('success', 'Hallo, Selamat Datang ' . $member['nm_member'] . '!'), 'role' => 'member'];
                } else {
                    $data = ['toast' => toast('error', 'User Tidak Aktif, Harap Konfirmasi Admin!'), 'role' => null];
                }
            } else {
                $data = ['toast' => toast('error', 'Password Anda Salah!'), 'role' => null];
            }
        } else {
            $data = ['toast' => toast('error', 'User Tidak Ditemukan!'), 'role' => null];
        }

        echo json_encode($data);
    }

    public function cekreseller()
    {
        $key = kunci();
        $no_telp = $this->input->post('no_telp');

        $telp = strval($no_telp);
        $hp = replace_phone_number($telp);

        $reseller = $this->db->query("SELECT *, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) decrypt FROM reseller  WHERE is_reseller_aktif = '1' AND is_reseller_hapus = '1'  HAVING decrypt = '$hp' ")->row_array();

        if ($reseller) {
            $data = ['toast' => toast('success', 'Nomer Telepon Ditemukan!'), 'no_telp' => base64_encode(encrypt($no_telp))];
        } else {
            $data = ['toast' => toast('error', 'Nomer Telepon Tidak Ditemukan!')];
        }

        echo json_encode($data);
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('kd_role');
        $this->session->unset_userdata('kd_admin');
        $this->session->unset_userdata('kd_masak');
        $this->session->unset_userdata('kd_kurir');

        $this->session->set_flashdata('flash', 'Logout');

        echo json_decode(true);
    }

    public function logout_pelanggan()
    {
        $this->session->unset_userdata('kd_member');
        $this->session->set_flashdata('flash_page', 'Terimakasih sudah menggunakan layanan kami.');
        redirect(base_url('main'));
    }

    public function datatable()
    {
        $data['judul'] = "Halaman Data Table";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('example/datatable', $data);
        $this->load->view('base/footer');
    }

    public function form()
    {
        $data['judul'] = "Halaman Form";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('example/form', $data);
        $this->load->view('base/footer');
    }

    public function getDataDetailProduk()
    {
        $kd_produk = $this->input->post('kd_produk');
        $a = [];

        for ($i = 0; $i < count($kd_produk); $i++) {
            $data = $this->db->get_where('detail_produk', ['kd_produk' => $kd_produk[$i]])->row_array();

            array_push($a, $data);
        }
        echo json_encode($a);
    }

    public function generateQrCode($path)
    {

        $dt = $this->db->get($path == "produk" ? "detail_produk" : $path);

        if ($dt->num_rows() > 0) {
            for ($i = 0; $i < $dt->num_rows(); $i++) {
                $dta = $dt->result_array();

                unlink(FCPATH . '/assets/images/qrcode/' . $path . "/" . $dta[$i]['kd_' . ($path == "produk" ? "detail_produk" : $path)] . ".png");

                $data['data'] = md5($dta[$i]['kd_' . ($path == "produk" ? "detail_produk" : $path)]);
                $data['size'] = 7;
                $data['savename'] = FCPATH . 'assets/images/qrcode/' . $path . "/" . $dta[$i]['kd_' . ($path == "produk" ? "detail_produk" : $path)] . ".png";
                $this->ciqrcode->generate($data);

                if ($i == ($dt->num_rows() - 1)) {
                    echo '<script>alert("Sukses Generate QrCode")</script>';
                }
            }
        }
    }

    public function getDataKategori()
    {
        $data = $this->db->get('kategori')->result_array();

        echo json_encode($data);
    }

    public function print_QrCode($a = null, $b = null)
    {

        $data['judul'] = "Print QrCode";

        $data['a'] = $a;

        if ($a == "detail_produk") {
            $data['tabel'] = "produk";
            $data['a'] = $b;
        }

        switch (substr($a, 0, 3)) {
            case 'MEM':
                $data['tabel'] = "member";
                break;
            case 'SUP':
                $data['tabel'] = "supplier";
                break;
            case 'RES':
                $data['tabel'] = "reseller";
                break;
            case 'ORD':
                $data['tabel'] = "order";
                break;

            default:
                # code...
                break;
        }
        $data['dataTampunganRole'] = $this->_cek_hak_akses();

        $this->load->view("admin/print_qrcode", $data);

        $size = array(0, 0, 260, 260);
        $orientasi = 'potrait';
        $this->pdf->atch = array("Attachment" => FALSE);
        $this->pdf->filename = "QrCode - " . $data['tabel'] . " - " . $data['a'] . ".pdf";
        $this->pdf->custom('admin/print_qrcode', $size, $orientasi, $data);
    }
}
