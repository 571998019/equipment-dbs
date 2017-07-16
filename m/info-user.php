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

$colname_Recordsetinfouser = "-1";
if (isset($_GET['id_log'])) {
  $colname_Recordsetinfouser = $_GET['id_log'];
}
mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordsetinfouser = sprintf("SELECT * FROM tb_user WHERE id_log = %s", GetSQLValueString($colname_Recordsetinfouser, "int"));
$Recordsetinfouser = mysql_query($query_Recordsetinfouser, $connectioneq) or die(mysql_error());
$row_Recordsetinfouser = mysql_fetch_assoc($Recordsetinfouser);
$colname_Recordsetinfouser = "''";
if (isset($_GET['id_log'])) {
  $colname_Recordsetinfouser = $_GET['id_log'];
}
mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordsetinfouser = sprintf("SELECT * FROM tb_user inner join tb_class inner join tb_faculty inner join tb_major on tb_user.class_id = tb_class.class_id and tb_user.faculty_id = tb_faculty.faculty_id and tb_user.major_id = tb_major.major_id WHERE tb_user.id_log = %s", GetSQLValueString($colname_Recordsetinfouser, "text"));
$Recordsetinfouser = mysql_query($query_Recordsetinfouser, $connectioneq) or die(mysql_error());
$row_Recordsetinfouser = mysql_fetch_assoc($Recordsetinfouser);
$totalRows_Recordsetinfouser = mysql_num_rows($Recordsetinfouser);
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
    <td colspan="7" style="background-color:#999">ข้อมูลของ <?php echo $row_Recordsetinfouser['name_log']; ?></td>
    </tr>
    <tr>
      <th style="text-align:left;color:#FFF" width="100px">รหัสนักศึกษา</th>
      <td style="text-align:left;background-color:#CCC;"><?php echo $row_Recordsetinfouser['student_id_log']; ?></td>
    </tr>
    <tr>
      <th style="text-align:left;color:#FFF">ชื่อ-นามสกุล</th>
      <td style="text-align:left;background-color:#CCC;"><?php echo $row_Recordsetinfouser['name_log']; ?></td>
    </tr>
    <tr>
      <th style="text-align:left;color:#FFF">เลขบัตรประชาชน</th>
      <td style="text-align:left;background-color:#CCC;"><?php echo $row_Recordsetinfouser['personal_id']; ?></td>
    </tr>
    <tr>
      <th style="text-align:left;color:#FFF">ปีการศึกษา</th>
      <td style="text-align:left;background-color:#CCC;"><?php echo $row_Recordsetinfouser['class_name']; ?></td>
    </tr>
    <tr>
      <th style="text-align:left;color:#FFF">สำนักวิชา/คณะ</th>
      <td style="text-align:left;background-color:#CCC;"><?php echo $row_Recordsetinfouser['faculty_name']; ?></td>
    </tr>
    <tr>
      <th style="text-align:left;color:#FFF">โปรแกรมวิชา</th>
      <td style="text-align:left;background-color:#CCC;"><?php echo $row_Recordsetinfouser['major_name']; ?></td>
    </tr>
    <tr>
        <th style="text-align:left;color:#FFF">เบอร์โทร</th>
        <td style="text-align:left;background-color:#CCC;"><?php echo $row_Recordsetinfouser['tel_log']; ?></td>
    </tr>
  </table>
  <a href="detail-user.php">
  <button class="btn btn-success">ย้อนกลับ</button>
  </a> 
    <a href="update-user.php?id_log=<?php echo $row_Recordsetinfouser['id_log']; ?>&amp;major_id=<?php echo $row_Recordsetinfouser['major_id']; ?>&amp;class_id=<?php echo $row_Recordsetinfouser['class_id']; ?>&amp;class_name=<?php echo $row_Recordsetinfouser['class_name']; ?>">
    <button class="btn btn-warning">แก้ไข</button>
    </a>
    <a href="delete.php?id_log=<?php echo $row_Recordsetinfouser['id_log']; ?>">
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
mysql_free_result($Recordsetinfouser);
?>
