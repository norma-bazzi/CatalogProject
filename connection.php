<?php
function connect() {
	$db = new mysqli('localhost','root','','catalog');
	if($db->connect_error){
		echo "error connection";
		exit;
	}
	return $db;
}
?>