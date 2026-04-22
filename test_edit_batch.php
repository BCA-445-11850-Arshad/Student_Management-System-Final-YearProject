<?php
require_once 'backend/connection.php';

// Test batch update
$batch_id = 1;
$class_id = 1;
$batch_name = 'Batch 2023-26 Test';
$description = '';

echo "Testing batch update...\n";

$update_sql = "UPDATE batches SET class_id = ?, batch_name = ?, description = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);

if ($update_stmt) {
    echo "Statement prepared successfully\n";
    
    $result = $update_stmt->bind_param("issi", $class_id, $batch_name, $description, $batch_id);
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
