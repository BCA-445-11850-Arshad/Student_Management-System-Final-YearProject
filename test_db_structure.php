<?php
require_once 'backend/connection.php';

echo 'Tables: ';
$result = $conn->query('SHOW TABLES');
while($row = $result->fetch_row()) {
    echo $row[0] . ', ';
}
echo "\n";

echo 'Classes structure: ';
$result = $conn->query('DESCRIBE classes');
while($row = $result->fetch_assoc()) {
    echo $row['Field'] . ':' . $row['Type'] . ', ';
}
echo "\n";

echo 'Batches structure: ';
$result = $conn->query('DESCRIBE batches');
while($row = $result->fetch_assoc()) {
    echo $row['Field'] . ':' . $row['Type'] . ', ';
}
echo "\n";

echo 'Notices structure: ';
$result = $conn->query('DESCRIBE notices');
while($row = $result->fetch_assoc()) {
    echo $row['Field'] . ':' . $row['Type'] . ', ';
}
echo "\n";
?>
