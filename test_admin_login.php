<?php
/*
Test file to check admin login and database connection
*/

require_once 'backend/connection_simple.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Admin Login Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .section { margin: 20px 0; padding: 20px; border: 1px solid #e5e7eb; border-radius: 6px; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        th { background: #f8f9fa; font-weight: 600; }
        .success { color: #10b981; }
        .error { color: #ef4444; }
        .info { color: #3b82f6; }
        h1 { color: #1f2937; }
        h2 { color: #374151; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px; }
        .test-form { background: #f0f9ff; padding: 20px; border-radius: 6px; margin: 20px 0; }
        .form-group { margin: 15px 0; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px; }
        .btn { background: #3b82f6; color: white; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; }
        .btn:hover { background: #2563eb; }
    </style>
</head>
<body>";

echo "<div class='container'>
    <h1>Admin Login Test</h1>";

// Test database connection
if ($conn) {
    echo "<div class='section'>
        <h2>Database Connection</h2>
        <p class='success'>Database connection successful!</p>
    </div>";
} else {
    echo "<div class='section'>
        <h2>Database Connection</h2>
        <p class='error'>Database connection failed!</p>
    </div>";
    echo "</div></body></html>";
    exit;
}

// Check admin table
echo "<div class='section'>
    <h2>Admin Table Check</h2>";

try {
    $sql = "SELECT * FROM admin";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        echo "<p class='success'>Found " . $result->num_rows . " admin records:</p>";
        echo "<table>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Password</th><th>Phone</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['password']) . "</td>
                <td>" . htmlspecialchars($row['phone']) . "</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='error'>No admin records found in database!</p>";
        echo "<p class='info'>Please import the database.sql file first.</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>Error checking admin table: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Test login form
echo "<div class='test-form'>
    <h2>Test Admin Login</h2>
    <form method='POST' action='backend/login_process.php'>
        <input type='hidden' name='user_type' value='admin'>
        <div class='form-group'>
            <label for='email'>Email:</label>
            <input type='email' id='email' name='email' value='admin@studentms.com' required>
        </div>
        <div class='form-group'>
            <label for='password'>Password:</label>
            <input type='password' id='password' name='password' value='Arshad@123' required>
        </div>
        <button type='submit' class='btn'>Test Login</button>
    </form>
</div>";

// Show expected credentials
echo "<div class='section'>
    <h2>Expected Admin Credentials</h2>
    <table>
        <tr><th>Field</th><th>Value</th></tr>
        <tr><td>Email</td><td>admin@studentms.com</td></tr>
        <tr><td>Password</td><td>Arshad@123</td></tr>
    </table>
</div>";

echo "<div class='section'>
    <h2>Troubleshooting Steps</h2>
    <ol>
        <li><strong>Check Database Import:</strong> Make sure you imported database.sql file in MySQL</li>
        <li><strong>Verify Connection:</strong> Check if connection_simple.php is working</li>
        <li><strong>Check Admin Table:</strong> Verify admin records exist in database</li>
        <li><strong>Password Format:</strong> Database should contain plain text password 'Arshad@123'</li>
        <li><strong>Login Process:</strong> login_process.php should use direct password comparison</li>
    </ol>
</div>";

echo "<div style='text-align: center; margin: 30px 0;'>
    <a href='frontend/admin_login.php' class='btn'>Go to Admin Login</a>
    <a href='index.php' class='btn' style='margin-left: 10px; background: #6b7280;'>Back to Home</a>
</div>";

echo "</div>";
$conn->close();
echo "</body>
</html>";
?>
