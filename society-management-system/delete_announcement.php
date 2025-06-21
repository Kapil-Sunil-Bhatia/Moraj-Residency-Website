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
    $announcement_id = sanitizeInput($_GET['id']);

    // Delete the announcement from the database
    $sql = "DELETE FROM announcements WHERE id = :announcement_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':announcement_id', $announcement_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Announcement deleted successfully. <a href='announcement.php'>Back to Announcements</a>";
    } else {
        echo "Error deleting announcement: " . $stmt->errorInfo()[2];
    }
} else {
    echo "Invalid announcement ID.";
}
