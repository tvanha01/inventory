<?php

include "db.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Delete</title>
    </head>
    <body>
        <?php
        
        deleteEquipment($_GET['assetId']);
        echo "you successfully deleted " . $_GET['assetId'];
        
        header( "refresh:1.5; url=index.php" );
        ?>

    </body>
</html>