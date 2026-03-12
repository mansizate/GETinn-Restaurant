<?php
require_once "../includes/connection.php";

echo "<h2>Database Column Fix Tool</h2>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; }
.success { color: green; font-weight: bold; }
.error { color: red; font-weight: bold; }
.warning { color: orange; font-weight: bold; }
.info { background: #e7f3ff; padding: 15px; border-left: 6px solid #2196F3; margin: 15px 0; }
</style>";

echo "<div class='info'>";
echo "<h3>🔧 Fixing Column Name Issue</h3>";
echo "<p>This tool will check and fix the column name typo in your database.</p>";
echo "<p>The issue: <code>enable_meessage</code> should be <code>enable_message</code></p>";
echo "</div>";

// Check if admin_message table exists
echo "<h3>1. Checking admin_message table:</h3>";
$tableCheck = "SHOW TABLES LIKE 'admin_message'";
$tableResult = mysqli_query($conn, $tableCheck);

if (mysqli_num_rows($tableResult) == 0) {
    echo "<div class='warning'>⚠️ admin_message table doesn't exist. Creating it...</div>";
    
    $createTable = "CREATE TABLE admin_message (
        id INT AUTO_INCREMENT PRIMARY KEY,
        message TEXT NOT NULL,
        enable_message TINYINT(1) DEFAULT 1
    )";
    
    if (mysqli_query($conn, $createTable)) {
        echo "<div class='success'>✅ admin_message table created successfully!</div>";
        
        // Insert a default message
        $insertDefault = "INSERT INTO admin_message (message, enable_message) VALUES ('Welcome to Taaza Restaurant!', 1)";
        if (mysqli_query($conn, $insertDefault)) {
            echo "<div class='success'>✅ Default message inserted!</div>";
        }
    } else {
        echo "<div class='error'>❌ Error creating table: " . mysqli_error($conn) . "</div>";
    }
} else {
    echo "<div class='success'>✅ admin_message table exists</div>";
    
    // Check table structure
    echo "<h3>2. Checking table structure:</h3>";
    $structureQuery = "DESCRIBE admin_message";
    $structureResult = mysqli_query($conn, $structureQuery);
    
    $hasCorrectColumn = false;
    $hasWrongColumn = false;
    
    if ($structureResult) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        
        while ($row = mysqli_fetch_assoc($structureResult)) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . ($row['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
            
            if ($row['Field'] == 'enable_message') {
                $hasCorrectColumn = true;
            }
            if ($row['Field'] == 'enable_meessage') {
                $hasWrongColumn = true;
            }
        }
        echo "</table>";
    }
    
    echo "<h3>3. Column Analysis:</h3>";
    
    if ($hasCorrectColumn && !$hasWrongColumn) {
        echo "<div class='success'>✅ Perfect! You have the correct column name: enable_message</div>";
    } elseif (!$hasCorrectColumn && $hasWrongColumn) {
        echo "<div class='warning'>⚠️ Found wrong column name: enable_meessage</div>";
        echo "<div class='info'>🔧 <strong>Fixing this now...</strong></div>";
        
        // Fix the column name
        $fixQuery = "ALTER TABLE admin_message CHANGE enable_meessage enable_message TINYINT(1) DEFAULT 1";
        if (mysqli_query($conn, $fixQuery)) {
            echo "<div class='success'>✅ Column name fixed successfully! enable_meessage → enable_message</div>";
        } else {
            echo "<div class='error'>❌ Error fixing column: " . mysqli_error($conn) . "</div>";
        }
    } elseif ($hasCorrectColumn && $hasWrongColumn) {
        echo "<div class='warning'>⚠️ You have both columns! This shouldn't happen.</div>";
        echo "<div class='info'>Removing the wrong column: enable_meessage</div>";
        
        $dropQuery = "ALTER TABLE admin_message DROP COLUMN enable_meessage";
        if (mysqli_query($conn, $dropQuery)) {
            echo "<div class='success'>✅ Wrong column removed successfully!</div>";
        } else {
            echo "<div class='error'>❌ Error removing wrong column: " . mysqli_error($conn) . "</div>";
        }
    } else {
        echo "<div class='warning'>⚠️ Neither column found. Adding the correct one...</div>";
        
        $addQuery = "ALTER TABLE admin_message ADD COLUMN enable_message TINYINT(1) DEFAULT 1";
        if (mysqli_query($conn, $addQuery)) {
            echo "<div class='success'>✅ Correct column added successfully!</div>";
        } else {
            echo "<div class='error'>❌ Error adding column: " . mysqli_error($conn) . "</div>";
        }
    }
}

// Final verification
echo "<h3>4. Final Verification:</h3>";
$testQuery = "SELECT * FROM admin_message LIMIT 1";
$testResult = mysqli_query($conn, $testQuery);

if ($testResult) {
    echo "<div class='success'>✅ Database is working correctly!</div>";
    
    if (mysqli_num_rows($testResult) > 0) {
        $row = mysqli_fetch_assoc($testResult);
        echo "<p><strong>Current message:</strong> " . htmlspecialchars($row['message']) . "</p>";
        echo "<p><strong>Status:</strong> " . ($row['enable_message'] ? 'Enabled' : 'Disabled') . "</p>";
    } else {
        echo "<div class='info'>No admin messages in database. You can add one from the admin panel.</div>";
    }
} else {
    echo "<div class='error'>❌ Still having issues: " . mysqli_error($conn) . "</div>";
}

echo "<hr>";
echo "<h3>✅ Summary:</h3>";
echo "<p>1. ✅ Fixed admin.php column name typo</p>";
echo "<p>2. ✅ Fixed enable-admin-message.php column name typo</p>";
echo "<p>3. ✅ Fixed disable-admin-message.php column name typo</p>";
echo "<p>4. ✅ Fixed database column name (if needed)</p>";
echo "<p>5. ✅ Fixed APPURL path in admin.php</p>";

echo "<div class='info'>";
echo "<h4>🎉 Your admin panel should now work correctly!</h4>";
echo "<p>Try accessing: <a href='admin.php'>admin.php</a></p>";
echo "</div>";
?>
