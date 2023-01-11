<?php foreach ($barang as $b) : ?>
    <?php if (($b['nama_ukuran'] == $row->nama_ukuran) && ) : ?>
        <?php if ($row->jumlah_stok != '') : ?>
            <td><?php echo $row->jumlah_stok ?></td>
        <?php else : ?>
            <td></td>
        <?php endif; ?>
    <?php else : ?>
        <td>
            <?php
            $sin = $this->db->query("SELECT jumlah_stok FROM `stok1` WHERE id_ukuran = '$row->id_ukuran' AND tanggal < '$row->tanggal' ORDER BY id_stok DESC LIMIT 1")->row_array();
            echo " $sin";
            ?>
        </td>
    <?php endif; ?>
<?php endforeach; ?>


<!-- <td>
<?php
                                                    $sin = $this->db->query("SELECT jumlah_stok FROM stok1 WHERE id_ukuran = '$row->id_ukuran' AND tanggal < '$row->tanggal' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                                    var_dump($sin);
                                                    die;
                                                    ?>
                                                </td> -->

                                                <?php if (($b['nama_ukuran'] == $row->nama_ukuran) && ($row->jumlah_stok != '')) : ?>
                                                <td><?php echo $row->jumlah_stok ?></td>
                                            <?php elseif (($b['nama_ukuran'] == $row->nama_ukuran) && ($row->jumlah_stok == 'NULL')) : ?>
                                                <td>4</td>
                                            <?php endif; ?>

                                            <?php if (($b['nama_ukuran'] == $row->nama_ukuran)) : ?>
                                                <?php if ($row->jumlah_stok != '') : ?>
                                                    <td><?php echo $row->jumlah_stok ?></td>
                                                <?php else : ?>
                                                    <td></td>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <td>

                                                </td>
                                            <?php endif; ?>

                                            <?php
                                        @@$temukan = $this->db->query("SELECT * from stok1 JOIN tbl_ukuran ON tbl_ukuran.id_ukuran = stok1.id_ukuran WHERE tbl_ukuran.nama_ukuran = '$b[nama_ukuran]'")->row_array();
                                        @@$st = $this->db->query("SELECT jumlah_stok FROM stok1 WHERE id_ukuran = '$temukan[id_ukuran]' AND tanggal <= '$row->tanggal' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                        if (@@$st['jumlah_stok'] == '') {
                                            echo "<td>-</td>";
                                        } else {
                                            echo "<td>" . $st['jumlah_stok'] . "</td>";
                                        }
                                        ?>


                                        <td>
                                            <?php
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '18' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '18' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                                if ($st != '') {
                                                    echo $st['jumlah_stok'];;
                                                } else {
                                                    echo '-';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '19' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '19' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                                if ($st != '') {
                                                    echo $st['jumlah_stok'];;
                                                } else {
                                                    echo '-';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?php
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '20' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '20' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                                if ($st != '') {
                                                    echo $st['jumlah_stok'];;
                                                } else {
                                                    echo '-';
                                                }
                                            }
                                            ?></td>
                                        <td>
                                            <?php
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '21' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '21' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                                if ($st != '') {
                                                    echo $st['jumlah_stok'];;
                                                } else {
                                                    echo '-';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '22' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '22' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                                if ($st != '') {
                                                    echo $st['jumlah_stok'];;
                                                } else {
                                                    echo '-';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '23' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '23' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                                if ($st != '') {
                                                    echo $st['jumlah_stok'];;
                                                } else {
                                                    echo '-';
                                                }
                                            }
                                            ?>
                                        </td>
