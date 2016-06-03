<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 위 3개의 메타 태그는 *반드시* head 태그의 처음에 와야합니다; 어떤 다른 콘텐츠들은 반드시 이 태그들 *다음에* 와야 합니다 -->
<!-- 부트스트랩 -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- jQuery (부트스트랩의 자바스크립트 플러그인을 위해 필요합니다) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
<!-- 모든 컴파일된 플러그인을 포함합니다 (아래), 원하지 않는다면 필요한 각각의 파일을 포함하세요 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="http://momentjs.com/downloads/moment.js"></script>

<title>iBus</title>

<style>

td{
	padding:5px
}
</style>
</head>
<?php

header('Content-Type: text/html; charset=UTF-8');

error_reporting(0);

include "../db_conn.php";



// outer join으로 리팩토링해봐봐

//$query = "select * from igo_bus_applicant order by match where eventSeq = ".$_POST["eventSeq"];
$query = "select * from igo_bus_bus where eventSeq = 1 order by busNum";

echo "<div class='container'>";
$table = "<div class='row'><div class='col-md-3'></div><div class='col-md-5'><b>버스</b><table class='table table-hover'><tr align='center'><td>호차</td><td>출발시간</td><td>출발지</td><td>목적지</td><td>담당자</td></tr>";

if($result = mysql_query($query)){
	while($row = mysql_fetch_assoc($result)){
		$table .= "<tr align='center'><td>".$row["busNum"]."</td><td>".$row["start"]."</td><td>".$row["dep"]."</td><td>".$row["dest"]."</td><td>".$row["charger"]."</td></tr>";

	}
	$table .= "</table></div><div class='col-md-4'></div></div>";
	echo $table;
	echo '<div class="row"><div class="col-md-4"></div><div class="text-right col-md-4"><input type="button" onclick="add();" value="버스 추가"/></div><div class="col-md-4"></div></div>';
	echo "</div>";
}else
	die("qErr1");

?>
<body>
<script>

function add(){
	location.href="/addBus.php";
}
</script>
</body>