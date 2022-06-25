<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Custom extends CI_Controller
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
        $data['judul'] = "Halaman custom Aktif";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/custom/list_custom', $data);
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

    // custom

    public function get_custom()
    {

        $this->datatables->select('kd_custom, nm_custom, harga_custom, jenis_custom');
        $this->datatables->from('custom');
        $this->db->order_by('created_at', 'DESC');
        $this->datatables->add_column(
            'aksi',
            '<span data-toggle="tooltip" data-placement="top" title="Edit custom"><a href="javascript:void(0);" class="edit_record btn btn-sm btn-primary" data-id="$1" data-backdrop="static" data-keyboard="false">
                <i class="fas fa-edit"></i> </a> </span>
                <span data-toggle="tooltip" data-placement="top" title="Hapus custom"><a href="javascript:void(0);" class="hapus_record btn btn-sm btn-danger" data-id="$1" data-backdrop="static" data-keyboard="false">
                <i class="fas fa-trash"></i> </a>',
            'kd_custom'
        );
        return print_r($this->datatables->generate());
    }
    public function add_custom()
    {
        $data = [
            'nm_custom' => ucwords($this->input->post('nm_custom')),
            'harga_custom' => $this->input->post('harga_custom'),
            'jenis_custom' => $this->input->post('jenis_custom'),
        ];

        $data = $this->db->insert('custom', $data);
        if ($this->db->affected_rows() > 0) {
            $data = toast('success', 'Berhasil Tambah Data custom!');
        } else {
            $data = toast('error', 'Gagal Tambah Data custom!');
        }
        echo json_encode($data);
    }

    public function getcustomById()
    {
        $id = $this->input->post('kd_custom');

        $data = $this->db->get_where('custom', ['kd_custom' => $id])->row_array();

        $this->session->set_userdata("kd_custom", $id);

        echo json_encode($data);
    }

    public function edit_custom()
    {
        $where = ['kd_custom' => $this->session->userdata('kd_custom')];
        $data = [
            'nm_custom'       => ucwords($this->input->post('nm_custom')),
            'harga_custom' => $this->input->post('harga_custom'),
            'jenis_custom' => $this->input->post('jenis_custom'),
        ];

        $data = $this->db->update('custom', $data, $where);
        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Berhasil Edit Data custom!');
        } else {
            $data = toast('error', 'Gagal Edit Data custom!');
        }


        $this->session->unset_userdata('kd_custom');

        echo json_encode($data);
    }

    public function delete_custom()
    {
        $where = ['kd_custom' => $this->session->userdata('kd_custom')];

        $data = $this->db->delete('custom', $where);
        if ($this->db->affected_rows() > 0) {
            $data = toast('success', 'Berhasil Delete Data custom!');
        } else {
            $data = toast('error', 'Gagal Delete Data custom!');
        }

        $this->session->unset_userdata('kd_custom');

        echo json_encode($data);
    }

    public function get_json()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->Modelcustom->getcustomjson($searchTerm);

        echo json_encode($response);
    }

    public function get_json_sub()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');
        $kd_custom = $this->input->post('kd_custom');

        // Get users
        $response = $this->Modelcustom->getSubcustomjson($searchTerm, $kd_custom);

        echo json_encode($response);
    }

    public function get_json_multi_sub_custom()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');
        $custom = $this->input->post('custom');

        // Get users
        $response = $this->Modelcustom->getmultisubcustomjson($searchTerm, $custom);

        echo json_encode($response);
    }
}
