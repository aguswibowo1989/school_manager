<?php

    require_once("config.php");
    
    $resourceid = getUnescapedGET("resourceid");
    $action = getUnescapedGET("action");
    
    $vars = array();
    $vars['resourceid'] = $resourceid;
    
    if (! $resourceid) {
        trigger_error("Resource ID is a require parameter", E_USER_ERROR);
    }
    
    if ($action == "Yes") {
        $resource = get_resource($resourceid);
        $vars['lessonid'] = get_lessonid_from_resourceid($resourceid);
        
        if ($resource['type'] == TYPE_LOCAL_FILE) {
             $file = $config['path']['filestore'] . "/" .
                     substr($resource['md5'], 0, 2) . "/" . 
                     substr($resource['md5'], 2, 2) . "/" . $resource['md5'];
             if (file_exists($file)) {
                if (!unlink($file)) {
                    trigger_error("Failed to delete file", E_USER_ERROR);
                }
             }
        }
        $sql = "delete from resource where id = '$resourceid'";
        $result = $conn->query($sql);
        
        if (DB::isError($result)) {
            trigger_error($sql);
            trigger_error($result->getMessage());
            trigger_error("Cound not delete from resource table" , E_USER_ERROR);
        }
        $sql = "delete from lesson_resource where resourceid = '$resourceid'";
        $result = $conn->query($sql);
        
        if (DB::isError($result)) {
            trigger_error($sql);
            trigger_error($result->getMessage());
            trigger_error("Could not delete from lesson_resource table" , E_USER_ERROR);
        }

        header("Location:  ViewResources.php?" . http_build_simple_query($vars));
    }
    elseif ($action == "No") {
        $vars['lessonid'] = get_lessonid_from_resourceid($resourceid);
        header("Location:  ViewResources.php?" . http_build_simple_query($vars));
    }
    else {
        $resource = get_resource($resourceid);
        layout_display_dialog("Are you sure you want to delete the resource named '{$resource['name']}'?", "YesNo", $vars);
    }
 
?>
