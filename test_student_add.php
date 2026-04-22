<?php
/*
Test file to verify student addition functionality
This will test the admin_process.php student add functionality
*/

session_start();
require_once 'backend/connection_simple.php';

echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Test Student Addition</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f8f9fa; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 5px; font-weight: 600; color: #374151; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; }
        .form-control:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .btn { padding: 12px 24px; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3b82f6; color: white; }
        .btn-primary:hover { background: #2563eb; }
        .btn-success { background: #10b981; color: white; }
        .btn-success:hover { background: #059669; }
        .alert { padding: 15px; margin: 20px 0; border-radius: 6px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-grid .form-group:last-child { grid-column: 1 / -1; }
        h1 { color: #1f2937; margin-bottom: 30px; }
        h2 { color: #374151; margin-bottom: 20px; }
    </style>
</head>
<body>";

echo "<div class='container'>
    <h1>🧪 Test Student Addition</h1>
    
    <p>This page tests the student addition functionality. Fill in the form below to test adding a new student.</p>";

// Display session messages
if (isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>
        <i class='fas fa-check-circle'></i> " . $_SESSION['success'] . "
    </div>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-error'>
        <i class='fas fa-exclamation-circle'></i> " . $_SESSION['error'] . "
    </div>";
    unset($_SESSION['error']);
}

// Get classes for dropdown
$classes = [];
$result = $conn->query("SELECT * FROM classes ORDER BY class_name");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $classes[] = $row;
    }
}

echo "<form method='POST' action='backend/admin_process.php' enctype='multipart/form-data'>
    <input type='hidden' name='action' value='add_student'>
    
    <h2>📝 Student Information</h2>
    
    <div class='form-grid'>
        <div class='form-group'>
            <label class='form-label'>Full Name *</label>
            <input type='text' name='name' required class='form-control' placeholder='Enter full name'>
        </div>
        
        <div class='form-group'>
            <label class='form-label'>Email *</label>
            <input type='email' name='email' required class='form-control' placeholder='Enter email address'>
        </div>
        
        <div class='form-group'>
            <label class='form-label'>Phone *</label>
            <input type='tel' name='phone' required class='form-control' placeholder='Enter phone number'>
        </div>
        
        <div class='form-group'>
            <label class='form-label'>Date of Birth</label>
            <input type='date' name='dob' class='form-control'>
        </div>
        
        <div class='form-group'>
            <label class='form-label'>Gender</label>
            <select name='gender' class='form-control'>
                <option value=''>Select Gender</option>
                <option value='Male'>Male</option>
                <option value='Female'>Female</option>
                <option value='Other'>Other</option>
            </select>
        </div>
        
        <div class='form-group'>
            <label class='form-label'>Blood Group</label>
            <select name='blood_group' class='form-control'>
                <option value=''>Select Blood Group</option>
                <option value='A+'>A+</option>
                <option value='A-'>A-</option>
                <option value='B+'>B+</option>
                <option value='B-'>B-</option>
                <option value='O+'>O+</option>
                <option value='O-'>O-</option>
                <option value='AB+'>AB+</option>
                <option value='AB-'>AB-</option>
            </select>
        </div>
        
        <div class='form-group'>
            <label class='form-label'>Password *</label>
            <input type='password' name='password' required class='form-control' placeholder='Enter password'>
        </div>
        
        <div class='form-group'>
            <label class='form-label'>Confirm Password *</label>
            <input type='password' name='confirm_password' required class='form-control' placeholder='Confirm password'>
        </div>
        
        <div class='form-group'>
            <label class='form-label'>Photo</label>
            <input type='file' name='photo' accept='image/*' class='form-control'>
        </div>
        
        <div class='form-group'>
            <label class='form-label'>Class *</label>
            <select name='class_id' required class='form-control'>
                <option value=''>Select Class</option>";
                foreach ($classes as $class) {
                    echo "<option value='" . $class['id'] . "'>" . htmlspecialchars($class['class_name']) . "</option>";
                }
echo "            </select>
        </div>
        
        <div class='form-group'>
            <label class='form-label'>Batch</label>
            <select name='batch_id' class='form-control'>
                <option value=''>Select Batch (Optional)</option>";
                // Get batches for each class
                $batches_result = $conn->query("SELECT * FROM batches ORDER BY batch_name");
                if ($batches_result) {
                    while ($batch = $batches_result->fetch_assoc()) {
                        echo "<option value='" . $batch['id'] . "'>" . htmlspecialchars($batch['batch_name']) . "</option>";
                    }
                }
echo "            </select>
        </div>
        
        <div class='form-group'>
            <label class='form-label'>Session</label>
            <input type='text' name='session' class='form-control' placeholder='e.g., 2023 or 2023-24'>
        </div>
        
        <div class='form-group'>
            <label class='form-label'>Address</label>
            <textarea name='address' rows='3' class='form-control' placeholder='Enter address'></textarea>
        </div>
    </div>
    
    <div style='display: flex; gap: 15px; margin-top: 30px;'>
        <button type='submit' class='btn btn-success'>
            <i class='fas fa-plus'></i> Add Student
        </button>
        <a href='frontend/admin_dashboard.php#students' class='btn btn-primary'>
            <i class='fas fa-arrow-left'></i> Back to Dashboard
        </a>
    </div>
</form>

</div>";

$conn->close();
echo "</body>
</html>";
?>
