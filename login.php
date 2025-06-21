<?php

// Check if the system setup is complete

require_once 'society-management-system/config.php';

if (isset($_SESSION['user_id'])) {
    header('Location: society-management-system/user_dashboard.php');
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
                    header('Location: society-management-system/user_dashboard.php');
                } else {
                    header('Location: society-management-system/dashboard.php');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">    

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Marcellus&display=swap" rel="stylesheet">
</head>
<style>

*{
    box-sizing: border-box;
    margin: 0;
    font-family: "Marcellus", sans-serif;
    padding: 0;
}
.topnav {
    background-color: #4C0033;
    overflow: hidden;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
    height: 50px;
}

.topnav h3.logo {
    float: left!important;
    margin-top: 0.5pc;
    margin-left: 1pc;
    color: #283142;
    font-weight: 500;
    font-size: 20px;
    color: white; 
    margin-top: 12px;
    text-transform: uppercase;
    font-weight: bold;
}

.topnav a {
    float: right!important;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 20px;
    cursor: pointer;
    color: #283142;
    font-weight: 500;
       
}

.topnav a.active {
    background-color: #F5C6EC;
    color: #4C0033;
    cursor: pointer;
    margin-top: -4px;
    font-weight: bold;
}

.topnav a:hover {
    background-color: #4C0033;
    color: #F5C6EC;
    cursor: pointer;
} 

body{
    background: #FFF8DC;
    /* display: flex;
    justify-content: center;
    align-items: center; */
    /* height:100vh; */
    font-family: sans-serif;
    /* background: url('img/bg.jpg');
    background-size: cover; */
}
center{
    width:80%;
    margin: 130px auto;
}
.container{
    width: 90%;
    margin: auto;
    padding: 20px;
  height:100%;
  
}
.login ,.register{
    width: 50%;
}

/*Start Login Style*/
.login{
    float:left;
    background-color: #fafafa;
    height: 100%;
    border-radius: 10px 0 0 10px;
    text-align: center;
    padding-top: 100px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}
.login h1{
    margin-bottom: 40px;
    font-size: 2.5em;
}

input[type="email"] , input[type="password"]{
    width: 100%;
    padding: 10px;
    margin-bottom: 30px;
    border: none;
    background-color: #eeeeef;
}
input[type="checkbox"]{
    float: left;
    margin-right: 5px;
}
.login span{
    float: left
}
.login a{
    float: right;
    text-decoration: none;
    color: #000;
    transition: 0.3s all ease-in-out;
}
.login a:hover{color: #9526a9;font-weight: bold}
.login button{
    width: 100%;
    margin: 30px 0;
    padding: 10px;
    border: none;
    background-color: #4C0033;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    transition: 0.3s all ease-in-out;
}
.login button:hover{
    width:97%;
    font-size: 22px;
    border-radius: 5px;
    background-color: #430A5D;
    
}
.login hr{
    width: 30%;
    display: inline-block
}

.login p{
    display: inline-block;
    margin: 0px 10px 30px;
}
.login ul{
    list-style: none;
    margin-bottom:40px;  
}
.login ul li{
    display: inline-block;
    margin-right: 30px;
    cursor: pointer;
}
.login ul li:hover{opacity: 0.6}
.login ul li:last-child{margin-right: 0}
.login .copyright{
    display: inline-block;
    float: none;
}
/*Start Register Style*/
.register{
    float: right;
    /* background-image: linear-gradient(135deg, #F7DBF0 5%, #c27bc1 95%); */
    background-color: #FFD0EC;
    height: 100%;
    color:#000000;
    border-radius:  0 10px 10px  0;
    text-align: center;
    padding: 100px 0;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}
.register h2{
    margin: 8px auto;
    font-size: 40px;
    letter-spacing: 3px;
}
.register p{
    font-size: 18px;
    margin-bottom: 30px;
}
#mobileform{
        display: none;
    }
@media (min-width: 250px) and (max-width: 768px) {
    center{
        width: 100%;
    }
    .register{
        display: none;
    }
    .login{
        display: none;
    }
    #mobileform{
        display: block;
        box-shadow: 1px 1px 335px -80px rgba(0,0,0,0.75);
-webkit-box-shadow: 1px 1px 335px -80px rgba(0,0,0,0.75);
-moz-box-shadow: 1px 1px 335px -80px rgba(0,0,0,0.75);
background: #fafafa;
border: 2px #4C0033 solid;
        padding: 2rem;
        margin: 10px 10px 10px 10px;
        border-radius: 10px;
    }
    .btn{
        display: block;
        margin-top: 10%;
        background: #430033;
    border: none;
    width: 60%;
    }
    .topnav h3.logo {
    float: left!important;
    margin-top: 0.5pc;
    margin-left: 1pc;
    color: #283142;
    font-weight: 500;
    font-size: 16px;
    color: white; 
    margin-top: 15px;
    text-transform: uppercase;
    font-weight: bold;
}

.topnav a {
    float: right!important;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 16px;
    cursor: pointer;
    color: #283142;
    font-weight: 500;
       
}

.topnav a.active {
    background-color: #F5C6EC;
    color: #4C0033;
    cursor: pointer;
    margin-top: -3px;
    font-weight: bold;
}
input[type="email"], input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 30px;
    border: 1px black solid;
    background-color: #eeeeef;
    border-radius: 10px;
}
}

</style>

<body>
<div class="topnav">
<h3 class="logo">Moraj Residency</h1> 
<a class="active" href="index.php" style="cursor: pointer;">Home</a>
  <!-- <a href="#">Register</a> -->
</div>        <center>

                    <?php

if (isset($errors)) {
    foreach ($errors as $error) {
        echo "<div class='alert alert-danger'>$error</div>";
    }
}
?>
<form id="mobileform" method="POST">

<i class="fas fa-user-plus fa-2x"></i>
              <p><h6 style="font-weight:bold;">Welcome to Moraj Residency</h6></p>
              <p style="font-style: italic;">" A house is made of bricks and beams, but a home is made of hopes and dreams."</p>

<h1 style="font-weight: bold; text-transform: uppercase;">Login</h1>
              <label for="email" style="float: left;"><b>Email</b></label>
              <input type="email" placeholder="Enter Username" id="email" name="email" required>
              <div class="invalid-feedback">Please enter a valid email address.</div>

              <label for="psw" style="float: left;"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="password" id="password" required />
              <!-- <i class="fa-solid fa-eye-slash" id="togglePassword"></i> -->
              <div class="invalid-feedback">Please enter a password.</div>
              <!-- <span class="psw"><a href="#">Forgot Password?</a></span> -->

              <button type="submit" name="btn_login" class="btn btn-primary">Login</button>
              
</form>
<form id= "login-form" method="post">

      <div class="login">
         <div class="container">
              <h1 style="font-weight: bold; text-transform: uppercase;">Login</h1>
              <label for="email" style="float: left;"><b>Email</b></label>
              <input type="email" placeholder="Enter Username" id="email" name="email" required>
              <div class="invalid-feedback">Please enter a valid email address.</div>

              <label for="psw" style="float: left;"><b>Password</b></label>
              <input type="password" placeholder="Enter Password" name="password" id="password" required />
              <!-- <i class="fa-solid fa-eye-slash" id="togglePassword"></i> -->
              <div class="invalid-feedback">Please enter a password.</div>
              <!-- <span class="psw"><a href="#">Forgot Password?</a></span> -->

              <button type="submit" name="btn_login" class="btn btn-primary">Login</button>
              
         </div>
      </div>
      <div class="register">
          <div class="container">
              <i class="fas fa-user-plus fa-4x"></i>
              <h2>Hello,User!</h2>
              <p><h4 style="font-weight:bold;">Welcome to Moraj Residency</h4></p>
              <p style="font-style: italic;">" A house is made of bricks and beams, but a home is made of hopes and dreams."</p>
              <!-- <button>Register <i class="fas fa-arrow-circle-right"></i></button> -->
          </div>
      </div>  
    </div>


</form>

</center>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- 
        <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            
            // toggle the icon
            this.classList.toggle("fa-eye");
        });

        // prevent form submit
        const form = document.querySelector("login-form");
        form.addEventListener('submit', function (e) {
            e.preventDefault();
        });
    </script> -->

    </body>

</html>
