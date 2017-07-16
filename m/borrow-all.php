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
$query_RecordsetTool = "SELECT * FROM tb_tools";
$RecordsetTool = mysql_query($query_RecordsetTool, $connectioneq) or die(mysql_error());
$row_RecordsetTool = mysql_fetch_assoc($RecordsetTool);
$totalRows_RecordsetTool = mysql_num_rows($RecordsetTool);

mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetQ = "SELECT * FROM tb_borrow";
$RecordsetQ = mysql_query($query_RecordsetQ, $connectioneq) or die(mysql_error());
$row_RecordsetQ = mysql_fetch_assoc($RecordsetQ);
$totalRows_RecordsetQ = mysql_num_rows($RecordsetQ);

mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordsettest = "SELECT tb_tools.tool_id, tb_borrow.b_tool_id FROM tb_tools, tb_borrow ";
$Recordsettest = mysql_query($query_Recordsettest, $connectioneq) or die(mysql_error());
$row_Recordsettest = mysql_fetch_assoc($Recordsettest);
$totalRows_Recordsettest = mysql_num_rows($Recordsettest);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Borrow</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
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
</style></head> 
<body>
<ul>
  <li><a class="active" href="background.php">หน้าหลัก</a></li>
  <form id="form2" name="form2" method="post" action="">
  </form>
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
<form id="form1" name="form1" method="post" action="">
</form>

<div style="background-color:#FFF">
<div class="contrainer" style="padding-top:20px; padding-left:20px; padding-right:20px; padding-bottom:20px;">

<table border="1" width="110%">
  <tr>
        <tr>
          <th colspan="8" style="background-color:#395FEA">รายชื่อผู้ใช้งาน</th>
        </tr>
  <tr>
    <th>ชื่ออุปกรณ์</th>
    <th>รหัสอุปกรณ์</th>
    <th>ประเภทอุปกรณ์</th>
    <th>รูปประกอบ</th>
    <th>จำนวน</th>
    <th>สถานที่เก็บ</th>
    <th>status</th>
    <th>Options</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_RecordsetTool['tool_name']; ?></td>
      <td><?php echo $row_RecordsetTool['tool_code']; ?></td>
      <td><?php echo $row_RecordsetTool['tool_type']; ?></td>
      <td><?php echo $row_RecordsetTool['image']; ?></td>
      <td><?php echo $row_RecordsetTool['item']; ?></td>
      <td><?php echo $row_RecordsetTool['tool_store_id']; ?></td>
      <td><?php echo $row_RecordsetTool['status']; ?></td>
      
      
      <td>
      
      <a href="borrow-click.php?tool_id=<?php echo $row_RecordsetTool['tool_id']; ?>">ยืม</a> 
      

      </td>
      
    </tr>
    <?php } while ($row_RecordsetTool = mysql_fetch_assoc($RecordsetTool)); ?>
    </tr>
</table>
</div>
</div>

</center>
</body>
</html>
<?php
mysql_free_result($RecordsetTool);

mysql_free_result($RecordsetQ);

mysql_free_result($Recordsettest);
?>
