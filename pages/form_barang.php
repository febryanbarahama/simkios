<?php
include '../config/koneksi.php';

$id = $_GET['id'] ?? null;
$data = null;

if ($id) {
    $result = mysqli_query($conn, "SELECT * FROM barang WHERE id = '$id'");
    $data = mysqli_fetch_assoc($result);
}
?>

<?php include '../layouts/header.php'; ?>

<div class="container mt-4">
    <h3><?= $id ? 'Edit Barang' : 'Tambah Barang' ?></h3>
    <form action="../proses/tambah_barang.php" method="POST">
        <!-- Hidden untuk mode & id -->
        <input type="hidden" name="mode" value="<?= $id ? 'edit' : 'tambah' ?>">
        <?php if ($id): ?>
            <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <?php endif; ?>

        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                   value="<?= $data['nama_barang'] ?? '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <input type="text" class="form-control" id="kategori" name="kategori"
                   value="<?= $data['kategori'] ?? '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="harga_beli" class="form-label">Harga Beli</label>
            <input type="number" class="form-control" id="harga_beli" name="harga_beli"
                   value="<?= $data['harga_beli'] ?? '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="harga_jual" class="form-label">Harga Jual</label>
            <input type="number" class="form-control" id="harga_jual" name="harga_jual"
                   value="<?= $data['harga_jual'] ?? '' ?>" required>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok"
                   value="<?= $data['stok'] ?? '' ?>" required>
        </div>

        <button type="submit" class="btn btn-primary"><?= $id ? 'Simpan Perubahan' : 'Tambah Barang' ?></button>
        <a href="barang.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php include '../layouts/footer.php'; ?>
