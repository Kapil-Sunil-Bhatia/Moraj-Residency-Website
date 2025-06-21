<?php

$stmt = $pdo->prepare("SELECT message, link FROM notifications WHERE user_id = ? AND read_status = ? ORDER BY id DESC");

$stmt->execute([$_SESSION['user_id'], 'unread']);

$notification = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>

        <?php
        $sql = "SELECT society_name FROM society";
        $stmt = $pdo->query($sql);
        
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $society_name = $row["society_name"];
                echo "$society_name";
            }
        } else {
            echo "---";
        }
        ?>

    </title>
    <link rel="icon" type="image/x-icon" href="/img/favicon.png">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Marcellus&display=swap" rel="stylesheet">
</head>
<style>
#leftsidebar {
    width: 200px;
    float: left;
}
.fa-gear, .fa-bell{
    color: white;
}
#main {
    margin-left: 216px;
}
.sb-sidenav-dark .sb-sidenav-footer {
    background-color: #4C0033 !important;
    color: white;
}

.nav {
    display: flex;
    justify-content: left;
    align-items: flex-start;
    background-color: #000000 !important;
    color: white;
}

.sb-topnav {
    background-color: #4C0033 !important;
    color: white;
}

#layoutSidenav {
    background: #fff0f9;
}

.sb-sidenav-menu {
    background-color: #000 !important;
    color: white;
}

.sb-sidenav .sb-sidenav-menu .nav .nav-link {
    display: flex;
    align-items: center;
    /* padding-top: 0.75rem;
    padding-bottom: 0.75rem; */
    padding: 1.5pc;
    position: relative;
    color: white;
}

.sb-sidenav-footer {
    background-color: #4C0033 !important;
    color: white;
}

* {
    font-family: "Marcellus", sans-serif;
}

/* .sb-sidenav .sb-sidenav-menu .nav .nav-link:hover {
    background-color: #c4dbfa;
    color: #283142;
} */
#sidebarToggle {
    visibility: hidden;
}

#laptop {
    visibility: visible;
}

#mobile {
    visibility: hidden;

}

@media (min-width: 300px) and (max-width: 398px) {
    #laptop {
        visibility: hidden;
    }

    #mobile {
        visibility: visible;
    }

    .sb-topnav {
        background-color: #4C0033 !important;
        width: 122%;

    }

    #layoutSidenav {
        background: #fff0f9;
        width: 122%;

    }
    .navbar-expand .navbar-nav .dropdown-menu {
    position: absolute;
    font-size: small;
    text-wrap: wrap;
}
.center {
    padding-bottom: 5rem;
    width: 85%;
    font-size: small;
}
}
@media (min-width: 399px) and (max-width: 991px) {
    #laptop {
        visibility: hidden;
    }
    .center {
    padding-bottom: 5rem;
    width: 85%;
    font-size: small;
}
    #mobile {
        visibility: visible;
    }

    .sb-topnav {
        background-color: #4C0033 !important;
        width: 100%!important;

    }

    #layoutSidenav {
        background: #fff0f9;
        width: 100%!important;

    }
    .navbar-expand .navbar-nav .dropdown-menu {
    position: absolute;
    font-size: small;
    text-wrap: wrap;
}
}

/* @media (min-width: 300px) and (max-width: 350px) {
        .sb-topnav{
    background-color: #000000 !important;
    width: 122%;

}
#layoutSidenav{
    background: #c4dbfa;
    width: 122%;

}
    } */
</style>

<body>

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark" style="background-color: #4C0033 !important;
    color: white;">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="#"><i class="fa-solid fa-building"></i> Moraj Residency</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarnotificationDropdown" href="#" role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"><?php echo (count($notification) > 0) ? '<span class="badge bg-danger">' . count($notification) . '</span>' : ''; ?><i
                        class="fa-solid fa-bell"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarnotificationDropdown"
                    style="max-width: 350px; max-height: 400px; overflow: scroll;">
                    <?php
if (count($notification) > 0) {
    foreach ($notification as $msg) {
        echo '<li><a class="dropdown-item" href="' . $msg["link"] . '">' . $msg["message"] . '</a></li>';
    }
} else {
    echo '<li>No Notification Found</li>';
}
?>
                </ul>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4" id="mobile">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa-solid fa-gear"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <?php
if ($_SESSION['user_role'] == 'admin') {
    ?>
                    <!-- <li><a class="dropdown-item" href="#">Settings</a></li> -->
                    <?php
}
?>
                    <!-- <li><a class="dropdown-item" href="profile.php">Profile</a></li> -->
                    <li><a class="dropdown-item" href="change_password.php">
                            <i class="fa-solid fa-key"></i> &nbsp;Change Password</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <!-- <li><a class="dropdown-item" href="logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i> &nbsp;Logout</a></li>
                 -->
                    <!-- <li><a class="dropdown-item" href="logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i> &nbsp;Logout</a></li>
                    <li> -->

                    <?php
if ($_SESSION['user_role'] == 'admin') {
    ?>
                    <a class="dropdown-item" href="dashboard.php">
                        <i class="fa-solid fa-house"></i> &nbsp; Dashboard
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="users.php">
                        <i class="fa-solid fa-users"></i> &nbsp;User
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="flats.php">
                        <i class="fa-solid fa-door-closed"></i> &nbsp;Flats
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="allotments.php">
                        <i class="fa-solid fa-location-arrow"></i> &nbsp;Allotment
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="bills.php">
                        <i class="fa-solid fa-file-invoice"></i> &nbsp;Bills
                    </a>
                    <!--<li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="confirmpayment.php">
                        <i class="fa-solid fa-file-invoice"></i> &nbsp;Confirm payment
                    </a>-->
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="complaints.php">
                        <i class="fa-solid fa-building-circle-exclamation"></i> &nbsp; Complaints
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="announcement.php">
                        <i class="fa-solid fa-bullhorn"></i> &nbsp;Announcements
                    </a>
                    <!-- <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="visitors.php">
                        <i class="fa-solid fa-people-group"></i> &nbsp;Visitors
                    </a>-->
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="abouthome.php">
                        <i class="fa-solid fa-file-pen"></i> &nbsp;Edit About
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="societycore.php">
                        <i class="fa-solid fa-user-tie"></i> &nbsp;Society Management Committee (Core)
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="societymember.php">
                        <i class="fa-solid fa-people-roof"></i> &nbsp;Society Members
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="societydetails.php">
                        <i class="fa-solid fa-building"></i> &nbsp;Society Details
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="noc.php">
                        <i class="fa-solid fa-building-circle-check"></i> &nbsp;Permission Management
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="sellrent.php">
                        <i class="fa-solid fa-building"></i> &nbsp;Rent/Sell Management
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="reports.php">
                        <i class="fa-solid fa-file-lines"></i> &nbsp;Reports
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <!--<a class="dropdown-item" href="profile.php">-->
                    <!--    <i class="fa-solid fa-circle-user"></i> &nbsp;Profile-->
                    <!--</a>-->
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <?php
}

if ($_SESSION['user_role'] == 'user') {
    ?>
                    <a class="dropdown-item" href="user_dashboard.php">
                        <i class="fa-solid fa-house"></i> &nbsp; Dashboard
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="bills.php">
                        <i class="fa-solid fa-file-invoice"></i> &nbsp; Bills
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="complaints.php">
                        <i class="fa-solid fa-building-circle-exclamation"></i> &nbsp;
                        Complaints
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="noc.php">
                        <i class="fa-solid fa-building-circle-check"></i> &nbsp;
                        NOC Permission Management
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="sellrent.php">
                        <i class="fa-solid fa-building"></i> &nbsp;
                        Rent/Sell Management
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="announcement.php">
                        <i class="fa-solid fa-bullhorn"></i> &nbsp;
                        Announcements
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                   <!--  <a class="dropdown-item" href="visitors.php">
                        <i class="fa-solid fa-people-group"></i> &nbsp;
                        Visitors
                    </a>-->
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <a class="dropdown-item" href="profile.php">
                        <i class="fa-solid fa-circle-user"></i> &nbsp;
                        Profile
                    </a>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>

                    <?php
}
?>
                    <a class="dropdown-item" href="logout.php">
                        <i class="fa-solid fa-right-from-bracket"></i> &nbsp;
                        Logout
                    </a>
                </ul>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4" id="laptop">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa-solid fa-gear"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <?php
if ($_SESSION['user_role'] == 'admin') {
    ?>
                    <!-- <li><a class="dropdown-item" href="#">Settings</a></li> -->
                    <?php
}
?>
                    <!-- <li><a class="dropdown-item" href="profile.php">Profile</a></li> -->
                    <li><a class="dropdown-item" href="change_password.php">
                            <i class="fa-solid fa-key"></i> &nbsp;Change Password</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="logout.php">
                            <i class="fa-solid fa-right-from-bracket"></i> &nbsp;Logout</a></li>
                    <li>

                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion " id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <?php
if ($_SESSION['user_role'] == 'admin') {
    ?>
                        <a class="nav-link" href="dashboard.php">
                            <i class="fa-solid fa-house"></i> &nbsp; Dashboard
                        </a>
                        <a class="nav-link" href="users.php">
                            <i class="fa-solid fa-users"></i> &nbsp;User
                        </a>
                        <a class="nav-link" href="flats.php">
                            <i class="fa-solid fa-door-closed"></i> &nbsp;Flats
                        </a>
                        <a class="nav-link" href="allotments.php">
                            <i class="fa-solid fa-location-arrow"></i> &nbsp;Allotment
                        </a>
                        <a class="nav-link" href="billsadmin.php">
                            <i class="fa-solid fa-file-invoice"></i> &nbsp;Bills
                        </a>
                       <!-- <a class="nav-link" href="confirmpayment.php">
                            <i class="fa-solid fa-file-invoice"></i> &nbsp;Confirm Payment
                        </a>-->
                        <a class="nav-link" href="complaints.php">
                            <i class="fa-solid fa-building-circle-exclamation"></i> &nbsp; Complaints
                        </a>
                        <a class="nav-link" href="announcement.php">
                            <i class="fa-solid fa-bullhorn"></i> &nbsp;Announcements
                        </a>
                        <a class="nav-link" href="visitors.php">
                            <i class="fa-solid fa-people-group"></i> &nbsp;Visitors
                        </a>
                        <a class="nav-link" href="reports.php">
                            <i class="fa-solid fa-file-lines"></i> &nbsp;Reports
                        </a>
                        <a class="nav-link" href="contactusdata.php">
                            <i class="fa-solid fa-address-book"></i> &nbsp;Contact Us Messages
                        </a>
                        <a class="nav-link" href="abouthome.php">
                            <i class="fa-solid fa-file-pen"></i> &nbsp;Edit About
                        </a>
                        <a class="nav-link" href="societycore.php">
                            <i class="fa-solid fa-user-tie"></i> &nbsp;Society Management Committee (Core)
                        </a>
                        <a class="nav-link" href="societymember.php">
                            <i class="fa-solid fa-people-roof"></i> &nbsp;Society Members
                        </a>
                        <a class="nav-link" href="societydetails.php">
                            <i class="fa-solid fa-building"></i> &nbsp;Society Details
                        </a>
                        <a class="nav-link" href="noc.php">
                            <i class="fa-solid fa-building-circle-check"></i> &nbsp;Permission Management
                        </a>
                        <a class="nav-link" href="sellrent.php">
                            <i class="fa-solid fa-building"></i> &nbsp;Rent/Sell Management
                        </a>
                        <!--<a class="nav-link" href="profile.php">-->
                        <!--    <i class="fa-solid fa-circle-user"></i> &nbsp;Profile-->
                        <!--</a>-->
                        <?php
}

if ($_SESSION['user_role'] == 'user') {
    ?>
                        <a class="nav-link" href="user_dashboard.php">
                            <i class="fa-solid fa-house"></i> &nbsp; Dashboard
                        </a>
                        <a class="nav-link" href="bills.php">
                            <i class="fa-solid fa-file-invoice"></i> &nbsp; Bill Payment
                        </a>
                        <a class="nav-link" href="complaints.php">
                            <i class="fa-solid fa-building-circle-exclamation"></i> &nbsp;
                            Complaints
                        </a>
                        <a class="nav-link" href="announcement.php">
                            <i class="fa-solid fa-bullhorn"></i> &nbsp;
                            Announcements
                        </a>
                        <!-- <a class="nav-link" href="visitors.php">
                            <i class="fa-solid fa-people-group"></i> &nbsp;
                            Visitors
                        </a>-->
                        <a class="nav-link" href="noc.php">
                            <i class="fa-solid fa-building-circle-check"></i> &nbsp;NOC Permission Management
                        </a>
                        <a class="nav-link" href="sellrent.php">
                            <i class="fa-solid fa-building"></i> &nbsp;Rent/Sell Flats
                        </a>
                        <a class="nav-link" href="profile.php">
                            <i class="fa-solid fa-circle-user"></i> &nbsp;
                            Profile
                        </a>
                        <a class="nav-link" href="change_password.php">
                        <i class="fa-solid fa-key"></i> &nbsp;
                            Change Password
                        </a>

                        <?php
}
?>
                        <a class="nav-link" href="logout.php">
                            <i class="fa-solid fa-right-from-bracket"></i> &nbsp;
                            Logout
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    
                    <?php echo $_SESSION['user_name'] ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">

            <main>
        </div>

</body>

</html>