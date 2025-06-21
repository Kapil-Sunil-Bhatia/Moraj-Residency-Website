<?php

require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: logout.php');
    exit();
}

if (isset($_POST['edit_user'])) {
    // Validate the form data
    $about = $_POST['about_text'];
    $status = $_POST['about_status'];
    $timestamp = $_POST['timestamp'];

    if (empty($about)) {
        $errors[] = 'Please enter about society';
    }


    // If the form data is valid, update the user's password
    if (empty($errors)) {

            $sql = "UPDATE about SET about_text = ?, about_status = ?, timestamp = ?";

            $pdo->prepare($sql)->execute([$about, $status, $timestamp]);

        $_SESSION['success'] = 'User Data has been edited';

        header('location:abouthome.php');
        exit();
    }
}

if (isset($_GET['id'])) {
    // Prepare a SELECT statement to retrieve the flats's details
    $stmt = $pdo->prepare("SELECT * FROM about WHERE id = ?");
    $stmt->execute([$_GET['id']]);

    // Fetch the user's details from the database
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <h1 class="mt-4">Edit Users</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php" style="text-decoration:none;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="societydetails.php" style="text-decoration:none;">Society Details</a></li>
        <li class="breadcrumb-item active">Edit User Data</li>
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
            <div class="card-header" style="background-color: #283142;">
                <h5 class="card-title" style="color: #fff;">Edit Society Details</h5>
            </div>
            <div class="card-body" style="background-color: #fff9e8;">
                <form method="post">
                    <div class="mb-3">
                        <label for="society_name">Society Name</label>
                        <input type="text" class="form-control" id="society_name" name="society_name" placeholder="Enter Society Name"
                            value="<?php echo isset($user['name']) ? $user['name'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="building_name">Building Name</label>
                        <input type="text" class="form-control" id="building_name" name="building_name" placeholder="Enter Building Name"
                            value="<?php echo isset($user['name']) ? $user['name'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="location">Society Name</label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Enter Location"
                            value="<?php echo isset($user['name']) ? $user['name'] : ''; ?>">
                    </div>
                    <input type="hidden" name="id" value="<?php echo isset($user['id']) ? $user['id'] : ''; ?>" />
                    <button type="submit" name="edit_user" class="btn btn-primary" style="background: #283142; border: #283142;">
                    Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</center>

<?php

include 'footer.php';

?>