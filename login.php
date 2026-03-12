<?php
require_once "includes/connection.php";
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $verification_code) // Mail sending function starts
{
  require ("PHPMailer/PHPMailer.php");
  require ("PHPMailer/SMTP.php");
  require ("PHPMailer/Exception.php");

  $mail = new PHPMailer(true);

  try {
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'tempmailforatharva@gmail.com';                     //SMTP username - REPLACE WITH YOUR EMAIL
    $mail->Password   = 'dywgffdlqerubsvp';                               //SMTP password - REPLACE WITH YOUR APP PASSWORD
    
    // For Gmail, use either:
    // Option 1: TLS on port 587 (recommended)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    
    // Option 2: SSL on port 465 (uncomment these and comment above if needed)
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    // $mail->Port       = 465;
    
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;  // Enable debug output

    //Recipients
    $mail->setFrom('tempmailforatharva@gmail.com', 'Taaza Restaurant');  //REPLACE WITH YOUR EMAIL
    $mail->addAddress($email);     //Add a recipient


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Email Verification - Taaza';
    $mail->Body    = "<b style='color:blue'>Thanks for verification !</b><br>
    Click the verify button below to Verify your email address<br>
    <a href='http://localhost/Project-Taaza/verify.php?email=$email&verification_code=$verification_code'>Verify</a>
    <br><p style='color:red'>Enjoy our services, hearty welcome from Taaza</p>
   ";
   // Disable SSL certificate verification, because error occured for me
   $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
      );


    $mail->send();
    return true;
} catch (Exception $e) {
    // Log the error for debugging (you can also write to a log file)
    error_log("PHPMailer Error: " . $mail->ErrorInfo);
    echo "<div style='color: red; font-weight: bold;'>❌ Email could not be sent. Mailer Error: " . $mail->ErrorInfo . "</div>";
    echo "<div style='color: red;'>Exception: " . $e->getMessage() . "</div>";
    error_log("Exception: " . $e->getMessage());
    
    // Add specific help for authentication errors
    if (strpos($mail->ErrorInfo, 'Could not authenticate') !== false) {
        echo "<div style='color: orange; padding: 10px; border: 1px solid orange; margin: 10px 0;'>";
        echo "<strong>Authentication Error - Possible Solutions:</strong><br>";
        echo "1. Make sure you're using a Gmail App Password, not your regular password<br>";
        echo "2. Enable 2-Factor Authentication on your Gmail account<br>";
        echo "3. Visit the link in the error message to sign in via browser<br>";
        echo "4. Try generating a new App Password<br>";
        echo "</div>";
    }
    
    return false;
}
} // Mail sending function ends

if(isset($_POST['register']))
{
  // Check if passwords match
  if($_POST['password'] !== $_POST['confirm-password']) {
    echo"
    <script>alert('Passwords do not match! Please try again.');
    window.location.href='login.php';
    </script>
    ";
    exit;
  }

  // Sanitize inputs to prevent SQL injection
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $fullname = mysqli_real_escape_string($conn, $_POST['full-name']);
  $gender = mysqli_real_escape_string($conn, $_POST['gender']);
  $state = mysqli_real_escape_string($conn, $_POST['state']);
  $district = mysqli_real_escape_string($conn, $_POST['district']);

  $user_exist_query="SELECT * FROM registered_users WHERE `email`='$email'";

  $result=mysqli_query($conn, $user_exist_query);

  if($result)
  {
    if(mysqli_num_rows($result)>0)
    {
      $result_fetch=mysqli_fetch_assoc($result);
      if($result_fetch['email']==$email)
      {
        echo"
        <script>
        alert('Email already registered');
        window.location.href='login.php';
        </script>
        ";
      }
    }
    else
    {
     $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
     $verification_code=bin2hex(random_bytes(16));
$query = "INSERT INTO `registered_users` (`name`, `email`, `password`, `gender`, `state`, `district`, `verification_code`, `is_verified`) VALUES ('$fullname','$email','$password','$gender','$state','$district', '$verification_code', '0')";

      // First, try to save to database
      if(mysqli_query($conn, $query)) 
      {
        // Database save successful, now try to send email
        $sentMail = sendMail($email, $verification_code);
        if($sentMail) 
        {
          echo"
            <script>alert('Registration successful! Check your email for verification');
            window.location.href='new-login.php';
            </script>
            ";
        }
        else
        {
          echo"
            <script>alert('Registration successful! However, verification email could not be sent. Please contact support or manually verify your account. Check browser console for email debug info.');
            </script>
            ";
            // window.location.href='new-login.php';
        }
      }
      else
      {
        echo"
        <script>alert('Registration failed: Database error - " . mysqli_error($conn) . "');
        window.location.href='login.php';
        </script>
        ";
      }
    }
  }
  else
  {
    echo"
    <script>alert('UNKNOWN ISSUE: cannot run your request');
    window.location.href='login.php';
    </script>alert
    ";
  }
}
?>


<?php require "includes/header.php"; ?>

      <section class="home" id="home">
        <div class="home-left">
          <div class="container">
              <div class="form-container">
                <div class="form-title"><b>Register</b></div>
                <form action="#" method="POST">
                  <!-- Login Information -->
                  <div class="form-section">

                    <div class="form-field">
                      <label for="full-name">FULL NAME</label>
                      <input type="text" id="full-name" name="full-name" required>
                    </div>

                    <div class="form-field">
                      <label for="email">EMAIL</label>
                      <input type="email" id="email" name="email" required>
                    </div>
                                       
                    <div class="form-field">
                      <label for="password">PASSWORD</label>
                      <input type="password" id="password" name="password" required>
                    </div>

                    <div class="form-field">
                      <label for="gender">Gender</label>
                      <select id="gender" name="gender" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="prefer-not-to-say">Prefer not to say</option>
                      </select>
                    </div>

                  </div>

                  <div class="form-section">                                       
                  </div>

                  <div class="form-section">

                    <div class="form-field">
                      <label for="state">STATE</label>
                      <input type="text" id="state" name="state" required>
                    </div>

                    <div class="form-field">
                      <label for="district">DISTRICT</label>
                      <input type="text" id="district" name="district" required>
                    </div>
                                       
                  </div>
                  <div class="form-field">
                      <label for="confirm-password">CONFIRM YOUR PASSWORD</label>
                      <input type="password" id="confirm-password" name="confirm-password" required>
                    </div>

                  <button type="submit" name="register" class="login-btn">Register</button>
                </form>
                <br><center>
                <div class="form-question"><h3>Already Registered? <u><a href="new-login.php" style="display: inline; color: #216aca;" onmouseover="this.style.color='#03d9ff'" onmouseout="this.style.color='#216aca'">Login Here</h3></a></u></div>
              </center>
              </div>
            </div>
        </div>

        <div class="home-right" style="margin-top: 1cm;">

          <img src="./assets/images/food1.png" alt="food image" class="food-img food-1" width="200" loading="lazy">
          <img src="./assets/images/food2.png" alt="food image" class="food-img food-2" width="200" loading="lazy">
          <img src="./assets/images/food3.png" alt="food image" class="food-img food-3" width="200" loading="lazy">

          <img src="./assets/images/dialog-1.svg" alt="dialog" class="dialog dialog-1" width="230">
          <img src="./assets/images/dialog-2.svg" alt="dialog" class="dialog dialog-2" width="230">

          <img src="./assets/images/circle.svg" alt="circle shape" class="shape shape-1" width="25">
          <img src="./assets/images/circle.svg" alt="circle shape" class="shape shape-2" width="15">
          <img src="./assets/images/circle.svg" alt="circle shape" class="shape shape-3" width="30">
          <img src="./assets/images/ring.svg" alt="ring shape" class="shape shape-4" width="60">
          <img src="./assets/images/ring.svg" alt="ring shape" class="shape shape-5" width="40">

        </div>
      </section>
</header>

<!-- Password Complexity Check -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const isValid = passwordPattern.test(password);

        if (!isValid) {
            this.setCustomValidity('Password must contain at least 8 characters, including at least one uppercase letter, one lowercase letter, one number, and one special character.');
        } else {
            this.setCustomValidity('');
        }
    });
});
</script>
<br><br><br><br>

<?php require "includes/footer.php"; ?>
