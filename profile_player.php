<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Games</title>
</head>

<link rel="stylesheet" type="text/css" href="master.css" media="screen" />
<body>
  
  <fieldset><legend>My Profile</legend>
  
  
<?php 
session_start();

$db = pg_connect('host=dbsrv1 dbname=csc309g7 user=csc309g7 password=aiboid4p');

$id = $_SESSION['userid'];
$otheruser = false;

if($db) 
{
	
	if($_GET['viewuserid'])
	{
		$id = $_GET['viewuserid'];
		$otheruser = true;
	}
	
  $query = "select name, email, sport_interested, skill_level from people where userid = $id";
  
  
  $result = pg_query($query);

  if ($result) {
  
    //echo "<img src='.pikachu.jpeg' alt='Join this game' width='16' height='14' border='0'>"
    while($data = pg_fetch_assoc($result))
	{
    
	if(!$otheruser)
	{						
    	echo "<h1> Welcome " . $data ['name'] . "</h1>";
	}
	else
	{
		echo "<h1> username: " . $data ['name'] . "</h1>";
	}
	
    echo "<h4> Email: " . $data['email'] . "</h4>";
    echo "<h4> Sport Interested: " . $data['sport_interested']  . "</h4>";
    echo "<h4> Skill Level: " . $data['skill_level']  . "</h4>";
    
    
    echo "<br/>";
    echo "<label>Operation:</label>\n";
    
    if(!$otheruser)
    {
		 echo "<a href='Game.php'>View Game List</a>\n";
    echo "<a href='createGame.php'>Create a game</a>\n";
    echo "<a href='Friend.php'>View friend list</a>\n";
	}
	else
	{
    	echo "<form action='Friend.php' method='post'><input type='hidden' value='$id' name='addfriend'/><input type='submit' value='Add to friend list'/></form>";
    	echo "<FORM><INPUT TYPE='BUTTON' VALUE='Go Back' ONCLICK='history.go(-1)'></FORM>";
   
   	}
      }
  }

}


      
      
      
?>
    </body>
  </html>
