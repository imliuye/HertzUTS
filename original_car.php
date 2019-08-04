<?php

$xmlDoc = new domDocument;
$xmlDoc->load("cars.xml");
$carsNode = $xmlDoc->documentElement;

?>
<?php
foreach ($carsNode->childNodes as $carNode) {
    if ($carNode->nodeName == "car") {
        $id = $carNode->getAttribute("id");
        $category = $carNode->getElementsByTagName("category")->item(0)->nodeValue;
        $availability = $carNode->getElementsByTagName("availability")->item(0)->nodeValue;
        $brand = $carNode->getElementsByTagName("brand")->item(0)->nodeValue;
        $model = $carNode->getElementsByTagName("model")->item(0)->nodeValue;
        $model_year = $carNode->getElementsByTagName("model_year")->item(0)->nodeValue;
        $mileage = $carNode->getElementsByTagName("mileage")->item(0)->nodeValue;
        $fuel_type = $carNode->getElementsByTagName("fuel_type")->item(0)->nodeValue;
        $seats = $carNode->getElementsByTagName("seats")->item(0)->nodeValue;
        $price_per_day = $carNode->getElementsByTagName("price_per_day")->item(0)->nodeValue;
        $description = $carNode->getElementsByTagName("description")->item(0)->nodeValue;

        ?>
        <div class="card" id="card-<?php echo "$id" ?>">
            <img class="card-img-top" src="images/<?php echo $model?>.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title"><?php echo "$brand-$model-$model_year"?></h5>
                <b>Mileage: </b><?php echo $mileage ?> <br>
                <b>Fuel Type: </b><?php echo $fuel_type ?> <br>
                <b>Seats: </b><?php echo $seats ?> <br>
                <b>Price Per Day: </b><?php echo $price_per_day ?> <br>
                <b>Availability: </b><span id="availability-<?php echo "$id" ?>"><?php echo $availability ?></span>

                <p class="card-text">
                    <b>Description: </b>
                    <?php //echo $description ?>
                    <span data-toggle="tooltip" data-placement="top" data-html="true" title="<?php echo $description?>" style="cursor: help">
                        <?php echo substr($description, 0, 27) ?>...
                    </span>
                </p>
                <p>
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit" id="<?php echo $model?>" onclick='addToCart(this)' ">Add to Cart</button>
                </p>
            </div>
        </div>
        <?php
    }

}
?>