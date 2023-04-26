<?php
// Connect to the database
require_once '../homeIncludes/dbconfig.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the content for the About Us section from the database
$sql = "SELECT content FROM about_us WHERE id = 1"; // assuming you only have one row in the table
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output the content in an HTML format
    echo "<div class='about-section'>";
    echo "<h1>About Us</h1>";
    while($row = $result->fetch_assoc()) {
        echo "<p>" . $row["content"] . "</p>";
    }
    echo "</div>";
} else {
    echo "No content available.";
}

// Close the database connection
$conn->close();
?>
