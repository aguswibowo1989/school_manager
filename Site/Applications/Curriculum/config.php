<?php

	global $config;
	$config['local']['name'] = "Curriculum";
	$config['local']['home'] = "../../";
		
	require_once("{$config['local']['home']}../config.php");
    require_once("Layout/Layout.php");
    require_once("Errors/Errors.php");
	require_once("Database/Connection.php");
	require_once("Auth/Session.php");
    require_once("Escape/Escape.php");
	require_once("HTTP/Parameter.php");
    require_once("HTTP/HTTP.php");
    require_once("Applications/Curriculum.php");

 	// Local configuration (Local means this application)
	$config['local']['login'] = "{$config['local']['home']}index.php";
	$config['local']['images'] = $config['path']['images'];
    $config['local']['icons'] = $config['path']['images'] . "Icons/";
	$config['local']['style'] = $config['path']['style'];
	$config['local']['js'] = $config['path']['js'];
    $config['local']['title'] = $config['local']['name'];
    
    $config['local']['user'] = my_session_query(session_id());
    
    $config['local']['navigation']['View Resources'] = "ViewResources.php";
    $config['local']['navigation']['New Resource'] = "ChooseLevel.php";
    //$config['local']['navigation']['Edit Resource'] = "EditResource.php";
    //$config['local']['navigation']['Delete Resource'] = "DeleteResource.php";
    $config['local']['navigation']['Search'] = "Search.php";
    $config['local']['navigation']['Import'] = "Import.php";
    $config['local']['navigation']['Export'] = "Export.php";
    
    $config['local']['display_per_page'] = 5;
    
?>
