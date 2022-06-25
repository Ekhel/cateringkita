<?php
class ModelAdmin extends CI_Model
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
        if ($tabel == "barang_primary" || $tabel == "barang_secondary") {
            $sql = $this->db->query($query . " where LEFT(kd_barang, 3) = '$kode' ORDER BY kd_barang DESC ")->result_array();
        } else if ($tabel == "detail_barang") {
            $sql = $this->db->query($query . " where LEFT(kd_alokasi, 3) = '$kode' ORDER BY kd_alokasi DESC ")->result_array();
        } else {
            $sql = $this->db->query($query . " where LEFT(kd_$tabel, 3) = '$kode' ORDER BY kd_$tabel DESC ")->result_array();
        }
        $kode = $kode;

        if ($sql != Null) {
            if ($tabel == "barang_primary" || $tabel == "barang_secondary") {
                $pisah = explode("-", $sql[0]["kd_barang"]);
            } else if ($tabel == "detail_barang") {
                $pisah = explode("-", $sql[0]["kd_alokasi"]);
            } else {
                $pisah = explode("-", $sql[0]["kd_" . $tabel]);
            }

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
}
