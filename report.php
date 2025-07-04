<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Agregat - Apotek Pintar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Apotek Pintar</h1>
    <nav>
        <a href="index.php">Daftar Obat</a>
        <a href="transaksi.php">Transaksi</a>
        <a href="report.php" class="active">Laporan</a>
    </nav>
</header>

<main>
    <section style="background-color: #eafaf1;">
        <h2>Total Penjualan & Jumlah Obat Terjual (SUM)</h2>
        <?php
        $sum = $conn->query("SELECT SUM(jumlah) AS total_obat, SUM(total_transaksi) AS total_uang FROM transaksi")->fetch_assoc();
        ?>
        <p>Total Obat Terjual: <strong><?php echo $sum['total_obat']; ?></strong></p>
        <p>Total Penjualan: <strong>Rp <?php echo number_format($sum['total_uang']); ?></strong></p>
    </section>

    <section style="background-color: #f0f8ff;">
        <h2>Rata-rata Penjualan Mingguan (AVG)</h2>
        <?php
        $avg = $conn->query("SELECT AVG(jumlah) AS avg_obat, AVG(total_transaksi) AS avg_penjualan FROM transaksi WHERE tgl_transaksi >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)")->fetch_assoc();
        ?>
        <p>Rata-rata Obat Terjual per Hari: <strong><?php echo number_format($avg['avg_obat'], 2); ?></strong></p>
        <p>Rata-rata Penjualan per Hari: <strong>Rp <?php echo number_format($avg['avg_penjualan'], 2); ?></strong></p>
    </section>

    <section style="background-color: #fff3cd;">
        <h2>Jumlah Transaksi (COUNT)</h2>
        <?php
        $count = $conn->query("SELECT COUNT(*) AS total_transaksi FROM transaksi")->fetch_assoc();
        ?>
        <p>Total Transaksi: <strong><?php echo $count['total_transaksi']; ?></strong></p>
    </section>

    <section style="background-color: #fde2e2;">
        <h2>Nilai Minimum (MIN)</h2>
        <?php
        $min_stok = $conn->query("SELECT nama, stok FROM obat ORDER BY stok ASC LIMIT 1")->fetch_assoc();
        $min_penjualan = $conn->query("SELECT obat.nama, SUM(transaksi.jumlah) AS jumlah FROM transaksi JOIN obat ON transaksi.id_obat = obat.id_obat GROUP BY transaksi.id_obat ORDER BY jumlah ASC LIMIT 1")->fetch_assoc();
        ?>
        <p>Obat dengan Stok Terendah: <strong><?php echo $min_stok['nama'] . " (" . $min_stok['stok'] . ")"; ?></strong></p>
        <p>Obat dengan Penjualan Terendah: <strong><?php echo $min_penjualan['nama'] . " (" . $min_penjualan['jumlah'] . ")"; ?></strong></p>
    </section>

    <section style="background-color: #e0f7fa;">
        <h2>Nilai Maksimum (MAX)</h2>
        <?php
        $max_stok = $conn->query("SELECT nama, stok FROM obat ORDER BY stok DESC LIMIT 1")->fetch_assoc();
        $max_penjualan = $conn->query("SELECT obat.nama, SUM(transaksi.jumlah) AS jumlah FROM transaksi JOIN obat ON transaksi.id_obat = obat.id_obat GROUP BY transaksi.id_obat ORDER BY jumlah DESC LIMIT 1")->fetch_assoc();
        ?>
        <p>Obat dengan Stok Tertinggi: <strong><?php echo $max_stok['nama'] . " (" . $max_stok['stok'] . ")"; ?></strong></p>
        <p>Obat dengan Penjualan Tertinggi: <strong><?php echo $max_penjualan['nama'] . " (" . $max_penjualan['jumlah'] . ")"; ?></strong></p>
    </section>
</main>
</body>
</html>