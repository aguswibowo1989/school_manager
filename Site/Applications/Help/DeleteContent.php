<?php

    require_once("config.php");
    
    $contentid = getUnescapedGET("contentid");
    $sectionid = getUnescapedGET("sectionid");
    $action = getUnescapedGET("action");
    
    $vars = array();
    
    if (! $contentid) {
        trigger_error("Content ID is a require parameter", E_USER_ERROR);
    }
    
    if ($action == "Yes") {
        
        $sql = "delete from help_content where id = '$contentid'";
        $result = $conn->query($sql);
        
        if (DB::isError($result)) {
            trigger_error($sql);
            trigger_error($result->getMessage());
            trigger_error("Cound not delete from help_content table" , E_USER_ERROR);
        }
        header("Location:  ViewSection.php?sectionid=$sectionid");
    }
    elseif ($action == "No") {
        header("Location:  ViewSection.php?sectionid=$sectionid");
    }
    else {
        $vars['contentid'] = $contentid;
        $vars['sectionid'] = $sectionid;
        layout_display_dialog("Are you sure you want to delete the help section?", "YesNo", $vars);
    }
 
?>