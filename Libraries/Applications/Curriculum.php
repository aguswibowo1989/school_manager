<?php
   
    define("NO_ANSWER", -1);
    define("NEW_ANSWER", -2);
    define("ADD_ANSWER", -3);
    
    define("TYPE_URL", 1);
    define("TYPE_LOCAL_FILE", 2);
    define("TYPE_FILE_PATH", 3);
    
    function get_level_navigation ()
    {
        global $conn;
        $return = array();
        
        $query = "select level.id as id, level.name as name 
                    from lstul 
                    join level on (id = levelid) 
                   group by id";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Could not get levels", E_USER_ERROR);
        }
        
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            $return[$row['name']] = "ViewLevel.php?levelid=" . urlencode($row['id']);
        }
        return $return;
    }
    
    function curriculum_add_answer($table, $column, $answer)
    {
        global $conn;
        
        if (!$table) {
            trigger_error("table is required", E_USER_ERROR);
        }
        
        if (!$column) {
            trigger_error("column is required", E_USER_ERROR);
        }
        
        if (!$answer) {
            trigger_error("answer is required", E_USER_ERROR);
        }
        
        $tableid = get_id_from_name($table, $column, $answer);
        
        if ($tableid > 0) {
            return $tableid;
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
        return db_get_insert_id($table . "_" . $column . "_seq");
    }

    function get_lessonid_from_resourceid($resourceid) {
        global $conn;
        $query = "select lessonid from lesson_resource where resourceid = " . $conn->quote($resourceid);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to retrieve lessonid", E_USER_ERROR);
        }
        
        if ($row = $result->fetchRow()) {
            return $row[0];
        }
        return -1;
    }
    
    function get_lessonid_from_testbankid($testbankid) {
        global $conn;
        $query = "select lessonid from lesson_testbank where testbankid = " . $conn->quote($testbankid);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to retrieve testbankid", E_USER_ERROR);
        }
        
        if ($row = $result->fetchRow()) {
            return $row[0];
        }
        return -1;
    }
    
    function get_id_from_name($t, $c, $a) {
        global $conn;
        $qanswer = $conn->quote($a);
        $query = "select id from $t where $c = $qanswer";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to retrieve answer", E_USER_ERROR);
        }
        
        if ($row = $result->fetchRow()) {
            return $row[0];
        }
        return -1;
    }
    
    function get_name_from_id($t, $c, $a) {
        global $conn;
        
        if ($a == "" || $a == -1) {
            return "";
        }
        $qanswer = $conn->quote($a);
        $query = "select name from $t where $c = $qanswer";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to retrieve answer", E_USER_ERROR);
        }
        
        if ($row = $result->fetchRow()) {
            return $row[0];
        }
        return "";
    }
        
    
    function show_level_select ($default_prompt, $pre, $type, $levelid = NO_ANSWER)
    {
        global $conn;
        
        if ($type == "SubmitOnChange") {
            echo "<select name=levelid onChange='this.form.submit()'>\n";
        } else {
            echo "<select name=levelid>\n";
        }
        echo "<option value=\"" . NO_ANSWER . "\">" . $default_prompt . "</option>\n";
        $query = "select level.id as id, level.name as name 
                    from lstul 
                    join level on (id = levelid) 
                   group by id";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Could not get levels", E_USER_ERROR);
        }
        
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            
            if ($levelid == $row['id']) {
                echo "<option value=\"" . $row['id'] . "\" selected>{$pre}" . $row['name'] . "</option>\n";
            }
            else {
                echo "<option value=\"" . $row['id'] . "\">{$pre}" . $row['name'] . "</option>\n";
            }
        }
        
        if ($type == "EnableAddNew") {
            echo "<option value=\"" . NEW_ANSWER . "\">Add New Level...</option>\n";
        }
        echo "</select>\n";
    }
    
    function show_subject_select ($default_prompt, $pre, $type, $levelid = NO_ANSWER, $subjectid = NO_ANSWER)
    {
        global $conn;
        
        if ($type == "SubmitOnChange") {
            echo "<select name=subjectid onChange='this.form.submit()'>\n";
        } else {
            echo "<select name=subjectid>\n";
        }
        echo "<option value=\"" . NO_ANSWER . "\">" . $default_prompt . "</option>\n";
        $query = "select subject.id as id, subject.name as name 
                    from lstul 
                    join subject on (id = subjectid) 
                   group by id";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Could not get subjects", E_USER_ERROR);
        }
        
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            
            if ($subjectid == $row['id']) {
                echo "<option value=\"" . $row['id'] . "\" selected>{$pre}" . $row['name'] . "</option>\n";
            }
            else {
                echo "<option value=\"" . $row['id'] . "\">{$pre}" . $row['name'] . "</option>\n";
            }
        }
        
        if ($type == "EnableAddNew") {
            echo "<option value=\"" . NEW_ANSWER . "\">Add New Level...</option>\n";
        }
        echo "</select>\n";
    }
    
    function show_topic_select ($default_prompt, $pre, $type, $levelid = NO_ANSWER, $subjectid = NO_ANSWER, $topicid = NO_ANSWER)
    {
        global $conn;
        
        if ($type == "SubmitOnChange") {
            echo "<select name=topicid onChange='this.form.submit()'>\n";
        } else {
            echo "<select name=topicid>\n";
        }
        echo "<option value=\"" . NO_ANSWER . "\">" . $default_prompt . "</option>\n";
        $query = "select topic.id as id, topic.name as name 
                    from lstul 
                    join topic on (id = topicid) 
                   group by id";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Could not get topics", E_USER_ERROR);
        }
        
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            
            if ($topicid == $row['id']) {
                echo "<option value=\"" . $row['id'] . "\" selected>{$pre}" . $row['name'] . "</option>\n";
            }
            else {
                echo "<option value=\"" . $row['id'] . "\">{$pre}" . $row['name'] . "</option>\n";
            }
        }
        
        if ($type == "EnableAddNew") {
            echo "<option value=\"" . NEW_ANSWER . "\">Add New Level...</option>\n";
        }
        echo "</select>\n";
    }
    
    function show_unit_select ($default_prompt, $pre, $type, $levelid = NO_ANSWER, $subjectid = NO_ANSWER, $topicid = NO_ANSWER, $unitid = NO_ANSWER)
    {
        global $conn;
        
        if ($type == "SubmitOnChange") {
            echo "<select name=unitid onChange='this.form.submit()'>\n";
        } else {
            echo "<select name=unitid>\n";
        }
        echo "<option value=\"" . NO_ANSWER . "\">" . $default_prompt . "</option>\n";
        $query = "select unit.id as id, unit.name as name 
                    from lstul 
                    join unit on (id = unitid) 
                   group by id";
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Could not get units", E_USER_ERROR);
        }
        
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            
            if ($unitid == $row['id']) {
                echo "<option value=\"" . $row['id'] . "\" selected>{$pre}" . $row['name'] . "</option>\n";
            }
            else {
                echo "<option value=\"" . $row['id'] . "\">{$pre}" . $row['name'] . "</option>\n";
            }
        }
        
        if ($type == "EnableAddNew") {
            echo "<option value=\"" . NEW_ANSWER . "\">Add New Level...</option>\n";
        }
        echo "</select>\n";
    }
    
    function get_resource ($resourceid)
    {
        global $conn;
        $query = "select * from resource where id = " . $conn->quote($resourceid);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to get resource information.", E_USER_ERROR);
        }
        
        $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
        $result->free();
        return $row;
    }
    
    function get_testquestion ($testbankid)
    {
        global $conn;
        $query = "select * from testbank where id = " . $conn->quote($testbankid);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to get test question information.", E_USER_ERROR);
        }
        
        $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
        $result->free();
        return $row;
    }
    
    function get_lesson ($lessonid)
    {
        global $conn;
        $query = "select name, author, school, description, levelid, topicid, subjectid, unitid, date_format(lstul.timestamp, '%c/%e/%Y %r') as t, lstul.timestamp as created from lesson join lstul on (lstul.lessonid = lesson.id) where id = " . $conn->quote($lessonid);
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to get resource information.", E_USER_ERROR);
        }
        
        $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
        $result->free();
        return $row;
    }

    function show_breadcrumb_lesson ($lessonid = -1)
    {

        if ($lessonid == -1) {
            return;
        }

        $lesson = get_lesson($lessonid);
        show_breadcrumb($lesson['levelid'], $lesson['subjectid'], $lesson['topicid'],
                        $lesson['unitid']);

    }
    
    function show_breadcrumb ($levelid = -1, $subjectid = -1, $topicid = -1, $unitid = -1)
    {
        $level_name = get_name_from_id("level", "id", $levelid);
        $subject_name = get_name_from_id("subject", "id", $subjectid);
        $topic_name = get_name_from_id("topic", "id", $topicid);
        $unit_name = get_name_from_id("unit", "id", $unitid);

        echo "<div id=breadcrumb>"; 
        echo "<a href=\"Home.php\">Home</a> :: ";
        echo "<a href=\"ChooseLevel.php\">Lesson Plans</a>";
        
        // Show Level
        if ($level_name) {
           
            $var['levelid'] = $levelid;
            echo " &gt; "; 
            echo "<a href=\"ChooseSubject.php? " . http_build_simple_query($var) . "\">" . $level_name . "</a>";
            
            // Show Subject
            if ($subject_name) {
                $var['subjectid'] = $subjectid;
                echo " &gt; ";               
                echo "<a href=\"ChooseTopic.php? " . http_build_simple_query($var) . "\">" . $subject_name . "</a>";
            
                // Show Topic
                if ($topic_name) {
                    $var['topicid'] = $topicid;
                    echo " &gt; ";
                    echo "<a href=\"ChooseUnit.php? " . http_build_simple_query($var) . "\">" . $topic_name . "</a>";
               
                    // Show Unit
                    if ($unit_name) {
                        $var['unitid'] = $unitid;
                        echo " &gt; ";
                        echo "<a href=\"ChooseLesson.php? " . http_build_simple_query($var) . "\">" . $unit_name . "</a>";
                    } 
                }
            }
        }
        echo "</div>";   
    }

    function RTESafe($strText) {
        //returns safe code for preloading in the RTE
        $tmpString = trim($strText);
        
        //convert all types of single quotes
        $tmpString = str_replace(chr(145), chr(39), $tmpString);
        $tmpString = str_replace(chr(146), chr(39), $tmpString);
        $tmpString = str_replace("'", "&#39;", $tmpString);
        
        //convert all types of double quotes
        $tmpString = str_replace(chr(147), chr(34), $tmpString);
        $tmpString = str_replace(chr(148), chr(34), $tmpString);
//    	$tmpString = str_replace("\"", "\"", $tmpString);
        
        //replace carriage returns & line feeds
        $tmpString = str_replace(chr(10), " ", $tmpString);
        $tmpString = str_replace(chr(13), " ", $tmpString);
        
        return $tmpString;
    }
    
    function get_lessonids($levelid, $subjectid, $topicid, $unitid, $lessonid) {
        
        global $conn;
        $query = null;
        $lessonids = array();
        
        // remove negative ids
        if ($levelid < 0) {
            $levelid = null;
        }
        
        if ($subjectid < 0) {
            $subjectid = null;
        }
        
        if ($topicid < 0) {
            $topicid = null;
        }
        
        if ($unitid < 0) {
            $unitid = null;
        }
        
        // if we get only a lessonid, then return it.
        if ($lessonid && is_numeric($lessonid)) {
            return array($lessonid);
        }
        
        if ($unitid && $topicid && $subjectid && $levelid) {
            $query = "select lessonid from lstul where ".
                     "unitid = " . $conn->quote($unitid) .
                     " and topicid = " . $conn->quote($topicid) .
                     " and subjectid = " . $conn->quote($subjectid) .
                     " and levelid = " . $conn->quote($levelid);

        }
        
        else if ($topicid && $subjectid && $levelid) {
            $query = "select lessonid from lstul where ".
                     " topicid = " . $conn->quote($topicid) .
                     " and subjectid = " . $conn->quote($subjectid) .
                     " and levelid = " . $conn->quote($levelid);

        }
        
        else if ($subjectid && $levelid) {
            $query = "select lessonid from lstul where ".
                     " subjectid = " . $conn->quote($subjectid) .
                     " and levelid = " . $conn->quote($levelid);

        }
        
        else if ($levelid) {
            $query = "select lessonid from lstul where ".
                     " levelid = " . $conn->quote($levelid);

        }
        else {
            $query = "select lessonid from lstul";
        }
        
        // if we have a query, then run it and return the results
        if ($query) {
            echo "<!-- $query -->\n\n";
            $result = $conn->query($query);
            
            if (DB::isError($result)) {
                trigger_error($query, E_USER_NOTICE);
                trigger_error($result->getMessage(), E_USER_NOTICE);
                trigger_error("Failed to get lessonids for export.", E_USER_ERROR);
            }
            
            while ($row = $result->fetchRow()) {
                array_push($lessonids, $row[0]);
            }
            $result->free();
            return $lessonids; 
        }
        return array();
    }
    
    function get_lesson_xml ($lessonid) {
        $lesson = get_lesson($lessonid);
        
        $xml = null;
        
        $xml .= "  <lesson>\r\n";
        $xml .= "    <level>" . htmlentities(get_name_from_id("level", "id", $lesson['levelid'])) . "</level>\r\n";
        $xml .= "    <subject>" . htmlentities(get_name_from_id("subject", "id", $lesson['subjectid'])) . "</subject>\r\n";
        $xml .= "    <topic>" . htmlentities(get_name_from_id("topic", "id", $lesson['topicid'])) . "</topic>\r\n";
        $xml .= "    <unit>" . htmlentities(get_name_from_id("unit", "id", $lesson['unitid'])) . "</unit>\r\n";
        $xml .= "    <name>" . htmlentities($lesson['name']) . "</name>\r\n";
        $xml .= "    <author>" . htmlentities($lesson['author']) . "</author>\r\n";
        $xml .= "    <school>" . htmlentities($lesson['school']) . "</school>\r\n";
        $xml .= "    <created>" . htmlentities($lesson['created']) . "</created>\r\n";
        $xml .= "    <description>" . htmlentities($lesson['description']) . "</description>\r\n";
        $xml .= get_resources_xml($lessonid);
        $xml .= get_testbank_xml($lessonid);
        $xml .= "  </lesson>\r\n\r\n";
        return $xml;
    }
        
    function get_resources_xml ($lessonid) {
        global $conn;
        
        //
        //        CREATE TABLE resource (
        //            id integer auto_increment not null primary key,
        //            name varchar(100),
        //            description text,
        //            type integer not null,
        //            path text,
        //            uid varchar(32),
        //            mimetype varchar(100),
        //            md5 varchar(32),
        //            timestamp timestamp
        //        );
        //        
        $query = "select * from resource r join lesson_resource lr on (r.id = lr.resourceid) where lr.lessonid = " . $conn->quote($lessonid);
        $result = $conn->query($query); 
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to get resources for export.", E_USER_ERROR);
        }
        $xml = null;
         
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            $xml .= "    <resource>\r\n";
            $xml .= "      <name>" . htmlentities($row['name']) . "</name>\r\n";
            $xml .= "      <path>" . htmlentities($row['path']) . "</path>\r\n";
            $xml .= "      <description>" . htmlentities($row['description']) . "</description>\r\n";
            $xml .= "      <type>" . htmlentities($row['type']) . "</type>\r\n";
            $xml .= "      <uid>" . htmlentities($row['uid']) . "</uid>\r\n";
            $xml .= "      <mimetype>" . htmlentities($row['mimetype']) . "</mimetype>\r\n";
            $xml .= "      <md5>" . htmlentities($row['md5']) . "</md5>\r\n";
            $xml .= "      <timestamp>" . htmlentities($row['timestamp']) . "</timestamp>\r\n";
            $xml .= "    </resource>\r\n\r\n";
        }
        return $xml;
    }
    
    function get_testbank_xml ($lessonid) {
        global $conn;
        
        //
        //CREATE TABLE testbank (
        //    id integer auto_increment not null primary key,
        //    question text,
        //    answer text,
        //    timestamp timestamp
        //);
        //        
        $query = "select * from testbank t join lesson_testbank lt on (t.id = lt.testbankid) where lt.lessonid = " . $conn->quote($lessonid);
        $result = $conn->query($query); 
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to get testbank for export.", E_USER_ERROR);
        }
        $xml = null;
         
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            $xml .= "    <testbank>\r\n";
            $xml .= "      <question>" . htmlentities($row['question']) . "</question>\r\n";
            $xml .= "      <answer>" . htmlentities($row['answer']) . "</answer>\r\n";
            $xml .= "      <timestamp>" . htmlentities($row['timestamp']) . "</timestamp>\r\n";
            $xml .= "    </testbank>\r\n\r\n";
        }
        return $xml;
    }
    
    function get_file_paths ($lessonid, &$f) {
        global $conn;

        $query = "select r.md5 from resource r join lesson_resource lr on (r.id = lr.resourceid) where r.type =  2 and lr.lessonid = " . $conn->quote($lessonid);
        $result = $conn->query($query); 
        
        if (DB::isError($result)) {
            trigger_error($query, E_USER_NOTICE);
            trigger_error($result->getMessage(), E_USER_NOTICE);
            trigger_error("Failed to get resources for export.", E_USER_ERROR);
        }
        
        while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) {
            array_push($f, substr($row['md5'], 0, 2) . "\\" . 
                               substr($row['md5'], 2, 2) . "\\" . 
                               $row['md5']);
        }
        $result->free();
    }    
    
    function import_lesson_from_xml($l) {
        
        if (count($l) == 0) {
            return true;
        }
        
        // Make sure index 0 is data_type lesson
        if (strtoupper($l[0]['data_type']) == "LESSON") {
            add_lesson($l[0]);
        }
        else {
            return false;
        }
    }
    
    function add_lesson($l) {
        global $conn;
        
        $levelid = curriculum_add_answer("level", "name", $l['LEVEL']);
        $subjectid = curriculum_add_answer("subject", "name", $l['SUBJECT']);
        $topicid = curriculum_add_answer("topic", "name", $l['TOPIC']);
        $unitid = curriculum_add_answer("unit", "name", $l['UNIT']);
        
        $query = "insert into lesson (name, description, author, school, uid, timestamp) values (";
        $query .= $conn->quote($l['NAME']) . ", ";
        $query .= $conn->quote($l['DESCRIPTION']) . ", ";
        $query .= $conn->quote($l['AUTHOR']) . ", ";
        $query .= $conn->quote($l['SCHOOL']) . ", ";
        $query .= $conn->quote($l['UID']) . ", ";
        $query .= $conn->quote($l['CREATED']) . ");";
        
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Import of lesson failed.", E_USER_NOTICE);
            return false;
        }
        
        $query = "insert into lstul (levelid, subjectid, topicid, unitid, timestamp) values (";
        $query .= $conn->query($levelid) . ", ";
        $query .= $conn->query($subjectid). ", ";
        $query .= $conn->query($topicid). ", ";
        $query .= $conn->query($unitid) . ", ";
        $query .= $conn->query($l['CREATED']) . ")";
        
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Import of lstul failed.", E_USER_NOTICE);
            return false;
        }
        
        $lessonid = db_get_insert_id("lesson_id_seq");
        
        for ($i = 1; $i < count($l); $i++) {
            
            if (strtoupper($l[$i]['data_type']) == "RESOURCE") {
                if (!add_resource($l[$i], $lessonid)) {
                    return false;
                }
            }
            else if (strtoupper($l[$i]['data_type']) == "TESTBANK") {
                if (!add_testbank($l[$i], $lessonid)) {
                    return false;
                }
            } 
        }
        return true;
    }
    
    function add_resource ($r, $lessonid) {
        $query = "insert into resource (name, path, description, type, uid, mimetype, md5, timestamp) values (";
        $query .= $conn->query($r['NAME']) . ", ";
        $query .= $conn->query($r['PATH']). ", ";
        $query .= $conn->query($r['DESCRIPTION']). ", ";
        $query .= $conn->query($r['TYPE']) . ", ";
        $query .= $conn->query($r['UID']) . ", ";
        $query .= $conn->query($r['MIMETYPE']) . ", ";
        $query .= $conn->query($r['MD5']) . ", ";
        $query .= $conn->query($r['TIMESTAMP']) . ")";
        
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Import of resource failed.", E_USER_NOTICE);
            return false;
        }
        
        $resourceid = db_get_insert_id("resource_id_seq");
        
        $query = "insert into lesson_resource (lessonid, resourceid) values (";
        $query .= $conn->query($lessonid) . ", ";
        $query .= $conn->query($resourceid). ") ";
        
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Import of lesson_resource failed.", E_USER_NOTICE);
            return false;
        }
        
        return true;
    }
    
    function add_testbank ($t, $lessonid) {
        $query = "insert into testbank (question, answer, timestamp) values (";
        $query .= $conn->query($r['QUESTION']) . ", ";
        $query .= $conn->query($r['ANSWER']). ", ";
        $query .= $conn->query($r['TIMESTAMP']) . ")";
        
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Import of testbank failed.", E_USER_NOTICE);
            return false;
        }
        
        $testbankid = db_get_insert_id("testbank_id_seq");
        
        $query = "insert into lesson_testbank (lessonid, testbankid) values (";
        $query .= $conn->query($lessonid) . ", ";
        $query .= $conn->query($testbankid). ") ";
        
        $result = $conn->query($query);
        
        if (DB::isError($result)) {
            trigger_error("Import of lesson_testbank failed.", E_USER_NOTICE);
            return false;
        }
        
        return true;
    }

?