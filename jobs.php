<?php

    session_start();
    $msg = "";
    if(isset($_SESSION['msg'])){
        $msg = $_SESSION['msg'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
    <title>Multistep Form</title>
</head>
<body onload="showTab(current);hideMsg();">
<?php

    if($msg == "done"){
    echo "<div id='msg' class='msg'>
            <p>You have registered successfully!</p>
          </div>";
    }

?>
    <div id="container" class="container">
        <form id="regForm" method="post" action="process.php">
            <ul id="progressbar">
                <li class="active" id="account">Account Details</li>
                <li id="personal">Personal Details</li>
                <li id="contact">Contact Details</li>
            </ul>
            <div class="tab">
                <input type="text" name="uname" placeholder="Enter Username" oninput="this.className=''">
                <input type="password" name="pass1" placeholder="Enter Password" oninput="this.className=''">
                <input type="password" name="pass2" placeholder="Confirm Password" oninput="this.className=''">
            </div>
            <div class="tab">
                <input type="text" name="fname" placeholder="Enter First Name" oninput="this.className=''">
                <input type="text" name="lname" placeholder="Enter Last Name" oninput="this.className=''">
                <input type="date" name="dob" placeholder="Enter Date of Birth" oninput="this.className=''">
            </div>
            <div class="tab">
                <input type="text" name="addr" placeholder="Enter Address" oninput="this.className=''">
                <input type="email" name="email" placeholder="Enter Email" oninput="this.className=''">
                <input type="text" name="mob" placeholder="Enter Mobile" oninput="this.className=''">
            </div>
            <div style="overflow: hidden;">
                <div style="float: right;">
                    <button onclick="nextPrev(-1);" type="button" id="prev">Previous</button>
                    <button onclick="nextPrev(1);" type="button" id="next">Next</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>