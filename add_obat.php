<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    
    $stmt = $conn->prepare("INSERT INTO obat (nama, stok, harga, kategori) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $nama, $stok, $harga, $kategori);
    $stmt->execute();
    
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Obat Baru - Apotek Pintar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Apotek Pintar</h1>
        <nav>
            <a href="index.php">Daftar Obat</a>
            <a href="transaksi.php">Transaksi</a>
            <a href="report.php">Laporan</a>
        </nav>
    </header>

    <main>
        <section>
            <h2>Tambah Obat Baru</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="nama">Nama Obat:</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                
                <div class="form-group">
                    <label for="kategori">Kategori:</label>
                    <input type="text" id="kategori" name="kategori" required>
                </div>
                
                <div class="form-group">
                    <label for="stok">Stok:</label>
                    <input type="number" id="stok" name="stok" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="harga">Harga (Rp):</label>
                    <input type="number" id="harga" name="harga" min="0" step="0.01" required>
                </div>
                
                <button type="submit" class="btn-submit">Simpan</button>
            </form>
        </section>
    </main>
</body>
</html>