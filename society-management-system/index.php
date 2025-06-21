<?php

// Check if the system setup is complete

require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

$errorMessage = '';

if (isset($_POST['btn_login'])) {
    // Get the email and password entered by the user
    $email = $_POST['email'];

    $password = $_POST['password'];

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email address format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    // Validate password field is not empty
    if (empty($password)) {
        $errors[] = 'Please enter a password.';
    }

    // If there are no validation errors, attempt to log in
    if (empty($errors)) {

        // Query the database to see if a user with that username exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // If the user exists, retrieve their password hash from the database
        if ($user) {
            $passwordHash = $user['password'];

            // Use the password_verify function to check if the entered password matches the password hash
            if (password_verify($password, $passwordHash)) {
                // Password is correct, log the user in
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_name'] = $user['name'];
                if ($user['role'] == 'user') {
                    header('Location: user_dashboard.php');
                } else {
                    header('Location: dashboard.php');
                }
                exit;
            } else {
                // Password is incorrect, show an error message
                $errors[] = "Invalid password";
            }
        } else {
            // User not found, show an error message
            $errors[] = "email not found in database";
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Moraj Residency</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">

    <!-- Load Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Marcellus&display=swap" rel="stylesheet">
</head>
<style>
    *{
        font-family: "Marcellus", sans-serif;
    }

 body {
  background-color: #f2f2f2;
  justify-content: center;
  align-items: center;

  /* margin: 100px auto; */
  
  background: linear-gradient(
      rgba(0, 83, 108, 0.634),
      rgba(255, 255, 255, 0.336)
    ),
    url("/img/homecity.png");
    background-repeat: no-repeat;
background-position: center center;
background-attachment: fixed;
background-size: cover;
}

form {
    background-color: white;
    width: 60%;
    padding: 2pc;
    margin: 50px auto;
}

input[type=email], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

.btn{
  background-color: #475c84;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  font-weight:bold;
  cursor: pointer;
  width: 100%;
}

.btn:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 18%;
  border-radius: 50%;
}

.container {
  padding: 2pc;
}

span.psw {
  float: right;
  padding-top: 16px;
  text-decoration: none;
  color: blue;
}
span.psw a{
    text-decoration: none;

}
.topnav {
  overflow: hidden;
  background-color: #000;
}

.topnav a {
  float: left;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
  cursor: pointer;
}

.topnav a:hover {
  background-color: #475c84;
  color: white;
  cursor: pointer;
}
/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
  img.avatar {
  width: 50%;
  border-radius: 50%;
}

}
@media (min-width: 300px) and (max-width: 650px)  {
    form {
    background-color: white;
    width: 80%;
    padding: 0.1pc;
}

input[type=email], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

.btn{
  background-color: #475c84;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  font-weight:bold;
  cursor: pointer;
  width: 100%;
}

.btn:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  /* margin: 24px 0 12px 0; */
  margin: 30px auto;
}

img.avatar {
  width: 30%;
  border-radius: 50%;
}

.container {
  padding: 2pc;
}

span.psw {
  float: right;
  padding-top: 16px;
  text-decoration: none;
  color: blue;
}
span.psw a{
    text-decoration: none;

}
}

</style>

<body>
<div class="topnav">
  <a class="active" onclick="history.back()" style="cursor: pounter;">Home</a>
  <!-- <a href="#">Register</a> -->

</div>        <center>

                    <?php

if (isset($errors)) {
    foreach ($errors as $error) {
        echo "<div class='alert alert-danger'>$error</div>";
    }
}
?>

<form id="login-form" method="post">
  <div class="imgcontainer">
    <img src="/img/loginuser.jpg" alt="Avatar" class="avatar">
    <h6 class="text-center" style="color:#475c84; font-weight:bolder;">LOGIN</h6> 
  </div>

  <div class="container">
    <label for="email" style="float: left;"><b>Email</b></label>
    <input type="email" placeholder="Enter Username" id="email" name="email" required>
    <div class="invalid-feedback">Please enter a valid email address.</div>

    <label for="psw" style="float: left;"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" id="password" required>
    <div class="invalid-feedback">Please enter a password.</div>
    <span class="psw"><a href="#">Forgot Password?</a></span>

    <button type="submit" name="btn_login" class="btn btn-primary">Login</button>

</form>

                    <!-- <div class="card">
                        
                        <div class="card-body">
                            <form id="login-form" method="post">
                                <div class="mb-3">
                                    <label for="email" class="form-label"
                                        style="font-size:1.2rem;color:#000; float: left;">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label"
                                        style="font-size:1.2rem;color:#000; float: left;">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    <div class="invalid-feedback">Please enter a password.</div>
                                </div>
                                <button type="submit" name="btn_login" class="btn btn-primary"
                                    style="width:100px; background-color: #9b2928 !important;border-color: #9b2928!important;">Login</button>
                            </form>
                        </div> -->

                    

                    <!-- </div>
                </div> -->
            <!-- </div>

        </div> -->
</center>

<!-- 
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
        <!-- Load Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

<script>
// $(document).ready(function() {
// Disable HTML5 validation
/*$('#login-form').attr('novalidate', 'novalidate');

  // Validate form input on submit
  $('#login-form').on('submit', function(e) {
    // Prevent form submission
    e.preventDefault();

    // Remove any existing error messages
    $('#email').removeClass('is-invalid');
    $('#password').removeClass('is-invalid');
    $('.invalid-feedback').hide();

    // Get form input values
    var email = $('#email').val().trim();
    var password = $('#password').val().trim();

    // Validate email address format
    if (!isValidEmail(email)) {
      $('#email').addClass('is-invalid');
      $('#email').next('.invalid-feedback').show();
      return;
    }

    // Validate password field is not empty
    if (password === '') {
      $('#password').addClass('is-invalid');
      $('#password').next('.invalid-feedback').show();
      return;
    }

    // Submit form if input is valid
    this.submit();
  });
});

// Function to validate email address format
function isValidEmail(email) {
  var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
  return emailRegex.test(email);
}*/
</script>