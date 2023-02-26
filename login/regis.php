<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Untitled</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
      .register-photo {
  background:#f1f7fc;
  padding:80px 0;
}

.register-photo .image-holder {
  display:table-cell;
  width:auto;
  background:url(../img/qq.jpg);
  background-size:cover;
}

.register-photo .form-container {
  display:table;
  max-width:900px;
  width:90%;
  margin:0 auto;
  box-shadow:1px 1px 5px rgba(0,0,0,0.1);
}

.register-photo form {
  display:table-cell;
  width:400px;
  background-color:#ffffff;
  padding:40px 60px;
  color:#505e6c;
}

@media (max-width:991px) {
  .register-photo form {
    padding:40px;
  }
}

.register-photo form h2 {
  font-size:24px;
  line-height:1.5;
  margin-bottom:30px;
}

.register-photo form .form-control {
  background:#f7f9fc;
  border:none;
  border-bottom:1px solid #dfe7f1;
  border-radius:0;
  box-shadow:none;
  outline:none;
  color:inherit;
  text-indent:6px;
  height:40px;
}

.register-photo form .form-check {
  font-size:13px;
  line-height:20px;
}

.register-photo form .btn-primary {
  background:#015F6B;
  border:none;
  border-radius:4px;
  padding:11px;
  box-shadow:none;
  margin-top:35px;
  text-shadow:none;
  outline:none !important;
}

.register-photo form .btn-primary:hover, .register-photo form .btn-primary:active {
  background:#015F6B;
}

.register-photo form .btn-primary:active {
  transform:translateY(1px);
}

.register-photo form .already {
  display:block;
  text-align:center;
  font-size:12px;
  color:#015F6B;
  opacity:0.9;
  text-decoration:none;
}


    </style>
</head>

<body>
    <div class="register-photo">
        <div class="form-container">
            <div class="image-holder"></div>
            <form method="post">
                <h2 class="text-center"><strong>Create</strong> an account.</h2>
                <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email"></div>
                <div class="form-group"><input class="form-control" type="password" name="password" placeholder="Password"></div>
                <div class="form-group"><input class="form-control" type="password" name="password-repeat" placeholder="Password (repeat)"></div>
                <div class="form-group">
                    <div class="form-check"><label class="form-check-label"><input class="form-check-input" type="checkbox">Remember me.</label></div>
                </div>
                <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Sign Up</button></div><a href="#" class="already">You already have an account? Login here.</a></form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>