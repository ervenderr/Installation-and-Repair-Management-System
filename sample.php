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


    // <!-- Modal -->
    echo '<div class="modal fade" id="img-modal-' . htmlspecialchars($name) . '" tabindex="-1" role="dialog" aria-labelledby="img-modal-' . htmlspecialchars($name) . '" aria-hidden="true">';
    echo '  <div class="modal-dialog" role="document">';
    echo '    <div class="modal-content">';
    echo '      <div class="modal-header">';
    echo '        <h5 class="modal-title" id="img-modal-' . htmlspecialchars($name) . '">Modal Title</h5>';
    echo '        <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    echo '          <span aria-hidden="true">&times;</span>';
    echo '        </button>';
    echo '      </div>';
    echo '      <div class="modal-body">';
    echo '        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">';
    echo '          <div class="carousel-indicators">';
    echo '            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
    echo '            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>';
    echo '            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>';
    echo '          </div>';
    echo '          <div class="carousel-inner">';
    echo '            <div class="carousel-item active">';
    echo '              <img src="data:image/jpeg;base64,' . base64_encode($image1) . '" class="d-block w-100" alt="...">';
    echo '            </div>';
    echo '            <div class="carousel-item">';
    echo '              <img src="data:image/jpeg;base64,' . base64_encode($image2) . '" class="d-block w-100" alt="...">';
    echo '            </div>';
    echo '            <div class="carousel-item">';
    echo '              <img src="data:image/jpeg;base64,' . base64_encode($image3) . '" class="d-block w-100" alt="...">';
    echo '            </div>';
    echo '          </div>';
    echo '          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">';
    echo '            <span class="carousel-control-prev-icon" aria-hidden="true"></span>';
    echo '            <span class="visually-hidden">Previous</span>';
    echo '          </button>';
    echo '          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">';
    echo '            <span class="carousel-control-next-icon" aria-hidden="true"></span>';
    echo '<span class="visually-hidden">Next</span>';
    echo '</button>';
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