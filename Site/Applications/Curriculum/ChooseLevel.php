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
    $config['local']['title'] = $config['local']['name'] . ": New Resource";
    layout_begin();
  
?>
<h2>Choose Level:</h2>
<ul>
<?php while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC)) { ?>
<li><a href="NewLevel.php?levelid=<?= $row['id'] ?>"><?= $row['name'] ?></a></li>
<?php } ?>
<li><a href="NewLevel.php?levelid=<?= NEW_ANSWER ?>">Add New Level...</a></li>
</ul>

<?php
    
    layout_end();

?>
