<?php

	function auth_user_pw ($username = "", $password = "")
	{
		global $config;
		
		if ($config['auth']['type'] == "ldap") {
			require("Auth/LDAP.php");
			$user = auth_user_pw_mod($username, $password);
			my_session_create(session_id(), $user['uid'], $user['name']);
		}
        else if ($config['auth']['type'] == "conn") {
            require("Auth/Connection.php");
            $user = auth_user_pw_mod($username, $password);
            my_session_create(session_id(), $user['uid'], $user['name']);
        }
        else if ($config['auth']['type'] == "null") {
            require("Auth/Null.php");
            $user = auth_user_pw_mod($username, $password);
            my_session_create(session_id(), $user['uid'], $user['name']);
        }
		else {
			trigger_error("Authentication type unavailable", E_USER_ERROR);
		}
	}
		
?>