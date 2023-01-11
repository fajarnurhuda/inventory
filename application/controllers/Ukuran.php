<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");
/**
 * 
 */
class Ukuran extends CI_Controller
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

        $this->load->model('Mukuran');
    }

    function index()
    {

        $data['ukuran'] = $this->Mukuran->data_ukuran();

        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/ukuran/vukuran', $data);
        $this->load->view('templates/footer/tabel');
    }

    function add_ukuran()
    {
        $data['bar'] = $this->db->get('tbl_barang')->result_array();
        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/ukuran/vaddukuran', $data);
        $this->load->view('templates/footer/tabel');
    }

    function save_data()
    { //data diri

        // print_r($barangno);
        $nama_ukuran    = trim($this->input->post('nama_ukuran'));
        $nama_barang    = trim($this->input->post('nama_barang'));
        $admin          = $this->input->post('admin');

        $cekukuran = $this->Mukuran->cek_ukur($nama_barang, $nama_ukuran);
        if ($cekukuran > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Data Sudah Ada
            </div>');
            redirect('Ukuran');
        } else {
            $data = array(
                'nama_ukuran' => $nama_ukuran,
                'id_barang' => $nama_barang,
                'edit' => date('Y-m-d H:i:s'),
                'admin' => $admin,
            );

            $this->Mukuran->input_data($data, 'tbl_ukuran');
            $ambilid = $this->db->insert_id();

            $data2 = array(
                'id_ukuran' => $ambilid,
                'stok_akhir' => 0,
                'edit' => date('Y-m-d H:i:s'),
                'admin' => $admin,
            );

            $data3 = array(
                'id_ukuran' => $ambilid,
                'jml_min' => 0,
                'edit' => date('Y-m-d H:i:s'),
                'admin' => $admin,
            );

            $this->Mukuran->input_data($data2, 'vstok');
            $this->Mukuran->input_data($data3, 'tbl_set');
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Data Berhasil Ditambahkan
            </div>');
            redirect('Ukuran');
        }
    }

    function delete($id)
    {
        $where = array('id_ukuran' => $id);
        $this->Mukuran->hapus_data($where, 'tbl_ukuran');
        $this->Mukuran->hapus_data($where, 'vstok');
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">
        Data Berhasil Dihapus
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>');
        redirect('ukuran');
    }


    function ubah_data($id)
    {
        $data['ukuran'] = $this->db->get_where('tbl_ukuran', array('id_ukuran' => $id))->row_array();
        $data['bar'] = $this->db->get('tbl_barang')->result_array();

        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/ukuran/veditukuran', $data);
        $this->load->view('templates/footer/tabel');
    }

    function update()
    {
        // print_r($barangno);
        $id_ukuran  = $this->input->post('id_ukuran');
        $nama_ukuran  = trim($this->input->post('nama_ukuran'));
        $admin  = $this->input->post('admin');
        $nama_barang  = trim($this->input->post('nama_barang'));

        $cekukuran = $this->Mukuran->cek_ukur($nama_barang, $nama_ukuran);
        if ($cekukuran > 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Data Sudah Ada
            </div>');
            redirect('Ukuran');
        } else {
            $data = array(
                'nama_ukuran' => $nama_ukuran,
                'admin' => $admin,
                'edit' => date('Y-m-d H:i:s'),
                'id_barang' => $nama_barang,
            );

            $where = array(
                'id_ukuran' => $id_ukuran
            );

            $this->Mukuran->update_data($where, $data, 'tbl_ukuran');
            $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible" role="alert">Data Berhasil Diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>');
            redirect('ukuran');
        }
    }

    function export_excel_ukuran()
    {

        $data['title'] = 'Laporan Excel Ukuran';
        $data['ukuran'] = $this->Mukuran->data_ukuran();

        $this->load->view('master/excel/ukuran', $data);
    }
}
