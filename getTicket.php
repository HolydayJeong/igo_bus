<?php

header('Content-Type: text/html; charset=UTF-8');

error_reporting(0);

include "../db_conn.php";

$query = "select * from igo_bus_applicant left join igo_bus_bus on igo_bus_applicant.busSeq = igo_bus_bus.seq where igo_bus_applicant.eventSeq=1 and name = '".$_POST['name']."'";

$rtn = array();
if($result = mysql_query($query)){
	while($row = mysql_fetch_assoc($result)){
		array_push($rtn, array("name"=>$row['name'],"busNum"=>$row['busNum'], "dep"=>$row['dep'], "dest"=>$row['dest'], "start"=>$row['start'], "confirm"=>$row['confirm']));

	}
//	echo "success";
	print json_encode($rtn);
}else
	die("qErr1");

?>