<?php
require_once "includes/connection.php";

echo "<h2>Manual Email Verification</h2>";
echo "<p>Use this tool to manually verify accounts when email isn't working.</p>";

if (isset($_POST['verify_email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    $query = "UPDATE registered_users SET is_verified = 1 WHERE email = '$email'";
    
    if (mysqli_query($conn, $query)) {
        if (mysqli_affected_rows($conn) > 0) {
            echo "<div style='color: green; font-weight: bold;'>✅ Email $email has been verified!</div>";
        } else {
            echo "<div style='color: orange;'>⚠️ No account found with email: $email</div>";
        }
    } else {
        echo "<div style='color: red;'>❌ Database error: " . mysqli_error($conn) . "</div>";
    }
}

// Show all unverified accounts
$query = "SELECT email, name, verification_code FROM registered_users WHERE is_verified = 0";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<h3>Unverified Accounts:</h3>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Name</th><th>Email</th><th>Verification Code</th><th>Action</th></tr>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['verification_code']) . "</td>";
        echo "<td>";
        echo "<form method='POST' style='margin: 0;'>";
        echo "<input type='hidden' name='email' value='" . htmlspecialchars($row['email']) . "'>";
        echo "<button type='submit' name='verify_email' style='background: green; color: white; border: none; padding: 5px 10px;'>Verify</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No unverified accounts found.</p>";
}
?>

<hr>
<h3>Manual Verification Form:</h3>
<form method="POST">
    <label for="email">Email to verify:</label><br>
    <input type="email" name="email" required style="width: 300px; padding: 5px;"><br><br>
    <button type="submit" name="verify_email" style="background: blue; color: white; border: none; padding: 10px 20px;">Verify Account</button>
</form>

<hr>
<p><strong>Note:</strong> This is a temporary solution while you fix the email configuration. Once email is working, remove this file for security.</p>
