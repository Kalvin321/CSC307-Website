<?php
include("varify_login.php");

// If user is not logged in
if (!isset($_SESSION['username'])) {

	// Check if they came from the login page
	if (isset($_POST['username']) && isset($_POST['password'])) {
		user_login($_POST['username'], $_POST['password']);

	// If not, then redirect them to the login page
	} else {
		echo "You must log-in before accessing this resource";
		include("login.php");
		exit();
	}
}

// If user is logged in, but someone else is logging in on the same
// computer, tell the person to first log out before logging in.
if (isset($_POST['username']) && isset($_SESSION['username'])
	&& ($_POST['username'] != $_SESSION['username'])) {
	die( "You must first logout of your previous session " . $_SESSION['username'] . ". " .
	     "<p> <a href='logout.php'>Logout</a> </p>" .
	     "<p> Or you may return to the <a href='home.php'>Home Page</a>. </p>");
} 

if ($_SESSION['type'] == 2) {
	include("AdminMainPage.php");
} else if ($_SESSION['type'] == 1) {
	include("UserMainPage.php");
}
?>
