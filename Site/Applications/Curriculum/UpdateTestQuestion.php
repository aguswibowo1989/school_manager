<?php

    require_once("config.php");
    
    $action = getUnescapedPOST("action");
    
    $vars = array();
    $vars['testbankid'] = getUnescapedPOST("testbankid");
    $vars['question'] = getUnescapedPOST("question");
    $vars['answer'] = getUnescapedPOST("answer");
    
    $vars['orig_question'] = getUnescapedPOST("orig_question");
    $vars['orig_answer'] = getUnescapedPOST("orig_answer");

    if (! $vars['testbankid']) {
        trigger_error("Test bank ID is a require parameter", E_USER_ERROR);
    }
    
    if ($action ==  "Cancel") {
        $lessonid = get_lessonid_from_testbankid($vars['testbankid']);
        header("Location:  ViewResources.php?lessonid=" . urlencode($lessonid));
        exit();
    }
    $lessonid = get_lessonid_from_testbankid($vars['testbankid']);
    
    if ($vars['orig_answer'] != $vars['answer']) {
        $query = "update testbank set answer = " . $conn->quote($vars['answer']) . " where id = " . $conn->quote($vars['testbankid']);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update resource name." , E_USER_ERROR);
        }
    }
    
    if ($vars['orig_question'] != $vars['question']) {
        $query = "update testbank set question = " . $conn->quote($vars['question']) . " where id = " . $conn->quote($vars['testbankid']);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query);
            trigger_error($result->getMessage());
            trigger_error("Could not update resource path." , E_USER_ERROR);
        }
    }
    
    header("Location:  ViewTestBank.php?lessonid=" . urlencode($lessonid));
 
?>
