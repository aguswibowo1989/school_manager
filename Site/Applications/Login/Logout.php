<?php
	
	// declare global variables
	global $config;
	global $conn;
	
	// include require libraries
	require("config.php");
	require("Auth/Auth.php");
	
	my_session_destroy(session_id());
	
	header("Location: {$config['local']['login']}");
?>