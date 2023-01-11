<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 
 */
class Karyawan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!isset($this->session->userdata['username'])) {
            $this->session->set_flashdata('Pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><small> Anda Belum Login! (Silahkan Login untuk mengakses halaman yang akan dituju!)</small> <button type="button" class="close" data-dismiss="alert" aria-label="Close" <span aria-hidden="true">&times;</span> </button> </div>');
            redirect('auth');
        }

        if ($this->session->userdata['username']  != 'admin') {
            redirect('dashboard');
        }

        $this->load->model('Mkaryawan');
    }

    function index()
    {

        $data['karyawan'] = $this->Mkaryawan->data_karyawan();

        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/karyawan/vkaryawan', $data);
        $this->load->view('templates/footer/tabel');
    }

    function add_view()
    {

        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/karyawan/vaddkaryawan');
        $this->load->view('templates/footer/tabel');
    }

    function save_data()
    { //data diri


        // print_r($barangno);
        $pns_id  = $this->input->post('pns_id');
        $nama_karyawan  = $this->input->post('nama_karyawan');

        $data = array(
            'pns_id' => $pns_id,
            'nama_karyawan' => $nama_karyawan
        );

        $this->Mkaryawan->input_data($data, 'tbl_karyawan');
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          Data Berhasil Ditambahkan
        </div>');
        redirect('Karyawan');
    }

    function delete($id)
    {
        $where = array('id_karyawan' => $id);
        $this->Mkaryawan->hapus_data($where, 'tbl_karyawan');
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">
        Data Berhasil Dihapus
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>');
        redirect('Karyawan');
    }


    function ubah_data($id)
    {
        $datakaryawan = $this->Mkaryawan->getkaryawanbyid($id);
        $data['karyawan'] = $datakaryawan[0];

        $this->load->view('templates/head/tabel');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('master/karyawan/veditkaryawan', $data);
        $this->load->view('templates/footer/tabel');
    }

    function update()
    {
        // print_r($barangno);
        $id_karyawan  = $this->input->post('id_karyawan');
        $pns_id  = $this->input->post('pns_id');
        $nama_karyawan  = $this->input->post('nama_karyawan');

        $data = array(
            'pns_id' => $pns_id,
            'nama_karyawan' => $nama_karyawan
        );

        $where = array(
            'id_karyawan' => $id_karyawan
        );

        $this->Mkaryawan->update_data($where, $data, 'tbl_karyawan');
        $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible" role="alert">Data Berhasil Diupdate
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>');
        redirect('Karyawan');
    }
}
