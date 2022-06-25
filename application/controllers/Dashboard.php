<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
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

        $data["$tabel"] = $this->db->get_where("$tabel", ["kd_$tabel" => $this->session->userdata("kd_$tabel")])->row_array();

        $this->db->select("*");
        $this->db->from("order");
        $data['order_harian'] = $this->db->get()->num_rows();

        $data['dataTampunganRole'] = $this->_cek_hak_akses();

        $data['judul'] = "Halaman Dashboard";

        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/dashboard', $data);
        $this->load->view('base/footer');
    }

    public function profile()
    {
        $key  = kunci();

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

        $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email");
        $this->db->from($tabel);

        $this->db->join('user_role', "$tabel.kd_$tabel=user_role.kd_user");

        $this->db->where(["$tabel.kd_$tabel" => $this->session->userdata("kd_$sess")]);
        $data['user'] = $this->db->get()->row_array();

        $this->session->set_userdata("kd_user", $this->session->userdata("kd_$sess"));

        $data['tabel'] = $tabel;
        $data['judul'] = "Edit Profile User";

        $this->load->view('base/header', $data);
        $this->load->view('base/navbar');
        $this->load->view('base/sidebar');
        $this->load->view('dashboard/edit', $data);
        $this->load->view('base/footer');
    }

    public function edit_user($no = null)
    {
        $upload_image = $_FILES['userfile']['name'];
        $key = kunci();
        $id = $this->session->userdata('kd_user');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $repassword = $this->input->post('retype_password');

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

        $this->db->select("*");
        $this->db->from($tabel);
        $this->db->join('user_role', "$tabel.kd_$tabel=user_role.kd_user");
        $this->db->where(["$tabel.kd_$tabel" => $this->session->userdata('kd_admin')]);
        $data['user'] = $this->db->get()->row_array();

        // $telp = strval($this->input->post('no_telp'));
        // $hp = replace_phone_number($telp);
        $nohp = $this->input->post('no_telp');
        $no = substr($nohp, 0, 1);
        if ($no == 0) {
            $hp = substr_replace($nohp, '62', 0, 1);
        } else {
            $hp = $this->input->post('no_telp');
        }

        $email = $this->input->post('email');

        if ($upload_image) { // variabel true
            $config['allowed_types'] = 'jpg|jpeg|png';
            // $config['max_size']     = '8192';
            $config['upload_path'] = './assets/images/user/';
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('userfile')) {
                $new_image = $this->upload->data('file_name');
                if ($password != null && $password == $repassword) {

                    $this->db->set("nm_$tabel", $this->input->post('nm_user'));
                    $this->db->set('password', encrypt($this->input->post('password')));
                    $this->db->set('image', $new_image);

                    if ($this->session->userdata('kd_reseller')) {
                        $this->db->escape($username);
                        $this->db->set('username', "AES_ENCRYPT('{$username}','{$key}')", FALSE);
                    } else {
                        $this->db->set('username', $username);
                    }

                    $this->db->escape($hp);
                    $this->db->set('no_telp', "AES_ENCRYPT('{$hp}','{$key}')", FALSE);
                    $this->db->escape($email);
                    $this->db->set('email', "AES_ENCRYPT('{$email}','{$key}')", FALSE);
                } else {
                    $this->db->set("nm_$tabel", $this->input->post('nm_user'));

                    if ($this->session->userdata('kd_reseller')) {
                        $this->db->escape($username);
                        $this->db->set('username', "AES_ENCRYPT('{$username}','{$key}')", FALSE);
                    } else {
                        $this->db->set('username', $username);
                    }

                    $this->db->set('image', $new_image);

                    $this->db->escape($hp);
                    $this->db->set('no_telp', "AES_ENCRYPT('{$hp}','{$key}')", FALSE);
                    $this->db->escape($email);
                    $this->db->set('email', "AES_ENCRYPT('{$email}','{$key}')", FALSE);
                }
            } else {
                $this->session->set_flashdata('error', 'Foto Tidak Berhasil Di Upload');
                redirect(base_url('dashboard/profile'));
            }
        } else {
            if ($password != null && $password == $repassword) {
                $this->db->set("nm_$tabel", $this->input->post('nm_user'));

                if ($this->session->userdata('kd_reseller')) {
                    $this->db->escape($username);
                    $this->db->set('username', "AES_ENCRYPT('{$username}','{$key}')", FALSE);
                } else {
                    $this->db->set('username', $username);
                }

                $this->db->set('password', encrypt($this->input->post('password')));

                $this->db->escape($hp);
                $this->db->set('no_telp', "AES_ENCRYPT('{$hp}','{$key}')", FALSE);
                $this->db->escape($email);
                $this->db->set('email', "AES_ENCRYPT('{$email}','{$key}')", FALSE);
            } else {
                $this->db->set("nm_$tabel", $this->input->post('nm_user'));

                if ($this->session->userdata('kd_reseller')) {
                    $this->db->escape($username);
                    $this->db->set('username', "AES_ENCRYPT('{$username}','{$key}')", FALSE);
                } else {
                    $this->db->set('username', $username);
                }

                $this->db->escape($hp);
                $this->db->set('no_telp', "AES_ENCRYPT('{$hp}','{$key}')", FALSE);
                $this->db->escape($email);
                $this->db->set('email', "AES_ENCRYPT('{$email}','{$key}')", FALSE);
            }
        }

        $this->db->where(["kd_$tabel" => $id]);
        $this->db->update("$tabel");
        $this->session->set_flashdata('flash', 'Berhasil Ubah Profile');

        $this->session->set_userdata("kd_anggota", $id);

        if ($no == null) {
            redirect(base_url('dashboard'));
        } else {
            redirect(base_url('dashboard/profile'));
        }
    }
}
