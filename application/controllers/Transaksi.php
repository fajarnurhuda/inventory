<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
/**
 * 
 */
class Transaksi extends CI_Controller
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

    $this->load->model('MTransaksi');
  }

  function getukuran()
  {
    $id_barang  = $this->input->post('id_barang');
    $getukuran = $this->db->query("SELECT * FROM tbl_ukuran WHERE id_barang = '$id_barang'")->result();

    echo json_encode($getukuran);
  }

  function view_masuk()
  {

    $data['tr_masuk'] = $this->MTransaksi->transaksi_masuk();


    $this->load->view('templates/head/tabel');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/transaksi_masuk/transaksi_masuk', $data);
    $this->load->view('templates/footer/tabel');
  }


  function delete($id)
  {
    $upstok = $this->db->query("SELECT jumlah_masuk, id_ukuran, id_stok FROM stok1 WHERE id_transaksi_masuk = '$id'")->result_array();
    $idukuran = $upstok[0]["id_ukuran"];
    $st = $upstok[0]["id_stok"];
    $up = $upstok[0]["jumlah_masuk"];

    $this->db->set('jumlah_stok', 'jumlah_stok - ' . $up, false);
    $this->db->WHERE('id_ukuran', $idukuran);
    // $this->db->WHERE('id_transaksi_masuk >', $id);
    $this->db->WHERE('id_stok >', $st);
    $this->db->update('stok1');

    $where = array('id_transaksi_masuk' => $id);

    $hasil = $this->MTransaksi->hapus_data($where, 'tbl_transaksi_masuk');
    $hasil = $this->MTransaksi->hapus_data($where, 'stok1');

    $stokmasuk = $this->db->query("SELECT SUM(jumlah_masuk) FROM tbl_transaksi_masuk WHERE id_ukuran = '$idukuran'")->result_array();
    $stokkeluar = $this->db->query("SELECT SUM(jumlah_keluar) FROM tbl_transaksi_keluar WHERE id_ukuran = '$idukuran'")->result_array();
    $stok_akhir = $stokmasuk[0]["SUM(jumlah_masuk)"] - $stokkeluar[0]["SUM(jumlah_keluar)"];

    $data3 = array(
      'stok_akhir' => $stok_akhir,
    );

    $where = array(
      'id_ukuran' => $idukuran
    );

    $this->MTransaksi->update_data($where, $data3, 'vstok');

    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">
    Data Berhasil Dihapus
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>');

    redirect('Transaksi-masuk-view');
  }


  function add_view()
  {

    $data['barang'] = $this->db->get('tbl_barang')->result_array();

    $this->load->view('templates/head/tabel');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/transaksi_masuk/vaddtransaksimasuk', $data);
    $this->load->view('templates/footer/tabel');
  }

  function save_data()
  {
    $tanggal  = $this->input->post('tanggal');
    $idukuran  = $this->input->post('id_ukuran');
    $jumlahmasuk  = $this->input->post('jumlah_masuk');
    $karyawan  = $this->session->userdata['username'];
    $ketmasuk  = $this->input->post('ket_masuk');
    $admin  = $this->input->post('admin');

    $data = array(
      'tanggal' => $tanggal,
      'id_ukuran' => $idukuran,
      'karyawan' => $karyawan,
      'jumlah_masuk' => $jumlahmasuk,
      'ket_masuk' => $ketmasuk,
      'edit' => date('Y-m-d H:i:s'),
      'admin' => $admin,
    );

    $this->MTransaksi->input_data($data, 'tbl_transaksi_masuk');
    $ambilid = $this->db->insert_id();

    $ambilstokterakhir = $this->db->query("SELECT jumlah_stok FROM stok1 WHERE id_ukuran = '$idukuran' ORDER BY id_stok DESC LIMIT 1")->result_array();
    $stok = $ambilstokterakhir[0]["jumlah_stok"] + $jumlahmasuk;
    $data2 = array(
      'id_transaksi_masuk' => $ambilid,
      'id_transaksi_keluar' => 0,
      'id_ukuran' => $idukuran,
      'karyawan' => $karyawan,
      'jumlah_masuk' => $jumlahmasuk,
      'jumlah_keluar' => 0,
      'jumlah_stok' => $stok,
      'tanggal' => $tanggal,
      'edit' => date('Y-m-d H:i:s'),
      'admin' => $admin,
    );
    $this->MTransaksi->input_data($data2, 'stok1');

    $stokmasuk = $this->db->query("SELECT SUM(jumlah_masuk) FROM tbl_transaksi_masuk WHERE id_ukuran = '$idukuran'")->result_array();
    $stokkeluar = $this->db->query("SELECT SUM(jumlah_keluar) FROM tbl_transaksi_keluar WHERE id_ukuran = '$idukuran'")->result_array();
    $stok_akhir = $stokmasuk[0]["SUM(jumlah_masuk)"] - $stokkeluar[0]["SUM(jumlah_keluar)"];

    $data3 = array(
      'stok_akhir' => $stok_akhir,
    );

    $where = array(
      'id_ukuran' => $idukuran
    );

    $this->MTransaksi->update_data($where, $data3, 'vstok');
    $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          Data Berhasil Ditambahkan
        </div>');
    redirect('Transaksi-masuk-view');
  }


  // KELUARR


  function view_keluar()
  {

    $data['tr_keluar'] = $this->MTransaksi->transaksi_keluar();

    $this->load->view('templates/head/tabel');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/transaksi_keluar/transaksi_keluar', $data);
    $this->load->view('templates/footer/tabel');
  }


  function add_keluar()
  {

    $data['barang'] = $this->db->get('tbl_barang')->result_array();

    $this->load->view('templates/head/tabel');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/transaksi_keluar/vaddtransaksikeluar', $data);
    $this->load->view('templates/footer/tabel');
  }

  function save_keluar()
  {

    $tanggal  = $this->input->post('tanggal');
    $idukuran  = $this->input->post('id_ukuran');
    $jumlahkeluar  = $this->input->post('jumlah_keluar');
    $karyawan  = $this->input->post('karyawan');
    $ketkeluar  = $this->input->post('ket_keluar');
    $admin  = $this->input->post('admin');

    $data = array(
      'tanggal' => $tanggal,
      'id_ukuran' => $idukuran,
      'karyawan' => $karyawan,
      'jumlah_keluar' => $jumlahkeluar,
      'ket_keluar' => $ketkeluar,
      'edit' => date('Y-m-d H:i:s'),
      'admin' => $admin,
    );

    $this->MTransaksi->input_data($data, 'tbl_transaksi_keluar');
    $ambilid = $this->db->insert_id();

    $data2 = array(
      'id_transaksi_masuk' => 0,
      'id_transaksi_keluar' => $ambilid,
      'id_ukuran' => $idukuran,
      'karyawan' => $karyawan,
      'jumlah_masuk' => 0,
      'jumlah_keluar' => $jumlahkeluar,
      'jumlah_stok' => 0,
      'tanggal' => $tanggal,
      'edit' => date('Y-m-d H:i:s'),
      'admin' => $admin,
    );
    $this->MTransaksi->input_data($data2, 'stok1');

    $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          Data Berhasil Ditambahkan
        </div>');
    redirect('Transaksi-keluar-view');
  }

  function reject()
  {
    foreach ($this->input->POST('id') as $id) {
      $this->db->query("DELETE FROM tbl_transaksi_keluar WHERE id_transaksi_keluar = '$id'");

      $this->db->query("DELETE FROM stok1 WHERE id_transaksi_keluar = '$id'");
    }
    echo json_encode(['success' => true]);
  }
}
