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
    header('location:bills.php');
}

include 'header.php';

?>
<style>
.btn {
    background-color: red;
}

center {
    padding-bottom: 5rem;
    width: 98%;
}
@media (min-width: 300px) and (max-width: 500px) {

.center {
    padding-bottom: 5rem;
    width: 85%;
    font-size: small;
}
table{
    width: 85%;
    font-size: small;
}
}
</style>
<div class="container-fluid px-4">
    <h1 class="mt-4">Bills Management</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php" style="text-decoration:none;">Dashboard</a></li>
        <li class="breadcrumb-item active">Bills Management</li>
    </ol>
    <center>
        
        <!-- Unpaid Bills Table -->
        <div class="card">
            <div class="card-header" style="background-color:#4C0033">
                <h5 class="card-title" style="color: #fff;">Unpaid Bills</h5>
            </div>
            <div class="card-body" style="background-color: #fffae5;">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-bordered" id="unpaid-bills-table"
                        style="border: black 2px; width: 100;">
                        <thead>
                            <tr>
                                <th data-orderable="false">ID</th>
                                <th data-orderable="false">Bill Title</th>
                                <th data-orderable="false">Flat Number</th>
                                <th data-orderable="false">Bill Amount</th>
                                <th data-orderable="false">Month</th>
                                <th data-orderable="false">Remaining Amount</th>
                                <th >Updated At</th>
                                <th data-orderable="false">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Paid Bills Table -->
        <div class="card">
            <div class="card-header" style="background-color:#4C0033">
                <h5 class="card-title" style="color: #fff;">Paid Bills</h5>
            </div>
            <div class="card-body" style="background-color: #fffae5;">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-bordered" id="paid-bills-table"
                        style="border: black 2px; width: 100;">
                        <thead>
                            <tr>
                                <th data-orderable="false">ID</th>
                                <th data-orderable="false">Bill Title</th>
                                <th data-orderable="false">Flat Number</th>
                                <th data-orderable="false">Bill Amount</th>
                                <th data-orderable="false">Month</th>
                                
                                <th >Updated At</th>
                                <th data-orderable="false">Payment ID</th>
                                <th data-orderable="false">Amount Paid</th>
                                <th data-orderable="false">Payment Status</th>
                                
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </center>
</div>
        <?php

if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';

    unset($_SESSION['success']);
}

?>
       
</center>
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
        },
         "order": [[ 6, "desc" ]]
    });

    $(document).on('click', '.delete_btn', function() {
        if (confirm("Are you sure you want to remove this Bill data?")) {
            window.location.href = 'bills.php?action=delete&id=' + $(this).data('id') + '';
        }
    });
});
</script>
<script>
    $(document).ready(function() {
        $('#paid-bills-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: 'action.php',
                method: "POST",
                data: {
                    action: 'fetch_bills',
                    payment_status: 'paid'
                }
            },
            "order": [[ 6, "desc" ]]
        });

        $('#unpaid-bills-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: 'action.php',
                method: "POST",
                data: {
                    action: 'fetch_bills',
                    payment_status: 'unpaid'
                }
            },
            "order": [[ 6, "desc" ]]
        });

        $(document).on('click', '.delete_btn', function() {
            if (confirm("Are you sure you want to remove this Bill data?")) {
                window.location.href = 'bills.php?action=delete&id=' + $(this).data('id') + '';
            }
        });
    });
</script>