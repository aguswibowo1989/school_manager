<?php
	require("DB.php");

	if ($config['sql']['phptype'] == "pgsql") {
		include ("PgSQL.php");
	}
    elseif ($config['sql']['phptype'] == "mysql") {
        include ("MySQL.php");
    }
	else {
		die("Database Not Supported");
	}
	
	// connect to the database
	db_connect(false);
	
	function build_dsn ()
	{
		global $config;
		
		// create dsn
		if ("unix" == $config['sql']['protocol']) {
			return $config['sql']['phptype'] . "://" .
				   $config['sql']['username'] . ":" .
				   $config['sql']['password'] . "@" .
				   $config['sql']['protocol'] . "(" .
				   $config['sql']['hostspec'] . ")/" .
				   $config['sql']['database'];
		}
		else {
			return $config['sql']['phptype'] . "://" .
				   $config['sql']['username'] . ":" .
				   $config['sql']['password'] . "@" .
				   $config['sql']['hostspec'] . "/" .
				   $config['sql']['database'];
		}
	}
?>
