<?php

function get_section_name($id) 
{
    global $conn;
    
    if (! is_numeric($id)) {
        return "";
    }
    $qid = $conn->quote($id);
    $query = "select name from help_section where id = $qid";
    $result = $conn->query($query);
    
    if (DB::isError($result)) {
        trigger_error($query, E_USER_NOTICE);
        trigger_error($result->getMessage(), E_USER_NOTICE);
        trigger_error("Failed to retrieve section name", E_USER_ERROR);
    }
    
    if ($row = $result->fetchRow()) {
        return $row[0];
    }
    return "";
}

?>