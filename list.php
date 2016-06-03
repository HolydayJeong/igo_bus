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

function setBusNum($seq, $num, $selector){
	$select = '<select id="sel'.$seq.'" class="select form-control">';
	if($num == 0)
		$select .= "<option selected='selected'></option>";
	for($i=1; $i<=count($selector); $i++){
		if($i == $num){
			$select .= "<option selected='selected'>".$i."</option>";
		}else
			$select .= "<option>".$i."</option>";
	}
	return $select;
		
}

// selector 만들기
$query = "select * from igo_bus_bus where eventSeq = 1 order by busNum";	// 버스 리스트 가져오기

$selector = array();

if($result = mysql_query($query)){
	while($row = mysql_fetch_assoc($result)){
		array_push($selector, array("busSeq"=>$row['seq'],"busNum"=>$row['busNum']));
	}
}



// outer join으로 리팩토링해봐봐

//$query = "select * from igo_bus_applicant order by match where eventSeq = ".$_POST["eventSeq"];
$query = "select igo_bus_applicant.seq, name, phNum, igo_bus_bus.eventSeq, busSeq, busNum, friendNum from igo_bus_applicant left join igo_bus_bus on igo_bus_applicant.busSeq = igo_bus_bus.seq order by confirm, busNum";

$noBus = "<div class='col-md-3'></div><div class='col-md-6'><b>버스 미배정</b><table class='table table-hover'><tr align='center'><td>성명</td><td>연락처</td><td>버스번호</td><td>동승자</td></tr>";
$finished = "<div class='col-md-3'></div><div class='col-md-6'><b>배정 완료</b><table class='table table-hover'><tr align='center'><td>성명</td><td>연락처</td><td>버스번호</td><td>동승자</td></tr>";
$dontknow = "<div class='col-md-3'></div><div class='col-md-6'><b>수취인 불명</b><table class='table table-hover'><tr align='center'><td>성명</td><td>금액</td><td>날짜</td></tr>";

if($result = mysql_query($query)){
	while($row = mysql_fetch_assoc($result)){
		if($row['busNum'] == 0){
			// 원래 이벤트 번호도 있었다!!!! 그 이름은 eventSeq
			$noBus .= "<tr align='center'><td>".$row["name"]."</td><td>0".$row["phNum"]."</td><td>".setBusNum($row['seq'],0,$selector)."</td><td>".$row["friendNum"]."</td></tr>";
		}else
			$finished .= "<tr align='center'><td>".$row["name"]."</td><td>0".$row["phNum"]."</td><td>".setBusNum($row['seq'],$row['busNum'],$selector)."</td><td>".$row["friendNum"]."</td></tr>";
		//$table .= "<tr align='center'><td>".$row["name"]."</td><td>".$row["phNum"]."</td><td>".$row["eventSeq"]."</td><td>".$row["busSeq"]."</td><td>".$row["friendNum"]."</td></tr>";
	}
	$query = "select * from igo_bus_depositor where confirm = 0 order by date";

	if($result = mysql_query($query)){
		while($row = mysql_fetch_assoc($result)){
			$dontknow .= "<tr align='center'><td>".$row["name"]."</td><td>".$row["deposit"]."</td><td>".$row["date"]."</td></tr>";
		}
		$noBus .= "</table></div><div class='col-md-3'></div>";
		$dontknow .= "</table></div><div class='col-md-3'></div>";
		$finished .= "</table></div><div class='col-md-3'></div>";

		echo $noBus."<div class='row'></div>";
		echo $dontknow."<div class='row'></div>";
		echo $finished."<div class='row'></div>";
	}else
		die("qErr2");

}else
	die("qErr1");
?>
<body style="margin-top:50px;">
<script>
$(document).ready(function(){
	bus = eval(<?php echo json_encode($selector); ?>);
	$(".select").change(function(){
		for(i in bus){
			if($(this).val() == bus[i].busNum)
				busSeq = bus[i].busSeq;
		}
		$.post("updateBus.php", ({seq:$(this).attr("id").substring(3), bus:busSeq}), function(dbresult){
			if("success" == dbresult){
				alert("변경되었습니다.");
//				location.replace("list.php");
			}else
				alert("변경 실패. 관리자에게 문의하세요.");
		});
	});
});
</script>



</body>