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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tb_meterial SET meterial_code=%s, meterial_name=%s, meterial_item=%s, meterial_img=%s, meterial_store_id=%s WHERE meterial_id=%s",
                       GetSQLValueString($_POST['meterial_code'], "text"),
                       GetSQLValueString($_POST['meterial_name'], "text"),
                       GetSQLValueString($_POST['meterial_item'], "int"),
                       GetSQLValueString($_POST['meterial_img'], "text"),
                       GetSQLValueString($_POST['meterial_store_id'], "int"),
                       GetSQLValueString($_POST['meterial_id'], "int"));

  mysql_select_db($database_connectioneq, $connectioneq);
  $Result1 = mysql_query($updateSQL, $connectioneq) or die(mysql_error());

  $updateGoTo = "detail-meterial.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_RecordsetM = "-1";
if (isset($_GET['meterial_id'])) {
  $colname_RecordsetM = $_GET['meterial_id'];
}
mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetM = sprintf("SELECT * FROM tb_meterial WHERE meterial_id = %s", GetSQLValueString($colname_RecordsetM, "int"));
$RecordsetM = mysql_query($query_RecordsetM, $connectioneq) or die(mysql_error());
$row_RecordsetM = mysql_fetch_assoc($RecordsetM);
$totalRows_RecordsetM = mysql_num_rows($RecordsetM);

mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetS = "SELECT * FROM tb_stores";
$RecordsetS = mysql_query($query_RecordsetS, $connectioneq) or die(mysql_error());
$row_RecordsetS = mysql_fetch_assoc($RecordsetS);
$totalRows_RecordsetS = mysql_num_rows($RecordsetS);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>update Meterial</title>
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
.submitss {
    width: 100%;
    background-color: #F00;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
	text-align:center;
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
<h3 style="text-align:center;">แก้ไขวัสดุ</h3>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">รหัสวัสดุ:</td>
      <td><input type="text" name="meterial_code" value="<?php echo htmlentities($row_RecordsetM['meterial_code'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ชื่อวัสดุ:</td>
      <td><input type="text" name="meterial_name" value="<?php echo htmlentities($row_RecordsetM['meterial_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">จำนวน:</td>
      <td><input type="text" name="meterial_item" value="<?php echo htmlentities($row_RecordsetM['meterial_item'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">รูปประกอบ:</td>
      <td><input type="file" name="meterial_img" value="<?php echo htmlentities($row_RecordsetM['meterial_img'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">สถานที่จัดเก็บ:</td>
      <td><label for="stores"></label>
        <select name="stores" id="stores">
          <?php
do {  
?>
          <option value="<?php echo $row_RecordsetS['stores_id']?>"><?php echo $row_RecordsetS['stores_name']?></option>
          <?php
} while ($row_RecordsetS = mysql_fetch_assoc($RecordsetS));
  $rows = mysql_num_rows($RecordsetS);
  if($rows > 0) {
      mysql_data_seek($RecordsetS, 0);
	  $row_RecordsetS = mysql_fetch_assoc($RecordsetS);
  }
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="แก้ไข" />
      	  <a href="detail-meterial.php">
      	  <button class="submitss" type="button" >ยกเลิก</button>
   	    </a>      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="meterial_id" value="<?php echo $row_RecordsetM['meterial_id']; ?>" />
</form>
</div>
</body>
</html>
<?php
mysql_free_result($RecordsetM);

mysql_free_result($RecordsetS);
?>
