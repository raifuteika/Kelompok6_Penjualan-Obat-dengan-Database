<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_obat = $_GET['id'];
    $result = $conn->query("SELECT * FROM obat WHERE id_obat = $id_obat");
    $obat = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_obat = $_POST['id_obat'];
    $nama = $_POST['nama'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    
    $stmt = $conn->prepare("UPDATE obat SET nama = ?, stok = ?, harga = ?, kategori = ? WHERE id_obat = ?");
    $stmt->bind_param("sdssi", $nama, $stok, $harga, $kategori, $id_obat);
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
    <title>Edit Obat - Apotek Pintar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h1>APOTEK PINTAR</h1>
        </div>
        <nav>
            <a href="index.php">Daftar Obat</a>
            <a href="transaksi.php">Transaksi</a>
            <a href="report.php">Laporan</a>
        </nav>
    </div>

    <main class="tambah-obat-main">
        <div class="form-container">
            <h2>Edit Obat</h2>
            <form action="edit_obat.php" method="POST">
                <input type="hidden" name="id_obat" value="<?php echo $obat['id_obat']; ?>">
                
                <div class="form-group">
                    <label for="nama">Nama Obat:</label>
                    <input type="text" id="nama" name="nama" value="<?php echo $obat['nama']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="kategori">Kategori:</label>
                    <input type="text" id="kategori" name="kategori" value="<?php echo $obat['kategori']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="stok">Stok:</label>
                    <input type="number" id="stok" name="stok" value="<?php echo $obat['stok']; ?>" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="harga">Harga (Rp):</label>
                    <input type="number" id="harga" name="harga" value="<?php echo $obat['harga']; ?>" min="0" step="0.01" required>
                </div>
                
                <button type="submit" class="btn-submit">Perbarui</button>
            </form>
        </div>
    </main>
</body>
</html>