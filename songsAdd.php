<?php
//include_once("config_local.php");
include_once("config.php");

/*
 * Vi organiserar sidan på sån sätt att vi har all processkod här i toppen av
 * sidan. All information som vi behöver processa hämtas från den nedre delen
 * av sidan där html formuläret finns.
 * Där finns namnen på formulärfälten som vi använder i php koden här upp för 
 * att processas.
*/

session_start();
if(empty($_SESSION['email']))
{
 header("location:index.php");
}

echo "Welcome ".$_SESSION['name']."<br>";

if(isset($_POST['Submit'])) {    
    $SongTrackNr = $_POST['SongTrackNr'];
    $SongName = $_POST['SongName'];
    $SongDuration = $_POST['SongDuration'];
    $AlbumId = $_POST['AlbumId'];
        
    // checking empty fields
    if(empty($SongTrackNr) || empty($SongName) || empty($SongDuration)) {
                
        if(empty($SongTrackNr)) {
            echo "<font color='red'>Track# field is empty.</font><br/>";
        }
        
        if(empty($SongName)) {
            echo "<font color='red'>Song name field is empty.</font><br/>";
        }
        
        if(empty($SongDuration)) {
            echo "<font color='red'>Song duration field is empty.</font><br/>";
        }
        
        //link to the previous page
        echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
    } else { 
        // if all the fields are filled (not empty)
            
        //insert data to database        
        $sql = "INSERT INTO Songs(SongTrackNr, SongName, SongDuration, AlbumId) VALUES(:SongTrackNr, :SongName, :SongDuration, :AlbumId)";
        $query = $pdo->prepare($sql);
                
        $query->bindparam(':SongTrackNr', $SongTrackNr);
        $query->bindparam(':SongName', $SongName);
        $query->bindparam(':SongDuration', $SongDuration);
        $query->bindparam(':AlbumId', $AlbumId);
        $query->execute();
        
        // Alternative to above bindparam and execute
        // $query->execute(array(':joketext' => $joketext, ':authorId' => $planeMakerId));
        
        //display success message
        echo "<font color='green'>Data added successfully.";
        echo "<br/><a href='SongsRead.php'>View Result</a>";
    }
}

/*
 * För att inte användaren ska behöva skriva siffror för en authorid, så vill vi
 * skapa en dropdown så att användare kan välja från namnlista från databasen
 * som ladda i en dropdown.
 * Nedanståend sql fråga är basen för den dropdown
*/
$AlbumSql = "SELECT * FROM Album"; 
$AlbumQuery = $pdo->prepare($AlbumSql); 
$AlbumQuery->execute(); 
        
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Songs</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <a href="SongsRead.php">Home</a>
    <br/><br/>

    <form action="songsAdd.php" method="post" name="form1">
        <table width="25%" border="0">
            <tr> 
                <td>Album data</td>
<!-- Här lägger vi till det nya flygplanet -->                
                <td><input type="text" name="SongTrackNr" placeholder="song track nr"></td>
                <td><input type="text" name="SongName" placeholder="song name"></td>
                <td><input type="text" name="SongDuration" placeholder="song length"></td>
            </tr>
            
            <tr> 
<td>Maker</td> 
<td>

<!-- Vi skapar en dropdown som laddas med författare från databasen, så att inte
användare inte lägger till författare som inte existerar-->    
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
        <td></td>
            <td><input type="submit" name="Submit" value="Add"></td>
            </tr>
        </table>
    </form>
    <a href="logout.php">Logout</a>
    </body>
</html>


