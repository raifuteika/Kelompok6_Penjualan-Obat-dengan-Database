<?php include '../config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Agregat - Apotek Pintar</title>
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

    <main>
        <div class="report-container">
            <h2>Laporan Agregat</h2>
            
            <div class="report-cards">
                <section style="background-color: #eafaf1;">
                    <h3>Total Penjualan & Jumlah Obat Terjual (SUM)</h3>
                    <?php
                    $sum = $conn->query("SELECT SUM(jumlah) AS total_obat, SUM(total_transaksi) AS total_uang FROM transaksi")->fetch_assoc();
                    ?>
                    <p>Total Obat Terjual: <strong><?php echo $sum['total_obat']; ?></strong></p>
                    <p>Total Penjualan: <strong>Rp <?php echo number_format($sum['total_uang']); ?></strong></p>
                </section>

                <section style="background-color: #f0f8ff;">
                    <h3>Rata-rata Penjualan Mingguan (AVG)</h3>
                    <?php
                    $avg = $conn->query("SELECT AVG(jumlah) AS avg_obat, AVG(total_transaksi) AS avg_penjualan FROM transaksi WHERE tgl_transaksi >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)")->fetch_assoc();
                    ?>
                    <p>Rata-rata Obat Terjual per Hari: <strong><?php echo number_format($avg['avg_obat'], 2); ?></strong></p>
                    <p>Rata-rata Penjualan per Hari: <strong>Rp <?php echo number_format($avg['avg_penjualan'], 2); ?></strong></p>
                </section>

                <section style="background-color: #fff3cd;">
                    <h3>Jumlah Transaksi (COUNT)</h3>
                    <?php
                    $count = $conn->query("SELECT COUNT(*) AS total_transaksi FROM transaksi")->fetch_assoc();
                    ?>
                    <p>Total Transaksi: <strong><?php echo $count['total_transaksi']; ?></strong></p>
                </section>

                <section style="background-color: #fde2e2;">
                    <h3>Nilai Minimum (MIN)</h3>
                    <?php
                    $min_stok = $conn->query("SELECT nama, stok FROM obat ORDER BY stok ASC LIMIT 1")->fetch_assoc();
                    $min_penjualan = $conn->query("SELECT obat.nama, transaksi.jumlah FROM transaksi JOIN obat ON transaksi.id_obat = obat.id_obat WHERE transaksi.jumlah = (SELECT MIN(jumlah) FROM transaksi)")->fetch_assoc();
                    ?>
                    <p>Obat dengan Stok Terendah: <strong><?php echo $min_stok['nama'] . " (" . $min_stok['stok'] . ")"; ?></strong></p>
                    <p>Obat dengan Penjualan Terendah: <strong><?php echo $min_penjualan['nama'] . " (" . $min_penjualan['jumlah'] . ")"; ?></strong></p>
                </section>

                <section style="background-color: #e0f7fa;">
                    <h3>Nilai Maksimum (MAX)</h3>
                    <?php
                    $max_stok = $conn->query("SELECT nama, stok FROM obat ORDER BY stok DESC LIMIT 1")->fetch_assoc();
                    $max_penjualan = $conn->query("SELECT obat.nama, transaksi.jumlah FROM transaksi JOIN obat ON transaksi.id_obat = obat.id_obat WHERE transaksi.jumlah = (SELECT MAX(jumlah) FROM transaksi)")->fetch_assoc();
                    ?>
                    <p>Obat dengan Stok Tertinggi: <strong><?php echo $max_stok['nama'] . " (" . $max_stok['stok'] . ")"; ?></strong></p>
                    <p>Obat dengan Penjualan Tertinggi: <strong><?php echo $max_penjualan['nama'] . " (" . $max_penjualan['jumlah'] . ")"; ?></strong></p>
                </section>

                <section style="background-color: #e6ffe6; grid-column: 1 / -1;">
                    <h3>Laporan Stok Obat Berdasarkan Kategori</h3>
                    <div class="report-table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Total Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result_stok_kategori = $conn->query("SELECT kategori, total_stok_kategori FROM v_stok_kategori ORDER BY kategori ASC");

                                if ($result_stok_kategori->num_rows > 0) {
                                    while ($row_stok = $result_stok_kategori->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>{$row_stok['kategori']}</td>";
                                        echo "<td>{$row_stok['total_stok_kategori']}</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>Tidak ada data stok per kategori.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </main>
</body>
</html>