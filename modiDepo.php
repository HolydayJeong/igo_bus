<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
</head>
<body>
<?php

header('Content-Type: text/html; charset=UTF-8');

require_once 'Excel/reader.php';
include "../db_conn.php";

$uploaddir = '/host/home1/jholyday/html/busReg/uploads/';
//$uploadfile = $uploaddir . basename($_FILES['depositorData']['name']);
$uploadfile = $uploaddir.$_FILES['depositorData']['name'];
$uploadfile = iconv("UTF-8","EUC-KR",$uploadfile);
//echo $_FILES['depositorData']['name']."<br><br>";
//echo $uploadfile."<br><br>";

if (!move_uploaded_file($_FILES['depositorData']['tmp_name'], $uploadfile)) {
	echo "<script>alert('파일 업로드 공격의 가능성이 있습니다!');history.go(-1);</script>";
}

// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();


// Set output Encoding.
//$data->setOutputEncoding('CP1251');
$data->setOutputEncoding('UTF-8');

/***
* if you want you can change 'iconv' to mb_convert_encoding:
* $data->setUTFEncoder('mb');
*
**/

/***
* By default rows & cols indeces start with 1
* For change initial index use:
* $data->setRowColOffset(0);
*
**/



/***
*  Some function for formatting output.
* $data->setDefaultFormat('%.2f');
* setDefaultFormat - set format for columns with unknown formatting
*
* $data->setColumnFormat(4, '%.3f');
* setColumnFormat - set format for column (apply only to number fields)
*
**/

$data->read($uploadfile);

/*


 $data->sheets[0]['numRows'] - count rows
 $data->sheets[0]['numCols'] - count columns
 $data->sheets[0]['cells'][$i][$j] - data from $i-row $j-column

 $data->sheets[0]['cellsInfo'][$i][$j] - extended info about cell
    
    $data->sheets[0]['cellsInfo'][$i][$j]['type'] = "date" | "number" | "unknown"
        if 'type' == "unknown" - use 'raw' value, because  cell contain value with format '0.00';
    $data->sheets[0]['cellsInfo'][$i][$j]['raw'] = value if cell without format 
    $data->sheets[0]['cellsInfo'][$i][$j]['colspan'] 
    $data->sheets[0]['cellsInfo'][$i][$j]['rowspan'] 
*/

error_reporting(E_ALL ^ E_NOTICE);

$excel = array();

for ($i = 8; $i <= $data->sheets[0]['numRows']; $i++) {
	array_push($excel , array("name"=>$data->sheets[0]['cells'][$i][6],"withdraw"=>$data->sheets[0]['cells'][$i][3],"deposit"=>$data->sheets[0]['cells'][$i][4],"date"=>$data->sheets[0]['cells'][$i][2],"bank"=>$data->sheets[0]['cells'][$i][8],"account"=>$data->sheets[0]['cells'][$i][7]));
}

var_dump($excel);
/*
$date = Date($array[count($array)-1]["date"]);

echo "date : ".$array[0]["date"];
echo "<br><br>date : ".$date;
*/

$query = "select * from igo_bus_depositor where deposit > 0";		// 쿼리 속도 측정해보자. select 하면서 넣는것과 select하고 insert하는것.

$list = array();

if($result = mysql_query($query)){
	while($row = mysql_fetch_assoc($result)){
		array_push($list, array("name"=>$row["name"],"deposit"=>$row["deposit"],"date"=>$row["date"]));
	}
}else
	die("qEr1");


/*for ($i = 8; $i <= $data->sheets[0]['numRows']; $i++) {
	for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
		echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
	}
	echo "\n";

}
*/

//print_r($data);
//print_r($data->formatRecords);
?>
<form action="insertDB.php" id="form" method="post">
<input type="hidden" id="data" name="excel" />

<script>
$(document).ready(function(){
	excel = eval(<?php echo json_encode($excel) ?>);
	list = eval(<?php echo json_encode($list) ?>);

	for (var i in excel){
		for (var j in list){
			if(list[j]["name"] == excel[i]["name"])
				excel.splice(i,1);
		}
	}

	$("#data").val(JSON.stringify(excel));
	$("#form").submit();
});
</script>
</body>
</html>