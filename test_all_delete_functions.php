<?php
/*
Comprehensive test file for all delete functionality
Tests all delete operations across admin sections
*/

session_start();
require_once 'backend/connection_simple.php';

echo "<h2>🧪 Testing All Delete Functions</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { border-collapse: collapse; margin: 20px 0; width: 100%; }
    th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
    th { background-color: #f2f2f2; }
    .test-btn { background: #007bff; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; margin: 2px; }
    .test-btn:hover { background: #0056b3; }
    .danger-btn { background: #dc3545; }
    .danger-btn:hover { background: #c82333; }
    .success { color: green; }
    .error { color: red; }
    .warning { color: orange; }
    .section { margin: 30px 0; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
</style>";

// Test Students Section
echo "<div class='section'>";
echo "<h3>👥 Students Delete Test</h3>";

$result = $conn->query("SELECT id, name, email FROM students ORDER BY id LIMIT 5");
if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td><a href='frontend/delete_student.php?id=" . $row['id'] . "' class='test-btn danger-btn' onclick='return confirm(\"Delete student " . htmlspecialchars($row['name']) . "?\")'>🗑️ Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='warning'>⚠️ No students found to test.</p>";
}
echo "</div>";

// Test Classes Section
echo "<div class='section'>";
echo "<h3>📚 Classes Delete Test</h3>";

$result = $conn->query("SELECT id, class_name FROM classes ORDER BY id LIMIT 5");
if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Class Name</th><th>Students Count</th><th>Batches Count</th><th>Action</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        // Check student count
        $student_check = $conn->prepare("SELECT COUNT(*) as count FROM students WHERE class_id = ?");
        $student_check->bind_param("i", $row['id']);
        $student_check->execute();
        $student_result = $student_check->get_result();
        $student_count = $student_result->fetch_assoc()['count'];
        $student_check->close();
        
        // Check batch count
        $batch_check = $conn->prepare("SELECT COUNT(*) as count FROM batches WHERE class_id = ?");
        $batch_check->bind_param("i", $row['id']);
        $batch_check->execute();
        $batch_result = $batch_check->get_result();
        $batch_count = $batch_result->fetch_assoc()['count'];
        $batch_check->close();
        
        $can_delete = ($student_count == 0 && $batch_count == 0);
        
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['class_name']) . "</td>";
        echo "<td>" . $student_count . "</td>";
        echo "<td>" . $batch_count . "</td>";
        echo "<td>";
        if ($can_delete) {
            echo "<a href='frontend/delete_class.php?id=" . $row['id'] . "' class='test-btn danger-btn' onclick='return confirm(\"Delete class " . htmlspecialchars($row['class_name']) . "?\")'>🗑️ Delete</a>";
        } else {
            echo "<span class='warning'>⚠️ Cannot delete (has dependencies)</span>";
        }
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='warning'>⚠️ No classes found to test.</p>";
}
echo "</div>";

// Test Batches Section
echo "<div class='section'>";
echo "<h3>🎯 Batches Delete Test</h3>";

$result = $conn->query("SELECT b.id, b.batch_name, c.class_name FROM batches b LEFT JOIN classes c ON b.class_id = c.id ORDER BY b.id LIMIT 5");
if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Batch Name</th><th>Class</th><th>Students Count</th><th>Action</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        // Check student count
        $student_check = $conn->prepare("SELECT COUNT(*) as count FROM students WHERE batch_id = ?");
        $student_check->bind_param("i", $row['id']);
        $student_check->execute();
        $student_result = $student_check->get_result();
        $student_count = $student_result->fetch_assoc()['count'];
        $student_check->close();
        
        $can_delete = ($student_count == 0);
        
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['batch_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['class_name'] ?? 'N/A') . "</td>";
        echo "<td>" . $student_count . "</td>";
        echo "<td>";
        if ($can_delete) {
            echo "<a href='frontend/delete_batch.php?id=" . $row['id'] . "' class='test-btn danger-btn' onclick='return confirm(\"Delete batch " . htmlspecialchars($row['batch_name']) . "?\")'>🗑️ Delete</a>";
        } else {
            echo "<span class='warning'>⚠️ Cannot delete (has " . $student_count . " students)</span>";
        }
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='warning'>⚠️ No batches found to test.</p>";
}
echo "</div>";

// Test Notices Section
echo "<div class='section'>";
echo "<h3>📢 Notices Delete Test</h3>";

$result = $conn->query("SELECT id, title FROM notices ORDER BY id LIMIT 5");
if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Title</th><th>Action</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td><a href='frontend/delete_notice.php?id=" . $row['id'] . "' class='test-btn danger-btn' onclick='return confirm(\"Delete notice " . htmlspecialchars($row['title']) . "?\")'>🗑️ Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='warning'>⚠️ No notices found to test.</p>";
}
echo "</div>";

// Test Public Notices Section
echo "<div class='section'>";
echo "<h3>🌐 Public Notices Delete Test</h3>";

$result = $conn->query("SELECT id, title FROM public_notices ORDER BY id LIMIT 5");
if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Title</th><th>Action</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td><a href='frontend/delete_public_notice.php?id=" . $row['id'] . "' class='test-btn danger-btn' onclick='return confirm(\"Delete public notice " . htmlspecialchars($row['title']) . "?\")'>🗑️ Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='warning'>⚠️ No public notices found to test.</p>";
}
echo "</div>";

// Test Contact Messages Section
echo "<div class='section'>";
echo "<h3>💬 Contact Messages Delete Test</h3>";

$result = $conn->query("SELECT id, name, email FROM contact_messages ORDER BY id LIMIT 5");
if ($result && $result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td><a href='frontend/delete_message.php?id=" . $row['id'] . "' class='test-btn danger-btn' onclick='return confirm(\"Delete message from " . htmlspecialchars($row['name']) . "?\")'>🗑️ Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='warning'>⚠️ No contact messages found to test.</p>";
}
echo "</div>";

// Display session messages if any
if (isset($_SESSION['success'])) {
    echo "<div class='success'>✅ " . $_SESSION['success'] . "</div>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo "<div class='error'>❌ " . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}

echo "<hr>";
echo "<p><strong>📝 Instructions:</strong></p>";
echo "<ul>";
echo "<li>Click on any delete button to test the delete functionality</li>";
echo "<li>Classes and batches with dependencies cannot be deleted (safety feature)</li>";
echo "<li>All delete operations will show confirmation dialogs</li>";
echo "<li>After deletion, you'll be redirected back to admin dashboard with success/error messages</li>";
echo "</ul>";

echo "<p><a href='frontend/admin_dashboard.php' class='test-btn'>🏠 Back to Admin Dashboard</a></p>";

$conn->close();
?>
