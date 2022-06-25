<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (empty($this->session->userdata('kd_role'))) {
            $this->session->set_flashdata('error', 'Anda Belum Login, Login Terlebih Dahulu!');
            redirect('admin');
        }
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
        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['judul'] = "Halaman Kategori Aktif";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/kategori/list_kategori', $data);
        $this->load->view('base/footer');
    }

    public function kategori_nonAktif()
    {
        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['judul'] = "Halaman Kategori Tidak Aktif";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/kategori/list_kategori_nonAktif', $data);
        $this->load->view('base/footer');
    }

    public function excel_kategori()
    {
        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['judul'] = "Halaman Upload Excel Kategori";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/kategori/excel_kategori', $data);
        $this->load->view('base/footer');
    }

    public function getKodeOtomatis($kode = null, $tabel = null)
    {
        $this->db->select('*');
        $this->db->from("$tabel");
        $query = $this->db->get_compiled_select();
        $sql = $this->db->query($query . " where LEFT(kd_$tabel, 3) = '$kode' ORDER BY kd_$tabel DESC ")->result_array();

        $kode = $kode;

        if ($sql != Null) {
            $pisah = explode("-", $sql[0]["kd_" . $tabel]);

            $number =  (int) $pisah[1];
            $digit = intval($number) + 1;

            if ($digit >= 1 and $digit <= 9) {
                $a = $kode . "-00" . $digit;
            } else if ($digit >= 10 and $digit <= 99) {
                $a = $kode . "-0" . $digit;
            } else {
                $a = $kode . "-" . $digit;
            }
        } else {
            $kodedefault = $kode . "-001";
            $a = $kodedefault;
        }

        return $a;
    }

    // Kategori

    public function get_kategori()
    {

        $this->datatables->select('kd_kategori, nm_kategori');
        $this->datatables->from('kategori');
        $this->db->order_by('created_at', 'DESC');
        $this->datatables->add_column(
            'aksi',
            '<span data-toggle="tooltip" data-placement="top" title="Edit Kategori"><a href="javascript:void(0);" class="edit_record btn btn-sm btn-primary" data-id="$1" data-backdrop="static" data-keyboard="false">
                <i class="fas fa-edit"></i> </a> </span>
                <span data-toggle="tooltip" data-placement="top" title="Hapus Kategori"><a href="javascript:void(0);" class="hapus_record btn btn-sm btn-danger" data-id="$1" data-backdrop="static" data-keyboard="false">
                <i class="fas fa-trash"></i> </a>',
            'kd_kategori'
        );
        return print_r($this->datatables->generate());
    }
    public function add_kategori()
    {
        $kodeOtomatis = $this->getKodeOtomatis("KAT", "kategori");
        $data = [
            'kd_kategori' => $kodeOtomatis,
            'nm_kategori' => ucwords($this->input->post('nm_kategori')),
            'created_at_admin' => $this->session->userdata('kd_admin'),
            'updated_at_admin' => $this->session->userdata('kd_admin'),
        ];

        $data = $this->db->insert('kategori', $data);
        if ($this->db->affected_rows() > 0) {
            $data = toast('success', 'Berhasil Tambah Data Kategori!');
        } else {
            $data = toast('error', 'Gagal Tambah Data Kategori!');
        }
        echo json_encode($data);
    }

    public function getKategoriById()
    {
        $id = $this->input->post('kd_kategori');

        $data = $this->db->get_where('kategori', ['kd_kategori' => $id])->row_array();

        $this->session->set_userdata("kd_kategori", $id);

        echo json_encode($data);
    }

    public function edit_kategori()
    {
        $where = ['kd_kategori' => $this->session->userdata('kd_kategori')];
        $data = [
            'nm_kategori'       => ucwords($this->input->post('nm_kategori')),
            'updated_at_admin'  => $this->session->userdata('kd_admin'),
            'updated_at'        => date('Y-m-d H:i:s', time()),
        ];

        $data = $this->db->update('kategori', $data, $where);
        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Berhasil Edit Data Kategori!');
        } else {
            $data = toast('error', 'Gagal Edit Data Kategori!');
        }


        $this->session->unset_userdata('kd_kategori');

        echo json_encode($data);
    }

    public function delete_kategori()
    {
        $where = ['kd_kategori' => $this->session->userdata('kd_kategori')];

        $data = $this->db->delete('kategori', $where);
        if ($this->db->affected_rows() > 0) {
            $data = toast('success', 'Berhasil Delete Data Kategori!');
        } else {
            $data = toast('error', 'Gagal Delete Data Kategori!');
        }

        $this->session->unset_userdata('kd_kategori');

        echo json_encode($data);
    }

    // end kategori

    // Sub Kategori

    public function sub_kategori()
    {

        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['subkategori'] = $this->db->get("kategori")->result();
        $data['judul'] = "Halaman Sub Kategori Aktif";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/kategori/list_sub_kategori', $data);
        $this->load->view('base/footer');
    }

    public function sub_kategori_nonAktif()
    {

        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['subkategori'] = $this->db->get("kategori")->result();
        $data['judul'] = "Halaman Sub Kategori Tidak Aktif";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/kategori/list_sub_kategori_nonAktif', $data);
        $this->load->view('base/footer');
    }

    public function get_sub_kategori($a)
    {
        $this->datatables->select('sub_kategori.kd_sub_kategori, sub_kategori.nm_sub_kategori, kategori.nm_kategori');
        $this->datatables->from('sub_kategori');
        $this->datatables->join('kategori', 'sub_kategori.kd_kategori=kategori.kd_kategori');

        $this->db->order_by('sub_kategori.created_at', 'DESC');

        $this->datatables->add_column(
            'aksi',
            '<span data-toggle="tooltip" data-placement="top" title="Edit Sub Kategori"><a href="javascript:void(0);" class="edit_record btn btn-sm btn-primary" data-id="$1">
             <i class="fas fa-edit"></i> </a> </span>
             <span data-toggle="tooltip" data-placement="top" title="Hapus Sub Kategori"><a href="javascript:void(0);" class="hapus_record btn btn-sm btn-danger" data-id="$1">
             <i class="fas fa-trash"></i> </a> </span>',
            'kd_sub_kategori'
        );
        return print_r($this->datatables->generate());
    }

    public function add_sub_kategori()
    {
        $kodeOtomatis = $this->getKodeOtomatis("KSB", "sub_kategori");
        $data = [
            'kd_sub_kategori' => $kodeOtomatis,
            'kd_kategori' => $this->input->post('kategori'),
            'nm_sub_kategori' => ucwords($this->input->post('nm_sub_kategori')),
            'created_at_admin' => $this->session->userdata('kd_admin'),
            'updated_at_admin' => $this->session->userdata('kd_admin'),
        ];

        $data = $this->db->insert('sub_kategori', $data);
        if ($this->db->affected_rows() > 0) {
            $data = toast('success', 'Berhasil Tambah Data Sub Kategori!');
        } else {
            $data = toast('error', 'Gagal Tambah Data Sub Kategori!');
        }
        echo json_encode($data);
    }

    public function getSubKategoriById()
    {
        $id = $this->input->post('kd_sub_kategori');

        $data = $this->db->get_where('sub_kategori', ['kd_sub_kategori' => $id])->row_array();

        $this->session->set_userdata('kd_sub_kategori', $id);

        echo json_encode($data);
    }

    public function edit_sub_kategori()
    {
        $where = ['kd_sub_kategori' => $this->session->userdata('kd_sub_kategori')];
        $data = [
            'kd_kategori'           => $this->input->post('kategori'),
            'nm_sub_kategori'       => ucwords($this->input->post('nm_sub_kategori')),
            'updated_at_admin'      => $this->session->userdata('kd_admin'),
            'updated_at'            => date('Y-m-d H:i:s', time()),
        ];

        $data = $this->db->update('sub_kategori', $data, $where);
        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Berhasil Edit Data Sub Kategori!');
        } else {
            $data = toast('error', 'Gagal Edit Data Sub Kategori!');
        }

        $this->session->unset_userdata('kd_sub_kategori');

        echo json_encode($data);
    }

    public function delete_sub_kategori()
    {
        $data = $this->db->delete('sub_kategori', ['kd_sub_kategori' => $this->session->userdata('kd_sub_kategori')]);
        if ($this->db->affected_rows() > 0) {
            $data = toast('success', 'Berhasil Delete Data Sub Kategori!');
        } else {
            $data = toast('error', 'Gagal Delete Data Sub Kategori!');
        }

        $this->session->unset_userdata('kd_sub_kategori');

        echo json_encode($data);
    }

    public function excel_sub_kategori()
    {
        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['judul'] = "Halaman Upload Excel Kategori";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/kategori/excel_sub_kategori', $data);
        $this->load->view('base/footer');
    }

    public function preview_sub_kategori()
    {
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $config['upload_path']        = './assets/excel/';
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size'] = '10000';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {

            //upload gagal
            $this->session->set_flashdata('error', 'Proses Import Data Sub Kategori Gagal!');
            //redirect halaman
            redirect('kategori/excel_sub_kategori');
        } else {
            $data_upload = $this->upload->data();

            $file = $this->upload->data('full_path');

            $excelreader     = new PHPExcel_Reader_Excel2007();
            $loadexcel         = $excelreader->load($file); // Load file yang telah diupload ke folder excel
            $sheet             = $loadexcel->getActiveSheet()->toArray();

            $data = [];
            for ($i = 1; $i < count($sheet); $i++) {
                if ($sheet[$i][0] != null) {
                    $data[] = [
                        'nm_sub_kategori' => $sheet[$i][0]
                    ];
                }
            }

            unlink($file);

            $this->upload_excel_sub_kategori($data);
        }
    }

    public function upload_excel_sub_kategori($import_data = null)
    {
        $data['judul'] = "Halaman Upload Excel Kategori";
        $data['dataTampunganRole'] = $this->_cek_hak_akses();

        if ($import_data != null) $data['import'] = $import_data;

        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/kategori/excel_sub_kategori', $data);
        $this->load->view('base/footer');
    }

    public function upload_excel_act_sub_kategori()
    {
        $input = json_decode($this->input->post('data', true));
        $kd_kategori = $this->input->post('kd_kategori');

        for ($i = 0; $i < count($input); $i++) {
            $data = [
                'kd_sub_kategori'       => $this->getKodeOtomatis("KSB", "sub_kategori"),
                'kd_kategori'           => $kd_kategori[$i],
                'nm_sub_kategori'       => ucwords($input[$i]->nm_sub_kategori),
                'created_at_admin'      => $this->session->userdata('kd_admin'),
                'updated_at_admin'      => $this->session->userdata('kd_admin'),
            ];

            $this->db->insert('sub_kategori', $data);
        }

        // unlink(realpath('excel/' . $data_upload['file_name']));

        //upload success
        $this->session->set_flashdata('flash', 'Proses Import Data Sub Kategori Berhasil!');
        //redirect halaman
        redirect('kategori/sub_kategori/');
    }

    // End Sub Kategori

    public function get_json()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->ModelKategori->getKategorijson($searchTerm);

        echo json_encode($response);
    }

    public function get_json_sub()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');
        $kd_kategori = $this->input->post('kd_kategori');

        // Get users
        $response = $this->ModelKategori->getSubKategorijson($searchTerm, $kd_kategori);

        echo json_encode($response);
    }

    public function get_json_multi_sub_kategori()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');
        $kategori = $this->input->post('kategori');

        // Get users
        $response = $this->ModelKategori->getmultisubkategorijson($searchTerm, $kategori);

        echo json_encode($response);
    }
}
