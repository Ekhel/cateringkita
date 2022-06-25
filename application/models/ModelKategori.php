<?php
class ModelKategori extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getKategorijson($searchTerm = "")
    {
        // Fetch users
        $this->db->select('*');
        $this->db->like("nm_kategori", $searchTerm);
        $fetched_records = $this->db->get('kategori');
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['kd_kategori'], "text" => $user['nm_kategori']);
        }
        return $data;
    }

    public function getSubKategorijson($searchTerm = "", $kd_kategori = "")
    {
        // Fetch users
        $this->db->select('*');
        $this->db->where("kd_kategori = '" . $kd_kategori . "' AND nm_sub_kategori like '%" . $searchTerm . "%' ");
        $fetched_records = $this->db->get('sub_kategori');
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['kd_sub_kategori'], "text" => $user['nm_sub_kategori']);
        }
        return $data;
    }

    public function getmultisubkategorijson($searchTerm = "", $kategori = "")
    {
        // Fetch users
        $this->db->select('*');
        $this->db->from("kategori");
        $this->db->join("sub_kategori", "kategori.kd_kategori=sub_kategori.kd_kategori");
        $this->db->where(['kategori.kd_kategori' => $kategori]);
        $this->db->like("kd_sub_kategori", $searchTerm);
        $this->db->limit(20);
        $fetched_records = $this->db->get('');
        $users = $fetched_records->result_array();

        // Initialize Array with fetched data
        $data = array();
        foreach ($users as $user) {
            $data[] = array("id" => $user['nm_sub_kategori'], "text" => $user['nm_sub_kategori']);
        }
        return $data;
    }
}
