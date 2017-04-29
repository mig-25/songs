<?php 
// including the database connection file
include_once("config.php");

session_start();
if(empty($_SESSION['email']))
{
 header("location:index.php");
}

echo "Welcome ".$_SESSION['name']."<br>";

$id = $_GET['id'];


$sql = "SELECT * FROM Album WHERE AlbumId=:AlbumId"; 
$query = $pdo->prepare($sql); 
$query->execute(array(':AlbumId' => $id)); 

while($row = $query->fetch()) 
{ 
$AlbumName = $row['AlbumName'];
$AlbumId = $row['AlbumId']; 
}




?>  
<?php 

if(isset($_POST['update'])) 
{ 
$id = $_POST['id'];  

$AlbumName=$_POST['AlbumName'];
$AlbumId=$_POST['AlbumId']; 



    if(empty($AlbumName)) {
                
        if(empty($AlbumName)) {
            echo "<font color='red'>Album  field is empty.</font><br/>";
        }
        
        
        
    } else{
        $sql = "UPDATE Album SET AlbumName=:AlbumName WHERE AlbumId=:AlbumId";


$query = $pdo->prepare($sql); 

$query->bindparam(':AlbumId', $id); 
$query->bindparam(':AlbumName', $AlbumName);
$query->execute(); 



header("Location: albumRead.php"); 
} 
}   
?> 
<!DOCTYPE html> 

<html> 
<head> 
<meta charset="UTF-8"> 
<title></title> 
</head> 
<body> 
    <a href="SongsRead.php">Home</a>&nbsp; | &nbsp;<a href="albumRead.php">Back</a><br/><br/> 
<br/><br/> 

<form name="form1" method="post" action="editAlbum.php"> 
<table border="0"> 
<tr> 
<td>Edit Albums</td> 

<td><input type="text" name="AlbumName" value="<?php echo $AlbumName;?>"></td>
</tr> 
 
<td>Albums</td> 
<td>
  
 
</td> 
</tr> 

<tr>
  
<td><input type="hidden" name="id" value=<?php echo $_GET['id'];?></td> 
<td><input type="submit" name="update" value="Update"></td> 
</tr> 
</table> 
</form>
<a href="logout.php">Logout</a>
    </body>
</html>


