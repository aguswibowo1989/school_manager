<?php
	session_start();
	//echo session_id()."<br>";
	
	// returns a boolean if the session is still valid
	function my_session_confirm($sessionid)
	{
		global $config;
		global $conn;
		$orig_sessionid = $sessionid;
		
		if (!$sessionid) {
			trigger_error("No Session ID available", E_USER_ERROR);
		}
		$sessionid = $conn->quote($sessionid);
        if ($config['auth']['type'] == "null") {
            $sql = "select uid, name from {$config['session']['table']} where " .
                   "id = {$sessionid}";
        }
        else {
    		$sql = "select uid, name from {$config['session']['table']} where " .
    		       "id = {$sessionid} and " .
    		       "timestamp > date_sub(now(), interval {$config['session']['timeout']} second)";
        }
		$result = $conn->query($sql);
		
		if (DB::isError($result)) {
			trigger_error("Could not verify session", E_USER_ERROR);
		}
		
		if (1 == $result->numRows()) {
			return true;
		}
		return false;
	}
	
	// returns array of user data if session is ready
	function my_session_query($sessionid)
	{
		global $config;
		global $conn;
		$orig_sessionid = $sessionid;
		
		if (!$sessionid) {
			trigger_error("No Session ID available", E_USER_ERROR);
		}
        
		$sessionid = $conn->quote($sessionid);
		$sql = "select uid, name from {$config['session']['table']} where " .
		       "id = {$sessionid} and " .
		       "timestamp > date_sub(now(), interval {$config['session']['timeout']} second)";
		$result = $conn->query($sql);
		
		if (DB::isError($result)) {
			trigger_error("Could not verify session.  " . $sql, E_USER_ERROR);
		}
		
		if (1 == $result->numRows()) {
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$result->free();
			my_session_update($orig_sessionid);
			return array("uid" => $row['uid'], "name" => $row['name']);
		}
		else {
			my_session_destroy($orig_sessionid);
			trigger_error("Session has expired", E_USER_NOTICE);
			header("Location: " . $config['local']['login'] . "?url=" . urlencode($_SERVER['REQUEST_URI']));
			die();
		}
	}
	
	function my_session_create($sessionid, $uid, $name)
	{
		global $config;
		global $conn;
		
		if (!$sessionid) {
			trigger_error("No Session ID available", E_USER_ERROR);
		}
		
		if (!$uid) {
			trigger_error("No User ID available", E_USER_ERROR);
		}
		
		if (!$name) {
			trigger_error("No Name available", E_USER_WARNING);
		}
		
		// clean out all previous
        if ($config['auth']['type'] != "null") {
            my_session_clean($uid);
        }
		$sessionid = $conn->quote($sessionid);
		$uid = $conn->quote($uid);
		$name = $conn->quote($name);
		$sql = "replace into {$config['session']['table']} (id, uid, name) values ($sessionid, $uid, $name)";
		$result = $conn->query($sql);
		
		if (DB::isError($result)) {
			trigger_error("Could not insert session into database " . $sql, E_USER_ERROR);
		}
		trigger_error("Created session for {$name}.", E_USER_NOTICE);
	}
	
	function my_session_update($sessionid)
	{
		global $config;
		global $conn;
		
		if (!$sessionid) {
			trigger_error("No Session ID available", E_USER_ERROR);
		}
		$sessionid = $conn->quote($sessionid);
		$sql = "update {$config['session']['table']} set timestamp = now() where id = {$sessionid}";
		$result = $conn->query($sql);
		
		if (DB::isError($result)) {
			trigger_error("Could not update session", E_USER_ERROR);
		}
	}
	
	function my_session_destroy($sessionid)
	{
		global $config;
		global $conn;
		
		if (!$sessionid) {
			trigger_error("No Session ID available", E_USER_ERROR);
		}
		trigger_error("Destroying session {$sessionid}.", E_USER_NOTICE);
		$sessionid = $conn->quote($sessionid);
		$sql = "delete from {$config['session']['table']} where id = $sessionid";
		$result = $conn->query($sql);
		
		if (DB::isError($result)) {
			trigger_error("Could not destroy session", E_USER_ERROR);
		}
	}
	
	function my_session_clean($uid)
	{
		global $config;
		global $conn;
		
		if (!$uid) {
			return;
		}
		trigger_error("Cleaning {$uid}'s session.", E_USER_NOTICE);
		$uid = $conn->quote($uid);
		$sql = "delete from {$config['session']['table']} where uid = $uid";
		$result = $conn->query($sql);
		
		if (DB::isError($result)) {
			trigger_error("Could clean session.", E_USER_WARN);
		}
	}
	
?>