<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
</head>
<body>
<?php

include "../db_conn.php";

$excel = json_decode($_POST["excel"],true);
//print_r(json_decode($_POST["excel"],true));

if(!$excel){
	echo "<script>alert('업데이트 사항이 없습니다.');history.go(-1);</script>";
	exit();
}

$query = "insert into igo_bus_depositor(name,deposit,withdraw,date,bank,account) values ";

foreach($excel as $row){
	$query .= "('".$row["name"]."', ".$row["deposit"].", ".$row["withdraw"].", '".$row["date"]."', '".$row["bank"]."', '".$row["account"]."'), ";
}

$query = substr($query, 0, -2);


if($result = mysql_query($query)){
	$query = "update igo_bus_applicant, igo_bus_depositor set igo_bus_applicant.confirm=1, igo_bus_depositor.confirm=1 where igo_bus_applicant.name = igo_bus_depositor.name";
	if($result = mysql_query($query)){
		echo "success";
	}else
		die("qErr2");
}else
	die("qErr1");


?>
