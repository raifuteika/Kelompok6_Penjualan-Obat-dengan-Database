<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tgl_transaksi = $_POST['tgl_transaksi'];
    $id_obat = $_POST['id_obat'];
    $jumlah = $_POST['jumlah'];
    
    // Hitung total transaksi
    $result = $conn->query("SELECT harga FROM obat WHERE id_obat = $id_obat");
    $harga = $result->fetch_assoc()['harga'];
    $total_transaksi = $harga * $jumlah;
    
    // Tambah transaksi baru
    $stmt = $conn->prepare("INSERT INTO transaksi (tgl_transaksi, id_obat, jumlah, total_transaksi) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siii", $tgl_transaksi, $id_obat, $jumlah, $total_transaksi);
    
    if ($stmt->execute()) {
        // Kurangi stok obat
        $update_stok = $conn->prepare("UPDATE obat SET stok = stok - ? WHERE id_obat = ?");
        $update_stok->bind_param("ii", $jumlah, $id_obat);
        $update_stok->execute();
        
        echo "<script>alert('Transaksi berhasil!'); window.location='departments.php';</script>";
    } else {
        echo "<script>alert('Transaksi gagal!'); window.location='departments.php';</script>";
    }
}
?>