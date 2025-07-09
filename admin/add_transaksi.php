<?php include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];
    $result = $conn->query("SELECT transaksi.*, obat.nama, obat.stok, obat.harga FROM transaksi JOIN obat ON transaksi.id_obat = obat.id_obat WHERE transaksi.id_transaksi = $id_transaksi");
    $transaksi = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_transaksi = isset($_POST['id_transaksi']) ? $_POST['id_transaksi'] : null;
    $tgl_transaksi = $_POST['tgl_transaksi'];
    $id_obat = $_POST['id_obat'];
    $jumlah = $_POST['jumlah'];
    
    // Hitung total transaksi
    $result = $conn->query("SELECT harga FROM obat WHERE id_obat = $id_obat");
    $harga = $result->fetch_assoc()['harga'];
    $total_transaksi = $harga * $jumlah;
    
    if ($id_transaksi) {
        // Update transaksi
        $stmt = $conn->prepare("UPDATE transaksi SET tgl_transaksi = ?, id_obat = ?, jumlah = ?, total_transaksi = ? WHERE id_transaksi = ?");
        $stmt->bind_param("siiid", $tgl_transaksi, $id_obat, $jumlah, $total_transaksi, $id_transaksi);
    } else {
        // Tambah transaksi baru
        $stmt = $conn->prepare("INSERT INTO transaksi (tgl_transaksi, id_obat, jumlah, total_transaksi) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siii", $tgl_transaksi, $id_obat, $jumlah, $total_transaksi);
    }
    
    $stmt->execute();
    header("Location: transaksi.php");
    exit();
}

// Ambil daftar obat untuk dropdown
$result_obat = $conn->query("SELECT id_obat, nama, stok FROM obat WHERE stok > 0");
$obat_list = [];
while ($row = $result_obat->fetch_assoc()) {
    $obat_list[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($id_transaksi) ? 'Edit' : 'Tambah'; ?> Transaksi - Apotek Pintar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h1>APOTEK PINTAR</h1>
        </div>
        <nav>
            <a href="index.php" >Daftar Obat</a>
            <a href="transaksi.php">Transaksi</a>
            <a href="report.php" class="active">Laporan</a>
            <a href="../index.html">Logout</a>
        </nav>
    </div>

    <main class="tambah-transaksi-main">
        <div class="form-container">
            <h2><?php echo isset($id_transaksi) ? 'Edit' : 'Tambah'; ?> Transaksi</h2>
            <form action="add_transaksi.php" method="POST">
                <?php if (isset($id_transaksi)): ?>
                    <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="tgl_transaksi">Tanggal Transaksi:</label>
                    <input type="date" id="tgl_transaksi" name="tgl_transaksi" value="<?php echo isset($id_transaksi) ? $transaksi['tgl_transaksi'] : date('Y-m-d'); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="id_obat">Obat:</label>
                    <select id="id_obat" name="id_obat" required>
                        <?php foreach ($obat_list as $obat): ?>
                            <option value="<?php echo $obat['id_obat']; ?>" <?php echo isset($id_transaksi) && $transaksi['id_obat'] == $obat['id_obat'] ? 'selected' : ''; ?>>
                                <?php echo "{$obat['nama']} (Stok: {$obat['stok']})"; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="jumlah">Jumlah:</label>
                    <input type="number" id="jumlah" name="jumlah" value="<?php echo isset($id_transaksi) ? $transaksi['jumlah'] : 1; ?>" min="1" required>
                </div>
                
                <button type="submit" class="btn-submit">Simpan</button>
            </form>
        </div>
    </main>
</body>
</html>