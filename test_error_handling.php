<?php
/*
Error Handling Test - Student Management System
Tests the ErrorHandler class functionality
*/

require_once 'backend/error_handler.php';

// Test 1: Database connection error
echo "<h2>Testing Error Handling</h2>";

// Test 2: Trigger a PHP error (commented out to avoid actual errors)
// echo $undefined_variable; // This would trigger a notice

// Test 3: Test user-friendly error display
// ErrorHandler::showUserError("This is a test error message");

// Test 4: Test database query execution
require_once 'backend/connection.php';

try {
    // Test a safe query
    $stmt = ErrorHandler::executeQuery($conn, "SELECT COUNT(*) as count FROM students", [], "", "Test query failed");
    if ($stmt) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        echo "<p>Test successful: Found " . $row['count'] . " students in database.</p>";
    }

    // Test an unsafe query (this should fail gracefully)
    // $stmt = ErrorHandler::executeQuery($conn, "SELECT * FROM nonexistent_table", [], "", "Test failed query");

} catch (Exception $e) {
    echo "<p>Exception caught: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<p>Error handling test completed. Check logs/error.log for logged errors.</p>";
?>