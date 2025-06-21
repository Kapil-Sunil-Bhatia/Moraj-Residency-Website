<?php

require_once 'config.php';

if (isset($_POST['add_user'])) {
    // Validate the form data
    $user_name = $_POST['user_name'];
    $role = $_POST['role'];
    $designation = $_POST['designation'];

    if (empty($user_name)) {
        $errors[] = 'Please enter user name';
    }
    if (empty($role)) {
        $errors[] = 'Please enter role';
    } 
    if (empty($designation)) {
        $errors[] = 'Please enter designation';
    } 


    // If the form data is valid, update the user's password
    if (empty($errors)) {
        // Insert user data into the database
        $stmt = $pdo->prepare("INSERT INTO society_member (user_name, role, designation) VALUES (?, ?, ?)");

        $stmt->execute([$user_name, $role, $designation]);

        $_SESSION['success'] = 'Society Member Added';

        header('location:societymember.php');
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
    <h1 class="mt-4">Add Society Members</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php" style="text-decoration:none;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="societymember.php" style="text-decoration:none;">Society Members</a></li>
        <li class="breadcrumb-item active">Add Society Members Details</li>
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
                <h5 class="card-title" style="color: #fff;">Add Society Members Details</h5>
            </div>
            <div class="card-body" style="background-color:#fff9e8;">
                <form method="post">
                    <div class="mb-3">
                        <label for="user_name">Name</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter User Name">
                    </div>
                    <div class="mb-3">
                        <label for="role">Role</label>
                        <input type="text" class="form-control" id="role" name="role" placeholder="Enter Role">
                    </div>
                    <div class="mb-3">
                        <label for="designation">Designation</label>
                        <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter Designation">
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