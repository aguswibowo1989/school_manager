<?php

    // Get the basedir.
    $config_base = dirname(__FILE__) . "/Configuration/";
    
    require_once($config_base . "/Site.php");
    require_once($config_base . "/Path.php");
    require_once($config_base . "/Errors.php");
    require_once($config_base . "/Database.php");
    require_once($config_base . "/Authentication.php");
    require_once($config_base . "/Layout.php");
    require_once($config_base . "/Navigation.php");
    require_once($config_base . "/Session.php");
    require_once($config_base . "/Icons.php");

?>