<?php
class Konfigurasi extends  CI_Controller
{
    public function __construct()
    {
        parent::__construct();
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

    public function index()
    {
        $data['judul'] = "Halaman Konfigurasi";
        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['konfigurasi'] = $this->db->get('konfigurasi')->row_array();
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/konfigurasi/index', $data);
        $this->load->view('base/footer');
    }

    public function process()
    {
        $kd_konfigurasi = $this->input->post('kd_konfigurasi');
        $data = [
            'nama_toko' => $this->input->post('nama_toko'),
            'no_hp' => $this->input->post('no_hp'),
            'email' => $this->input->post('email'),
            'facebook' => $this->input->post('facebook'),
            'twitter' => $this->input->post('twitter'),
            'instagram' => $this->input->post('instagram'),
            'created_at_admin' => $this->session->userdata('kd_admin'),
            'updated_at_admin' => $this->session->userdata('kd_admin')
        ];

        if (empty($kd_konfigurasi)) {
            $this->db->insert('konfigurasi', $data);
            $this->session->set_flashdata('flash', 'Berhasil Ditambah');
        } else {
            $this->db->update('konfigurasi', $data, ['kd_konfigurasi' => $kd_konfigurasi]);
            $this->session->set_flashdata('flash', 'Berhasil Diubah');
        }
        redirect(base_url('konfigurasi'));
    }

    public function getKonfigurasi()
    {
        $data = $this->db->get('konfigurasi')->row_array();
        echo json_encode($data);
    }

    public function backup()
    {
        $this->load->dbutil();
        $this->load->helper('file');

        $file_path = 'backup/backup-' . date('ymd') . '.zip';
        if (file_exists($file_path)) {
            unlink(FCPATH . 'backup/backup-' . date('ymd') . '.zip');

            $prefs = array(
                'format'        => 'zip',                       // gzip, zip, txt
                'filename'      => 'backup-' . date('ymd') . '.sql',              // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
                'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
                'newline'       => "\n"                         // Newline character used in backup file
            );

            $backup = $this->dbutil->backup($prefs);

            // Load the file helper and write the file to your server
            $this->load->helper('file');
            $save = FCPATH . 'backup/backup-' . date("ymd") . '.zip';
            write_file($save, $backup);
        } else {
            $hr = date('ymd');
            $kemarin = date('ymd', (strtotime('-1 day', strtotime($hr))));
            $file_path_kemarin = 'backup/backup-' . $kemarin . '.zip';

            if (file_exists($file_path_kemarin)) {
                unlink(FCPATH . 'backup/backup-' . $kemarin . '.zip');
                $prefs = array(
                    'format'        => 'zip',                       // gzip, zip, txt
                    'filename'      => 'backup-' . date('ymd') . '.sql',              // File name - NEEDED ONLY WITH ZIP FILES
                    'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
                    'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
                    'newline'       => "\n"                         // Newline character used in backup file
                );

                $backup = $this->dbutil->backup($prefs);
                $this->load->helper('file');
                $save = FCPATH . 'backup/backup-' . date("ymd") . '.zip';
                write_file($save, $backup);
            } else {
                $prefs = array(
                    'format'        => 'zip',                       // gzip, zip, txt
                    'filename'      => 'backup-' . date('ymd') . '.sql',              // File name - NEEDED ONLY WITH ZIP FILES
                    'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
                    'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
                    'newline'       => "\n"                         // Newline character used in backup file
                );

                $backup = $this->dbutil->backup($prefs);
                $this->load->helper('file');
                $save = FCPATH . 'backup/backup-' . date("ymd") . '.zip';
                write_file($save, $backup);
            }
        }
        // Load the download helper and send the file to your desktop
        // $this->load->helper('download');
        // force_download('backup-' . date('ymdHis') . '-db.zip', $backup);
    }

    public function rekening()
    {
        $data['judul'] = "Halaman Kelola Rekening";
        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['logo'] = $this->db->get('logo');

        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/konfigurasi/rekening', $data);
        $this->load->view('base/footer');
    }

    public function get_contact()
    {
        $this->datatables->select('kd_rekening, nama_bank, nomor_rekening');
        $this->datatables->from('rekening');
        $this->db->order_by('created_at', 'DESC');
        $this->datatables->add_column(
            'aksi',
            '<span data-toggle="tooltip" data-placement="top" title="Edit Kategori"><a href="javascript:void(0);" class="edit_record btn btn-sm btn-primary" data-id="$1" data-backdrop="static" data-keyboard="false">
                <i class="fas fa-edit"></i> </a> </span>
                <span data-toggle="tooltip" data-placement="top" title="Hapus Kategori"><a href="javascript:void(0);" class="hapus_record btn btn-sm btn-danger" data-id="$1" data-backdrop="static" data-keyboard="false">
                <i class="fas fa-trash"></i> </a>',
            'kd_rekening'
        );
        return print_r($this->datatables->generate());
    }

    public function add_contact_selera()
    {
        $data = [
            'nama_bank' => $this->input->post('nama_bank'),
            'atas_nama' => $this->input->post('atas_nama'),
            'nomor_rekening' => $this->input->post('nomor_rekening'),
            'created_at_admin' => $this->session->userdata('kd_admin'),
            'updated_at_admin' => $this->session->userdata('kd_admin'),
        ];

        $this->db->insert('rekening', $data);

        if ($this->db->affected_rows() > 0) {
            $data = toast('success', 'Berhasil Tambah Data Rekening!');
        } else {
            $data = toast('error', 'Gagal Tambah Data Rekening!');
        }
        echo json_encode($data);
    }

    public function getContactById()
    {
        $id = $this->input->post('kd_rekening');

        $data = $this->db->get_where('rekening', ['kd_rekening' => $id])->row_array();

        $this->session->set_userdata("kd_rekening", $id);

        echo json_encode($data);
    }

    public function edit_contact_selera()
    {
        $data = [
            'nama_bank' => $this->input->post('nama_bank'),
            'atas_nama' => $this->input->post('atas_nama'),
            'nomor_rekening' => $this->input->post('nomor_rekening'),
            'updated_at_admin'  => $this->session->userdata('kd_admin'),
            'updated_at'        => date('Y-m-d H:i:s', time()),
        ];

        $this->db->update('rekening', $data, ['kd_rekening' => $this->session->userdata('kd_rekening')]);

        $this->session->unset_userdata('kd_rekening');

        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Berhasil Tambah Edit Rekening!');
        } else {
            $data = toast('error', 'Gagal Tambah Edit Rekening!');
        }
        echo json_encode($data);
    }

    public function delete_contact_selera()
    {
        $this->db->delete('rekening', ['kd_rekening' => $this->session->userdata('kd_rekening')]);

        $this->session->unset_userdata('kd_rekening');

        if ($this->db->affected_rows() > 0) {
            $data = toast('success', 'Berhasil Tambah Delete Rekening!');
        } else {
            $data = toast('error', 'Gagal Tambah Delete Rekening!');
        }

        echo json_encode($data);
    }

    public function logo()
    {
        $data['judul'] = "Halaman Kelola Logo Aplikasi";
        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['logo'] = $this->db->get('logo');

        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/konfigurasi/kelola_logo', $data);
        $this->load->view('base/footer');
    }

    public function ganti_logo_website()
    {
        $upload_image = $_FILES['gallery']['name'];
        $kd_logo = $this->input->post('kd_logo');

        if ($upload_image) {
            $config['image_library'] = 'gd2';
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/images/logo_website/';

            $this->load->library('upload', $config);

            $data = $this->db->get_where('logo', ['kd_logo' => $kd_logo]);

            if ($this->upload->do_upload('gallery')) {
                $data_logo = $data->row_array();

                $gbr = $this->upload->data();

                $configi['image_library'] = 'gd2';
                $configi['source_image']   = './assets/images/logo_website/' . $gbr['file_name'];
                $configi['maintain_ratio'] = FALSE;
                $configi['width']  = 500;
                $configi['quality'] = '60%';
                $configi['height'] = 250;
                $config['new_image'] = './assets/images/logo_website/' . $gbr['file_name'];

                $this->load->library('image_lib');
                $this->image_lib->initialize($configi);
                $this->image_lib->resize();


                $new_image = $this->upload->data('file_name');
                if ($data->num_rows() > 0) {
                    $old_image = $data_logo['nm_logo'];
                    if ($old_image != 'default.svg') {
                        unlink(FCPATH . '/assets/images/logo_website/' . $old_image);
                    }
                    $this->db->set('nm_logo', $new_image);
                    $this->db->where(['kd_logo' => $kd_logo]);
                    $this->db->update('logo');
                } else {
                    $this->db->insert('logo', ['nm_logo' => $new_image]);
                }
            } else {
                echo $this->upload->display_errors();
            }
        }

        if ($this->db->affected_rows() > 0) {
            $data = ['logo' => $new_image, 'message' => toast('success', 'Berhasil Edit Logo Selera!')];
        } else {
            $data = ['message' => toast('error', 'Gagal Edit Logo Selera!')];
        }
        echo json_encode($data);
    }

    public function slider()
    {
        $data['judul'] = "Halaman Kelola Slider Aplikasi";
        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['slider'] = $this->db->get('slider');

        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/konfigurasi/kelola_slider', $data);
        $this->load->view('base/footer');
    }

    public function upload_slider()
    {
        $upload_image = $_FILES['gambarfoto']['name'];

        if ($upload_image) {
            $config['allowed_types'] = 'gif|jpg|jpeg|png|svg';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/images/slider/';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('gambarfoto')) {

                $gbr = $this->upload->data();

                $configi['image_library'] = 'gd2';
                $configi['source_image']   = './assets/images/slider/' . $gbr['file_name'];
                $configi['maintain_ratio'] = FALSE;
                $configi['width']  = 1000;
                $configi['height'] = 391;
                $config['new_image'] = './assets/images/slider/' . $gbr['file_name'];

                $this->load->library('image_lib');
                $this->image_lib->initialize($configi);
                $this->image_lib->resize();

                $new_image = $this->upload->data('file_name');

                $data = [
                    'nm_slider' => $new_image,
                    'created_at_admin' => $this->session->userdata('kd_admin')
                ];

                $this->db->insert('slider', $data);
                $this->session->set_flashdata('flash', 'Berhasil Tambah Slider');
                redirect(base_url('konfigurasi/slider'));
            } else {
                $this->session->set_flashdata('error', 'Foto Tidak Berhasil Di Upload');
                redirect(base_url('konfigurasi/slider'));
            }
        } else {
            $this->session->set_flashdata('error', 'Foto Tidak Berhasil Di Upload');
            redirect(base_url('konfigurasi/slider'));
        }
    }

    public function slider_hapus($kd)
    {
        $data = $this->db->get_where('slider', ['kd_slider' => $kd])->row_array();
        $old_image = $data['nm_slider'];
        unlink(FCPATH . '/assets/images/slider/' . $old_image);

        $this->db->delete('slider', ['kd_slider' => $kd]);

        $this->session->set_flashdata('flash', 'Berhasil Hapus Slider');
        redirect(base_url('konfigurasi/slider'));
    }

    public function contact()
    {
        $data['judul'] = "Halaman Saran dan Masukkan";
        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['saranmasukkan'] = $this->db->get('masukkansaran')->result_array();

        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/konfigurasi/saranmasukkan', $data);
        $this->load->view('base/footer');
    }
}
