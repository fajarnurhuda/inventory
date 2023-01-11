<?php

/**
 *
 */
class MLaporan extends CI_Model
{
   function graph()
   {
      $data = $this->db->query("SELECT tanggal,MONTH(tanggal) AS bulan, SUM(jumlah_masuk) AS jumlah_masuk FROM tbl_transaksi_masuk GROUP BY bulan");
      return $data->result();
   }
   function graph_keluar()
   {
      $data = $this->db->query("SELECT tanggal,MONTH(tanggal) AS bulan, SUM(jumlah_keluar) AS jumlah_keluar FROM tbl_transaksi_keluar GROUP BY bulan");
      return $data->result();
   }

   function show_barang_masuk()
   {
      $barang = $this->db->query("SELECT * FROM tbl_transaksi_masuk JOIN tbl_ukuran ON tbl_ukuran.id_ukuran = tbl_transaksi_masuk.id_ukuran JOIN tbl_barang ON tbl_barang.id_barang = tbl_ukuran.id_barang");
      return $barang->result();
   }

   function data_barang($dari, $sampai, $ukur)
   {
      if ($dari == '' && $sampai == '' && $ukur == '') {
         $barang = $this->db->query("SELECT a.*, b.nama_barang, c.nama_ukuran, d.nama_karyawan, e.ket_masuk FROM stok1 a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran LEFT JOIN tbl_karyawan d ON a.karyawan = d.id_karyawan
          Left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_masuk e ON a.id_transaksi_masuk = e.id_transaksi_masuk");
      } elseif ($dari != '' && $sampai != '' && $ukur == '') {
         $barang = $this->db->query("SELECT a.*, b.nama_barang, c.nama_ukuran, d.nama_karyawan, e.ket_masuk FROM stok1 a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran LEFT JOIN tbl_karyawan d ON a.karyawan = d.id_karyawan
         left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_masuk e ON a.id_transaksi_masuk = e.id_transaksi_masuk WHERE a.tanggal >= '$dari' AND a.tanggal <= '$sampai' ");
      } elseif ($dari == '' && $sampai == '' && $ukur != '') {
         $barang = $this->db->query("SELECT a.*, b.nama_barang, c.nama_ukuran, d.nama_karyawan, e.ket_masuk FROM stok1 a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran LEFT JOIN tbl_karyawan d ON a.karyawan = d.id_karyawan
         left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_masuk e ON a.id_transaksi_masuk = e.id_transaksi_masuk WHERE a.id_ukuran = '$ukur' ");
      } else {
         $barang = $this->db->query("SELECT a.*, b.nama_barang, c.nama_ukuran, d.nama_karyawan, e.ket_masuk FROM stok1 a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran LEFT JOIN tbl_karyawan d ON a.karyawan = d.id_karyawan
         left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_masuk e ON a.id_transaksi_masuk = e.id_transaksi_masuk WHERE a.tanggal >= '$dari' AND a.tanggal <= '$sampai' AND a.id_ukuran = '$ukur' ");
      }
      return $barang->result();
   }

   function show_barang_keluar()
   {
      $barang = $this->db->query("SELECT * FROM tbl_transaksi_keluar JOIN tbl_ukuran ON tbl_ukuran.id_ukuran = tbl_transaksi_keluar.id_ukuran JOIN tbl_barang ON tbl_barang.id_barang = tbl_ukuran.id_barang");
      return $barang->result();
   }



   // function data_barang_keluar($dari, $sampai, $id_barang)
   // {
   //    if ($dari == '' && $sampai == '' && $id_barang == '') {
   //       $barang = $this->db->query("SELECT a.*, b.nama_barang, c.nama_ukuran, a.id_ukuran, b.id_barang  FROM stok1 a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang WHERE tanggal >= '$dari' AND tanggal <= '$sampai' AND b.id_barang = '$id_barang' ORDER BY tanggal ASC");
   //    } else {
   //       $barang = $this->db->query("SELECT a.*, b.nama_barang, c.nama_ukuran, b.id_barang FROM stok1 a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang WHERE tanggal >= '$dari' AND tanggal <= '$sampai' AND b.id_barang = '$id_barang' ORDER BY tanggal ASC");
   //    }
   //    return $barang->result();
   // }

   function data_barang_keluar($dari, $sampai, $id_barang)
   {
      if ($dari == '' && $sampai == '' && $id_barang == '') {
         $barang = $this->db->query("SELECT a.*, b.nama_barang, c.nama_ukuran, a.id_ukuran, b.id_barang  FROM stok1 a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang WHERE tanggal >= '$dari' AND tanggal <= '$sampai' AND b.id_barang = '$id_barang' ORDER By tanggal ASC, id_transaksi_masuk != '' DESC");
      } else {
         $barang = $this->db->query("SELECT a.*, b.nama_barang, c.nama_ukuran, b.id_barang FROM stok1 a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang WHERE tanggal >= '$dari' AND tanggal <= '$sampai' AND b.id_barang = '$id_barang' ORDER By tanggal ASC, id_transaksi_masuk != '' DESC");
      }

      return $barang->result();
   }

   function data_stok()
   {
      $query = $this->db->query("SELECT tbl_ukuran.nama_ukuran, tbl_barang.nama_barang, tbl_barang.id_barang, vstok.stok_akhir FROM vstok
        LEFT JOIN tbl_ukuran ON vstok.id_ukuran = tbl_ukuran.id_ukuran LEFT JOIN tbl_barang ON tbl_barang.id_barang = tbl_ukuran.id_barang ORDER BY tbl_barang.nama_barang DESC");
      return $query->result();
   }

   function barang()
   {
      $query = $this->db->query("SELECT * FROM tbl_barang");
      return $query->result();
   }

   function data_keluar($dari, $sampai, $ukur)
   {
      if ($dari != '' && $sampai != '' && $ukur == '') {
         $barang = $this->db->query("SELECT a.*, b.nama_barang, c.nama_ukuran, e.ket_keluar FROM tbl_transaksi_keluar a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_keluar e ON a.id_transaksi_keluar = e.id_transaksi_keluar WHERE a.tanggal >= '$dari' AND a.tanggal <= '$sampai'");
      } elseif ($dari == '' && $sampai == ''  && $ukur == '') {
         $barang = $this->db->query("SELECT a.*, b.nama_barang, c.nama_ukuran, e.ket_keluar FROM tbl_transaksi_keluar a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_keluar e ON a.id_transaksi_keluar = e.id_transaksi_keluar");
      } elseif ($dari == '' && $sampai == ''  && $ukur != '') {
         $barang = $this->db->query("SELECT a.*, b.nama_barang, c.nama_ukuran, e.ket_keluar FROM tbl_transaksi_keluar a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_keluar e ON a.id_transaksi_keluar = e.id_transaksi_keluar WHERE a.id_ukuran = '$ukur' ");
      } else {
         $barang = $this->db->query("SELECT a.*, b.nama_barang, c.nama_ukuran, e.ket_keluar FROM tbl_transaksi_keluar a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_keluar e ON a.id_transaksi_keluar = e.id_transaksi_keluar WHERE a.tanggal >= '$dari' AND a.tanggal <= '$sampai' AND a.id_ukuran = '$ukur'");
      }
      return $barang->result();
   }

   function sum_data_keluar($dari, $sampai, $ukur)
   {
      if ($dari != '' && $sampai != '' && $ukur == '') {
         $total_keluar = $this->db->query("SELECT sum(a.jumlah_keluar) as total_keluar FROM tbl_transaksi_keluar a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_keluar e ON a.id_transaksi_keluar = e.id_transaksi_keluar WHERE a.tanggal >= '$dari' AND a.tanggal <= '$sampai'");
      } elseif ($dari == '' && $sampai == ''  && $ukur == '') {
         $total_keluar = $this->db->query("SELECT sum(a.jumlah_keluar) as total_keluar FROM tbl_transaksi_keluar a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_keluar e ON a.id_transaksi_keluar = e.id_transaksi_keluar");
      } elseif ($dari == '' && $sampai == ''  && $ukur != '') {
         $total_keluar = $this->db->query("SELECT sum(a.jumlah_keluar) as total_keluar FROM tbl_transaksi_keluar a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_keluar e ON a.id_transaksi_keluar = e.id_transaksi_keluar WHERE a.id_ukuran = '$ukur'");
      } else {
         $total_keluar = $this->db->query("SELECT sum(a.jumlah_keluar) as total_keluar FROM tbl_transaksi_keluar a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_keluar e ON a.id_transaksi_keluar = e.id_transaksi_keluar WHERE a.tanggal >= '$dari' AND a.tanggal <= '$sampai' AND a.id_ukuran = '$ukur'");
      }
      return $total_keluar->result_array();
   }

   function data_masuk($dari, $sampai, $ukur)
   {
      if ($dari != '' && $sampai != '' && $ukur == '') {
         $barang = $this->db->query("SELECT a.*, b.nama_barang, c.nama_ukuran, e.ket_masuk FROM tbl_transaksi_masuk a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_masuk e ON a.id_transaksi_masuk = e.id_transaksi_masuk WHERE a.tanggal >= '$dari' AND a.tanggal <= '$sampai'");
      } elseif ($dari == '' && $sampai == ''  && $ukur == '') {
         $barang = $this->db->query("SELECT a.*, b.nama_barang, c.nama_ukuran, e.ket_masuk FROM tbl_transaksi_masuk a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_masuk e ON a.id_transaksi_masuk = e.id_transaksi_masuk");
      } elseif ($dari == '' && $sampai == ''  && $ukur != '') {
         $barang = $this->db->query("SELECT a.*, b.nama_barang, c.nama_ukuran, e.ket_masuk FROM tbl_transaksi_masuk a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_masuk e ON a.id_transaksi_masuk = e.id_transaksi_masuk WHERE a.id_ukuran = '$ukur'");
      } else {
         $barang = $this->db->query("SELECT a.*, b.nama_barang, c.nama_ukuran, e.ket_masuk FROM tbl_transaksi_masuk a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_masuk e ON a.id_transaksi_masuk = e.id_transaksi_masuk WHERE a.tanggal >= '$dari' AND a.tanggal <= '$sampai' AND a.id_ukuran = '$ukur'");
      }
      return $barang->result();
   }

   function sum_data_masuk($dari, $sampai, $ukur)
   {
      if ($dari != '' && $sampai != '' && $ukur == '') {
         $total_masuk = $this->db->query("SELECT sum(a.jumlah_masuk) as total_masuk FROM tbl_transaksi_masuk a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_masuk e ON a.id_transaksi_masuk = e.id_transaksi_masuk WHERE a.tanggal >= '$dari' AND a.tanggal <= '$sampai'");
      } elseif ($dari == '' && $sampai == ''  && $ukur == '') {
         $total_masuk = $this->db->query("SELECT sum(a.jumlah_masuk) as total_masuk FROM tbl_transaksi_masuk a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_masuk e ON a.id_transaksi_masuk = e.id_transaksi_masuk ");
      } elseif ($dari == '' && $sampai == ''  && $ukur != '') {
         $total_masuk = $this->db->query("SELECT sum(a.jumlah_masuk) as total_masuk FROM tbl_transaksi_masuk a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_masuk e ON a.id_transaksi_masuk = e.id_transaksi_masuk WHERE a.id_ukuran = '$ukur' ");
      } else {
         $total_masuk = $this->db->query("SELECT sum(a.jumlah_masuk) as total_masuk FROM tbl_transaksi_masuk a left join tbl_ukuran c on a.id_ukuran = c.id_ukuran left join tbl_barang b on b.id_barang = c.id_barang left JOIN tbl_transaksi_masuk e ON a.id_transaksi_masuk = e.id_transaksi_masuk WHERE a.tanggal >= '$dari' AND a.tanggal <= '$sampai' AND a.id_ukuran = '$ukur' ");
      }
      return $total_masuk->result_array();
   }
}
