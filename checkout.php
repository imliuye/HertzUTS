<?php
session_start();
$carArray = array();
if(isset($_SESSION['cars'])){
    $carArray = $_SESSION['cars'];
}
$phpAmount = 0;
foreach ($carArray as $model=>$detail) {
    if(isset($_GET["$model"])){
        $rent_days = $_GET["$model"];
        $detail['rent_days'] = $rent_days;
        $price = (float)$rent_days * $detail["price_per_day"];
        $phpAmount += $price;
        $carArray["$model"]["rent_days"] = $rent_days;
        $_SESSION['cars'] = $carArray;
    }
}

$purchased = false;
$mailContent = "";
$payDetail = "";
$mailHTML = "";

if(isset($_POST['firstName'])){
    $purchased = true;
    $amount = $_POST['amount'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $payType = $_POST['payType'];
    $cardNumber = $_POST['cardNumber'];
    $cvv = $_POST['cvv'];
    $mailFrom = "12866277@student.uts.edu.au";

    $mailSubject="You have made a purchase of \$".$amount;
    $mailContent .= "Thanks for renting cars from Hertz-UTS, the total cost is $phpAmount \n\n" ;
    $mailContent .= "Details are as follows:\n\n";


    $detailHTML = "<table class=\"table\"><tbody>";
foreach ($carArray as $model=> $detail) {
    $category = $detail["category"];
    $brand = $detail["brand"];
    $model = $detail["model"];
    $model_year = $detail["model_year"];
    $mileage = $detail["mileage"];
    $description = $detail["description"];
    $seats = $detail["seats"];
    $fuel_type = $detail["fuel_type"];
    $price_per_day = $detail["price_per_day"];
    $vehicle = $detail["vehicle"];
    $rent_days = $detail['rent_days'];
    $mailContent .= "Model: $vehicle\n"
        ."mileage: $mileage kms\n"
        ."fuel_type: $fuel_type \n"
        ."seats: $seats \n"
        ."price_per_day: $price_per_day \n"
        ."rent_days: $rent_days \n"
        ."descriptions: $description\n\n";

    foreach ($detail as $key=>$value) {
        $detailHTML .= "<tr><th scope=\"row\">$key</th><td>$value</td></tr>";
    }

    $detailHTML .= "<tr><th></th><td></td></tr>";
}
$detailHTML .= "  </tbody></table>";

//    echo "$mailContent";
//    echo $detailHTML;

    mail($email,$mailSubject,$mailContent);

    $mailHTML=<<<EOF
    
<table class="table">
  <tbody>
    <tr>
      <th scope="row">Purchase Amount</th>
      <td>\$$amount</td>
    </tr>
    <tr>
      <th scope="row">Address</th>
      <td>$address, $city, $state, $zip</td>
    </tr>
    <tr>
      <th scope="row">Payment Type</th>
      <td>$payType</td>
    </tr>
    <tr>
      <th scope="row">Card Number</th>
      <td>$cardNumber</td>
    </tr>
    <tr>
      <th scope="row">CVV</th>
      <td>$cvv</td>
    </tr>
    
  </tbody>
</table>
EOF;

    // clear the session array
    $_SESSION['cars'] = array();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Hertz-UTS</title>
    <script type="text/javascript" src="./scripts/jquery.js"></script>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script type="text/javascript" src="./css/popper.min.js"></script>
    <script type="text/javascript" src="./css/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./css/hertz.css">
    <script type="text/javascript" >
        function addDayCtrl(eventSource) {
            if ( eventSource.value <1) {
                eventSource.value = 1;
            }
        }

    </script>
</head>
<body id="main-body">

<nav class="navbar navbar-light bg-dark">
    <a class="navbar-brand" href="index.php" style="color:white">
        <img src="images/logo.png" height="20" class="d-inline-block align-top" alt="">
        Car Rental Center
    </a>

    <form class="form-inline">
        <button class="btn btn-primary" type="button" onclick="window.parent.location='./'"
                data-toggle="tooltip" data-placement="right" data-html="true"
                title="Click <b>Back</b> to add more products to shopping cart">
            Home
        </button>
    </form>
</nav>
<div class="pay-done" style=' <?php echo $purchased?"":"display:none" ?>'>
    <h3>Thank you for your order.</h3>
    <p>Your payment is being processed and a confirmation email would be sent to you shortly. </p>
    <h5>Payment Detail:</h5>
    <p><?php echo $mailHTML?></p>
    <br>
    <p><?php echo $detailHTML?></p>
</div>



<div class="pay-form" style=' <?php echo $purchased?"display:none":"" ?>'>

    <h2 align="center">Checkout</h2>
    <h5>Customer Details and Payment</h5>
    <p>Please fill in your details. <span class="red-word">*</span> indicates required filed</p>


    <form class="needs-validation" method="post" action="checkout.php" validate >
        <input type="hidden" name="amount" value="<?php echo $phpAmount ?>">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="validationCustom01">First name<span class="red-word">*</span></label>
                <input type="text" class="form-control" id="validationCustom01" name="firstName" placeholder="First name" value="" required>
                <div class="invalid-tooltip">
                    First name must not be empty!
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label for="validationCustom02">Last name<span class="red-word">*</span></label>
                <input type="text" class="form-control" id="validationCustom02" name="lastName" placeholder="Last name" value="" required>
                <div class="invalid-tooltip">
                    Last name must not be empty!
                </div>
            </div>

            <!--        <div class="form-group">-->
            <div class="col-md-5 mb-3">
                <label for="validationCustomEmail">Email<span class="red-word">*</span></label>
                <input type="email" class="form-control" id="validationCustomEmail" aria-describedby="emailHelp" name="email"  value="" placeholder="Enter email address" required>
                <!--            <input type="text" class="form-control" aria-describedby="emailHelp"  id="validationCustomEmail" name="email" placeholder="Email Address" value="" required>-->
                <div class="invalid-tooltip">
                    Please enter a valid email address.
                </div>

            </div>
            <!--        </div>-->

        </div>

        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="validationCustom031">Address<span class="red-word">*</span></label>
                <input type="text" class="form-control" id="validationCustom031" name="address" placeholder="Address" required>
                <div class="invalid-tooltip">
                    Please provide a valid address.
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label for="validationCustom03">City<span class="red-word">*</span></label>
                <input type="text" class="form-control" id="validationCustom03" name="city" placeholder="City" required>
                <div class="invalid-tooltip">
                    Please provide a valid city.
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label for="validationCustom04">State<span class="red-word">*</span></label>
                <input type="text" class="form-control" id="validationCustom04" name="state" placeholder="State" required>
                <div class="invalid-tooltip">
                    Please provide a valid state.
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <label for="validationCustom05">Zip<span class="red-word">*</span></label>
                <input type="number" class="form-control" id="validationCustom05" name="zip" placeholder="Zip" required>
                <div class="invalid-tooltip">
                    Please provide a valid zip.
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group  col-md-4" >
                <label for="validationCustom11">Payment Type<span class="red-word">*</span></label>
                <select id="validationCustom11" class="custom-select" name="payType" required>
                    <option value="">Select a Payment Type</option>
                    <option value="Master Card">Master Card</option>
                    <option value="Visa">Visa</option>
                    <option value="American Express">American Express</option>
                </select>
                <div class="invalid-tooltip">Select a payment type</div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="validationCustom09">Card Number<span class="red-word">*</span></label>
                <input type="number" class="form-control" id="validationCustom09" name="cardNumber" placeholder="Card Number" required>
                <div class="invalid-tooltip">
                    Please provide a valid card number.
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <label for="validationCustom10">CVV<span class="red-word">*</span></label>
                <input type="number" class="form-control" id="validationCustom10" name="cvv" placeholder="CVV" required>
                <div class="invalid-tooltip">
                    Please provide a valid CVV.
                </div>
            </div>
        </div>

        <div align="right">

            <h3 class="pay-title">You are about to make a purchase of $<?php echo $phpAmount ?></h3>
            <button class="btn btn-secondary" type="button" onclick="window.parent.location='./'"
                    data-toggle="tooltip" data-placement="right" data-html="true"
                    title="Click <b>Continue Shopping</b> to add more products to shopping cart">
                Continue Selection
            </button>
            <button class="btn btn-primary" type="submit">Booking</button>
        </div>

    </form>

</div>



</body>