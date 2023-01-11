 <!-- Begin Page Content -->

 <div class="container-fluid">
 	<!-- DataTales Example -->
 	<?php echo $this->session->flashdata('message_edit') ?>
 	<?php echo $this->session->flashdata('message_success') ?>
 	<?php echo $this->session->flashdata('message') ?>

 	<h1 class="h3 mb-4 text-gray-800">Barang Keluar</h1>
 	<div class="card shadow mb-4">
 		<div class="card-header py-3">
 			<?php if ($this->session->userdata('level') == 'admin') : ?>
 				<a href="<?php echo base_url('Transaksi-keluar-add') ?>">
 					<button class="btn btn-sm btn-primary" type=""><i class="fas fa-plus fa-sm"></i> Tambah Transaksi Keluar</button>
 				</a>
 				<a href="" data-toggle="modal" data-target="#exampleModal">
 					<button class="btn btn-sm btn-info" type=""><i class="fas fa-upload fa-sm"></i> Upload Barang Keluar</button>
 				</a>
 				<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
 					<div class="modal-dialog" role="document">
 						<form action="<?php echo base_url('import/keluar') ?>" method="POST" enctype="multipart/form-data">
 							<div class="modal-content">
 								<div class="modal-header">
 									<h5 class="modal-title" id="exampleModalLabel">Upload Barang Keluar</h5>
 									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
 										<span aria-hidden="true">&times;</span>
 									</button>
 								</div>
 								<div class="modal-body">
 									<input type="file" name="import_keluar" id="import_keluar" accept=".xls,.xlsx">
 								</div>
 								<div class="modal-footer">
 									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
 									<button type="submit" class="btn btn-primary" name="tambah">
 										Upload
 									</button>
 									<a href="<?php echo base_url('assets/') ?>Upload Barang Keluar.xlsx" class="btn btn-info" class="btn btn-info">Template</a>
 								</div>
 							</div>
 						</form>
 					</div>
 				</div>
 			<?php endif; ?>
 		</div>
 		<div class="card-body">
 			<div class="btn btn-primary float-left mb-3" id="button">Delete</div>
 			<div class="table-responsive">
 				<table id="dataTable" class="table table-bordered" style="width:100%" cellspacing="0">
 					<thead>
 						<tr>
 							<th>#</th>
 							<th>No</th>
 							<th>Tanggal</th>
 							<th>Nama Barang</th>
 							<th>Ukuran</th>
 							<th>Karyawan</th>
 							<th>Jumlah Keluar</th>
 							<th>Ket Keluar</th>
 						</tr>
 					</thead>

 					<tbody>
 						<?php $no = 1;
							if (!empty($tr_keluar)) : ?>
 							<?php foreach ($tr_keluar as $row) :
									// $stt = $row->status;
								?>
 								<tr>
 									<td>
 										<center>
 											<input type="checkbox" class="select" name="id[]" value="<?= $row->id_transaksi_keluar ?>" id="defaultCheck1">
 										</center>
 									</td>
 									<td><?php echo $no++ ?></td>
 									<td><?php echo $row->tanggal ?></td>
 									<td><?php echo $row->nama_barang ?></td>
 									<td><?php echo $row->nama_ukuran ?></td>
 									<td><?php echo $row->karyawan ?></td>
 									<td><?php echo $row->jumlah_keluar ?></td>
 									<td><?php echo $row->ket_keluar ?></td>
 								</tr>
 							<?php endforeach ?>
 						<?php else : ?>
 							<tr>
 								<td colspan="9" align="center">Tidak Ada Data</td>
 							</tr>
 						<?php endif ?>
 					</tbody>
 					<tfoot>
 						<th colspan="5" style="text-align:center;">Total</th>
 						<th></th>
 						<th></th>
 						<th></th>
 					</tfoot>
 				</table>
 			</div>
 		</div>
 	</div>

 </div>
 <!-- /.container-fluid -->
 </div>

 <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
 <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
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
 </script>
 <script>
 	$(document).ready(function() {
 		var t = $('#dataTable').DataTable();

 		$("#button").on("click", function(event) {
 			event.preventDefault();


 			// t.draw('page');

 			var deleteArray = new Array();
 			$('input[type=checkbox]:checked').each(function(index) {
 				deleteArray.push($(this).val());
 			});

 			$.ajax({
 				type: "POST",
 				url: "<?= base_url('transaksi/reject') ?>",
 				data: {
 					id: deleteArray
 				},
 				success: function(data) {
 					t.rows($('table tr').has('input:checked')).remove().draw(false);
 				}
 			});
 		});
 	});
 </script>