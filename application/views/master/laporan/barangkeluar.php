<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
	<div class="container-fluid">
		<!-- Page Heading -->
		<h1 class="h3 mb-4 text-gray-800">Laporan Excel</h1>
		<div class="row">
			<div class="col-lg-12">
				<!-- Circle Buttons -->
				<div class="card shadow mb-12">
					<div class="card-body">
						<form method="post" action="<?= base_url('Laporan-masuk-cari-keluar') ?>" autocomplete="off">
							<label for="dari">Nama Barang</label>
							<select name="nama_barang" class="form-control mb-3" required autofocus>
								<option value="">- Pilih Barang -</option>
								<?php foreach ($listbarang as $b) { ?>
									<option value="<?= $b['id_barang'] ?>"><?= $b['nama_barang'] ?></option>
								<?php } ?>
							</select>
							<label for="dari">Dari</label>
							<input type="date" name="dari" id="dari" class="form-control mb-3" required>
							<label for="sampai">Sampai</label>
							<input type="date" name="sampai" id="sampai" class="form-control mb-3" required>
							<input type="submit" value="Cari" class="btn btn-primary">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- laporan -->
	<br><br>
	<!-- end laporan -->
</body>

</html>
</div>