<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Apotek Pintar</title>
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
        <section>
            <h2>Laporan Penjualan</h2>
            
            <div class="report-filter">
                <form action="report.php" method="GET">
                    <div class="form-group">
                        <label for="tgl_mulai">Tanggal Mulai:</label>
                        <input type="date" id="tgl_mulai" name="tgl_mulai" value="<?php echo isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : date('Y-m-01'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="tgl_akhir">Tanggal Akhir:</label>
                        <input type="date" id="tgl_akhir" name="tgl_akhir" value="<?php echo isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : date('Y-m-d'); ?>">
                    </div>
                    
                    <button type="submit" class="btn">Tampilkan Laporan</button>
                </form>
            </div>
            
            <h3>Ringkasan Penjualan</h3>
            <table>
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Jumlah Transaksi</th>
                        <th>Obat Terjual</th>
                        <th>Total Penjualan</th>
                        <th>Stok Terendah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : date('Y-m-01'); ?> s/d <?php echo isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : date('Y-m-d'); ?></td>
                        
                        <?php
                        $tgl_mulai = isset($_GET['tgl_mulai']) ? $_GET['tgl_mulai'] : date('Y-m-01');
                        $tgl_akhir = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : date('Y-m-d');
                        
                        // Hitung jumlah transaksi
                        $result_transaksi = $conn->query("
                            SELECT COUNT(*) AS jumlah_transaksi 
                            FROM transaksi 
                            WHERE tgl_transaksi BETWEEN '$tgl_mulai' AND '$tgl_akhir'
                        ");
                        $jumlah_transaksi = $result_transaksi->fetch_assoc()['jumlah_transaksi'];
                        
                        // Hitung total obat terjual
                        $result_obat_terjual = $conn->query("
                            SELECT SUM(jumlah) AS jumlah_obat 
                            FROM transaksi 
                            WHERE tgl_transaksi BETWEEN '$tgl_mulai' AND '$tgl_akhir'
                        ");
                        $jumlah_obat = $result_obat_terjual->fetch_assoc()['jumlah_obat'];
                        
                        // Hitung total penjualan
                        $result_total_penjualan = $conn->query("
                            SELECT SUM(total_transaksi) AS total_penjualan 
                            FROM transaksi 
                            WHERE tgl_transaksi BETWEEN '$tgl_mulai' AND '$tgl_akhir'
                        ");
                        $total_penjualan = $result_total_penjualan->fetch_assoc()['total_penjualan'];
                        
                        // Cari obat dengan stok terendah
                        $result_stok_terendah = $conn->query("
                            SELECT nama, stok 
                            FROM obat 
                            ORDER BY stok ASC 
                            LIMIT 1
                        ");
                        $stok_terendah = $result_stok_terendah->fetch_assoc();
                        ?>
                        
                        <td><?php echo $jumlah_transaksi; ?></td>
                        <td><?php echo $jumlah_obat; ?></td>
                        <td>Rp <?php echo number_format($total_penjualan); ?></td>
                        <td><?php echo $stok_terendah['nama'] . " (" . $stok_terendah['stok'] . ")"; ?></td>
                    </tr>
                </tbody>
            </table>
            
            <h3>Penjualan per Kategori</h3>
            <table>
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Jumlah Terjual</th>
                        <th>Total Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result_kategori = $conn->query("
                        SELECT 
                            kategori,
                            SUM(jumlah) AS jumlah_terjual,
                            SUM(jumlah * harga) AS total_penjualan
                        FROM transaksi
                        JOIN obat ON transaksi.id_obat = obat.id_obat
                        WHERE tgl_transaksi BETWEEN '$tgl_mulai' AND '$tgl_akhir'
                        GROUP BY kategori
                    ");
                    
                    while ($row = $result_kategori->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['kategori']}</td>";
                        echo "<td>{$row['jumlah_terjual']}</td>";
                        echo "<td>Rp " . number_format($row['total_penjualan']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            
            <h3>Stok Obat per Kategori</h3>
            <table>
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Total Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result_stok_kategori = $conn->query("SELECT * FROM v_stok_kategori");
                    
                    while ($row = $result_stok_kategori->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['kategori']}</td>";
                        echo "<td>{$row['total_stok']}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>