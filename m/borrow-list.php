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

$colname_Recordsetyous = "-1";
if (isset($_REQUEST['user_id'])) {
  $colname_Recordsetyous = $_REQUEST['user_id'];
}
mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordsetyous = sprintf("SELECT * FROM tb_borrow WHERE b_user_id = %s", GetSQLValueString($colname_Recordsetyous, "int"));
$Recordsetyous = mysql_query($query_Recordsetyous, $connectioneq) or die(mysql_error());
$row_Recordsetyous = mysql_fetch_assoc($Recordsetyous);
$colname_Recordsetyous = "-1";
if (isset($_GET['user_id'])) {
  $colname_Recordsetyous = $_GET['user_id'];
}
mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordsetyous = sprintf("SELECT * FROM tb_borrow inner join tb_user inner join tb_class inner join tb_faculty inner join tb_major inner join tb_tools inner join tb_type inner join tb_stores on tb_borrow.b_user_id = tb_user.id_log and tb_borrow.b_tool_id = tb_tools.tool_id and tb_user.class_id = tb_class.class_id and tb_user.faculty_id = tb_faculty.faculty_id and tb_user.major_id = tb_major.major_id and tb_tools.tool_type = tb_type.type_id and tb_tools.tool_store_id = tb_stores.stores_id WHERE b_user_id = %s", GetSQLValueString($colname_Recordsetyous, "int"));
$Recordsetyous = mysql_query($query_Recordsetyous, $connectioneq) or die(mysql_error());
$row_Recordsetyous = mysql_fetch_assoc($Recordsetyous);
$totalRows_Recordsetyous = mysql_num_rows($Recordsetyous);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Borrow List</title>
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
</style>
</head>
<body style="background-image:url(../img/back.jpg)">
<div style="text-align:center;background-color:#FFF">
	<table>
    <tr>
    	<td width="10%" style="background-color:#039">
        	<a href="borrow-system.php?search=">
        	<button type="button" class="submits">Back</button>
       	</a>        </td>
        <td width="10%" style="background-color:#039">
        	<a href="home.php">
        	<button type="button" class="submits">Home</button>
       	</a>        </td>
        <td width="80%" style="background-color:#CCC">
        <p><b>ระบบยืมคืนอุปกรณ์ :</b> Center for Microwave and Robotic Technology</p>
        <form id="form1" name="form1" method="post" action="">
          <input name="hiddenField" type="hidden" id="hiddenField" value="<?php echo $row_Recordsetyous['b_id_log']; ?>" />
        </form>
        </td>
    </tr>
    </table>
    <table border="1" width="110%">
    <tr>
        
      </tr>
      <tr>
        <th>ชื่อ-นามสกุล</th>
        <th>รหัสนักศึกษา</th>
        <th>ชั้นปี</th>
        <th>สาขาวิชา</th>
        <th>อุปกรณ์ที่ยืม</th>
        <th>รหัสอุปกรณ์</th>
        <th>ประเภทอุปกรณ์</th>
        <th>ที่เก็บอุปกรณ์</th>
        <th>วันที่ยืม</th>
        <th>กำหนดการคืน</th>
        <th>ตัวเลือก</th>
      </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $row_Recordsetyous['name_log']; ?></td>
          <td><?php echo $row_Recordsetyous['student_id_log']; ?></td>
          <td><?php echo $row_Recordsetyous['class_name']; ?></td>
          <td><?php echo $row_Recordsetyous['major_name']; ?></td>
          <td>
          <?php
          	if($row_Recordsetyous['image']!=""){
		  ?>
		  <img src="../img/<?php echo $row_Recordsetyous['image']; ?>" width="100" height="70" style="border:1px; border-color:#000;border-style: solid;"/><br/>
          <?php
			}
		  ?>
		  
		  <?php echo $row_Recordsetyous['tool_name']; ?>
          
          </td>
          <td><?php echo $row_Recordsetyous['tool_code']; ?></td>
          <td><?php echo $row_Recordsetyous['type_name']; ?></td>
          <td><?php echo $row_Recordsetyous['stores_name']; ?></td>
          <td><?php echo $row_Recordsetyous['b_date_borrow']; ?></td>
          <td><?php echo $row_Recordsetyous['b_date_return']; ?></td>
          <td>
       	    <a href="delete-return.php?b_id_log=<?php echo $row_Recordsetyous['b_id_log']; ?>&amp;user_id=<?php echo $row_Recordsetyous['id_log']; ?>">
       	    <button type="button" class="submits" onclick="return confirm('ต้องการคืน <?php echo $row_Recordsetyous['tool_name']; ?>')">คืนอุปกรณ์</button>
   	      </a></td>
        </tr>
        <?php } while ($row_Recordsetyous = mysql_fetch_assoc($Recordsetyous)); ?>
        </tr>
    </table>
</div>
</body>
</html>
<?php
mysql_free_result($Recordsetyous);
?>
