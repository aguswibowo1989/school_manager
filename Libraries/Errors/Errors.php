<?php
	
	//
	// setup up an error handler that we can use and tweak, and help make error
	// handling in our code easier.
	// 
	set_error_handler("my_error_handler");
	error_reporting($config['errors']['reporting']);
	
	function my_error_screen ($level, $message, $file, $line)
	{
		global $config;
		
		layout_begin();
		layout_display_error($level, $message, $file, $line);
		layout_end();
		exit();
	}
	
	function my_error_log ($level, $message)
	{
		global $config;
        global $error_msgs;
		
		if ($config['errors']['method'] == "bottom") {
			if (! is_array($error_msgs)) {
                $error_msgs = array();
            }
            array_push($error_msgs, "<strong>$level:</strong> $message");
		}
		else {
			trigger_error("log method not implemented -- " . $config['errors']['method'], E_USER_NOTICE);
		}
	}
	
	//
	// Error handling will be done in this function, so we can have a little better control
	// of what is going on, and we can diagnose error a little better and easier.
	//
	function my_error_handler($errno, $errmsg, $filename, $linenum, $vars)
	{
		// timestamp for the error entry
	    $dt = date("Y-m-d H:i:s");
	
	    // define an assoc array of error string in reality the only entries we should
	    // consider are 2,8,256,512 and 1024
	    $errortype = array (
	                E_ERROR				=>  "Error",
	                E_WARNING			=>  "Warning",
	                E_PARSE				=>  "Parsing Error",
	                E_NOTICE			=>  "Notice",
	                E_CORE_ERROR		=>  "Core Error",
	                E_CORE_WARNING  	=>  "Core Warning",
	                E_COMPILE_ERROR		=>  "Compile Error",
	                E_COMPILE_WARNING	=>  "Compile Warning",
	                E_USER_ERROR		=>  "User Error",
	                E_USER_WARNING		=>  "User Warning",
	                E_USER_NOTICE		=>  "User Notice"
	                );
	    // set of errors for which a var trace will be saved
	    $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
	    
	    // Each error will have it's own behavior.  Currently there are three behaviors. 
	    // log, log and print, and log and die.  log will only be seen by administrators.  log
	    // and print will print to the screen and to the log. log and die will stop execution and log.
	    $log = array(E_NOTICE, E_USER_NOTICE);
	    $log_and_print = array(E_WARNING, E_CORE_WARNING, E_COMPILE_WARNING, E_USER_WARNING);
	    $log_and_die = array(E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR);
	    
	    // This is the format of the
	    $err = "<b>$errortype[$errno]</b>: ";
	    $err .= "$errmsg ";
	    $err .= "in $filename ";
	    $err .= "on line $linenum";
	    
	    //if (in_array($errno, $user_errors)) {
	    //    $err .= ":".wddx_serialize_value($vars,"Variables");
	    //}
	    
	    $err .= "\n";
	    	    
	    if (in_array($errno, $log_and_die)) {
     		//error_log($err, 3, "/home/www/logs/error_log");
	    	my_error_log("error", $err);
	    	my_error_screen($errortype[$errno], $errmsg, $filename, $linenum);
	    }
	    
	    elseif (in_array($errno, $log_and_print)) {
	    	//error_log($err, 3, "/home/www/logs/error_log");
	    	my_error_log("warn", $err);
	    	echo "<br>" . $err . "<br>\n";
	    }
	    
	    elseif (in_array($errno, $log)) {
	    	// error_log($err, 3, "/home/www/logs/error_log");
	    	my_error_log("info", $err);
	    }
	    
	    else {
	    	my_error_log("info", $err . " -- There is a wierd error here.");
	    }	   
	}

?>