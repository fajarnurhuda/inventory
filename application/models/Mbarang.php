<?php

/**
 *
 */
class Mbarang extends CI_Model
{
    function data_barang()
    {
        $this->db->select('*');
        $this->db->from('tbl_barang');
        $this->db->order_by('nama_barang', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function cek_barang($nama_barang)
    {
        $this->db->where('nama_barang', $nama_barang);
        $query = $this->db->get('tbl_barang')->row_array();
        return $query;
    }

    function input_data($data, $table)
    {
        $this->db->insert($table, $data);
    }

    function update_data($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }


    function hapus_data($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
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
}
