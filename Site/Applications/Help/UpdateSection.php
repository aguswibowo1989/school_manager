<?php

    require_once("config.php");
    
    $action = getUnescapedPOST("action");
    $sectionid = getUnescapedPOST("sectionid");
    
    if (! $sectionid) {
        trigger_error("Section ID is required", E_USER_ERROR);
    }
    
    // Handle Cancel Button
    if ($action ==  "Cancel") {
        header("Location:  ViewSection.php?sectionid=" . urlencode($sectionid));
        exit();
    }
    
    $name = getUnescapedPOST("name");
    $displayorder = getUnescapedPOST("displayorder");
    $orig_name = getUnescapedPOST("orig_name");
    $orig_displayorder = getUnescapedPOST("orig_displayorder");
              
    if (! $name) {
        trigger_error("Section name is required", E_USER_ERROR);
    }
    
    if ($name != $orig_name) {
        $query = "update help_section set name = " . $conn->quote($name) . " where id = " . $conn->quote($sectionid);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update section displayorder." , E_USER_ERROR);
        }
    }
    
    if ($displayorder != $orig_displayorder) {
        $query = "update help_section set displayorder = " . $conn->quote($displayorder) . " where id = " . $conn->quote($sectionid);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update section displayorder." , E_USER_ERROR);
        }
    }
    
    
    header("Location:  ViewSection.php?sectionid=" . urlencode($sectionid));
 
?>
