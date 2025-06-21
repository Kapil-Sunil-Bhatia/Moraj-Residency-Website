<?php
// Include the database connection configuration
require 'config.php';
if (!isset($_SESSION['user_id']) && ($_SESSION['user_role'] !== 'admin' || $$_SESSION['user_role'] !== 'user')) {
    header('Location: logout.php');
    exit();
}

if (isset($_GET['add_about'], $_GET['id']) && $_GET['add_about'] == 'delete' && $_SESSION['user_role'] == 'admin') {
    $stmt = $pdo->prepare("DELETE FROM about WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $_SESSION['success'] = 'About the Society Data has been removed';
    header('location:abouthome.php');
}

include 'header.php';

// Function to sanitize user input (preventing SQL injection)
function sanitizeInput($input)
{
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

// Process form submission to add a new announcement
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_about"])) {
        $about = sanitizeInput($_POST["about_text"]);
        $about_status = sanitizeInput($_POST["about_status"]);

        // Insert the new announcement into the database
        $sql = "INSERT INTO about (about_text, about_status, timestamp) VALUES (:about_text,:about_status, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':about_text', $about, PDO::PARAM_STR);
        $stmt->bindParam(':about_status', $about_status, PDO::PARAM_STR);


        if ($stmt->execute()) {
            echo "<center><div class='alert alert-success' role='alert'>
            About society added successfully!!!! 
          </div></center>";
        } else {
            echo "Error adding about the society: " . $stmt->errorInfo()[2];
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add About</title>
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
    <h1>Add About</h1>
    <a href="abouthome.php">View About</a>


    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="form">
        <label for="about_text">About the Society Text:</label><br>
        <textarea id="about_text" name="about_text" rows="4" cols="50" maxlength="10000" required></textarea>
        <div id="the-count" style="float: right!important;">
    <span id="current">0</span>
    <span id="maximum">/ 10000</span>
  </div>
  <br>
  <label for="about_status">Status:</label><br>
  <textarea id="about_status" name="about_status" rows="4" cols="50" required></textarea>
        <br><br>
        <input type="submit" name="add_about" value="Add About the Society" 
        style="background: #4C0033; border: #4C0033; padding: 0.5pc; color: white; border-radius:2px;">
    </form>
    </div>
</body>

<script>
$('textarea').keyup(function() {
    
    var characterCount = $(this).val().length,
        current = $('#current'),
        maximum = $('#maximum'),
        theCount = $('#the-count');
      
    current.text(characterCount);
   
    
    /*This isn't entirely necessary, just playin around*/
    if (characterCount < 70) {
      current.css('color', '#666');
    }
    if (characterCount > 70 && characterCount < 90) {
      current.css('color', '#6d5555');
    }
    if (characterCount > 90 && characterCount < 100) {
      current.css('color', '#793535');
    }
    if (characterCount > 100 && characterCount < 120) {
      current.css('color', '#841c1c');
    }
    if (characterCount > 120 && characterCount < 139) {
      current.css('color', '#8f0001');
    }
    
    if (characterCount >= 140) {
      maximum.css('color', '#8f0001');
      current.css('color', '#8f0001');
      theCount.css('font-weight','bold');
    } else {
      maximum.css('color','#666');
      theCount.css('font-weight','normal');
    }
    
        
  });
</script>

</html>