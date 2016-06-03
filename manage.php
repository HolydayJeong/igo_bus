<?php
	header('Content-Type: text/html; charset=UTF-8');

	error_reporting(0);

	include "../db_conn.php";

	$query = "select * from igo_bus_applicant 