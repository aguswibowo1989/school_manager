<?php

	global $config;
	$config['local']['name'] = "Assessment";
	$config['local']['home'] = "../../";
		
	require_once("{$config['local']['home']}../config.php");
    require_once("Errors/Errors.php");
	require_once("Database/Connection.php");
	require_once("Auth/Session.php");
    require_once("Escape/Escape.php");
	require_once("HTTP/Parameter.php");
	require_once("Layout/Layout.php");

 	// Local configuration (Local means this application)
	$config['local']['login'] = "{$config['local']['home']}index.php";
	$config['local']['images'] = $config['path']['images'];
	$config['local']['style'] = $config['path']['style'];
	$config['local']['js'] = $config['path']['js'];
    $config['local']['title'] = $config['local']['name'];
    
    $config['local']['user'] = my_session_query(session_id()); 

?>
