<?php

    require_once("config.php");
    
    $action = getUnescapedPOST("action");
    
    $vars = array();
    $vars['levelid'] = getUnescapedPOST("levelid");
    $vars['subjectid'] = getUnescapedPOST("subjectid");
    $vars['topicid'] = getUnescapedPOST("topicid");
    
    $view_resource_param = $vars;
    
    $vars['resourceid'] = getUnescapedPOST("resourceid");
    $vars['name'] = getUnescapedPOST("name");
    $vars['path'] = getUnescapedPOST("path");
    $vars['description'] = getUnescapedPOST("description");
    
    $vars['orig_levelid'] = getUnescapedPOST("orig_levelid");
    $vars['orig_subjectid'] = getUnescapedPOST("orig_subjectid");
    $vars['orig_topicid'] = getUnescapedPOST("orig_topicid");
    $vars['orig_resourceid'] = getUnescapedPOST("orig_resourceid");
    $vars['orig_name'] = getUnescapedPOST("orig_name");
    $vars['orig_path'] = getUnescapedPOST("orig_path");
    $vars['orig_description'] = getUnescapedPOST("orig_description");
    
    if ($action ==  "Cancel") {
        header("Location:  ViewResources.php?" . http_build_simple_query($view_resource_param));
        exit();
    }

    if (! $vars['resourceid']) {
        trigger_error("Resource ID is a require parameter", E_USER_ERROR);
    }
    
    if (! $vars['levelid'] || $vars['levelid'] < 0) {
        trigger_error("Level ID is a require parameter", E_USER_ERROR);
    }
    
    if (! $vars['subjectid'] || $vars['subjectid'] < 0) {
        trigger_error("Subject ID is a require parameter", E_USER_ERROR);
    }
    
    if (! $vars['topicid'] || $vars['topicid'] < 0) {
        trigger_error("Topic ID is a require parameter", E_USER_ERROR);
    }
    
    if ($vars['orig_name'] != $vars['name']) {
        $query = "update resource set name = " . $conn->quote($vars['name']) . " where id = " . $conn->quote($vars['resourceid']);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update resource name." , E_USER_ERROR);
        }
    }
    
    if ($vars['orig_path'] != $vars['path']) {
        $query = "update resource set path = " . $conn->quote($vars['path']) . " where id = " . $conn->quote($vars['resourceid']);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update resource path." , E_USER_ERROR);
        }
    }
    
    if ($vars['orig_description'] != $vars['description']) {
        $query = "update resource set description = " . $conn->quote($vars['description']) . " where id = " . $conn->quote($vars['resourceid']);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update resource description." , E_USER_ERROR);
        }
    }
    
    if ($vars['orig_levelid'] != $vars['levelid']) {
        $query = "update lstr set levelid = " . $conn->quote($vars['levelid']) . 
                 " where resourceid = " . $conn->quote($vars['resourceid']);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update resource level." , E_USER_ERROR);
        }
    }
    
    if ($vars['orig_subjectid'] != $vars['subjectid']) {
        $query = "update lstr set subjectid = " . $conn->quote($vars['subjectid']) . 
                 " where resourceid = " . $conn->quote($vars['resourceid']);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update resource subject." , E_USER_ERROR);
        }
    }
    
    if ($vars['orig_topicid'] != $vars['topicid']) {
        $query = "update lstr set topicid = " . $conn->quote($vars['topicid']) . 
                 " where resourceid = " . $conn->quote($vars['resourceid']);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update resource topic." , E_USER_ERROR);
        }
    }

    header("Location:  ViewResources.php?" . http_build_simple_query($view_resource_param));
 
?>
