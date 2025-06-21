<?php

require_once 'config.php';

if (!isset($_SESSION['user_id']) && ($_SESSION['user_role'] !== 'admin' || $$_SESSION['user_role'] !== 'user')) {
    header('Location: logout.php');
    exit();
}

if (isset($_GET['action'], $_GET['id']) && $_GET['action'] == 'delete' && $_SESSION['user_role'] == 'admin') {
    $stmt = $pdo->prepare("DELETE FROM contact_us WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $_SESSION['success'] = 'The Contact Data has been removed';
    header('location:contactusdata.php');
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
@media (min-width: 321px) and (max-width: 760px) {

    h5.card-title{
    color: #fff;
    font-size: small;    }
    #addbtn{
  width: 60%;
    }
}
</style>
<div class="container-fluid px-4">
    <h1 class="mt-4">Contact Us Data</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php" style="text-decoration:none;">Dashboard</a></li>
        <li class="breadcrumb-item active">Contact Us Data</li>
    </ol>
    <?php

if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';

    unset($_SESSION['success']);
}

?>
    <div class="card">
        <div class="card-header" style="background-color:#4C0033;">
            <div class="row">
                <div class="col col-6">
                    <h5 class="card-title" style="color: #fff;">Contact Us Data</h5>
                </div>
                <div class="col col-6">
                    <?php
if ($_SESSION['user_role'] == 'admin') {
    ?>  
                    <?php
}
?>

                </div>

            </div>

        </div>

    </div>
    <div>

        <table class="table table-bordered table-striped table-bordered" style="border: 1px black solid; background: #fff9e8">
            <tr style=" background: #4C0033;">
                <th style="    color: white;
    text-align: center;">Sr. No.</th>
                <th style="    color: white;
    text-align: center;">Name of user</th>
     <th style="    color: white;
    text-align: center;">Email</th>
                <th style="    color: white;
    text-align: center;">Message</th>
    <th style="    color: white;
    text-align: center;">Action</th>
            </tr>
            <?php
// SQL query to retrieve all announcements, ordered by timestamp (latest first)
$sql = "SELECT id, name, email, message FROM contact_us";
$stmt = $pdo->query($sql);

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user_id = $row["id"];
        $name = $row["name"];
        $email = $row["email"];
        $message = $row["message"];
        echo "<tr>";
        echo "<td>$user_id</td>";
        echo "<td>$name</td>";
        echo "<td>$email</td>";
        echo "<td>$message</td>";
        echo "<td>";

        // Check if the user is an admin to display the delete button
        if ($_SESSION['user_role'] == 'admin') {
            echo "<center><button class='download_btn' style='
            background: #DC3545;
            padding: 4px 8px;
            border-radius: 4px;
            width: 70%;
            color: white;
            border:none;' onclick='confirmDelete($user_id)'>Delete</button></center>";
        }

        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='3'>No about available.</td></tr>";
}
?>
        </table>
    </div>

    <script>
    function confirmDelete(aboutId) {
        if (confirm("Are you sure you want to delete this message?")) {
            // If the user confirms, navigate to the delete_announcement.php page with the announcement ID
            window.location.href = `delete_contactus.php?id=${aboutId}`;
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
    $('#users-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: 'action.php',
            method: "POST",
            data: {
                action: 'fetch_contact'
            }
        },
        "columns": [{
                "data": "id"
            },
            {
                "data": "name"
            },
            {
                "data": "email"
            },
            {
                "data": "message"
            },
            {
                "data": null,
                "render": function(data, type, row) {
                    return '<a href="edit_abouthome.php?id=' + row.id +
                        '" class="btn btn-sm btn-primary">Edit</a>&nbsp;<button type="button" class="btn btn-sm btn-danger delete_btn" data-id="' +
                        row.id + '">Delete</button>';
                }
            }
        ]
    });

    $(document).on('click', '.delete_btn', function() {
        if (confirm("Are you sure you want to remove this Users data?")) {
            window.location.href = 'contactusdata.php?action=delete&id=' + $(this).data('id') + '';
        }
    });
});
</script>
