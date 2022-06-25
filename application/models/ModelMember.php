<?php
class ModelMember extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getMemberjson($searchTerm = "")
    {

        $searchTerm = replace_phone_number($searchTerm);

        $key = kunci();
        // Fetch users
        $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email");
        $this->db->from("member");
        $this->db->join("user_role", "member.kd_member=user_role.kd_user");
        $this->db->join("kecamatan", "member.kd_subdistricts=kecamatan.id");
        $this->db->where(["user_role.kd_role" => '3', 'member.is_member_aktif' => '1', 'member.is_member_hapus' => '1']);
        $this->db->having("member.nm_member LIKE '%$searchTerm%' ");
        $this->db->or_having("no_telp LIKE '%$searchTerm%' ");
        $this->db->group_by("member.kd_member", "ASC");
        $fetched_records = $this->db->get('');
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $this->db->select("*,CAST(AES_DECRYPT(no_telp, '$key') AS CHAR(50)) no_telp,CAST(AES_DECRYPT(email, '$key') AS CHAR(50)) email");
            $this->db->from("cek_reseller_utama");
            $this->db->join("reseller", "cek_reseller_utama.kd_reseller=reseller.kd_reseller");
            $this->db->where(['kd_member' => $user['kd_member'], 'is_reseller_utama_hapus' => 1]);
            $member = $this->db->get()->row_array();
            if (!empty($member['kd_member'])) {
                $res = "   (Reseller : " . $member['nm_reseller'] . ")";
            } else {
                $res = "";
            }
            $data[] = array("id" => $user['kd_member'], "text" => $user['nm_member'] . ' - ' . $user['no_telp'] . $res, "nama" => $user['nm_member'], "no_telp" => $user['no_telp'], "email" => $user['email'], "alamat" => $user['alamat'], "kodepos" => $user['kodepos'], "kecamatan" => $user['kd_subdistricts'], "kec_text" =>  $user['provinsi'] . ', ' . $user['kabupaten'] . ', ' . $user['kecamatan'] . ', ' . $user['kelurahan'] . ', ' . $user['kodepos'], "kecamatan" => $user['kd_subdistricts'], "kec_text" =>  $user['provinsi'] . ', ' . $user['kabupaten'] . ', ' . $user['kecamatan'] . ', ' . $user['kelurahan'] . ', ' . $user['kodepos'], "alamat_ongkir" => $user['alamat_untuk_ongkir'], "jarak" => $user['jarak'], "lat_alamat" => $user['lat_alamat'], "lon_alamat" => $user['lon_alamat'], "subregion" => $user['subregion'], "city" => $user['city'], "nbrhd" => $user['nbrhd']);
        }
        return $data;
    }
}
