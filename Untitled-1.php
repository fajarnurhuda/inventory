CREATE TRIGGER `stok_tambah` AFTER INSERT ON `tbl_transaksi_masuk`
FOR EACH ROW BEGIN
INSERT INTO stok SET
id_stok = null,
id_barang = NEW.id_barang,
ukuran = NEW.ukuran,
karyawan = NEW.karyawan,
jumlah_masuk = NEW.jumlah_masuk,
jumlah_keluar = 0,
jumlah_stok = jumlah_stok+jumlah_masuk,
tanggal = NEW.tanggal;
END

UPDATE stok set jumlah_stok = jumlah_stok + NEW.jumlah_stok
WHERE id_barang = NEW.id_barang AND ukuran = NEW.ukuran ORDER BY id_stok DESC LIMIT 1;


CREATE TRIGGER `stok_tambah` AFTER INSERT ON `tbl_transaksi_masuk`
FOR EACH ROW BEGIN
UPDATE stok set jumlah_stok = jumlah_stok + NEW.jumlah_masuk
WHERE id_barang = NEW.id_barang AND ukuran = NEW.ukuran ORDER BY id_stok DESC LIMIT 1;
END


function total()
{

$connect = new PDO("mysqli:host=localhost;dbname=gudang", "root", "");
$column = array('tanggal', 'nama_barang', 'nama_ukuran', 'jumlah_masuk', 'ket_masuk');

$query = 'SELECT tbl_transaksi_masuk.*, tbl_barang.nama_barang, tbl_ukuran.nama_ukuran, tbl_karyawan.nama_karyawan from tbl_transaksi_masuk JOIN tbl_ukuran ON tbl_transaksi_masuk.id_ukuran = tbl_ukuran.id_ukuran JOIN tbl_karyawan ON tbl_transaksi_masuk.karyawan = tbl_karyawan.id_karyawan JOIN tbl_barang ON tbl_ukuran.id_barang = tbl_barang.id_barang
WHERE tbl_transaksi_masuk.tanggal LIKE "%' . $_POST["search"]["value"] . '%" OR tbl_barang.nama_barang LIKE "%' . $_POST["search"]["value"] . '%" OR tbl_ukuran.nama_ukuran LIKE "%' . $_POST["search"]["value"] . '%" OR tbl_transaksi_masuk.jumlah_masuk "%' . $_POST["search"]["value"] . '%" OR tbl_transaksi_masuk.ket_masuk LIKE "%' . $_POST["search"]["value"] . '%"';

if (isset($_POST['total'])) {
$query .= 'ORDER BY ' . $column[$_POST['total']['0']['column']] . '' . $_POST['total']['0']['dir'] . '';
} else {
$query .= 'ORDER BY tbl_transaksi_masuk.id_transaksi_masuk DESC';
}

$query1 = '';

if ($_POST["length"] != -1) {
$query1 = 'LIMIT' . $_POST['start'] . ',' . $_POST['length'];
}

$statement = $connect->prepare($query);
$statement->execute();
$number_filter_row = $statement->rowCount();
$statement = $connect->prepare($query . $query1);
$statement->execute();

$result = $statement->fetchAll();
$data = array();

$total_order = 0;

foreach ($result as $row) {
$sub_array = array();
$sub_array[] = $row["tanggal"];
$sub_array[] = $row["nama_barang"];
$sub_array[] = $row["nama_ukuran"];
$sub_array[] = $row["jumlah_masuk"];
$sub_array[] = $row["ket_masuk"];

$total_order = $total_order + floatval($row["jumlah_masuk"]);
$data[] = $sub_array;
}

$output = array(
'draw' => intval($_POST["draw"]),
'recordTotal' => count_all_data($connect),
'data' => $data,
'total' => number_format($total_order)
);

echo json_encode($output);

function count_all_data($connect)
{
$query = "SELECT tbl_transaksi_masuk.*, tbl_barang.nama_barang, tbl_ukuran.nama_ukuran, tbl_karyawan.nama_karyawan from tbl_transaksi_masuk JOIN tbl_ukuran ON tbl_transaksi_masuk.id_ukuran = tbl_ukuran.id_ukuran JOIN tbl_karyawan ON tbl_transaksi_masuk.karyawan = tbl_karyawan.id_karyawan JOIN tbl_barang ON tbl_ukuran.id_barang = tbl_barang.id_barang";
$statement = $connect->prepare($query);
$statement->execute();
return $statement->rowCount();
}
}


<script type="text/javascript">
    $(document).ready(function() {
        var dataTable = $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "<?= base_url() ?>/Transaksi/total",
                type: "POST"
            },
            drawCallback: function(setting) {
                $('#total_order').html(setting.json.total);
            }
        });
    });
</script>

function export_pdf_masuk($dari, $sampai, $ukur)
{
$pdf = new FPDF('l', 'mm', 'A4');
// membuat halaman baru
$pdf->AddPage();
// setting jenis font yang akan digunakan
$pdf->SetFont('Arial', 'B', 16);
// mencetak string
$pdf->Cell(190, 7, 'DATA BARANG MASUK', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10, 7, '', 0, 1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 6, 'Tanggal', 1, 0);
$pdf->Cell(30, 6, 'Nama Barang', 1, 0);
$pdf->Cell(20, 6, 'Ukuran', 1, 0);
$pdf->Cell(30, 6, 'Nama Karyawan', 1, 0);
$pdf->Cell(20, 6, 'Masuk', 1, 0);
$pdf->Cell(20, 6, 'Keluar', 1, 0);
$pdf->Cell(20, 6, 'Stok', 1, 1);
$pdf->SetFont('Arial', '', 10);


$dtbarang = $this->MLaporan->data_barang($dari, $sampai, $ukur);

foreach ($dtbarang as $row) {
$pdf->Cell(20, 6, $row->tanggal, 1, 0);
$pdf->Cell(30, 6, $row->nama_barang, 1, 0);
$pdf->Cell(20, 6, $row->nama_ukuran, 1, 0);
$pdf->Cell(30, 6, $row->nama_karyawan, 1, 0);
$pdf->Cell(20, 6, $row->jumlah_masuk, 1, 0);
$pdf->Cell(20, 6, $row->jumlah_keluar, 1, 0);
$pdf->Cell(20, 6, $row->jumlah_stok, 1, 1);
}
$pdf->Output();
}

function export_pdf_keluar($dari, $sampai, $id_barang)
{
$pdf = new FPDF('l', 'mm', 'A5');
// membuat halaman baru
$pdf->AddPage();
// setting jenis font yang akan digunakan
$pdf->SetFont('Arial', 'B', 16);
// mencetak string
$pdf->Cell(190, 7, 'DATA BARANG KELUAR', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10, 7, '', 0, 1);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 6, 'Tanggal', 1, 0);
$pdf->Cell(60, 6, 'Nama Barang', 1, 0);
$pdf->Cell(20, 6, 'Ukuran', 1, 0);
$pdf->Cell(30, 6, 'Nama Karyawan', 1, 0);
$pdf->Cell(27, 6, 'Jumlah Masuk', 1, 0);
$pdf->Cell(25, 6, 'Jumlah Keluar', 1, 1);
$pdf->SetFont('Arial', '', 10);


$dtbarang = $this->MLaporan->data_barang_keluar($dari, $sampai, $id_barang);

foreach ($dtbarang as $row) {
$pdf->Cell(20, 6, $row->tanggal, 1, 0);
$pdf->Cell(60, 6, $row->nama_barang, 1, 0);
$pdf->Cell(20, 6, $row->nama_ukuran, 1, 0);
$pdf->Cell(30, 6, $row->nama_karyawan, 1, 0);
$pdf->Cell(27, 6, $row->jumlah_masuk, 1, 0);
$pdf->Cell(27, 6, $row->jumlah_keluar, 1, 0);
}
$pdf->Output();
}