<head>

	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
</head>
<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-4 text-gray-800">Tambah Transaksi Masuk</h1>

	<div class="row">

		<div class="col-lg-6">

			<!-- Circle Buttons -->
			<div class="card shadow mb-12">
				<div class="card-body">
					<form method="post" action="<?= base_url('Transaksi-masuk-save') ?>" autocomplete="off">
						<input type="hidden" name="admin" class="form-control" value="<?php echo $this->fungsi->user_login()->username ?>">
						<div class="form-group col-lg-12">
							<label>Tanggal *</label>
							<?php
							$date = date("mm/dd/yyyy");

							?>
							<input type="date" name="tanggal" class="form-control" required>
						</div>
						<div class="form-group col-lg-12">
							<label>Nama Barang *</label>
							<select name="id_barang" class="form-control" id="id_barang" required autofocus>
								<option value="">--Pilih Nama Barang--</option>
								<?php foreach ($barang as $br) { ?>
									<option value="<?= $br['id_barang'] ?>"><?= $br['nama_barang'] ?> </option>
								<?php } ?>
							</select>
						</div>

						<div class="form-group col-lg-12">
							<label>Ukuran Barang *</label>
							<select name="id_ukuran" class="form-control" id="id_ukuran" required autofocus>

							</select>
						</div>

						<div class="form-group col-lg-12">
							<label>Jumlah Barang Masuk *</label>
							<input type="number" name="jumlah_masuk" class="form-control" required>
						</div>

						<div class="form-group col-lg-12">
							<label>Keterangan </label>
							<input type="text" name="ket_masuk" class="form-control" style="height: 60px;">
						</div>

						<div class="form-group col-lg-6">
							<button type="submit" class="btn btn-primary btn-flat">
								<i class="fa fa-pencil"></i> Simpan</button>
							<button type="reset" class="btn btn-info">Reset</button>
						</div>
				</div>
			</div>
		</div>

	</div>

</div>

</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script src="<?= base_url() ?>assets/js/jquery-3.6.0.min.js"></script>
<script>
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