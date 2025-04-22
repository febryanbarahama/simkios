<?php
include '../config/koneksi.php';

$id_barang = $_POST['id'] ?? null;
$nama_barang = $_POST['nama_barang'];
$kategori = $_POST['kategori'];
$harga_beli = $_POST['harga_beli'];
$harga_jual = $_POST['harga_jual'];
$stok = $_POST['stok'];
$mode = $_POST['mode']; 

if ($mode === 'edit') {
    $query = "UPDATE barang SET 
                nama_barang = '$nama_barang',
                kategori = '$kategori',
                harga_beli = '$harga_beli',
                harga_jual = '$harga_jual',
                stok = '$stok'
              WHERE id = '$id_barang'";

    if (mysqli_query($conn, $query)) {
        header("Location: ../pages/barang.php?status=success&message=Barang berhasil diperbarui");
    } else {
        header("Location: ../pages/barang.php?status=error&message=Gagal memperbarui barang");
    }
} else {
    $created_at = date('Y-m-d H:i:s');
    $query = "INSERT INTO barang (nama_barang, kategori, harga_beli, harga_jual, stok, created_at) 
              VALUES ('$nama_barang', '$kategori', '$harga_beli', '$harga_jual', '$stok', '$created_at')";

    if (mysqli_query($conn, $query)) {
        header("Location: ../pages/barang.php?status=success&message=Barang berhasil ditambahkan");
    } else {
        header("Location: ../pages/barang.php?status=error&message=Gagal menambahkan barang");
    }
}
