<?php
include '../layouts/header.php';
include '../config/koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header('Location: transaksi.php');
    exit;
}

// Ambil data transaksi
$transaksiQuery = mysqli_query($conn, "SELECT * FROM transaksi WHERE id = '$id'");
$transaksi = mysqli_fetch_assoc($transaksiQuery);

if (!$transaksi) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>Data transaksi tidak ditemukan.</div></div>";
    include '../layouts/footer.php';
    exit;
}

// Ambil detail barang dalam transaksi, termasuk harga_jual dari barang
$detailQuery = mysqli_query($conn, "
    SELECT dt.*, b.nama_barang, b.harga_jual 
    FROM detail_transaksi dt
    JOIN barang b ON dt.id_barang = b.id
    WHERE dt.id_transaksi = '$id'
");
?>

<div class="container mt-4">
    <h4>Detail Transaksi</h4>
    <div class="mb-3">
        <strong>Nama Pembeli:</strong> <?= htmlspecialchars($transaksi['nama_pembeli']) ?><br>
        <strong>Tanggal Transaksi:</strong> <?= date('d-m-Y H:i', strtotime($transaksi['created_at'])) ?><br>
        <strong>Total Bayar:</strong> Rp <?= number_format($transaksi['jumlah_bayar'], 0, ',', '.') ?>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; $grandTotal = 0; ?>
            <?php while ($row = mysqli_fetch_assoc($detailQuery)) : 
                $subtotal = $row['harga_jual'] * $row['jumlah'];
                $grandTotal += $subtotal;
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                    <td>Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                    <td><?= $row['jumlah'] ?></td>
                    <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-end">Total</th>
                <th>Rp <?= number_format($grandTotal, 0, ',', '.') ?></th>
            </tr>
        </tfoot>
    </table>

    <a href="transaksi.php" class="btn btn-secondary mt-3">← Kembali ke Transaksi</a>
    <a href="/simkios/index.php" class="btn btn-secondary mt-3">← Kembali ke Dashboard</a>
</div>

<?php include '../layouts/footer.php'; ?>
