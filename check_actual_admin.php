<?php
/*
Check actual admin data in database
*/

require_once 'backend/connection_simple.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Check Actual Admin Data</title>
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
        .highlight { background: #fef3c7; padding: 15px; border-radius: 6px; border-left: 4px solid #f59e0b; margin: 15px 0; }
        .btn { background: #3b82f6; color: white; padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn:hover { background: #2563eb; }
    </style>
</head>
<body>";

echo "<div class='container'>
    <h1>Actual Admin Data Check</h1>";

// Check admin table
echo "<div class='section'>
    <h2>Current Admin Records in Database</h2>";

try {
    $sql = "SELECT * FROM admin";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        echo "<p class='success'>Found " . $result->num_rows . " admin records:</p>";
        echo "<table>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Password</th><th>Phone</th><th>Address</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td><strong>" . htmlspecialchars($row['email']) . "</strong></td>
                <td><strong>" . htmlspecialchars($row['password']) . "</strong></td>
                <td>" . htmlspecialchars($row['phone']) . "</td>
                <td>" . htmlspecialchars($row['address']) . "</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='error'>No admin records found in database!</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>Error checking admin table: " . $e->getMessage() . "</p>";
}

echo "</div>";

// Show correct login details
echo "<div class='highlight'>
    <h2>Correct Admin Login Details:</h2>
    <table>
        <tr><th>Field</th><th>Value</th></tr>
        <tr>
            <td>Email</td>
            <td><strong>arshadshaikhofficial0@gmail.com</strong></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><strong>Arshad@123</strong></td>
        </tr>
    </table>
</div>";

echo "<div class='section'>
    <h2>Test Login Form</h2>
    <form method='POST' action='backend/login_process.php' style='background: #f0f9ff; padding: 20px; border-radius: 6px;'>
        <input type='hidden' name='user_type' value='admin'>
        <div style='margin: 15px 0;'>
            <label style='display: block; margin-bottom: 5px; font-weight: 600;'>Email:</label>
            <input type='email' name='email' value='arshadshaikhofficial0@gmail.com' required 
                   style='width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px;'>
        </div>
        <div style='margin: 15px 0;'>
            <label style='display: block; margin-bottom: 5px; font-weight: 600;'>Password:</label>
            <input type='password' name='password' value='Arshad@123' required 
                   style='width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px;'>
        </div>
        <button type='submit' class='btn'>Login with Correct Credentials</button>
    </form>
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
