<?php

	// escapes characters for Javascript function parameters
	function jsEscape ($strTarget) {
	    $TICK = "&tick;";
	    $QUOTE = "&quote;";
	    $BACKSLASH = "&bslash;";
	    
	    // escape ticks and quotes
	    $strReturn = str_replace("'", $TICK, $strTarget);
	    $strReturn = str_replace("\"", $QUOTE, $strReturn);
	    $strReturn = str_replace("\\", $BACKSLASH, $strReturn);
	    
	    return $strReturn;
	}
	
?>