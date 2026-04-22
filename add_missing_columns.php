<?php
/*
Add missing columns to students table
This will add dob and gender columns to support the full student form
*/

require_once 'backend/connection_simple.php';

echo "<h2>Adding Missing Columns to Students Table</h2>";

try {
    // Check if dob column exists
    $result = $conn->query("SHOW COLUMNS FROM students LIKE 'dob'");
    if ($result->num_rows == 0) {
        // Add dob column
        $sql = "ALTER TABLE students ADD COLUMN dob DATE NULL AFTER phone";
        if ($conn->query($sql)) {
            echo "<p style='color: green;'>✅ Successfully added 'dob' column to students table</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to add 'dob' column: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color: blue;'>ℹ️ 'dob' column already exists</p>";
    }
    
    // Check if gender column exists
    $result = $conn->query("SHOW COLUMNS FROM students LIKE 'gender'");
    if ($result->num_rows == 0) {
        // Add gender column
        $sql = "ALTER TABLE students ADD COLUMN gender VARCHAR(10) NULL AFTER dob";
        if ($conn->query($sql)) {
            echo "<p style='color: green;'>✅ Successfully added 'gender' column to students table</p>";
        } else {
            echo "<p style='color: red;'>❌ Failed to add 'gender' column: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color: blue;'>ℹ️ 'gender' column already exists</p>";
    }
    
    // Show updated table structure
    echo "<h3>Updated Students Table Structure:</h3>";
    $result = $conn->query("DESCRIBE students");
    if ($result) {
        echo "<table border='1' style='border-collapse: collapse; margin: 20px 0;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
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
    }
    
    echo "<p style='color: green; font-weight: bold;'>✅ Database update completed successfully!</p>";
    echo "<p><a href='frontend/admin_dashboard.php#students' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;'>📝 Go to Admin Dashboard</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}

$conn->close();
?>
