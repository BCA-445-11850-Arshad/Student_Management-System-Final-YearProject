<?php
require_once 'backend/connection.php';

// Test notice update
$notice_id = 1;
$title = 'Test Notice';
$content = 'Test content';
$class_id = 0;
$batch_id = 0;

echo "Testing notice update...\n";

$update_sql = "UPDATE notices SET title = ?, content = ?, class_id = ?, batch_id = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);

if ($update_stmt) {
    echo "Statement prepared successfully\n";
    
    $result = $update_stmt->bind_param("sssii", $title, $content, $class_id, $batch_id, $notice_id);
    if ($result) {
        echo "Parameters bound successfully\n";
        
        if ($update_stmt->execute()) {
            echo "Update executed successfully\n";
        } else {
            echo "Execute failed: " . $update_stmt->error . "\n";
        }
    } else {
        echo "Bind param failed: " . $update_stmt->error . "\n";
    }
    
    $update_stmt->close();
} else {
    echo "Prepare failed: " . $conn->error . "\n";
}

$conn->close();
?>
