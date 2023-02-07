<?php

// Connect to the database
require_once '../homeIncludes/dbconfig.php';

// Query the database for all products
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

// Loop through each product
while ($row = mysqli_fetch_assoc($result)) {
    // Get the product information
    $name = $row['name'];
    $price = $row['price'];
    $description = $row['description'];
    $full_description = $row['full_descriptions'];
    $features = $row['features'];
    $image1 = $row['img1'];
    $image2 = $row['img2'];
    $image3 = $row['img3'];


    // Modal
    echo '<div class="modal fade" id="img-modal-' . htmlspecialchars($name) . '" tabindex="-1" role="dialog" aria-labelledby="img-modal-' . htmlspecialchars($name) . '" aria-hidden="true">';    echo '<div class="modal-dialog modal-xl">';
    echo '<div class="modal-content">';
    echo '<div class="modal-header">';
    echo '<h5 class="modal-title" id="product-modal-' . $name . '-label">' . $name . '</h5>';
    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '<span aria-hidden="true">&times;</span>';
    echo '</button>';
    echo '</div>';
    echo '<div class="productt">';
    echo '    <div class="img-container">';
    echo '        <img class="img-responsive img-responsive-main" id="imgBox-' . htmlspecialchars($name) . '-1" src="data:image/jpeg;base64,' . base64_encode($image1) . '" alt="">';
    echo '    <div class="product-small-img">';
    echo '        <img class="img-responsive" src="data:image/jpeg;base64,' . base64_encode($image1) . '" alt="" onclick="myFunction(this,\'imgBox-' . htmlspecialchars($name) . '-1\')">';
    echo '        <img class="img-responsive" src="data:image/jpeg;base64,' . base64_encode($image2) . '" alt="" onclick="myFunction(this,\'imgBox-' . htmlspecialchars($name) . '-1\')">';
    echo '        <img class="img-responsive" src="data:image/jpeg;base64,' . base64_encode($image3) . '" alt="" onclick="myFunction(this,\'imgBox-' . htmlspecialchars($name) . '-1\')">';
    echo '    </div>';
    echo '    </div>';
    
      // Navbar
  echo '<nav class="m-nav navbar navbar-expand-sm navbar-light bg-light">';
  echo '<div class="m-collapses collapses navbar-collapse" id="navbarNav">';
  echo '<ul class="nav nav-tabs" id="myTab" role="tablist">';
  echo '<li class="nav-item">';
  echo '<a class="nav-link active" id="overview-tab-' . $name . '" data-toggle="tab" href="#overview-' . $name . '" role="tab" aria-controls="overview" aria-selected="true">Overview</a>';
  echo '</li>';
  echo '<li class="nav-item">';
  echo '<a class="nav-link" id="specification-tab-' . $name . '" data-toggle="tab" href="#specification-' . $name . '" role="tab" aria-controls="specification" aria-selected="false">Specification</a>';
  echo '</li>';
  echo '</ul>';
  echo '</div>';
  echo '</nav>';
    // Modal body content
    echo '<div class="tab-content" id="myTabContent">';
    // Overview tab
    echo '<div class="tab-pane fade show active" id="overview-' . $name . '" role="tabpanel" aria-labelledby="overview-tab-' . $name . '">';
    echo '<h4>'  . $description .  '</h4>';
    echo '<div class="product-price">₱ ' . $price . '</div>';
    //Convert the full_description string to an array
    $full_description_array = explode("\n", $full_description);
    //oop through the array and output each item as a list item
    echo '<ul>';
    foreach ($full_description_array as $descriptionss) {
        echo '<li>' . $descriptionss . '</li>';
    }
    echo '</ul>';
    echo '</div>';
    // Specification tab
    echo '<div class="tab-pane fade" id="specification-' . $name . '" role="tabpanel" aria-labelledby="specification-tab-' . $name . '">';
    echo '<h4>Specification</h4>';
    //Convert the features string to an array
    $features_array = explode("\n", $features);
    //oop through the array and output each item as a list item
    echo '<ul>';
    foreach ($features_array as $feature) {
        echo '<li>' . $feature . '</li>';
    }
    echo '</ul>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    
    echo '<div class="modal-footer">';
    echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
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