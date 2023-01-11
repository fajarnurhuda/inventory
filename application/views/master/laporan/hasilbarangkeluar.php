<!doctype html>
<html lang="en">

<?php $stok = []; ?>

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
                            <label for="dari">Nama Barang </label>
                            <select name="nama_barang" class="form-control mb-3" required autofocus>
                                <option value="">- Pilih Barang -</option>
                                <?php foreach ($listbarang as $b) { ?>
                                    <option value="<?= $b['id_barang'] ?>"><?= $b['nama_barang'] ?></option>
                                <?php } ?>
                            </select>
                            <label for="dari">Dari</label>
                            <input type="date" name="dari" id="dari" class="form-control mb-3" required>
                            <label for="sampai">Sampai</label>
                            <input type="date" name="sampai" id="sampai" class="form-control mb-3" required>
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
                                <th rowspan="2">No</th>
                                <th rowspan="2">Tanggal</th>
                                <th rowspan="2">Karyawan</th>
                                <th rowspan="2">Nama Barang</th>

                                <th colspan="<?= $ukuran ?>">Jumlah Masuk</th>
                                <th colspan="<?= $ukuran ?>">Jumlah Keluar</th>
                                <th colspan="<?= $ukuran ?>">Jumlah Stok</th>
                            </tr>
                            <tr>
                                <?php foreach ($barang as $row) : ?>
                                    <th><?= $row['nama_ukuran'] ?></th>
                                    <?php $stok[$row['nama_ukuran']] = 0; ?>
                                <?php endforeach; ?>
                                <?php foreach ($barang as $row) : ?>
                                    <th><?= $row['nama_ukuran'] ?></th>
                                <?php endforeach; ?>
                                <?php foreach ($barang as $row) : ?>
                                    <th><?= $row['nama_ukuran'] ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            if (!empty($caribarang)) : ?>
                                <?php foreach ($caribarang as $row) : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row->tanggal ?></td>
                                        <td><?php echo $row->karyawan ?></td>
                                        <td><?php echo $row->nama_barang ?></td>
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if ($b['nama_ukuran'] == $row->nama_ukuran) : ?>
                                                <?php if (empty($row->jumlah_masuk)) : ?>
                                                    <td></td>
                                                <?php else : ?>
                                                    <td><?php echo $row->jumlah_masuk ?></td>
                                                    <?php $stok[$row->nama_ukuran] += $row->jumlah_masuk ?>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <td></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if ($b['nama_ukuran'] == $row->nama_ukuran) : ?>
                                                <?php if (empty($row->jumlah_keluar)) : ?>
                                                    <td></td>
                                                <?php else : ?>
                                                    <td><?php echo $row->jumlah_keluar ?></td>
                                                    <?php $stok[$row->nama_ukuran] -= $row->jumlah_keluar ?>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <td></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if (empty($stok[$b['nama_ukuran']])) : ?>
                                                <td> - </td>
                                            <?php else : ?>
                                                <td>
                                                    <?php echo $stok[$b['nama_ukuran']]; ?>
                                                </td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="9" align="center">Tidak Ada Data</td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
                <br>
                <a href="<?php
                            $dari = $this->input->post('dari');
                            $sampai = $this->input->post('sampai');
                            $barang = $this->input->post('nama_barang');

                            echo base_url('Laporan/export_excel/') . $dari . '/' . $sampai . '/' . $barang ?>" target="_blank">
                    <input type="submit" value="Export Excel" class="btn btn-primary"><br>
                </a>
            </div>
        </div>
    </div>
    <!-- end laporan -->
</body>

</html>
</div>