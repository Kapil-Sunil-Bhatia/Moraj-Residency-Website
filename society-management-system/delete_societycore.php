<?php
// Include the database connection configuration
require 'config.php';
if (!isset($_SESSION['user_id']) && ($_SESSION['user_role'] !== 'admin' || $$_SESSION['user_role'] !== 'user')) {
    header('Location: logout.php');
    exit();
}

// Function to sanitize user input (preventing SQL injection)
function sanitizeInput($input)
{
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

// Check if an announcement ID is provided in the URL
if (isset($_GET['id'])) {
    $about_id = sanitizeInput($_GET['id']);

    // Delete the announcement from the database
    $sql = "DELETE FROM society_core_member WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $about_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Core Member entry deleted successfully. <a href='societycore.php'>Back to Society Core Members</a>";
    } else {
        echo "Error deleting about: " . $stmt->errorInfo()[2];
    }
} else {
    echo "Invalid about ID.";
}
