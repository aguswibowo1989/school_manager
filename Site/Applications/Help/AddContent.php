<?php

    require("config.php");
    
    $title = getUnescapedPost("title");
    $content = getUnescapedPost("content");
    $displayorder = getUnescapedPost("displayorder");
    $action = getUnescapedPost("action");
    $sectionid = getUnescapedPost("sectionid");
    
    if ($action == "Cancel") {
        header("Location: ViewSection.php?sectionid=$sectionid");
        exit();
    }
    
    if (!$sectionid) {
        trigger_error("Section ID is required", E_USER_ERROR);
    }
    
    if (!$title) {
        trigger_error("Content Title is required", E_USER_ERROR);
    }
    
    if (!$content) {
        trigger_error("Content is required", E_USER_ERROR);
    }
    
    $query = "insert into help_content (title, content, helpsectionid, 
                                        displayorder) values (" .
             $conn->quote($title) . ", " .
             $conn->quote($content) . ", " .
             $conn->quote($sectionid) . ", " .
             $conn->quote($displayorder) . ")";
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query, E_USER_NOTICE);
        trigger_error($result->getMessage(), E_USER_NOTICE);
        trigger_error("Failed to create new content", E_USER_ERROR);
    }

    header("Location: ViewSection.php?sectionid=$sectionid");
    
?>
