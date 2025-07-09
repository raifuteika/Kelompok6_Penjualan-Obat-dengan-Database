<?php 
// Perbaikan path include
include '../config.php'; 

if (isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];
    
    // Mulai transaction untuk keamanan
    $conn->begin_transaction();
    
    try {
        // Ambil data transaksi untuk dikembalikan stoknya
        $result = $conn->query("SELECT id_obat, jumlah FROM transaksi WHERE id_transaksi = $id_transaksi");
        
        if ($result && $result->num_rows > 0) {
            $transaksi = $result->fetch_assoc();
            $id_obat = $transaksi['id_obat'];
            $jumlah = $transaksi['jumlah'];
            
            // Hapus transaksi
            $delete_result = $conn->query("DELETE FROM transaksi WHERE id_transaksi = $id_transaksi");
            
            if ($delete_result) {
                // Kembalikan stok obat
                $update_result = $conn->query("UPDATE obat SET stok = stok + $jumlah WHERE id_obat = $id_obat");
                
                if ($update_result) {
                    // Commit transaction jika semua berhasil
                    $conn->commit();
                    echo "<script>
                        alert('Transaksi berhasil dihapus dan stok obat telah dikembalikan!');
                        window.location.href = 'transaksi.php';
                    </script>";
                } else {
                    throw new Exception("Gagal mengembalikan stok obat");
                }
            } else {
                throw new Exception("Gagal menghapus transaksi");
            }
        } else {
            throw new Exception("Transaksi tidak ditemukan");
        }
    } catch (Exception $e) {
        // Rollback jika ada error
        $conn->rollback();
        echo "<script>
            alert('Error: " . $e->getMessage() . "');
            window.location.href = 'transaksi.php';
        </script>";
    }
} else {
    header("Location: transaksi.php");
    exit();
}
?>