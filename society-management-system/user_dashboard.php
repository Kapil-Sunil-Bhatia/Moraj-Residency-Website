<?php

require_once 'config.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="/img/favicon.png">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Marcellus&display=swap" rel="stylesheet">

</head>

<style>
* {
    font-family: "Marcellus", sans-serif;
}

body {
    margin: 0;
    padding: 0;
    background-color: #FFF8DC;
    index: 12;
}

.topnav {
    overflow: hidden;
    background-color: #4C0033;
}

.topnav a {
    float: left;
    display: block;
    color: #fff;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
}

.topnav a:hover {
    background-color: #ddd;
    color: black;
}

.topnav .icon {
    display: none;
}

#settings {
    float: right;
    overflow: hidden;

}

h3 {
    margin-top: 5pc;
}

#settings .dropbtn {
    font-size: 16px;
    border: none;
    outline: none;
    color: white;
    padding: 14px 16px;
    background-color: inherit;
    font-family: inherit;
    margin: 0;
    top: 1rem;
}

#settings:hover {
    align: right;
}

.dropdown-menu {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.dropdown-menu a {
    float: none;
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-menu a:hover {
    background-color: #ddd;
}

.dropdown:hover .dropdown-menu {
    display: block;
}

.col {
    padding: 4pc;
    background: white;
    border: 2px black solid;
}

#userbtn {
    width: 40%;
    display: block;
    margin: 20px;
    padding: 1pc;
    font-size: large;
    background-color: #4C0033;
    color: #fff;
    transition: 0.3s all ease-in-out;
    border: none;
}

#userbtn:hover {
    background-color: #430A5D;
    color: #fff;
    width: 43%;
    font-size: larger;

}

@media screen and (max-width: 600px) {
    .topnav a:not(:first-child) {
        display: none;
    }

    .topnav a.icon {
        float: right;
        display: block;
    }
}

@media screen and (max-width: 600px) {
    .topnav.responsive {
        position: relative;
    }

    .topnav.responsive .icon {
        position: absolute;
        right: 0;
        top: 0;
    }

    .topnav.responsive a {
        float: none;
        display: block;
        text-align: left;
    }
}

@media (min-width: 300px) and (max-width: 370px) {
    #userbtn {
        width: 70%;
        display: block;
        margin: 20px;
        padding: 1pc;
        font-size: large;
        background-color: #283142;
        border: none;
    }

    #userbtn:hover {
        background-color: #3f69b9;

    }
}
</style>

<body>
    <div class="topnav" id="myTopnav">
        <a class="navbar-brand ps-3" href="#"><i class="fa-solid fa-building"></i> Moraj Residency</a>
        <!-- <div class="dropdown" id="settings">
    <button class="dropbtn"><i class="fa-solid fa-gear"></i> 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content hover-right">
      <a href="#">Link 1</a>
      <a href="#">Link 2</a>
      <a href="#">Link 3</a>
    </div>
  </div>  -->
        <div class="dropdown-right" style="float:right; margin-top: 0.5pc;" id="settings">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false" style="background: #4C0033; border:none;">
                <i class="fa-solid fa-gear"></i>
            </button>
            <ul class="dropdown-menu">
                <li> <a class="nav-link" href="profile.php">
                        <i class="fa-solid fa-circle-user"></i> &nbsp;
                        Profile
                    </a></li>
                <li><a class="dropdown-item" href="change_password.php">
                        <i class="fa-solid fa-key"></i> &nbsp;Change Password</a></li>
                <li>
                <li><a class="dropdown-item" href="logout.php">
                        <i class="fa-solid fa-right-from-bracket"></i> &nbsp;Logout</a></li>
            </ul>
        </div>


        <!-- <a href="#news">News</a>
  <a href="#contact">Contact</a>
  <a href="#about">About</a> -->
        <!-- <a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a> -->
    </div>


    <center>
        <h3>Welcome Back</h3>
        <h1><?php echo $_SESSION['user_name']; ?>!!!!!</h1>
        <!-- <div class="card">
  <div class="card-body">
  <a class="dropdown-item" href="logout.php">
  <i class="fa-solid fa-file-invoice"></i> &nbsp;Bills</a>
  </div>
</div>
    <div class="card">
  <div class="card-body">
  <a class="dropdown-item" href="logout.php">
  <i class="fa-solid fa-bullhorn"></i> &nbsp;Announcement</a>
  </div>
</div>
    <div class="card">
  <div class="card-body">
  <a class="dropdown-item" href="logout.php">
  <i class="fa-solid fa-people-group"></i> &nbsp;Visitor</a>
  </div>
</div>
    <div class="card">
  <div class="card-body">
  <a class="dropdown-item" href="logout.php">
  <i class="fa-solid fa-building-circle-exclamation"></i> &nbsp;Complaints</a>
  </div>
</div> --><br>
        <div class="group">
            <a class="btn btn-primary" href="bills.php" role="button" id="userbtn">
                <i class="fa-solid fa-file-invoice"></i> &nbsp;Bill Payment</a>
            </a>
            <a class="btn btn-primary" href="announcement.php" role="button" id="userbtn">
                <i class="fa-solid fa-bullhorn"></i> &nbsp;Announcement</a>
            </a>
           <!-- <a class="btn btn-primary" href="visitors.php" role="button" id="userbtn">
                <i class="fa-solid fa-people-group"></i> &nbsp;Visitor</a>-->
            </a>
            <a class="btn btn-primary" href="complaints.php" role="button" id="userbtn">
                <i class="fa-solid fa-building-circle-exclamation"></i> &nbsp;Complaints</a>
            </a>
            <a class="btn btn-primary" href="noc.php" role="button" id="userbtn">
            <i class="fa-solid fa-building-circle-check"></i> &nbsp;NOC Permission Management</a>
            </a>
            <a class="btn btn-primary" href="sellrent.php" role="button" id="userbtn">
                <i class="fa-solid fa-building"></i> &nbsp;Rent/Sell Flats</a>
            </a>
            <a class="btn btn-primary" href="change_password.php" role="button" id="userbtn">
                        <i class="fa-solid fa-key"></i> &nbsp;
                            Change Password
                        </a>
        </div>


    </center>



    <script>
    function myFunction() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
    </script>
    <?php

include 'footer.php';

?>
</body>

</html>