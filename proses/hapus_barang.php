<?php
include '../config/koneksi.php';

$id = $_GET['id'];

$query = "DELETE FROM barang WHERE id = '$id'";

if (mysqli_query($conn, $query)) {
    header("Location: ../pages/barang.php?status=success&message=Barang berhasil dihapus");
} else {
    header("Location: ../pages/barang.php?status=error&message=Gagal menghapus barang");
}
?>
