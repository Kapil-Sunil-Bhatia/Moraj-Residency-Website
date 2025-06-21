<?php

require_once 'config.php';

if (isset($_POST['edit_bill'])) {
    // Validate the form data

    $bill_title = $_POST['bill_title'];
    $flat_id = $_POST['flat_id'];
    $amount = $_POST['amount'];
    $month = $_POST['month'];
    $id = $_POST['id'];

    if (empty($bill_title)) {
        $errors[] = 'Please Define Bill Title';
    }

    if (empty($flat_id)) {
        $errors[] = 'Please Select Flat Number';
    }
    if (empty($amount)) {
        $errors[] = 'Please enter Bill Amount';
    } else if (!is_numeric($amount)) {
        $errors[] = 'Amount must be a number';
    }
    if (empty($month)) {
        $errors[] = 'Please Bill Month';
    }

    // If the form data is valid, update the user's password
    if (empty($errors)) {
        // Insert user data into the database
        $stmt = $pdo->prepare("UPDATE bills SET flat_id = ?, bill_title = ?, amount = ?, month = ? WHERE id = ?");

        $stmt->execute([$flat_id, $bill_title, $amount, $month, $id]);

        $_SESSION['success'] = 'Bill Data has been edited';

        header('location:bills.php');
        exit();
    }
}

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: logout.php');
    exit();
}

$sql = "SELECT id, flat_number, block_number FROM flats ORDER BY id DESC";

$stmt = $pdo->prepare($sql);

$stmt->execute();

$flats = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM bills WHERE id = ?");

    $stmt->execute([$_GET['id']]);

    $bill = $stmt->fetch(PDO::FETCH_ASSOC);
}

include 'header.php';

?>
<style>
    label{
        float: left;
    }
    .col-md-4{
        width: 60%;
    }

</style>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Bill Data</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php" style="text-decoration:none;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="bills.php" style="text-decoration:none;">Bills Management</a></li>
        <li class="breadcrumb-item active">Edit Bill Data</li>
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
                <h5 class="card-title" style="color: #fff;">Edit Bill Data</h5>
            </div>
            <div class="card-body" style="background-color:#fff9e8;">
                <form method="post">
                    <div class="mb-3">
                        <label for="bill_title">Bill Title</label>
                        <input type="text" id="bill_title" name="bill_title" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="name">Flat Number</label>
                        <select name="flat_id" id="flat_id" class="form-control">
                            <option value="">Select Flat Number</option>
                            <?php foreach ($flats as $flat): ?>
                            <option value="<?php echo $flat['id']; ?>">
                                <?php echo $flat['block_number'] . ' - ' . $flat['flat_number']; ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amount">Amount</label>
                        <input type="number" id="amount" name="amount" class="form-control" step="0.01"
                            value="<?php echo (isset($bill['amount'])) ? $bill['amount'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="month">Month</label>
                        <input type="month" id="month" name="month" class="form-control"
                            value="<?php echo (isset($bill['month'])) ? $bill['month'] : ''; ?>">
                    </div>
                    <input type="hidden" name="id" value="<?php echo (isset($bill['id'])) ? $bill['id'] : ''; ?>" />
                    <button type="submit" name="edit_bill" class="btn btn-primary" 
                    style="background: #430A5D; border: #430A5D;">Edit Bill</button>
                    <script>
                    $('#flat_id').val('<?php echo (isset($bill['flat_id'])) ? $bill['flat_id'] : ''; ?>');
                    </script>
                </form>
            </div>
        </div>
    </div>
</div>
                            </center>
<?php

include 'footer.php';

?>