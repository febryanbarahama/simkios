<?php include '../layouts/header.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="container mt-4">
    <h4>Form Transaksi</h4>

    <form action="../proses/simpan_transaksi.php" method="POST" id="formTransaksi">
        <div class="table-responsive">
            <table class="table table-bordered" id="tabel-barang">
                <thead class="table-dark">
                    <tr>
                        <th>Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="id_barang[]" class="form-select" onchange="updateHarga(this)">
                                <option value="">Pilih Barang</option>
                                <?php
                                $barang = mysqli_query($conn, "SELECT * FROM barang");
                                while ($row = mysqli_fetch_assoc($barang)) {
                                    echo "<option value='{$row['id']}' data-harga='{$row['harga_jual']}'>{$row['nama_barang']}</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td><input type="text" class="form-control harga" readonly></td>
                        <td><input type="number" name="jumlah[]" class="form-control jumlah" min="1" onchange="updateSubtotal(this)"></td>
                        <td><input type="text" name="subtotal[]" class="form-control subtotal" readonly></td>
                        <td><button type="button" class="btn btn-danger" onclick="hapusBaris(this)">-</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-secondary mb-3" onclick="tambahBaris()">+ Tambah Barang</button>
        </div>

        <div class="mb-3">
    <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
    <input type="text" class="form-control" name="nama_pembeli" id="nama_pembeli" required>
</div>


        <div class="mb-3">
            <label for="total_harga" class="form-label">Total</label>
            <input type="text" name="total_harga" id="total" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label for="jumlah_bayar" class="form-label">Jumlah Bayar</label>
            <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" onchange="hitungKembalian()">
        </div>

        <div class="mb-3">
            <label for="kembalian" class="form-label">Kembalian</label>
            <input type="text" name="kembalian" id="kembalian" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-success">Simpan Transaksi</button>
    </form>
</div>

<script>
    function tambahBaris() {
        const row = document.querySelector("#tabel-barang tbody tr");
        const clone = row.cloneNode(true);

        clone.querySelectorAll("input").forEach(input => input.value = '');
        clone.querySelector("select").selectedIndex = 0;
        document.querySelector("#tabel-barang tbody").appendChild(clone);
    }

    function hapusBaris(btn) {
        const rows = document.querySelectorAll("#tabel-barang tbody tr");
        if (rows.length > 1) btn.closest('tr').remove();
        hitungTotal();
    }

    function updateHarga(selectElement) {
        const harga = selectElement.selectedOptions[0].getAttribute('data-harga') || 0;
        const row = selectElement.closest('tr');
        row.querySelector(".harga").value = harga;
        updateSubtotal(row.querySelector(".jumlah"));
    }

    function updateSubtotal(inputElement) {
        const row = inputElement.closest('tr');
        const harga = parseFloat(row.querySelector(".harga").value || 0);
        const jumlah = parseInt(row.querySelector(".jumlah").value || 0);
        const subtotal = harga * jumlah;
        row.querySelector(".subtotal").value = subtotal;
        hitungTotal();
    }

    function hitungTotal() {
        const subtotalFields = document.querySelectorAll(".subtotal");
        let total = 0;
        subtotalFields.forEach(field => {
            total += parseFloat(field.value || 0);
        });
        document.getElementById("total").value = total;
        hitungKembalian();
    }

    function hitungKembalian() {
        const total = parseFloat(document.getElementById("total").value || 0);
        const bayar = parseFloat(document.getElementById("jumlah_bayar").value || 0);
        const kembali = bayar - total;
        document.getElementById("kembalian").value = kembali >= 0 ? kembali : 0;
    }
</script>

<?php include '../layouts/footer.php'; ?>
