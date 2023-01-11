<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'third_party\Spout\src\Spout\Autoloader\autoload.php';


use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class Laporan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!isset($this->session->userdata['username'])) {
            $this->session->set_flashdata('Pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><small> Anda Belum Login! (Silahkan Login untuk mengakses halaman yang akan dituju!)</small> <button type="button" class="close" data-dismiss="alert" aria-label="Close" <span aria-hidden="true">&times;</span> </button> </div>');
            redirect('auth');
        }

        $this->load->library('Pdf');
        $this->load->model('MLaporan');
    }

    function barang_masuk()
    {

        $data['graph'] = $this->MLaporan->graph();
        $data['caribarang'] = $this->MLaporan->show_barang_masuk();
        $data['barang'] = $this->MLaporan->barang();

        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/laporan/barangmasuk', $data);
        $this->load->view('templates/footer/tabel');
    }

    function laporan_masuk()
    {
        $dari = $this->input->post('dari');
        $sampai = $this->input->post('sampai');
        $ukur = $this->input->post('id_ukuran');

        $data['caribarang'] = $this->MLaporan->data_barang($dari, $sampai, $ukur);

        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/laporan/barangmasuk', $data);
        $this->load->view('templates/footer/tabel');
    }

    function stok_barang()
    {

        $data['ukuran'] = $this->db->query("SELECT * FROM tbl_ukuran JOIN tbl_barang ON tbl_barang.id_barang = tbl_ukuran.id_barang")->result();

        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/laporan/stokbarang', $data);
        $this->load->view('templates/footer/tabel');
    }


    // Code tidak digunakan
    function barang_keluar()
    {

        $data['graph'] = $this->MLaporan->graph_keluar();
        $data['caribarang'] = $this->MLaporan->show_barang_keluar();
        // $data['listbarang'] = $this->MLaporan->barang();
        $data['listbarang'] = $this->db->get('tbl_barang')->result_array();

        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/laporan/barangkeluar', $data);
        $this->load->view('templates/footer/tabel');
    }

    function laporan_keluar()
    {
        $dari = $this->input->post('dari');
        $sampai = $this->input->post('sampai');
        $id_barang = $this->input->post('nama_barang');

        $caribarang = $this->MLaporan->data_barang_keluar($dari, $sampai, $id_barang);
        

        // $data['barang'] = $this->db->get_where('tbl_barang', ['nama_barang' => $nama_barang])->result_array();
        // $barang = $this->db->distinct()->select('ukuran_barang')->get_where('tbl_ukuran', ['id_barang' => $id_barang])->result_array();

        $barang = $this->db->distinct()->select('nama_ukuran')->get_where('tbl_ukuran', ['id_barang' => $id_barang])->result_array();

        $ukuran = $this->db->get_where('tbl_ukuran', ['id_barang' => $id_barang])->num_rows();

        $listbarang = $this->db->get('tbl_barang')->result_array();

        $tanggal = $this->db->distinct()->select('tanggal')->get_where('stok1', ['tanggal >=' => $dari, 'tanggal <=' => $sampai])->result();

        // $data['karya'] = $this->db->query("SELECT nama_karyawan, id_karyawan FROM stok1 INNER JOIN tbl_karyawan ON tbl_karyawan.id_karyawan = stok1.karyawan WHERE tanggal >= '$dari' AND tanggal <= '$sampai'")->result();
        // var_dump($caribarang);
        // die;

        $object['controller'] = $this;
        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/laporan/hasilbarangkeluar', compact('caribarang', 'object', 'barang', 'ukuran', 'listbarang', 'tanggal'));
        $this->load->view('templates/footer/tabel');
    }

    public function getBarangMasuk($date, $karyawan, $barang)
    {
        $data = $this->db->query("SELECT tbl_transaksi_masuk.*, tbl_barang.* FROM tbl_transaksi_masuk JOIN tbl_barang ON tbl_barang.id_barang = tbl_transaksi_masuk.id_barang JOIN tbl_karyawan ON tbl_transaksi_masuk.karyawan = tbl_karyawan.id_karyawan WHERE tbl_transaksi_masuk.tanggal = '$date' AND tbl_transaksi_masuk.karyawan = '$karyawan' AND tbl_barang.nama_barang = '$barang'")->result_array();
        return $data;
    }

    function export_excel($dari, $sampai, $id_barang)
    {
        $data['title'] = 'Laporan Excel';
        $data['caribarang'] = $this->MLaporan->data_barang_keluar($dari, $sampai, $id_barang);
        $data['barang'] = $this->db->distinct()->select('nama_ukuran')->get_where('tbl_ukuran', ['id_barang' => $id_barang])->result_array();
        $data['ukuran'] = $this->db->get_where('tbl_ukuran', ['id_barang' => $id_barang])->num_rows();
        $data['listbarang'] = $this->db->get('tbl_barang')->result_array();
        $data['tanggal'] = $this->db->distinct()->select('tanggal')->get_where('stok1', ['tanggal >=' => $dari, 'tanggal <=' => $sampai])->result();
        $this->load->view('master/excel/excel', $data);
    }

    function total_keluar()
    {
        $data['barang'] = $this->MLaporan->barang();
        $data['caribarang'] = $this->MLaporan->show_barang_keluar();

        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/laporan/total_keluar', $data);
        $this->load->view('templates/footer/tabel');
    }

    function keluar_cari()
    {
        $dari = $this->input->post('dari');
        $sampai = $this->input->post('sampai');
        $ukur = $this->input->post('id_ukuran');

        $data['barang'] = $this->MLaporan->barang();
        $data['caribarang'] = $this->MLaporan->data_keluar($dari, $sampai, $ukur);

        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/laporan/total_keluar', $data);
        $this->load->view('templates/footer/tabel');
    }

    function export_excel_keluar($dari, $sampai, $id_barang)
    {

        $data['title'] = 'Laporan Excel Keluar';
        $data['caribarang'] = $this->MLaporan->data_keluar($dari, $sampai, $id_barang);
        $data['sum_stok'] = $this->MLaporan->sum_data_keluar($dari, $sampai, $id_barang);
        $data['periode1'] = $dari;
        $data['periode2'] = $sampai;

        $this->load->view('master/excel/keluar', $data);
    }

    function export_excel_stok()
    {

        $data['title'] = 'Laporan Excel Stok';
        $data['ukuran'] = $this->db->query("SELECT * FROM tbl_ukuran JOIN tbl_barang ON tbl_barang.id_barang = tbl_ukuran.id_barang")->result();

        $this->load->view('master/excel/stok', $data);
    }

    function total_masuk()
    {
        $data['barang'] = $this->MLaporan->barang();
        $data['caribarang'] = $this->MLaporan->show_barang_masuk();

        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/laporan/total_masuk', $data);
        $this->load->view('templates/footer/tabel');
    }

    function masuk_cari()
    {
        $dari = $this->input->post('dari');
        $sampai = $this->input->post('sampai');
        $ukur = $this->input->post('id_ukuran');

        $data['barang'] = $this->MLaporan->barang();
        $data['caribarang'] = $this->MLaporan->data_masuk($dari, $sampai, $ukur);

        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/laporan/total_masuk', $data);
        $this->load->view('templates/footer/tabel');
    }

    function export_excel_masuk($dari, $sampai, $id_barang)
    {

        $data['title'] = 'Laporan Excel Keluar';
        $data['caribarang'] = $this->MLaporan->data_masuk($dari, $sampai, $id_barang);
        $data['sum_stok'] = $this->MLaporan->sum_data_masuk($dari, $sampai, $id_barang);

        $this->load->view('master/excel/masuk', $data);
    }
}
