<?php

    require_once("config.php");
    
    $resourceid = getUnescapedGET("resourceid");
    $levelid = getUnescapedGET("levelid");
    $subjectid = getUnescapedGET("subjectid");
    $topicid = getUnescapedGET("topic");
    $action = getUnescapedGET("action");
    
    $vars = array();
    $vars['levelid'] = $levelid;
    $vars['subjectid'] = $subjectid;
    $vars['topicid'] = $topicid;
    $vars['resourceid'] = $resourceid;
    
    if (! $resourceid) {
        trigger_error("Resource ID is a require parameter", E_USER_ERROR);
    }
    
    header("Location:  ViewResources.php?" . http_build_simple_query($vars));
   
?>
