<?php

    require_once("config.php");
    
    $resourceid = getUnescapedGET("resourceid");
    
    if (! $resourceid) {
        trigger_error("Resource ID is a require parameter", E_USER_ERROR);
    }
    
    $resource = get_resource($resourceid);
    
    if ($resource['type'] == TYPE_URL) {
        header("Location:  " . $resource['path']);
        exit();
    }
    else if ($resource['type'] == TYPE_FILE_PATH) {
        header("Location:  file://" . rawurlencode($resource['path']));
        exit();
    }
    else if ($resource['type'] == TYPE_LOCAL_FILE) {
        $file = $config['path']['filestore'] . "/" .
                substr($resource['md5'], 0, 2) . "/" . 
                substr($resource['md5'], 2, 2) . "/" . $resource['md5'];
        
        if (! file_exists($file)) {
            trigger_error("File Not Found ($file)", E_USER_ERROR);
        }
        
        header("Content-type: " . $resource['mimetype']);
        header("Content-Disposition: filename=" . $resource['path']);
        readfile($file);
        exit();
    }
    else {
        header("Location:  ViewResources.php?" . http_build_simple_query($vars));
    }

?>
