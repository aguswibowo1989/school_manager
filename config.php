<?php
    
    // $config needs to be global so other functions can use it.
    global $config;
    
    // Get the basedir.
    $basedir = dirname(__FILE__);
    $homedir = realpath($basedir) . "/";
    
    // Site Configuration
    $config['site']['name'] = "School Manager";
    $config['site']['author'] = "Greg Hewett";
    $config['site']['version'] = "0.0 Alpha";
    
    // Path Configuration
    $config['path']['home']   = $homedir . "/";
    $config['path']['lib']    = $homedir . "Libraries/";
    $config['path']['style']  = $config['local']['home'] . "Style/Default/";
    $config['path']['js']     = $config['local']['home'] . "JavaScript/";
    $config['path']['images'] = $config['local']['home'] . "Images/";
    $config['path']['icons'] = $config['local']['home'] . "Images/Icons/";
    
    // SQL Database Configuration
    $config['sql']['phptype'] = 'mysql';
    $config['sql']['protocol'] = 'tcp';
    $config['sql']['hostspec'] = '127.0.0.1';
    $config['sql']['database'] = 'SchoolManager';
    $config['sql']['username'] = 'webuser';
    $config['sql']['password'] = '7y6t5r6t';
    
    // Error Configuration
    //$config['errors']['reporting'] = E_USER_ERROR | E_USER_WARNING | E_USER_NOTICE;
    $config['errors']['reporting'] = E_ALL;
    $config['errors']['method'] = "bottom";
    
    // Authentication Configuration
    //$config['auth']['type']      = "ldap";
    //$config['auth']['host']      = "ldap.domain.com";
    //$config['auth']['port']      = "389";
    //$config['auth']['basedn']    = "ou=People,dc=domain,dc=com";
    //$config['auth']['username']  = "uid";
    //$config['auth']['password']  = "userPassword";
    //$config['auth']['managerdn'] = "cn=Manager,dc=domain,dc=com";
    //$config['auth']['managerpw'] = "passw0rd";
    
    //$config['auth']['type']      = "conn";
    //$config['auth']['table']     = "user";
    //$config['auth']['crypt_type']= "md5";
    //$config['auth']['user_col']  = "username";
    //$config['auth']['pass_col']  = "password";
    //$config['auth']['name_col']  = "realname";
    
    $config['auth']['type']      = "null";
    $config['auth']['redirect']  = "Applications/Home/";

    // Session Configurations
    $config['session']['timeout'] = 120 * 60; // 2 hours
    $config['session']['table'] = "session";    
       
    // Layout Configurations
    $config['layout']['left_col_width'] = 175;
    $config['layout']['right_col_width'] = 175;
    $config['layout']['buffer_col_width'] = 20;
    $config['layout']['notitle'] = array("Login", "Logout");
    
    // Top Level Navigation Configuration
    $config['navigation']['HOME'] = $config['local']['home'] . "Applications/Home/";
    $config['navigation']['Curriculum'] = $config['local']['home'] . "Applications/Curriculum/";
    $config['navigation']['Assessment'] = $config['local']['home'] . "Applications/Assessment/";
    $config['navigation']['Attendance'] = $config['local']['home'] . "Applications/Attendance/";
    $config['navigation']['Student Portal'] = $config['local']['home'] . "Applications/StudentPortal/";
    $config['navigation']['Help'] = $config['local']['home'] . "Applications/Help/";
    $config['navigation']['Logout'] = $config['local']['home'] . "Applications/Login/Logout.php";
    
    // Icons
    $config['icons']['default'] = $config['path']['icons'] . "default_icon.gif";
    $config['icons']['HOME'] = $config['path']['icons'] . "tb_home.gif";
    $config['icons']['Curriculum'] = $config['path']['icons'] . "tb_book_open.gif";
    $config['icons']['Assessment'] = $config['path']['icons'] . "tb_book_red.gif";
    $config['icons']['Attendance'] = $config['path']['icons'] . "tb_book_blue.gif";
    $config['icons']['Student Portal'] = $config['path']['icons'] . "tb_book_green.gif";
    $config['icons']['Help'] = $config['path']['icons'] . "tb_help.gif";
    $config['icons']['Logout'] = $config['path']['icons'] . "tb_exit.gif";
    $config['icons']['New Resource'] = $config['path']['icons'] . "tb_new.gif";
    $config['icons']['Edit Resource'] = $config['path']['icons'] . "tb_edit.gif";
    $config['icons']['Delete Resource'] = $config['path']['icons'] . "tb_trash.gif";
    $config['icons']['Search'] = $config['path']['icons'] . "tb_search.gif";
    $config['icons']['Import'] = $config['path']['icons'] . "tb_open.gif";
    $config['icons']['Export'] = $config['path']['icons'] . "tb_save.gif";
    
    
    // add the application lib directory, to screens can include the libs they 
    // need.  The reason that this is so complicated is becuase of the differences
    // between windows and unix.
    $separator = '';
    $current_path = ini_get('include_path');

    if (strstr($current_path, ';')) {
        $separator = ';';
    }
    else { 
        $separator = ':';
    }
     
    // set include_path   
    ini_set('include_path', $current_path . $separator . $config['path']['lib']);

?>