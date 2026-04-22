<?php
require_once 'backend/connection.php';

if ($conn) {
    echo 'Database connection successful';
    $result = $conn->query('SELECT COUNT(*) as count FROM students');
    if ($result) {
        $row = $result->fetch_assoc();
        echo ' - Found ' . $row['count'] . ' students';
    }
} else {
    echo 'Database connection failed';
}
?>