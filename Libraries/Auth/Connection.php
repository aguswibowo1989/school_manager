<?php 

	//
	// Check to make sure that we have all of the configuration parameters 
	// that are needed to complete the tasks.
	//
	function check_auth_options()
	{
        global $config;
        
		if (! $config['auth']['table']) {
			trigger_error ("Connection auth table not configured.", E_USER_ERROR);
		}
        
        if (! $config['auth']['crypt_type']) {
            trigger_error ("Connection auth crypt_type not configured.", E_USER_ERROR);
        }
		
        if (! $config['auth']['user_col']) {
            trigger_error ("Connection auth user_col not configured.", E_USER_ERROR);
        }
        
        if (! $config['auth']['pass_col']) {
            trigger_error ("Connection auth pass_col not configured.", E_USER_ERROR);
        }
        
        if (! $config['auth']['name_col']) {
            trigger_error ("Connection auth real_col not configured.", E_USER_ERROR);
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
        trigger_error("Authentication Module Incomlete", E_USER_ERROR);
        
        // Make sure that the arguments exist and are good
        if (! $username) {
            trigger_error("Username is required", E_USER_ERROR);
        }
        
        if (! $password) {
            trigger_error("Password is required", E_USER_ERROR);
        }
	}
?>