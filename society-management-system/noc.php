<?php

require_once 'config.php';

if (!isset($_SESSION['user_id']) && ($_SESSION['user_role'] !== 'admin' || $_SESSION['user_role'] !== 'user')) {
    header('Location: logout.php');
    exit();
}

if (isset($_GET['action'], $_GET['id']) && $_GET['action'] == 'delete' && $_SESSION['user_role'] == 'admin') {
    $stmt = $pdo->prepare("DELETE FROM bills WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $_SESSION['success'] = 'Bills Data has been removed';
    header('location:bills.php');
}
include 'header.php';
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">NOC Management</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php" style="text-decoration:none;">Dashboard</a></li>
        <li class="breadcrumb-item active">NOC Management</li>
    </ol>
    <?php
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}
?>
    <style>
    body {
        margin: 0;
        padding: 0;
    }

    .btn-warning {
        background-color: #461959 !important;
        width: 100px;
        color: white !important;
    }

    body {
        font-family: Arial, sans-serif;
    }

    .container {
        width: 80%;
        margin: 0 auto;
    }

    input[type="file"],
    input[type="text"],
    select,
    button {
        margin-bottom: 10px;
        padding: 8px;
        width: 100%;
        box-sizing: border-box;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #fffae5;
        border: 1px solid #000;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #4C0033;
        color: white;
    }

    button {
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }
    @media (min-width: 300px) and (max-width: 470px){
 
    .btn{
        margin: 10px;
    }
    td,tr{
        width: fit-content;
        font-size: 10px;
        border: 1px black solid;

    }
    .download_btn{
        width: 100%;
    font-size: 10px;
    padding: 2px;
    }
    .approve,.disapprove{
        text-decoration: none;
    padding: 10px;
    border-radius: 5px;
    margin: 10px;
    color: white;
    padding: none;
    display: block;
    border: none;
    }
    .tablediv{
        margin-left: -10%;
        border: 1px black solid;

    }
    table{
        border: 1px black solid;

    }
}
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="container">
        <?php
        if ($_SESSION['user_role'] !== 'admin') {
            // User upload form
            echo "<h2>Upload Application Letter</h2>";
            echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' enctype='multipart/form-data'>";
            echo "<input type='file' name='document' required>";
            echo "<input type='text' name='name' placeholder='Name' required>";
            echo "<input type='text' name='flat_number' placeholder='Flat Number' required>";
            echo "<select name='permission_status'>";
            echo "<option value='sell'>Sell</option>";
            echo "<option value='rent'>Rent</option>";
            echo "<option value='renovate'>Renovate</option>";
            echo "</select>";
            echo "<br>";
            echo "<br>";
            echo "<button type='submit' name='submit'>Upload</button>";
            echo "</form>";
            echo "<br>";
            echo "<br>";
            echo "<div class='tablediv' style='overflow-x: auto; width: 100%;'>";
            echo "<table>";
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Flat Number</th>";
            echo "<th>Status</th>";
            echo "<th>Action</th>";
            echo "<th>File Uploaded</th>";
            echo "</tr>";

            // Database connection
            $conn=mysqli_connect('localhost','','','');


            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            // Fetch data from database
            $sql = "SELECT * FROM user_documents";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['flat_number'] . "</td>";
                    echo "<td>" . $row['permission_status'] . "</td>";
                    echo "<td>" . $row['action'] . "</td>";
                    echo "<td>" . $row['document_path'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>0 results</td></tr>";
            }    
            echo "</table>";
            echo "</div>";
            // Handle user document upload
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Database connection
            $conn=mysqli_connect('localhost','','','');

                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                // Handle file upload
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["document"]["name"]);
                move_uploaded_file($_FILES["document"]["tmp_name"], $target_file);
                // Insert data into database
                $name = $_POST['name'];
                $flat_number = $_POST['flat_number'];
                $permission_status = $_POST['permission_status'];
                $sql = "INSERT INTO user_documents (document_path, name, flat_number, permission_status) VALUES ('$target_file', '$name', '$flat_number', '$permission_status')";
                if (mysqli_query($conn, $sql)) {
                    echo "<p>Document uploaded successfully.</p>";
                } else {
                    echo "<p>Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
                }
                mysqli_close($conn);
            }
        } else {
            // Admin panel
            echo "<div class='tablediv' style='overflow-x: auto; width: 100%;'>";
            echo "<table>";
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Flat Number</th>";
            echo "<th>Status</th>";
            echo "<th>Edit Status</th>";
            echo "<th>Action</th>";
            echo "<th>Document</th>";
            echo "</tr>";
            // Database connection
            $conn=mysqli_connect('localhost','','','');
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            // Fetch data from database
            $sql = "SELECT * FROM user_documents";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['flat_number'] . "</td>";
                    echo "<td>" . $row['permission_status'] . "</td>";
                    echo "<td>" . $row['action'] . "</td>";
                    echo "<td> <a class='download_btn' style='
                        background: #00629c;
                        text-decoration: none;
                        color: white;
                        padding: 10px;
                        border:none;
                        border-radius: 5px;' href='uploads/{$row['document_path']}' download='{$row['document_path']}'><i class='fa-solid fa-download'></i>&nbsp;Download</a></td>";
                    echo "<td><a class='approve' style='
                    background: #009f10;
                    text-decoration: none;
                    padding: 10px;
                    border-radius: 5px;
                    margin: 10px;
                    color: white;
                    padding: none;
                    border:none;' href='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?admin&action=approve&id=" . $row['id'] . "'>Approve</a> | <a class='disapprove' style='
                    background: #9b2928;
                    text-decoration: none;
                    padding: 10px;
                    margin: 10px;
                    border-radius: 5px;
                    color: white;
                    padding: none;
                    border:none;' href='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?admin&action=disapprove&id=" . $row['id'] . "'>Disapprove</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>0 results</td></tr>";
            }
            mysqli_close($conn);
            echo "</table>";
            echo "</div>";

            // Admin actions
           // Check if action and id are set, action is 'approve', and user role is admin
if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'approve' && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    // Database connection
        $conn=mysqli_connect('localhost','','','');
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // Sanitize the input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    // Update the action to 'approved' for the specified id
    $sql = "UPDATE user_documents SET action='approved' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<p>Action performed successfully.</p>";
    } else {
        echo "<p>Error updating record: " . mysqli_error($conn) . "</p>";
    }
    mysqli_close($conn);
} elseif (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'disapprove' && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    // Database connection
            $conn=mysqli_connect('localhost','','','');


    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Sanitize the input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Update the action to 'disapproved' for the specified id
    $sql = "UPDATE user_documents SET action='disapproved' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<p>Action performed successfully.</p>";
    } else {
        echo "<p>Error updating record: " . mysqli_error($conn) . "</p>";
    }

    mysqli_close($conn);
}
        }
        ?>
    </div>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <?php

include 'footer.php';

?>

    <script>

    </script>