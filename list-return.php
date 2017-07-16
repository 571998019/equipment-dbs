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
$query_RecordsetList = "SELECT tb_borrow.*, tb_tools.tool_name, tb_tools.tool_code, tb_tools.image, tb_type.type_name, tb_user.name_log FROM tb_borrow, tb_tools, tb_type, tb_user WHERE tb_borrow.b_tool_id = tb_tools.tool_id and tb_tools.tool_type = tb_type.type_id and tb_borrow.b_user_id = tb_user.id_log";
$RecordsetList = mysql_query($query_RecordsetList, $connectioneq) or die(mysql_error());
$row_RecordsetList = mysql_fetch_assoc($RecordsetList);
$totalRows_RecordsetList = mysql_num_rows($RecordsetList);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Return</title>
<style>
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
body {
	background-image: url(img/back.jpg);
}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li {
    float: left;
}

li a, .dropbtn {
    display: inline-block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}



li.dropdown {
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
    display: block;
}

.active {
    background-color: red;
}
</style>
</head>

<body style="text-decoration:none;">
 <form id="form2" name="form2" method="post" action="">
        <ul>
          <li><a class="active" href="background.php">หน้าหลัก</a></li>
         
          <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">ผู้ใช้งาน</a>
            <div class="dropdown-content">
              <a href="insert_user.php">เพิ่มผู้ใช้งาน</a>
              <a href="insert_admin.php">เพิ่มผู้ดูแลระบบ</a>
              <a href="detail-user.php">รายชื่อผู้ใช้งาน</a>
              <a href="detail-admin.php">รายชื่อผู้ดูแลระบบ</a>
              
          <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">อุปกรณ์</a>
            <div class="dropdown-content">
              <a href="insert_tolls.php">เพิ่มอุปกรณ์</a>
              <a href="detail-tool.php">รายการอุปกรณ์</a>
              <a href="insert_type.php">เพิ่มประเภทอุปกรณ์</a>
              <a href="detail-type.php">ประเภทอุปกรณ์</a>
              
              <li class="dropdown">
            <a href="javascript:void(0)" class="dropbtn">ยืม - คืน</a>
            <div class="dropdown-content">
              <a href="borrow-all.php">ยืมอุปกรณ์</a>
              <a href="list-return.php">คืนอุปกรณ์</a>
            </div>
          </li>
          
          <li style="float:right"><a  href="#about">ออกจากระบบ</a></li>
        </ul>
        
        </form>


<div style="background-color:#FFF">
<div class="contrainer" style="padding-top:20px; padding-left:20px; padding-right:20px; padding-bottom:20px;">

<table border="1" width="110%">
  <tr>
        <tr>
          <th colspan="6" style="background-color:#395FEA">รายชื่อผู้ใช้งาน</th>
        </tr>
  <tr>
    
    <th>รหัสอุปกรณ์</th>
    <th>ชื่ออุปกรณ</th>
    <th>ประเภทอุปกรณ์</th>
    <th>รูปประกอบ</th>
    <th>ชื่อผู้ยืม</th>
    <th>ตัวเลือก</th>
  </tr>
  <?php do { ?>
    <tr>
    <td><?php echo $row_RecordsetList['tool_code']; ?></td>
      <td><?php echo $row_RecordsetList['tool_name']; ?></td>
      <td><?php echo $row_RecordsetList['type_name']; ?></td>
       <td><?php echo $row_RecordsetList['image']; ?></td>
      <td><?php echo $row_RecordsetList['name_log']; ?></td>
      <td>
      <?php
	  if($row_RecordsetList['status']==''){
		  ?>
        <a style="color:#F00" href="conf.php?b_id_log=<?php echo $row_RecordsetList['b_id_log']; ?>&amp;b_user_id=<?php echo $row_RecordsetList['b_user_id']; ?>">คืน</a>
        <?php
	  }else{
		  echo $row_RecordsetList['status'];
		  }
		  ?>
		
		</td>
    </tr>
    
    <?php } while ($row_RecordsetList = mysql_fetch_assoc($RecordsetList)); ?>
    </tr>
</table>
</div>
</div>

</body>
</html>
<?php
mysql_free_result($RecordsetList);
?>
