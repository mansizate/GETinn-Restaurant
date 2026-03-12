<?php
require_once "../includes/connection.php";

echo "<h2>Admin Login Debug Tool</h2>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; }
table { border-collapse: collapse; width: 100%; margin: 20px 0; }
th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
th { background-color: #f2f2f2; }
tr:nth-child(even) { background-color: #f9f9f9; }
.error { color: red; font-weight: bold; }
.success { color: green; font-weight: bold; }
.warning { color: orange; font-weight: bold; }
.info { background: #e7f3ff; padding: 15px; border-left: 6px solid #2196F3; margin: 15px 0; }
</style>";

// Check if admin table exists
echo "<h3>1. Checking Admin Table:</h3>";
$tableCheck = "SHOW TABLES LIKE 'admin'";
$tableResult = mysqli_query($conn, $tableCheck);

if (mysqli_num_rows($tableResult) == 0) {
    echo "<div class='error'>❌ Error: 'admin' table does not exist!</div>";
    echo "<p>You need to create the admin table first.</p>";
    
    echo "<h4>Create Admin Table:</h4>";
    echo "<textarea rows='10' cols='80' readonly>";
    echo "CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    resettoken VARCHAR(255) NULL,
    resettokenexpire DATETIME NULL,
    enable_menu_page TINYINT(1) DEFAULT 1
);";
    echo "</textarea>";
    
} else {
    echo "<div class='success'>✅ Admin table exists</div>";
    
    // Check table structure
    echo "<h4>Table Structure:</h4>";
    $structureQuery = "DESCRIBE admin";
    $structureResult = mysqli_query($conn, $structureQuery);
    
    if ($structureResult) {
        echo "<table>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = mysqli_fetch_assoc($structureResult)) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . ($row['Default'] ?? 'NULL') . "</td>";
            echo "<td>" . $row['Extra'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
}

// Check admin users
echo "<h3>2. Checking Admin Users:</h3>";
$adminQuery = "SELECT id, email, name, password FROM admin";
$adminResult = mysqli_query($conn, $adminQuery);

if ($adminResult) {
    $adminCount = mysqli_num_rows($adminResult);
    echo "<p><strong>Total admin users: $adminCount</strong></p>";
    
    if ($adminCount > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Email</th><th>Name</th><th>Password Hash (first 20 chars)</th><th>Password Length</th></tr>";
        
        while ($row = mysqli_fetch_assoc($adminResult)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
            echo "<td>" . substr($row['password'], 0, 20) . "...</td>";
            echo "<td>" . strlen($row['password']) . " chars</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Check if passwords look like they're hashed
        mysqli_data_seek($adminResult, 0); // Reset result pointer
        $firstAdmin = mysqli_fetch_assoc($adminResult);
        if (strlen($firstAdmin['password']) < 50) {
            echo "<div class='warning'>⚠️ Warning: Password doesn't look hashed (too short). Passwords should be hashed with password_hash().</div>";
        } else {
            echo "<div class='success'>✅ Password appears to be properly hashed.</div>";
        }
        
    } else {
        echo "<div class='warning'>⚠️ No admin users found in database!</div>";
        echo "<p>You need to create an admin user first.</p>";
    }
} else {
    echo "<div class='error'>❌ Error querying admin table: " . mysqli_error($conn) . "</div>";
}

// Test login functionality
echo "<h3>3. Test Admin Login:</h3>";
echo "<form method='POST'>";
echo "<p><label>Email: <input type='email' name='test_email' required style='width: 300px;'></label></p>";
echo "<p><label>Password: <input type='password' name='test_password' required style='width: 300px;'></label></p>";
echo "<button type='submit' name='test_login' style='background: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px;'>Test Login</button>";
echo "</form>";

if (isset($_POST['test_login'])) {
    echo "<div class='info'>";
    echo "<h4>Login Test Results:</h4>";
    
    $test_email = mysqli_real_escape_string($conn, $_POST['test_email']);
    $test_password = $_POST['test_password'];
    
    echo "<p><strong>Testing email:</strong> " . htmlspecialchars($test_email) . "</p>";
    
    $query = "SELECT * FROM admin WHERE email='$test_email'";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            echo "<p class='success'>✅ Email found in database</p>";
            
            $result_fetch = mysqli_fetch_assoc($result);
            echo "<p><strong>Stored password hash:</strong> " . substr($result_fetch['password'], 0, 30) . "...</p>";
            
            if (password_verify($test_password, $result_fetch['password'])) {
                echo "<p class='success'>✅ Password verification successful!</p>";
                echo "<p class='success'>🎉 Login should work!</p>";
            } else {
                echo "<p class='error'>❌ Password verification failed</p>";
                echo "<p>This means either:</p>";
                echo "<ul>";
                echo "<li>Wrong password entered</li>";
                echo "<li>Password in database is not properly hashed</li>";
                echo "<li>Password was hashed with different method</li>";
                echo "</ul>";
            }
        } else {
            echo "<p class='error'>❌ Email not found in database</p>";
        }
    } else {
        echo "<p class='error'>❌ Database query failed: " . mysqli_error($conn) . "</p>";
    }
    echo "</div>";
}

// Admin creation form
echo "<hr>";
echo "<h3>4. Create Admin User (if needed):</h3>";
echo "<form method='POST'>";
echo "<p><label>Name: <input type='text' name='admin_name' required style='width: 300px;'></label></p>";
echo "<p><label>Email: <input type='email' name='admin_email' required style='width: 300px;'></label></p>";
echo "<p><label>Password: <input type='password' name='admin_password' required style='width: 300px;'></label></p>";
echo "<button type='submit' name='create_admin' style='background: #2196F3; color: white; padding: 10px 20px; border: none; border-radius: 5px;'>Create Admin User</button>";
echo "</form>";

if (isset($_POST['create_admin'])) {
    $name = mysqli_real_escape_string($conn, $_POST['admin_name']);
    $email = mysqli_real_escape_string($conn, $_POST['admin_email']);
    $password = password_hash($_POST['admin_password'], PASSWORD_BCRYPT);
    
    // Check if email already exists
    $checkQuery = "SELECT * FROM admin WHERE email='$email'";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        echo "<div class='error'>❌ Admin with this email already exists!</div>";
    } else {
        $insertQuery = "INSERT INTO admin (name, email, password, enable_menu_page) VALUES ('$name', '$email', '$password', 1)";
        
        if (mysqli_query($conn, $insertQuery)) {
            echo "<div class='success'>✅ Admin user created successfully!</div>";
            echo "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
            echo "<p><strong>Password:</strong> [the password you entered]</p>";
            echo "<p>You can now try logging in with these credentials.</p>";
        } else {
            echo "<div class='error'>❌ Error creating admin user: " . mysqli_error($conn) . "</div>";
        }
    }
}

echo "<hr>";
echo "<h3>5. Quick Fixes:</h3>";
echo "<div class='info'>";
echo "<h4>If you're still having issues:</h4>";
echo "<ol>";
echo "<li><strong>Check your admin credentials:</strong> Make sure you're using the correct email and password</li>";
echo "<li><strong>Create a new admin:</strong> Use the form above to create a test admin user</li>";
echo "<li><strong>Check database connection:</strong> Make sure your database connection is working</li>";
echo "<li><strong>Clear browser cache:</strong> Sometimes old JavaScript can cause issues</li>";
echo "</ol>";
echo "</div>";
?>