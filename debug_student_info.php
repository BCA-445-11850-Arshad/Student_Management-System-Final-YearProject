<?php
/*
Debug file to check what data student_info actually contains
*/

session_start();
require_once 'backend/connection_simple.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Debug Student Info</title>
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
        pre { background: #f8f9fa; padding: 15px; border-radius: 6px; overflow-x: auto; }
    </style>
</head>
<body>";

echo "<div class='container'>
    <h1>Student Info Debug</h1>";

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    echo "<div class='section'>
        <h2>Session Check</h2>
        <p class='error'>No student logged in. Please login first.</p>
        <a href='frontend/student_login.php' style='background: #3b82f6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px;'>Go to Login</a>
    </div>";
    echo "</div></body></html>";
    exit;
}

$student_id = $_SESSION['student_id'];
echo "<div class='section'>
    <h2>Session Data</h2>
    <p><strong>Student ID:</strong> " . $student_id . "</p>
</div>";

// Get student info exactly like student_dashboard.php
$student_info = [];
try {
    $sql = "SELECT s.*, c.class_name, b.batch_name FROM students s 
              LEFT JOIN classes c ON s.class_id = c.id 
              LEFT JOIN batches b ON s.batch_id = b.id 
              WHERE s.id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $student_info = $result->fetch_assoc();
            echo "<div class='section'>
                <h2>Database Query Result</h2>
                <p class='success'>Student found in database!</p>
                <table>
                    <tr><th>Field</th><th>Value</th></tr>";
            foreach ($student_info as $key => $value) {
                echo "<tr><td>" . $key . "</td><td>" . ($value ?? 'NULL') . "</td></tr>";
            }
            echo "</table>
            </div>";
        } else {
            echo "<div class='section'>
                <h2>Database Query Result</h2>
                <p class='error'>No student found in database with ID: " . $student_id . "</p>
                </div>";
            
            // Fallback data
            $student_info = [
                'id' => $student_id,
                'roll_number' => '',
                'college_id' => '',
                'name' => 'Student',
                'email' => 'student@example.com',
                'phone' => '',
                'dob' => '',
                'gender' => '',
                'address' => '',
                'blood_group' => '',
                'photo' => 'uploads/default.jpg',
                'class_name' => '',
                'batch_name' => '',
                'session' => ''
            ];
            
            echo "<div class='section'>
                <h2>Fallback Data Used</h2>
                <p class='info'>Using fallback data because student not found in database.</p>
                <table>
                    <tr><th>Field</th><th>Value</th></tr>";
            foreach ($student_info as $key => $value) {
                echo "<tr><td>" . $key . "</td><td>" . ($value ?? 'NULL') . "</td></tr>";
            }
            echo "</table>
            </div>";
        }
        $stmt->close();
    } else {
        echo "<div class='section'>
            <h2>Database Error</h2>
            <p class='error'>Failed to prepare query: " . $conn->error . "</p>
            </div>";
    }
} catch (Exception $e) {
    echo "<div class='section'>
        <h2>Exception</h2>
        <p class='error'>Error: " . $e->getMessage() . "</p>
        </div>";
}

echo "<div class='section'>
    <h2>What Should Display in Student Dashboard</h2>
    <table>
        <tr><th>Field</th><th>Display Value</th><th>Status</th></tr>
        <tr>
            <td>Student ID</td>
            <td>" . htmlspecialchars($student_info['id'] ?? 'NULL') . "</td>
            <td>" . (isset($student_info['id']) ? '<span class="success">Available</span>' : '<span class="error">Missing</span>') . "</td>
        </tr>
        <tr>
            <td>Roll Number</td>
            <td>" . htmlspecialchars($student_info['roll_number'] ?? 'NULL') . "</td>
            <td>" . (!empty($student_info['roll_number']) ? '<span class="success">Available</span>' : '<span class="error">Missing/Empty</span>') . "</td>
        </tr>
        <tr>
            <td>College ID</td>
            <td>" . htmlspecialchars($student_info['college_id'] ?? 'NULL') . "</td>
            <td>" . (!empty($student_info['college_id']) ? '<span class="success">Available</span>' : '<span class="error">Missing/Empty</span>') . "</td>
        </tr>
        <tr>
            <td>Class Name</td>
            <td>" . htmlspecialchars($student_info['class_name'] ?? 'NULL') . "</td>
            <td>" . (!empty($student_info['class_name']) ? '<span class="success">Available</span>' : '<span class="error">Missing/Empty</span>') . "</td>
        </tr>
        <tr>
            <td>Batch Name</td>
            <td>" . htmlspecialchars($student_info['batch_name'] ?? 'NULL') . "</td>
            <td>" . (!empty($student_info['batch_name']) ? '<span class="success">Available</span>' : '<span class="error">Missing/Empty</span>') . "</td>
        </tr>
    </table>
</div>";

echo "<div class='section'>
    <h2>Solutions</h2>
    <div style='background: #f0f9ff; padding: 15px; border-radius: 6px; margin: 10px 0;'>
        <h3>If Roll Number/College ID is missing:</h3>
        <ol>
            <li>Admin needs to add student with roll_number and college_id</li>
            <li>Check if student was added before these fields were added</li>
            <li>Edit the student in admin section to add missing fields</li>
        </ol>
    </div>
    <div style='background: #fef3c7; padding: 15px; border-radius: 6px; margin: 10px 0;'>
        <h3>If Class/Batch is missing:</h3>
        <ol>
            <li>Student might not be assigned to any class or batch</li>
            <li>Edit student in admin section to assign class and batch</li>
            <li>Make sure class and batch exist in database</li>
        </ol>
    </div>
</div>";

echo "<div style='text-align: center; margin: 30px 0;'>
    <a href='frontend/student_dashboard.php' style='background: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: 600;'>
        Back to Student Dashboard
    </a>
    <a href='frontend/admin_dashboard.php' style='background: #10b981; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: 600; margin-left: 10px;'>
        Go to Admin Dashboard
    </a>
</div>";

echo "</div>";
$conn->close();
echo "</body>
</html>";
?>
