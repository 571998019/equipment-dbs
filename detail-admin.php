<?php require_once('Connections/connectioneq.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<title>Admins</title>
<style >
table {
	border-collapse: collapse;
	width: 100%;
	text-align: center;
}

th, td {
	text-align: center;
	padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
	background-color: #4CAF50;
	color: white;
	text-align: center;
}
</style>
</head>

<body>
 <!-- Nav -->
     <nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false" style="color:#FFF">
        <span class="sr-only">Toggle navigation</span>
        เมนู
      </button>
      <a class="navbar-brand" href="index-member.php"><b>Member Management</b></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li style="background-color:red;"><a href="home.php" style=" color:#000">หน้าหลัก <span class="sr-only">(current)</span></a></li>
       
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">เพิ่มข้อมูลสมาชิก<span class="caret"></span></a>
          <ul class="dropdown-menu">
              <li ><a href="insert_user.php">เพิ่มผู้ใช้งาน</a></li>
              <li ><a href="insert_admin.php">เพิ่มผู้ดูแลระบบ</a></li>
              <li ><a href="insert-faculty.php">เพิ่มสำนักวิชา/คณะ</a></li>
              <li ><a href="insert-major.php">เพิ่มโปรแกรมวิชา</a></li>
              <li ><a href="insert-class.php">เพิ่มชั้นปี</a></li>
          </ul>
        </li> 
        
         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">จัดการข้อมูลสมาชิก<span class="caret"></span></a>
          <ul class="dropdown-menu">
              <li ><a href="detail-user.php">รายชื่อผู้ใช้งาน</a></li>
              <li ><a href="detail-admin.php">รายชื่อผู้ดูแลระบบ</a></li>
              <li ><a href="detail-faculty.php">รายชื่อสำนักวิชา/คณะ</a></li>
              <li ><a href="detail-major.php">รายชื่อโปรแกรมวิชา</a></li>
              <li ><a href="detail-class.php">รายชื่อชั้นปี</a></li>
          </ul>
        </li> 
        
        <!-- dropdown 
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li> End dropdown -->
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div style="padding-top:74px">
</div>
<div style="background-color:#FFF; text-decoration:none;">
<div class="contrainer" style="padding-top:20px; padding-left:20px; padding-right:20px; padding-bottom:20px">
<table border="1" width="110%">
<tr>
	<tr>
          <th colspan="5" style="background-color:#395FEA">รายชื่อผู้ดูแล</th>
          <th style="background-color:#666" width="10%">ตัวเลือก</th>
     </tr>
  <tr>
    <th>Username</th>
    <th>ชื่อ-นามสกุล</th>
    <th>E-mail</th>
    <th>โทรศัพท์</th>
    <th>รหัสผ่าน</th>
    <th style="background-color:#FFF">
      <a href="insert_admin.php">
      <button type="button">เพิ่ม</button>
      </a>    </th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordsetadmin['username_log']; ?></td>
      <td><?php echo $row_Recordsetadmin['admin_name']; ?></td>
      <td><?php echo $row_Recordsetadmin['admin_email']; ?></td>
      <td><?php echo $row_Recordsetadmin['admin_tel']; ?></td>
      <td><?php echo $row_Recordsetadmin['admin_password']; ?></td>
      <td><a href="delete-admin.php?id_admin=<?php echo $row_Recordsetadmin['id_admin']; ?>">
        <button onclick="return confirm('ยืนยันการลบ <?php echo $row_Recordsetadmin['username_log']; ?>')">ลบ</button>
      <a href="update-admin.php?id_admin=<?php echo $row_Recordsetadmin['id_admin']; ?>">
      <button>แก้ไข</button>
      </a></td>
    </tr>
    <?php } while ($row_Recordsetadmin = mysql_fetch_assoc($Recordsetadmin)); ?>
    </tr>
</table>
</div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="bootstrap/js/js-member.js" type="text/javascript"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>
<?php
mysql_free_result($Recordsetadmin);
?>
