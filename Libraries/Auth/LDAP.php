<?php 

	//
	// Check to make sure that we have all of the configuration parameters 
	// that are needed to complete the tasks.
	//
	function check_auth_options($ldap_config)
	{
	
		if (! $ldap_config['host']) {
			trigger_error ("LDAP host not configured.", E_USER_ERROR);
		}
		
		if (! $ldap_config['port']) {
			$ldap_config['port'] = "389";
		}
		
		if (! $ldap_config['basedn']) {
			trigger_error ("LDAP base dn not configured.", E_USER_ERROR);
		}
		
		if (! $ldap_config['username']) {
			trigger_error ("LDAP username attribute not configured.", E_USER_ERROR);
		}
		
		if (! $ldap_config['password']) {
			trigger_error ("LDAP password attribute not configured.", E_USER_ERROR);
		}		
		
		if (! $ldap_config['managerdn']) {
			trigger_error ("LDAP manager dn not configured.", E_USER_ERROR);
		}
		
		if (! $ldap_config['managerpw']) {
			trigger_error ("LDAP manager password not configured.", E_USER_ERROR);
		}	
	}
	
	//
	// do the user authentication via ldap.  The function will die if there are any issues,
	// and it will return an array of user information if auth succeeds.
	//
	function auth_user_pw_mod($username, $password)
	{
		global $config;
		$return = array();
		check_auth_options($config['auth']);
		
		// Make sure that the arguments exist and are good
		if (! $username) {
			trigger_error("Username is required", E_USER_ERROR);
		}
		
		if (! $password) {
			trigger_error("Password is required", E_USER_ERROR);
		}
		
		$ds = ldap_connect($config['auth']['host'], $config['auth']['port']);
		
		if (! $ds) { 
			trigger_error("Could not connect to ldap server", E_USER_ERROR);
		}
		
		// bind to it.  We must user Manager to read userPassword field
		if (ldap_bind($ds, $config['auth']['managerdn'], $config['auth']['managerpw'])) {
			$filter = $config['auth']['username'] . "=" . $username;
	        $sr = ldap_search ($ds, $config['auth']['basedn'], $filter, array("cn", "uid", "userPassword"));
	        
	        if (!$sr) {
	        	trigger_error("LDAP search failed", E_USER_ERROR);
	        }
	    	$entry = ldap_first_entry($ds, $sr);
	    	
	    	if (!$entry) {
	    		trigger_error("Could not get first entry from search", E_USER_ERROR);
	    	}
	    	
	    	$cn = ldap_get_values($ds, $entry, "cn");
	    	$uid = ldap_get_values($ds, $entry, "uid");
	    	$return['name'] = $cn[0];
	    	$return['uid'] = $uid[0];
	    	$userpassword = ldap_get_values_len($ds, $entry, "userPassword");
	    	
	    	// get last two segments of host name
			if (preg_match('/^\{\w+\}/', $userpassword[0], $matches)) {
				
				$real_pass = substr($userpassword[0], strlen($matches[0]));
		
				if ($real_pass == crypt($password, $real_pass)) {
					return $return;
				}
				else {
					trigger_error("User <i>{$username}</i> did not authenticate", E_USER_ERROR);
				}
			}
			else {
				trigger_error("Malformed userPassword attribute for $username", E_USER_ERROR);
			}
		}
		else {
			trigger_error("Could not bind to ldap server", E_USER_ERROR);
		}
	    ldap_close($ds);	
	}
?>