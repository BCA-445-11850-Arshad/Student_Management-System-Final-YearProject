<?php
/*
Test file to check student data in database
This will help debug what's missing
*/

require_once 'backend/connection_simple.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Student Data Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .section { margin: 30px 0; padding: 20px; border: 1px solid #e5e7eb; border-radius: 6px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #f8f9fa; font-weight: 600; }
        .success { color: #10b981; }
        .error { color: #ef4444; }
        .info { color: #3b82f6; }
        h1 { color: #1f2937; }
        h2 { color: #374151; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px; }
    </style>
</head>
<body>";

echo "<div class='container'>
    <h1>Student Data Debug Test</h1>
    
    <div class='section'>
        <h2>Database Connection Test</h2>";
        
if ($conn && $conn->ping()) {
    echo "<p class='success'>Database connection: SUCCESS</p>";
} else {
    echo "<p class='error'>Database connection: FAILED</p>";
    exit();
}

echo "    </div>";

// Check students table structure
echo "<div class='section'>
    <h2>Students Table Structure</h2>";
    
$result = $conn->query("DESCRIBE students");
if ($result) {
    echo "<table>
        <tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='error'>Failed to get table structure</p>";
}

echo "    </div>";

// Check all students data
echo "<div class='section'>
    <h2>All Students Data</h2>";
    
$result = $conn->query("SELECT s.*, c.class_name, b.batch_name FROM students s 
                        LEFT JOIN classes c ON s.class_id = c.id 
                        LEFT JOIN batches b ON s.batch_id = b.id 
                        ORDER BY s.id");
if ($result && $result->num_rows > 0) {
    echo "<table>
        <tr><th>ID</th><th>Roll Number</th><th>College ID</th><th>Name</th><th>Email</th><th>Phone</th><th>DOB</th><th>Gender</th><th>Class</th><th>Batch</th><th>Session</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . ($row['roll_number'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['college_id'] ?? 'NULL') . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . ($row['phone'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['dob'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['gender'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['class_name'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['batch_name'] ?? 'NULL') . "</td>";
        echo "<td>" . ($row['session'] ?? 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<p class='info'>Total students: " . $result->num_rows . "</p>";
} else {
    echo "<p class='error'>No students found or query failed</p>";
}

echo "    </div>";

// Check classes and batches
echo "<div class='section'>
    <h2>Classes and Batches</h2>";
    
echo "<h3>Classes:</h3>";
$result = $conn->query("SELECT * FROM classes ORDER BY id");
if ($result && $result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Class Name</th><th>Description</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['id'] . "</td><td>" . $row['class_name'] . "</td><td>" . ($row['description'] ?? '') . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p class='error'>No classes found</p>";
}

echo "<h3>Batches:</h3>";
$result = $conn->query("SELECT b.*, c.class_name FROM batches b LEFT JOIN classes c ON b.class_id = c.id ORDER BY b.id");
if ($result && $result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Class</th><th>Batch Name</th><th>Description</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row['id'] . "</td><td>" . ($row['class_name'] ?? 'NULL') . "</td><td>" . $row['batch_name'] . "</td><td>" . ($row['description'] ?? '') . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p class='error'>No batches found</p>";
}

echo "    </div>";

// Test specific student login
echo "<div class='section'>
    <h2>Test Student Login Simulation</h2>";
    
$test_email = 'rahul@studentms.com';
$result = $conn->query("SELECT s.*, c.class_name, b.batch_name FROM students s 
                        LEFT JOIN classes c ON s.class_id = c.id 
                        LEFT JOIN batches b ON s.batch_id = b.id 
                        WHERE s.email = '$test_email'");
if ($result && $result->num_rows > 0) {
    $student = $result->fetch_assoc();
    echo "<h4>Student found: " . $student['name'] . "</h4>";
    echo "<table>";
    echo "<tr><th>Field</th><th>Value</th></tr>";
    foreach ($student as $key => $value) {
        echo "<tr><td>" . $key . "</td><td>" . ($value ?? 'NULL') . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p class='error'>Test student not found</p>";
}

echo "    </div>";

echo "<div style='text-align: center; margin: 30px 0;'>
    <a href='frontend/student_dashboard.php' style='background: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: 600;'>
        Go to Student Dashboard
    </a>
</div>";

echo "</div>";
$conn->close();
echo "</body>
</html>";
?>
