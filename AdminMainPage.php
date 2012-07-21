<!DOCTYPE html >
<html>
<head>
<title>Pick-up Master</title>

<link href="styles.css" type="text/css" rel="stylesheet"/>
</head>


<?php session_start();

$db = pg_connect('host=dbsrv1 dbname=csc309g7 user=csc309g7 password=aiboid4p');

$id = $_SESSION['userid'];
$otheruser = false;

if($db) 
{
	
	$query = "select name, email, sport_interested, skill_level from people where userid = $id";
  
  
  $result = pg_query($query);

  if ($result) 
  {
  
    //echo "<img src='.pikachu.jpeg' alt='Join this game' width='16' height='14' border='0'>"
    while($data = pg_fetch_assoc($result))
	{
    
		if(!$otheruser)
		{						
			$username= $data ['name'];
		}
	
	}
	
}

}

?>
    
<body>
    
 <!--********************************************
***************Top Heading of the web format*****
 -********************************************-->
 <div class="header">
 <div id="Logo">
    <p>
        <a href="AdminMainPage.html"><img src="sample.jpg" height="35" width="55"></a> 
        <div class="control">
        <a>Logout</a>   
        <a href="aboutus.html">About us</a>
        </div>
    </p>
 </div>
 </div>
 <hr style="width: 100%; height: 2em; border: 1em solid #288888;"></hr>
  <!--**********************************************
***************End of the Top Heading **************
 -***********************************************-->   
 
  <!--**************************************************
***************Profile Section of the Web***************
 -******************************************************--> 
        <div class="body"> <!-- Class body starts-->
                <div id="profile">		
		<a href="Userprofile.html"> <img src="sample.jpg" height="100" width ="80"></a>
		</div>	
 
		
                <a href="Userprofile.php"><?= $username?></a>
                          
 
                <div id="permission">
                    <a href="Userprofile.php"> Administrator</a>
                </div>
			
 <!--******************************************
***************End of the web format*************
 -********************************************-->
		
		
 <!--*************************************************************************
***************Operation Section: Insert Operations of the web****************
 -**************************************************************************-->			
           
			<div class ="Operations">
                         <p>
                            <ul>
				<li><a href="ManageGames.html"> <img src="sample.jpg" height="60" width ="60"> Manage Games</a></li>
				<li><a href="ManageAccounts.html"> <img src="sample.jpg"height="60" width ="60"> Manage Accounts</a></li>
				<li><a href="SystemReport.html"><img src="sample.jpg"height="60" width ="60"> System Report</a></li>
                            </ul>
                        </p>	
                        </div>
	</div> <!--class body ends-->
 <!--**************************8**********
***************End of Operations********
 -*************************************-->			
		
		
 <!--***************************************
***************Footer of the Web*************
 -*****************************************-->	

<hr style="width: 100%; height: 2em; border: 1em solid #288888;"></hr>
	
<div class="control"> <p> Group:"the magic" @ CSC309 </p>   </div>           

 <!--******************************************
***************End of the web footer **********
 -*******************************************-->


</body>
</html>
