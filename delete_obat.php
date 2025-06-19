<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id_obat = $_GET['id'];
    
    // Cek apakah obat digunakan dalam transaksi
    $result = $conn->query("SELECT COUNT(*) AS count FROM transaksi WHERE id_obat = $id_obat");
    $row = $result->fetch_assoc();
    
    if ($row['count'] > 0) {
        echo "<script>
            alert('Obat tidak dapat dihapus karena sudah ada dalam transaksi!');
            window.location.href = 'index.php';
        </script>";
    } else {
        $conn->query("DELETE FROM obat WHERE id_obat = $id_obat");
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>