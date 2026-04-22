<!DOCTYPE html>
<html>
<head>
    <title>Test Student Form</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 300px; padding: 8px; border: 1px solid #ccc; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        .success { color: green; margin: 10px 0; }
        .error { color: red; margin: 10px 0; }
    </style>
</head>
<body>
    <h2>Test Add Student Form (No JavaScript Validation)</h2>
    
    <?php
    session_start();
    if (isset($_SESSION['success'])) {
        echo '<div class="success">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo '<div class="error">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    ?>
    
    <form method="POST" action="backend/admin_process.php">
        <input type="hidden" name="action" value="add_student">
        
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" required value="Test Student">
        </div>
        
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required value="test@example.com">
        </div>
        
        <div class="form-group">
            <label>Phone:</label>
            <input type="tel" name="phone" required value="9876543210">
        </div>
        
        <div class="form-group">
            <label>Address:</label>
            <input type="text" name="address" required value="123 Test Street">
        </div>
        
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required value="Test123@">
        </div>
        
        <div class="form-group">
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" required value="Test123@">
        </div>
        
        <div class="form-group">
            <label>Blood Group:</label>
            <select name="blood_group">
                <option value="O+">O+</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Class:</label>
            <input type="number" name="class_id" value="1">
        </div>
        
        <div class="form-group">
            <label>Batch:</label>
            <input type="number" name="batch_id" value="1">
        </div>
        
        <div class="form-group">
            <label>Session:</label>
            <input type="text" name="session" value="2023-24">
        </div>
        
        <button type="submit">Add Student</button>
    </form>
</body>
</html>
