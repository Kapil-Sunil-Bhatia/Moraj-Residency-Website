<?php

require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: logout.php');
    exit();
} else {

    if (isset($_POST['add_visitor'])) {
        $flat_id = trim($_POST['flat_id']);
        $name = trim($_POST['name']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $person_to_meet = trim($_POST['person_to_meet']);
        $reason = trim($_POST['reason']);
        $in_datetime = trim($_POST['in_datetime']);

        // Validate form fields
        if (empty($flat_id)) {
            $errors[] = 'Flat ID is required';
        }

        if (empty($name)) {
            $errors[] = 'Name is required';
        }

        if (empty($phone)) {
            $errors[] = 'Phone is required';
        } else {
            // assume $phone contains the phone number input from the form
            $regex = "/^[0-9]{10}$/"; // regular expression to match 10 digits
            if (!preg_match($regex, $phone)) {
                // phone number is invalid
                $errors[] = 'Phone number is invalid';
            }
        }

        if (empty($address)) {
            $errors[] = 'Address is required';
        }

        if (empty($person_to_meet)) {
            $errors[] = 'Person to meet is required';
        }

        if (empty($reason)) {
            $errors[] = 'Reason is required';
        }

        if (empty($in_datetime)) {
            $errors[] = 'In date and time is required';
        }

        // Insert visitor data if there are no validation errors
        if (empty($errors)) {
            $stmt = $pdo->prepare('INSERT INTO visitors (flat_id, name, phone, address, person_to_meet, reason, in_datetime, is_in_out) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$flat_id, $name, $phone, $address, $person_to_meet, $reason, $in_datetime, 'in']);

            $_SESSION['success'] = 'New Visitor Data has been Added';

            header('Location: visitors.php');
            exit();
        }
    }
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
    center{
        padding-bottom: 5rem;
    }

</style>
<div class="container-fluid px-4">
    <h1 class="mt-4">Add Visitors</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php" style="text-decoration:none;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="complaints.php" style="text-decoration:none;">Visitors Management</a></li>
        <li class="breadcrumb-item active">Add Visitor</li>
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
                <h5 class="card-title" style="color: #fff;">Add Visitor</h5>
            </div>
            <div class="card-body" style="background-color:#fff9e8;">
                <form method="post">
                    <div class="mb-3">
                        <label for="flat_id">Flat Number</label>
                        <select id="flat_id" name="flat_id" class="form-control">
                            <option value="">Select Flat</option>
                            <?php
$stmt = $pdo->prepare('SELECT id, flat_number, block_number FROM flats ORDER BY flat_number ASC');
$stmt->execute();
$flats_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($flats_result as $flat) {
    echo "<option value=\"" . $flat['id'] . "\">" . $flat['block_number'] . ' - ' . $flat['flat_number'] . "</option>";
}
?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name">Visitor Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="person_to_meet">Person to Meet</label>
                        <input type="text" id="person_to_meet" name="person_to_meet" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="reason">Reason for Visit</label>
                        <textarea id="reason" name="reason" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="in_datetime">In Date/Time</label>
                        <input type="datetime-local" id="in_datetime" name="in_datetime" class="form-control">
                    </div>
                    <button type="submit" name="add_visitor" class="btn btn-primary"
                    style="background: #430A5D; border: #430A5D;">Add Visitor</button>
                </form>
                
            </div>
        </div>
    </div>
</div>
</center>
<br><br>
<?php

include 'footer.php';

?>