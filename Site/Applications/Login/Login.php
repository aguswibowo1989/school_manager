<?php
	
	// declare global variables
	global $config;
	global $conn;
	
	require("config.php");
	
	if (! my_session_confirm(session_id())) {
		// retrieve parameters from POST
		$username = getUnescapedPOST('username');
		$password = getUnescapedPOST('password');
		
		// Authenticate
		auth_user_pw($username, $password);
		$user = my_session_query(session_id());
	}
	else {
		$user = my_session_query(session_id());
	}
	
    if ($_POST['url']) {
        
        if (ereg("Applications\/Login", $_POST['url'])) {
            header("Location: {$config['local']['home']}Applications/Home");
        }
        else {
            header("Location: " . $_POST['url']);
        }
    }
    else {
	   header("Location: {$config['local']['home']}Applications/Home");
    }
?>