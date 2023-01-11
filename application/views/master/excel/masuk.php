<?php
header("Content-type:application/octet-stream/");
header("Content-Disposition:attachment; filename=$title.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<h3>Laporan Total Masuk <?= date('d F Y') ?></h3>
<table class="table table-bordered" border="1" id="tableku" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Masuk</th>
            <th>Nama Barang</th>
            <th>Ukuran</th>
            <th>Karyawan</th>
            <th>Jumlah Masuk</th>
            <th>Ket Masuk</th>

        </tr>
    </thead>

    <tbody>
        <?php $no = 1;
        $total_masuk = 0;
        if (!empty($caribarang)) : ?>
            <?php foreach ($caribarang as $row) :
                $total_masuk += $row->jumlah_masuk; ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo date('d-M-Y', strtotime($row->tanggal)) ?></td>
                    <td><?php echo $row->nama_barang ?></td>
                    <td><?php echo $row->nama_ukuran ?></td>
                    <td><?php echo $row->admin ?></td>
                    <td><?php echo $row->jumlah_masuk ?></td>
                    <td><?php echo $row->ket_masuk ?></td>

                </tr>
            <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td colspan="9" align="center">Tidak Ada Data</td>
            </tr>
        <?php endif ?>
    </tbody>
    <tfoot>
        <th colspan="5" style="text-align:center;">Total</th>
        <th><?= $total_masuk ?></th>
        <th></th>
    </tfoot>
</table>