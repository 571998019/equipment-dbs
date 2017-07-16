<?php
session_start();
session_destroy();
header( "location:http://www.cecrru.com/equipment-dbs/home.php" );
 exit(0);
?>