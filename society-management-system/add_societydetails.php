<?php

require_once 'config.php';

if (isset($_POST['add_user'])) {
    // Validate the form data
    $society_name = $_POST['society_name'];
    $building_name = $_POST['building_name'];
    $location = $_POST['location'];

    if (empty($society_name)) {
        $errors[] = 'Please enter society name';
    }
    if (empty($building_name)) {
        $errors[] = 'Please enter building name';
    } 

    // If the form data is valid, update the user's password
    if (empty($errors)) {
        // Insert user data into the database
        $stmt = $pdo->prepare("INSERT INTO society (society_name, building_name, location) VALUES (?, ?, ?)");

        $stmt->execute([$society_name, $building_name, $location]);

        $_SESSION['success'] = 'Society Data Added';

        header('location:societydetails.php');
        exit();
    }
}

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: logout.php');
    exit();
}

include 'header.php';

?>
<style>
     center{
        padding-bottom: 5rem;
    }
    
    label{
        float: left;
    }
    .col-md-4{
        width: 60%;
    }
</style>
<div class="container-fluid px-4">
    <h1 class="mt-4">Add Society Details</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php" style="text-decoration:none;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="societydetails.php" style="text-decoration:none;">Society Details</a></li>
        <li class="breadcrumb-item active">Add Society Details</li>
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
                <h5 class="card-title" style="color: #fff;">Add Society Details</h5>
            </div>
            <div class="card-body" style="background-color:#fff9e8;">
                <form method="post">
                    <div class="mb-3">
                        <label for="society_name">Society Name</label>
                        <input type="text" class="form-control" id="society_name" name="society_name" placeholder="Enter Society Name">
                    </div>
                    <div class="mb-3">
                        <label for="building_name">Building Name</label>
                        <input type="text" class="form-control" id="building_name" name="building_name" placeholder="Enter Building Name">
                    </div>
                    <div class="mb-3">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Enter Location">
                    </div>
                    <button type="submit" name="add_user" class="btn btn-primary"
                    style="background: #430A5D; border: #430A5D;">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</center>
<?php

include 'footer.php';

?>