<?php

    require_once("config.php");
    
    $testbankid = getUnescapedGET("testbankid");
    $action = getUnescapedGET("action");
    
    $vars = array();
    $vars['testbankid'] = $testbankid;
    
    if (! $testbankid) {
        trigger_error("Test Bank ID is a require parameter", E_USER_ERROR);
    }
    
    if ($action == "Yes") {
        
        $sql = "delete from testbank where id = '$testbankid'";
        $result = $conn->query($sql);
        
        if (DB::isError($result)) {
            trigger_error($sql);
            trigger_error($result->getMessage());
            trigger_error("Cound not delete from testbank table" , E_USER_ERROR);
        }
        $vars['lessonid'] = get_lessonid_from_testbankid($testbankid);
        header("Location:  EditTestBank.php?" . http_build_simple_query($vars));
    }
    elseif ($action == "No") {
        $vars['lessonid'] = get_lessonid_from_testbankid($testbankid);
        header("Location:  EditTestBank.php?" . http_build_simple_query($vars));
    }
    else {
        layout_display_dialog("Are you sure you want to delete the test bank question?", "YesNo", $vars);
    }
 
?>
