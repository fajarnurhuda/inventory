<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
/**
 * 
 */
class Barang extends CI_Controller
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

    $this->load->model('Mbarang');
  }

  function index()
  {

    $data['barang'] = $this->Mbarang->data_barang();


    $this->load->view('templates/head/tabel');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/barang/vbarang', $data);
    $this->load->view('templates/footer/tabel');
  }

  function add_view()
  {

    $this->load->view('templates/head/tabel');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/barang/vaddbarang');
    $this->load->view('templates/footer/tabel');
  }

  function save_data()
  { //data diri

    // print_r($barangno);
    $nama  = trim($this->input->post('nama_barang'));
    $admin  = $this->input->post('admin');

    $cekbarang = $this->Mbarang->cek_barang($nama);
    if ($cekbarang > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      Data Sudah Ada
      </div>');
      redirect('Barang-view');
    } else {
      $data = array(
        'nama_barang' => $nama,
        'edit' => date('Y-m-d H:i:s'),
        'admin' => $admin,
      );

      $this->Mbarang->input_data($data, 'tbl_barang');
      $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      Data Berhasil Ditambahkan
      </div>');
      redirect('Barang-view');
    }
  }

  function delete($id)
  {
    $where = array('id_barang' => $id);
    $this->Mbarang->hapus_data($where, 'tbl_barang');
    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">
        Data Berhasil Dihapus
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>');
    redirect('Barang-view');
  }


  function ubah_data($id)
  {
    $data['barang'] = $this->db->get_where('tbl_barang', ['id_barang' => $id])->row_array();

    $this->load->view('templates/head/tabel');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/topbar');
    $this->load->view('master/barang/veditbarang', $data);
    $this->load->view('templates/footer/tabel');
  }

  function update()
  {
    // print_r($barangno);
    $idbar  = $this->input->post('id_barang');
    $nama  = trim($this->input->post('nama_barang'));
    $admin  = $this->input->post('admin');

    $cekbarang = $this->Mbarang->cek_barang($nama);
    if ($cekbarang > 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      Data Sudah Ada
      </div>');
      redirect('Barang-view');
    } else {
      $data = array(
        'nama_barang' => $nama,
        'edit' => date('Y-m-d H:i:s'),
        'admin' => $admin,
      );

      $where = array(
        'id_barang' => $idbar
      );

      $this->Mbarang->update_data($where, $data, 'tbl_barang');
      $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible" role="alert">Data Berhasil Diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>');
      redirect('Barang-view');
    }
  }
}
