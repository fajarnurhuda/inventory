<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800">Laporan Total Masuk</h1>

	<div class="row">

		<div class="col-lg-12">

			<!-- Circle Buttons -->
			<div class="card shadow mb-12">
				<div class="card-body">
					<form method="post" action="<?= base_url('Laporan-masuk-cari') ?>" autocomplete="off">
						<label for="dari">Dari</label>
						<input type="date" name="dari" id="dari" class="form-control mb-2" required>
						<label for="sampai">Sampai</label>
						<input type="date" name="sampai" id="sampai" class="form-control mb-2" required>
						<label for="nama_barang">Nama Barang</label>
						<select name="id_barang" class="form-control mb-2" id="id_barang" required autofocus>
							<option value="0">--Pilih Semua Barang--</option>
							<?php foreach ($barang as $br) { ?>
								<option value="<?= $br->id_barang ?>"><?= $br->nama_barang ?> </option>
							<?php } ?>
						</select>
						<label for="ukuran_barang">Ukuran Barang</label>
						<select name="id_ukuran" class="form-control mb-3" id="id_ukuran" autofocus required>

						</select>
						<input type="submit" value="Cari" class="btn btn-primary">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- laporan -->
<br><br>

<div class="container-fluid">
	<div class="card shadow mb-12">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="tesTable" width="100%" cellspacing="0">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal</th>
							<th>Nama Barang</th>
							<th>Nama Ukuran</th>
							<th>Karyawan</th>
							<th>Jumlah Masuk</th>
							<th>Keterangan</th>
						</tr>
					</thead>

					<tbody>
						<?php $no = 1;
						if (!empty($caribarang)) : ?>
							<?php foreach ($caribarang as $row) : ?>
								<tr>
									<td><?php echo $no++; ?></td>
									<td><?php echo $row->tanggal ?></td>
									<td><?php echo $row->nama_barang ?> </td>
									<td><?php echo $row->nama_ukuran ?> </td>
									<td><?php echo $row->admin ?></td>
									<td><?php echo $row->jumlah_masuk  ?></td>
									<td><?php echo $row->ket_masuk ?></td>
								</tr>
							<?php endforeach ?>
						<?php else : ?>
							<tr>
								<td colspan="9" align="center">Tidak Ada Data</td>
							</tr>
						<?php endif ?>
					</tbody>
					<tfoot>
						<tfoot>
							<th colspan="5" style="text-align:center;">Total</th>
							<th></th>
							<th></th>
						</tfoot>
					</tfoot>
				</table>
			</div>
			<br>
			<a href="<?php
						$dari = $this->input->post('dari');
						$sampai = $this->input->post('sampai');
						$ukur = $this->input->post('id_ukuran');
						echo base_url('Laporan/export_pdf_masuk/') . $dari . '/' . $sampai . '/' . $ukur  ?>" target="_blank">
				<input type="submit" value="Export Excel" class="btn btn-primary"><br>
			</a>
		</div>
	</div>
</div>
<!-- end laporan -->


<!-- <script src="<?= base_url() ?>assets/js/jquery-3.6.0.min.js"></script> -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script>
	$(document).ready(function() {
		$('#tesTable').DataTable({
			footerCallback: function(row, data, start, end, display) {
				var api = this.api();

				// Remove the formatting to get integer data for summation
				var intVal = function(i) {
					return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
				};

				// Total over all pages
				total = api
					.column(5)
					.data()
					.reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				// Total over this page
				pageTotal = api
					.column(5, {
						page: 'current'
					})
					.data()
					.reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				// Update footer
				$(api.column(5).footer()).html('' + pageTotal + '');
			},
		});
	});

	$(document).ready(function() {
		$("#id_barang").change(function() {
			var getbarang = $("#id_barang").val();
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: "<?= base_url() ?>/Transaksi/getukuran",
				data: {
					id_barang: getbarang
				},
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += '<option value="' + data[i].id_ukuran + '">' + data[i].nama_ukuran + '</option>';
					}
					$("#id_ukuran").html(html);
				}
			});
		});
	});
</script>