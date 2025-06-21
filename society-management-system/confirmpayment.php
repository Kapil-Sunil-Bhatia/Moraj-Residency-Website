<?php

require_once 'config.php';

if (!isset($_SESSION['user_id']) && ($_SESSION['user_role'] !== 'admin' || $$_SESSION['user_role'] !== 'user')) {
    header('Location: logout.php');
    exit();
}

include 'header.php';
// Fetch payment data using PDO
$query = "SELECT * FROM payment";
$stmt = $pdo->query($query);
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<style>
.download_btn {
    background: #00629c;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
}

select {
    background: #fff;
    color: #000;
    padding: 5px;
    border-radius: 5px;

}

center {
    padding-bottom: 5rem;
}

table {
    /* border-collapse: collapse; */
    width: 100%;
    background: #fffae5;
    border: 2px solid #000;
    overflow-x: auto;
    white-space: nowrap;
}

th,
td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

th {
    background-color: #4C0033;
    color: white;
}

@media (min-width: 300px) and (max-width: 398px) {
    table {
        /* border-collapse: collapse; */
        width: 100%;
        background: #fffae5;
        border: 1px solid #000;
        overflow-x: auto;
    }
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="container-fluid px-4">
    <h1 class="mt-4">Confirm Payment</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php" style="text-decoration:none;">Dashboard</a></li>
        <li class="breadcrumb-item active">Confirm Payment</li>
    </ol>

    <h2>Admin Payments</h2>
    <div style="overflow-x: auto; width: 80%; font-size: small;">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Payment ID</th>
                <th>Payment Status</th>
                <th>Added On</th>
                <!-- <th>Payment Photo</th> -->
                <!-- <th>Action</th> -->
            </tr>
            <?php foreach ($payments as $payment): ?>
            <tr>
                <td><?php echo $payment['id']; ?></td>
                <td><?php echo $payment['name']; ?></td>
                <td><?php echo $payment['amount']; ?></td>
                <td><?php echo $payment['payment_id']; ?></td>
                <td><?php echo $payment['payment_status']; ?></td>
                <td><?php echo $payment['added_on']; ?></td>

                <!-- -->
            </tr>
            <?php endforeach; ?>
        </table>
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
    function updatePaymentStatus(status, paymentId) {
        // Send AJAX request to update payment status
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_payment_status.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Reload the page after updating status
                location.reload();
            } else {
                console.log('Request failed. Returned status of ' + xhr.status);
            }
        };
        xhr.send('status=' + status + '&payment_id=' + paymentId);
    }
    </script>