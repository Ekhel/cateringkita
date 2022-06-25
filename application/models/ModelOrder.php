<?php
class ModelOrder extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getKecamatanjson($searchTerm = "", $kabupaten = "")
    {
        // Fetch users
        $this->db->select('*');
        $this->db->from("kecamatan");
        $this->db->where(['kabupaten' => $kabupaten]);
        $this->db->like("kecamatan", $searchTerm);
        $this->db->limit(20);
        $this->db->group_by('kecamatan', 'ASC');
        $fetched_records = $this->db->get('');
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['kecamatan'], "text" => $user['kecamatan']);
        }
        return $data;
    }
    
    public function getDaerahjson($searchTerm = "")
    {
        // Fetch users
        $this->db->select("concat(city, ' ', type) as id");
        $this->db->from("subdistricts");
        $this->db->like("city", $searchTerm);
        $this->db->limit(20);
        $this->db->group_by('id', 'ASC');
        $fetched_records = $this->db->get('');
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['id'], "text" => $user['id']);
        }
        return $data;
    }
    
    public function getKotajson($searchTerm = "")
    {
        // Fetch users
        $this->db->select('*');
        $this->db->from("kecamatan");
        $this->db->like("kabupaten", $searchTerm);
        $this->db->limit(20);
        $this->db->group_by('kabupaten', 'ASC');
        $fetched_records = $this->db->get('');
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['kabupaten'], "text" => $user['kabupaten']);
        }
        return $data;
    }
    
    public function getKelurahanjson($searchTerm = "", $kabupaten = "", $kecamatan = "")
    {
        // Fetch users
        $this->db->select('*');
        $this->db->from("kecamatan");
        $this->db->where(['kabupaten' => $kabupaten,'kecamatan' => $kecamatan]);
        $this->db->like("kelurahan", $searchTerm);
        $this->db->limit(20);
        $fetched_records = $this->db->get('');
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['kelurahan'], "text" => $user['kelurahan']);
        }
        return $data;
    }
}
