<?php 
include 'layouts/header.php'; 
include 'config/koneksi.php'; 

// Ambil data dari database
$total_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM barang"))['total'];
$total_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi WHERE DATE(tanggal) = CURDATE()"))['total'];
$total_pendapatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_harga) as total FROM transaksi WHERE DATE(tanggal) = CURDATE()"))['total'] ?? 0;

// Ambil 5 transaksi terbaru
$query_transaksi = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY tanggal DESC LIMIT 5");
?>

<h1 class="mb-4">Dashboard SimKios</h1>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-start border-4 border-primary">
            <div class="card-body">
                <h5 class="card-title">Total Barang</h5>
                <p class="card-text fs-3 fw-bold text-primary"><?= $total_barang; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-start border-4 border-success">
            <div class="card-body">
                <h5 class="card-title">Transaksi Hari Ini</h5>
                <p class="card-text fs-3 fw-bold text-success"><?= $total_transaksi; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-start border-4 border-warning">
            <div class="card-body">
                <h5 class="card-title">Pendapatan Hari Ini</h5>
                <p class="card-text fs-3 fw-bold text-warning">Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Transaksi Terbaru -->
<h3 class="mt-5">Transaksi Terbaru</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Tanggal</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($query_transaksi)): ?>
        <tr>
            <td><?= $row['id_transaksi']; ?></td>
            <td><?= $row['nama_barang']; ?></td>
            <td><?= date('d M Y, H:i', strtotime($row['tanggal'])); ?></td>
            <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'layouts/footer.php'; ?>
