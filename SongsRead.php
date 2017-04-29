<!DOCTYPE html>

<?php
//including the database connection file
//include_once("config_local.php");
include_once("config.php");

session_start();
if(empty($_SESSION['email']))
{
 header("location:index.php");
}

echo "Welcome ".$_SESSION['name']; 


 
/*Vi använder pdo objekets metod query och sparar resultatet i $result 
 * (via vår store procedure) Bygga alltid sp där det finns en primarykey id, 
 * även om den inte visas i raden, så måste vi ha en id som referens om vi sen
 * ska redigera eller ta bort en rad.
 */

$result = $pdo->query("call sp_songs");



?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Songs</title>
    </head>
    <body>
<!-- Länk till lägga till nya skämt -->        
        <a href="songsAdd.php">Add New Song to Album</a> &nbsp; | &nbsp;
        <a href="album.php">Add New Album</a>
        <br/><br/>
 
    <table width='80%' border=0>
 
    <tr bgcolor='#CCCCCC'>
        <td>Album Name</td>
        <td>Track #</td>
        <td>Song Name</td>
        <td>Duration</td>
        <td>Update</td>
    </tr>
    <?php
/*
 * vi behöver inte skriva $authorQuery->fetch(FETCH_ASSOC) då vi i vår databas
 * kopplinga redan har angett att det är den metoden vi har satt som default.
 * 
 * Vi fetch så loopar vi genom alla rader från sp och matar in i varje rad i 
 * tabellen.
 * 
 * För varje rad vi får ut, så tar vi reda på id (vår primary key i tabllen) och 
 * sprarar den i varibeln $row. Denna id använder vi sen som basis för att
 * redigera en enskild rad som bär med sig det värdet till edit sidan, eller tar
 * det värde för att radera en ensild rad i tabellen.
*/    
    while($row = $result->fetch()) {         
        echo "<tr>";
        echo "<td>".$row['AlbumName']."</td>";
        echo "<td>".$row['SongTrackNr']."</td>";
        echo "<td>".$row['SongName']."</td>";
        echo "<td>".$row['SongDuration']."</td>";
        echo "<td><a href=\"songsEdit.php?id=$row[SongId]\">Edit</a> | <a href=\"songsDelete.php?id=$row[SongId]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";        
    }
    
    ?>
    <a href="logout.php">Logout</a>
    </table>
    </body>
</html>
