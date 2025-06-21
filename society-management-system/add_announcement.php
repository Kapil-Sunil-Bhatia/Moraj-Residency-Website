<?php
// Include the database connection configuration
require 'config.php';
if (!isset($_SESSION['user_id']) && ($_SESSION['user_role'] !== 'admin' || $$_SESSION['user_role'] !== 'user')) {
    header('Location: logout.php');
    exit();
}

if (isset($_GET['action'], $_GET['id']) && $_GET['action'] == 'delete' && $_SESSION['user_role'] == 'admin') {
    $stmt = $pdo->prepare("DELETE FROM bills WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $_SESSION['success'] = 'Announcement Data has been removed';
    header('location:announcement.php');
}

include 'header.php';

// Function to sanitize user input (preventing SQL injection)
function sanitizeInput($input)
{
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

// Process form submission to add a new announcement
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_announcement"])) {
        $announcement_text = sanitizeInput($_POST["announcement_text"]);

        // Insert the new announcement into the database
        $sql = "INSERT INTO announcements (announcement_text, timestamp) VALUES (:announcement_text, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':announcement_text', $announcement_text, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Announcement added successfully.";
        } else {
            echo "Error adding announcement: " . $stmt->errorInfo()[2];
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Announcement</title>
</head>
<style>
    #form{
        background: white;
    width: 80%;
    /* height: 180%; */
    padding: 2pc;
    margin: 50px auto;
    background-color: #fff9e8;
    -webkit-box-shadow: 2px 2px 31px -7px rgba(0,0,0,0.38);
-moz-box-shadow: 2px 2px 31px -7px rgba(0,0,0,0.38);
box-shadow: 2px 2px 31px -7px rgba(0,0,0,0.38);
    }
    textarea {
    resize: vertical;
    width: 100%;
}
</style>
<body>
    <div class="container">
    <h1>Add Announcement</h1>
    <a href="announcement.php">View Announcements</a>


    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form">
        <label for="announcement_text">Announcement Text:</label><br>
        <textarea id="announcement_text" name="announcement_text" rows="4" cols="50" required></textarea><br><br>
        <input type="submit" name="add_announcement" value="Add Announcement" 
        style="background: #430A5D; border: #430A5D; padding: 0.5pc; color: white; border-radius:2px;">
    </form>
    </div>
</body>

</html>