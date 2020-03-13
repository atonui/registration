<?php
require 'config.php';
require 'header.php';
//retrieve product data from the db

$sql = "SELECT * FROM `products`";

$products = mysqli_query($conn,$sql);

echo '<div class="container">';
echo '<div class="card-group">';

while ($row = mysqli_fetch_assoc($products)) {
    $id = $row['product_id'];
    $name = $row['name'];
    $description = $row['description'];
    $price = $row['price'];
    $image = $row['image'];


//retrieve images from the images folder
//display the data in cards


    echo '<div class="card" style="width: 18rem;">';
    echo ' <img src="images/'.$image.'" class="card-img-top" alt="...">';
    echo '<div class="card-body">';
    echo ' <h5 class="card-title">'.$name.'</h5>';
    echo '<p class="card-text">'.$description.'</p>';
    echo '<a href="cart.php?id='.$id.'&price='.$price.'" class="btn btn-success">Add to Cart</a>';
    echo '</div>';
    echo '</div>';

}
echo '</div>';
echo '</div>';
require 'footer.php';
?>
