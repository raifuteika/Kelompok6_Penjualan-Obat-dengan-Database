<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Penjualan - Apotek Pintar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h1>APOTEK PINTAR</h1>
        </div>
        <nav>
            <a href="index.php">Daftar Obat</a>
            <a href="transaksi.php" class="active">Transaksi</a>
            <a href="report.php">Laporan</a>
        </nav>
    </div>

    <main>
        <section>
            <h2>Transaksi Penjualan</h2>
            <a href="add_transaksi.php" class="btn">Tambah Transaksi Baru</a>
            
            <table>
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Tanggal</th>
                        <th>Nama Obat</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    $result = $conn->query("SELECT transaksi.*, obat.nama FROM transaksi JOIN obat ON transaksi.id_obat = obat.id_obat ORDER BY transaksi.tgl_transaksi DESC");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id_transaksi']}</td>";
        echo "<td>{$row['tgl_transaksi']}</td>";
        echo "<td>{$row['nama']}</td>";
        echo "<td>{$row['jumlah']}</td>";
        echo "<td>".number_format($row['total_transaksi'])."</td>";
        echo "<td>
            <button class='btn-edit' onclick=\"location.href='add_transaksi.php?id={$row['id_transaksi']}'\">Edit</button> 
            <button class='btn-delete' onclick=\"if(confirm('Apakah Anda yakin?')) location.href='delete_transaksi.php?id={$row['id_transaksi']}'\">Hapus</button>
          </td>";
        echo "</tr>";
    }
    ?>
</tbody>
            </table>
        </section>
    </main>
</body>
</html>