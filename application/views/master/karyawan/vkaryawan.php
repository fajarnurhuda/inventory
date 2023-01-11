 <!-- Begin Page Content -->
 <div class="container-fluid">
     <!-- DataTales Example -->
     <?php echo $this->session->flashdata('message_edit') ?>
     <?php echo $this->session->flashdata('message_success') ?>
     <?php echo $this->session->flashdata('message') ?>

     <h1 class="h3 mb-4 text-gray-800">Data Karyawan</h1>
     <div class="card shadow mb-4">
         <div class="card-header py-3">
             <?php if ($this->session->userdata('level') == 'admin') : ?>
                 <a href="<?php echo base_url('Karyawan/add_view') ?>">
                     <button class="btn btn-sm btn-primary" type=""><i class="fas fa-plus fa-sm"></i> Tambah Karyawan</button>
                 </a>
                 <a href="" data-toggle="modal" data-target="#exampleModal">
                     <button class="btn btn-sm btn-info" type=""><i class="fas fa-upload fa-sm"></i> Import Karyawan</button>
                 </a>
                 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                         <form action="<?php echo base_url('Karyawan/add_view') ?>" method="POST" enctype="multipart/form-data">
                             <div class="modal-content">
                                 <div class="modal-header">
                                     <h5 class="modal-title" id="exampleModalLabel">Import Karyawan</h5>
                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                         <span aria-hidden="true">&times;</span>
                                     </button>
                                 </div>
                                 <div class="modal-body">
                                     <input type="file" name="import" accept=".xls,.xlsx">
                                 </div>
                                 <div class="modal-footer">
                                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                     <button type="submit" class="btn btn-primary" name="tambah">
                                         Tambah
                                     </button>
                                     <a href="<?php echo base_url('assets/') ?>template.xlsx" class="btn btn-info" class="btn btn-info">Template</a>
                                 </div>
                             </div>
                         </form>
                     </div>
                 </div>
             <?php
                endif;
                ?>
         </div>
         <div class="card-body">
             <div class="table-responsive">
                 <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                     <thead>
                         <tr>
                             <th>No</th>
                             <th>PNS ID</th>
                             <th>Nama Karyawan</th>
                             <th>Aksi</th>
                         </tr>
                     </thead>

                     <tbody>
                         <?php $no = 1;
                            if (!empty($karyawan)) : ?>
                             <?php foreach ($karyawan as $row) : ?>
                                 <tr>
                                     <td><?php echo $no++; ?></td>
                                     <td><?php echo $row->pns_id ?></td>
                                     <td><?php echo $row->nama_karyawan ?></td>
                                     <td>
                                         <a href="<?= site_url('karyawan/ubah_data/' . $row->id_karyawan) ?>">
                                             <i class="fas fa-edit"></i>
                                         </a>
                                         |
                                         <a href="<?= site_url('karyawan/delete/' . $row->id_karyawan) ?>">
                                             <i class="fas fa-trash"></i>
                                         </a>
                                     </td>
                                 </tr>
                             <?php endforeach ?>
                         <?php else : ?>
                             <tr>
                                 <td colspan="9" align="center">Tidak Ada Data</td>
                             </tr>
                         <?php endif ?>
                     </tbody>
                 </table>
             </div>
         </div>
     </div>

 </div>
 <!-- /.container-fluid -->
 </div>