<?php

	global $config;
	$config['local']['name'] = "Login";
	$config['local']['home'] = "../../";
		
	require_once("{$config['local']['home']}../config.php");
    require_once("Errors/Errors.php");
	require_once("Database/Connection.php");
    require_once("Escape/Escape.php");
	require_once("Auth/Session.php");
    require_once("Auth/Auth.php");
	require_once("HTTP/Parameter.php");
	require_once("Layout/Layout.php");

	$config['local']['login'] = "{$config['local']['home']}Site/index.php";
	$config['local']['images'] = $config['path']['images'];
    $config['local']['common_images'] = $config['path']['images'];
	$config['local']['style'] = $config['path']['style'];
	$config['local']['js'] = $config['path']['js'];
	$config['local']['title'] = $config['local']['name'];
    
    // Exception for NULL Authentication
    if ($config['auth']['type'] == "null") {
        auth_user_pw("", "");
        header("Location: " . $config['local']['home'] . $config['auth']['redirect']);
    }
	
?>