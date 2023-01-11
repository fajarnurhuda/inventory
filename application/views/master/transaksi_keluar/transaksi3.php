<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trial</title>
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="container-fluid">
        <!-- DataTales Example -->
        <?php echo $this->session->flashdata('message_edit') ?>
        <?php echo $this->session->flashdata('message_success') ?>
        <?php echo $this->session->flashdata('message') ?>

        <h1 class="h3 mb-4 text-gray-800">Barang Keluar</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <?php if ($this->session->userdata('level') == 'admin') : ?>
                    <a href="<?php echo base_url('Transaksi-keluar-add') ?>">
                        <button class="btn btn-sm btn-primary" type=""><i class="fas fa-plus fa-sm"></i> Tambah Transaksi Keluar</button>
                    </a>
                    <a href="" data-toggle="modal" data-target="#exampleModal">
                        <button class="btn btn-sm btn-info" type=""><i class="fas fa-upload fa-sm"></i> Upload Barang Keluar</button>
                    </a>
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="<?php echo base_url('import/keluar') ?>" method="POST" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Upload Barang Keluar</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="file" name="import_keluar" id="import_keluar" accept=".xls,.xlsx">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="tambah">
                                            Upload
                                        </button>
                                        <a href="<?php echo base_url('assets/') ?>Upload Barang Keluar.xlsx" class="btn btn-info" class="btn btn-info">Template</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <button id="button" class="float-right mb-3">Delete </button>
                    <table id="example" class="table display" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Barang</th>
                                <th>Ukuran</th>
                                <th>Karyawan</th>
                                <th>Jumlah Keluar</th>
                                <th>Ket Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            if (!empty($tr_keluar)) : ?>
                                <?php foreach ($tr_keluar as $row) :
                                    // $stt = $row->status;
                                ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row->tanggal ?></td>
                                        <td><?php echo $row->nama_barang ?></td>
                                        <td><?php echo $row->nama_ukuran ?></td>
                                        <td><?php echo $row->karyawan ?></td>
                                        <td><?php echo $row->jumlah_keluar ?></td>
                                        <td><?php echo $row->ket_keluar ?></td>

                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="9" align="center">Tidak Ada Data</td>
                                </tr>
                            <?php endif ?>
                        </tbody>

                    </table>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable();

        $('#example tbody').on('click', 'tr', function() {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });

        $('#button').click(function() {
            table.row('.selected').remove().draw(false);
        });
    });
</script>

public function employee_edit_proses()
    {
        if (isset($_POST['submit'])) {

            $this->form_validation->set_rules('id', 'ID', 'trim');
            $this->form_validation->set_rules('employee_name', 'Nama Lengkap', 'trim');
            $this->form_validation->set_rules('first_name', 'Nama Pertama', 'trim');
            $this->form_validation->set_rules('last_name', 'Nama Akhir', 'trim');
            $this->form_validation->set_rules('call_name', 'Nama Panggilan', 'trim');
            $this->form_validation->set_rules('jk', 'Jenis Kelamin', 'trim');
            $this->form_validation->set_rules('bornplace', 'Tempat Lahir', 'trim');
            $this->form_validation->set_rules('borndate', 'Tanggal Lahir', 'trim');
            $this->form_validation->set_rules('gol_dar', 'Golongan Darah', 'trim');
            $this->form_validation->set_rules('agama', 'Agama', 'trim');
            $this->form_validation->set_rules('suku', 'Suku', 'trim');
            $this->form_validation->set_rules('status_kawin', 'Status Perkawinan', 'trim');
            $this->form_validation->set_rules('tanggungan', 'Jumlah Tanggungan', 'trim');
            $this->form_validation->set_rules('phoneNumber', 'No HP', 'trim');
            $this->form_validation->set_rules('waNumber', 'No WA', 'trim');
            $this->form_validation->set_rules('email', 'Email', 'trim');
            $this->form_validation->set_rules('pend_akhir', 'Pendidikan Terakhir', 'trim');
            $this->form_validation->set_rules('jurusan', 'Jurusan', 'trim');
            $this->form_validation->set_rules('tahun_lulus', 'Tahun Lulus', 'trim');
            $this->form_validation->set_rules('nama_sekolah', 'Nama Sekolah', 'trim');
            $this->form_validation->set_rules('kota_asal_sekolah', 'Kota Asal Sekolah', 'trim');
            $this->form_validation->set_rules('ukuran_baju', 'Ukuran Baju', 'trim');
            $this->form_validation->set_rules('ukuran_sepatu', 'Ukuran Sepatu', 'trim');
            $this->form_validation->set_rules('npwp', 'NPWP', 'trim');
            $this->form_validation->set_rules('mandiri', 'No Rekening', 'trim');
            $this->form_validation->set_rules('bpjs_kes', 'BPJS Kesehatan', 'trim');
            $this->form_validation->set_rules('status_bpjs_kes', 'Status BPJS Kesehatan', 'trim');
            $this->form_validation->set_rules('bpjs_tk', 'BPJS Tenaga Kerja', 'trim');
            $this->form_validation->set_rules('status_bpjs_tk', 'Status BPJS Tenaga Kerja', 'trim');

            $this->form_validation->set_rules('nik', 'NO NIK', 'trim');
            $this->form_validation->set_rules('no_kk', 'NO KK', 'trim');
            $this->form_validation->set_rules('kota_ktp', 'KTP Daerah', 'trim');
            $this->form_validation->set_rules('tgl_vaksin_1', 'Tanggal Vaksin 1', 'trim');
            $this->form_validation->set_rules('tmpt_vaksin_1', 'Tempat vaksin 1', 'trim');
            $this->form_validation->set_rules('tgl_vaksin_2', 'Tanggal Vaksin 2', 'trim');
            $this->form_validation->set_rules('tmpt_vaksin_2', 'Tempat Vaksin 2', 'trim');
            $this->form_validation->set_rules('tgl_vaksin_3', 'Tanggal Vaksin 3', 'trim');
            $this->form_validation->set_rules('tmpt_vaksin_3', 'Tempat Vaksin 3', 'trim');
            $this->form_validation->set_rules('jenis_vaksin', 'Nama Vaksin 1 dan 2', 'trim');
            $this->form_validation->set_rules('jenis_vaksin_3', 'Nama Vaksin 3', 'trim');

            $this->form_validation->set_rules('address_ktp', 'Alamat KTP', 'trim');
            $this->form_validation->set_rules('rt_ktp', 'Rt', 'trim');
            $this->form_validation->set_rules('rt_ktp', 'Rw', 'trim');
            $this->form_validation->set_rules('kel_ktp', 'Kelurahan', 'trim');
            $this->form_validation->set_rules('kec_ktp', 'Kecamatan', 'trim');
            $this->form_validation->set_rules('kab_ktp', 'Kabupaten/Kota', 'trim');
            $this->form_validation->set_rules('prov_ktp', 'Provinsi', 'trim');

            $this->form_validation->set_rules('address_btm', 'Alamat Batam', 'trim');
            $this->form_validation->set_rules('rt_btm', 'Rt', 'trim');
            $this->form_validation->set_rules('rt_btm', 'Rw', 'trim');
            $this->form_validation->set_rules('kel_btm', 'Kelurahan', 'trim');
            $this->form_validation->set_rules('kec_btm', 'Kecamatan', 'trim');
            $this->form_validation->set_rules('kode_pos', 'Kode Pos', 'trim');

            $this->form_validation->set_rules('nama_pasang', 'Nama Pasangan', 'trim');
            $this->form_validation->set_rules('jk_pasang', 'Jenis Kelamin', 'trim');
            $this->form_validation->set_rules('tmpt_lahir_pasang', 'Tempat Lahir Pasangan', 'trim');
            $this->form_validation->set_rules('tgl_lahir_pasang', 'Tanggal Lahir Pasangan', 'trim');
            $this->form_validation->set_rules('nik_pasang', 'NIK Pasangan', 'trim');
            $this->form_validation->set_rules('no_hp_pasang', 'NO HP Pasangan', 'trim');
            $this->form_validation->set_rules('tgl_v1_pas', 'Tanggal Vaksin 1 Pasangan', 'trim');
            $this->form_validation->set_rules('tmpt_v1_pas', 'Tempat Vaksin 1 Pasangan', 'trim');
            $this->form_validation->set_rules('tgl_v2_pas', 'Tanggal Vaksin 2 Pasangan', 'trim');
            $this->form_validation->set_rules('tmpt_v2_pas', 'Tempat Vaksin 2 Pasangan', 'trim');
            $this->form_validation->set_rules('tgl_v3_pas', 'Tanggal Vaksin 3 Pasangan', 'trim');
            $this->form_validation->set_rules('tmpt_v3_pas', 'Tempat Vaksin 3 Pasangan', 'trim');
            $this->form_validation->set_rules('jenis_v_pas', 'Jenis Vaksin Pasangan', 'trim');
            $this->form_validation->set_rules('ket_v_pas', 'Keterangan Vaksin Pasangan', 'trim');

            $this->form_validation->set_rules('nama_anak1', 'Nama Anak 1', 'trim');
            $this->form_validation->set_rules('jk_anak1', 'Jenis Kelamin Anak 1', 'trim');
            $this->form_validation->set_rules('tmpt_lahir_anak1', 'Tempat Lahir Anak 1', 'trim');
            $this->form_validation->set_rules('tgl_lahir_anak1', 'Tanggal Lahir Anak 1', 'trim');
            $this->form_validation->set_rules('nik_anak1', 'NIK Anak 1', 'trim');
            $this->form_validation->set_rules('tgl_v1_anak1', 'Tanggal Vaksin 1 Anak 1', 'trim');
            $this->form_validation->set_rules('tmpt_v1_anak1', 'Tempat Vaksin 1 Anak 1', 'trim');
            $this->form_validation->set_rules('tgl_v2_anak1', 'Tanggal Vaksin 2 Anak 1', 'trim');
            $this->form_validation->set_rules('tmpt_v2_anak1', 'Tempat Vaksin 2 Anak 1', 'trim');
            $this->form_validation->set_rules('tgl_v3_anak1', 'Tanggal Vaksin 3 Anak 1', 'trim');
            $this->form_validation->set_rules('tmpt_v3_anak1', 'Tempat Vaksin 3 Anak 1', 'trim');
            $this->form_validation->set_rules('jenis_vaksin_anak1', 'Jenis Vaksin Anak 1', 'trim');
            $this->form_validation->set_rules('ket_v_anak1', 'Keterangan Vaksin Anak 1', 'trim');

            $this->form_validation->set_rules('nama_anak2', 'Nama Anak 2', 'trim');
            $this->form_validation->set_rules('jk_anak2', 'Jenis Kelamin Anak 2', 'trim');
            $this->form_validation->set_rules('tmpt_lahir_anak2', 'Tempat Lahir Anak 2', 'trim');
            $this->form_validation->set_rules('tgl_lahir_anak2', 'Tanggal Lahir Anak 2', 'trim');
            $this->form_validation->set_rules('nik_anak2', 'NIK Anak 2', 'trim');
            $this->form_validation->set_rules('tgl_v1_anak2', 'Tanggal Vaksin 1 Anak 2', 'trim');
            $this->form_validation->set_rules('tmpt_v1_anak2', 'Tempat Vaksin 1 Anak 2', 'trim');
            $this->form_validation->set_rules('tgl_v2_anak2', 'Tanggal Vaksin 2 Anak 2', 'trim');
            $this->form_validation->set_rules('tmpt_v2_anak2', 'Tempat Vaksin 2 Anak 2', 'trim');
            $this->form_validation->set_rules('tgl_v3_anak2', 'Tanggal Vaksin 3 Anak 2', 'trim');
            $this->form_validation->set_rules('tmpt_v3_anak2', 'Tempat Vaksin 3 Anak 2', 'trim');
            $this->form_validation->set_rules('jenis_vaksin_anak2', 'Jenis Vaksin Anak 2', 'trim');
            $this->form_validation->set_rules('ket_v_anak2', 'Keterangan Vaksin Anak 2', 'trim');

            $this->form_validation->set_rules('nama_anak3', 'Nama Anak 3', 'trim');
            $this->form_validation->set_rules('jk_anak3', 'Jenis Kelamin Anak 3', 'trim');
            $this->form_validation->set_rules('tmpt_lahir_anak3', 'Tempat Lahir Anak 3', 'trim');
            $this->form_validation->set_rules('tgl_lahir_anak3', 'Tanggal Lahir Anak 3', 'trim');
            $this->form_validation->set_rules('nik_anak3', 'NIK Anak 3', 'trim');
            $this->form_validation->set_rules('tgl_v1_anak3', 'Tanggal Vaksin 1 Anak 3', 'trim');
            $this->form_validation->set_rules('tmpt_v1_anak3', 'Tempat Vaksin 1 Anak 3', 'trim');
            $this->form_validation->set_rules('tgl_v2_anak3', 'Tanggal Vaksin 2 Anak 3', 'trim');
            $this->form_validation->set_rules('tmpt_v2_anak3', 'Tempat Vaksin 2 Anak 3', 'trim');
            $this->form_validation->set_rules('tgl_v3_anak3', 'Tanggal Vaksin 3 Anak 3', 'trim');
            $this->form_validation->set_rules('tmpt_v3_anak3', 'Tempat Vaksin 3 Anak 3', 'trim');
            $this->form_validation->set_rules('jenis_vaksin_anak3', 'Jenis Vaksin Anak 3', 'trim');
            $this->form_validation->set_rules('ket_vaksin_anak3', 'Keterangan Vaksin Anak 3', 'trim');

            $this->form_validation->set_rules('mom', 'Nama Ibu', 'trim');
            $this->form_validation->set_rules('tmpt_lahir_mom', 'Tempat Lahir Ibu', 'trim');
            $this->form_validation->set_rules('tgl_lahir_mom', 'Tanggal Lahir Ibu', 'trim');
            $this->form_validation->set_rules('dad', 'Nama Ayah', 'trim');
            $this->form_validation->set_rules('tmpt_lahir_dad', 'Tempat Lahir Ayah', 'trim');
            $this->form_validation->set_rules('tgl_lahir_dad', 'Tanggal Lahir Ayah', 'trim');

            $this->form_validation->set_rules('nama_kodar1', 'Nama Lengkap', 'trim');
            $this->form_validation->set_rules('firstname_kodar1', 'Nama Awal', 'trim');
            $this->form_validation->set_rules('lastname_kodar1', 'Nama Akhir', 'trim');
            $this->form_validation->set_rules('hubungan_kodar1', 'Hubungan', 'trim');
            $this->form_validation->set_rules('alamat_kodar1', 'Alamat', 'trim');
            $this->form_validation->set_rules('no_hp_kodar1', 'No HP', 'trim');
            $this->form_validation->set_rules('no_wa_kodar1', 'No WA', 'trim');

            $this->form_validation->set_rules('kronos_no', 'No Kronos', 'trim');
            $this->form_validation->set_rules('classification', 'Klasifikasi', 'trim');
            $this->form_validation->set_rules('department', 'Departemen', 'trim');
            $this->form_validation->set_rules('grade', 'Grade', 'trim');
            $this->form_validation->set_rules('no_sap', 'No SAP', 'trim');
            $this->form_validation->set_rules('tanggal_training', 'Tanggal Training', 'trim');
            $this->form_validation->set_rules('pns_id', 'PNS ID', 'trim');
            $this->form_validation->set_rules('aktif', 'Status Aktif Karyawan', 'trim');
            $this->form_validation->set_rules('tanggal_join', 'Tanggal Bergabung', 'trim');
            $this->form_validation->set_rules('tgl_out', 'Tanggal Keluar', 'trim');
            $this->form_validation->set_rules('status', 'Status Karyawan', 'trim');



            $config['upload_path'] = './assets/employee/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']     = '2048';
            $this->load->library('upload', $config);

            if (!empty($_FILES['foto']['name'])) {
                $this->upload->do_upload('foto');
                $id = $this->input->post('id');
                $old_img = $this->db->query("SELECT foto FROM employees WHERE id = '$id'")->row();
                if ($old_img != 'default.png') {
                    $target_file = './assets/employee/' . $old_img->foto;
                    unlink($target_file);
                }
                $data1 = $this->upload->data();
                $foto = $data1['file_name'];
            } 
            
            if (!empty($_FILES['foto_kk']['name'])) {
                $this->upload->do_upload('foto_kk');
                $old_img = $this->db->query("SELECT foto_kk FROM employees WHERE id = '$id'")->row();
                if ($old_img != 'default_kk.png') {
                    $target_file = './assets/employee/' . $old_img->foto;
                    unlink($target_file);
                }
                $data2 = $this->upload->data();
                $foto_kk = $data2['file_name'];
            } else {
                echo $this->upload->display_errors();
            }
            

            if (!empty($_FILES['foto_ktp']['name'])) {
                $this->upload->do_upload('foto_ktp');
                $old_img = $this->db->query("SELECT foto_ktp FROM employees WHERE id = '$id'")->row();
                if ($old_img != 'default_ktp.png') {
                    $target_file = './assets/employee/' . $old_img->foto;
                    unlink($target_file);
                }
                $data3 = $this->upload->data();
                $foto_ktp = $data3['file_name'];
            } else {
                echo $this->upload->display_errors();
            }
            

            if ($this->form_validation->run()) {
                $id                 = $this->input->post('id');
                $role_id            = $this->input->post('role_id');
                $employee_name      = $this->input->post('employee_name');
                $first_name         = $this->input->post('first_name');
                $last_name          = $this->input->post('last_name');
                $call_name          = $this->input->post('call_name');
                $jk                 = $this->input->post('jk');
                $bornplace          = $this->input->post('bornplace');
                $borndate           = $this->input->post('borndate');
                $gol_dar            = $this->input->post('gol_dar');
                $agama              = $this->input->post('agama');
                $suku               = $this->input->post('suku');
                $status_kawin       = $this->input->post('status_kawin');
                $tanggungan         = $this->input->post('tanggungan');
                $phoneNumber        = $this->input->post('phoneNumber');
                $waNumber           = $this->input->post('waNumber');
                $email              = $this->input->post('email');
                $pend_akhir         = $this->input->post('pend_akhir');
                $jurusan            = $this->input->post('jurusan');
                $tahun_lulus        = $this->input->post('tahun_lulus');
                $nama_sekolah       = $this->input->post('nama_sekolah');
                $kota_asal_sekolah  = $this->input->post('kota_asal_sekolah');
                $ukuran_baju        = $this->input->post('ukuran_baju');
                $ukuran_sepatu      = $this->input->post('ukuran_sepatu');
                $npwp               = $this->input->post('npwp');
                $mandiri            = $this->input->post('mandiri');
                $bpjs_kes           = $this->input->post('bpjs_kes');
                $status_bpjs_kes    = $this->input->post('status_bpjs_kes');
                $bpjs_tk            = $this->input->post('bpjs_tk');
                $status_bpjs_tk     = $this->input->post('status_bpjs_tk');

                $nik                = $this->input->post('nik');
                $no_kk              = $this->input->post('no_kk');
                $kota_ktp           = $this->input->post('kota_ktp');
                $tgl_vaksin_1       = $this->input->post('tgl_vaksin_1');
                $tmpt_vaksin_1      = $this->input->post('tmpt_vaksin_1');
                $tgl_vaksin_2       = $this->input->post('tgl_vaksin_2');
                $tmpt_vaksin_2      = $this->input->post('tmpt_vaksin_2');
                $tgl_vaksin_3       = $this->input->post('tgl_vaksin_3');
                $tmpt_vaksin_3      = $this->input->post('tmpt_vaksin_3');
                $jenis_vaksin       = $this->input->post('jenis_vaksin');
                $jenis_vaksin_3       = $this->input->post('jenis_vaksin_3');

                $address_ktp        = $this->input->post('address_ktp');
                $rt_ktp             = $this->input->post('rt_ktp');
                $rw_ktp             = $this->input->post('rw_ktp');
                $kel_ktp            = $this->input->post('kel_ktp');
                $kec_ktp            = $this->input->post('kec_ktp');
                $kab_ktp            = $this->input->post('kab_ktp');
                $prov_ktp           = $this->input->post('prov_ktp');

                $address_btm        = $this->input->post('address_btm');
                $rt_btm             = $this->input->post('rt_btm');
                $rw_btm             = $this->input->post('rw_btm');
                $kel_btm            = $this->input->post('kel_btm');
                $kec_btm            = $this->input->post('kec_btm');
                $kode_pos           = $this->input->post('kode_pos');

                $nama_pasang        = $this->input->post('nama_pasang');
                $jk_pasang          = $this->input->post('jk_pasang');
                $tmpt_lahir_pasang  = $this->input->post('tmpt_lahir_pasang');
                $tgl_lahir_pasang   = $this->input->post('tgl_lahir_pasang');
                $nik_pasang         = $this->input->post('nik_pasang');
                $no_hp_pasang       = $this->input->post('no_hp_pasang');
                $tgl_v1_pas         = $this->input->post('tgl_v1_pas');
                $tmpt_v1_pas        = $this->input->post('tmpt_v1_pas');
                $tgl_v2_pas         = $this->input->post('tgl_v2_pas');
                $tmpt_v2_pas        = $this->input->post('tmpt_v2_pas');
                $tgl_v3_pas         = $this->input->post('no_hp_pasang');
                $tmpt_v3_pas        = $this->input->post('no_hp_pasang');
                $jenis_v_pas        = $this->input->post('jenis_v_pas');
                $ket_v_pas          = $this->input->post('ket_v_pas');

                $nama_anak1         = $this->input->post('nama_anak1');
                $jk_anak1           = $this->input->post('jk_anak1');
                $tmpt_lahir_anak1   = $this->input->post('tmpt_lahir_anak1');
                $tgl_lahir_anak1    = $this->input->post('tgl_lahir_anak1');
                $nik_anak1          = $this->input->post('nik_anak1');
                $tgl_v1_anak1       = $this->input->post('tgl_v1_anak1');
                $tmpt_v1_anak1      = $this->input->post('tmpt_v1_anak1');
                $tgl_v2_anak1       = $this->input->post('tgl_v2_anak1');
                $tmpt_v2_anak1      = $this->input->post('tmpt_v2_anak1');
                $tgl_v3_anak1       = $this->input->post('tgl_v3_anak1');
                $tmpt_v3_anak1      = $this->input->post('tmpt_v3_anak1');
                $jenis_vaksin_anak1 = $this->input->post('jenis_vaksin_anak1');
                $ket_v_anak1        = $this->input->post('ket_v_anak1');

                $nama_anak2         = $this->input->post('nama_anak2');
                $jk_anak2           = $this->input->post('jk_anak2');
                $tmpt_lahir_anak2   = $this->input->post('tmpt_lahir_anak2');
                $tgl_lahir_anak2    = $this->input->post('tgl_lahir_anak2');
                $nik_anak2          = $this->input->post('nik_anak2');
                $tgl_v1_anak2       = $this->input->post('tgl_v1_anak2');
                $tmpt_v1_anak2      = $this->input->post('tmpt_v1_anak2');
                $tgl_v2_anak2       = $this->input->post('tgl_v2_anak2');
                $tmpt_v2_anak2      = $this->input->post('tmpt_v2_anak2');
                $tgl_v3_anak2       = $this->input->post('tgl_v3_anak2');
                $tmpt_v3_anak2      = $this->input->post('tmpt_v3_anak2');
                $jenis_vaksin_anak2 = $this->input->post('jenis_vaksin_anak2');
                $ket_v_anak2        = $this->input->post('ket_v_anak2');

                $nama_anak3         = $this->input->post('nama_anak3');
                $jk_anak3           = $this->input->post('jk_anak3');
                $tmpt_lahir_anak3   = $this->input->post('tmpt_lahir_anak3');
                $tgl_lahir_anak3    = $this->input->post('tgl_lahir_anak3');
                $nik_anak3          = $this->input->post('nik_anak3');
                $tgl_v1_anak3       = $this->input->post('tgl_v1_anak3');
                $tmpt_v1_anak3      = $this->input->post('tmpt_v1_anak3');
                $tgl_v2_anak3       = $this->input->post('tgl_v2_anak3');
                $tmpt_v2_anak3      = $this->input->post('tmpt_v2_anak3');
                $tgl_v3_anak3       = $this->input->post('tgl_v3_anak3');
                $tmpt_v3_anak3      = $this->input->post('tmpt_v3_anak3');
                $jenis_vaksin_anak3 = $this->input->post('jenis_vaksin_anak3');
                $ket_vaksin_anak3   = $this->input->post('ket_vaksin_anak3');

                $mom                = $this->input->post('mom');
                $tmpt_lahir_mom     = $this->input->post('tmpt_lahir_mom');
                $tgl_lahir_mom      = $this->input->post('tgl_lahir_mom');
                $dad                = $this->input->post('dad');
                $tmpt_lahir_dad     = $this->input->post('tmpt_lahir_dad');
                $tgl_lahir_dad      = $this->input->post('tgl_lahir_dad');

                $nama_kodar1        = $this->input->post('nama_kodar1');
                $firstname_kodar1   = $this->input->post('firstname_kodar1');
                $lastname_kodar1    = $this->input->post('lastname_kodar1');
                $hubungan_kodar1    = $this->input->post('hubungan_kodar1');
                $alamat_kodar1      = $this->input->post('alamat_kodar1');
                $no_hp_kodar1       = $this->input->post('no_hp_kodar1');
                $no_wa_kodar1       = $this->input->post('no_wa_kodar1');

                $kronos_no          = $this->input->post('kronos_no');
                $classification     = $this->input->post('classification');
                $department         = $this->input->post('department');
                $grade              = $this->input->post('grade');
                $no_sap             = $this->input->post('no_sap');
                $tanggal_training   = $this->input->post('tanggal_training');
                $pns_id             = $this->input->post('pns_id');
                $aktif              = $this->input->post('aktif');
                $tanggal_join       = $this->input->post('tanggal_join');
                $tgl_out            = $this->input->post('tgl_out');
                $status             = $this->input->post('status');
                $foto               = $_FILES['foto']['name'];
                $foto_kk            = $_FILES['foto_kk']['name'];
                $foto_ktp           = $_FILES['foto_ktp']['name'];
                $updated_at         = date("Y/m/d h:i:s");


                $data = array(
                    'employee_name'     => $employee_name,
                    'first_name'        => $first_name,
                    'last_name'         => $last_name,
                    'call_name'         => $call_name,
                    'jk'                => $jk,
                    'bornplace'         => $bornplace,
                    'borndate'          => $borndate,
                    'gol_dar'           => $gol_dar,
                    'agama'             => $agama,
                    'suku'              => $suku,
                    'status_kawin'      => $status_kawin,
                    'tanggungan'        => $tanggungan,
                    'phoneNumber'       => $phoneNumber,
                    'waNumber'          => $waNumber,
                    'email'             => $email,
                    'pend_akhir'        => $pend_akhir,
                    'jurusan'           => $jurusan,
                    'tahun_lulus'       => $tahun_lulus,
                    'nama_sekolah'      => $nama_sekolah,
                    'kota_asal_sekolah' => $kota_asal_sekolah,
                    'ukuran_baju'       => $ukuran_baju,
                    'ukuran_sepatu'     => $ukuran_sepatu,
                    'npwp'              => $npwp,
                    'mandiri'           => $mandiri,
                    'bpjs_kes'          => $bpjs_kes,
                    'status_bpjs_kes'   => $status_bpjs_kes,
                    'bpjs_tk'           => $bpjs_tk,
                    'status_bpjs_tk'    => $status_bpjs_tk,

                    'nik'               => $nik,
                    'no_kk'             => $no_kk,
                    'kota_ktp'          => $kota_ktp,
                    'tgl_vaksin_1'      => $tgl_vaksin_1,
                    'tmpt_vaksin_1'     => $tmpt_vaksin_1,
                    'tgl_vaksin_2'      => $tgl_vaksin_2,
                    'tmpt_vaksin_2'     => $tmpt_vaksin_2,
                    'tgl_vaksin_3'      => $tgl_vaksin_3,
                    'tmpt_vaksin_3'     => $tmpt_vaksin_3,
                    'jenis_vaksin'      => $jenis_vaksin,
                    'jenis_vaksin_3'    => $jenis_vaksin_3,

                    'address_ktp'       => $address_ktp,
                    'rt_ktp'            => $rt_ktp,
                    'rw_ktp'            => $rw_ktp,
                    'kel_ktp'           => $kel_ktp,
                    'kec_ktp'           => $kec_ktp,
                    'kab_ktp'           => $kab_ktp,
                    'prov_ktp'          => $prov_ktp,

                    'address_btm'       => $address_btm,
                    'rt_btm'            => $rt_btm,
                    'rw_btm'            => $rw_btm,
                    'kel_btm'           => $kel_btm,
                    'kec_btm'           => $kec_btm,
                    'kode_pos'          => $kode_pos,

                    'nama_pasang'       => $nama_pasang,
                    'jk_pasang'         => $jk_pasang,
                    'tmpt_lahir_pasang' => $tmpt_lahir_pasang,
                    'tgl_lahir_pasang'  => $tgl_lahir_pasang,
                    'nik_pasang'        => $nik_pasang,
                    'no_hp_pasang'      => $no_hp_pasang,
                    'tgl_v1_pas'        => $tgl_v1_pas,
                    'tmpt_v1_pas'       => $tmpt_v1_pas,
                    'tgl_v2_pas'        => $tgl_v2_pas,
                    'tmpt_v2_pas'       => $tmpt_v2_pas,
                    'tgl_v3_pas'        => $tgl_v3_pas,
                    'tmpt_v3_pas'       => $tmpt_v3_pas,
                    'jenis_v_pas'       => $jenis_v_pas,
                    'ket_v_pas'         => $ket_v_pas,

                    'nama_anak1'        => $nama_anak1,
                    'jk_anak1'          => $jk_anak1,
                    'tmpt_lahir_anak1'  => $tmpt_lahir_anak1,
                    'tgl_lahir_anak1'   => $tgl_lahir_anak1,
                    'nik_anak1'         => $nik_anak1,
                    'tgl_v1_anak1'      => $tgl_v1_anak1,
                    'tmpt_v1_anak1'     => $tmpt_v1_anak1,
                    'tgl_v2_anak1'      => $tgl_v2_anak1,
                    'tmpt_v2_anak1'     => $tmpt_v2_anak1,
                    'tgl_v3_anak1'      => $tgl_v3_anak1,
                    'tmpt_v3_anak1'     => $tmpt_v3_anak1,
                    'jenis_vaksin_anak1' => $jenis_vaksin_anak1,
                    'ket_v_anak1'       => $ket_v_anak1,

                    'nama_anak2'        => $nama_anak2,
                    'jk_anak2'          => $jk_anak2,
                    'tmpt_lahir_anak2'  => $tmpt_lahir_anak2,
                    'tgl_lahir_anak2'   => $tgl_lahir_anak2,
                    'nik_anak2'         => $nik_anak2,
                    'tgl_v1_anak2'      => $tgl_v1_anak2,
                    'tmpt_v1_anak2'     => $tmpt_v1_anak2,
                    'tgl_v2_anak2'      => $tgl_v2_anak2,
                    'tmpt_v2_anak2'     => $tmpt_v2_anak2,
                    'tgl_v3_anak2'      => $tgl_v3_anak2,
                    'tmpt_v3_anak2'     => $tmpt_v3_anak2,
                    'jenis_vaksin_anak2' => $jenis_vaksin_anak2,
                    'ket_v_anak2'       => $ket_v_anak2,

                    'nama_anak3'        => $nama_anak3,
                    'jk_anak3'          => $jk_anak3,
                    'tmpt_lahir_anak3'  => $tmpt_lahir_anak3,
                    'tgl_lahir_anak3'   => $tgl_lahir_anak3,
                    'nik_anak3'         => $nik_anak3,
                    'tgl_v1_anak3'      => $tgl_v1_anak3,
                    'tmpt_v1_anak3'     => $tmpt_v1_anak3,
                    'tgl_v2_anak3'      => $tgl_v2_anak3,
                    'tmpt_v2_anak3'     => $tmpt_v2_anak3,
                    'tgl_v3_anak3'      => $tgl_v3_anak3,
                    'tmpt_v3_anak3'     => $tmpt_v3_anak3,
                    'jenis_vaksin_anak3' => $jenis_vaksin_anak3,
                    'ket_vaksin_anak3'  => $ket_vaksin_anak3,

                    'mom'               => $mom,
                    'tmpt_lahir_mom'    => $tmpt_lahir_mom,
                    'tgl_lahir_mom'     => $tgl_lahir_mom,
                    'dad'               => $dad,
                    'tmpt_lahir_dad'    => $tmpt_lahir_dad,
                    'tgl_lahir_dad'     => $tgl_lahir_dad,

                    'nama_kodar1'       => $nama_kodar1,
                    'firstname_kodar1'  => $firstname_kodar1,
                    'lastname_kodar1'   => $lastname_kodar1,
                    'hubungan_kodar1'   => $hubungan_kodar1,
                    'alamat_kodar1'     => $alamat_kodar1,
                    'no_hp_kodar1'      => $no_hp_kodar1,
                    'no_wa_kodar1'      => $no_wa_kodar1,

                    'kronos_no'         => $kronos_no,
                    'classification'    => $classification,
                    'department'        => $department,
                    'grade'             => $grade,
                    'no_sap'            => $no_sap,
                    'tanggal_training'  => $tanggal_training,
                    'tanggal_join'      => $tanggal_join,
                    'pns_id'            => $pns_id,
                    'aktif'             => $aktif,
                    'tgl_out'           => $tgl_out,
                    'status'            => $status,

                    'foto'              => $foto,
                    'foto_kk'           => $foto_kk,
                    'foto_ktp'          => $foto_ktp,
                    'updated_at'        => $updated_at,
                );

                $where = array(
                    'id' => $id
                );


                $this->db->update('employees', $data, $where);
                $this->session->set_flashdata('message', '<div class="alert alert-success"><strong> Update Success.</strong></div>');

                if ($role_id == '1') {
                    redirect('admin/employees');
                } else {
                    redirect('user/profile_employee');
                }
            } else {
                echo $this->upload->display_errors();
            }
        }
    }