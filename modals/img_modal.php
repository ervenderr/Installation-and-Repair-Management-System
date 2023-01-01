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
    echo '        <div class="carousel slide carousel-example-' . htmlspecialchars($name) . '" id="carousel-example-' . htmlspecialchars($name) . '" data-ride="carousel">';
    echo '          <div class="carousel-indicators">';
    echo '            <button data-target="#carousel-example-' . htmlspecialchars($name) . '" data-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>';
    echo '            <button data-target="#carousel-example-' . htmlspecialchars($name) . '" data-slide-to="1" aria-label="Slide 2"></button>';
    echo '            <button data-target="#carousel-example-' . htmlspecialchars($name) . '" data-slide-to="2" aria-label="Slide 3"></button>';
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
    echo '<a class="carousel-control-prev" href="#carousel-example-' . htmlspecialchars($name) . '" role="button" data-slide="prev">';
    echo '  <span class="carousel-control-prev-icon" aria-hidden="true"></span>';
    echo '  <span class="sr-only">Previous</span>';
    echo '</a>';
    echo '<a class="carousel-control-next" href="#carousel-example-' . htmlspecialchars($name) . '" role="button" data-slide="next">';
    echo '  <span class="carousel-control-next-icon" aria-hidden="true"></span>';
    echo '  <span class="sr-only">Next</span>';
    echo '</a>';
    echo '          </div>';
    echo '        </div>';
    echo '      </div>';
    echo '      <div class="modal-footer">';
    echo '        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
    echo '      </div>';
    echo '    </div>';
    echo '  </div>';
    echo '</div>';
}

// Close the database connection


