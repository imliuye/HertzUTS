<?php
session_start();
$carArray = array();
if(!isset($_SESSION['cars'])){
//    echo "test: no car";
} else {
    $carArray = $_SESSION['cars'];
//    print_r($carArray);
//    echo "has car";
}

if(isset($_GET['delete'])){
    $itemToDelete = $_GET['delete'];
    unset($carArray["$itemToDelete"]);
//    echo ("<br>after deletion");
//    print_r($carArray);
    $_SESSION['cars'] = $carArray;
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
            console.log(eventSource.value)
            if ( eventSource.value <1) {
                eventSource.value = 1;
            }
        }

        $(document).ready(function(){
            let list = $("#tableBody").children();
            if(list.length === 0 ) {
                alert("No car has been reserved.");
                window.parent.location='./'
            }
        });

    </script>
</head>
<body id="main-body">

<nav class="navbar navbar-light bg-dark">
    <a class="navbar-brand" href="index.php" style="color:white">
        <img src="images/logo.png" height="20" class="d-inline-block align-top" alt="">
        Car Rental Center
    </a>
    <form class="form-inline">
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Car Reservation</button>
    </form>
</nav>

<form action="checkout.php">
<div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">Thumbnail</th>
            <th scope="col">Vehicle</th>
            <th scope="col">Price Per Day</th>
            <th scope="col">Rental Days</th>
            <th scope="col">Actions</th>

        </tr>
        </thead>
        <tbody id="tableBody">
    <?php
    foreach ($carArray as $model=>$car) {
        echo "<tr>";

        $vehicle = $car["vehicle"];
        $price_per_day = $car["price_per_day"];
        ?>
        <td><img alt="" src="images/<?php echo $model?>.jpg" width="60"/></td>
        <td><?php echo $vehicle ?></td>
        <td><?php echo $price_per_day?></td>
        <td>
            <input type="number" class="item-quantity-input spin0" value="1" name="<?php echo $model ?>"  id="day-<?php echo $model?>" onblur="addDayCtrl(this)" placeholder="days" />
        </td>

        <td> <a  id="<?php echo $model ?>" class='btn btn-primary' href="cart.php?delete=<?php echo $model?>" ><span style="color:white">Delete</span></a> </td>
        </tr>
    <?php
    }
    ?>
        </tbody></table>
</div>

<div style="padding-right:20px"  align="right">
        <a class="btn btn-primary my-2 my-sm-0 white-word" onclick="window.parent.location='./'"><span style="color:white">Continue Selection</span></a>
        <input type="submit" class='btn btn-primary white-word' value='Proceed to checkout'>
</div>
</form>

</body>
