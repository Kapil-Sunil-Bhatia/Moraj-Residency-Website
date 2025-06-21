<?php

?>

<?php
session_start();
include('db.php');
include 'config.php';


if(isset($_POST['amt']) && isset($_POST['name']) && isset($_POST['payment_id'])){
    $amt=$_POST['amt'];
    $name=$_POST['name'];
    $payment_status="pending";
    $added_on=date('Y-m-d h:i:s');
    $paymentnewid=$_SESSION['paymentnewid'];
    mysqli_query($con,"insert into payment(name,amount,payment_status,added_on,bid) values('$name','$amt','$payment_status','$added_on','$paymentnewid')");
    $_SESSION['OID']=mysqli_insert_id($con);
    $payment_id=$_POST['payment_id'];
    mysqli_query($con,"update payment set payment_status='complete',payment_id='$payment_id'  where id='".$_SESSION['OID']."'");
    
$stmt = $pdo->prepare("UPDATE bills SET paid_date = ?, payment_method = ?, paid_amount = ?, remaining_amount = ? WHERE id = ?");
$stmt->execute([$_SESSION['paid_date'], NULL, $_SESSION['paid_amount'], $_SESSION['remaining_balance'], $_SESSION['paymentnewid']]);

$admin_id = $pdo->query("SELECT id FROM users WHERE role = 'admin'")->fetchColumn();

$message = "Bill Payment Done by Flat Number - " . $_SESSION['flat_number'] . " for " . $_SESSION['hidden_bill_title'] . ".";

$notification_link = 'bill_payment.php?id=' . $_SESSION['paymentnewid'] . '&action=notification';
$stmt = $pdo->prepare("INSERT INTO notifications (user_id, notiification_type, event_id, message, link) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$admin_id, 'Bill Payment', $_SESSION['paymentnewid'], $message, $notification_link]);
$_SESSION['success'] = 'Bill Payment has been done';
}

?><button type="button" name="btn" id="btn" value="Pay Now" onclick="window.location.href='bill_payment.php?id=<?php echo $_SESSION['paymentnewid'];?>'" />Back</button>
