<?php
	error_reporting(0);
	include "../db_conn.php";
	
	$query = "update igo_bus_applicant set busSeq = ".$_POST['bus']." where seq = ".$_POST['seq'];

	if($result = mysql_query($query))
		echo "success";
	else
		echo "fail";

?>