<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
/**
 * 
 */
class Stok extends CI_Controller
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

    $this->load->model('MStok');
  }

  function index()
  {
    $min = 1;
    $data['stok_min'] = $this->db->query("SELECT * FROM `tbl_ukuran` JOIN tbl_barang ON tbl_barang.id_barang = tbl_ukuran.id_barang")->result_array();

    $this->load->view('templates/head/tabel');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/stok/stokmin', $data);
    $this->load->view('templates/footer/tabel');
  }

  function ubah_data($id)
  {
    $data['stok_min'] = $this->db->query("SELECT * FROM `tbl_ukuran` JOIN tbl_barang ON tbl_barang.id_barang = tbl_ukuran.id_barang WHERE id_ukuran = '$id'")->row_array();

    $this->load->view('templates/head/tabel');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/stok/veditmin', $data);
    $this->load->view('templates/footer/tabel');
  }

  function update()
  {
    // print_r($barangno);
    $idukuran = $this->input->post('id_ukuran');
    $min_stok  = $this->input->post('min_stok');
    $admin  = $this->input->post('admin');

    $data = array(
      'min_stok' => $min_stok,
      'edit' => date('Y-m-d H:i:s'),
      'admin' => $admin,
    );

    $where = array(
      'id_ukuran' => $idukuran
    );

    $this->MStok->update_data($where, $data, 'tbl_ukuran');
    $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible" role="alert">Data Berhasil Diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>');
    redirect('Stok');
  }
}
