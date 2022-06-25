<?php
function format_hari_tanggal($waktu, $param = null)
{
    $hari_array = array(
        'Minggu',
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu'
    );
    $hr = date('w', strtotime($waktu));
    $hari = $hari_array[$hr];
    $tanggal = date('j', strtotime($waktu));
    $bulan_array = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    );
    $bl = date('n', strtotime($waktu));
    $bulan = $bulan_array[$bl];
    $tahun = date('Y', strtotime($waktu));
    $jam = date('H:i:s', strtotime($waktu));


    if ($param == "jam") {
        return "$hari, $tanggal $bulan $tahun $jam";
        //nampilin format tanggal dgn jam
    } else if ($param == "hari") {
        return "$hari";
    } else {
        //nampilin format tanggal saja
        return "$hari, $tanggal $bulan $tahun";
    }
}

function format_rupiah($angka)
{
    $hasil_rupiah = "Rp. " . number_format($angka, 0, ',', ',');
    return $hasil_rupiah;
}

function nama_bulan($bulan)
{
    $bulan_array = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    );

    $bulan = $bulan_array[$bulan];

    return $bulan;
}

function getnamecustom($kd_custom)
{
    if ($kd_custom) {
        $CI = &get_instance();
        $custom = $CI->db->get_where('custom', ['kd_custom' => $kd_custom])->row_array();
        if ($custom) {
            return $custom['nm_custom'];
        } else {
            return "";
        }
    } else {
        return "";
    }
}

function gethargacustom($kd_custom)
{
    if ($kd_custom) {
        $CI = &get_instance();
        $custom = $CI->db->get_where('custom', ['kd_custom' => $kd_custom])->row_array();
        if ($custom) {
            return $custom['harga_custom'];
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}
