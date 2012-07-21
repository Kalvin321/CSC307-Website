<?php
session_start();



$db = pg_connect('host=dbsrv1 dbname=csc309g7 user=csc309g7 password=aiboid4p') || die();


function user_login ($username, $password) {

	// to prevent SQL injections
	$username = pg_escape_string($username);

	// See if the username/password combination exist in the table
	$query = "SELECT userid, admin_user FROM people WHERE username = '".$username."' AND password = '".$password."' LIMIT 1";
	$result = pg_query($query);

	// check to see if an entry was returned
	$rows = pg_num_rows($result);
	$data = pg_fetch_assoc($result);

	if ($rows<=0 ) {
		echo "Invalid username/password.  Please try again <br>";
		include("login.php");
		exit();
	} else if ($rows=1){
		// they can login
		///echo "User type: ";
		$_SESSION['userid'] = $data['userid'];
		$_SESSION['type'] = $data['admin_user'];    //NEED WORK ON SETTING THE ADMIN USER TYPE
	} else {
		echo "ERROR";
		include("login.php");
	}
}

function user_logout () {
	if(isset($_SESSION['username'])) {
		unset($_SESSION['userid']);
	}
	if(isset($_SESSION['type'])) {
		unset($_SESSION['type']);
	}
	echo "You have successfully logged out.";
	session_destroy();
}

function authenticate() {
    header('HTTP/1.0 401 Unauthorized');
    echo "You must log-in before accessing this resource\n";
    exit();
}

function authenticate_admin () {
	if(isset($_SESSION['type'])) {
		if ($_SESSION['type'] != 2) {
			header('HTTP/1.0 401 Unauthorized');
    			echo "You must be an administrator to access this resource.\n";
    			exit();			
		}
	} else {
		authenticate();
	}
}

function authenticate_player () {
	if(isset($_SESSION['type'])) {
		if ($_SESSION['type'] != 1) {
			header('HTTP/1.0 401 Unauthorized');
    			echo "You do not have permission to access this resource.\n";
    			exit();			
		}
	} else {
		authenticate();
	}
}

?>