<?php 

	//
	// Check to make sure that we have all of the configuration parameters 
	// that are needed to complete the tasks.
	//
	function check_auth_options()
	{
        global $config;
        
		if (! $config['auth']['redirect']) {
			trigger_error ("Null Auth Redirect not configured.", E_USER_ERROR);
		}
	}
	
	//
	// do the user authentication via ldap.  The function will die if there are any issues,
	// and it will return an array of user information if auth succeeds.
	//
	function auth_user_pw_mod($username, $password)
	{
		$return = array();
        
		check_auth_options();
        
        $return['uid'] = 'Unknown';
        $return['name'] = 'Unknown User';
        return $return;	
	}
?>