<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- DataTales Example -->
	<?php echo $this->session->flashdata('message_edit') ?>
	<?php echo $this->session->flashdata('message_success') ?>
	<?php echo $this->session->flashdata('message') ?>
	<h1 class="h3 mb-4 text-gray-800">Stok Barang</h1>
	<div class="card shadow mb-4">

		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
									<td><?php echo $no++; ?></td>
									<td><?php echo $row->nama_barang ?></td>
									<td><?php echo $row->nama_ukuran ?></td>
									<?php
									$id_u = $row->id_ukuran;
									$s_masuk = $this->db->query("SELECT SUM(jumlah_masuk) as s_m FROM tbl_transaksi_masuk WHERE id_ukuran = '$id_u'")->row_array();
									$s_keluar = $this->db->query("SELECT SUM(jumlah_keluar) as s_k FROM tbl_transaksi_keluar WHERE id_ukuran = '$id_u'")->row_array();
									$tot = $s_masuk['s_m'] - $s_keluar['s_k'];
									if ($tot <= $row->min_stok) {
										echo "<td bgcolor='yellow'>" . $tot . "</td>";
									} else {
										echo "<td>" . $tot . "</td>";
									}
									?>
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
						<th></th>
					</tfoot>
				</table>
			</div>
			<a href="<?= base_url('Laporan/export_excel_stok/') ?>" target="_blank" class="btn btn-primary" target="_blank">Export Excel</a>
			<br>
			<button class="btn btn-warning"></button> Stok Minimum <br>
			<button class="btn btn-danger"></button> Stok Kosong
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#dataTable').DataTable({
			footerCallback: function(row, data, start, end, display) {
				var api = this.api();

				// Remove the formatting to get integer data for summation
				var intVal = function(i) {
					return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
				};

				// Total over all pages
				total = api
					.column(3)
					.data()
					.reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				// Total over this page
				pageTotal = api
					.column(3, {
						page: 'current'
					})
					.data()
					.reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				// Update footer
				$(api.column(3).footer()).html('' + pageTotal + '');
			},
		});
	});
</script>