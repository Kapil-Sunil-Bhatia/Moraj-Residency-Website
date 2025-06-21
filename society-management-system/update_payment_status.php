<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['status']) && isset($_POST['payment_id'])) {
    $status = $_POST['status'];
    $paymentId = $_POST['payment_id'];

    // Update payment status using PDO
    $query = "UPDATE payment SET payment_status = :status WHERE id = :payment_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':payment_id', $paymentId);
    if ($stmt->execute()) {
        echo "Payment status updated successfully";
    } else {
        echo "Error updating payment status";
    }
}
?>