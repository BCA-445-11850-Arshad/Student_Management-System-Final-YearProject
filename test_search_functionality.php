<?php
/*
Test file to verify search functionality works properly
This will test the search features for students and classes
*/

session_start();
require_once 'backend/connection_simple.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Search Functionality Test</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 1200px; margin: 0 auto; }
        .section { margin: 30px 0; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .search-box { margin: 20px 0; }
        .search-input { padding: 12px 45px 12px 20px; border: 2px solid #e5e7eb; border-radius: 8px; width: 400px; font-size: 14px; outline: none; transition: border-color 0.3s; }
        .search-input:focus { border-color: #3b82f6; }
        .search-container { position: relative; display: inline-block; }
        .search-icon { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #6b7280; }
        .clear-btn { padding: 12px 15px; background: #f3f4f6; border: 1px solid #d1d5db; border-radius: 6px; cursor: pointer; font-size: 14px; margin-left: 10px; }
        .results-info { margin: 15px 0; font-weight: 600; color: #6b7280; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #f8f9fa; font-weight: 600; }
        .highlight { background: #fef3c7; padding: 2px 4px; border-radius: 3px; }
        .no-results { text-align: center; padding: 40px; color: #6b7280; }
        .test-info { background: #e0f2fe; padding: 15px; border-radius: 6px; margin: 20px 0; }
        .feature-list { background: #f0fdf4; padding: 15px; border-radius: 6px; margin: 20px 0; }
        h1 { color: #1f2937; }
        h2 { color: #374151; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px; }
    </style>
</head>
<body>";

echo "<div class='container'>
    <h1>🔍 Search Functionality Test</h1>
    
    <div class='test-info'>
        <h3>ℹ️ Test Information</h3>
        <p>This page tests the search functionality that has been added to the admin dashboard.</p>
        <p><strong>Features:</strong></p>
        <ul>
            <li>Real-time search as you type</li>
            <li>Search across multiple fields</li>
            <li>Result counting and feedback</li>
            <li>Clear search functionality</li>
            <li>Enter key support</li>
        </ul>
    </div>";

// Get test data
$students_query = "SELECT s.id, s.name, s.email, s.phone, c.class_name, b.batch_name FROM students s 
                  LEFT JOIN classes c ON s.class_id = c.id 
                  LEFT JOIN batches b ON s.batch_id = b.id 
                  ORDER BY s.name LIMIT 10";
$students_result = $conn->query($students_query);

$classes_query = "SELECT * FROM classes ORDER BY class_name LIMIT 10";
$classes_result = $conn->query($classes_query);

// Students Section
echo "<div class='section'>
    <h2>👥 Students Search Test</h2>
    
    <div class='search-box'>
        <div class='search-container'>
            <input type='text' id='studentSearchTest' class='search-input' placeholder='🔍 Search students by name, email, phone, class, batch...' onkeyup='filterStudentsTest()'>
            <i class='fas fa-search search-icon'></i>
        </div>
        <button class='clear-btn' onclick='clearStudentSearchTest()'><i class='fas fa-times'></i> Clear</button>
    </div>
    
    <div id='studentSearchResults' class='results-info'></div>
    
    <table id='studentsTable'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Class</th>
                <th>Batch</th>
            </tr>
        </thead>
        <tbody>";

if ($students_result && $students_result->num_rows > 0) {
    while ($student = $students_result->fetch_assoc()) {
        echo "<tr id='student-{$student['id']}' 
                  data-name='" . htmlspecialchars(strtolower($student['name'])) . "'
                  data-email='" . htmlspecialchars(strtolower($student['email'])) . "'
                  data-phone='" . htmlspecialchars(strtolower($student['phone'])) . "'
                  data-class='" . htmlspecialchars(strtolower($student['class_name'] ?? '')) . "'
                  data-batch='" . htmlspecialchars(strtolower($student['batch_name'] ?? '')) . "'>
            <td>{$student['id']}</td>
            <td><strong>" . htmlspecialchars($student['name']) . "</strong></td>
            <td>" . htmlspecialchars($student['email']) . "</td>
            <td>" . htmlspecialchars($student['phone']) . "</td>
            <td>" . htmlspecialchars($student['class_name'] ?? 'N/A') . "</td>
            <td>" . htmlspecialchars($student['batch_name'] ?? 'N/A') . "</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='6' class='no-results'>No students found</td></tr>";
}

echo "        </tbody>
    </table>
</div>";

// Classes Section
echo "<div class='section'>
    <h2>📚 Classes Search Test</h2>
    
    <div class='search-box'>
        <div class='search-container'>
            <input type='text' id='classSearchTest' class='search-input' placeholder='🔍 Search classes by name or description...' onkeyup='filterClassesTest()'>
            <i class='fas fa-search search-icon'></i>
        </div>
        <button class='clear-btn' onclick='clearClassSearchTest()'><i class='fas fa-times'></i> Clear</button>
    </div>
    
    <div id='classSearchResults' class='results-info'></div>
    
    <table id='classesTable'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Class Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>";

if ($classes_result && $classes_result->num_rows > 0) {
    while ($class = $classes_result->fetch_assoc()) {
        echo "<tr id='class-{$class['id']}' 
                  data-name='" . htmlspecialchars(strtolower($class['class_name'])) . "'
                  data-description='" . htmlspecialchars(strtolower($class['description'] ?? '')) . "'>
            <td>{$class['id']}</td>
            <td><strong>" . htmlspecialchars($class['class_name']) . "</strong></td>
            <td>" . htmlspecialchars($class['description'] ?? 'No description') . "</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='3' class='no-results'>No classes found</td></tr>";
}

echo "        </tbody>
    </table>
</div>";

// Feature List
echo "<div class='feature-list'>
    <h3>✅ Implemented Search Features</h3>
    <ul>
        <li><strong>Students Search:</strong> Search by name, email, phone, class, batch</li>
        <li><strong>Classes Search:</strong> Search by class name, description</li>
        <li><strong>Real-time Filtering:</strong> Results update as you type</li>
        <li><strong>Result Counting:</strong> Shows number of matches found</li>
        <li><strong>No Results Message:</strong> Friendly message when no matches found</li>
        <li><strong>Clear Function:</strong> Easy button to clear search</li>
        <li><strong>Enter Key Support:</strong> Press Enter to search</li>
        <li><strong>Case Insensitive:</strong> Search works regardless of case</li>
        <li><strong>Partial Matching:</strong> Finds partial matches within text</li>
    </ul>
</div>";

echo "<div style='text-align: center; margin: 30px 0;'>
    <a href='frontend/admin_dashboard.php' style='background: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; font-weight: 600;'>
        <i class='fas fa-arrow-left'></i> Back to Admin Dashboard
    </a>
</div>";

echo "</div>";

// JavaScript for search functionality
echo "<script>
// Student Search Functions
function filterStudentsTest() {
    const searchValue = document.getElementById('studentSearchTest').value.toLowerCase();
    const studentRows = document.querySelectorAll('[id^=\"student-\"]');
    let visibleCount = 0;
    
    studentRows.forEach(row => {
        const name = row.getAttribute('data-name') || '';
        const email = row.getAttribute('data-email') || '';
        const phone = row.getAttribute('data-phone') || '';
        const className = row.getAttribute('data-class') || '';
        const batchName = row.getAttribute('data-batch') || '';
        
        const matchesSearch = name.includes(searchValue) || 
                            email.includes(searchValue) || 
                            phone.includes(searchValue) || 
                            className.includes(searchValue) || 
                            batchName.includes(searchValue);
        
        if (matchesSearch) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    updateStudentSearchResults(visibleCount, searchValue);
}

function updateStudentSearchResults(count, searchTerm) {
    const resultsDiv = document.getElementById('studentSearchResults');
    const totalStudents = document.querySelectorAll('[id^=\"student-\"]').length;
    
    if (searchTerm.trim() === '') {
        resultsDiv.innerHTML = '';
    } else if (count === 0) {
        resultsDiv.innerHTML = '<span style=\"color: #ef4444;\">❌ No students found for \"' + searchTerm + '\"</span>';
    } else {
        resultsDiv.innerHTML = '<span style=\"color: #10b981;\">✅ Found ' + count + ' student' + (count > 1 ? 's' : '') + ' for \"' + searchTerm + '\" (showing ' + count + ' of ' + totalStudents + ')</span>';
    }
}

function clearStudentSearchTest() {
    document.getElementById('studentSearchTest').value = '';
    filterStudentsTest();
}

// Class Search Functions
function filterClassesTest() {
    const searchValue = document.getElementById('classSearchTest').value.toLowerCase();
    const classRows = document.querySelectorAll('[id^=\"class-\"]');
    let visibleCount = 0;
    
    classRows.forEach(row => {
        const name = row.getAttribute('data-name') || '';
        const description = row.getAttribute('data-description') || '';
        
        const matchesSearch = name.includes(searchValue) || description.includes(searchValue);
        
        if (matchesSearch) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    updateClassSearchResults(visibleCount, searchValue);
}

function updateClassSearchResults(count, searchTerm) {
    const resultsDiv = document.getElementById('classSearchResults');
    const totalClasses = document.querySelectorAll('[id^=\"class-\"]').length;
    
    if (searchTerm.trim() === '') {
        resultsDiv.innerHTML = '';
    } else if (count === 0) {
        resultsDiv.innerHTML = '<span style=\"color: #ef4444;\">❌ No classes found for \"' + searchTerm + '\"</span>';
    } else {
        resultsDiv.innerHTML = '<span style=\"color: #10b981;\">✅ Found ' + count + ' class' + (count > 1 ? 'es' : '') + ' for \"' + searchTerm + '\" (showing ' + count + ' of ' + totalClasses + ')</span>';
    }
}

function clearClassSearchTest() {
    document.getElementById('classSearchTest').value = '';
    filterClassesTest();
}

// Add enter key support
document.addEventListener('DOMContentLoaded', function() {
    const studentSearchInput = document.getElementById('studentSearchTest');
    if (studentSearchInput) {
        studentSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                filterStudentsTest();
            }
        });
    }
    
    const classSearchInput = document.getElementById('classSearchTest');
    if (classSearchInput) {
        classSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                filterClassesTest();
            }
        });
    }
});
</script>";

echo "</body>
</html>";

$conn->close();
?>
