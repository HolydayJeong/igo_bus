<?php
// Test CVS

require_once 'Excel/reader.php';
include "../db_conn.php";

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

$data->read('test.xls');

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

$query = "insert into igo_bus_depositor(name,withdraw,deposit,date,bank,account) values ";

//for ($i = 8; $i <= $data->sheets[0]['numRows']; $i++) {
for ($i = 8; $i <= 10; $i++) {
	$query .= "('".$data->sheets[0]['cells'][$i][6]."',".$data->sheets[0]['cells'][$i][3].", ".$data->sheets[0]['cells'][$i][4].", '".$data->sheets[0]['cells'][$i][2]."' , '".$data->sheets[0]['cells'][$i][8]."', '".$data->sheets[0]['cells'][$i][7]."'), ";
}

$query = substr($query, 0, -2);

if(mysql_query($query)){
	echo "Success";
}else
	die("qErr");

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
