<?php

require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: logout.php');
    exit();
}

if (isset($_POST['edit_user'])) {
    // Validate the form data
    $user_name = $_POST['user_name'];
    $role = $_POST['role'];
    $designation = $_POST['designation'];
    $user_id = $_POST['id'];

    if (empty($user_name) || empty($role) || empty($designation) || empty($user_id)) {
        $errors[] = 'Please fill all fields.';
    }


    // If the form data is valid, update the user's password
    if (empty($errors)) {

            $sql = "UPDATE society_member SET user_name = ?, role = ?, designation = ? WHERE id = ?";

            $pdo->prepare($sql)->execute([$user_name, $role, $designation, $user_id]);

        $_SESSION['success'] = 'User Data has been edited';

        header('location:societymember.php');
        exit();
    }
}

if (isset($_GET['id'])) {
    // Prepare a SELECT statement to retrieve the flats's details
    $stmt = $pdo->prepare("SELECT * FROM society_member WHERE id = ?");
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
    <h1 class="mt-4">Edit Society Core Members Data</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php" style="text-decoration:none;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="societymember.php" style="text-decoration:none;">Society Members</a></li>
        <li class="breadcrumb-item active">Edit Society Members Data</li>
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
            <div class="card-header" style="background-color: #4C0033;">
                <h5 class="card-title" style="color: #fff;">Edit Society Core Members Details</h5>
            </div>
            <div class="card-body" style="background-color: #fff9e8;">
                <form method="post">
                    <div class="mb-3">
                        <label for="user_name">Name</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter User Name"
                           >
                    </div>
                    <div class="mb-3">
                        <label for="role">Role</label>
                        <input type="text" class="form-control" id="role" name="role" placeholder="Enter Role"
                           >
                    </div>
                    <div class="mb-3">
                        <label for="designation">Designation</label>
                        <input type="text" class="form-control" id="designation" name="designation" placeholder="Enter Designation"
                        >
                    </div>
                    <input type="hidden" name="id" value="<?php echo isset($user['id']) ? $user['id'] : ''; ?>" />
                    <button type="submit" name="edit_user" class="btn btn-primary" style="background: #430A5D; border: #430A5D;">
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