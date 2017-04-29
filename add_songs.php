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
    $aeroplaneName = $_POST['aeroplane'];
    $aeroplaneTopSpeed = $_POST['speed'];
    $aeroplaneRange = $_POST['range'];
    $planeMakerid = $_POST['planeMakerID'];
        
    // checking empty fields
    if(empty($aeroplaneName) || empty($aeroplaneTopSpeed) || empty($aeroplaneRange)) {
                
        if(empty($aeroplaneName)) {
            echo "<font color='red'>Aeroplane field is empty.</font><br/>";
        }
        
        if(empty($aeroplaneTopSpeed)) {
            echo "<font color='red'>Speed field is empty.</font><br/>";
        }
        
        if(empty($aeroplaneRange)) {
            echo "<font color='red'>Range field is empty.</font><br/>";
        }
        
        //link to the previous page
        echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
    } else { 
        // if all the fields are filled (not empty) 
            
        //insert data to database        
        $sql = "INSERT INTO aeroplane(aeroplaneName, aeroplaneTopSpeed, aeroplaneRange, planeMakerID) VALUES(:aeroplaneName, :aeroplaneTopSpeed, :aeroplaneRange, :planeMakerID)";
        $query = $pdo->prepare($sql);
                
        $query->bindparam(':aeroplaneName', $aeroplaneName);
        $query->bindparam(':aeroplaneTopSpeed', $aeroplaneTopSpeed);
        $query->bindparam(':aeroplaneRange', $aeroplaneRange);
        $query->bindparam(':planeMakerID', $planeMakerid);
        $query->execute();
        
        // Alternative to above bindparam and execute
        // $query->execute(array(':joketext' => $joketext, ':authorId' => $planeMakerId));
        
        //display success message
        echo "<font color='green'>Data added successfully.";
        echo "<br/><a href='aeroplane.php'>View Result</a>";
    }
}

/*
 * För att inte användaren ska behöva skriva siffror för en authorid, så vill vi
 * skapa en dropdown så att användare kan välja från namnlista från databasen
 * som ladda i en dropdown.
 * Nedanståend sql fråga är basen för den dropdown
*/
$planeMakerSql = "SELECT * FROM plane_maker"; 
$planeMakerQuery = $pdo->prepare($planeMakerSql); 
$planeMakerQuery->execute(); 
        
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Aeroplanes</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <a href="aeroplane.php">Home</a>
    <br/><br/>

    <form action="add_form.php" method="post" name="form1">
        <table width="25%" border="0">
            <tr> 
                <td>Aeroplane data</td>
<!-- Här lägger vi till det nya flygplanet -->                
                <td><input type="text" name="aeroplane" placeholder="aeroplane name"></td>
                <td><input type="text" name="speed" placeholder="aeroplane speed"></td>
                <td><input type="text" name="range" placeholder="aeroplane range"></td>
            </tr>
            
            <tr> 
<td>Maker</td> 
<td>

<!-- Vi skapar en dropdown som laddas med författare från databasen, så att inte
användare inte lägger till författare som inte existerar-->    
<select name="planeMakerID"> 
<?php

//$planeMakerID="";
while($planeMaker = $planeMakerQuery->fetch()) { 
if ($planeMaker['planeMakerID'] == $planeMakerID) { 
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
        <td></td>
            <td><input type="submit" name="Submit" value="Add"></td>
            </tr>
        </table>
    </form>
    <a href="logout.php">Logout</a>
    </body>
</html>


