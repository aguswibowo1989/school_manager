<?php

    require("config.php");
    $levelid = getUnescapedPost("levelid");
    
    if (!$level) {
        trigger_error("Level ID is required", E_USER_ERROR);
    }
    else if ($levelid >= 0) {
        header("Location: ChooseSubject.php?levelid=" . urlencode($levelid));
        exit();
    }
    else if ($levelid == -1) {
        trigger_error("Level ID is required", E_USER_ERROR);
    }
    
    layout_begin();
    
?>

<?php
    
    layout_end();
    
?>    