<?php

function db_connect($alt) {
	// TODO:  this altconn is a hack, and probaly should use an array of connections
    // or something a little more manageable
    global $config;
	global $conn;
    global $altconn;
    
	
    // connect to database using PEAR::DB
    if (!$alt) {
        $conn = DB::connect(build_dsn());
        if (DB::isError($conn)) {
            trigger_error($conn->getMessage() . "<br>" . $config['sql']['dsn'], E_USER_ERROR);
        }
    }
    else {
        $altconn = DB::connect(build_dsn());
        
        if (DB::isError($altconn)) {
            trigger_error($altconn->getMessage() . "<br>" . $config['sql']['dsn'], E_USER_ERROR);
        }
    }
}

function db_begin_transaction($conn) {
	return $conn->query("begin");
}

function db_rollback_transaction($conn) {
	return $conn->query("rollback");
}

function db_commit_transaction($conn) {
	 return $conn->query("commit");
}

?>
