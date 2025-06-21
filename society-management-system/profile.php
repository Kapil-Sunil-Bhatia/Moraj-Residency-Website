<?php
require_once 'config.php';

if (isset($_POST['save_button'])) {
    // Validate name
    if (empty(trim($_POST['name']))) {
        $errors[] = 'Please enter your name.';
    } else {
        $name = trim($_POST['name']);
    }

    // Validate email
    if (empty(trim($_POST['email']))) {
        $errors[] = 'Please enter your email address.';
    } else {
        $email = trim($_POST['email']);
    }

    // Validate phone number
    if (empty(trim($_POST['phone']))) {
        $errors[] = 'Please enter your phone number.';
    } else {
        $phone = trim($_POST['phone']);
    }

    // Validate flat number
    if (empty(trim($_POST['flat_no']))) {
        $errors[] = 'Please enter your flat number.';
    } else {
        $flat_no = trim($_POST['flat_no']);
    }

    // Validate building number
    if (empty(trim($_POST['building_no']))) {
        $errors[] = 'Please enter your building number.';
    } else {
        $building_no = trim($_POST['building_no']);
    }

    // Validate family members count
    if (empty(trim($_POST['family_members']))) {
        $errors[] = 'Please enter the number of people in your family.';
    } else {
        $family_members = trim($_POST['family_members']);
    }

    // Upload profile picture
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["profile_pic"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $errors[] = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["profile_pic"]["size"] > 500000) {
        $errors[] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $errors[] = "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFile)) {
            // Update users table with new fields and profile picture path
            $profile_pic_path = $targetFile;
            $sql = "UPDATE users SET name = ?, email = ?, phone = ?, flat_no = ?, building_no = ?, family_members = ?, profile_pic = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $email, $phone, $flat_no, $building_no, $family_members, $profile_pic_path, $_SESSION['user_id']]);
            $message = "Profile updated";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {
            $errors[] = "Sorry, there was an error uploading your file.";
        }
    }
}

// Check if the user ID is set in the query string
if (isset($_SESSION['user_id'])) {
    // Retrieve the user ID from the query string
    $user_id = $_SESSION['user_id'];

    // Prepare a SELECT statement to retrieve the user's details
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);

    // Fetch the user's details from the database
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header('Location: logout.php');
    exit();
}

include 'header.php';
?>

<style>
.col-md-4 {
    width: 80%;
    margin: 50px auto;
    -webkit-box-shadow: 2px 2px 31px -7px rgba(0, 0, 0, 0.38);
    -moz-box-shadow: 2px 2px 31px -7px rgba(0, 0, 0, 0.38);
    box-shadow: 2px 2px 31px -7px rgba(0, 0, 0, 0.38);

}
.img-thumbnail {
    max-width: 150px; /* Adjust as needed */
    max-height: 150px; /* Adjust as needed */
}

label {
    float: left;
}
.mb-3{
    background-color: #fdf9ea;
    margin-bottom: 0rem !important;
}
form {
    padding: 1pc;
    border-radius: 20%;

}

.card-body {
    background-color: #fff9e8;

}

#btn_cp {
    background-color: #430A5D;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    font-weight: bold;
    cursor: pointer;
    width: 30%;
}

#btn_cp:hover {
    opacity: 0.8;
}

input#name,
input#email,
input#img {
    float: left;
}

@media (min-width: 300px) and (max-width: 320px) {
    .sb-topnav {
        background-color: #000000 !important;
        width: 117%;
    }

    #btn_cp {
        background-color: #430A5D;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
    }

    #layoutSidenav #layoutSidenav_content {
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-width: 0;
        flex-grow: 1;
        min-height: 100vh;
        margin-left: -225px;
    }

    .card {
        width: 80%;
    }

    #layoutSidenav {
        width: 117%;
    }

}

@media (min-width: 321px) and (max-width: 760px) {

    .card {
        width: 80%;
    }

    #btn_cp {
        width: 60%;
    }
}
</style>

<div class="container-fluid px-4">
    <h1 class="mt-4">Profile</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Edit Profile</li>
    </ol>
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
        <?php if (!empty($user['profile_pic'])): ?>
    <div class="d-flex justify-content-center mb-3">
        <img src="<?php echo $user['profile_pic']; ?>" class="img-thumbnail" alt="Profile Picture">
    </div>
<?php endif; ?>
        <center>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="profile_pic" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" id="profile_pic" name="profile_pic">
                    </div>
                    <br>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="<?php echo $user['name']; ?>">
                    </div><br><br><br>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?php echo $user['email']; ?>">
                    </div><br><br><br>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            value="<?php echo $user['phone'] ?? ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="flat_no" class="form-label">Flat Number</label>
                        <input type="text" class="form-control" id="flat_no" name="flat_no"
                            value="<?php echo $user['flat_no'] ?? ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="building_no" class="form-label">Building Number</label>
                        <input type="text" class="form-control" id="building_no" name="building_no"
                            value="<?php echo $user['building_no'] ?? ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="family_members" class="form-label">Number of People in Family</label>
                        <input type="number" class="form-control" id="family_members" name="family_members"
                            value="<?php echo $user['family_members'] ?? ''; ?>">
                    </div>
                    <button type="submit" name="save_button" class="btn btn-primary" id="btn_cp">Save</button>
                </form>
            </div>
        </center>
    </div>
</div>
</div>

<?php include 'footer.php'; ?>