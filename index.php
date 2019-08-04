<?php
session_start();
$carArray = null;
if(!isset($_SESSION['cars'])){
    $carArray = array();
} else {
    $carArray = $_SESSION['cars'];
}

if(isset($_GET['model'])) {

    $id = $_GET['model'];
    $availability = $_GET['availability'];
    /*    $category = $_GET["category"];
        $brand = $_GET["brand"];
        $model = $_GET["model"];
        $model_year = $_GET["model_year"];
        $mileage = $_GET["mileage"];
        $description = $_GET["description"];
        $seats = $_GET["seats"];
        $fuel_type = $_GET["fuel_type"];
        $price_per_day = $_GET["price_per_day"];

        $vehicle = $_GET['vehicle'];
        $price_per_day = $_GET['price_per_day'];
    */
   // $detail = array("vehicle"=>$vehicle, "price_per_day"=>"$price_per_day" );
    $detail = array("category"=>$_GET["category"],
        "availability"=>$_GET["availability"],
        "brand"=>$_GET["brand"],
        "model"=>$_GET["model"],
        "model_year"=>$_GET["model_year"],
        "mileage"=>$_GET["mileage"],
        "description"=>$_GET["description"],
        "seats"=>$_GET["seats"],
        "fuel_type"=>$_GET["fuel_type"],
        "price_per_day"=>$_GET["price_per_day"],
        "vehicle"=>$_GET['vehicle']);

    $carArray["$id"] = $detail;
    if ($availability == "True") {
        $_SESSION['cars'] = $carArray;
    }


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
        //Ajax query xml files

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        function loadDoc() {

        }


        function addToCart(eventSource) {
            let id = eventSource.id;
            let availability = $("#span-"+eventSource.id).html();

            let ajax;
            if (window.XMLHttpRequest) {
                ajax = new XMLHttpRequest();
            }
            else if (window.ActiveXObject)  {
                ajax=new ActiveXObject("Microsoft.XMLHTTP");
            }

            ajax.open("GET", "cars.xml", true);
            ajax.setRequestHeader('Content-Type', 'text/xml');
            ajax.overrideMimeType('application/xml');
            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4 && ajax.status == 200) {
                    let xmlDoc = ajax.responseXML;
                    let carNode = xmlDoc.getElementById(id);
                    let availability = "True";
                    if(carNode){
                        availability = carNode.getElementsByTagName("availability")[0].childNodes[0].nodeValue;
                    } else {
                        availability = document.getElementById("availability-"+id).innerHTML
                        console.log("id is "+"available-"+id)
                        console.log("availability elem is "+ document.getElementById("available-"+id))
                        console.log("availability is"+availability)
                    }

                    // let brand = carNode.getElementsByTagName("brand")[0].childNodes[0].nodeValue;
                    // let model = carNode.getElementsByTagName("model")[0].childNodes[0].nodeValue;
                    // let model_year = carNode.getElementsByTagName("model_year")[0].childNodes[0].nodeValue;
                    // console.log(availability+ brand + model + model_year);
                    if (availability=="False"){
                      alert("Sorry, the car is not available now. Please try other cars.");
                      $("#availability-"+id).html("False")
                        return false
                    } else {
                      $("#availability-"+id).html("True");
                      alert("Add to the cart successfully")
                    }
                }
            };
            ajax.send();
        }

        // 2. Use AJAX to load the XML file “cars.xml” and extract the data and save it as arrays in your webpage.
        let carObj = [];
        $(document).ready(function(){
            let ajax;
            if (window.XMLHttpRequest) {
                ajax = new XMLHttpRequest();
            }
            else if (window.ActiveXObject)  {
                ajax=new ActiveXObject("Microsoft.XMLHTTP");
            }

            ajax.open("GET", "cars.xml", true);
            ajax.setRequestHeader('Content-Type', 'text/xml');
            ajax.overrideMimeType('application/xml');
            ajax.onreadystatechange = function() {
                if (ajax.readyState === 4 && ajax.status === 200) {
                    let xmlDoc = ajax.responseXML;
                    let cars = xmlDoc.getElementsByTagName("car");

                    for (let key in cars) {
                        let carNode = cars[key];
                        if (!carNode.getElementsByTagName){
                            continue
                        }

                        //console.log(carNode);
                        let id = carNode.getElementsByTagName("model")[0].childNodes[0].nodeValue;
                        let category = carNode.getElementsByTagName("category")[0].childNodes[0].nodeValue;
                        let availability = carNode.getElementsByTagName("availability")[0].childNodes[0].nodeValue;
                        let brand = carNode.getElementsByTagName("brand")[0].childNodes[0].nodeValue;
                        let model = carNode.getElementsByTagName("model")[0].childNodes[0].nodeValue;
                        let model_year = carNode.getElementsByTagName("model_year")[0].childNodes[0].nodeValue;
                        let mileage = carNode.getElementsByTagName("mileage")[0].childNodes[0].nodeValue;
                        let description = carNode.getElementsByTagName("description")[0].childNodes[0].nodeValue;
                        let seats = carNode.getElementsByTagName("seats")[0].childNodes[0].nodeValue;
                        let fuel_type = carNode.getElementsByTagName("fuel_type")[0].childNodes[0].nodeValue;
                        let price_per_day = carNode.getElementsByTagName("price_per_day")[0].childNodes[0].nodeValue;

                        let html = '        <div class="card" id="card-' + id + '">\n' +
                            '            <img class="card-img-top" src="images/' + model + '.jpg" alt="Card image cap">\n' +
                            '            <div class="card-body">\n' +
                            '                <h5 class="card-title">' + brand + '-' + model + '-' + model_year + '</h5>\n' +
                            '                <b>Mileage: </b>' + mileage  + ' <br>\n' +
                            '                <b>Fuel Type: </b>' + fuel_type  + ' <br>\n' +
                            '                <b>Seats: </b>' + seats  + ' <br>\n' +
                            '                <b>Price Per Day: </b>' + price_per_day  + ' <br>\n' +
                            '                <b>Availability: </b><span id="availability-' +  id  + '">' + availability  + '</span>\n' + '\n' +
                            '                <p class="card-text">\n' +
                            '                    <b>Description: </b>\n' +
                            '                    <span data-toggle="tooltip" data-placement="top" data-html="true" title="' + description + '" style="cursor: help">\n' +
                            '                        ' +  description.substr(0,27)  + '...\n' +
                            '                    </span>\n' +
                            '                </p>\n' +
                            '                <p>\n' +
                            '                    <form action="index.php?id='+ id +'" id="' + model + '" onsubmit="addToCart(this)" >\n' +
                            '                        <input type="hidden" name="category" value="'+ category +'">\n' +
                            '                        <input type="hidden" name="description" value="'+ description +'">\n' +
                            '                        <input type="hidden" name="seats" value="'+ seats +'">\n' +
                            '                        <input type="hidden" name="mileage" value="'+ mileage +'">\n' +
                            '                        <input type="hidden" name="model_year" value="'+ model_year +'">\n' +
                            '                        <input type="hidden" name="fuel_type" value="'+ fuel_type +'">\n' +
                            '                        <input type="hidden" id="available-' + model + '" name="availability" value="'+ availability +'">\n' +
                            '                        <input type="hidden" name="brand" value="'+ brand +'">\n' +
                            '                        <input type="hidden" name="model" value="'+ model +'">\n' +
                            '                        <input type="hidden" name="vehicle" value="' + brand + '-' + model + '-' + model_year + '">\n' +
                            '                        <input type="hidden" name="price_per_day" value="' + price_per_day + '">\n' +
                            '                        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit" >Add to Cart</button>\n' +
                            '                    </input>\n' +
                            '                </p>\n' +
                            '            </div>\n' +
                            '        </div>';
                        $("#card-columns").append(html);
                    }

                }
            };
            ajax.send();

            //Timer to query infinitely the state of the availability of the cars
            setInterval(updateAvailability, 1000)

        });

        function updateAvailability() {



            let ajax;
            if (window.XMLHttpRequest) {
                ajax = new XMLHttpRequest();
            }
            else if (window.ActiveXObject)  {
                ajax=new ActiveXObject("Microsoft.XMLHTTP");
            }

            ajax.open("GET", "cars.xml", true);
            ajax.setRequestHeader('Content-Type', 'text/xml');
            ajax.overrideMimeType('application/xml');
            ajax.onreadystatechange = function() {
                if (ajax.readyState === 4 && ajax.status === 200) {
                    let xmlDoc = ajax.responseXML;
                    let cars = xmlDoc.getElementsByTagName("car");
                    for (let key in cars) {
                        let carNode = cars[key];
                        let id = carNode.id;
                        if(carNode.getElementsByTagName){
                            let availability = carNode.getElementsByTagName("availability")[0].childNodes[0].nodeValue;
                            $("#availability-"+id).html(availability)
                        }
                    }
                }
            };
            ajax.send();
        }


</script>
</head>
<body id="main-body">

<nav class="navbar navbar-light bg-dark">
    <a class="navbar-brand" href="#" style="color:white">
        <img src="images/logo.png" height="20" class="d-inline-block align-top" alt="">
        Car Rental Center
    </a>
    <form action="cart.php" class="form-inline">
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Car Reservation</button>
    </form>
</nav>



<div class="carHolder" style="margin-top: 20px">
    <div class="card-columns" id="card-columns" >
    </div>
</div>

</body>
