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

$colname_RecordsetTools = "''";
if (isset($_GET['qrcode'])) {
  $colname_RecordsetTools = $_GET['qrcode'];
}
mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetTools = sprintf("SELECT * FROM tb_borrow inner join tb_user inner join tb_class inner join tb_faculty inner join tb_major inner join tb_tools inner join tb_type inner join tb_stores on tb_borrow.b_user_id = tb_user.id_log and tb_borrow.b_tool_id = tb_tools.tool_id and tb_user.class_id = tb_class.class_id and tb_user.faculty_id = tb_faculty.faculty_id and tb_user.major_id = tb_major.major_id and tb_tools.tool_type = tb_type.type_id and tb_tools.tool_store_id = tb_stores.stores_id WHERE tb_tools.tool_code  LIKE %s", GetSQLValueString("%" . $colname_RecordsetTools . "%", "text"));
$RecordsetTools = mysql_query($query_RecordsetTools, $connectioneq) or die(mysql_error());
$row_RecordsetTools = mysql_fetch_assoc($RecordsetTools);
$colname_RecordsetTools = "''";
if (isset($_GET['qrcode'])) {
  $colname_RecordsetTools = $_GET['qrcode'];
}
mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetTools = sprintf("SELECT * FROM tb_borrow inner join tb_user inner join tb_class inner join tb_faculty inner join tb_major inner join tb_tools inner join tb_type inner join tb_stores on tb_borrow.b_user_id = tb_user.id_log and tb_borrow.b_tool_id = tb_tools.tool_id and tb_user.class_id = tb_class.class_id and tb_user.faculty_id = tb_faculty.faculty_id and tb_user.major_id = tb_major.major_id and tb_tools.tool_type = tb_type.type_id and tb_tools.tool_store_id = tb_stores.stores_id WHERE tb_tools.tool_code  LIKE %s", GetSQLValueString("%" . $colname_RecordsetTools . "%", "text"));
$RecordsetTools = mysql_query($query_RecordsetTools, $connectioneq) or die(mysql_error());
$row_RecordsetTools = mysql_fetch_assoc($RecordsetTools);
$totalRows_RecordsetTools = mysql_num_rows($RecordsetTools);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<title>QR Borrow</title>
</head>
<body>
<div style="padding-bottom:20px">
</div>
<div class="container" style="background-color:#999; padding-bottom:50px;">
<form name="qr" method="POST">
<div class="w3-half" align="center" style="padding-left:5px">
    <table>
      <tr>
        <th colspan="2" style="font-size:20px; text-align:center">รายระเอียดอุปกรณ์ที่คืน
          <input name="hiddenField2" type="hidden" id="hiddenField2" value="<?php echo $row_RecordsetTools['tool_id']; ?>" /></th>
      </tr>
      
    <tr>
     <th colspan="2" style="text-align:center">
      <p><img src="img/<?php echo $row_RecordsetTools['image']; ?>" width="100" height="70" style="border:1px; border-color:#000;border-style: solid;"/></p>
     </th>
     <tr>
      <td><input name="hiddenField" type="hidden" id="hiddenField" value="<?php echo $row_RecordsetTools['b_id_log']; ?>"></td>
     </tr>
     <tr valign="baseline">
          <td nowrap="nowrap" align="right">ชื่อ-นามสกุล คนยืม :</td>
          <td><input type="text" disabled="disabled" name="tool_code" value="<?php echo $row_RecordsetTools['name_log']; ?>" size="20"  /></td>
      </tr>  
                 
      <tr valign="baseline">
          <td nowrap="nowrap" align="right">รหัสอุปกรณ์ :</td>
          <td><input type="text" disabled="disabled" name="tool_code" value="<?php echo $row_RecordsetTools['tool_code']; ?>" size="20"  /></td>
      </tr>
        
         <tr valign="baseline">
          <td nowrap="nowrap" align="right">ชื่ออุปกรณ์ :</td>
          <td><input type="text" disabled="disabled" name="tool_name" value="<?php echo $row_RecordsetTools['tool_name']; ?>" size="20"  /></td>
        </tr>
        
         <tr valign="baseline">
          <td nowrap="nowrap" align="right">ชื่อประเภท :</td>
          <td><input type="text" disabled="disabled" name="tool_type" value="<?php echo $row_RecordsetTools['type_name']; ?>" size="20"  /></td>
        </tr>
        
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">สถานที่จัดเก็บ :</td>
          <td ><input type="text" disabled="disabled" name="tool_store" value="<?php echo $row_RecordsetTools['stores_name']; ?>" size="20"  /></td>
        </tr> 
        
        <tr valign="baseline">
          <td colspan="2" style="text-align:center"><label for="dates_b">วันที่คืน : <?php echo date("Y/m/d"); ?>
            <input name="returned" type="hidden" id="returned" value="<?php echo date("Y/m/d"); ?>">
          </label></td>
        </tr>
        
        <tr valign="baseline" >
          <td align="center" colspan="2" ><!--
          --><a href="delete-return-3.php?b_id_log=<?php echo $row_RecordsetTools['b_id_log']; ?>">
          <button type="button" class="btn btn-success" >คืน</button>&nbsp;<!-- --></a><!--
		-->
          <a href="home.php">
          <button type="button" class="btn btn-danger">ยกเลิก</button>
          </a>
          </td>
        </tr>
        </th>
   </tr>
    </table>
   </div>
</form>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>
<?php
mysql_free_result($RecordsetTools);
?>
