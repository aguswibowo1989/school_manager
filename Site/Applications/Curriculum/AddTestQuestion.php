<?php

    require("config.php");
    
    $answer = getUnescapedPost("answer");
    $question = getUnescapedPost("question");
    $lessonid = getUnescapedPost("lessonid");
    
    if (!$lessonid) {
        trigger_error("Lesson ID is required", E_USER_ERROR);
    }
    else if (!$question) {
        trigger_error("Question is required", E_USER_ERROR);
    }
    
    $query = "insert into testbank (question, answer) values (" .
             $conn->quote($question) . ", " .
             $conn->quote($answer) . ")";
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query, E_USER_NOTICE);
        trigger_error($result->getMessage(), E_USER_NOTICE);
        trigger_error("Failed to create test question", E_USER_ERROR);
    }
    
    $testbankid = db_get_insert_id("testbank_id_seq");
    
    $query = "insert into lesson_testbank (lessonid, testbankid) values (" .
             $conn->quote($lessonid) . ", " .
             $conn->quote($testbankid) . ")";
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query, E_USER_NOTICE);
        trigger_error($result->getMessage(), E_USER_NOTICE);
        trigger_error("Failed to create testbank", E_USER_ERROR);
    }

    header("Location: EditTestBank.php?lessonid=" . urlencode($lessonid));
    
?>
