<?php

    require_once("config.php");
    
    $vars = array();
    $sectionid = getUnescapedGET("sectionid");
    $action = getUnescapedGET("action");
    
    $vars = array();
    
    if (!$sectionid) {
        trigger_error("Section ID is a require parameter", E_USER_ERROR);
    }
    
    if ($action == "Yes") {
        
        $sql = "delete from help_section where id = '$sectionid'";
        $result = $conn->query($sql);
        
        if (DB::isError($result)) {
            trigger_error($sql);
            trigger_error($result->getMessage());
            trigger_error("Cound not delete from help_section table" , E_USER_ERROR);
        }
        header("Location:  Home.php");
    }
    elseif ($action == "No") {
        header("Location:  ViewSection.php?sectionid=$sectionid");
    }
    else {
        $vars['sectionid'] = getUnescapedGET("sectionid");
        layout_display_dialog("Are you sure you want to delete the help section?", "YesNo", $vars);
    }
 
?>