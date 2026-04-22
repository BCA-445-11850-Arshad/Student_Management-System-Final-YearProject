<?php
require_once 'backend/connection.php';
$result = $conn->query('DESCRIBE contact_messages');
while($row = $result->fetch_assoc()) {
    echo $row['Field'] . ' - ' . $row['Type'] . PHP_EOL;
}
?>