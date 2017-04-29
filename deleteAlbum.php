<?php
//including the database connection file
include_once("config.php");
//include_once("config_local.php");
 
//getting id of the data from url
$id = $_GET['id'];
 
//deleting the row from table
$sql = "DELETE FROM Album WHERE AlbumId=:AlbumId";
$query = $pdo->prepare($sql);
$query->execute(array(':AlbumId' => $id));
 
//redirecting to the display page (index.php in our case)
header("Location:albumRead.php");
?>

