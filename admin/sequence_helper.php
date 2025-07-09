<?php
function getNextSequence($conn, $sequence_name) {
    $result = $conn->query("SELECT NEXTVAL('$sequence_name') as next_id");
    $row = $result->fetch_assoc();
    return $row['next_id'];
}
?>