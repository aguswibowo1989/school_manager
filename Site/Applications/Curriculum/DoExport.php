<?php

    require("config.php");
    require("Archive/Tar.php");
    
    $lessonids = $_GET['lessonids'];
    
    if (count($lessonids) == 0) {
        trigger_error("No Lessons to Export", E_USER_ERROR);
    }
    
    $files = array();
    
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\r\n";
    $xml .= "<export>\r\n";
    foreach ($lessonids as $lessonid) {
        $xml .= get_lesson_xml($lessonid);
        get_file_paths($lessonid, $files); 
    }
    
    $xml .= "</export>\r\n";
    
    chdir($config['path']['filestore']);
    $filename = session_id() . ".xml";
    $archive = session_id() . ".tgz";
    
    if (file_exists($filename)) {
        unlink($filename);
    }
    
    if (!$handle = fopen($filename, "w")) {
        trigger_error("Unable to open tmp file", E_USER_ERROR);
    }
    
    if (!fwrite($handle, $xml)) {
        trigger_error("Unable to write to tmp file", E_USER_ERROR);
    }
    fclose($handle);
    array_push($files, $filename); 
    
    if (! $tar_obj = new Archive_Tar($archive, true)) {
        trigger_error("Unable to create archive object", E_USER_ERROR);
    }
    
    $tar_obj->create($files);
    
    header("Content-type: text/plain");
    print_r($files);
    //header("Content-type: application/x-gzip");
    //header("Content-Disposition: filename=CirExp-" . date("YmdGis") . ".tgz");
    //readfile($archive);
    
    unlink($filename);
    unlink($archive);

    
?>