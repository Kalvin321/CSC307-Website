<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Games</title>
</head>

<link rel="stylesheet" type="text/css" href="master.css" media="screen" />
<body>
<?php 




session_start();

$db = pg_connect('host=dbsrv1 dbname=csc309g7 user=csc309g7 password=aiboid4p');


if($db)
{

	

	
	if($_POST['create_game'])
	{
		
		
		
		$game_title = $_POST['game_title'];
		$sport_select = $_POST['sport_select'];
		$start_date = $_POST['start_date'];
		$start_time = $_POST['start_time'];
		$location_select = $_POST['location_select'];
		$myuserid = $_POST['myuserid'];
		
		
		$createGame_Query="insert into games values(default, ".$sport_select . ", ".$myuserid.",'".$start_date."','".$start_time."',".$location_select.",'".$game_title."')";
		$createGame_result = pg_query($createGame_Query);
		
		
		
		echo "<form action='Game.php' method='POST'>
		<table>
			<tr><td>";
		//echo $createGame_result;
		
		if($createGame_result)
		{
		
			echo "<label>Your game was created successfully!</label>\n";
		}
		else
		{
			echo "<label>Failed</label>\n";
		}
			
		
		
		echo "</td></tr>
		<tr><td><input type='submit' Value='Return to game list'/></td></tr>
		</table>
		</form>";
	
	
	
	
	
	
	}
	else
	{
	
?>

	
	
<fieldset>
	<legend>Events</legend>
	
	<div class="content events">
			
					<dl>						
						<?php 
						
						$myuserid = $_SESSION['userid'];	
						
						$itemsPerPage = 20;
						
						if($_GET['pagenum'])
						{
							$pageNum = $_GET['pagenum'];
							
							$startFrom=($itemsPerPage-1)*$pageNum -1;
						}
						else
						{   $pageNum=1;
							$startFrom=0;
						}
						if($_GET['location_id'])
						{
							$location_id = $_GET['location_id'];
							
							
							$query = "select gameid, sport_name, username, start_date, start_time, location_name, title, location from
								(select * from (select * from games g left join location l on g.location = l.lid where g.location = ".$location_id.") a left join sports s on a.sid = s.sid) b
								left join people p on b.creator = p.userid where start_date > now() order by start_date, start_time, title, sport_name,location,username limit $itemsPerPage offset $startFrom";
							
						}
						else
						{
							$query = "select gameid, sport_name, username, start_date, start_time, location_name, title, location from 
								(select * from (select * from games g left join location l on g.location = l.lid) a left join sports s on a.sid = s.sid) b 
								left join people p on b.creator = p.userid where start_date > now() order by start_date, start_time, title, sport_name,location,username limit $itemsPerPage offset $startFrom";
						}
						
						
						
						
						$result = pg_query($query);
						if (pg_num_rows($result)!=0)
						{
							$ind=1;
	
							while($current_games = pg_fetch_assoc($result))
							{
								
								
								if($ind%2==0)
									$background = "";
								else 
									$background = "alt";
								
							
								echo "<dt class='".$background."'><strong>"   .  date("l", strtotime($current_games['start_date']))   . "  </strong>" . date("M d", strtotime($current_games['start_date']));
								
								if($_GET['action'] && $_GET['gameid'])
								{
									$action = $_GET['action'];
									$gameid  = $_GET['gameid'];
									if($gameid == $current_games['gameid'])
									{
										if($action == 'join')
										{
											$action='quit';
											$action_image='quit.gif';									
											$width="16";
											$height="14";				
											$join_query = "insert into usergame values(". $myuserid . " , " . $current_games['gameid'].", 'default')";									
											pg_query($join_query);
											
											
										}
										else
										{
											$action='join';
											$action_image='join.png';
											$width="33";
											$height="20";
											$delete_query = "delete from usergame where gameid = ".$current_games['gameid']." and userid = ". $myuserid;									
											pg_query($delete_query);
											
											
										}
										
										echo "<a  class='btn save' href='Game.php?action=" . $action . "&gameid=".$current_games['gameid']."' ><img src='".$action_image."' alt='Join this game' width='". $width."' height='".$height."' border='0'></a>
											</dt>";
									}							
									else
									{
										$usergame_query = "select * from usergame where gameid = ". $current_games['gameid'] . " and userid=". $myuserid;
										
										$usergame_result = pg_query($usergame_query);
										if (pg_num_rows($usergame_result) != 0)
										{				
										
											echo "<a  class='btn save' href='Game.php?action=quit&gameid=".$current_games['gameid']."' ><img src='quit.gif' alt='Join this game' width='16' height='14' border='0'></a>
											</dt>";
										}
										else
										{
											
											echo "<a  class='btn save' href='Game.php?action=join&gameid=".$current_games['gameid']."' ><img src='join.png' alt='Join this game' width='33' height='20' border='0'></a>
											</dt>";
										}		
									
									}		
									
								}						
								else
									{
										$usergame_query = "select * from usergame where gameid = ". $current_games['gameid'] . " and userid=". $myuserid;
										
										$usergame_result = pg_query($usergame_query);
										if (pg_num_rows($usergame_result) != 0)
										{				
										
											echo "<a  class='btn save' href='Game.php?action=quit&gameid=".$current_games['gameid']."' ><img src='quit.gif' alt='Join this game' width='16' height='14' border='0'></a>
											</dt>";
										}
										else
										{
											
											echo "<a  class='btn save' href='Game.php?action=join&gameid=".$current_games['gameid']."' ><img src='join.png' alt='Join this game' width='33' height='20' border='0'></a>
											</dt>";
										}		
									
									}	
									
								
								echo "<dd class='".$background."'>  
									  <h4>" .  $current_games['sport_name']  . ": <a class='event_title' href='gameDetails.php?gameid=".$current_games['gameid']."'>" .  $current_games['title'] ."</a> 									
									  " . $current_games['start_time'] . "						    
										@&nbsp;<a class='locale' href='?location_id=".$current_games['location']."'>" . $current_games['location_name'] ."</a>					              
									</h4>
									<p class='attendees'> Created by <a href='Game.php'>" . $current_games['username'] . "</a> </p>
							</dd>";
								
							$ind++;
							}
							
								?>
								
					</dl>
					<?php 
					
					$pageNum++;
					
					echo "<div class='info'>            
							  <p class='click_for_more'><em><a href='?pagenum=$pageNum'>Next page >> </a></em></p>
						</div>";
						
						echo  "<INPUT TYPE='BUTTON' VALUE='Go Back' ONCLICK=\"window.location='UserMainPage.php'\">";
						echo "<INPUT TYPE='BUTTON' VALUE='Create a game' ONCLICK=\"window.location='createGame.php'\">";
							
							
						}
						else//return 0 rows
						{
							
						
							
						}
					
					
						
					?>
						
						
		</div>
</fieldset>
	
	
<?php
	
	
	
	
	}





}
else
{
	echo "no connection made";
}



?>
</body>
</html>
