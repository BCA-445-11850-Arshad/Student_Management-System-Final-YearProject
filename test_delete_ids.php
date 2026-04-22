<?php
/*
Test file to verify delete ID fetching and parameter passing
This will help debug any ID mismatch issues
*/

session_start();
require_once 'backend/connection_simple.php';

echo "<h2>🔍 Delete ID Debugging Test</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { border-collapse: collapse; margin: 20px 0; width: 100%; }
    th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
    th { background-color: #f2f2f2; }
    .debug-info { background: #f8f9fa; padding: 15px; margin: 10px 0; border-left: 4px solid #007bff; }
    .success { color: green; }
    .error { color: red; }
    .warning { color: orange; }
    .section { margin: 30px 0; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
    .code { background: #f4f4f4; padding: 10px; font-family: monospace; margin: 10px 0; }
</style>";

// Function to display debug info
function showDebugInfo($title, $data) {
    echo "<div class='debug-info'>";
    echo "<h4>$title</h4>";
    echo "<pre>" . print_r($data, true) . "</pre>";
    echo "</div>";
}

// Test 1: Check Students Data
echo "<div class='section'>";
echo "<h3>👥 Students Data Debug</h3>";

$students_query = "SELECT s.id, s.name, s.email, c.class_name, b.batch_name FROM students s 
                   LEFT JOIN classes c ON s.class_id = c.id 
                   LEFT JOIN batches b ON s.batch_id = b.id 
                   ORDER BY s.id LIMIT 3";
$result = $conn->query($students_query);

if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>DB ID</th><th>Name</th><th>Email</th><th>Class</th><th>Batch</th><th>JS Function Call</th><th>Parameter Passed</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><strong>" . $row['id'] . "</strong></td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['class_name'] ?? 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row['batch_name'] ?? 'N/A') . "</td>";
        echo "<td><code>deleteStudent(" . $row['id'] . ")</code></td>";
        echo "<td><code>delete_student: " . $row['id'] . "</code></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='warning'>No students found</p>";
}
echo "</div>";

// Test 2: Check Classes Data
echo "<div class='section'>";
echo "<h3>📚 Classes Data Debug</h3>";

$classes_query = "SELECT * FROM classes ORDER BY id LIMIT 3";
$result = $conn->query($classes_query);

if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>DB ID</th><th>Class Name</th><th>Description</th><th>JS Function Call</th><th>Parameter Passed</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><strong>" . $row['id'] . "</strong></td>";
        echo "<td>" . htmlspecialchars($row['class_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['description'] ?? 'N/A') . "</td>";
        echo "<td><code>deleteClass(" . $row['id'] . ")</code></td>";
        echo "<td><code>delete_class: " . $row['id'] . "</code></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='warning'>No classes found</p>";
}
echo "</div>";

// Test 3: Check Batches Data
echo "<div class='section'>";
echo "<h3>🎯 Batches Data Debug</h3>";

$batches_query = "SELECT b.id, b.batch_name, c.class_name FROM batches b 
                  LEFT JOIN classes c ON b.class_id = c.id 
                  ORDER BY b.id LIMIT 3";
$result = $conn->query($batches_query);

if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>DB ID</th><th>Batch Name</th><th>Class</th><th>JS Function Call</th><th>Parameter Passed</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><strong>" . $row['id'] . "</strong></td>";
        echo "<td>" . htmlspecialchars($row['batch_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['class_name'] ?? 'N/A') . "</td>";
        echo "<td><code>confirmDeleteBatch(" . $row['id'] . ", '" . htmlspecialchars($row['batch_name']) . "')</code></td>";
        echo "<td><code>GET id: " . $row['id'] . "</code></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='warning'>No batches found</p>";
}
echo "</div>";

// Test 4: Check Notices Data
echo "<div class='section'>";
echo "<h3>📢 Notices Data Debug</h3>";

$notices_query = "SELECT * FROM notices ORDER BY id LIMIT 3";
$result = $conn->query($notices_query);

if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>DB ID</th><th>Title</th><th>Content Preview</th><th>JS Function Call</th><th>Parameter Passed</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><strong>" . $row['id'] . "</strong></td>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td>" . substr(htmlspecialchars($row['content']), 0, 50) . "...</td>";
        echo "<td><code>deleteNotice(" . $row['id'] . ")</code></td>";
        echo "<td><code>delete_notice: " . $row['id'] . "</code></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='warning'>No notices found</p>";
}
echo "</div>";

// Test 5: Check Public Notices Data
echo "<div class='section'>";
echo "<h3>🌐 Public Notices Data Debug</h3>";

$public_notices_query = "SELECT * FROM public_notices ORDER BY id LIMIT 3";
$result = $conn->query($public_notices_query);

if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>DB ID</th><th>Title</th><th>Content Preview</th><th>JS Function Call</th><th>Parameter Passed</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><strong>" . $row['id'] . "</strong></td>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td>" . substr(htmlspecialchars($row['content']), 0, 50) . "...</td>";
        echo "<td><code>deletePublicNotice(" . $row['id'] . ")</code></td>";
        echo "<td><code>delete_public_notice: " . $row['id'] . "</code></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='warning'>No public notices found</p>";
}
echo "</div>";

// Test 6: Check Contact Messages Data
echo "<div class='section'>";
echo "<h3>💬 Contact Messages Data Debug</h3>";

$messages_query = "SELECT * FROM contact_messages ORDER BY id LIMIT 3";
$result = $conn->query($messages_query);

if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>DB ID</th><th>Name</th><th>Email</th><th>Subject</th><th>JS Function Call</th><th>Parameter Passed</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><strong>" . $row['id'] . "</strong></td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
        echo "<td><code>deleteMessage(" . $row['id'] . ")</code></td>";
        echo "<td><code>delete_contact: " . $row['id'] . "</code></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='warning'>No contact messages found</p>";
}
echo "</div>";

// Show Expected Parameter Mapping
echo "<div class='section'>";
echo "<h3>📋 Expected Parameter Mapping</h3>";
echo "<div class='code'>";
echo "<strong>admin_process.php expects:</strong><br>";
echo "• Students: delete_student<br>";
echo "• Classes: delete_class<br>";
echo "• Notices: delete_notice<br>";
echo "• Public Notices: delete_public_notice<br>";
echo "• Contact Messages: delete_contact<br>";
echo "<br>";
echo "<strong>Batch delete uses:</strong><br>";
echo "• Separate file: delete_batch.php<br>";
echo "• GET parameter: id<br>";
echo "</div>";
echo "</div>";

// Display any session messages
if (isset($_SESSION['success'])) {
    echo "<div class='success'>✅ " . $_SESSION['success'] . "</div>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo "<div class='error'>❌ " . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}

echo "<hr>";
echo "<p><a href='frontend/admin_dashboard.php' class='btn' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;'>🏠 Back to Admin Dashboard</a></p>";

$conn->close();
?>
