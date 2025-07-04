<?php

require_once 'config.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'user')) {
    header('Location: logout.php');
    exit();
}

if (isset($_GET['action'], $_GET['id']) && $_GET['action'] == 'delete') {
    $stmt = $pdo->prepare("DELETE FROM visitors WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $_SESSION['success'] = 'Visitor Data has been removed';
    header('location:visitors.php');
}

include 'header.php';

?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Visitor Management</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php" style="text-decoration:none;">Dashboard</a></li>
        <li class="breadcrumb-item active">Visitor Management</li>
    </ol>
    <?php

if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';

    unset($_SESSION['success']);
}

?>
<style>
.btn{
    margin: 5px;
    width: fit-content;
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
    <div class="card">
        <div class="card-header" style="background-color:#4C0033">
            <div class="row">
                <div class="col col-6">
                    <h5 class="card-title" style="color: #fff;">Visitor Management</h5>
                </div>
                <div class="col col-6">
                    <?php
if ($_SESSION['user_role'] == 'admin') {
    ?>
                    <div class="float-end"><a href="add_visitor.php" class="btn btn-success btn-sm"
                            style="background-color:#fff9e8!important; color: #000; font-weight:bold; border-color: #FFF2E2; width: 100px;">Add</a>
                    </div>
                    <?php
}
?>
                </div>
            </div>
        </div>
        <div class="card-body" style="background-color:#fff9e8;">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-bordered" id="visitors-table"
                    style="border: black 2px;">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <th>Flat Number</th>
                            <th>Visitor Name</th>
                            <th>Visitor Phone</th>
                            <th>Person to Meet</th>
                            <th>In Time</th>
                            <th>Out Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
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
    $('#visitors-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: 'action.php',
            method: "POST",
            data: {
                action: 'fetch_visitors'
            }
        }
    });

    $(document).on('click', '.delete_btn', function() {
        if (confirm("Are you sure you want to remove this Visitors data?")) {
            window.location.href = 'visitors.php?action=delete&id=' + $(this).data('id') + '';
        }
    });
});
</script>