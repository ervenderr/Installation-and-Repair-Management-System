// Connect to the database
<?php
require_once 'homeIncludes/dbconfig.php';

// Query the database for all products
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

// Loop through each product
while ($row = mysqli_fetch_assoc($result)) {
// Get the product information
$name = $row['name'];
$image1 = $row['img1'];
$image2 = $row['img2'];
$image3 = $row['img3'];
}

echo '<div class="container servicecon">';
    echo '<div class="productt">';
        echo ' <div class="product-small-img">';
            echo ' <img src="data:image/jpeg;base64,' . base64_encode($image1) . '" alt=""
                onclick="myFunction(this,\'imgBox1\')">';
            echo ' <img src="data:image/jpeg;base64,' . base64_encode($image2) . '" alt=""
                onclick="myFunction(this,\'imgBox1\')">';
            echo ' <img src="data:image/jpeg;base64,' . base64_encode($image3) . '" alt=""
                onclick="myFunction(this,\'imgBox1\')">';
            echo ' </div>';
        echo ' <div class="img-container">';
            echo ' <img id="imgBox1" src="data:image/jpeg;base64,' . base64_encode($image1) . '" alt="">';
            echo ' </div>';
        echo '</div>';
    echo '</div>';

?>

<script>
    function myFunction(smallImg, imgBoxId) {
        var fullImg = document.getElementById(imgBoxId);
        fullImg.src = smallImg.src;
    }
</script>