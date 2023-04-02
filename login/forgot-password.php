
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php'; // Assuming you have installed PHPMailer via Composer

// initialize variables
$email = '';
$errors = array();

// process forgot password request
if (isset($_POST['email'])) {
    // get email
    $email = $_POST['email'];

    // TODO: Validate the email address

    // Generate a unique token for the password reset link
    $token = bin2hex(random_bytes(32));

    // TODO: Store the token and email in a database or a file

    // Send the password reset email using PHPMailer
    $mail = new PHPMailer(true); // true enables exceptions

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output (set to 2 for more detailed output)
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = '@gmail.com'; // SMTP username
        $mail->Password = 'qhpxvcziymazcypi'; // SMTP password
        $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465; // TCP port to connect to

        //Recipients
        $mail->setFrom('@gmail.com', 'ProtonTech');
        $mail->addAddress($email); // Add a recipient
        $mail->addReplyTo('robin.almorfi2002@gmail.com', 'ProtonTech');

        //Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Password Reset';
        $mail->Body = "Click the following link to reset your password:\n\n";
        $mail->Body .= "http://proton-tech.online/reset-password.php?email=$email&token=$token";

        $mail->send();
        // Redirect the user to a confirmation page
        header('Location: reset-link-sent.php');
        exit();
    } catch (Exception $e) {
        // Display an error message
        $errors[] = "An error occurred while sending the email: " . $mail->ErrorInfo;
    }
}
?>

<!-- Display the forgot password form -->
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h1>Forgot Password</h1>
    <?php foreach ($errors as $error): ?>
        <p><?php echo $error; ?></p>
    <?php endforeach; ?>
    <form action="forgot-password.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
