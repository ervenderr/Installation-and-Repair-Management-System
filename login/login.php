<?php
session_start();
require_once '../homeIncludes/dbconfig.php';
require_once '../tools/variables.php';
$page_title = 'ProtonTech | Log In';
include_once('../homeIncludes/header.php');

// initialize variables
$email = '';
$password = '';
$errors = array();

// process login
if (isset($_POST['submit'])) {
    // get email and password
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // validate form inputs
    if (empty($email)) {
        $errors[] = "Email is required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

// if no errors, log in user
if (count($errors) == 0) {
    $stmt = $conn->prepare("SELECT * FROM accounts
    WHERE email=? AND password=? LIMIT 1");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // login successful
        while ($row = $result->fetch_assoc()) {
            if ($row['user_type'] == 'customer' && $row['verify_status'] == "1") {
                $_SESSION['logged_id'] = $row['account_id'];
                $_SESSION['user_type'] = $row['user_type'];
                header("Location: ../homepage/home.php");
            } elseif ($row['user_type'] == 'admin') {
                // unset($_SESSION['cust_id']);
                header("Location: ../admin/dashboard.php");
            }elseif ($row['user_type'] == 'customer' && $row['verify_status'] != "1") {
                $errors[] = "Email is not Verified";
            }
        }
    } else {
        // add error message
        $errors[] = "Incorrect email or password";
    }
    $stmt->close();
    }

    // display errors
    foreach ($errors as $error) {
        echo "<span class='text-danger'>$error</span>";
    }

    }
?>

<body>
    <?php include_once('../homeIncludes/homenav.php');?>
    <div class="register-photo">

        <?php
            if (isset($_SESSION['msg'])) {
                $msg = $_SESSION['msg'];
                echo '<div class="alert alert-success alert-dismissible fade show login-alert" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                '. $msg .'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
              unset($_SESSION['msg']);
            }
        ?>

        <div class="form-container">
            <form method="post" action="login.php">
                <?php
                    if (isset($_SESSION['signup_success']) && $_SESSION['signup_success']) {
                        echo '<div id="alert" class="alert alert-success alert-dismissible fade show text-center" role="alert">
                            "Sign up successful! Please log in."
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                        $_SESSION['signup_success'] = false;
                    }
                ?>

                <h2 class="text-center login-h4"><strong>Sign In Now</strong><img class="login-img"
                        src="../img/proton-logo.png" alt=""></h2>
                <div class="form-group lgns">
                    <input class="form-control" type="email" name="email" placeholder="Email"
                        value="<?php echo $email; ?>">
                    <span
                        class="val-error"><?php if (in_array("Email is required", $errors)) echo "<span class='text-danger'>Email is required</span>"; 
                                elseif (in_array("Invalid email format", $errors)) echo "<span class='text-danger'>Invalid email format</span>"; 
                                elseif (in_array("Incorrect email or password", $errors)) echo "<span class='text-danger'>Incorrect email or password</span>";
                                elseif (in_array("Email is not Verified", $errors)) echo "<span class='text-danger'>Email is not verified</span>"; ?>
                    </span>
                </div>

                <div class="form-group lgns">
                    <input class="form-control" type="password" name="password" placeholder="Password"
                        value="<?php echo $password; ?>">
                    <span
                        class="val-error"><?php if (in_array("Password is required", $errors)) echo "<span class='text-danger'>Password is required</span>"; 
                            elseif (in_array("Incorrect email or password", $errors)) echo "<span class='text-danger'>Incorrect email or password</span>";?></span>
                </div>


                <div class="form-group lgns">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox">Remember password.
                        </label>
                    </div>
                </div>
                <div class="form-group btn-block">
                    <button class="btn btn-primary btn-block" name="submit" type="submit">Sign In</button>
                </div>
                <a href="../login/signup.php" class="already">Don't have an account? Sign up here.</a>
            </form>
            <div class="image-holder"></div>
        </div>
    </div>

    <script>
    // Set a timer to hide the alert after 3 seconds
    const alert = document.querySelector("#alert");
    if (alert) {
        setTimeout(() => {
            alert.style.display = "none";
        }, 2000);
    }
    </script>
</body>


</html>