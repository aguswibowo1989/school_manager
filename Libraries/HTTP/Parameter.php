<?php

	// returns POST variables in original form
	function getUnescapedPOST ($key) {
        
        if (in_array($key, array_keys($_POST))) {
    	    $value = $_POST[$key];     // $_POST returns slashed string
    	    $value = stripslashes($value);   // unescape back to original form
    	    return $value;
        }
        return "";        
	}
	    
	// function is to remind us $_POST returns slashed strings
	function getEscapedPOST ($key) {
        
        if (in_array($key, array_keys($_POST))) {
	       return $_POST[$key];
        }
        return  "";
	}
	
	// returns GET variables in original form
	function getUnescapedGET ($key) {
        
        if (in_array($key, array_keys($_GET))) {
    	    $value = $_GET[$key];     // $_POST returns slashed string
    	    $value = stripslashes($value);   // unescape back to original form
    	    return $value;
        }
        return "";    
	}
	
	// returns REQUEST variables in original form
	function getUnescapedRequest ($key) {
        
        if (in_array($key, array_keys($_REQUEST))) {
    	    $value = $_REQUEST[$key];     // $_POST returns slashed string
    	    $value = stripslashes($value);   // unescape back to original form
    	    return $value;
        }
        return "";          
	}
	    
	// function is to remind us $_GET returns slashed strings
	function getEscapedGET ($key) {
        
        if (in_array($key, array_keys($_GET))) {
	       return $_GET[$key];
        }
        return "";
	}
	
	function update_cookie ($key) 
	{
		
		if (array_key_exists($key, $_GET)) {
			setcookie($key, $_GET[$key]);
			return $_GET[$key];
		}
		
		if (array_key_exists($key, $_POST)) {
			setcookie($key, $_POST[$key]);
			return $_POST[$key];
		}
		
		if (array_key_exists($key, $_COOKIE)) {
			return $_COOKIE[$key];
		}
		
		// default behavior or boxes
		return "";
	}

?>