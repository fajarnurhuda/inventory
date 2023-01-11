<?php
header("Content-type:application/octet-stream/");
header("Content-Disposition:attachment; filename=$title.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<style>
    table td {
        table-layout: fixed;
        border: 1px;
        overflow: hidden;
        word-wrap: break-word;
    }
</style>
<div class="card-body">
    <div class="table-responsive">
        <h3>Laporan STOK BARANG PT PNS <?= date('d F Y') ?> </h3>
        <table class="table table-bordered" border="1" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Ukuran Barang</th>
                    <th>Stok</th>
                </tr>
            </thead>

            <tbody>
                <?php $no = 1;

                if (!empty($ukuran)) : ?>
                    <?php foreach ($ukuran as $row) :
                    ?>
                        <tr>
                            <td style="text-align:center;"><?php echo $no++; ?></td>
                            <td style="text-align:center;"><?php echo $row->nama_barang ?></td>
                            <td style="text-align:center;"><?php echo $row->nama_ukuran ?></td>
                            <?php
                            $id_u = $row->id_ukuran;
                            $s_masuk = $this->db->query("SELECT SUM(jumlah_masuk) as s_m FROM tbl_transaksi_masuk WHERE id_ukuran = '$id_u'")->row_array();
                            $s_keluar = $this->db->query("SELECT SUM(jumlah_keluar) as s_k FROM tbl_transaksi_keluar WHERE id_ukuran = '$id_u'")->row_array();
                            $tot = $s_masuk['s_m'] - $s_keluar['s_k'];
                            if ($tot <= $row->min_stok) {
                                echo "<td bgcolor='yellow'; text-align:'center';>" . $tot . "</td>";
                            } else {
                                echo "<td>" . $tot . "</td>";
                            } ?>
                        </tr>
                    <?php endforeach ?>
                <?php else : ?>
                    <tr>
                        <td colspan="9" align="center">Tidak Ada Data</td>
                    </tr>
                <?php endif ?>
            </tbody>
            <tfoot>
                <th colspan="3" style="text-align:center;">Total</th>
                <th>
                    <?php
                    $s_masuk = $this->db->query("SELECT SUM(jumlah_masuk) as s_m FROM tbl_transaksi_masuk")->row_array();
                    $s_keluar = $this->db->query("SELECT SUM(jumlah_keluar) as s_k FROM tbl_transaksi_keluar")->row_array();
                    $total = $s_masuk['s_m'] - $s_keluar['s_k'];
                    echo "$total";
                    ?>
                </th>
            </tfoot>
        </table>
    </div>
</div>