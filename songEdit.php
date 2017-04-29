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


$sql = "SELECT * FROM aeroplane WHERE aeroplaneID=:aeroplaneID"; 
$query = $pdo->prepare($sql); 
$query->execute(array(':aeroplaneID' => $id)); 

while($row = $query->fetch()) 
{ 
$SongTrackNr = $row['aeroplaneName'];
$aeroplaneTopSpeed = $row['aeroplaneTopSpeed'];
$aeroplaneRange = $row['aeroplaneRange'];
$AlbumId = $row['planeMakerID']; 
}

$planeMakerSql = "SELECT * FROM plane_maker"; 
$planeMakerQuery = $pdo->prepare($planeMakerSql); 
$planeMakerQuery->execute(); 


?>  
<?php 

if(isset($_POST['update'])) 
{ 
$id = $_POST['id'];  

$SongTrackNr=$_POST['aeroplaneName'];
$aeroplaneTopSpeed=$_POST['aeroplaneTopSpeed'];
$aeroplaneRange=$_POST['aeroplaneRange'];
$AlbumId=$_POST['planeMakerID']; 



    if(empty($SongTrackNr) || empty($aeroplaneTopSpeed) || empty($aeroplaneRange)) {
                
        if(empty($SongTrackNr)) {
            echo "<font color='red'>Aeroplane field is empty.</font><br/>";
        }
        
        if(empty($aeroplaneTopSpeed)) {
            echo "<font color='red'>Speed field is empty.</font><br/>";
        }
        
        if(empty($aeroplaneRange)) {
            echo "<font color='red'>Range field is empty.</font><br/>";
        }
        
    } else{
        $sql = "UPDATE aeroplane SET aeroplaneName=:aeroplaneName, aeroplaneTopSpeed=:aeroplaneTopSpeed, aeroplaneRange=:aeroplaneRange, planeMakerID=:planeMakerID WHERE aeroplaneID=:aeroplaneID";


$query = $pdo->prepare($sql); 

$query->bindparam(':aeroplaneID', $id); 
$query->bindparam(':aeroplaneName', $SongTrackNr);
$query->bindparam(':aeroplaneTopSpeed', $aeroplaneTopSpeed);
$query->bindparam(':aeroplaneRange', $aeroplaneRange);
$query->bindparam(':planeMakerID', $AlbumId);
$query->execute(); 



header("Location: aeroplane.php"); 
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
    <a href="aeroplane.php">Home</a> 
<br/><br/> 

<form name="form1" method="post" action="edit.php"> 
<table border="0"> 
<tr> 
<td>Edit aeroplane</td> 

<td><input type="text" name="aeroplaneName" value="<?php echo $SongTrackNr;?>"></td>
<td><input type="text" name="aeroplaneTopSpeed" value="<?php echo $aeroplaneTopSpeed;?>"></td>
<td><input type="text" name="aeroplaneRange" value="<?php echo $aeroplaneRange;?>"></td>
</tr> 
 
<td>Aeroplane maker</td> 
<td>
  
<select name="planeMakerID"> 
<?php

//$planeMakerID="";
while($planeMaker = $planeMakerQuery->fetch()) { 
if ($planeMaker['planeMakerID'] == $AlbumId) { 
//The aeroplane maker is currently associated to the aeroplane, select it by default 
echo "<option value=\"{$planeMaker['planeMakerID']}\" selected>{$planeMaker['planeMakerName']}</option>"; 
} else { 
//The aeroplane maker is not currently associated to the aeroplane 
echo "<option value=\"{$planeMaker['planeMakerID']}\">{$planeMaker['planeMakerName']}</option>"; 
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


