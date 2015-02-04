<?php
if($_SERVER['SERVER_NAME'] == "www.mekstudios.com") {

	//$mysqli = new mysqli('localhost', 'my_user', 'my_password', 'my_db');
	$mysqli =  new mysqli("domain.com", "username", "password", "database_name");
	
	if ($mysqli->connect_error) {
			die('Connect Error (' . $mysqli->connect_errno . ') '
							. $mysqli->connect_error);
	}


}