<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/script.js" defer></script>
    <link rel="stylesheet" href="../css/login.css" />
    
    <title>
        <?php echo $page_title; ?>
    </title>
</head>

<?php
require_once '../homeIncludes/dbconfig.php';


//process login
if (isset($_POST['submit'])){
    //check email and password from db
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM accounts, customer WHERE email='$email' AND password='$password' AND customer.account_id=accounts.account_id AND user_type='customer'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)) {
          //login successful
        $_SESSION['email'] = $email;
        $_SESSION['logged_id'] = $row['account_id'];
        $_SESSION['user_type'] = $row['user_type'];
        if($_SESSION['user_type'] == 'customer' ){
          header("Location: ../homepage/home.php");
        }
      }
  }else {
        //login failed
        $error = "Invalid email or password";
    }
}
?>


<body>
  
  <div class="wrapper">
    <h2>Log in</h2>
    
    <form action="login.php" method="POST">
      <div class="input-box">
        <input type="email" placeholder="Enter your email" name="email" required>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Create password" name="password" required>
      </div>
      <div class="policy">
        <input type="checkbox">
        <h3>Remember me</h3>
      </div>
      <div class="input-box button">
        <input type="Submit" value="LOG IN" name="submit">
      </div>
      <div class="text">
        <h3>Don't have an account? <a href="#">Register now</a></h3>
      </div>
    </form>
  </div>
</body>
</html>