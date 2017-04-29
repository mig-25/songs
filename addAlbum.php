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
    $albumName = $_POST['AlbumName'];
        
    // checking empty fields
    if(empty($albumName)) {
                
        if(empty($albumName)) {
            echo "<font color='red'>Album name field is empty.</font><br/>";
        }
        
 
        
        
    } else { 
        // if all the fields are filled (not empty) 
            
        //insert data to database        
        $sql = "INSERT INTO Album(albumName) VALUES(:albumName)";
        $query = $pdo->prepare($sql);
                
        $query->bindparam(':albumName', $albumName);
        $query->execute();
        
        // Alternative to above bindparam and execute
        // $query->execute(array(':joketext' => $joketext, ':authorId' => $planeMakerId));
        
        //display success message
        echo "<font color='green'>Data added successfully.";
        echo "<br/><a href='albumRead.php'>View Result</a>";
    }
}


        
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Albums</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <a href="SongsRead.php">Home</a>&nbsp; | &nbsp;<a href="AlbumName.php">Back</a><br/><br/>
    <br/><br/>

    <form action="addAlbum.php" method="post" name="form1">
        <table width="25%" border="0">
            <tr> 
                <td>Albums</td>
<!-- Här lägger vi till det nya flygplanet -->                
                <td><input type="text" name="AlbumName" placeholder="album name"></td>
                
            </tr>
            
            <tr> 
<td>Maker</td> 
<td>

<!-- Vi skapar en dropdown som laddas med författare från databasen, så att inte
användare inte lägger till författare som inte existerar-->    
 
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


