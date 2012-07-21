<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Friends List</title>

<script type="text/javascript">



</script>

</head>


<link rel="stylesheet" type="text/css" href="master.css" media="screen" />
<body>



<fieldset><legend>Friends</legend>

<div class="content friends">
					
					<dl>
						
<?php 



 session_start();


$db = pg_connect('host=dbsrv1 dbname=csc309g7 user=csc309g7 password=aiboid4p');


if($db)
{
	
	$myuserid = $_SESSION['userid'];
	
	if($_GET['friend_action'] && $_GET['friend_id'])
	{
		$action = $_GET['friend_action'];
		$friendid= $_GET['friend_id'];
		
		
		echo "<form action='Friend.php' method='POST'>";
		
		if($action == 'delete')
		{
		
			$deleteFriend_query = "delete from friends where userid=".$myuserid." and friends_with = ".$friendid;
			
			$deleteFriend_result = pg_query($deleteFriend_query);
			
			if (!$deleteFriend_result) 
			{
				echo "<p>An error occured.</p>\n";
				
			}
			else
			{
				echo "<p> Your operation was successful</p>\n ";
			}
			
		}
		else
		{
			
			
			echo "<p>Error occured</p>\n";
		}
		
		
		echo "<input type='submit' value='Return'></form>";
	
	}
	else if($_POST['addfriend'])
	{
		echo "<form action='Friend.php' method='POST'>";
		
				
			$addFriend_query = "insert into friends values(".$myuserid.",".$_POST['addfriend'].")";
			
			$addFriend_result = pg_query($addFriend_query);
			
			if (!$addFriend_result) 
			{
				echo "<p>An error occured.</p>\n";
				
			}
			else
			{
				echo "<p> Your operation was successful</p>\n ";
			}
			
		
		
		
		echo "<input type='submit' value='Return'></form>";
	}
	else 
	{

				
				//friends list
				$getFriends_query = "select p.name, p.userid  from friends f, people p where f.friends_with = p.userid and f.userid = " . $myuserid;
				
				$getFriends_result = pg_query($getFriends_query);
				if ($getFriends_result)
				{

                      $ind=1;
					while($friendslist = pg_fetch_assoc($getFriends_result))
					{
						
						if($ind%2==0)
							$background = "";
						else 
							$background = "alt";
						
						echo "<dt class='".$background."'>							
						<a  class='btn save' href='' ><img src='ani1.jpeg' alt='user1' width='60' height='45' border='0'></a>
						</dt>
					
					
						<dd class='". $background. " delete_btn'><a href='?friend_action=delete&friend_id=".$friendslist['userid']."'><img src='delete-friend.png' alt='Delete friend' width='20' height='20' border='0'></a></dd>
						<dd class='".$background."'>
							<h4>
							<a class='event_title' href='profile_player.php?viewuserid=".$friendslist['userid']."'>" . $friendslist['name'] . "</a>";
							
							$getMostRecentGame_query = "select s.sport_name, l.location_name from games g, location l, sports s where g.sid = s.sid and g.location = l.lid and g.gameid = (select ug1.gameid 
							from usergame ug1, usergame ug2 
							where ug1.gameid = ug2.gameid 
								and ug1.userid = " . $myuserid . " 
								and ug2.userid = " . $friendslist['userid']. " 
								order by ug1.gameid limit 1)";
							
						$getMostRecentGame_result = pg_query($getMostRecentGame_query);
						if (pg_num_rows($getMostRecentGame_result) != 0)
						{
							
							while($mostrecentgame = pg_fetch_assoc($getMostRecentGame_result))
							{
								echo "<span class='last_game'>Most Recent Game:" . $mostrecentgame['sport_name'] . " 
								in " . $mostrecentgame['location_name'] . "</span>";
							}
							
						}
						else
						{
							echo "<span class='last_game'>No games with this user</span>";
						}
						
						echo "</h4>";
						
						$get_participation_query = "select to_char(((
						(select participation from ratings where userid = " . $friendslist['userid']. ")::float/
						(select count(*) from usergame ug where ug.userid = 13)::float)*100), '999.9') as participation_rate";
						
						$get_participation_result = pg_query($get_participation_query);
						if (pg_num_rows(get_participation_result)!=0)
						{
							while($participation = pg_fetch_assoc($get_participation_result))
							{
						
								echo "
								<p class='attendees'> ".$participation['participation_rate']."% Participation, 89% Likes </p>";
							}
						}
						else
						{
							echo"<p class='attendees'>No participation yet</p>";
						}
						
						echo"
						</dd>";
					
					
					 $ind++;
					
					
					}
				
			}
				echo  "<FORM><INPUT TYPE='BUTTON' VALUE='Go Back' ONCLICK=\"window.location='UserMainPage.php'\"></FORM>";
	}
	?>
						
						
							              
				         
			              
							
						
<?php 

}
?>						
						
					</dl>
				
					
				</div>
				
				</fieldset>




</body>
</html>
