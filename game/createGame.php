<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Create Game</title>
</head>
<link rel="stylesheet" type="text/css" href="master.css" media="screen" />
<body>


<fieldset>

<legend>Create a game</legend>

<div class="content creat_game">
	
	
<?php 
 session_start();
$db = pg_connect('host=dbsrv1 dbname=csc309g7 user=csc309g7 password=aiboid4p');


if($db)
{
	

?>
<form action="Game.php" method="POST">
	
	<table >
	<tr>
	<td>
		<label>Title: </label>	
	</td>
	<td>
		<input  size="50" type="text" name="game_title"/>
	</td>
	</tr>
	<tr>
	<td>
		<label>Sports: </label>	
	</td>
	
	<td>
		<select name="sport_select">
		
		<?php  
		
		$myuserid = $_SESSION['userid'];
		
		
		$getSports_query = "select * from sports order by sport_name";
		
		$getSports_result = pg_query($getSports_query);
		
		if($getSports_result)
		{
			while($sportslist = pg_fetch_assoc($getSports_result))
			{	
				echo "<option value='". $sportslist['sid']."'>". $sportslist['sport_name']. "</option>";	
			}
		
		}
		
		?>
			
		</select>
	</td>
	</tr>
	<tr>
		
	<td>
		<label>Start Date: </label>
	</td>
	<td>	
		<input  size="20" type="text" name="start_date"/> e.g: "yyyy-mm-td"
	</td>
	</tr>
	
	
	<tr>
		<td>Start Time: </td>
		<td><input  size="15" type="text" name="start_time"/> e.g: "HH:MM:SS"</td>
	</tr>
	<tr>
		<td>Location: </td>
		<td>
			<select name="location_select">
				<?php  
			
					$getLocation_query = "select * from location order by location_name";
					
					$getLocation_result = pg_query($getLocation_query);
					
					if($getLocation_result)
					{
						while($locationlist = pg_fetch_assoc($getLocation_result))
						{	
							echo "<option value='". $locationlist['lid']."'>". $locationlist['location_name']. "</option>";	
						}
					
					}
				
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td><input type="hidden" value="create" name="create_game"/><input type="hidden" value="<?=$myuserid ?>" name="myuserid"/><input type="submit" value="Done" /></td>	
	</tr>
	
			</table>
</form>

<?php 

}
?>		
</div>					

</fieldset>




</body>
</html>
