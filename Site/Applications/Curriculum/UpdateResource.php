<?php

    require_once("config.php");
    
    $action = getUnescapedPOST("action");
    
    $vars = array();
    $vars['resourceid'] = getUnescapedPOST("resourceid");
    $vars['type'] = getUnescapedPOST("type");
    $vars['name'] = getUnescapedPOST("name");
    $vars['path'] = getUnescapedPOST("path");
    
    $vars['orig_resourceid'] = getUnescapedPOST("orig_resourceid");
    $vars['orig_name'] = getUnescapedPOST("orig_name");
    $vars['orig_path'] = getUnescapedPOST("orig_path");

    if (! $vars['resourceid']) {
        trigger_error("Resource ID is a require parameter", E_USER_ERROR);
    }
    
    if ($action ==  "Cancel") {
        $lessonid = get_lessonid_from_resourceid($vars['resourceid']);
        header("Location:  ViewResources.php?lessonid=" . urlencode($lessonid));
        exit();
    }
    $lessonid = get_lessonid_from_resourceid($vars['resourceid']);
    
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
    
    header("Location:  ViewResources.php?lessonid=" . urlencode($lessonid));
 
?>
