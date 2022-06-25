<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Member extends CI_Controller
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

        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['judul'] = "Halaman Member";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/member/list_member_aktif', $data);
        $this->load->view('base/footer');
    }

    public function countmembernonaktif()
    {
        $data = $this->db->get_where('member', ['is_member_aktif' => '0', 'is_member_hapus' => '1'])->num_rows();

        echo json_encode($data);
    }

    public function getKecamatan()
    {
        $kd = $this->input->post('kd_kecamatan');
        $data = $this->db->get_where('kecamatan', ['id' => $kd])->row_array();

        echo json_encode($data);
    }

    public function member_nonAktif()
    {

        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['judul'] = "Halaman Member";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/member/list_member_nonAktif', $data);
        $this->load->view('base/footer');
    }

    public function get_member($a)
    {
        $key = kunci();
        $this->datatables->select("kd_member, nm_member, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp, CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email, jenis_kelamin");
        $this->datatables->from('member');
        $this->datatables->where(['is_member_hapus' => 1, 'is_member_aktif' => $a]);
        $this->db->order_by("created_at", "DESC");
        $this->datatables->add_column(
            'aksi',
            '<span data-toggle="tooltip" data-placement="top" title="Edit Member"><a href="javascript:void(0);" class="edit_record btn btn-sm btn-primary" data-id="$1" data-toggle="modal" data-target="#editModal">
                <i class="fas fa-edit"></i> </a> </span>
                <span data-toggle="tooltip" data-placement="top" title="Reset Password"><a href="javascript:void(0);" class="rst_pass btn btn-sm btn-info" data-id="$1" data-toggle="modal" data-target="#shapusModal">
                <i class="fas fa-unlock-alt"></i> </a> </span>
                <span data-toggle="tooltip" data-placement="top" title="Hapus Member"><a href="javascript:void(0);" class="hapus_record btn btn-sm btn-danger" data-id="$1" data-toggle="modal" data-target="#hapusModal">
                <i class="fas fa-trash"></i> </a> </span>',
            'kd_member'
        );
        return print_r($this->datatables->generate());
    }

    public function get_search_member()
    {
        $searchTerm = $this->input->post('key');

        if (substr($searchTerm, 0, 1) == "0") {
            $searchTerm = replace_phone_number($searchTerm);
        }

        $a = $this->input->post('no');
        $key = kunci();
        $this->datatables->select("kd_member, nm_member, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp, CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email, jenis_kelamin");
        $this->datatables->from('member');
        $this->datatables->where(['is_member_hapus' => 1, 'is_member_aktif' => $a]);
        $this->db->having("nm_member LIKE '%$searchTerm%' ");
        $this->db->or_having("no_telp LIKE '%$searchTerm%' ");
        $this->db->order_by("created_at", "DESC");
        $this->datatables->add_column(
            'aksi',
            '<span data-toggle="tooltip" data-placement="top" title="Edit Member"><a href="javascript:void(0);" class="edit_record btn btn-sm btn-primary" data-id="$1" data-toggle="modal" data-target="#editModal">
                <i class="fas fa-edit"></i> </a> </span>
                <span data-toggle="tooltip" data-placement="top" title="Reset Password"><a href="javascript:void(0);" class="rst_pass btn btn-sm btn-info" data-id="$1" data-toggle="modal" data-target="#shapusModal">
                <i class="fas fa-unlock-alt"></i> </a> </span>
                <span data-toggle="tooltip" data-placement="top" title="Hapus Member"><a href="javascript:void(0);" class="hapus_record btn btn-sm btn-danger" data-id="$1" data-toggle="modal" data-target="#hapusModal">
                <i class="fas fa-trash"></i> </a> </span>',
            'kd_member'
        );
        return print_r($this->datatables->generate());
    }

    public function getKodeOtomatis($kode = null, $tabel = null)
    {
        $this->db->select('*');
        $this->db->from("$tabel");
        $query = $this->db->get_compiled_select();
        $sql = $this->db->query($query . " where LEFT(kd_$tabel, " . strlen($kode) . ") = '$kode' ORDER BY kd_$tabel DESC ")->row_array();
        $kode = $kode;
        $tahun = date('y', time());
        $bulan = date('m', time());

        if ($sql != Null && substr($sql['kd_member'], -7, 2) == $tahun) {

            $number = (int) substr($sql['kd_member'], -5);
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

        return $a;
    }

    public function add_member()
    {

        $kd_member = $this->getKodeOtomatis("MBR", "member");
        $nohp = $this->input->post('no_telp');
        $hp = replace_phone_number($nohp);

        $nm_member = ucwords($this->input->post('nm_member'));
        $email = $this->input->post('email');
        $kodepos = $this->input->post('kode_pos');
        $alamat = $this->input->post('alamat');
        $username = $hp;

        $key = kunci();

        $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email");
        $this->db->from("member");
        $this->db->where(['member.is_member_aktif' => '1', 'member.is_member_hapus' => '1']);
        $this->db->having("no_telp = '$hp' ");
        $this->db->group_by("member.kd_member", "ASC");
        $no_hp = $this->db->get()->row_array();

        if ($no_hp) {
            $data = toast('error', 'Nomor HP Sudah Terdaftar!');
            echo json_encode($data);
            die;
        }

        if ($email != "") {
            $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email");
            $this->db->from("member");
            $this->db->where(['member.is_member_aktif' => '1', 'member.is_member_hapus' => '1']);
            $this->db->having("email = '$email' ");
            $this->db->group_by("member.kd_member", "ASC");
            $emaill = $this->db->get()->row_array();

            if ($emaill) {
                $data = toast('error', 'Email Sudah Terdaftar!');
                echo json_encode($data);
                die;
            }
        }

        $this->db->set('kd_member', $kd_member);
        $this->db->set('kd_subdistricts', $this->input->post('pilihankecamatan'));
        $this->db->set('alamat', encrypt($alamat));
        $this->db->set('jenis_kelamin', $this->input->post('jk'));
        $this->db->set('nm_member', $nm_member);

        $this->db->escape($hp);
        $this->db->set('no_telp', "AES_ENCRYPT('{$hp}','{$key}')", FALSE);
        $this->db->escape($email);
        $this->db->set('email', "AES_ENCRYPT('{$email}','{$key}')", FALSE);
        $this->db->escape($kodepos);
        $this->db->set('kodepos', "AES_ENCRYPT('{$kodepos}','{$key}')", FALSE);
        $this->db->escape($username);
        $this->db->set('username', "AES_ENCRYPT('{$username}','{$key}')", FALSE);

        $this->db->set('password', encrypt("cateringkita"));
        $this->db->set('created_at_admin', $this->session->userdata('kd_admin'));
        $this->db->set('updated_at_admin', $this->session->userdata('kd_admin'));

        $this->db->insert('member');

        $cek_user_role = $this->db->get_where('user_role', ['kd_user' => $kd_member, 'kd_role' => 3])->num_rows();
        if ($cek_user_role == 0) {
            $dataUserRole = [
                'kd_user' => $kd_member,
                'kd_role' => '3'
            ];

            $this->db->insert('user_role', $dataUserRole);
        }

        $checkboxsosmed = $this->input->post('checkboxsosmed');
        if ($checkboxsosmed == "on") {
            $dataSocmed = [
                'kd_member' => $kd_member,
                'instagram' => $this->input->post('instagram'),
                'facebook' => $this->input->post('facebook'),
                'twitter' => $this->input->post('twitter'),
            ];

            $this->db->insert('detail_sosmed', $dataSocmed);
        }

        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Berhasil Tambah Data Member!');
        } else {
            $data = toast('error', 'Gagal Tambah Data Member!');
        }
        echo json_encode($data);
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

        $this->session->set_userdata("kd_member", $id);

        echo json_encode($data);
    }

    public function getMemberKecById()
    {
        $key = kunci();
        // ini didapet pada saat scan barcode. ada di footer.php function scanDataQrCode
        $id = $this->input->post('tujuan');

        if ($id == null) {
            $id = $this->input->post('kd_member');
            $where = ['member.kd_member' => $id];
        } else {
            $where = ['member.qr_member' => $id];
        }

        $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email");
        $this->db->from('member');
        $this->db->join("detail_sosmed", "member.kd_member=detail_sosmed.kd_member");
        $this->db->join("kecamatan", "member.kd_subdistricts=kecamatan.id");
        $this->db->where($where);
        $data = $this->db->get()->row_array();

        if ($data == null) {
            $this->db->select("*, CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email");
            $this->db->from('member');
            $this->db->join("kecamatan", "member.kd_subdistricts=kecamatan.id");
            $this->db->where($where);
            $data = $this->db->get()->row_array();
        }

        echo json_encode($data);
    }

    public function edit_member()
    {

        $nohp = $this->input->post('no_telp');
        $hp = replace_phone_number($nohp);

        $kd_member = $this->session->userdata('kd_member');
        $nm_member = ucwords($this->input->post('nm_member'));
        $email = $this->input->post('email');
        $kodepos = $this->input->post('kode_pos');
        $alamat = $this->input->post('alamat');
        $username = $hp;

        $key = kunci();

        $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email");
        $this->db->from("member");
        $this->db->where(['member.is_member_aktif' => '1', 'member.is_member_hapus' => '1']);
        $this->db->having("no_telp = '$hp' ");
        $this->db->group_by("member.kd_member", "ASC");
        $no_hp = $this->db->get()->row_array();

        // if ($no_hp) {
        //     if ($no_hp['no_telp'] == $hp && $no_hp['kd_member'] != $this->session->userdata('kd_member')) {
        //         $data = toast('error', 'Nomor HP Sudah Terdaftar!');
        //         echo json_encode($data);
        //         die;
        //     }
        // }

        if ($email != "") {
            $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email");
            $this->db->from("member");
            $this->db->where(['member.is_member_aktif' => '1', 'member.is_member_hapus' => '1']);
            $this->db->having("email = '$email' ");
            $this->db->group_by("member.kd_member", "ASC");
            $emaill = $this->db->get()->row_array();

            if ($emaill) {
                if ($emaill['email'] == $email && $emaill['kd_member'] != $this->session->userdata('kd_member')) {
                    $data = toast('error', 'Email Sudah Terdaftar!');
                    echo json_encode($data);
                    die;
                }
            }
        }

        $this->db->set('jenis_kelamin', $this->input->post('jk'));
        $this->db->set('kd_subdistricts', $this->input->post('pilihankecamatan'));
        $this->db->set('alamat', encrypt($alamat));
        $this->db->set('nm_member', $nm_member);

        $this->db->escape($hp);
        $this->db->set('no_telp', "AES_ENCRYPT('{$hp}','{$key}')", FALSE);
        $this->db->escape($email);
        $this->db->set('email', "AES_ENCRYPT('{$email}','{$key}')", FALSE);
        $this->db->escape($kodepos);
        $this->db->set('kodepos', "AES_ENCRYPT('{$kodepos}','{$key}')", FALSE);
        $this->db->escape($username);
        $this->db->set('username', "AES_ENCRYPT('{$username}','{$key}')", FALSE);

        $this->db->set('is_member_aktif', $this->input->post('status_member'));
        $this->db->set('updated_at_admin', $this->session->userdata('kd_admin'));
        $this->db->set('updated_at', date('Y-m-d H:i:s', time()));

        $this->db->where('kd_member', $kd_member);

        $this->db->update('member');

        $checkboxsosmed = $this->input->post('checkboxsosmed');
        $data = $this->db->get_where('detail_sosmed', ['kd_member' => $kd_member])->num_rows();

        if ($data > 0) {
            if ($checkboxsosmed == "on") {
                $dataSocmed = [
                    'instagram' => $this->input->post('instagram'),
                    'facebook' => $this->input->post('facebook'),
                    'twitter' => $this->input->post('twitter'),
                ];
            } else {
                $dataSocmed = [
                    'instagram' => null,
                    'facebook' => null,
                    'twitter' => null,
                ];
            }
            $this->db->update('detail_sosmed', $dataSocmed, ['kd_member' => $kd_member]);
        } else {
            if ($checkboxsosmed == "on") {
                $dataSocmed = [
                    'kd_member' => $this->input->post('kd_member'),
                    'instagram' => $this->input->post('instagram'),
                    'facebook' => $this->input->post('facebook'),
                    'twitter' => $this->input->post('twitter'),
                ];
                $this->db->insert('detail_sosmed', $dataSocmed);
            }
        }

        $this->session->unset_userdata('kd_member');

        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Berhasil Edit Data Member!');
        } else {
            $data = toast('error', 'Gagal Edit Data Member!');
        }
        echo json_encode($data);
    }

    public function delete_member()
    {

        $where = ['kd_member' => $this->session->userdata('kd_member')];

        $data = [
            'is_member_aktif' => 0,
            'is_member_hapus' => 0,
            'deleted_at_admin' => $this->session->userdata('kd_admin'),
            'deleted_at'        => date('Y-m-d H:i:s', time()),
        ];

        $data = $this->db->update('member', $data, $where);


        if ($this->db->affected_rows() > 0) {
            $data = toast('success', 'Berhasil Delete Data Member!');
        } else {
            $data = toast('error', 'Gagal Delete Data Member!');
        }
        echo json_encode($data);
    }

    public function reset_password_member()
    {

        $where = ['kd_member' => $this->session->userdata('kd_member')];

        $data = [
            'password' => encrypt("cateringkita"),
            'updated_at_admin' => $this->session->userdata('kd_admin'),
            'updated_at'        => date('Y-m-d H:i:s', time()),
        ];

        $data = $this->db->update('member', $data, $where);

        if ($this->db->affected_rows() > 0) {
            $data = toast('success', 'Berhasil Reset Password Member!');
        } else {
            $data = toast('error', 'Gagal Reset Password Member!');
        }
        echo json_encode($data);
    }

    public function get_json()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->ModelMember->getMemberjson($searchTerm);

        echo json_encode($response);
    }

    public function export_excel_member($a)
    {
        $key = kunci();
        $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(username, '$key') AS CHAR(50)) username");
        $this->db->from('member');
        $this->db->where(['is_member_aktif' => $a, 'is_member_hapus' => '1']);
        $member = $this->db->get()->result_array();
        $spreadsheet = new Spreadsheet;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B2', 'CATERING KITA')
            ->setCellValue('B3', 'DAFTAR Member')
            ->setCellValue('B5', 'Nomor')
            ->setCellValue('C5', 'Kode Member')
            ->setCellValue('D5', 'Nama Member')
            ->setCellValue('E5', 'Nomor Telepon')
            ->setCellValue('F5', 'email')
            ->setCellValue('G5', 'Username')
            ->setCellValue('H5', 'Jenis_kelamin')
            ->setCellValue('I5', 'Alamat');

        $kolom = 6;
        $nomor = 1;

        foreach ($member as $member) {

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('B' . $kolom, $nomor)
                ->setCellValue('C' . $kolom, $member['kd_member'])
                ->setCellValue('D' . $kolom, $member['nm_member'])
                ->setCellValue('E' . $kolom, $member['no_telp'])
                ->setCellValue('F' . $kolom, $member['email'])
                ->setCellValue('G' . $kolom, $member['username'])
                ->setCellValue('H' . $kolom, $member['jenis_kelamin'])
                ->setCellValue('I' . $kolom, strip_tags(decrypt($member['alamat'])));

            $kolom++;
            $nomor++;
        }
        $kolom++;

        $spreadsheet->getActiveSheet()->setTitle("All Member");

        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        if ($a = '1') {
            header('Content-Disposition: attachment;filename="Master Data Member Aktif "' . date('d-m-Y', time()) . '".xlsx"');
        } else {
            header('Content-Disposition: attachment;filename="Master Data Member Tidak Aktif"' . date('d-m-Y', time()) . '".xlsx"');
        }
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
