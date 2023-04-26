<!DOCTYPE html>
<html>
<head>
	<title>Edit About Us Content</title>
</head>
<body>
	<h1>Edit About Us Content</h1>
	<form action="about_update.php" method="post">
		<label for="content">Content:</label><br>
		<textarea id="content" name="content" rows="10" cols="50"><?php echo $content; ?></textarea><br><br>
		<input type="submit" value="Save">
	</form>
</body>
</html>

<?php
// Connect to the database
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the content for the About Us section from the database
$sql = "SELECT content FROM about_us WHERE id = 1"; // assuming you only have one row in the table
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $content = $row["content"];
    }
} else {
    $content = "No content available.";
}

// Close
