<?php
class Select2 extends CI_Controller
{
    public function get_json_member()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->ModelMember->getMemberjson($searchTerm);

        echo json_encode($response);
    }

    public function get_json_member_res_new()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');
        $reseller = $this->input->post('reseller');
        $key = kunci();

        // Get users where reseller

        $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email");
        $this->db->from("member");
        $this->db->join("user_role", "member.kd_member=user_role.kd_user");
        $this->db->join("kecamatan", "member.kd_subdistricts=kecamatan.id");
        $this->db->join("cek_reseller_utama", "cek_reseller_utama.kd_member=member.kd_member");
        $this->db->where(["user_role.kd_role" => '3', 'member.is_member_aktif' => '1', 'member.is_member_hapus' => '1', 'cek_reseller_utama.kd_reseller' => $reseller]);
        $this->db->having("member.nm_member LIKE '%$searchTerm%' ");
        $this->db->or_having("no_telp LIKE '%$searchTerm%' ");
        $this->db->group_by("member.kd_member", "ASC");
        $fetched_records = $this->db->get('');
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['nm_member'], "text" => $user['nm_member'] . ' - ' . $user['no_telp'], "nama" => $user['nm_member'], "no_telp" => $user['no_telp'], "email" => $user['email'], "alamat" => $user['alamat'], "kodepos" => $user['kodepos'], "kecamatan" => $user['kd_subdistricts'], "kec_text" =>  $user['provinsi'] . ', ' . $user['kabupaten'] . ', ' . $user['kecamatan'] . ', ' . $user['kelurahan'] . ', ' . $user['kodepos']);
        }

        echo json_encode($data);
    }

    public function get_json_member_res()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');
        $reseller = $this->input->post('reseller');
        $key = kunci();

        // Get users where reseller

        $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email");
        $this->db->from("member");
        $this->db->join("user_role", "member.kd_member=user_role.kd_user");
        $this->db->join("kecamatan", "member.kd_subdistricts=kecamatan.id");
        $this->db->join("cek_reseller_utama", "cek_reseller_utama.kd_member=member.kd_member");
        $this->db->where(["user_role.kd_role" => '3', 'member.is_member_aktif' => '1', 'member.is_member_hapus' => '1', 'cek_reseller_utama.kd_reseller' => $reseller]);
        $this->db->having("member.nm_member LIKE '%$searchTerm%' ");
        $this->db->or_having("no_telp LIKE '%$searchTerm%' ");
        $this->db->group_by("member.kd_member", "ASC");
        $fetched_records = $this->db->get('');
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['kd_member'], "text" => $user['nm_member'] . ' - ' . $user['no_telp'], "nama" => $user['nm_member'], "no_telp" => $user['no_telp'], "email" => $user['email'], "alamat" => $user['alamat'], "kodepos" => $user['kodepos'], "kecamatan" => $user['kd_subdistricts'], "kec_text" =>  $user['provinsi'] . ', ' . $user['kabupaten'] . ', ' . $user['kecamatan'] . ', ' . $user['kelurahan'] . ', ' . $user['kodepos'], "alamat_ongkir" => $user['alamat_untuk_ongkir'], "jarak" => $user['jarak'], "lat_alamat" => $user['lat_alamat'], "lon_alamat" => $user['lon_alamat'], "subregion" => $user['subregion'], "city" => $user['city'], "nbrhd" => $user['nbrhd']);
        }

        echo json_encode($data);
    }

    public function get_json_stok_produk()
    {
        $searchTerm = $this->input->post('searchTerm');
        $lokasi = $this->input->post('lokasi');

        $this->db->select('stok_produk.kd_detail_produk, nm_produk, berat, satuan_berat, lokasi, sum(stok_produk.stok) as stok');
        $this->db->from('stok_produk');
        $this->db->join('detail_produk', 'detail_produk.kd_detail_produk=stok_produk.kd_detail_produk');
        $this->db->join('produk', 'produk.kd_produk=detail_produk.kd_produk');
        $this->db->where(['lokasi' => $lokasi]);
        $this->db->like("produk.nm_produk", $searchTerm);
        $this->db->group_by("stok_produk.kd_detail_produk");
        $fetched_records = $this->db->get('');
        $users = $fetched_records->result_array();

        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['kd_detail_produk'], "text" => $user['nm_produk'] . " - " . $user['berat'] . " " . $user['satuan_berat'], "stok" => $user['stok']);
        }
        echo json_encode($data);
    }

    public function get_json_detail_produk()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->ModelProduk->getDetailProdukjson($searchTerm);

        echo json_encode($response);
    }

    public function get_json_detail_produk_paket()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->ModelProduk->getDetailProdukBonusjson($searchTerm);

        echo json_encode($response);
    }

    public function get_json_detail_produk_bonus()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->ModelProduk->getDetailProdukBonusjson($searchTerm);

        echo json_encode($response);
    }

    public function get_json_detail_produkpo()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->ModelProduk->getDetailProdukPojson($searchTerm);

        echo json_encode($response);
    }

    public function get_json_produk()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->ModelProduk->getProdukjson($searchTerm);

        echo json_encode($response);
    }

    public function get_json_produk_paket()
    {
        // Search term
        $searchTerm = $this->input->post('searchTerm');

        // Get users
        $response = $this->ModelProduk->getProdukPaketjson($searchTerm);

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

    public function cekStokProductPromo()
    {
        $kd_promo = $this->input->post('kd_promo');

        $data = $this->db->get_where('promo', ['kd_promo' => $kd_promo])->row_array();

        echo json_encode($data['stok_paket']);
    }

    public function cekStokProduct()
    {
        $kd_detail_produk = $this->input->post('kd_detail_produk');

        $data = $this->db->get_where('detail_produk', ['kd_detail_produk' => $kd_detail_produk])->row_array();

        echo json_encode($data['stok']);
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
}
