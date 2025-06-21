<?php

require_once 'config.php';

if (isset($_POST['add_complaint'])) {
    // Validate the form data

    $stmt = $pdo->prepare('SELECT flat_id FROM allotments WHERE user_id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $flat_id = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $_SESSION['user_id'];
    $description = $_POST['description'];
    $created_at = date('Y-m-d H:i:s');

    if (empty($description)) {
        $errors[] = 'Complaints Description is required';
    }

    // If the form data is valid, update the user's password
    if (empty($errors)) {
        $sql = "INSERT INTO complaints (user_id, flat_id, description, master_comment, status, created_at) VALUES (?, ?, ?, ?, ?, ?)";

        $pdo->prepare($sql)->execute([$user_id, $flat_id['flat_id'], $description, '', 'pending', $created_at]);

        // get last inserted ID
        $complaint_id = $pdo->lastInsertId();

        $admin_id = $pdo->query("SELECT id FROM users WHERE role = 'admin'")->fetchColumn();

        $flat_number = $pdo->query("SELECT CONCAT(block_number, ' - ', flat_number) AS flat_number FROM flats WHERE id = '" . $flat_id['flat_id'] . "'")->fetchColumn();

        // insert notification data into notifications table
        $message = "New Complaint added by Flat Number " . $flat_number . ".";

        $notification_link = 'view_complaint.php?id=' . $complaint_id . '&action=notification';
        $stmt = $pdo->prepare("INSERT INTO notifications (user_id, notiification_type, event_id, message, link) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$admin_id, 'Complaint', $complaint_id, $message, $notification_link]);

        $_SESSION['success'] = 'Your Complaints has been submitted';

        header('location:complaints.php');
        exit();
    }
}

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'user')) {
    header('Location: logout.php');
    exit();
}

include 'header.php';

?>
<style>
    .card{
        margin: 10px auto;
        width: 60%;
    }
    .form-label {
    margin-bottom: 0.5rem;
    float: left;
}
#addbtn{
background-color: #430A5D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  font-weight:bold;
  cursor: pointer;
  width: 40%;
    }
@media (min-width: 300px) and (max-width: 320px) {
    .sb-topnav {
    background-color: #000000 !important;
    width: 111%;
}
#addbtn{
background-color: #430A5D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  font-weight:bold;
  cursor: pointer;
  width: 80%;
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
.card{
        width: 80%;
    }
#layoutSidenav{
    width: 111%;
}

}
@media (min-width: 321px) and (max-width: 760px) {

    .card{
        width: 80%;
    }
    #addbtn{
  width: 60%;
    }
}
</style>
<div class="container-fluid px-4">
    <h1 class="mt-4">Add Complaints</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="user_dashboard.php" style="text-decoration:none;">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="complaints.php" style="text-decoration:none;">Complaints Management</a></li>
        <li class="breadcrumb-item active">Add Complaints</li>
    </ol>
    <center>
        <?php

if (isset($errors)) {
    foreach ($errors as $error) {
        echo "<div class='alert alert-danger'>$error</div>";
    }
}

?>

        <div class="card">
            <div class="card-header" style="background-color:#4C0033; color: white;">
                <h5 class="card-title">Add Complaint</h5>
            </div>
            <div class="card-body" style="background-color:#fff9e8;">
                <form id="add-flat-form" method="POST">
                    <div class="mb-3">
                        <label for="description" class="form-label">Complaint Description</label>
                        <textarea name="description" id="description" class="form-control" rows="5"
                            placeholder="Enter Complaint Description"></textarea>
                    </div>
                    <button type="submit" name="add_complaint" class="btn btn-primary" id="addbtn">Add Complaint</button>
                </form>
            </div>

    </div>

</div>
</center>
 
<?php

include 'footer.php';

?>