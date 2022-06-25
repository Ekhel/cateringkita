<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Product extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
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

        if ($sql != Null && substr($sql['kd_' . $tabel], -7, 2) == $tahun) {

            $number = (int) substr($sql['kd_' . $tabel], -5);
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

    public function add_produk()
    {

        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['kodeOtomatis'] = $this->getKodeOtomatis("PS", "produk");
        $data['konfigurasi'] = $this->db->get('konfigurasi')->row_array();
        $data['judul'] = "Halaman Tambah Menu";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/product/index', $data);
        $this->load->view('base/footer');
    }

    public function add_product()
    {

        $jumlah_berkas = count($_FILES['gallery']['name']);

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
                    $config1['upload_path'] = './assets/images/gallery_produk/';
                    $config1['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config1['max_size'] = '5000'; // max_size in kb
                    $config1['file_name'] = $_FILES['gallery']['name'][$i];

                    //Load upload library
                    $this->load->library('upload', $config1);
                    $arr = array('msg' => 'something went wrong', 'success' => false);
                    // File upload
                    if ($this->upload->do_upload('file')) {

                        $data = array('upload_data' => $this->upload->data());
                        $path = $data['upload_data']['full_path'];
                        $q['name'] = $data['upload_data']['file_name'];

                        $configi['image_library'] = 'gd2';
                        $configi['source_image']   = $path;
                        $configi['maintain_ratio'] = FALSE;
                        $configi['width']  = 380;
                        $configi['height'] = 380;

                        $this->load->library('image_lib');
                        $this->image_lib->initialize($configi);
                        $this->image_lib->resize();

                        $dataGallery = [
                            'kd_produk' => $this->input->post('kd_produk'),
                            'foto'      => $q['name']
                        ];
                        $this->db->insert('gallery_produk', $dataGallery);
                    } else {
                        // echo $this->upload->display_errors();
                        $this->session->set_flashdata('error', 'Foto Tidak Berhasil Di Upload');
                        redirect(base_url('product/daftar_produk'));
                    }
                }
            }

            $gambar_awal = str_replace(" ", "_", $_FILES['gallery']['name'][0]);
            if ($gambar_awal == "" || $gambar_awal == null) {
                $gambar_awal = "imagenotfound.jpg";
            }

            $dataProduk = [
                'kd_produk' => $this->input->post('kd_produk'),
                'nm_produk' => ucwords($this->input->post('nm_produk')),
                'foto_produk' => $gambar_awal,
                'kd_kategori' => $this->input->post('kategori'),
                'kd_sub_kategori' => $this->input->post('sub_kategori'),
                'deskripsi' => $this->input->post('deskripsi'),
                'harga' => $this->input->post('harga_produk'),
                'min_order' => $this->input->post('min_order'),
                'created_at_admin' => $this->session->userdata('kd_admin'),
                'updated_at_admin' => $this->session->userdata('kd_admin'),
            ];

            $this->db->insert('produk', $dataProduk);

            if ($this->db->affected_rows() >= 0) {
                $data = toast('success', 'Berhasil Tambah Data Produk!');
            } else {
                $data = toast('error', 'Gagal Tambah Data Produk!');
            }
            echo json_encode($data);
        }
    }

    public function daftar_produk()
    {
        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['subkategori'] = $this->db->get("kategori")->result();
        $data['judul'] = "Halaman Menu Aktif";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/product/list_product_aktif', $data);
        $this->load->view('base/footer');
    }

    public function daftar_produk_nonAktif()
    {
        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['judul'] = "Halaman Menu Tidak Aktif";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/product/list_product_tdk_aktif', $data);
        $this->load->view('base/footer');
    }

    public function get_product($a)
    {
        $this->datatables->select('kategori.nm_kategori, produk.kd_produk, produk.nm_produk, produk.foto_produk,produk.harga, produk.kd_kategori, produk.deskripsi');
        $this->datatables->from('produk');
        $this->datatables->join("kategori", "kategori.kd_kategori=produk.kd_kategori");
        $this->datatables->where(['produk.is_produk_hapus' => 1, 'produk.is_produk_aktif' => $a]);
        $this->db->order_by("produk.created_at", "DESC");
        $this->datatables->add_column(
            'aksi',
            '<a href="javascript:void(0);" class="edit_record btn btn-sm btn-primary" data-id="$1" data-toggle="tooltip" data-placement="top" title="Edit Produk">
                <i class="fas fa-edit"></i> </a> 
                <a href="javascript:void(0);" class="hapus_record btn btn-sm btn-danger" data-id="$1" data-toggle="tooltip" data-placement="top" title="Hapus Produk">
                <i class="fas fa-trash"></i> </a>',
            'kd_produk'
        );
        return print_r($this->datatables->generate());
    }

    public function get_order_produk()
    {
        $kd_order = $this->input->post('kd_order');

        $this->datatables->select('produk.nm_produk, detail_order.berat_produk, detail_order.satuan_berat_produk, detail_order.harga_produk, detail_order.qty, detail_order.sub_total, CONCAT(detail_order.berat_produk, " ", detail_order.satuan_berat_produk) AS satuan_berat_produkk');
        $this->datatables->from('detail_order');
        $this->datatables->join('produk', 'detail_order.kd_produk=produk.kd_produk');
        $this->datatables->where(['kd_order' => $kd_order]);

        return print_r($this->datatables->generate());
    }

    public function getProductById()
    {
        $id = $this->input->post('kd_produk');

        $this->db->select("*");
        $this->db->from("produk");
        $this->db->where(['kd_produk' => $id]);
        $data = $this->db->get()->row_array();

        $this->session->set_userdata('kd_produk', $id);

        echo json_encode(['data' => $data]);
    }

    public function getGalleryById()
    {
        $id = $this->input->post('kd_produk');
        $data = $this->db->get_where('gallery_produk', ['kd_produk' => $id])->result_array();
        echo json_encode($data);
    }

    public function getDetailDataProduk($a = null)
    {

        if ($a == null) {
            $a = $this->input->post('kd_produk');
        }

        $this->db->select("*");
        $this->db->from("produk");
        $this->db->join("kategori", "produk.kd_kategori=kategori.kd_kategori");

        // $this->db->join("kalkulasi_harga", "kalkulasi_harga.kd_detail_produk=detail_produk.kd_detail_produk");
        // $this->input->post('tujuan') ini didapet pada saat scan barcode. ada di footer.php function scanDataQrCode

        $a == "detail" ? $this->db->where(['detail_produk.qr_detail_produk' => $this->input->post('tujuan'), 'is_detail_produk_aktif' => '1', 'is_detail_produk_hapus' => '1']) : $this->db->where(['produk.kd_produk' => $this->input->post('kd_produk'), 'is_detail_produk_aktif' => '1', 'is_detail_produk_hapus' => '1']);
        $a == "detail" ? "" : $this->db->group_by("detail_produk.kd_detail_produk");
        $a == "detail" ? $data = $this->db->get()->row_array() : $data = $this->db->get()->result_array();

        echo json_encode($data);
    }

    public function update_stok_produk()
    {
        $update_stok = $this->input->post('update_stok');
        $qty_stok = $this->input->post('qty_stok');

        for ($i = 0; $i < count($update_stok); $i++) {

            $detail = $this->db->get_where('detail_produk', ['kd_detail_produk' => $update_stok[$i]])->row_array();
            $data = [
                // 'stok' => $detail['stok'] + $qty_stok[$i],
                'stok' => $qty_stok[$i],
            ];

            $d = $this->db->update('detail_produk', $data, ['kd_detail_produk' => $update_stok[$i]]);
        }

        if ($d == TRUE) {
            $data = toast('success', 'Berhasil Edit Data Stok Produk!');
        } else {
            $data = toast('error', 'Gagal Edit Data Stok Produk!');
        }
        echo json_encode($data);
    }

    public function update_kat_produk()
    {
        $produk = $this->input->post('produk');
        $kategori = $this->input->post('kategori');

        for ($i = 0; $i < count($produk); $i++) {

            $detail = $this->db->get_where('detail_produk', ['kd_detail_produk' => $produk[$i]])->row_array();

            $data = [
                'kd_kategori' => $kategori,
            ];

            $d = $this->db->update('produk', $data, ['kd_produk' => $detail['kd_produk']]);
        }

        if ($d == TRUE) {
            $data = toast('success', 'Berhasil Edit Data Ketegori Menu!');
        } else {
            $data = toast('error', 'Gagal Edit Data Ketegori Menu!');
        }
        echo json_encode($data);
    }

    public function edit_product($id)
    {
        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['dataGallery'] = $this->db->get_where('gallery_produk', ['kd_produk' => $id])->result_array();
        $data['konfigurasi'] = $this->db->get('konfigurasi')->row_array();

        $this->db->select("*");
        $this->db->from("produk");
        $this->db->join("kategori", "kategori.kd_kategori=produk.kd_kategori");
        $this->db->join("sub_kategori", "sub_kategori.kd_sub_kategori=produk.kd_sub_kategori");
        $this->db->where(['produk.kd_produk' => $id]);
        $data['dataProduk'] = $this->db->get()->row_array();

        $data['judul'] = "Halaman Edit Produk";
        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/product/edit_product', $data);
        $this->load->view('base/footer');
    }

    public function update_product()
    {
        $upload_image = $_FILES['gambarfoto']['name'];

        $jumlah_berkas = count($_FILES['gallery']['name']) / 2;
        $ketfoto = $this->input->post('ketfoto');
        $exp1 = explode(",", $ketfoto);

        if ($jumlah_berkas) { // variabel true

            for ($i = 0; $i < $jumlah_berkas; $i++) {

                if ($_FILES['gallery']['name'][$i] != "") {
                    if (!empty($_FILES['gallery']['name'][$i])) {

                        // Define new $_FILES array - $_FILES['file']
                        $_FILES['file']['name'] = $_FILES['gallery']['name'][$i];
                        $_FILES['file']['type'] = $_FILES['gallery']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['gallery']['tmp_name'][$i];
                        $_FILES['file']['error'] = $_FILES['gallery']['error'][$i];
                        $_FILES['file']['size'] = $_FILES['gallery']['size'][$i];

                        // Set preference
                        $config1['upload_path'] = './assets/images/gallery_produk/';
                        $config1['allowed_types'] = 'jpg|jpeg|png|gif';
                        $config1['max_size'] = '5000'; // max_size in kb
                        $config1['file_name'] = $_FILES['gallery']['name'][$i];

                        //Load upload library
                        $this->load->library('upload', $config1);
                        $arr = array('msg' => 'something went wrong', 'success' => false);
                        // File upload
                        if ($this->upload->do_upload('file')) {

                            $data = array('upload_data' => $this->upload->data());
                            $path = $data['upload_data']['full_path'];
                            $q['name'] = $data['upload_data']['file_name'];

                            $configi['image_library'] = 'gd2';
                            $configi['source_image']   = $path;
                            $configi['maintain_ratio'] = FALSE;
                            $configi['width']  = 380;
                            $configi['height'] = 380;

                            $this->load->library('image_lib');
                            $this->image_lib->initialize($configi);
                            $this->image_lib->resize();

                            $dataGallery = [
                                'kd_produk' => $this->input->post('kd_produk'),
                                'foto'      => $q['name']
                            ];
                            $this->db->insert('gallery_produk', $dataGallery);
                        } else {
                            // echo $this->upload->display_errors();
                            $this->session->set_flashdata('error', 'Foto Tidak Berhasil Di Upload');
                            redirect(base_url('product/daftar_produk'));
                        }
                    }
                }
            }

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|jpeg|png|svg';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/images/gallery_produk/';

                $this->load->library('upload', $config);

                $data = $this->db->get_where('produk', ['kd_produk' => $this->input->post('kd_produk')])->row_array();

                if ($this->upload->do_upload('gambarfoto')) {

                    $gbr = $this->upload->data();

                    $configi['image_library'] = 'gd2';
                    $configi['source_image']   = './assets/images/gallery_produk/' . $gbr['file_name'];
                    $configi['maintain_ratio'] = FALSE;
                    $configi['width']  = 380;
                    $configi['height'] = 380;
                    $config['new_image'] = './assets/images/gallery_produk/' . $gbr['file_name'];

                    $this->load->library('image_lib');
                    $this->image_lib->initialize($configi);
                    $this->image_lib->resize();

                    $old_image = $data['foto_produk'];
                    if ($old_image != 'imagenotfound.jpg') {
                        unlink(FCPATH . '/assets/images/gallery_produk/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('foto_produk', $new_image);
                    $this->db->where(['kd_produk' => $this->input->post('kd_produk')]);
                    $this->db->update('produk');

                    $where = ['kd_gallery' => $this->input->post('kdDetailFotoUtama')];
                    $data = ['foto' => $new_image];
                    $this->db->update('gallery_produk', $data, $where);
                } else {
                    echo $this->upload->display_errors();
                }
            }
        }

        $where = ['kd_produk' => $this->input->post('kd_produk')];
        $dataProduk = [
            'nm_produk' => ucwords($this->input->post('nm_produk')),
            'kd_kategori' => $this->input->post('kategori'),
            'kd_sub_kategori' => $this->input->post('sub_kategori'),
            'deskripsi' => $this->input->post('deskripsi'),
            'harga' => $this->input->post('harga'),
            'min_order' => $this->input->post('min_order'),
            'is_produk_aktif' => $this->input->post('status'),
            'updated_at_admin'  => $this->session->userdata('kd_admin'),
            'updated_at'        => date('Y-m-d H:i:s', time()),
        ];
        $this->db->update('produk', $dataProduk, $where);

        if ($this->db->affected_rows() >= 0) {
            $data = toast('success', 'Berhasil Edit Data Produk!');
        } else {
            $data = toast('error', 'Gagal Edit Data Produk!');
        }
        echo json_encode($data);
    }

    public function convertRp($variabel)
    {
        $variabel = str_replace("Rp ", "", $variabel);
        if (strlen($variabel) > 3) {
            $variabel = str_replace(",", "", $variabel);
        }
        return $variabel;
    }

    public function hapus_galery_foto()
    {
        $id = $this->input->post('donatur_code_delete');

        $where = [
            'kd_gallery' => $id,
        ];

        $data = $this->db->get_where('gallery_produk', ['kd_gallery' => $id])->row_array();

        unlink(FCPATH . '/assets/images/gallery_produk/' . $data['foto']);

        $data = $this->db->delete('gallery_produk', $where);

        if ($this->db->affected_rows() > 0) {
            $data = toast('success', 'Berhasil Delete Gallery Produk!');
        } else {
            $data = toast('error', 'Gagal Delete Gallery Produk!');
        }
        echo json_encode($data);
    }

    public function productDetail($id = null)
    {
        $this->db->select('*');
        $this->db->from('produk');
        $this->db->where('produk.kd_produk', $id);
        $data['product'] = $this->db->get()->result_array();
        $data['judul'] = 'Detail Produk';

        $this->load->view('base-toko/header');
        $this->load->view('base-toko/navbar');
        $this->load->view('catering/detail_produk', $data);
        $this->load->view('base-toko/footer');
    }

    public function delete_product()
    {
        $id = $this->session->userdata('kd_produk');
        $data = $this->db->update('produk', ['is_produk_hapus' => '0', 'is_produk_aktif' => '0'], ['kd_produk' => $id]);

        if ($this->db->affected_rows() > 0) {
            $data = toast('success', 'Berhasil Delete Data Product!');
        } else {
            $data = toast('error', 'Gagal Delete Data Product!');
        }
        echo json_encode($data);
    }

    public function getDetailProductById()
    {
        $id = $this->input->post('id');
        $this->db->select('*');
        $this->db->from('detail_produk');
        $this->db->join('produk', 'produk.kd_produk=detail_produk.kd_produk');
        $this->db->where(['kd_detail_produk' => $id]);
        $data = $this->db->get()->row_array();
        echo json_encode($data);
    }

    public function get_json()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->ModelProduk->getProdukjson($searchTerm);

        echo json_encode($response);
    }

    public function get_json_jnsproduk()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');
        $kd_produk = $this->input->post('kd_produk');

        // Get users
        $response = $this->ModelProduk->getJnsProdukjson($searchTerm, $kd_produk);

        echo json_encode($response);
    }

    public function getDetailProductAll()
    {
        $this->db->select('*');
        $this->db->from('produk');
        $this->db->join('detail_produk', 'detail_produk.kd_produk=produk.kd_produk');
        $data = $this->db->get()->result_array();
        echo json_encode($data);
    }

    public function getDetailProductBySup()
    {
        $id = $this->input->post('kd_supplier');
        $this->db->select('*');
        $this->db->from('produk');
        $this->db->join('detail_produk', 'detail_produk.kd_produk=produk.kd_produk');
        $this->db->where('kd_supplier', $id);
        $data = $this->db->get()->result_array();
        echo json_encode($data);
    }

    public function getDetailProductByPro()
    {
        $id = $this->input->post('kd_produk');
        $data = $this->db->get_where('detail_produk', ['kd_produk' => $id, 'is_detail_produk_hapus' => 1])->result_array();
        echo json_encode($data);
    }

    public function get_json_prosup()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');
        $supplier = $this->input->post('supplier');

        // Get users
        $response = $this->ModelProduk->getProdukSupjson($searchTerm, $supplier);

        echo json_encode($response);
    }

    public function getProdukById()
    {
        $detail_produk = $this->input->post('kd_produk');

        $this->db->select('*');
        $this->db->from("produk");
        $this->db->join("detail_produk", "detail_produk.kd_produk=produk.kd_produk");
        $this->db->where('detail_produk.kd_detail_produk', $detail_produk);
        $data = $this->db->get()->row_array();

        echo json_encode($data);
    }
}
