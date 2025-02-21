<?php
$servername = getenv("SERVER_NAME");
$username = getenv("DB_USER");
$password = getenv("DB_PASSWORD");
$dbname = getenv("DB_NAME");

$conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Failed to connect to database" . $conn->connect_error);
  } else {
      echo "Conenct successfully";
  }
?>
