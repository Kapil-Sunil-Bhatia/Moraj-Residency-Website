<?php

require_once 'config.php';

if (isset($_POST['btn_change_password'])) {
    // Validate the form data
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($current_password)) {
        $errors[] = 'Current password is required';
    }
    if (empty($new_password)) {
        $errors[] = 'New password is required';
    } elseif (strlen($new_password) < 6) {
        $errors[] = 'New password must be at least 6 characters long';
    }
    if (empty($confirm_password)) {
        $errors[] = 'Confirm password is required';
    } elseif ($new_password !== $confirm_password) {
        $errors[] = 'New password and confirm password do not match';
    }

    // If the form data is valid, update the user's password
    if (empty($errors)) {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT password FROM users WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($current_password, $row['password'])) {
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$new_password_hash, $user_id]);
            $_SESSION['success'] = 'Password changed successfully';
        } else {
            $errors[] = 'Current password is incorrect';
        }
    }
}

// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
//     header('Location: logout.php');
//     exit();
// } else {
//     // Check if the user ID is set in the query string
//     if (isset($_SESSION['user_id'])) {
//         // Retrieve the user ID from the query string
//         $user_id = $_SESSION['user_id'];

//         // Prepare a SELECT statement to retrieve the user's details
//         $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
//         $stmt->execute([$user_id]);

//         // Fetch the user's details from the database
//         $user = $stmt->fetch(PDO::FETCH_ASSOC);
//     }
// }

include 'header.php';

?>

<style>
    .col-md-4{
        
        width: 80%;
        margin: 50px auto;
        -webkit-box-shadow: 2px 2px 31px -7px rgba(0,0,0,0.38);
-moz-box-shadow: 2px 2px 31px -7px rgba(0,0,0,0.38);
box-shadow: 2px 2px 31px -7px rgba(0,0,0,0.38);
        
    }
    label{
        float:left;
    }
    form{
        padding: 1pc;
        border-radius: 20%;
        
    }
    .card-body{
        background-color: #fff9e8;

    }
    #btn_cp{
  background-color: #430A5D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  font-weight:bold;
  cursor: pointer;
  width: 30%;
}

#btn_cp:hover {
  opacity: 0.8;
}

@media (min-width: 300px) and (max-width: 630px) {
    #btn_cp{
  background-color: #475c84;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  font-weight:bold;
  cursor: pointer;
  width: 100%;
}
}

</style>

<div class="container-fluid px-4">
    <h1 class="mt-4">Profile</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Change Password</li>
    </ol>
    <center>
    <div class="col-md-4">
        <?php

if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';

    unset($_SESSION['success']);
}

if (isset($errors)) {
    foreach ($errors as $error) {
        echo "<div class='alert alert-danger'>$error</div>";
    }
}

?>

        <div class="card">
            <!-- <div class="card-header" style="background-color:#9b2928">
                <h5 class="card-title" style="color: #fff;">Change Password</h5>
            </div> -->
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="current-password">Current Password</label>
                        <input type="password" class="form-control" id="current-password" name="current_password">
                    </div>
                    <div class="mb-3">
                        <label for="new-password">New Password</label>
                        <input type="password" class="form-control" id="new-password" name="new_password">
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm-password" name="confirm_password">
                    </div>
                    <button type="submit" name="btn_change_password" class="btn btn-primary" id="btn_cp">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
</center>

<?php

include 'footer.php';

?>