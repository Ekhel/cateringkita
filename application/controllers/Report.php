<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (empty($this->session->userdata('kd_role'))) {
            $this->session->set_flashdata('error', 'Anda Belum Login, Login Terlebih Dahulu!');
            redirect('admin');
        }
    }

    public function excel_alignment()
    {
        $style = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                // 'textRotation' => 0,
                // 'wrapText' => TRUE
            ],

        ];

        return $style;
    }

    public function excel_border()
    {
        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000'],
                ],
            ],
        ];
        return $styleBorder;
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

    //order

    public function order()
    {
        $bulan = $this->input->post('bulan');
        $tahun1 = $this->input->post('tahun1');
        $tahun2 = $this->input->post('tahun2');
        $jenis_report = $this->input->post('jenis_report');
        $data['judul'] = "Halaman Report Order";
        $this->db->select('*');
        $this->db->from('order');

        if ($jenis_report != null) {
            if ($jenis_report == "tahun") {
                $data['thn'] = $tahun2;
                $data['bulan'] = 0;

                $this->db->where(['YEAR(created_at)' => $tahun2, 'order_status' => 'done']);
            } else if ($jenis_report == "bulan") {
                $data['thn'] = $tahun1;
                $data['bulan'] = $bulan;

                $this->db->where(['MONTH(created_at)' => $bulan, 'YEAR(created_at)' => $tahun1, 'order_status' => 'done']);
            }
        } else {
            $data['thn'] = 0;
            $data['bulan'] = 0;

            $this->db->where(['order_status' => 'done']);
        }


        $query = $this->db->get();

        $data['order'] = $query->result_array();
        if (count($data['order']) == 0 && $data['thn'] != 0) {
            $this->session->set_flashdata('error', 'Data Tidak Ditemukan');
        }
        $data['dataTampunganRole'] = $this->_cek_hak_akses();
        $data['admin'] = $this->db->get_where('admin', ['kd_admin' => $this->session->userdata('kd_admin')])->row_array();

        $this->load->view('base/header', $data);
        $this->load->view('base/sidebar');
        $this->load->view('base/navbar');
        $this->load->view('admin/report/order', $data);
        $this->load->view('base/footer');
    }

    public function get_order_detail()
    {
        $id = $this->input->post('id');
        $this->db->select("*, detail_order.qty as qtyy");
        $this->db->from("detail_order");
        $this->db->where(['kd_order' => $id]);
        $data = $this->db->get()->result_array();

        echo json_encode($data);
    }

    public function print_order($id, $bulan, $tahun, $status, $bayar, $tgl, $pembayaran)
    {
        $admin = $this->db->get_where('admin', ['kd_admin' => $this->session->userdata('kd_admin')])->row_array();

        $this->db->select('*');
        $this->db->from('order');
        if ($bulan != "0") {
            $this->db->where('MONTH(tgl_order)', $bulan);
        }
        if ($tahun != "0") {
            $this->db->where('YEAR(tgl_order)', $tahun);
        }
        if ($status != "0") {
            $this->db->where('order_status', $status);
        }
        if ($bayar != "0") {
            $this->db->where('payment_status', $bayar);
        }
        if ($tgl != "0") {
            $this->db->where('tgl_order', $tgl);
        }
        if ($pembayaran != "-") {
            $this->db->where('order.payment_status', $pembayaran);
        }

        $this->db->order_by('order.tgl_order', 'ASC');

        $data['order'] = $this->db->get()->result_array();
        $data['judul'] = "Report Order";
        $data['no'] = $id;
        $data['dataTampunganRole'] = $this->_cek_hak_akses();

        $this->load->view('admin/report/print_order', $data);
    }

    public function pdf_order($id, $bulan, $tahun, $status, $bayar, $tgl, $pembayaran)
    {
        $admin = $this->db->get_where('admin', ['kd_admin' => $this->session->userdata('kd_admin')])->row_array();

        $this->db->select('*');
        $this->db->from('order');
        if ($bulan != "0") {
            $this->db->where('MONTH(tgl_order)', $bulan);
        }
        if ($tahun != "0") {
            $this->db->where('YEAR(tgl_order)', $tahun);
        }
        if ($status != "0") {
            $this->db->where('order_status', $status);
        }
        if ($bayar != "0") {
            $this->db->where('payment_status', $bayar);
        }
        if ($tgl != "0") {
            $this->db->where('tgl_order', $tgl);
        }
        if ($pembayaran != "-") {
            $this->db->where('order.payment_status', $pembayaran);
        }

        $this->db->order_by('order.tgl_order', 'ASC');

        $data['order'] = $this->db->get()->result_array();
        $data['judul'] = "Report Order";
        $data['no'] = $id;
        $data['dataTampunganRole'] = $this->_cek_hak_akses();

        $this->load->library('pdf');

        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->atch = array("Attachment" => FALSE);
        $this->pdf->filename = "laporan-Report-Order.pdf";
        $this->pdf->load_view('admin/report/pdf_order', $data);
    }

    public function selectOrderUser($bulan = "0", $tahun = "0", $status = "0", $bayar = "0", $tgl = "0", $pembayaran = "-", $statuss = null)
    {
        $this->db->select("*, detail_order.harga_produk as hrg_produk");
        $this->db->from('order');
        $this->db->join('detail_order', 'order.kd_order=detail_order.kd_order');

        if ($bulan != "0") {
            $this->db->where('MONTH(order.tgl_order)', $bulan);
        }
        if ($tahun != "0") {
            $this->db->where('YEAR(order.tgl_order)', $tahun);
        }
        if ($status != "0") {
            $this->db->where('order_status', $status);
        }
        if ($bayar != "0") {
            $this->db->where('payment_status', $bayar);
        }
        if ($tgl != "0") {
            $this->db->where('order.tgl_order', $tgl);
        }
        if ($pembayaran != "-") {
            $this->db->where('order.payment_status', $pembayaran);
        }

        $this->db->order_by("order.tgl_order ASC, order.kd_order ASC");

        if ($statuss == "group") {
            $this->db->group_by('order.kd_order');
        }
        return $this->db->get()->result_array();
    }

    public function excel_order($bulan, $tahun, $status, $bayar, $tgl, $pembayaran)
    {
        $key = kunci();
        $tgx = $tgl;

        $no = 0;

        $spreadsheet = new Spreadsheet;
        $writer = new Xlsx($spreadsheet);

        $orderr = $this->selectOrderUser($bulan, $tahun, $status, $bayar, $tgx, $pembayaran);
        $spreadsheet->setActiveSheetIndex($no)
            ->setCellValue('B4', 'Nomor')
            ->setCellValue('C4', 'Tanggal')
            ->setCellValue('D4', 'No. Invoice')
            ->setCellValue('E4', 'Kode Detail Order')
            ->setCellValue('F4', 'Customer')
            ->setCellValue('G4', 'No. Telepon')
            ->setCellValue('H4', 'Alamat')
            ->setCellValue('I4', 'Kode Menu')
            ->setCellValue('J4', 'Produk Pesanan')
            ->setCellValue('K4', 'Harga Per Item')
            ->setCellValue('L4', 'Qty')
            ->setCellValue('M4', 'Total')
            ->setCellValue('N4', 'Total Pembayaran Langsung')
            ->setCellValue('O4', 'Total Pembayaran TF')
            ->setCellValue('P4', 'Metode Pembayaran')
            ->setCellValue('Q4', 'Status Pembayaran');

        $abjad = ['B', 'C', 'D', 'E', 'F', 'G', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q'];

        foreach ($abjad as $ab) {
            $spreadsheet->getActiveSheet()->getStyle($ab . "4:" . $ab . "4")->applyFromArray($this->excel_alignment());
            $spreadsheet->getActiveSheet()->getColumnDimension($ab)->setAutoSize(true);
        }

        $kolom = 5;
        $nomor = 1;
        $jml_qty = [];
        $jml_total = [];
        $jml_bayar_langsung = [];
        $jml_bayar_tf = [];
        $cekKodeYgSama = [];
        $cekTotalTransaksi = [];

        foreach ($orderr as $order) {

            if ($order['payment_type'] == "ambil_langsung") {
                $payment_type = "Tunai";
            } else if ($order['payment_type'] == "cod") {
                $payment_type = "COD";
            } else if ($order['payment_type'] == "transfer") {
                $payment_type = "TRANSFER";
            } else if ($order['payment_type'] == "kredit") {
                $payment_type = "Kredit";
            }

            if ($order['kd_member'] != "#") {
                $this->db->select("*,CAST(AES_DECRYPT(member.no_telp, '$key') AS CHAR(50)) no_telp");
                $this->db->from("member");
                $this->db->where(['kd_member' => $order['kd_member']]);
                $member = $this->db->get_where()->row_array();
            } else {
                $member['nm_member'] = "Tidak Memilih Pelanggan";
                $member['no_telp']   = "-";
                $member['alamat']    = "-";
            }

            if (substr($order['kd_produk'], 0, 2) == "PS") {
                $this->db->select("*");
                $this->db->from("produk");
                $this->db->where(['kd_produk' => $order['kd_produk']]);
            }
            $produk = $this->db->get()->row_array();
            $test = "";

            if ($produk) {
                array_push($jml_qty, $order['qty']);
                array_push($jml_total, $order['harga_produk'] * $order['qty']);

                if (in_array($order['kd_order'], $cekKodeYgSama)) {
                    $totalll = $order['hrg_produk'] * $order['qty'];
                    $order['kd_order'] = "";
                    $order['total_transfer'] = "";
                    $member['no_telp'] = "";
                    $member['alamat'] = "";
                } else {
                    $totalll = $order['hrg_produk'] * $order['qty'];
                }

                array_push($cekKodeYgSama, $order['kd_order']);
                if ($order['kd_order'] != "") {
                    array_push($cekTotalTransaksi, $order['kd_order']);
                }


                $spreadsheet->getActiveSheet()->getStyle('L' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('N' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('O' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('P' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('Q' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('R' . $kolom)->getNumberFormat()->setFormatCode('#,##0');
                $spreadsheet->getActiveSheet()->getStyle('S' . $kolom)->getNumberFormat()->setFormatCode('#,##0');

                $spreadsheet->setActiveSheetIndex($no)
                    ->setCellValue('B' . $kolom, $nomor)
                    ->setCellValue('C' . $kolom, format_hari_tanggal($order['tgl_order'], "hari"))
                    ->setCellValue('D' . $kolom, $order['kd_order'])
                    ->setCellValue('E' . $kolom, $order['kd_detail_order'])
                    ->setCellValue('F' . $kolom, $member['nm_member'])
                    ->setCellValue('G' . $kolom, (string) $member['no_telp'])
                    ->setCellValue('H' . $kolom, strip_tags(decrypt($member['alamat'])))
                    ->setCellValue('I' . $kolom, $order['kd_produk'])
                    ->setCellValue('J' . $kolom, $produk['nm_produk'])
                    ->setCellValue('K' . $kolom, $order['hrg_produk'])
                    ->setCellValue('L' . $kolom, $order['qty'])
                    ->setCellValue('M' . $kolom, $order['hrg_produk'] * $order['qty']);

                if ($payment_type == "TRANSFER") {
                    $order_langsung = "";
                    $order_tf = $totalll;
                } else {
                    $order_tf = "";
                    $order_langsung = $totalll;
                }
                $payment_status = $order['payment_status'] == "1" ? "Sudah Bayar" : "Belum Bayar";

                $spreadsheet->setActiveSheetIndex($no)
                    ->setCellValue('N' . $kolom, $order_langsung)
                    ->setCellValue('O' . $kolom, $order_tf);
                $spreadsheet->setActiveSheetIndex($no)
                    ->setCellValue('P' . $kolom, $payment_type)
                    ->setCellValue('Q' . $kolom, $payment_status);

                if ($totalll == "") {
                    $totalll = 0;
                }

                if ($payment_type == "TRANSFER") {
                    $order_langsung = 0;
                } else {
                    $order_tf = 0;
                }

                array_push($jml_bayar_langsung, $order_langsung);
                array_push($jml_bayar_tf, $order_tf);

                $kolom++;
                $nomor++;
            }
        }

        $abjad = ['D', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U'];
        foreach ($abjad as $abj) {
            $spreadsheet->getActiveSheet()->getStyle($abj . '2')->getNumberFormat()->setFormatCode('#,##0');
        }

        $spreadsheet->setActiveSheetIndex($no)->setCellValue('D2', count($cekTotalTransaksi) . " Transaksi");
        $spreadsheet->setActiveSheetIndex($no)->setCellValue('D2', count($cekTotalTransaksi) . " Transaksi");
        $spreadsheet->setActiveSheetIndex($no)->setCellValue('L2', array_sum($jml_qty));
        $spreadsheet->setActiveSheetIndex($no)->setCellValue('M2', array_sum($jml_total));
        $spreadsheet->setActiveSheetIndex($no)->setCellValue('N2', array_sum($jml_bayar_langsung));
        $spreadsheet->setActiveSheetIndex($no)->setCellValue('O2', array_sum($jml_bayar_tf));

        $spreadsheet->getActiveSheet()->getStyle("B4:Q" . $kolom)->applyFromArray($this->excel_border());
        $spreadsheet->getActiveSheet()->getStyle("B2:B" . $kolom)->applyFromArray($this->excel_alignment());

        $spreadsheet->getActiveSheet()->setTitle("Report Order");

        $spreadsheet->createSheet();
        $no++;



        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Transaksi-' . date('ymdhis') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
