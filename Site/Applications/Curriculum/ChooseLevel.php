<?php

    require("config.php");
    $query = "select level.id as id, level.name as name 
                from lstul 
                join level on (id = levelid) 
               group by id";
    $result = $conn->query($query);
   
    
    if (DB::isError($result)) {
        trigger_error($query);
        trigger_error($result->getMessage());
        trigger_error("Could not get levels", E_USER_ERROR);
    }
    $config['local']['title'] = $config['local']['name'] . ": Lesson Plans";
    layout_begin();
    show_breadcrumb();
  
?>
<div id=bar>
    <a href="Search.php">Search Lesson Plans</a>
    <a href="Export.php">Export Lesson Plans</a>
    <a href="Import.php">Import Lesson Plans</a>
</div>

<strong>Choose Level: &nbsp;</strong>
<a href="NewLevel.php?levelid=<?= NEW_ANSWER ?>">Add New Level...</a>
<ul>
<?php 
    if ($result->numRows() == 0) {
        echo "<li>No Levels</li>\n";
    }
    
    while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) { 
?>

<li><a href="NewLevel.php?levelid=<?= $row['id'] ?>"><?= $row['name'] ?></a></li>
<?php 
    } 
?>

</ul>

<?php
    
    layout_end();

?>
