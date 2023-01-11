<?php

/**
 *
 */
class Mukuran extends CI_Model
{
    function data_ukuran()
    {
        $this->db->select('*');
        $this->db->from('tbl_ukuran');
        $this->db->join('tbl_barang', 'tbl_barang.id_barang = tbl_ukuran.id_barang');

        $query = $this->db->get();
        return $query->result();
    }

    public function cek_ukur($nama_barang, $nama_ukuran)
    {
        $this->db->where('nama_ukuran', $nama_ukuran);
        $this->db->where('id_barang', $nama_barang);
        $query = $this->db->get('tbl_ukuran')->row_array();
        return $query;
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
}
