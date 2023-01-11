<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- DataTales Example -->
    <?php echo $this->session->flashdata('message_edit') ?>
    <?php echo $this->session->flashdata('message_success') ?>
    <?php echo $this->session->flashdata('message') ?>

    <h1 class="h3 mb-4 text-gray-800">Setting Stok Minimum</h1>
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Ukuran Barang</th>
                            <th>Jumlah Minimum</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($stok_min as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?php echo $row['nama_barang'] ?></td>
                                <td><?php echo $row['nama_ukuran'] ?></td>
                                <td><?php echo $row['min_stok'] ?></td>
                                <td>
                                    <a href="<?= site_url('stok/ubah_data/' . $row['id_ukuran']) ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
</div>