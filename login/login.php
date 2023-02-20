<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> ProtonTech | Signin/Signup</title>
    <link rel="stylesheet" href="./style.css">
</head>

<?php
require_once '../homeIncludes/dbconfig.php';


//process login
if (isset($_POST['submit'])){
    //check email and password from db
    $email = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);
    $sql = "SELECT * FROM accounts, admin, customer WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          //login successful
        $_SESSION['email'] = $email;
        $_SESSION['logged_id'] = $row['account_id'];
        $_SESSION['user_type'] = $row['user_type'];
        $_SESSION['cust_id'] = $row['cust_id'];
        if($_SESSION['user_type'] == 'customer' ){
          header("Location: ../homepage/home.php");
        }elseif($_SESSION['user_type'] == 'admin' ){
            header("Location: ../admin/dashboard.php");
        }
      }
  }else {
        //login failed
        $error = "Invalid email or password";
    }
}


if (isset($_POST['submit-signup'])){
    //check email and password from db
    $username = htmlentities($_POST['username']);
    $email = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);
    $user_type = htmlentities("customer");
    $sql = "INSERT INTO `accounts`(`username`, `email`, `password`, `user_type`) VALUES ('$username','$email','$password', '$user_type')";
    $result = mysqli_query($conn, $sql);
          //signup successful
        $_SESSION['email'] = $email;
        $_SESSION['logged_id'] = $_POST['account_id'];
          header("Location: ../login/signin.php");
        }else {
        //login failed
        $error = "Invalid email or password";
    }



?>

<body>
    <!-- partial:index.partial.html -->
    <!DOCTYPE html>
    <html>

    <head>
        <title>Slide Navbar</title>
        <link rel="stylesheet" type="text/css" href="../css/login.css">
        <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="main">
            <input type="checkbox" id="chk" aria-hidden="true">

            <div class="signup">
                <form action="login.php" method="POST">
                    <label for="chk" aria-hidden="true">Sign up</label>
                    <input type="text" name="username" placeholder="User name" required="">
                    <input type="email" name="email" placeholder="Email" required="">
                    <input type="password" name="password" placeholder="Password" required="">
                    <button name="submit-signup">Sign In</button>

                </form>
            </div>

            <div class="login">
                <form action="login.php" method="POST">
                    <label for="chk" aria-hidden="true">Login</label>
                    <input type="email" name="email" placeholder="Email" required="">
                    <input type="password" name="password" placeholder="Password" required="">
                    <button name="submit">Log In</button>
                </form>
            </div>
        </div>
    </body>

    </html>
    <!-- partial -->

</body>

</html>