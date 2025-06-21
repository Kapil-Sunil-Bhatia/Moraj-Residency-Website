<?php

require_once 'config.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'admin' && $_SESSION['user_role'] !== 'user')) {
    header('Location: logout.php');
    exit();
}
?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<style>
/* Style for form */
body {
    background-color: #FFEAEA;
}
.payment{
      width: 390px;
        padding: 8% 0 0;
        margin: auto;
}
.form input {
  font-family: "Roboto", sans-serif;
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form{
    position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 100px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
}
.form button {
  font-family: "Roboto", sans-serif;
  text-transform: uppercase;
  outline: 0;
  background: #4C0033;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,.form button:active,.form button:focus {
  background: #4C0033;
}
form,
h1,
h3 {
    width: 300px;
    margin: 0 auto;
    text-align: center;
    
}

input[type="text"],
input[type="file"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    box-sizing: border-box;
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

/* Style for QR code placeholder */
img {
    display: block;
    margin: 20px auto;
}
</style>

<div class="payment">
<div class="form">
    <h1>Payment Page</h1>
<br><br>
<form>
    <!--  <label>Enter Your Name</label><br /><br />-->
    <input type="textbox" name="name" id="name" hidden placeholder="Enter Your Name" value="<?php echo $_SESSION['user_name'];?>"/><br /><br />
    <!-- <label>Enter Amount</label><br /><br />-->
    <input type="textbox" name="amt" id="amt" hidden  value="<?php echo $_SESSION['paid_amount']; ?>" placeholder="Enter Amount" /><br /><br />
    
    <button type="button" name="btn" id="btn" value="Pay Now" onclick="pay_now()" />Pay Now</button>
    <button type="button" name="btn" id="btn" value="Pay Now" onclick="window.location.href='bill_payment.php?id=<?php echo $_SESSION['paymentnewid'];?>'" />Back</button>
</form>
</div>
</div>
<script>
function pay_now() {
    var name = jQuery('#name').val();
    var amt = jQuery('#amt').val();

    //jQuery.ajax({
       // type: 'post',
       // url: 'payment_process.php',
        //data: "amt=" + amt + "&name=" + name,
        
            var options = {
                "key": "rzp_test_1234567890", // Enter the Key ID generated from the Dashboard
                "amount": amt * 100,
                "currency": "INR",
                "name": "Moraj Residency",
                "description": "Test Transaction",
                "image": "/img/favicon.png",
                "handler": function(response) {
                    jQuery.ajax({
                        type: 'post',
                        url: 'payment_process.php',
                        data: "amt=" + amt + "&name=" + name + "&payment_id=" + response.razorpay_payment_id,
                        success: function(result) {
                            window.location.href = "bills.php";
                        }
                    });
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        
    //});


}
</script>