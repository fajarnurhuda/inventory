<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
require_once APPPATH . 'third_party/Spout/src/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;


class Import extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!isset($this->session->userdata['username'])) {
            $this->session->set_flashdata('Pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><small> Anda Belum Login! (Silahkan Login untuk mengakses halaman yang akan dituju!)</small> <button type="button" class="close" data-dismiss="alert" aria-label="Close" <span aria-hidden="true">&times;</span> </button> </div>');
            redirect('auth');
        }

        if ($this->session->userdata['level']  != 'admin') {
            redirect('dashboard');
        }
        $this->load->model('MImport');
    }

    // code ini tidak di pakai
    public function masukku()
    {
        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'xlsx|xls';
        $config['file_name'] = 'Upload masuk' . time();
        $config['max_size']     = '2048';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('import_masuk')) {
            $file = $this->upload->data();
            $reader = ReaderEntityFactory::createXLSXReader();
            $reader->setShouldFormatDates(true);
            $reader->open('upload/' . $file['file_name']);
            foreach ($reader->getSheetIterator() as $sheet) {
                $numRow = 1;
                $date = date("Y-m-d H:i:s");
                foreach ($sheet->getRowIterator() as $row) {
                    if ($numRow > 1) {
                        $databarang = array(
                            'tanggal' =>  date('Y-m-d', strtotime($row->getCellAtIndex(1))),
                            'id_ukuran' => $row->getCellAtIndex(4),
                            'karyawan' => $this->session->userdata['username'],
                            'jumlah_masuk' => $row->getCellAtIndex(5),
                            'ket_masuk' => $row->getCellAtIndex(6),
                            'edit' => $date,
                            'admin' => $this->session->userdata['username'],
                        );
                        $this->db->insert('tbl_transaksi_masuk', $databarang);

                        $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                Data Berhasil Ditambahkan
                            </div>');
                        redirect('Transaksi-masuk-view');
                    } else {
                        echo 'Data Kosong';
                    }
                    $numRow++;
                }
                $reader->close();
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        Data Berhasil Diupload
                                      </div>');
                redirect('Transaksi/view_masuk');
            }
        } else {
            echo "Error:" . $this->upload->display_errors();
        };
    }


    // SELECT tbl_barang.nama_barang, tbl_ukuran.nama_ukuran, tbl_barang.id_barang, tbl_ukuran.id_ukuran from tbl_ukuran JOIN tbl_barang ON tbl_ukuran.id_barang = tbl_barang.id_barang WHERE nama_barang = 'Helmet' AND nama_ukuran = 'merah';

    public function masuk()
    {
        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'xls|xlsx';
        $config['file_name'] = 'Barang Masuk' . time();
        $config['max_size']     = '2048';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('import_masuk')) {
            $file = $this->upload->data();
            $reader = ReaderEntityFactory::createXLSXReader();
            $reader->setShouldFormatDates(true);
            $reader->open('upload/' . $file['file_name']);
            foreach ($reader->getSheetIterator() as $sheet) {
                $numRow = 1;
                $date = date("Y-m-d H:i:s");
                foreach ($sheet->getRowIterator() as $row) {
                    if ($numRow > 1) {
                        // $id_ukuran = $row->getCellAtIndex(4);
                        $jml_masuk = $row->getCellAtIndex(4)->getValue();
                        $nama_barang = trim($row->getCellAtIndex(2));
                        $ukuran = trim($row->getCellAtIndex(3));

                        $cek_data = $this->db->query("SELECT * FROM tbl_ukuran JOIN tbl_barang WHERE tbl_ukuran.nama_ukuran = '$ukuran' AND tbl_barang.nama_barang = '$nama_barang'")->row_array();

                        if ($cek_data > 0) {
                            $nama_barang = trim($row->getCellAtIndex(2));
                            $ukuran = trim($row->getCellAtIndex(3));
                            $cek_id = $this->db->query("SELECT id_ukuran FROM tbl_ukuran JOIN tbl_barang WHERE tbl_ukuran.nama_ukuran = '$ukuran' AND tbl_barang.nama_barang = '$nama_barang'")->row_array();
                            $id_ukur = $cek_id['id_ukuran'];
                            $databarang = array(
                                'tanggal' =>  date('Y-m-d', strtotime($row->getCellAtIndex(1))),
                                'id_ukuran' => $id_ukur,
                                'karyawan' => $this->session->userdata['username'],
                                'jumlah_masuk' => $row->getCellAtIndex(4),
                                'ket_masuk' => $row->getCellAtIndex(5),
                                'edit' => $date,
                                'admin' => $this->session->userdata['username'],
                            );
                            $this->db->insert('tbl_transaksi_masuk', $databarang);
                            $ambilid = $this->db->insert_id();

                            $ambilstokterakhir = $this->db->query("SELECT jumlah_stok FROM stok1 WHERE id_ukuran = '$id_ukur' ORDER BY id_stok DESC LIMIT 1")->result_array();

                            $stok = $ambilstokterakhir[0]["jumlah_stok"] + $jml_masuk;

                            $data2 = array(
                                'id_transaksi_masuk' => $ambilid,
                                'id_transaksi_keluar' => 0,
                                'id_ukuran' => $id_ukur,
                                'karyawan' => $this->session->userdata['username'],
                                'jumlah_masuk' =>  $row->getCellAtIndex(4),
                                'jumlah_keluar' => 0,
                                'jumlah_stok' => $stok,
                                'tanggal' => date('Y-m-d', strtotime($row->getCellAtIndex(1))),
                                'edit' => date('Y-m-d H:i:s'),
                                'admin' => $this->session->userdata['username'],
                            );
                            $this->db->insert('stok1', $data2);
                        } else {
                            $dataerror = array(
                                'tanggal' =>  date('Y-m-d', strtotime($row->getCellAtIndex(1))),
                                'nama_barang' => $row->getCellAtIndex(2),
                                'nama_ukuran' => $row->getCellAtIndex(3),
                                'jumlah_masuk' => $row->getCellAtIndex(4),
                                'ket_masuk' => $row->getCellAtIndex(5),
                            );
                            $this->db->insert('temp', $dataerror);
                        }
                    }
                    $numRow++;
                }
                $reader->close();
                $this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Import Data Success.</strong></div>');
                redirect('Transaksi-masuk-view');
            }
        } else {
            echo "Error :" . $this->upload->display_errors();;
        };
    }

    public function keluar()
    {
        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'xls|xlsx';
        $config['file_name'] = 'Barang Keluar' . time();
        $config['max_size']     = '2048';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('import_keluar')) {
            $file = $this->upload->data();
            $reader = ReaderEntityFactory::createXLSXReader();
            $reader->setShouldFormatDates(true);
            $reader->open('upload/' . $file['file_name']);
            foreach ($reader->getSheetIterator() as $sheet) {
                $numRow = 1;
                $date = date("Y-m-d H:i:s");
                foreach ($sheet->getRowIterator() as $row) {
                    if ($numRow > 1) {

                        $jml_keluar = $row->getCellAtIndex(5)->getValue();
                        $nama_barang = trim($row->getCellAtIndex(3));
                        $ukuran = trim($row->getCellAtIndex(4));

                        $cek_data = $this->db->query("SELECT * FROM tbl_ukuran JOIN tbl_barang WHERE tbl_ukuran.nama_ukuran = '$ukuran' AND tbl_barang.nama_barang = '$nama_barang'")->row_array();

                        if ($cek_data > 0) {
                            $nama_barang = trim($row->getCellAtIndex(3));
                            $ukuran = trim($row->getCellAtIndex(4));
                            $cek_id = $this->db->query("SELECT id_ukuran FROM tbl_ukuran JOIN tbl_barang WHERE tbl_ukuran.nama_ukuran = '$ukuran' AND tbl_barang.nama_barang = '$nama_barang'")->row_array();
                            $id_ukur = $cek_id['id_ukuran'];

                            $databarang = array(
                                'tanggal' =>  date('Y-m-d', strtotime($row->getCellAtIndex(1))),
                                'karyawan' => $row->getCellAtIndex(2),
                                'id_ukuran' => $id_ukur,
                                'jumlah_keluar' => $row->getCellAtIndex(5),
                                'ket_keluar' => $row->getCellAtIndex(6),
                                'edit' => $date,
                                'admin' => $this->session->userdata['username'],
                            );
                            $this->db->insert('tbl_transaksi_keluar', $databarang);
                            $ambilid = $this->db->insert_id();

                            $ambilstokterakhir = $this->db->query("SELECT jumlah_stok FROM stok1 WHERE id_ukuran = '$id_ukur' ORDER BY id_stok DESC LIMIT 1")->result_array();

                            $stok = $ambilstokterakhir[0]["jumlah_stok"] - $jml_keluar;

                            $data2 = array(
                                'id_transaksi_masuk' => 0,
                                'id_transaksi_keluar' => $ambilid,
                                'id_ukuran' => $id_ukur,
                                'karyawan' => $row->getCellAtIndex(2),
                                'jumlah_masuk' => 0,
                                'jumlah_keluar' => $row->getCellAtIndex(5),
                                'jumlah_stok' => $stok,
                                'tanggal' => date('Y-m-d', strtotime($row->getCellAtIndex(1))),
                                'edit' => $date,
                                'admin' => $this->session->userdata['username'],
                            );
                            $this->db->insert('stok1', $data2);
                        } else {
                            $dataerror = array(
                                'tanggal' =>  date('Y-m-d', strtotime($row->getCellAtIndex(1))),
                                'karyawan' => $row->getCellAtIndex(2),
                                'nama_barang' => $row->getCellAtIndex(3),
                                'nama_ukuran' => $row->getCellAtIndex(4),
                                'jumlah_keluar' => $row->getCellAtIndex(5),
                                'ket_keluar' => $row->getCellAtIndex(6),
                            );
                            $this->db->insert('temp_keluar', $dataerror);
                        }
                    }
                    $numRow++;
                }
                $reader->close();
                $this->session->set_flashdata('message', '<div class="alert alert-success"><strong>Import Data Success.</strong></div>');
                redirect('Transaksi-keluar-view');
            }
        } else {
            echo "Error :" . $this->upload->display_errors();;
        };
    }
}
