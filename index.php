<?php 
include 'layouts/header.php'; 
include 'config/koneksi.php'; 

$total_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM barang"))['total'];
$total_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi WHERE DATE(created_at) = CURDATE()"))['total'];
$total_pendapatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_harga) as total FROM transaksi WHERE DATE(created_at) = CURDATE()"))['total'] ?? 0;

$query_transaksi = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY created_at DESC LIMIT 5");
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
<table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Pembeli</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Bayar</th>
                <th>Kembalian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY created_at DESC");
            while ($row = mysqli_fetch_assoc($query)) :
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_pembeli']) ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>
                    <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($row['jumlah_bayar'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($row['kembalian'], 0, ',', '.') ?></td>
                    <td>
                        <a href="/simkios/pages/detail_transaksi.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">Detail</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>


<?php include 'layouts/footer.php'; ?>
