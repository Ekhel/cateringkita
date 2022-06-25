<?php
class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function konfirmasi_pembayaran()
    {

        $kd_order = $this->input->post('kd_order');

        $data = [
            'payment_status' => 1,
            'updated_at_admin'  => $this->session->userdata('kd_admin'),
            'updated_at'        => date('Y-m-d H:i:s', time()),
        ];

        $this->db->update('order', $data, ['kd_order' => $kd_order]);

        $data_nukti = [
            'status' => 1,
            'updated_at_admin'  => $this->session->userdata('kd_admin'),
            'updated_at'        => date('Y-m-d H:i:s', time()),
        ];

        $this->db->update('bukti_pembayaran', $data_nukti, ['kd_order' => $kd_order]);

        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Berhasil Konfirmasi Bukti Pembayaran!');
        } else {
            $data = toast('error', 'Gagal Konfirmasi Bukti Pembayaran!');
        }
        echo json_encode($data);
    }

    public function tolak_pembayaran()
    {
        $kd_order = $this->input->post('kd_order');

        $data = [
            'payment_status' => 0,
            'updated_at_admin'  => $this->session->userdata('kd_admin'),
            'updated_at'        => date('Y-m-d H:i:s', time()),
        ];

        $this->db->update('order', $data, ['kd_order' => $kd_order]);

        $this->db->delete('bukti_pembayaran', ['kd_order' => $kd_order]);

        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Berhasil Tolak Bukti Pembayaran!');
        } else {
            $data = toast('error', 'Gagal Tolak Bukti Pembayaran!');
        }
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

    public function list_pengiriman()
    {
        $this->load->view('admin/order/list_pengiriman');
    }

    public function list_order_reseller()
    {
        $this->load->view('reseller/list_notif_reseller');
    }

    public function read_pengiriman($kd)
    {
        $data = ['read_pengiriman' => 1];
        $where = ['kd_order' => $kd];

        $this->db->update('pengiriman', $data, $where);
        redirect('order/detail_pesanan_kurir/' . $kd);
    }

    public function list_order_pending()
    {
        $this->load->view('admin/order/list_order_pending');
    }

    public function list_order_pending_po()
    {
        $this->load->view('admin/order/list_order_pending_po');
    }

    public function list_order_proses()
    {
        $this->load->view('admin/order/list_order_proses');
    }

    public function list_order_proses_po()
    {
        $this->load->view('admin/order/list_order_proses_po');
    }

    public function list_notif_catetan()
    {
        $this->load->view('admin/order/list_notif_catatan');
    }

    public function list_notif_produk_kosong()
    {
        $this->load->view('admin/order/list_notif_produk_kosong');
    }

    public function list_notif_produk_blm_dibayar()
    {
        var_dump("sss");
        die;
        $this->load->view('admin/order/list_notif_produk_blm_dibayar');
    }

    public function read_order($kd)
    {
        $data = ['read_order' => 1];
        $where = ['kd_order' => $kd];

        $this->db->update('order', $data, $where);
        redirect('order/detail_pesanan/' . $kd);
    }

    public function read_temporary_order($kd)
    {
        $data = ['read_order' => 1];
        $where = ['kd_temporary_order' => $kd];

        $this->db->update('temporary_order', $data, $where);
        redirect('order/pesanan_nonmember/');
    }

    public function createQrCode($kode, $path)
    {
        $data['data'] = $kode;
        $data['size'] = 7;
        $data['savename'] = FCPATH . 'assets/images/qrcode/' . $path;
        $this->ciqrcode->generate($data);
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

    public function getOrderById()
    {
        $id = $this->input->post('kd_order');
        $this->db->select("*");
        $this->db->from("order");
        $this->db->join('bukti_pembayaran', "bukti_pembayaran.kd_order=order.kd_order");
        $this->db->where(['order.kd_order' => $id]);
        $data = $this->db->get()->row_array();

        if (!$data) {
            $data = $this->db->get_where('order', ['kd_order' => $id])->row_array();
        }

        $this->session->set_userdata("kd_order", $id);
        echo json_encode($data);
    }

    public function editStatusPesanan()
    {
        $order = $this->db->get_where('order', ['kd_order' => $this->session->userdata('kd_order')])->row_array();

        if ($order['payment_status'] == 0) {
            $data = toast('error', 'Gagal Ubah Status Data Order! Pastikan Pembayaran sudah dilakukan.');
            echo json_encode($data);
            die;
        }

        $sess_masak = $this->session->userdata('kd_masak');
        $sess_kurir = $this->session->userdata('kd_kurir');

        if ($sess_masak) {
            if ($this->input->post('status') == "pending") {
                $data = toast('error', 'Gagal Ubah Status Data Order! Anda tidak memiliki akses.');
                echo json_encode($data);
                die;
            }
            if ($this->input->post('status') == "done") {
                $data = toast('error', 'Gagal Ubah Status Data Order! Anda tidak memiliki akses.');
                echo json_encode($data);
                die;
            }
        }

        if ($sess_kurir) {
            if ($this->input->post('status') == "pending") {
                $data = toast('error', 'Gagal Ubah Status Data Order! Anda tidak memiliki akses.');
                echo json_encode($data);
                die;
            }
            if ($this->input->post('status') == "onprocess") {
                $data = toast('error', 'Gagal Ubah Status Data Order! Anda tidak memiliki akses.');
                echo json_encode($data);
                die;
            }
        }

        $data = ['order_status' => $this->input->post('status')];
        $where = ['kd_order' => $this->session->userdata('kd_order')];
        $this->db->update('order', $data, $where);

        if ($this->db->affected_rows() > 0) {
            $data = toast('success', 'Berhasil Ubah Status Data Order!');
        } else {
            $data = toast('error', 'Gagal Ubah Status Data Order!');
        }

        $this->session->unset_userdata('kd_order');

        echo json_encode($data);
    }

    public function delete_order()
    {
        $where = ['kd_order' => $this->session->userdata('kd_order')];

        $this->db->delete('order', $where);
        $this->db->delete('detail_order', $where);
        $this->db->delete('detail_order_perhari', $where);
        if ($this->db->affected_rows() > 0) {
            $data = toast('success', 'Berhasil Delete Data Order!');
        } else {
            $data = toast('error', 'Gagal Delete Data Order!');
        }

        $this->session->unset_userdata('kd_order');

        echo json_encode($data);
    }

    public function semua_pesanan()
    {

        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['judul'] = "Semua Pesanan";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/order/semua_pesanan', $data);
        $this->load->view('base/footer');
    }

    public function get_semua_pesanan($user = null)
    {
        $sess_masak = $this->session->userdata('kd_masak');
        $sess_admin = $this->session->userdata('kd_admin');
        $sess_kurir = $this->session->userdata('kd_kurir');

        $this->datatables->select('kd_order, tgl_kirim, tgl_order, payment_type,  payment_status, order_status, order_type, cust_name, cust_email, total_harga , cust_phone');
        $this->datatables->from('order');
        if ($sess_masak) {
            $this->datatables->where(['order_status' => "onprocess"]);
        }
        if ($sess_kurir) {
            $this->datatables->where(['order_status' => "ondelivery"]);
        }
        $this->db->order_by("created_at", "DESC");

        if ($sess_masak) {
            $this->datatables->add_column(
                'aksi',
                '</span><span data-toggle="tooltip" data-placement="top" title="Lihat Order"><a href="javascript:void(0);" class="detail_record btn btn-sm btn-info" data-id="$1">
                <i class="fas fa-eye"></i> </a> </span>',
                'kd_order'
            );
        } else if ($sess_kurir) {
            $this->datatables->add_column(
                'aksi',
                '</span><span data-toggle="tooltip" data-placement="top" title="Lihat Order"><a href="javascript:void(0);" class="detail_record btn btn-sm btn-info" data-id="$1">
                <i class="fas fa-eye"></i> </a> </span>',
                'kd_order'
            );
        } else if ($sess_admin) {
            $this->datatables->add_column(
                'aksi',
                '<span data-toggle="tooltip" data-placement="top" title="Whatsapp Pelanggan"><a href="javascript:void(0);" class="whatsapp btn btn-sm btn-dark" data-id="$1">
                <i class="fas fa-comments"></i> </a> 
                </span><span data-toggle="tooltip" data-placement="top" title="Lihat Order"><a href="javascript:void(0);" class="detail_record btn btn-sm btn-info" data-id="$1">
                <i class="fas fa-eye"></i> </a> </span>
                <span data-toggle="tooltip" data-placement="top" title="Hapus Order"><a href="javascript:void(0);" class="hapus_record btn btn-sm btn-danger" data-id="$1" data-id="$1" data-toggle="modal" data-target="#hapusModal">
                <i class="fas fa-trash"></i> </a></span>',
                'kd_order'
            );
        }

        return print_r($this->datatables->generate());
    }

    public function pesanan_khusus()
    {

        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['judul'] = "Pesanan khusus";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/order/pesanan_khusus', $data);
        $this->load->view('base/footer');
    }

    public function get_pesanan_khusus($user = null)
    {
        $sess_masak = $this->session->userdata('kd_masak');
        $sess_admin = $this->session->userdata('kd_admin');
        $sess_kurir = $this->session->userdata('kd_kurir');

        $this->db->select('kd_detail_order_perhari, detail_order_perhari.kd_order, produk.nm_produk, qty, status, tanggal, order_type');
        $this->db->from('detail_order_perhari');
        $this->db->join('detail_order', 'detail_order.kd_order = detail_order_perhari.kd_order');
        $this->db->join('order', 'order.kd_order = detail_order_perhari.kd_order');
        $this->db->join('produk', 'produk.kd_produk = detail_order_perhari.kd_produk');
        if ($sess_masak) {
            $this->db->where(['status' => 2]);
        } else if ($sess_kurir) {
            $this->db->where(['status' => 3]);
        }
        $data = $this->db->get()->result_array();
        echo json_encode($data);
    }

    public function getOrderPerhariById()
    {
        $sess_masak = $this->session->userdata('kd_masak');
        $sess_admin = $this->session->userdata('kd_admin');
        $sess_kurir = $this->session->userdata('kd_kurir');
        $sess_member = $this->session->userdata('kd_member');
        $id = $this->input->post('kd_order');

        $this->db->select('kd_detail_order_perhari, detail_order_perhari.kd_order, produk.nm_produk, qty, status, tanggal');
        $this->db->from('detail_order_perhari');
        $this->db->join('detail_order', 'detail_order.kd_order = detail_order_perhari.kd_order');
        $this->db->join('produk', 'produk.kd_produk = detail_order_perhari.kd_produk');
        if (!$sess_member) {
            if ($sess_masak) {
                $this->db->where(['status' => 2]);
            } else if ($sess_kurir) {
                $this->db->where(['status' => 3]);
            }
        }
        $this->db->where(['detail_order_perhari.kd_order' => $id]);
        $data = $this->db->get()->result_array();

        echo json_encode($data);
    }

    public function updatestatusperhari()
    {
        $sess_masak = $this->session->userdata('kd_masak');
        $sess_kurir = $this->session->userdata('kd_kurir');

        $id = $this->input->post('kd_detail_order_perhari');
        $status = $this->input->post('status');
        $tanggal = $this->input->post('tanggal');
        $hariini = date('Y-m-d');

        if ($hariini < $tanggal) {
            $data = toast('error', 'Tidak boleh ubah status, belum waktunya!');
            echo json_encode($data);
            die;
        }

        if ($sess_masak) {
            if ($status != 3) {
                $data = toast('error', 'Tidak boleh ubah status, tidak memiliki akses!');
                echo json_encode($data);
                die;
            }
        } else if ($sess_kurir) {
            if ($status != 1) {
                $data = toast('error', 'Tidak boleh ubah status, tidak memiliki akses!');
                echo json_encode($data);
                die;
            }
        }
        $this->db->update('detail_order_perhari', ['status' => $status], ['kd_detail_order_perhari' => $id]);


        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Berhasil Ubah Status!');
        } else {
            $data = toast('error', 'Gagal Ubah Status!');
        }

        $detail_order_perhari = $this->db->get_where('detail_order_perhari', ['detail_order_perhari' => $id])->row_array();
        $alldetail_order_perhari = $this->db->get_where('detail_order_perhari', ['kd_order' => $detail_order_perhari['kd_order'], ['status' => 1]])->result_array();
        $order = $this->db->get_where('order', ['kd_order' => $detail_order_perhari['kd_order']])->row_array();
        if ($order['order_type'] == "mingguan") {
            $total_hari = 7;
        } else if ($order['order_type'] == "bulanan") {
            $total_hari = 30;
        }
        if (count($alldetail_order_perhari) == $total_hari) {
            $this->db->update('order', ['order_status' => "done"], ['kd_order' => $detail_order_perhari['kd_order']]);
        }
        echo json_encode($data);
    }

    public function detail_pesanan($a)
    {
        $get = $this->db->get_where('order', ['kd_order' => $a])->row_array();
        $key = kunci();

        if ($get['kd_member'] != "#") {
            $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos");
            $this->db->from("member");
            $this->db->join("order", "order.kd_member=member.kd_member");
            $this->db->where(['order.kd_order' => $a]);
            $data['order_member'] = $this->db->get()->row_array();
        } else {
            $data['order_member'] = $this->db->get_where('order', ['kd_order' => $a])->row_array();
        }

        $data['detail_order'] = $this->db->get_where('detail_order', ['kd_order' => $a])->result_array();

        $data['kd_order'] = $a;

        $dt = $this->db->get_where('bukti_pembayaran', ['kd_order' => $a]);

        $data['bukti_pembayaran'] = $dt->row_array();

        $data['rows_bukti_pembayaran'] = $dt->num_rows();

        $data['judul'] = "Detail Order";
        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/order/detail', $data);
        $this->load->view('base/footer');
    }

    public function select_bukti_transfer()
    {
        $kd_order = $this->input->post('kd_order');

        $orders = $this->db->get_where('bukti_pembayaran', ['kd_order' => $kd_order])->result_array();
        echo json_encode($orders);
    }

    public function del_bukti_transfer_satuan()
    {
        $kd_pembayaran =  $this->input->post('kd_pembayaran');
        $kd_order =  $this->input->post('kd_order');
        $bukti_tf = $this->db->get_where('bukti_pembayaran', ['kd_bukti_pembayaran' => $kd_pembayaran])->row_array();
        $jml_bukti = $this->db->get_where('bukti_pembayaran', ['kd_order' => $bukti_tf['kd_order']])->num_rows();

        $status = $jml_bukti < 2 ? 0 : 1;

        unlink(FCPATH . '/assets/images/bukti_pembayaran/' . $bukti_tf['bukti_upload']);

        $this->db->delete('bukti_pembayaran', ['kd_bukti_pembayaran' => $kd_pembayaran]);

        $data = [
            'payment_status' => $status,
            'updated_at_admin'  => $this->session->userdata('kd_admin'),
            'updated_at'        => date('Y-m-d H:i:s', time()),
        ];
        $this->db->update('order', $data, ['kd_order' => $bukti_tf['kd_order']]);

        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Berhasil Hapus Bukti Pembayaran!');
        } else {
            $data = toast('error', 'Gagal Hapus Bukti Pembayaran!');
        }
        echo json_encode(['data' => $data, 'status' => $status]);
    }

    public function del_bukti_transfer()
    {
        $kd_order =  $this->input->post('kd_order');
        $bukti_tf = $this->db->get_where('bukti_pembayaran', ['kd_order' => $kd_order])->result_array();

        foreach ($bukti_tf as $bukti) {
            unlink(FCPATH . '/assets/images/bukti_pembayaran/' . $bukti['bukti_upload']);
            $this->db->delete('bukti_pembayaran', ['kd_order' => $kd_order]);
        }

        $data = [
            'payment_status' => '0',
            'updated_at_admin'  => $this->session->userdata('kd_admin'),
            'updated_at'        => date('Y-m-d H:i:s', time()),
        ];
        $this->db->update('order', $data, ['kd_order' => $kd_order]);

        $data = $this->db->get_where('order', ['kd_order' => $kd_order])->row_array();
        $dataDetail = $this->db->get_where('detail_order', ['kd_order' => $kd_order])->result_array();

        if ($data['payment_type'] == "ambil_langsung") {
            $dataStatusPembayaran = [
                'payment_status' => '0'
            ];
            $this->db->update('order', $dataStatusPembayaran, ['kd_order' => $kd_order]);
        }

        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Berhasil Hapus Bukti Pembayaran!');
        } else {
            $data = toast('error', 'Gagal Hapus Bukti Pembayaran!');
        }

        echo json_encode($data);
    }

    public function del_bukti_penerimaan()
    {
        $lokasi = lokasi_gambar();
        $kd_order =  $this->input->post('kd_order');
        $bukti_penerimaan = $this->db->get_where('pengiriman', ['kd_order' => $kd_order])->row_array();

        unlink($lokasi . $bukti_penerimaan['bukti_barang_diterima']);

        $data = [
            'bukti_barang_diterima' => null,
            'updated_at_admin'      => $this->session->userdata('kd_admin'),
            'updated_at'            => date('Y-m-d H:i:s', time()),
        ];
        $this->db->update('pengiriman', $data, ['kd_order' => $kd_order]);

        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Berhasil Hapus Bukti Penerimaan!');
        } else {
            $data = toast('error', 'Gagal Hapus Bukti Penerimaan!');
        }

        echo json_encode($data);
    }

    public function get_pengiriman()
    {
        $kd_order = $this->input->post('kd_order');

        $data = $this->db->get_where('pengiriman', ['kd_order' => $kd_order])->result_array();

        echo json_encode($data);
    }

    public function edit_pengiriman()
    {
        $kd_order = $this->session->userdata('kd_order');

        $where = ['kd_pengiriman' => $this->input->post('kd_pengiriman')];
        $data = [
            'kd_kurir' => $this->input->post('kurir'),
            'updated_at_admin' => $this->session->userdata('kd_admin')
        ];

        $this->db->update('pengiriman', $data, $where);

        pusher('pengiriman');

        if ($this->db->affected_rows() > 0) {
            $data = toast('success', 'Berhasil Update Data Pengiriman!');
        } else {
            $data = toast('error', 'Gagal Update Data Pengiriman!');
        }
        echo json_encode($data);
    }

    public function get_order_tracking()
    {
        $kd_order = $this->input->post('kd_order');

        $this->db->select("order_track.*, reseller.nm_reseller");
        $this->db->from("order_track");
        $this->db->join("reseller", "order_track.created_at_admin=reseller.kd_reseller");
        $this->db->where(['kd_order' => $kd_order]);
        $data1 = $this->db->get_compiled_select();

        $this->db->select("order_track.*, admin.nm_admin");
        $this->db->from("order_track");
        $this->db->join("admin", "order_track.created_at_admin=admin.kd_admin");
        $this->db->where(['kd_order' => $kd_order]);
        $data2 = $this->db->get_compiled_select();

        $data = $this->db->query($data1 . " UNION " . $data2)->result_array();

        echo json_encode($data);
    }

    public function get_pesanan($where = null)
    {
        $sess_masak = $this->session->userdata('kd_masak');
        $sess_kurir = $this->session->userdata('kd_kurir');

        $this->db->select('*');
        $this->db->from('order');
        if ($sess_masak) {
            $this->db->where(['order_status' => "onprocess"]);
        }
        if ($sess_kurir) {
            $this->db->where(['order_status' => "ondelivery"]);
        }
        $order = $this->db->get()->result_array();

        $data = ['jumlah' => count($order)];
        echo json_encode($data);
    }

    public function get_pesanan_where($a = null)
    {
        $data_role = $this->_cek_hak_akses();

        $admin = $this->db->get_where('admin', ['kd_admin' => $this->session->userdata('kd_admin')])->row_array();

        $this->datatables->select('kd_order, tgl_order, cust_name, cust_email, total_harga, cust_phone, payment_type, pilihan_kurir, catatan_order');
        $this->datatables->from('order');
        $this->datatables->where(['order_status' => $a]);
        $this->db->order_by("created_at", "DESC");

        $this->datatables->add_column(
            'aksi',
            '<span data-toggle="tooltip" data-placement="top" title="Lihat Order"><a href="javascript:void(0);" class="detail_record btn btn-sm btn-info" data-id="$1">
                        <i class="fas fa-eye"></i> </a> </span>
                    <span data-toggle="tooltip" data-placement="top" title="Qr Member"><a href="javascript:void(0);" class="qr_order btn btn-sm btn-success" data-id="$1" data-toggle="modal" data-target="#shapusModal">
                        <i class="fas fa-qrcode"></i> </a> </span>',
            'kd_order'
        );

        return print_r($this->datatables->generate());
    }

    public function ubah_status_order()
    {
        $detail_order_code_edit = $this->input->post('detail_order_code_edit');
        $status_edit = $this->input->post('status_edit');
        $kd_member = $this->input->post('kd_member');

        $data = $this->db->get_where('order', ['kd_order' => $detail_order_code_edit])->row_array();

        $dataOrderTrack = [
            'kd_order' => $detail_order_code_edit,
            'status'   => $status_edit,
            'created_at_admin' => $this->session->userdata('kd_admin'),
            'updated_at_admin' => $this->session->userdata('kd_admin'),
        ];

        $this->db->insert('order_track', $dataOrderTrack);

        $dataWhere = [
            'order_status' => $status_edit,
            'updated_at_admin'  => $this->session->userdata('kd_admin'),
            'updated_at'        => date('Y-m-d H:i:s', time()),
        ];
        $data = $this->db->update('order', $dataWhere, ['kd_order' => $detail_order_code_edit]);

        if ($status_edit == "onprocess") {
            $this->db->update('order', ['read_order' => '0'], ['kd_order' => $detail_order_code_edit]);
        }

        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Berhasil Edit Status Order!');
        } else {
            $data = toast('error', 'Gagal Edit Status Order!');
        }

        $order = $this->db->get_where('order', ['kd_order' => $detail_order_code_edit])->row_array();

        echo json_encode(['status' => $data, 'order' => $order]);
    }

    public function delete_tracking()
    {

        $dt = $this->db->get_where('order_track', ['kd_track' => $this->input->post('kd_tracking')])->row_array();

        $data = ['kd_track' => $this->input->post('kd_tracking')];
        $data = $this->db->delete('order_track', $data);

        if ($this->db->affected_rows() > 0) {
            $data = toast('success', 'Berhasil Delete Data Order Tracking!');
        } else {
            $data = toast('error', 'Gagal Delete Data Order Tracking!');
        }

        echo json_encode($data);
    }

    public function get_upload_bukti_tf()
    {
        $this->datatables->select('kd_order, tgl_order, payment_type, order_status, cust_name, cust_email, total_harga , cust_phone');
        $this->datatables->from('order');
        $this->datatables->where(['payment_type' => 'transfer', 'payment_status' => '0', 'kd_reseller' => $this->session->userdata('kd_reseller')]);
        $this->db->order_by("order.tgl_order", "ASC");
        $this->datatables->add_column(
            'aksi',
            '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_bukti btn btn-sm btn-primary" data-id="$1" data-toggle="modal" data-target="#editModal">
                <i class="fas fa-eye"></i> </a> </span>
            <span data-toggle="tooltip" data-placement="top" title="UploadBuktiTF"><a href="javascript:void(0);" class="upload_bukti btn btn-sm btn-success" data-id="$1" data-toggle="modal" data-target="#uploadbuktitf">
                <i class="fas fa-upload"></i> </a> </span>',
            'kd_order'
        );
        return print_r($this->datatables->generate());
    }

    public function upload_bukti_tf()
    {
        $upload_image = $_FILES['bukti_transfer']['name'];
        $kd_order = $this->session->userdata('kd_order');

        if ($upload_image) {
            $config['allowed_types'] = 'jpg|jpeg|png|svg';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/images/bukti_pembayaran/';

            $this->load->library('upload', $config);

            $data = $this->db->get_where('produk', ['kd_produk' => $this->input->post('kd_produk')])->row_array();

            if ($this->upload->do_upload('bukti_transfer')) {

                $buktitf = $this->db->get_where('bukti_pembayaran', ['kd_order' => $kd_order])->row_array();
                $new_image = $this->upload->data('file_name');

                if ($buktitf) {
                    $old_image = $data['foto_produk'];
                    if ($old_image != 'imagenotfound.jpg') {
                        unlink(FCPATH . '/assets/images/bukti_pembayaran/' . $old_image);
                    }
                    $data = [
                        'kd_bukti_pembayaran'   => $this->getKodeOtomatis("PEM", "bukti_pembayaran"),
                        'bukti_upload'          => $new_image,
                        'updated_at_admin'      => $this->session->userdata('kd_reseller'),
                        'updated_at'            => date('Y-m-d H:i:s', time()),
                    ];
                    $this->db->update('bukti_pembayaran', $data, ['kd_order' => $kd_order]);
                } else {
                    $data = [
                        'kd_bukti_pembayaran'   => $this->getKodeOtomatis("PEM", "bukti_pembayaran"),
                        'kd_order'              => $kd_order,
                        'bukti_upload'          => $new_image,
                        'status'                => 1,
                        'created_at_admin'      => $this->session->userdata('kd_reseller'),
                        'updated_at_admin'      => $this->session->userdata('kd_reseller'),
                    ];
                    $this->db->insert('bukti_pembayaran', $data);
                }

                $this->session->set_flashdata('flash_page', "Segera Konfirmasi Kepada Admin Untuk Pembayaran dengan Kode Order " . $kd_order . " !");
                redirect('order/bukti_transfer_reseller');
            } else {
                echo $this->upload->display_errors();
            }
            $this->session->unset_userdata('kd_order');
        }
    }

    public function get_upload_pembayaran()
    {
        $kd_order = $this->input->post('kd_order');
        $data = $this->db->get_where('bukti_pembayaran', ['kd_order' => $kd_order])->row_array();

        echo json_encode($data);
    }

    public function upload_bukti_pembayaran()
    {
        $jumlah_berkas = count($_FILES['gallery']['name']);
        $kd_order = $this->input->post('kd_order');

        if ($jumlah_berkas) { // variabel true
            for ($i = 0; $i < $jumlah_berkas; $i++) {
                if (!empty($_FILES['gallery']['name'][$i])) {

                    // Define new $_FILES array - $_FILES['file']
                    $_FILES['file']['name'] = $_FILES['gallery']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['gallery']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['gallery']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['gallery']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['gallery']['size'][$i];

                    // Set preference
                    $config1['upload_path'] = './assets/images/bukti_pembayaran/';
                    $config1['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config1['max_size'] = '5000'; // max_size in kb
                    $config1['file_name'] = $_FILES['gallery']['name'][$i];

                    //Load upload library
                    $this->load->library('upload', $config1);
                    $arr = array('msg' => 'something went wrong', 'success' => false);
                    // File upload
                    if ($this->upload->do_upload('file')) {

                        $new_image = $this->upload->data('file_name'); // file name yaitu nama bawaan gambar

                        $data = array('upload_data' => $this->upload->data());
                        $path = $data['upload_data']['full_path'];
                        $q['name'] = $data['upload_data']['file_name'];

                        $configi['image_library'] = 'gd2';
                        $configi['source_image']   = $path;
                        $configi['maintain_ratio'] = FALSE;

                        $data = [
                            'kd_bukti_pembayaran'     => $this->getKodeOtomatis("PEM", "bukti_pembayaran"),
                            'kd_order'          => $kd_order,
                            'bukti_upload'      => $new_image,
                            'status'            => 1,
                            'created_at_admin'  => $this->session->userdata('kd_admin'),
                            'updated_at_admin'  => $this->session->userdata('kd_admin'),
                        ];
                        $this->db->insert('bukti_pembayaran', $data);

                        $data = $this->db->get_where('order', ['kd_order' => $kd_order])->row_array();

                        $totalKomisi = [];
                        $totalPoint = [];
                        $totalSelera = [];

                        $dataDetail = $this->db->get_where('detail_order', ['kd_order' => $kd_order])->result_array();

                        $where = ['kd_order'    => $kd_order];
                        $data_order = ['payment_status' => 1];
                        $this->db->update('order', $data_order, $where);
                    } else {
                        // echo $this->upload->display_errors();
                        $this->session->set_flashdata('error', 'Foto Tidak Berhasil Di Upload');
                        redirect(base_url('order/detail_pesanan/' . $kd_order));
                    }
                }
            }

            if ($this->db->affected_rows() >= 0) {
                $data = ['toast' => toast('success', 'Berhasil Upload Bukti Transfer!'), 'bukti_transfer' => $new_image];
            } else {
                $data = toast('error', 'Gagal Upload Bukti Transfer!');
            }

            echo json_encode($data);
        }
    }

    public function edit_status_pembayaran()
    {
        $kd_order = $this->session->userdata('kd_order');
        $ord = $this->db->get_where('order', ['kd_order' => $kd_order])->row_array();
        $dataDetail = $this->db->get_where('detail_order', ['kd_order' => $kd_order])->result_array();

        $data = [
            'payment_status' => $this->input->post('stat_pembayaran'),
            'updated_at_admin'  => $this->session->userdata('kd_admin'),
            'updated_at'        => date('Y-m-d H:i:s', time()),
        ];

        $this->db->update('order', $data, ['kd_order' => $kd_order]);

        if ($this->db->affected_rows() >= 0) {
            $data = ['toast' =>  toast('success', 'Berhasil Ganti Status Pembayaran!'), 'status' => $this->input->post('stat_pembayaran')];
        } else {
            $data = ['toast' =>  toast('error', 'Gagal Ganti Status Pembayaran!'), 'status' => $this->input->post('stat_pembayaran')];
        }

        echo json_encode($data);
    }

    public function edit_metode_pembayaran()
    {
        $kd_order = $this->session->userdata('kd_order');

        $data = [
            'payment_type' => $this->input->post('met_pembayaran'),
            'updated_at_admin'  => $this->session->userdata('kd_admin'),
            'updated_at'        => date('Y-m-d H:i:s', time()),
        ];

        $this->db->update('order', $data, ['kd_order' => $kd_order]);

        $order = $this->db->get_where('order', ['kd_order' => $kd_order])->row_array();

        if ($order['order_status'] == 'done' && $order['payment_type'] != 'transfer') {
            $detail = $this->db->get_where('detail_order', ['kd_order' => $kd_order])->result_array();
            $ujroh = $this->db->get_where('rincian_ujroh', ['kd_order' => $kd_order])->result_array();

            $tampunganUjroh = [];

            foreach ($detail as $detail) {
                array_push($tampunganUjroh, $detail['jml_komisi']);
            }

            $data = [
                'kd_reseller'       => $order['kd_reseller'],
                'jml_ujroh'         => array_sum($tampunganUjroh),
            ];

            if ($ujroh) {
                $data['updated_at_admin'] = $this->session->userdata('kd_admin');
                $data['updated_at'] = date('Y-m-d H:i:s', time());
                $this->db->update('rincian_ujroh', $data, ['kd_order' => $kd_order]);
            } else {
                $data['kd_order'] = $kd_order;
                $data['waktu_hitung_ujroh'] = date('Y-m-d', time());
                $data['created_at_admin'] = $this->session->userdata('kd_admin');
                $data['created_at'] = date('Y-m-d H:i:s', time());

                $this->db->insert('rincian_ujroh', $data);
            }
        } else {
            $this->db->delete('rincian_ujroh', ['kd_order' => $kd_order]);
        }

        if ($this->db->affected_rows() >= 0) {
            $data = ['toast' =>  toast('success', 'Berhasil Ganti Metode Pembayaran!'), 'metode' => $this->input->post('met_pembayaran')];
        } else {
            $data = ['toast' =>  toast('error', 'Gagal Ganti Metode Pembayaran!'), 'metode' => $this->input->post('met_pembayaran')];
        }

        echo json_encode($data);
    }

    public function get_json_kecamatan()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');
        $kabupaten = $this->input->post('kabupaten');

        // Get users
        $response = $this->ModelOrder->getKecamatanjson($searchTerm, $kabupaten);

        echo json_encode($response);
    }

    public function get_json_daerah()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->ModelOrder->getDaerahjson($searchTerm);

        echo json_encode($response);
    }

    public function get_json_kota()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->ModelOrder->getKotajson($searchTerm);

        echo json_encode($response);
    }

    public function get_json_kelurahan()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');
        $kabupaten = $this->input->post('kabupaten');
        $kecamatan = $this->input->post('kecamatan');

        // Get users
        $response = $this->ModelOrder->getkelurahanjson($searchTerm, $kabupaten, $kecamatan);

        echo json_encode($response);
    }

    // -------------------------------------------------- Bagian Kurir -------------------------------------------------

    public function getOrderByyId()
    {
        // ini didapet pada saat scan barcode. ada di footer.php function scanDataQrCode
        $id = $this->input->post('tujuan');

        if ($id == null) {
            $id = $this->input->post('kd_order');
        }
        $data = $this->db->get_where('order', ['kd_order' => $id])->row_array();

        $this->session->set_userdata('kd_order', $id);

        echo json_encode($data);
    }

    public function get_list_detail_order_kurir()
    {
        $key = kunci();
        $kd_order = $this->input->post('tujuan');
        $jenis = $this->input->post('jenis');
        if ($kd_order == null) {
            $kd_order = $this->input->post('kd_order');
        }
        $get = $this->db->get_where('order', ['kd_order' => $kd_order])->row_array();

        if ($jenis == "id") {
            if ($get['kd_member'] != "#") {
                $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos");
                $this->db->from("order");
                $this->db->join("member", "order.kd_member=member.kd_member");
                $this->db->where(['order.kd_order' => $kd_order]);
                $order_member = $this->db->get()->row_array();
            } else {
                $order_member = $this->db->get_where('order', ['kd_order' => $kd_order])->row_array();
            }
        } else if ($jenis == "qr") {
            if ($get['kd_member'] != "#") {
                $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email,CAST(AES_DECRYPT(kodepos, '$key') AS CHAR(50)) kodepos");
                $this->db->from("order");
                $this->db->join("member", "order.kd_member=member.kd_member");
                $this->db->where(['order.qr_order' => $kd_order]);
                $order_member = $this->db->get()->row_array();
            } else {
                $order_member = $this->db->get_where('order', ['kd_order' => $kd_order])->row_array();
            }
        }

        if ($order_member == null) {
            echo json_encode(null);
        }

        $this->db->select("*");
        $this->db->from("detail_order");
        $this->db->join("produk", "detail_order.kd_produk=produk.kd_produk");
        $this->db->where(['detail_order.kd_order' => $order_member['kd_order']]);
        $detail_order = $this->db->get()->result_array();

        $dt = $this->db->get_where('bukti_pembayaran', ['kd_order' => $order_member['kd_order']]);

        $bukti_pembayaran = $dt->row_array();

        $rows_bukti_pembayaran = $dt->num_rows();

        echo json_encode(['order_member' => $order_member, 'detail_order' => $detail_order, 'bukti_pembayaran' => $bukti_pembayaran, 'rows_bukti_pembayaran' => $rows_bukti_pembayaran]);
    }

    public function get_datatable_order()
    {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $status = $this->input->post('status');
        $bayar = $this->input->post('bayar');
        $tgl = $this->input->post('tgl');
        $reseller = $this->input->post('reseller');
        $admin = $this->db->get_where('admin', ['kd_admin' => $this->session->userdata('kd_admin')])->row_array();
        $this->datatables->select('kd_order, tgl_order, cust_name, cust_email, cust_phone,  total_harga, payment_type');
        $this->datatables->from('order');

        if ($bulan != "") {
            $this->datatables->where('month(tgl_order)', $bulan);
        }
        if ($tahun != "") {
            $this->datatables->where('year(tgl_order)', $tahun);
        }
        if ($status != "") {
            $this->datatables->where('order_status', $status);
        }
        if ($bayar != "") {
            $this->datatables->where('payment_status', $bayar);
        }
        if ($tgl != "") {
            $this->datatables->where('tgl_order', $tgl);
        }

        if ($this->session->userdata('kd_reseller')) {
            $this->datatables->where('kd_reseller', $this->session->userdata('kd_reseller'));
        }

        $this->db->order_by("created_at", "DESC");
        $this->datatables->add_column(
            'aksi',
            '</span><span data-toggle="tooltip" data-placement="top" title="Lihat Order"><a href="javascript:void(0);" class="modal-lihat-barangsec btn btn-info btn-sm" data-toggle="modal" data-target="#modal-lihat-reportorder" data-id="$1">
                <i class="fas fa-eye"></i> </a> </span>
                </span><span data-toggle="tooltip" data-placement="top" title="Lihat Order"><a href="javascript:void(0);" class="download-invoice-report-order btn btn-success btn-sm" data-id="$1">
                <i class="fas fa-download"></i> </a> </span>',
            'kd_order'
        );
        return print_r($this->datatables->generate());
    }

    public function get_list_member()
    {
        $key = kunci();
        $reseller = $this->input->post('reseller');

        $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp");
        $this->db->from('cek_reseller_utama');
        $this->db->join('member', 'member.kd_member=cek_reseller_utama.kd_member');
        $this->db->where(['kd_reseller' => $reseller]);
        $data = $this->db->get()->result_array();
        echo json_encode($data);
    }

    public function kon_bukti_tf()
    {
        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['judul'] = "Konfirmasi Bukti Upload Transfer";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/order/kon_bukti_tf', $data);
        $this->load->view('base/footer');
    }

    public function get_kon_bukti_tf()
    {
        $admin = $this->db->get_where('admin', ['kd_admin' => $this->session->userdata('kd_admin')])->row_array();

        $this->datatables->select('order.kd_order, nm_member, bukti_pembayaran.created_at');
        $this->datatables->from('bukti_pembayaran');
        $this->datatables->join('order', 'bukti_pembayaran.kd_order=order.kd_order');
        $this->datatables->join('member', 'order.kd_member=member.kd_member');
        $this->datatables->where(['payment_status' => '0']);
        $this->datatables->add_column(
            'aksi',
            '<span data-toggle="tooltip" data-placement="top" title="DetailOrder"><a href="javascript:void(0);" class="detail_bukti_tf btn btn-sm btn-success" data-id="$1" data-toggle="modal" data-target="#editModal">
                <i class="fas fa-eye"></i> </a> </span>',
            'kd_order'
        );
        return print_r($this->datatables->generate());
    }

    public function count_bukti_tf()
    {
        $admin = $this->db->get_where('admin', ['kd_admin' => $this->session->userdata('kd_admin')])->row_array();

        $this->db->select('order.kd_order, nm_member, bukti_pembayaran.created_at');
        $this->db->from('bukti_pembayaran');
        $this->db->join('order', 'bukti_pembayaran.kd_order=order.kd_order');
        $this->db->join('member', 'order.kd_member=member.kd_member');
        $this->db->where(['payment_status' => '0']);
        $order = $this->db->get()->num_rows();

        echo json_encode($order);
    }
}
