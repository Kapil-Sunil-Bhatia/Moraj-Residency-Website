<?php

require_once 'config.php';

if (!isset($_SESSION['user_id']) && ($_SESSION['user_role'] !== 'admin' || $$_SESSION['user_role'] !== 'user')) {
    header('Location: logout.php');
    exit();
}

if (isset($_GET['action'], $_GET['id']) && $_GET['action'] == 'delete' && $_SESSION['user_role'] == 'admin') {
    $stmt = $pdo->prepare("DELETE FROM bills WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $_SESSION['success'] = 'Bills Data has been removed';
    header('location:announcement.php');
}

include 'header.php';

?>
<style>
.btn {
    background-color: red;
}

.table {
    border-collapse: collapse;
    width: 100%;
    
    border: 1px black solid;

}

table,
th,
td {
    border: 2px solid black;
}

th,
td {
    padding: 8px;
    text-align: left;
}

marquee {
    width: 100%;
    height: 30px;
    background-color: #fff9e8;
    color: #9b2928;
    font-weight: bold;
}
@media (min-width: 300px) and (max-width: 320px) {
    .sb-topnav {
    background-color: #000000 !important;
    width: 111%;
}
#addbtn{
background-color: #475c84;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  font-weight:bold;
  cursor: pointer;
  width: 80%;
    }
#layoutSidenav #layoutSidenav_content {
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-width: 0;
    flex-grow: 1;
    min-height: 100vh;
    margin-left: -225px;
}
h5.card-title{
    color: #fff;
    font-size: small;    }
#layoutSidenav{
    width: 111%;
}

}
@media (min-width: 300px) and (max-width: 760px) {


    h5.card-title{
    color: #fff;
    font-size: small;    }

    #addbtn{
  width: 60%;
    }

    .btn{
        margin: 10px;
    }
    td{
        width: fit-content;
        font-size: small;
    }
    .px-4 {
    padding-right: 0.5rem !important;
    padding-left: 0.5rem !important;
}

}
</style>
<div class="container-fluid px-4">
    <h1 class="mt-4">Announcement Management</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php" style="text-decoration:none;">Dashboard</a></li>
        <li class="breadcrumb-item active">Announcement Management</li>
    </ol>
    <?php

if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';

    unset($_SESSION['success']);
}

?>
    <div class="card">
        <div class="card-header" style="background-color:#4C0033">
            <div class="row">
                <div class="col col-6">
                    <h5 class="card-title" style="color: #fff;">Announcement Management</h5>
                </div>
                <div class="col col-6">
                    <?php
if ($_SESSION['user_role'] == 'admin') {
    ?>
                    <div class="float-end"><a href="add_announcement.php" class="btn btn-success btn-sm"
                            style="background-color:#FFF2E2!important; color: #000; font-weight:bold; border-color: #FFF2E2;width: 100px;">Add</a>
                    </div>
                    <?php
}
?>

                </div>

            </div>

        </div>

    </div>
    <div>
        <marquee behavior="scroll" direction="left" scrollamount="4">
            <?php
// SQL query to retrieve all announcements, ordered by timestamp (latest first)
$sql = "SELECT announcement_text FROM announcements ORDER BY timestamp DESC";
$stmt = $pdo->query($sql);

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $announcement = $row["announcement_text"];
        echo "$announcement &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    }
} else {
    echo "No announcements available.";
}
?>
        </marquee>

        <br><br>
        <div style="overflow-x: auto; width: 100%;">

        <table class="table table-bordered table-striped table-bordered" style="border: 1px black solid; background: #fff9e8">
            <tr style=" background: #4C0033;">
                <th style="    color: white;
    text-align: center;">Date</th>
                <th style="    color: white;
    text-align: center;">Announcement</th>
                <th style="    color: white;
    text-align: center;">Action</th>
            </tr>
            <?php
// SQL query to retrieve all announcements, ordered by timestamp (latest first)
$sql = "SELECT id, announcement_text, timestamp FROM announcements ORDER BY timestamp DESC";
$stmt = $pdo->query($sql);

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $announcement_id = $row["id"];
        $announcement = $row["announcement_text"];
        $timestamp = $row["timestamp"];
        echo "<tr>";
        echo "<td>$timestamp</td>";
        echo "<td>$announcement</td>";
        echo "<td>";


        // Check if the user is an admin to display the delete button
        if ($_SESSION['user_role'] == 'admin') {
            echo "<center><button class='download_btn' style='
                background: #DC3545;
                padding: 4px 8px;
                border-radius: 4px;
                width: 100%;
                color: white;
                border:none;' onclick='confirmDelete($announcement_id)'>Delete</button></center>";
        }

        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No announcements available.</td></tr>";
}
?>
        </table>
</div>


    <script>
    function confirmDelete(announcementId) {
        if (confirm("Are you sure you want to delete this announcement?")) {
            // If the user confirms, navigate to the delete_announcement.php page with the announcement ID
            window.location.href = `delete_announcement.php?id=${announcementId}`;
        }
    }
    </script>
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
$(document).ready(function() {
    $('#bills-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: 'action.php',
            method: "POST",
            data: {
                action: 'fetch_bills'
            }
        }
    });

    $(document).on('click', '.delete_btn', function() {
        if (confirm("Are you sure you want to remove this Bill data?")) {
            window.location.href = 'bills.php?action=delete&id=' + $(this).data('id') + '';
        }
    });
});
</script>