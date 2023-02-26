<?php
session_start();
require_once '../homeIncludes/dbconfig.php';
include_once('../homeIncludes/header.php');


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
?>

<body>
<?php include_once('../homeIncludes/homenav.php');?>
<div class="register-photo">
        <div class="form-container">
            
            <form method="post">
                <h2 class="text-center login-h4"><strong>Sign In</strong><img class="login-img" src="../img/proton-logo.png" alt=""></h2>
                <div class="form-group lgns"><input class="form-control" type="email" name="email" placeholder="Email"></div>
                <div class="form-group lgns"><input class="form-control" type="password" name="password" placeholder="Password"></div>
                <div class="form-group lgns">
                    <div class="form-check"><label class="form-check-label"><input class="form-check-input" type="checkbox">I agree to the license terms.</label></div>
                </div>
                <div class="form-group btn-block"><button class="btn btn-primary btn-block" type="submit">Sign In</button></div><a href="#" class="already">You already have an account? Login here.</a>
            </form>
            <div class="image-holder"></div>
        </div>
    </div>
</body>
</html>
