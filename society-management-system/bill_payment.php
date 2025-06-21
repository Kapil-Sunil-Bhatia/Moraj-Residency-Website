<?php

require_once 'config.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'user')) {
    header('Location: logout.php');
    exit();
}

if (isset($_POST['payment_bill'])) {
    $paid_amount = $_POST['paid_amount'];
    $_SESSION['paid_amount'] = $paid_amount;
    $paid_date = $_POST['paid_date'];
    $_SESSION['paid_date'] = $paid_date;
    //$payment_method = $_POST['payment_method'];
    $id = $_POST['id'];
    $_SESSION['paymentnewid'] = $id;
    if (empty($paid_date)) {
        $errors[] = 'Please Select Bill Payment Date';
    }
    if (empty($paid_amount)) {
        $errors[] = 'Please enter Bill Amount';
    } else if (!is_numeric($paid_amount)) {
        $errors[] = 'Amount must be a number';
    }

    $stmt = $pdo->prepare("SELECT amount, remaining_amount FROM bills WHERE id = ?");
    $stmt->execute([$id]);
    $bill = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($bill['remaining_amount'] == 0) {
        $remaining_balance = $bill['amount'] - $paid_amount;
    } else {
        $remaining_balance = $bill['remaining_amount'] - $paid_amount;
    }
    $_SESSION['remaining_balance'] = $remaining_balance;
    // $remaining_balance = max(0, $remaining_balance);


    if (empty($errors)) {
        $_SESSION['flat_number'] = $_POST['flat_number'];
        $_SESSION['hidden_bill_title'] = $_POST['hidden_bill_title'];
        
        header('location:payment.php');
        exit();
    }
}

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT flats.flat_number, flats.block_number, bills.bill_title, bills.id, bills.amount, bills.month, bills.paid_date, bills.paid_amount, bills.payment_method, bills.remaining_amount FROM bills INNER JOIN flats ON flats.id = bills.flat_id WHERE bills.id = ?");

    $stmt->execute([$_GET['id']]);

    $bill = $stmt->fetch(PDO::FETCH_ASSOC);
    // Display remaining amount
    if (isset($_GET['action']) && $_GET['action'] == 'notification') {
        if ($_SESSION['user_role'] == 'admin') {
            $notification_type = 'Bill Payment';
        } else {
            $notification_type = 'Bill';
        }
        $stmt = $pdo->prepare("UPDATE notifications SET read_status = 'read' WHERE user_id = '" . $_SESSION['user_id'] . "' AND notiification_type = '" . $notification_type . "' AND event_id = '" . $_GET['id'] . "'");

        $stmt->execute();
    }
}

include 'header.php';

?>

<style>
label {
    float: left;
}

.col-md-4 {
    width: 60%;
}
</style>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<div class="container-fluid px-4">
    <h1 class="mt-4">Bill Payment</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php" style="text-decoration:none;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="bills.php" style="text-decoration:none;">Bills Management</a></li>
        <li class="breadcrumb-item active">Bill Payment</li>
    </ol>
    <center>
        <div class="col-md-4">
            <?php

if (isset($errors)) {
    foreach ($errors as $error) {
        echo "<div class='alert alert-danger'>$error</div>";
    }
}

?>
            <div class="card">
                <div class="card-header" style="background-color:#4C0033;">
                    <h5 class=" card-title" style="color: #fff;">Bill Payment</h5>
                </div>
                <div class="card-body" style="background-color:#fff9e8;">
                    <form method="post">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-5"><b>Flat Number</b></div>
                                <div class="col-md-7">
                                    <?php echo (isset($bill['flat_number'])) ? $bill['block_number'] . ' - ' . $bill['flat_number'] : ''; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5"><b>Bill Details</b></div>
                                <div class="col-md-7">
                                    <?php echo (isset($bill['bill_title'])) ? $bill['bill_title'] : ''; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5"><b>Bill Month</b></div>
                                <div class="col-md-7"><?php echo (isset($bill['month'])) ? $bill['month'] : ''; ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-5"><b>Bill Amount</b></div>
                                <div class="col-md-7"><?php echo (isset($bill['amount'])) ? $bill['amount'] : ''; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5"><b>Remaining Amount</b></div>
                                <div class="col-md-7">
                                    <?php echo (isset($bill['remaining_amount'])) ? $bill['remaining_amount'] : ''; ?>
                                </div>
                            </div>
                            <?php
if (isset($bill['remaining_amount']) && $bill['remaining_amount'] == 0) {
    ?>
                            <div class="row">
                                <div class="col-md-5"><b>Payment Date</b></div>
                                <div class="col-md-7">
                                    <?php echo (isset($bill['paid_date'])) ? $bill['paid_date'] : ''; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5"><b>Paid Bill Amount</b></div>
                                <div class="col-md-7">
                                    <?php echo (isset($bill['paid_amount'])) ? $bill['paid_amount'] : ''; ?></div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-5"><b>Payment Method</b></div>
                                <div class="col-md-7">
                                    <?php echo (isset($bill['payment_method'])) ? $bill['payment_method'] : ''; ?></div>
                            </div>-->
                            <div class="row">
                                <div class="col-md-5"><b>Remaining Amount</b></div>
                                <div class="col-md-7">
                                    <?php echo (isset($bill['remaining_amount'])) ? $bill['remaining_amount'] : ''; ?>
                                </div>
                            </div>

                            <!-- <div class="row">
                            <div class="col-md-5"><b>Payed to</b></div>
                            <div class="col-md-7">
                                boism-9820214870@boi</div>
                        </div> -->
                            <?php
} else {
    if ($_SESSION['user_role'] == 'user') {
        ?>
                        </div>
                        <div class="mb-3">
   <!--  <label>Payment Date</label> -->
    <input type="date" class="form-control" name="paid_date" id="paid_date" hidden value="<?php echo date('Y-m-d'); ?>">
</div>

<script>
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("paid_date").value = today;
</script>   
                        <div class="mb-3">
                            <label for="amount">Amount</label>
                            <input required type="number" id="paid_amount" name="paid_amount" class="form-control" step="0.01"
                                value="">
                        </div>
                        <!-- <div class="mb-3">
                        <label for="month">Payment Method</label>
                        <select name="payment_method" class="form-control">
                            <option value="">Select Payment Method</option>
                            <option value="Cash">UPI</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amount">Use this UPI ID</label>
                        <input type="text" id="upi_id" name="upi_id" class="form-control" step="0.01" readonly
                            placeholder="boism-9820214870@boi" value="">
                    </div> -->
                        <input type="hidden" name="id" value="<?php echo (isset($bill['id'])) ? $bill['id'] : ''; ?>" />
                        <input type="hidden" name="hidden_amount"
                            value="<?php echo (isset($bill['amount'])) ? $bill['amount'] : ''; ?>" />
                        <input type="hidden" name="hidden_bill_title"
                            value="<?php echo isset($bill['bill_title']) ? $bill['bill_title'] : ''; ?>" />
                        <input type="hidden" name="flat_number"
                            value="<?php echo (isset($bill['flat_number'])) ? $bill['block_number'] . ' - ' . $bill['flat_number'] : ''; ?>" />
                        <button type="submit" name="payment_bill" class="btn btn-primary"
                            style="background: #430A5D; border: #430A5D;">Payment</button>
                        <?php
} else {
        ?>
                        <div class="row">
                            <div class="col-md-5"><b>Payment Status</b></div>
                            <div class="col-md-7"><span class="badge bg-danger">Not Paid</span></div>
                        </div>
                </div>
                <?php
}
}
?>
                </form>
            </div>
        </div>
</div>

<br>
<br>
</div>
</center>
<?php

include 'footer.php';

?>