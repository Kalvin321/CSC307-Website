<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Friends List</title>
</head>
<link rel="stylesheet" type="text/css" href="master.css" media="screen" />
<body>


<fieldset>

<legend>Create a game</legend>

<div class="content creat_game">
<form action="Game.php" method="POST">
	
	<table >
	
<?php 



session_start();

$db = pg_connect('host=dbsrv1 dbname=csc309g7 user=csc309g7 password=aiboid4p');

if($db)
{
	if($_GET['gameid'])
	{
		
	$gameid =$_GET['gameid'];
	
	$getGames_query = "select gameid, sport_name, username, start_date, start_time, location_name, title from 
						(select * from (select * from games g left join location l on g.location = l.lid) a left join sports s on a.sid = s.sid) b 
						left join people p on b.creator = p.userid where gameid = ". $gameid;
	
	$getGames_result = pg_query($getGames_query);
	
	if(pg_num_rows($getGames_result)!=0)
	{
		while($gamedetail = pg_fetch_assoc($getGames_result))
		{
?>

	<tr>
	<td>
		<label>Title: </label>	
	</td>
	<td>
		<label style="font-size:12px;"> <?= $gamedetail['title'] ?> </label>
	</td>
	</tr>
	<tr>
	<td>
		<label>Sports: </label>	
	</td>
	
	<td>
		<label style="font-size:12px;"> <?= $gamedetail['sport_name'] ?> </label>
	</td>
	</tr>
	<tr>
		
	<td>
		<label>Start Date: </label>
	</td>
	<td>	
		<label style="font-size:12px;"> <?= $gamedetail['start_date'] ?> </label>
	</td>
	</tr>
	
	
	<tr>
		<td>Start Time: </td>
		<td><label style="font-size:12px;"> <?= $gamedetail['start_time'] ?> </label></td>
	</tr>
	<tr>
		<td>Location: </td>
		<td>
			<label style="font-size:12px;"> <?= $gamedetail['location_name'] ?> </label>
		</td>
	</tr>
	
<?php 
			}

		}
		else //zero games found for gameid
		{
				echo "<tr><p>No game information found for your request</p></tr>";
		}
	}	
	else // no gameid
	{
		
		echo "Error occur, please return to Game list page";
		
	}
}
?>

<tr>
		<td><input type="submit" value="OK" /></td>	
</tr>

</table>
</form>
</div>		

</fieldset>




</body>
</html>
