<?php

	// returns POST variables in original form
	function getUnescapedPOST ($key) {
	    $value = $_POST[$key];     // $_POST returns slashed string
	    $value = stripslashes($value);   // unescape back to original form
	    return $value;           
	}
	    
	// function is to remind us $_POST returns slashed strings
	function getEscapedPOST ($key) {
	    return $_POST[$key];
	}
	
	// returns GET variables in original form
	function getUnescapedGET ($key) {
	    $value = $_GET[$key];     // $_POST returns slashed string
	    $value = stripslashes($value);   // unescape back to original form
	    return $value;           
	}
	
	// returns REQUEST variables in original form
	function getUnescapedRequest ($key) {
	    $value = $_REQUEST[$key];     // $_POST returns slashed string
	    $value = stripslashes($value);   // unescape back to original form
	    return $value;           
	}
	    
	// function is to remind us $_GET returns slashed strings
	function getEscapedGET ($key) {
	    return $_GET[$key];
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