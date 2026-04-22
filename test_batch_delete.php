<?php
/*
Test file to verify batch delete functionality
This will test the delete_batch.php file
*/

session_start();
require_once 'backend/connection_simple.php';

echo "<h2>Testing Batch Delete Functionality</h2>";

// First, let's see what batches exist
echo "<h3>Current Batches:</h3>";
$result = $conn->query("SELECT * FROM batches ORDER BY id");
if ($result && $result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; margin: 20px 0;'>";
    echo "<tr><th>ID</th><th>Batch Name</th><th>Class ID</th><th>Students Count</th><th>Action</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        // Check student count for each batch
        $check_sql = "SELECT COUNT(*) as count FROM students WHERE batch_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $row['id']);
        $check_stmt->execute();
        $student_result = $check_stmt->get_result();
        $student_count = $student_result->fetch_assoc()['count'];
        $check_stmt->close();
        
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['batch_name']) . "</td>";
        echo "<td>" . $row['class_id'] . "</td>";
        echo "<td>" . $student_count . "</td>";
        echo "<td><a href='frontend/delete_batch.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No batches found.</p>";
}

// Test delete functionality with a safe batch ID (if exists)
echo "<h3>Test Delete Function:</h3>";
$test_batch_id = 1; // Change this to an actual batch ID for testing

// Check if batch exists
$check_batch = $conn->prepare("SELECT * FROM batches WHERE id = ?");
$check_batch->bind_param("i", $test_batch_id);
$check_batch->execute();
$batch_result = $check_batch->get_result();

if ($batch_result->num_rows > 0) {
    $batch_info = $batch_result->fetch_assoc();
    echo "<p>Found batch: " . htmlspecialchars($batch_info['batch_name']) . " (ID: " . $batch_info['id'] . ")</p>";
    
    // Check students count
    $check_sql = "SELECT COUNT(*) as count FROM students WHERE batch_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $test_batch_id);
    $check_stmt->execute();
    $student_result = $check_stmt->get_result();
    $student_count = $student_result->fetch_assoc()['count'];
    $check_stmt->close();
    
    echo "<p>Students in this batch: " . $student_count . "</p>";
    
    if ($student_count == 0) {
        echo "<p style='color: green;'>✓ This batch can be safely deleted (no students assigned)</p>";
        echo "<p><a href='frontend/delete_batch.php?id=" . $test_batch_id . "' style='background: red; color: white; padding: 10px; text-decoration: none;'>Test Delete Batch " . $test_batch_id . "</a></p>";
    } else {
        echo "<p style='color: orange;'>⚠ This batch cannot be deleted (has " . $student_count . " students)</p>";
    }
} else {
    echo "<p>No batch found with ID " . $test_batch_id . "</p>";
}

$check_batch->close();
$conn->close();

echo "<hr>";
echo "<p><a href='frontend/admin_dashboard.php#batches'>← Back to Admin Dashboard</a></p>";
?>
