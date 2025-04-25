<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pembeli = $_POST['nama_pembeli'];
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];
    $subtotal = $_POST['subtotal'];

    $total_harga = $_POST['total_harga'];
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $kembalian = $_POST['kembalian'];
    $created_at = date('Y-m-d H:i:s');

    // Simpan ke tabel transaksi
    $queryTransaksi = mysqli_query($conn, "INSERT INTO transaksi (nama_pembeli, total_harga, jumlah_bayar, kembalian, created_at) 
                                            VALUES ('$nama_pembeli', '$total_harga', '$jumlah_bayar', '$kembalian', '$created_at')");

    if ($queryTransaksi) {
        $id_transaksi = mysqli_insert_id($conn); // ambil id transaksi terakhir

        // Simpan detail transaksi
        for ($i = 0; $i < count($id_barang); $i++) {
            $id = $id_barang[$i];
            $jml = $jumlah[$i];
            $sub = $subtotal[$i];

            mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_barang, jumlah, subtotal)
                                 VALUES ('$id_transaksi', '$id', '$jml', '$sub')");

            // Kurangi stok barang
            mysqli_query($conn, "UPDATE barang SET stok = stok - $jml WHERE id = '$id'");
        }

        header("Location: ../pages/transaksi.php?status=success&message=Transaksi berhasil disimpan");
        exit;
    } else {
        header("Location: ../pages/form_transaksi.php?status=danger&message=Gagal menyimpan transaksi");
        exit;
    }
} else {
    header("Location: ../pages/transaksi.php");
    exit;
}
