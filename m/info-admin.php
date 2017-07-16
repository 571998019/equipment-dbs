<?php require_once('../Connections/connectioneq.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordsetadmin = "SELECT * FROM tb_admin";
$Recordsetadmin = mysql_query($query_Recordsetadmin, $connectioneq) or die(mysql_error());
$row_Recordsetadmin = mysql_fetch_assoc($Recordsetadmin);
$totalRows_Recordsetadmin = mysql_num_rows($Recordsetadmin);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Imfomations</title>

<!-- Bootstrap -->
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../bootstrap/justified-nav.css/justified-nav.css" rel="stylesheet" type="text/css">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">
th{
	background-color:#090;
	}
</style>
</head>

<body style="background-image:url(../img/back.jpg)">
<div class="container">
<div style="text-align:center">
  <table class="table table-bordered">
    <tr>
    	<td colspan="7" style="background-color:#999">ข้อมูลของ <?php echo $row_Recordsetadmin['admin_name']; ?></td>
    </tr>
    <tr>
      <th style="text-align:left;color:#FFF" width="100px">Username</th>
      <td style="text-align:left;background-color:#CCC;"><?php echo $row_Recordsetadmin['username_log']; ?></td>
    </tr>
    <tr>
      <th style="text-align:left;color:#FFF">ชื่อ-นามสกุล</th>
      <td style="text-align:left;background-color:#CCC;"><?php echo $row_Recordsetadmin['admin_name']; ?></td>
    </tr>
    <tr>
      <th style="text-align:left;color:#FFF">E-mail</th>
      <td style="text-align:left;background-color:#CCC;"><?php echo $row_Recordsetadmin['admin_email']; ?></td>
    </tr>
    <tr>
        <th style="text-align:left;color:#FFF">เบอร์โทร</th>
        <td style="text-align:left;background-color:#CCC;"><?php echo $row_Recordsetadmin['admin_tel']; ?></td>
    </tr>
     <tr>
        <th style="text-align:left;color:#FFF">รหัสผ่าน</th>
        <td style="text-align:left;background-color:#CCC;"><?php echo $row_Recordsetadmin['admin_password']; ?></td>
    </tr>
    </table>
  <a href="detail-admin.php">
  <button class="btn btn-success">ย้อนกลับ</button>
  </a> 
    <a href="update-admin.php?id_admin=<?php echo $row_Recordsetadmin['id_admin']; ?>">
    <button class="btn btn-warning">แก้ไข</button>
    </a>
    <a href="delete-admin.php?id_admin=<?php echo $row_Recordsetadmin['id_admin']; ?>">
    	<button class="btn btn-danger">ลบ</button>
    </a>
  </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>
<?php
mysql_free_result($Recordsetadmin);
?>
