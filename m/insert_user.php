<?php require_once('../Connections/connectioneq.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form-user")) {
  $insertSQL = sprintf("INSERT INTO tb_user (name_log, personal_id, student_id_log, class_id, faculty_id, major_id, tel_log) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['personal_id'], "text"),
                       GetSQLValueString($_POST['pass'], "text"),
                       GetSQLValueString($_POST['tb_class'], "int"),
                       GetSQLValueString($_POST['faculty_tb'], "int"),
                       GetSQLValueString($_POST['major_tb'], "int"),
                       GetSQLValueString($_POST['tel'], "text"));

  mysql_select_db($database_connectioneq, $connectioneq);
  $Result1 = mysql_query($insertSQL, $connectioneq) or die(mysql_error());

  $insertGoTo = "detail-user.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetC = "SELECT * FROM tb_class ORDER BY class_name ASC";
$RecordsetC = mysql_query($query_RecordsetC, $connectioneq) or die(mysql_error());
$row_RecordsetC = mysql_fetch_assoc($RecordsetC);
$totalRows_RecordsetC = mysql_num_rows($RecordsetC);

mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetF = "SELECT * FROM tb_faculty ORDER BY faculty_id ASC";
$RecordsetF = mysql_query($query_RecordsetF, $connectioneq) or die(mysql_error());
$row_RecordsetF = mysql_fetch_assoc($RecordsetF);
$totalRows_RecordsetF = mysql_num_rows($RecordsetF);

mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetM = "SELECT * FROM tb_major ORDER BY major_id ASC";
$RecordsetM = mysql_query($query_RecordsetM, $connectioneq) or die(mysql_error());
$row_RecordsetM = mysql_fetch_assoc($RecordsetM);
$totalRows_RecordsetM = mysql_num_rows($RecordsetM);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Add member</title>
<style>
input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.submits{
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}
body {
	background-image: url(../img/back.jpg);
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

<body>

<div class="container">
  <form action="<?php echo $editFormAction; ?>" method="POST" name="form-user">
  
  	<center><h3>เพิ่มผู้ใช้งาน</h3></center>
    <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ชื่อผู้ใช้งาน :</td>
      <td><input type="text" id="name" name="user" placeholder="ตัวอย่าง : พสิษฐ์ สมคณะ"></td>
    </tr>
        <td nowrap="nowrap" align="right">ชั้นปี :</td>
      <td><label for="tb_class"></label>
        <select name="tb_class" id="tb_class">
          <?php
do {  
?>
          <option value="<?php echo $row_RecordsetC['class_id']?>"><?php echo $row_RecordsetC['class_name']?></option>
          <?php
} while ($row_RecordsetC = mysql_fetch_assoc($RecordsetC));
  $rows = mysql_num_rows($RecordsetC);
  if($rows > 0) {
      mysql_data_seek($RecordsetC, 0);
	  $row_RecordsetC = mysql_fetch_assoc($RecordsetC);
  }
?>
        </select></td>
    </tr>
    <td nowrap="nowrap" align="right">รหัสนักศึกษา :</td>
      <td><input type="text" id="student_id" name="pass" placeholder="ตัวอย่าง : 571998019"></td>
    </tr>
       <td nowrap="nowrap" align="right">บัตรประชาชน :</td>
      <td><input type="text" id="personal_id" name="personal_id" placeholder="ตัวอย่าง : 150xxxxxxxxxx3"></td>
    </tr>
    <td nowrap="nowrap" align="right">สำนักวิชา/คณะ :</td>
      <td><label for="faculty_tb"></label>
        <select name="faculty_tb" id="faculty_tb">
          <?php
do {  
?>
          <option value="<?php echo $row_RecordsetF['faculty_id']?>"><?php echo $row_RecordsetF['faculty_name']?></option>
          <?php
} while ($row_RecordsetF = mysql_fetch_assoc($RecordsetF));
  $rows = mysql_num_rows($RecordsetF);
  if($rows > 0) {
      mysql_data_seek($RecordsetF, 0);
	  $row_RecordsetF = mysql_fetch_assoc($RecordsetF);
  }
?>
        </select></td>
    </tr>
    <td nowrap="nowrap" align="right">สาขาวิชา :</td>
      <td><label for="major_tb"></label>
        <select name="major_tb" id="major_tb">
          <?php
do {  
?>
          <option value="<?php echo $row_RecordsetM['major_id']?>"><?php echo $row_RecordsetM['major_name']?></option>
          <?php
} while ($row_RecordsetM = mysql_fetch_assoc($RecordsetM));
  $rows = mysql_num_rows($RecordsetM);
  if($rows > 0) {
      mysql_data_seek($RecordsetM, 0);
	  $row_RecordsetM = mysql_fetch_assoc($RecordsetM);
  }
?>
        </select></td>
    </tr>
    <td nowrap="nowrap" align="right">โทรศัพท์:</td>
      <td>
    <input type="text" id="tel" name="tel" placeholder="ตัวอย่าง : 0988888887" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="ตกลง" />
      	<a href="detail-user.php">
      	<button type="button" class="submits" style="background-color:#F00">ยกเลิก</button>
      	</a>      </td>
    </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form-user" />
  </form>
</div>
</body>
</html>
<?php
mysql_free_result($RecordsetC);

mysql_free_result($RecordsetF);

mysql_free_result($RecordsetM);
?>
