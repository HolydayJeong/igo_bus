<?php

header('Content-Type: text/html; charset=UTF-8');

error_reporting(0);

include "../db_conn.php";



// outer join으로 리팩토링해봐봐

$query = "insert into igo_bus_bus(eventSeq, busNum, start, dep, dest, charger) values (1, ".$_POST['busNum'].", '".$_POST['start']."', '".$_POST['dep']."', '".$_POST['dest']."', '".$_POST['charger']."')";

echo $query;

if($result = mysql_query($query)){
	echo "<script>location.replace('eventManage.php');</script>";
}else
	die("qErr1");

?>