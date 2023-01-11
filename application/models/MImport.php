<?php

/**
 *
 */
class MImport extends CI_Model
{
    function import_data($databarang)
    {
        $jumlah = count($databarang);
        if ($jumlah > 0) {
            $this->db->insert('tbl_ukuran', $databarang);
        }
    }
}
