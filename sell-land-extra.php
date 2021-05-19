<?php

    $my_lands_query = "select * from lands where seller_name = '$user_name'";
    $my_lands = mysqli_query($con, $my_lands_query);
?>

<section class="container mt-5" style="max-width: 700px;">
    <h2>All My Previous Lands</h2>
    <div class="row">

    <?php
        while($row = mysqli_fetch_array($my_lands)) {
    ?>
    
    <div class="card col-5 ml-2" style="width: 18rem;">
        <div class="card-body">
        <h5 class="card-title">Land Area: <?php echo $row['land_area'] ?></h5>
        <p class="card-text">Price: <?php echo $row['price'] ?> L.E</p>
        <p class="card-text">Address: <?php echo $row['address'] ?></p>
        <?php 
            if($row['buyer_name'] !== "") {
        ?>
        <p class="card-text">Buyer name: <?php echo $row['buyer_name'] ?></p>
        <p class="card-text">Buyer phone: 0<?php echo $row['buyer_phone'] ?></p>
        <?php  } else { ?>
        <p class="card-text">No Buyer Yet!</p>
        <?php } ?>
        
        </div>
    </div>

    <?php } ?>
    </div>
</section>