<?php

/**
 *
 */
class MTransaksi extends CI_Model
{


    function transaksi_masuk()
    {
        $query = $this->db->query("SELECT tbl_transaksi_masuk.*, tbl_barang.nama_barang, tbl_ukuran.nama_ukuran from tbl_transaksi_masuk JOIN tbl_ukuran ON tbl_transaksi_masuk.id_ukuran = tbl_ukuran.id_ukuran JOIN tbl_barang ON tbl_ukuran.id_barang = tbl_barang.id_barang");
        return $query->result();
    }

    function transaksi_keluar()
    {
        $query = $this->db->query("SELECT tbl_transaksi_keluar.*, tbl_barang.nama_barang, tbl_ukuran.nama_ukuran from tbl_transaksi_keluar JOIN tbl_ukuran ON tbl_transaksi_keluar.id_ukuran = tbl_ukuran.id_ukuran JOIN tbl_barang ON tbl_ukuran.id_barang = tbl_barang.id_barang");
        return $query->result();
    }

    function get_master_toobject($tablename, $value, $display, $orderby, $objtype, $defaultvalue, $condition, $columns = '*', $encrypt = false)
    {
        $enc_value = '';
        if ($condition == '') {
            $query = $this->db->query("SELECT $columns FROM " . $tablename . " order by " . $orderby);
        } else {
            $query = $this->db->query("SELECT $columns FROM " . $tablename . " where " . $condition . " order by " . $orderby);
        }
        if ($query->num_rows() > 0) {
            $fetch_data = $query->result();
            $data = array();
            foreach ($fetch_data as $row) {
                if ($encrypt == false) {
                    $enc_value = $row->$value;
                } else {
                    $enc_value = encrypt($row->$value);
                }
                if ($objtype == "Select") {
                    if ($defaultvalue != "" && $row->$value == $defaultvalue) {
                        $data[] = "<option value=" . $enc_value . " selected>" . $row->$display . "</option>";
                    } else {
                        $data[] = "<option value=" . $enc_value . ">" . $row->$display . "</option>";
                    }
                }
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    function generatenobarang()
    {
        $query = $this->db->query("SELECT generate_barang_no() as barangid");
        return $query->result_array();
    }


    function input_data($data, $table)
    {
        $this->db->insert($table, $data);
    }


    function hapus_data($where, $table)
    {
        $aksi = $this->db->where($where);
        $aksi = $this->db->delete($table);
    }

    function update_data($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    function accept_data($id)
    {
        $accept = $this->db->query("
        UPDATE tbl_transaksi_keluar
        SET status = 1
        WHERE pk_transaksi_keluar_id = $id");
        return $accept;
    }

    function reject_data($id)
    {
        $reject = $this->db->query("DELETE tbl_transaksi_keluar WHERE id_transaksi_keluar = $id");
        return $reject;
    }
}
