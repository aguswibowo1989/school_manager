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
    
    $contentid = getUnescapedPOST("contentid");
    $title = getUnescapedPOST("title");
    $displayorder = getUnescapedPOST("displayorder");
    $content = getUnescapedPOST("content");
    $orig_title = getUnescapedPOST("orig_title");
    $orig_displayorder = getUnescapedPOST("orig_displayorder");
    $orig_content = getUnescapedPOST("orig_content");
                
    if (! $title) {
        trigger_error("Content title is required", E_USER_ERROR);
    }
    
    if ($title != $orig_title) {
        $query = "update help_content set title = " . $conn->quote($title) . " where id = " . $conn->quote($contentid);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update help content title." , E_USER_ERROR);
        }
    }
    
   if ($content != $orig_content) {
        $query = "update help_content set content = " . $conn->quote($content) . " where id = " . $conn->quote($contentid);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update help content." , E_USER_ERROR);
        }
    }
    
    if ($displayorder != $orig_displayorder) {
        $query = "update help_content set displayorder = " . $conn->quote($displayorder) . " where id = " . $conn->quote($contentid);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update help content displayorder." , E_USER_ERROR);
        }
    }
    
    
    header("Location:  ViewSection.php?sectionid=" . urlencode($sectionid));
 
?>
