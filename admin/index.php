<?php include '../config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Pintar - Daftar Obat</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h1>APOTEK PINTAR</h1>
        </div>
        <nav>
            <a href="index.php" class="active">Daftar Obat</a>
            <a href="transaksi.php">Transaksi</a>
            <a href="report.php">Laporan</a>
            <a href="../index.html">Logout</a>
        </nav>
    </div>

    <main>
        <section>
            <h2>Daftar Obat Tersedia</h2>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    $result = $conn->query("SELECT * FROM obat ORDER BY kategori, nama");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id_obat']}</td>";
        echo "<td>{$row['nama']}</td>";
        echo "<td>{$row['kategori']}</td>";
        echo "<td>{$row['stok']}</td>";
        echo "<td>".number_format($row['harga'])."</td>";
        echo "<td>
            <button class='btn-edit' onclick=\"location.href='edit_obat.php?id={$row['id_obat']}'\">Edit</button> 
            <button class='btn-delete' onclick=\"if(confirm('Apakah Anda yakin?')) location.href='delete_obat.php?id={$row['id_obat']}'\">Hapus</button>
          </td>";
        echo "</tr>";
    }
    ?>
</tbody>
            </table>
            
            <div class="tambah-obat">
                <a href="add_obat.php" class="btn">Tambah Obat Baru</a>
            </div>
        </section>
    </main>
</body>
</html>