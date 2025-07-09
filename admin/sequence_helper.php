<?php
function getNextSequence($conn, $sequence_name) {
    // Mulai transaction untuk atomicity
    $conn->begin_transaction();
    
    try {
        // Lock table untuk mencegah race condition
        $conn->query("LOCK TABLES sequence_table WRITE");
        
        // Ambil current value
        $result = $conn->query("SELECT current_value FROM sequence_table WHERE sequence_name = '$sequence_name'");
        $row = $result->fetch_assoc();
        
        if ($row) {
            $current_value = $row['current_value'];
            $next_value = $current_value + 1;
            
            // Update sequence
            $conn->query("UPDATE sequence_table SET current_value = $next_value WHERE sequence_name = '$sequence_name'");
        } else {
            // Jika sequence belum ada, buat baru
            $next_value = 1;
            $conn->query("INSERT INTO sequence_table (sequence_name, current_value) VALUES ('$sequence_name', $next_value)");
        }
        
        // Unlock table
        $conn->query("UNLOCK TABLES");
        
        // Commit transaction
        $conn->commit();
        
        return $next_value;
        
    } catch (Exception $e) {
        // Rollback jika error
        $conn->rollback();
        $conn->query("UNLOCK TABLES");
        throw $e;
    }
}
?>