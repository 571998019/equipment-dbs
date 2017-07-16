<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_connectioneq = "localhost";
$database_connectioneq = "equipment";
$username_connectioneq = "root";
$password_connectioneq = "";
$connectioneq = mysql_pconnect($hostname_connectioneq, $username_connectioneq, $password_connectioneq) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("Set Names UTF8");
?>