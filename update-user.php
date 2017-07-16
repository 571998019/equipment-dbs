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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE tb_user SET name_log=%s, personal_id=%s, student_id_log=%s, class_id=%s, major_id=%s, tel_log=%s WHERE id_log=%s",
                       GetSQLValueString($_POST['name_log'], "text"),
                       GetSQLValueString($_POST['personal_id'], "text"),
                       GetSQLValueString($_POST['student_id_log'], "text"),
                       GetSQLValueString($_POST['class_tb'], "int"),
                       GetSQLValueString($_POST['major_tb'], "int"),
                       GetSQLValueString($_POST['tel_log'], "text"),
                       GetSQLValueString($_POST['id_log'], "int"));

  mysql_select_db($database_connectioneq, $connectioneq);
  $Result1 = mysql_query($updateSQL, $connectioneq) or die(mysql_error());

  $updateGoTo = "detail-user.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_RecordsetUser = "-1";
if (isset($_GET['id_log'])) {
  $colname_RecordsetUser = $_GET['id_log'];
}
mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetUser = sprintf("SELECT * FROM tb_user WHERE id_log = %s", GetSQLValueString($colname_RecordsetUser, "int"));
$RecordsetUser = mysql_query($query_RecordsetUser, $connectioneq) or die(mysql_error());
$row_RecordsetUser = mysql_fetch_assoc($RecordsetUser);
$totalRows_RecordsetUser = mysql_num_rows($RecordsetUser);

mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetC = "SELECT * FROM tb_class";
$RecordsetC = mysql_query($query_RecordsetC, $connectioneq) or die(mysql_error());
$row_RecordsetC = mysql_fetch_assoc($RecordsetC);
$totalRows_RecordsetC = mysql_num_rows($RecordsetC);

mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetF = "SELECT * FROM tb_faculty";
$RecordsetF = mysql_query($query_RecordsetF, $connectioneq) or die(mysql_error());
$row_RecordsetF = mysql_fetch_assoc($RecordsetF);
$totalRows_RecordsetF = mysql_num_rows($RecordsetF);

mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetM = "SELECT * FROM tb_major";
$RecordsetM = mysql_query($query_RecordsetM, $connectioneq) or die(mysql_error());
$row_RecordsetM = mysql_fetch_assoc($RecordsetM);
$totalRows_RecordsetM = mysql_num_rows($RecordsetM);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>update</title>
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
	background-image: url(img/back.jpg);
}
</style>
</head>

<body>

<div style="background-color:#CCC;">
<h3 style="text-align:center;">
แก้ไขข้อมูลผู้ใช้งาน</h3>
  <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
    <table align="center">
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">ชื่อ-นามสกุล:</td>
        <td><input type="text" name="name_log" value="<?php echo htmlentities($row_RecordsetUser['name_log'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">รหัสนักศึกษา:</td>
        <td><input type="text" name="student_id_log" value="<?php echo htmlentities($row_RecordsetUser['student_id_log'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">บัตรประชาชน:</td>
        <td><input type="text" name="personal_id" value="<?php echo htmlentities($row_RecordsetUser['personal_id']); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">เลือกชั้นปี:</td>
        <td><label for="class_tb"></label>
          <select name="class_tb" id="class_tb">
          <option value="<?php echo $_GET['class_id']; ?>"><?php echo $_GET['class_name']; ?></option>
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
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">สำนักวิชา/คณะ:</td>
        <td><label for="faculty_-tb"></label>
          <select name="faculty_-tb" id="faculty_-tb">
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
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">สาขา:</td>
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
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">โทรศัพท์:</td>
        <td><input type="text" name="tel_log" value="<?php echo htmlentities($row_RecordsetUser['tel_log'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td><input type="submit" value="แก้ไข" />
        	<a href="detail-user.php">
        	<button type="button" class="submits" style=" background-color:#F00">ยกเลิก</button>
       	</a>        </td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="form2" />
    <input type="hidden" name="id_log" value="<?php echo $row_RecordsetUser['id_log']; ?>" />
  </form>
</div>
</body>
</body>
</html>
<?php
mysql_free_result($RecordsetUser);

mysql_free_result($RecordsetC);

mysql_free_result($RecordsetF);

mysql_free_result($RecordsetM);
?>
