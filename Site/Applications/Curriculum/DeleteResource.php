<?php

    require_once("config.php");
    
    $resourceid = getUnescapedGET("resourceid");
    $levelid = getUnescapedGET("levelid");
    $subjectid = getUnescapedGET("subjectid");
    $topicid = getUnescapedGET("topicid");
    $action = getUnescapedGET("action");
    
    $vars = array();
    $vars['levelid'] = $levelid;
    $vars['subjectid'] = $subjectid;
    $vars['topicid'] = $topicid;
    $vars['resourceid'] = $resourceid;
    
    if (! $resourceid) {
        trigger_error("Resource ID is a require parameter", E_USER_ERROR);
    }
    
    if ($action == "Yes") {
        $sql = "delete from resource where id = '$resourceid'";
        $result = $conn->query($sql);
        
        if (DB::isError($result)) {
            trigger_error($sql);
            trigger_error($result->getMessage());
            trigger_error("Cound not delete from resource table" , E_USER_ERROR);
        }
        $sql = "delete from lstr where resourceid = '$resourceid'";
        $result = $conn->query($sql);
        
        if (DB::isError($result)) {
            trigger_error($sql);
            trigger_error($result->getMessage());
            trigger_error("Could not delete from lstr table" , E_USER_ERROR);
        }
        
        header("Location:  ViewResources.php?" . http_build_simple_query($vars));
    }
    elseif ($action == "No") {
        header("Location:  ViewResources.php?" . http_build_simple_query($vars));
    }
    else {
        $resource = get_resource($resourceid);
        layout_display_dialog("Are you sure you want to delete the resource named '{$resource['name']}'?", "YesNo", $vars);
    }
 
?>
