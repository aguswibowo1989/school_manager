<?php

    require("config.php");
    $resources = $_GET['resources'];
    
    $query = "select level.name as level, level.id as levelid,
                     subject.name as subject, subject.id as subjectid,
                     topic.name as topic, topic.id as topicid,
                     resource.name as name, resource.id as resourceid,
                     resource.type as type, resource.description as description,
                     resource.path as path, resource.uid as uid, resource.timestamp as created
                from lstr join resources r on (lstr.resourceid = r.id)
                          join level l on (lstr.levelid = l.id)
                          join subject s on (lstr.subjectid = s.id)
                          join topic t on (lstr.topicid = t.id)";

?>