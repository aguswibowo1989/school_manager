<?php

    function get_level_navigation ()
    {
        global $conn;
        $return = array();
        
        $query = "SELECT id, name from level";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Could not get levels", E_USER_ERROR);
        }
        
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            $return[$row['name']] = "ViewLevel.php?levelid=" . urlencode($row['id']);
        }
        return $return;
    }
    
    function curriculum_add_answer()
    {
        global $conn;
        
        $table = getUnescapedPost("table");
        $column = getUnescapedPost("column");
        $answer = getUnescapedPost("answer");
        
        if (!$table) {
            trigger_error("table is required", E_USER_ERROR);
        }
        
        if (!$column) {
            trigger_error("column is required", E_USER_ERROR);
        }
        
        if (!$answer) {
            trigger_error("answer is required", E_USER_ERROR);
        }
        $qtable = $conn->quote($table);
        $qcolumn = $conn->quote($column);
        $qanswer = $conn->quote($answer);    
        $query = "insert into $table ($column) values ($qanswer)";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to insert answer", E_USER_ERROR);
        }
        return db_get_insert_id($table, $column);
    }

?>