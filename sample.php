
<?php

// Connect to the database
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


    // Modal
    echo '<div class="modal fade" id="img-modal-' . htmlspecialchars($name) . '" tabindex="-1" role="dialog" aria-labelledby="img-modal-' . htmlspecialchars($name) . '" aria-hidden="true">';
    echo '<div class="modal-dialog modal-xl" role="document">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    echo '</div>';

    echo '<div class="modal-body">';
    echo '<div class="productt">';
    echo '<div class="productt-flex">';
    echo '    <div class="product-small-img">';
    echo '        <img class="img-responsive" src="data:image/jpeg;base64,' . base64_encode($image1) . '" alt="" onclick="myFunction(this,\'imgBox1\')">';
    echo '        <img class="img-responsive" src="data:image/jpeg;base64,' . base64_encode($image2) . '" alt="" onclick="myFunction(this,\'imgBox1\')">';
    echo '        <img class="img-responsive" src="data:image/jpeg;base64,' . base64_encode($image3) . '" alt="" onclick="myFunction(this,\'imgBox1\')">';
    echo '    </div>';
    echo '    <div class="img-container">';
    echo '        <img class="img-responsive" id="imgBox1" src="data:image/jpeg;base64,' . base64_encode($image1) . '" alt="">';
    echo '    </div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    
    echo '</div>';
    echo '</div>';
    echo '</div>';

    echo '</div>';
}
?>

<script>
    function myFunction(smallImg, imgBoxId) {
        var fullImg = document.getElementById(imgBoxId);
        fullImg.src = smallImg.src;
    }
</script>
</div>

