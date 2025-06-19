<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Pintar - Daftar Obat</title>
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
            <h2>Daftar Obat Tersedia</h2>
            <a href="add_obat.php" class="btn">Tambah Obat Baru</a>
            
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
                            <a href='edit_obat.php?id={$row['id_obat']}' class='btn-edit'>Edit</a> | 
                            <a href='delete_obat.php?id={$row['id_obat']}' class='btn-delete' onclick='return confirm(\"Apakah Anda yakin?\")'>Hapus</a>
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