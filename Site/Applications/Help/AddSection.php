<?php

    require("config.php");
    
    $name = getUnescapedPost("name");
    $displayorder = getUnescapedPost("displayorder");
    $action = getUnescapedPost("action");
    
    if ($action == "Cancel") {
        header("Location: Home.php");
        exit();
    }
    
    if (!$name) {
        trigger_error("Section Name is required", E_USER_ERROR);
    }
    
    $query = "insert into help_section (name, displayorder) values (" .
             $conn->quote($name) . ", " .
             $conn->quote($displayorder) . ")";
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query, E_USER_NOTICE);
        trigger_error($result->getMessage(), E_USER_NOTICE);
        trigger_error("Failed to create new section", E_USER_ERROR);
    }

    header("Location: Home.php");
    
?>
