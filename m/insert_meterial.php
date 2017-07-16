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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tb_meterial (meterial_code, meterial_name, meterial_item, meterial_img, meterial_store_id) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['meterial_code'], "text"),
                       GetSQLValueString($_POST['meterial_name'], "text"),
                       GetSQLValueString($_POST['meterial_item'], "int"),
                       GetSQLValueString($_POST['meterial_img'], "text"),
                       GetSQLValueString($_POST['store'], "int"));

  mysql_select_db($database_connectioneq, $connectioneq);
  $Result1 = mysql_query($insertSQL, $connectioneq) or die(mysql_error());

  $insertGoTo = "detail-meterial.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetStore = "SELECT * FROM tb_stores";
$RecordsetStore = mysql_query($query_RecordsetStore, $connectioneq) or die(mysql_error());
$row_RecordsetStore = mysql_fetch_assoc($RecordsetStore);
$totalRows_RecordsetStore = mysql_num_rows($RecordsetStore);

mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetM = "SELECT * FROM tb_meterial";
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

<title>Add Meterial</title>
<script type="text/javascript" async="async" src="../Jq/Inputmask/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../jQuery/lib/jquery-1.8.3.min.js" charset="utf-8"></script>
<script type="text/javascript" src="../jQuery/dist/jquery.maskedinput.js"></script>
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
</style>
</head>
<body>
<?php include("layout-tool.php"); ?>

<div>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
<p style="text-align:center;"><b>เพิ่มวัสดุ</b></p>
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">ชื่อวัสดุ:</td>
      <td><input type="text" name="meterial_name" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">รหัสวัสดุ:</td>
      <td><input type="text" id="me_code"name="meterial_code" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">จำนวน:</td>
      <td><input type="text" name="meterial_item" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">รูปประกอบ:</td>
      <td><input type="file" name="meterial_img" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">สถานที่เก็บ:</td>
      <td><label for="store"></label>
        <select name="store" id="store">
          <?php
do {  
?>
          <option value="<?php echo $row_RecordsetStore['stores_id']?>"><?php echo $row_RecordsetStore['stores_name']?></option>
          <?php
} while ($row_RecordsetStore = mysql_fetch_assoc($RecordsetStore));
  $rows = mysql_num_rows($RecordsetStore);
  if($rows > 0) {
      mysql_data_seek($RecordsetStore, 0);
	  $row_RecordsetStore = mysql_fetch_assoc($RecordsetStore);
  }
?>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="เพิ่ม" />
      	<a href="detail-meterial.php">
      	<button type="button" class="submits" style="background-color:#F00">ยกเลิก</button>
      	</a>      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
</div>
</body>
</html>
<?php
mysql_free_result($RecordsetStore);

mysql_free_result($RecordsetM);
?>
