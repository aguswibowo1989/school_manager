<?php    
    
    global $config;
    
    // Get the basedir.
    $basedir = dirname(__FILE__);
    $homedir = realpath($basedir . "/..");
    
    // Path Configuration
    $config['path']['home']   = $homedir . "/";
    $config['path']['lib']    = $homedir . "/Libraries/";
    $config['path']['style']  = $config['local']['home'] . "Style/Default/";
    $config['path']['js']     = $config['local']['home'] . "JavaScript/";
    $config['path']['images'] = $config['local']['home'] . "Images/";
    $config['path']['icons'] = $config['local']['home'] . "Images/Icons/";
    
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