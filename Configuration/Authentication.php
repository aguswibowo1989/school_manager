<?php
    
    global $config;

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

?>