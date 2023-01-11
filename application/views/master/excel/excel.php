<?php
header("Content-type:application/octet-stream/");
header("Content-Disposition:attachment; filename=$title.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<div class="container-fluid">
    <div class="card shadow mb-12">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" border="1" id="dataTable" width="100%" cellspacing="0">
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
                                <?php $ukb[] = $row['nama_ukuran']; ?>
                            <?php endforeach; ?>
                            <?php foreach ($barang as $row) : ?>
                                <th><?= $row['nama_ukuran'] ?></th>
                                <?php $ukb[] = $row['nama_ukuran']; ?>
                            <?php endforeach; ?>
                            <?php foreach ($barang as $row) : ?>
                                <th><?= $row['nama_ukuran'] ?></th>
                                <?php $ukb[] = $row['nama_ukuran']; ?>
                            <?php endforeach; ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1;
                        if (!empty($caribarang)) : ?>
                            <?php foreach ($caribarang as $row) : ?>
                                <?php if ($row->id_barang == '5') : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row->tanggal ?></td>
                                        <td><?php echo $row->karyawan ?></td>
                                        <td><?php echo $row->nama_barang ?></td>
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if ($b['nama_ukuran'] == $row->nama_ukuran) : ?>
                                                <?php if ($row->jumlah_masuk == '0') : ?>
                                                    <td></td>
                                                <?php else : ?>
                                                    <td><?php echo $row->jumlah_masuk ?></td>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <td></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if ($b['nama_ukuran'] == $row->nama_ukuran) : ?>
                                                <?php if ($row->jumlah_keluar == '0') : ?>
                                                    <td></td>
                                                <?php else : ?>
                                                    <td><?php echo $row->jumlah_keluar ?></td>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <td></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

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
                                    </tr>
                                <?php elseif ($row->id_barang == '1') : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row->tanggal ?></td>
                                        <td><?php echo $row->karyawan ?></td>
                                        <td><?php echo $row->nama_barang ?></td>
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if ($b['nama_ukuran'] == $row->nama_ukuran) : ?>
                                                <?php if ($row->jumlah_masuk == '0') : ?>
                                                    <td></td>
                                                <?php else : ?>
                                                    <td><?php echo $row->jumlah_masuk ?></td>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <td></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if ($b['nama_ukuran'] == $row->nama_ukuran) : ?>
                                                <?php if ($row->jumlah_keluar == '0') : ?>
                                                    <td></td>
                                                <?php else : ?>
                                                    <td><?php echo $row->jumlah_keluar ?></td>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <td></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <td>
                                            <?php
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '1' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '1' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '2' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '2' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                                if ($st != '') {
                                                    echo $st['jumlah_stok'];;
                                                } else {
                                                    echo '-';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?php
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '3' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '3' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                                if ($st != '') {
                                                    echo $st['jumlah_stok'];;
                                                } else {
                                                    echo '-';
                                                }
                                            }
                                            ?></td>
                                        <td>
                                            <?php
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '4' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '4' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '5' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '5' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '6' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '6' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '7' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '7' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '8' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '8' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                                if ($st != '') {
                                                    echo $st['jumlah_stok'];;
                                                } else {
                                                    echo '-';
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php elseif ($row->id_barang == '2') : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row->tanggal ?></td>
                                        <td><?php echo $row->karyawan ?></td>
                                        <td><?php echo $row->nama_barang ?></td>
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if ($b['nama_ukuran'] == $row->nama_ukuran) : ?>
                                                <?php if ($row->jumlah_masuk == '0') : ?>
                                                    <td></td>
                                                <?php else : ?>
                                                    <td><?php echo $row->jumlah_masuk ?></td>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <td></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if ($b['nama_ukuran'] == $row->nama_ukuran) : ?>
                                                <?php if ($row->jumlah_keluar == '0') : ?>
                                                    <td></td>
                                                <?php else : ?>
                                                    <td><?php echo $row->jumlah_keluar ?></td>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <td></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <td>
                                            <?php
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '11' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '11' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '12' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '12' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                                if ($st != '') {
                                                    echo $st['jumlah_stok'];;
                                                } else {
                                                    echo '-';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?php
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '13' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '13' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                                if ($st != '') {
                                                    echo $st['jumlah_stok'];;
                                                } else {
                                                    echo '-';
                                                }
                                            }
                                            ?></td>
                                        <td>
                                            <?php
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '14' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '14' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '15' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '15' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '16' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '16' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '17' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '17' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                                if ($st != '') {
                                                    echo $st['jumlah_stok'];;
                                                } else {
                                                    echo '-';
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php elseif ($row->id_barang == '3') : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row->tanggal ?></td>
                                        <td><?php echo $row->karyawan ?></td>
                                        <td><?php echo $row->nama_barang ?></td>
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if ($b['nama_ukuran'] == $row->nama_ukuran) : ?>
                                                <?php if ($row->jumlah_masuk == '0') : ?>
                                                    <td></td>
                                                <?php else : ?>
                                                    <td><?php echo $row->jumlah_masuk ?></td>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <td></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if ($b['nama_ukuran'] == $row->nama_ukuran) : ?>
                                                <?php if ($row->jumlah_keluar == '0') : ?>
                                                    <td></td>
                                                <?php else : ?>
                                                    <td><?php echo $row->jumlah_keluar ?></td>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <td></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <td>
                                            <?php
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '9' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '9' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '10' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '10' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                                if ($st != '') {
                                                    echo $st['jumlah_stok'];;
                                                } else {
                                                    echo '-';
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php elseif ($row->id_barang == '4') : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row->tanggal ?></td>
                                        <td><?php echo $row->karyawan ?></td>
                                        <td><?php echo $row->nama_barang ?></td>
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if ($b['nama_ukuran'] == $row->nama_ukuran) : ?>
                                                <?php if ($row->jumlah_masuk == '0') : ?>
                                                    <td></td>
                                                <?php else : ?>
                                                    <td><?php echo $row->jumlah_masuk ?></td>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <td></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if ($b['nama_ukuran'] == $row->nama_ukuran) : ?>
                                                <?php if ($row->jumlah_keluar == '0') : ?>
                                                    <td></td>
                                                <?php else : ?>
                                                    <td><?php echo $row->jumlah_keluar ?></td>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <td></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <td>
                                            <?php
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '24' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '24' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '25' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '25' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '26' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '26' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '27' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '27' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '28' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '28' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '29' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '29' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                                if ($st != '') {
                                                    echo $st['jumlah_stok'];;
                                                } else {
                                                    echo '-';
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php elseif ($row->id_barang == '6') : ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $row->tanggal ?></td>
                                        <td><?php echo $row->karyawan ?></td>
                                        <td><?php echo $row->nama_barang ?></td>
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if ($b['nama_ukuran'] == $row->nama_ukuran) : ?>
                                                <?php if ($row->jumlah_masuk == '0') : ?>
                                                    <td></td>
                                                <?php else : ?>
                                                    <td><?php echo $row->jumlah_masuk ?></td>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <td></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php foreach ($barang as $b) : ?>
                                            <?php if ($b['nama_ukuran'] == $row->nama_ukuran) : ?>
                                                <?php if ($row->jumlah_keluar == '0') : ?>
                                                    <td></td>
                                                <?php else : ?>
                                                    <td><?php echo $row->jumlah_keluar ?></td>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <td></td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>

                                        <td>
                                            <?php
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '30' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '30' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '31' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '31' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
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
                                            $temukan = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '32' AND tanggal = '$row->tanggal' AND id_stok = '$row->id_stok'")->row_array();
                                            if ($temukan != '') {
                                                echo $temukan['jumlah_stok'];
                                            } else {
                                                $st = $this->db->query("SELECT * from stok1 WHERE id_ukuran = '32' AND id_stok < '$row->id_stok' ORDER BY id_stok DESC LIMIT 1")->row_array();
                                                if ($st != '') {
                                                    echo $st['jumlah_stok'];;
                                                } else {
                                                    echo '-';
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endif ?>
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
        </div>
    </div>
</div>