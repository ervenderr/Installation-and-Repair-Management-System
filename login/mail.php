<?php
ob_start();
require_once '../homeIncludes/dbconfig.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

function sendEmail_verify($fname, $email, $verify_token){

    $mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = 'smtp.gmail.com';
    $mail->Username = 'ervenfailed@gmail.com';
    $mail->Password = 'kpzfylxmigejjlny';

    $mail->SMTPSecure = "ssl";
    $mail->Port = 465;

    $mail->setFrom('ervenfailed@gmail.com', 'ProtonTech');
    $mail->addAddress($email, $fname);

    $mail->isHTML(true);
    $mail->Subject = 'Email verification from Proton Electronics and Services';

    // Email Template
    $email_template = "
        <html>
        <head>
            <style>
                .container {
                    margin: 20px;
                    padding: 20px;
                    background-color: #F7F7F7;
                    font-family: Arial, Helvetica, sans-serif;
                }
                .header {
                    font-size: 24px;
                    font-weight: bold;
                    color: #333333;
                    margin-bottom: 10px;
                }
                .message {
                    font-size: 16px;
                    color: #666666;
                    margin-bottom: 20px;
                }
                .button {
                    display: inline-block;
                    background-color: #015F6B !important;
                    color: #ffffff;
                    text-decoration: none;
                    padding: 10px 20px;
                    border-radius: 5px;
                }
                .button:hover {
                    background-color: #015F6B;
                    color: #ffffff;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>Welcome to Proton Electronics and Services</div>
				<p class=''>Thank you for registering an account on <a href='http://proton-tech.online/'>ProtonTech.<a/> 
					Before you can access other features, please click the following link to verify your email:</p>
					<br>
					<br>
					<p class=''>http://proton-tech.online/login/verify-email.php?verify_email=$verify_token 
					.Before you can access other features, please click the following link to verify your email:</p>
            </div>
        </body>
    </html>
    ";

    $mail->Body = $email_template;
    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Get the form data and sanitize it
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $verify_token = md5(rand());
    $usertype = 'customer';
    $cust_type = 'online';

    // Verify the reCAPTCHA
    $secretkey = "6LckLd4kAAAAAJyeMoi-eP6s4qaD82K-1m3XURGA";
    $ip = $_SERVER['REMOTE_ADDR'];
    $response = $_POST['g-recaptcha-response'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$response&remoteip=$ip";
    $fire = file_get_contents($url);
    $data = json_decode($fire);

    if($data->success==false){
        // reCAPTCHA verification failed
        $_SESSION['msg'] = "Please verify that you are not a robot";
        header("Location: signup.php");
        exit();
    }

    // Check if the email already exists
    $checkEmail = "SELECT email FROM accounts WHERE email='$email' LIMIT 1";
    $checkEmailRun = mysqli_query($conn, $checkEmail);

    if(mysqli_num_rows($checkEmailRun) > 0){
        $_SESSION['msg'] = "Email already exists";
        header("Location: signup.php");
        exit();
    }

    // Prepare and execute the first SQL statement to insert email, password, and user type into the accounts table
    $stmt = mysqli_prepare($conn, "INSERT INTO accounts (email, password, user_type, verify_token) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $email, $password, $usertype, $verify_token);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Get the ID of the newly inserted account
    $account_id = mysqli_insert_id($conn);

    // Prepare and execute the second SQL statement to insert the rest of the data into the customer table
    $stmt = mysqli_prepare($conn, "INSERT INTO customer (account_id, fname, mname, lname, phone, address, cust_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "issssss", $account_id, $fname, $mname, $lname, $phone, $address, $cust_type);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if($stmt){
		// Registration successful
        sendEmail_verify("$fname", "$email", "$verify_token");
		$_SESSION['msg'] = "Sign up successful! Please log in.";
        $_SESSION['msg'] = "Registration successful. Check your email to confirm your registration";
        $_SESSION['signup_success'] = true;
        header("Location: login.php");
        exit();
    }else{
        // Registration failed
        $_SESSION['msg'] = "Registration failed";
        header("Location: signup.php");
        exit();
    }
}

?>