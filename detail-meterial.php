<?php require_once('Connections/connectioneq.php'); ?>
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
$query_RecordsetMe = "SELECT * FROM tb_meterial, tb_stores WHERE tb_meterial.meterial_store_id = tb_stores.stores_id";
$RecordsetMe = mysql_query($query_RecordsetMe, $connectioneq) or die(mysql_error());
$row_RecordsetMe = mysql_fetch_assoc($RecordsetMe);
$totalRows_RecordsetMe = mysql_num_rows($RecordsetMe);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>detail metail</title>
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
<?php include("layout-tool.php"); ?>
<div style="background-color:#FFF; text-decoration:none;">
<div class="contrainer" style="padding-top:20px; padding-left:20px; padding-right:20px; padding-bottom:20px">
<table border="1" width="110%">
<tr>
	<tr>
          <th colspan="5" style="background-color:#395FEA">รายชื่ออุปกรณ์</th>
          <th style="background-color:#666" width="10%">ตัวเลือก</th>
     </tr>
  <tr>
    <th>รหัสวัสดุ</th>
    <th>ชื่อวัสดุ</th>
    <th>จำนวน</th>
    <th>รูปประกอบ</th>
    <th>สถานที่เก็บ</th>
    <th style="background-color:#FFF">
      <a href="insert_meterial.php">
      <button type="button">เพิ่มรายการพัสดุ</button>
      </a>    </th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_RecordsetMe['meterial_code']; ?></td>
      <td><?php echo $row_RecordsetMe['meterial_name']; ?></td>
      <td><?php echo $row_RecordsetMe['meterial_item']; ?></td>
      <td><?php echo $row_RecordsetMe['meterial_img']; ?></td>
      <td><?php echo $row_RecordsetMe['stores_name']; ?></td>
      <td><a href="delete-meterial.php?meterial_id=<?php echo $row_RecordsetMe['meterial_id']; ?>">
        <button onclick="return confirm('ยืนยันการลบ <?php echo $row_RecordsetMe['meterial_name']; ?>')">ลบ</button>
      </a><a href="update-meterial.php?meterial_id=<?php echo $row_RecordsetMe['meterial_id']; ?>">
      <button>แก้ไข</button>
      </a></td>
    </tr>
    <?php } while ($row_RecordsetMe = mysql_fetch_assoc($RecordsetMe)); ?>
    </tr>
</table>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($RecordsetMe);
?>
