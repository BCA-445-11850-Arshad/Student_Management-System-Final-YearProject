<?php
require_once 'backend/connection.php';

// Test class update
$class_id = 1;
$class_name = 'BCA Test';
$description = '';

echo "Testing class update...\n";

$update_sql = "UPDATE classes SET class_name = ?, description = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);

if ($update_stmt) {
    echo "Statement prepared successfully\n";
    
    // Test with empty string
    $result = $update_stmt->bind_param("ssi", $class_name, $description, $class_id);
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
