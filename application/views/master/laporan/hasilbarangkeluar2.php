<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Laporan Excel</h1>
        <div class="row">
            <div class="col-lg-12">
                <!-- Circle Buttons -->
                <div class="card shadow mb-12">
                    <div class="card-body">
                        <form method="post" action="<?= base_url('Laporan-masuk-cari-keluar') ?>" autocomplete="off">
                            <label for="dari">Dari</label>
                            <input type="date" name="dari" id="dari" class="form-control mb-2">
                            <label for="sampai">Sampai</label>
                            <input type="date" name="sampai" id="sampai" class="form-control mb-2">
                            <label for="nama_barang">Nama Barang</label>
                            <select name="id_barang" class="form-control mb-2" id="id_barang" autofocus>
                                <option value="">--Pilih Semua Barang--</option>
                                <?php foreach ($barang as $br) { ?>
                                    <option value="<?= $br->id_barang ?>"><?= $br->nama_barang ?> </option>
                                <?php } ?>
                            </select>
                            <label for="ukuran_barang">Ukuran Barang</label>
                            <select name="id_ukuran" class="form-control mb-3" id="id_ukuran" autofocus>

                            </select>
                            <input type="submit" value="Cari" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- laporan -->
    <br><br>

    <div class="container-fluid">
        <div class="card shadow mb-12">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pegawai</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($tanggal as $row) : ?>

                                <tr>
                                    <td><?php echo $row->tanggal ?></td>
                                    <td><?php echo $row->karyawan ?></td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
                <br>
                <a href="<?php
                            $dari = $this->input->post('dari');
                            $sampai = $this->input->post('sampai');
                            $barang = $this->input->post('nama_barang');

                            echo base_url('Export-pdf-laporan-keluar/') . $dari . '/' . $sampai . '/' . $barang ?>">
                    <input type="submit" value="Export Excel" class="btn btn-primary"><br>
                </a>
            </div>
        </div>
    </div>
    <!-- end laporan -->
</body>

</html>
</div>