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


$sql = "SELECT * FROM Songs WHERE SongId=:SongId"; 
$query = $pdo->prepare($sql); 
$query->execute(array(':SongId' => $id)); 

while($row = $query->fetch()) 
{ 
$SongTrackNr = $row['SongTrackNr'];
$SongName = $row['SongName'];
$SongDuration = $row['SongDuration'];
$AlbumId = $row['AlbumId']; 
}

$AlbumSql = "SELECT * FROM Album"; 
$AlbumQuery = $pdo->prepare($AlbumSql); 
$AlbumQuery->execute(); 


?>  
<?php 

if(isset($_POST['update'])) 
{ 
$id = $_POST['id'];  

$SongTrackNr=$_POST['SongTrackNr'];
$SongName=$_POST['SongName'];
$SongDuration=$_POST['SongDuration'];
$AlbumId=$_POST['AlbumId']; 



    if(empty($SongTrackNr) || empty($SongName) || empty($SongDuration)) {
                
        if(empty($SongTrackNr)) {
            echo "<font color='red'>Aeroplane field is empty.</font><br/>";
        }
        
        if(empty($SongTrackName)) {
            echo "<font color='red'>Speed field is empty.</font><br/>";
        }
        
        if(empty($SongDuration)) {
            echo "<font color='red'>Range field is empty.</font><br/>";
        }
        
    } else{
        $sql = "UPDATE Songs SET SongTrackNr=:SongTrackNr, SongName=:SongName, SongDuration=:SongDuration, AlbumId=:AlbumId WHERE SongId=:SongId";


$query = $pdo->prepare($sql); 

$query->bindparam(':SongId', $id); 
$query->bindparam(':SongTrackNr', $SongTrackNr);
$query->bindparam(':SongName', $SongName);
$query->bindparam(':SongDuration', $SongDuration);
$query->bindparam(':AlbumId', $AlbumId);
$query->execute(); 



header("Location: SongsRead.php"); 
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
    <a href="SongsRead.php">Home</a> 
<br/><br/> 

<form name="form1" method="post" action="songsEdit.php"> 
<table border="0"> 
<tr> 
<td>Edit Song</td> 

<td><input type="text" name="SongTrackNr" value="<?php echo $SongTrackNr;?>"></td>
<td><input type="text" name="SongName" value="<?php echo $SongName;?>"></td>
<td><input type="text" name="SongDuration" value="<?php echo $SongDuration;?>"></td>
</tr> 
 
<td>Album</td> 
<td>
  
<select name="AlbumId"> 
<?php

//$AlbumId="";
while($Album = $AlbumQuery->fetch()) { 
if ($Album['AlbumId'] == $AlbumId) { 
 
echo "<option value=\"{$Album['AlbumId']}\" selected>{$Album['AlbumName']}</option>"; 
} else { 

echo "<option value=\"{$Album['AlbumId']}\">{$Album['AlbumName']}</option>"; 
} 
} 
?> 
</select>  
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


