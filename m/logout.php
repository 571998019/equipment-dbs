<?php
session_start();
session_destroy();
header( "location:http://www.cecrru.com/equipment-dbs/m/index.php" );
 exit(0);
?>