<?php include '../layouts/header.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="container mt-4">
<?php if (isset($_GET['status']) && isset($_GET['message'])): ?>
  <div class="alert alert-<?= $_GET['status'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
    <?= htmlspecialchars($_GET['message']) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>
    <div class="d-flex justify-content-between mb-3">
        <h4>Data Barang</h4>
        <a href="form_barang.php" class="btn btn-primary">+ Tambah Barang</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Created At</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($conn, "SELECT * FROM barang ORDER BY created_at DESC");
            while ($row = mysqli_fetch_assoc($query)) :
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                    <td><?= htmlspecialchars($row['kategori']) ?></td>
                    <td>Rp <?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                    <td><?= $row['stok'] ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>
                    <td>
                        <a href="form_barang.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="#" 
                        class="btn btn-sm btn-danger" 
                        data-bs-toggle="modal" 
                        data-bs-target="#hapusModal"
                        data-id="<?= $row['id'] ?>" 
                         data-nama="<?= htmlspecialchars($row['nama_barang']) ?>">
                         Hapus
                        </a>

                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Apakah kamu yakin ingin menghapus <strong id="namaBarang"></strong> dari daftar barang?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <a href="#" class="btn btn-danger" id="btnKonfirmasiHapus">Ya, Hapus</a>
      </div>
    </div>
  </div>
</div>

<script>
  const hapusModal = document.getElementById('hapusModal');
  hapusModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const nama = button.getAttribute('data-nama');

    document.getElementById('namaBarang').textContent = nama;
    document.getElementById('btnKonfirmasiHapus').href = '../proses/hapus_barang.php?id=' + id;
  });
</script>



<?php include '../layouts/footer.php'; ?>
