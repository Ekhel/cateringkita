<?php
class ModelProduk extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    // function getUserCustomMenu() {
    //     this->db->select('*');
    //     $this->db->from('produk');
    //     $this->db->where(['kd_kategori' => $kat1['kd_kategori']]);
    //     $this->db->where(['created_at_admin' => $this->session->userdata('kd_member')]);
    //     $this->db->where(['is_produk_hapus' => 1]);
    //     $data = $this->db->get();
    // }

    public function getProdukjson($searchTerm = "")
    {
        // Fetch users
        $this->db->select('kd_detail_produk,nm_produk,harga_produk,berat,satuan_berat,produk.kd_produk,diskon,jns_komisi,nominal_komisi, nominal_komisi as date_start, nominal_komisi as time_start, nominal_komisi as time_end, nominal_komisi as date_end');
        $this->db->from("produk");
        $this->db->join("detail_produk", "produk.kd_produk=detail_produk.kd_produk");
        $this->db->where(["is_produk_aktif" => '1', "is_produk_hapus" => '1', "is_detail_produk_aktif" => '1', "is_detail_produk_hapus" => '1']);
        $this->db->like("produk.nm_produk", $searchTerm);
        $query1 = $this->db->get_compiled_select();

        $this->db->select('kd_promo as kd_detail_produk, nama_promo as nm_produk, harga_hasil_promo as harga_produk, date_start as berat, date_start as satuan_berat, date_start as kd_produk, date_start as diskon, date_start as jns_komisi, date_start as nominal_komisi, date_start, time_start,time_end, date_end');
        $this->db->from("promo");
        $this->db->where(["type_promo" => 'paket', 'is_promo_aktif' => '1', 'is_promo_hapus' => '1']);
        $this->db->like("nama_promo", $searchTerm);
        $query2 = $this->db->get_compiled_select();

        $users = $this->db->query($query1 . ' UNION ' . $query2)->result_array();

        $data = array();
        foreach ($users as $user) {
            if (substr($user['kd_produk'], 0, 2) == "PS") {
                // Initialize Array with fetched data
                $data[] = array("id" => $user['kd_detail_produk'], "text" => $user['nm_produk'] . " - " . $user['berat'] . " " . $user['satuan_berat'], "kd_produk" => $user['kd_produk'], "diskon" => $user['diskon'], "harga" => $user['harga_produk'], "komisi" => $user['jns_komisi'], "jmlKomisi" => $user['nominal_komisi']);
            } else {

                // Initialize Array with fetched data

                $now = time();
                $promo_start = strtotime($user['date_start'] . " " . $user['time_start']);
                $promo_end = strtotime($user['date_end'] . " " . $user['time_end']);

                if (!($now < $promo_start || $now > $promo_end)) {
                    $data[] = array("id" => $user['kd_detail_produk'], "text" => $user['nm_produk'], "kd_produk" => $user['kd_produk'], "diskon" => $user['diskon'], "harga" => $user['harga_produk'], "komisi" => $user['jns_komisi'], "jmlKomisi" => $user['nominal_komisi']);
                }
            }
        }
        return $data;
    }

    public function getProdukSupjson($searchTerm = "", $supplier = "")
    {
        // Fetch users
        $this->db->select('*');
        $this->db->from("produk");
        $this->db->join("detail_produk", "produk.kd_produk=detail_produk.kd_produk");
        $this->db->where(["is_produk_aktif" => '1', "is_produk_hapus" => '1', 'kd_supplier' => $supplier]);
        $this->db->like("produk.nm_produk", $searchTerm);
        $users = $this->db->get()->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['kd_detail_produk'], "text" => $user['nm_produk'] . " - " . $user['berat'] . " " . $user['satuan_berat'], "kd_produk" => $user['kd_produk'], "diskon" => $user['diskon'], "harga" => $user['harga_produk'], "komisi" => $user['jns_komisi'], "jmlKomisi" => $user['nominal_komisi']);
        }
        return $data;
    }

    public function getJnsProdukjson($searchTerm = "", $kd_produk = "")
    {
        // Fetch users
        $this->db->select('*');
        $this->db->where(["kd_produk" => $kd_produk]);
        $this->db->where(["is_detail_produk_hapus" => 1]);
        $this->db->like("detail_produk.berat", $searchTerm);
        $fetched_records = $this->db->get('detail_produk');
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['kd_detail_produk'], "text" => $user['berat'] . " " . $user['satuan_berat'], "diskon" => $user['diskon'], "harga" => $user['harga_produk'], "komisi" => $user['jns_komisi'], "jmlKomisi" => $user['nominal_komisi']);
        }
        return $data;
    }

    public function getProdukPaketjson($searchTerm = "")
    {
        // Fetch users
        $this->db->select('*');
        $this->db->where(["type_promo" => 'paket', 'is_promo_aktif' => '1', 'is_promo_hapus' => '1']);
        $this->db->like("nama_promo", $searchTerm);
        $fetched_records = $this->db->get('promo');
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();

        foreach ($users as $user) {
            $now = time();
            $promo_start = strtotime($user['date_start'] . " " . $user['time_start']);
            $promo_end = strtotime($user['date_end'] . " " . $user['time_end']);

            if (!($now < $promo_start || $now > $promo_end)) {
                $data[] = array("id" => $user['kd_promo'], "text" => $user['nama_promo'], "harga_promo" => $user['harga_hasil_promo']);
            }
        }
        return $data;
    }

    public function getDetailProdukjson($searchTerm = "")
    {
        // Fetch users
        $this->db->select('*');
        $this->db->from('detail_produk');
        $this->db->join('produk', 'produk.kd_produk = detail_produk.kd_produk');
        $this->db->where(["is_detail_produk_hapus" => 1]);
        $this->db->like("produk.nm_produk", $searchTerm);
        $fetched_records = $this->db->get();
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $this->db->select("*");
            $this->db->from("promo");
            $this->db->join("detail_promo", "promo.kd_promo=detail_promo.kd_promo");
            $this->db->where(['kd_detail_produk' => $user['kd_detail_produk'], 'is_promo_aktif' => '1', 'is_promo_hapus' => '1']);
            $member = $this->db->get()->row_array();
            if (!empty($member['kd_promo'])) {
                $res = "   (Promo : " . $member['nama_promo'] . ")";
            } else {
                $res = "";
            }
            $data[] = array("id" => $user['kd_detail_produk'], "text" => $user['nm_produk'] . " - " . $user['berat'] . " " . $user['satuan_berat'] . $res, "diskon" => $user['diskon'], "harga" => $user['harga_produk'], "komisi" => $user['jns_komisi'], "jmlKomisi" => $user['nominal_komisi'], "jmlKomisiSelera" => $user['nominal_komisi_selera']);
        }
        return $data;
    }

    public function getDetailProdukBonusjson($searchTerm = "")
    {
        // Fetch users
        $this->db->select('*');
        $this->db->from('detail_produk');
        $this->db->join('produk', 'produk.kd_produk = detail_produk.kd_produk');
        $this->db->where(["is_detail_produk_hapus" => 1]);
        $this->db->like("produk.nm_produk", $searchTerm);
        $fetched_records = $this->db->get();
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $this->db->select("*");
            $this->db->from("promo");
            $this->db->join("detail_promo", "promo.kd_promo=detail_promo.kd_promo");
            $this->db->where(['kd_detail_produk' => $user['kd_detail_produk']]);
            $member = $this->db->get()->row_array();
            if (!empty($member['kd_promo'])) {
                $res = "   (Promo : " . $member['nama_promo'] . ")";
            } else {
                $res = "";
            }
            $data[] = array("id" => $user['kd_detail_produk'], "text" => $user['nm_produk'] . " - " . $user['berat'] . " " . $user['satuan_berat'] . $res);
        }
        return $data;
    }

    public function getDetailProdukPojson($searchTerm = "")
    {
        // Fetch users
        $this->db->select('*');
        $this->db->from('detail_produk');
        $this->db->join('produk', 'produk.kd_produk = detail_produk.kd_produk');
        $this->db->where(["is_produk_aktif" => 1, "is_produk_hapus" => 1]);
        $this->db->like("produk.nm_produk", $searchTerm);
        $fetched_records = $this->db->get();
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $this->db->select("*");
            $this->db->from("pre_order");
            $this->db->join("detail_pre_order", "pre_order.kd_pre_order=detail_pre_order.kd_pre_order");
            $this->db->where(['kd_detail_produk' => $user['kd_detail_produk']]);
            $member = $this->db->get()->row_array();
            if (!empty($member['kd_pre_order'])) {
                $res = "   (Pre Order : " . format_hari_tanggal($member['date_start']) . " - " . format_hari_tanggal($member['date_end']) . ")";
            } else {
                $res = "";
            }
            $data[] = array("id" => $user['kd_detail_produk'], "text" => $user['nm_produk'] . " - " . $user['berat'] . " " . $user['satuan_berat'] . $res, "diskon" => $user['diskon'], "harga" => $user['harga_produk'], "komisi" => $user['jns_komisi'], "jmlKomisi" => $user['nominal_komisi']);
        }
        return $data;
    }
}
