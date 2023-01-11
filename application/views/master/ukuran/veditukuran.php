<head>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
</head>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Ukuran</h1>

    <div class="row">

        <div class="col-lg-6">

            <!-- Circle Buttons -->
            <div class="card shadow mb-12">
                <div class="card-body">
                    <form method="post" action="<?= base_url('ukuran/update') ?>" autocomplete="off">
                        <input type="hidden" name="id_ukuran" value="<?php echo $ukuran['id_ukuran'] ?>">
                        <input type="hidden" name="admin" class="form-control" value="<?php echo $this->fungsi->user_login()->username ?>">
                        <div class="form-group col-lg-12">
                            <label>Nama Ukuran *</label>
                            <input type="text" name="nama_ukuran" class="form-control" value="<?php echo $ukuran['nama_ukuran'] ?>">
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Nama Barang </label>
                            <select name="nama_barang" class="form-control js-single" required autofocus>
                                <?php foreach ($bar as $b) : ?>
                                    <option value="<?= $b['id_barang'] ?>"><?= $b['nama_barang'] ?></option>
                                <?php endforeach; ?>
                            </select>
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
<script>
    $('.js-single').select2({
        placeholder: 'Select an option'
    });
</script>