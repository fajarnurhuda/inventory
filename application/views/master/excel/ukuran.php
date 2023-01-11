<?php
header("Content-type:application/octet-stream/");
header("Content-Disposition:attachment; filename=$title.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<style>
    .tab {
        font-family: sans-serif;
        color: #444;
        border-collapse: collapse;
        width: 20%;
        border: 1px solid #444;
    }

    .tab tr th {
        background: #35A9DB;
        color: #fff;
        font-weight: normal;
    }

    .tab,
    th,
    td {
        padding: 5px 5px;
        text-align: center;
        border: 1px solid #444;
    }
</style>
<div class="card-body">
    <div class="table-responsive">

        <table class="tab">
            <thead>
                <tr>
                    <td colspan="3" style="text-align:center;">
                        <strong>Data Ukuran PT PNS <br><?= date('j F Y') ?></strong>
                    </td>
                </tr>
                <tr>
                    <th>No</th>
                    <th>Nama Ukuran</th>
                    <th>Nama Barang</th>
                </tr>
            </thead>

            <tbody>
                <?php $no = 1;
                if (!empty($ukuran)) : ?>
                    <?php foreach ($ukuran as $row) : ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row->nama_ukuran ?></td>
                            <td><?php echo $row->nama_barang ?></td>
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