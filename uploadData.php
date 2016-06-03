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
?>

<body>

<div class="container">
 <div class="row">
  <div class="col-md-3"></div>
    <div class="col-md-5"><p align="center"><b>!!!주의사항!!!</b></p>
		1. 엑셀파일은 <b>xls(97-2003) 파일</b>로 변환해서 첨부해주세요.<br>
		<!-- 2. 데이터를 알맞은 칸에 첨부해주세요.<br><br> -->
	</div>
  </div>
 </div>
 <!-- 	<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-5">
 	<form action="modiAppl.php" method="post" id="data1" enctype="multipart/form-data" accept-charset="UTF-8">
 	  <div class="form-group">
 		<label for="applicantData">신청자 데이터</label>
 		<input type="file" name="applicantData" id="applicantData"/>
 	  </div>
 	  <div class="col-md-10"></div>
 	  <button type="button" onclick="check1();" class="btn btn-default">업데이트</button>
 	</form>
   </div>
  </div>
 </div> -->
 <div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-5">
	<form action="modiDepo.php" method="post" id="data2" enctype="multipart/form-data" accept-charset="UTF-8">
	  <div class="form-group">
		<label for="depositorData">입금자 데이터</label>
		<input type="file" name="depositorData" id="depositorData"/>
	  </div>
	  <div class="col-md-10"></div>
	  <button type="button" onclick="check2();" class="btn btn-default">업데이트</button>
	  <br><br>
	</form>
  </div>
 </div>
<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-5">
	  <button type="button" onclick="location.href='list.php';" class="btn btn-primary btn-lg btn-block">인원관리</button>
  </div>
 </div>




<script>
function check1(){
	if($("#applicantData").val().match(/(.+)\.xls/)){
		if(confirm("파일이 '신청자' 데이터가 맞습니까?"))
			$("#data1").submit();
	}else
		alert("파일을 확인해 주세요");
}

function check2(){
	if($("#depositorData").val().match(/거래내역조회(.+)\.xls/)){
		if(confirm("파일이 '입금자' 데이터가 맞습니까?"))
			$("#data2").submit();
	}else
		alert("파일을 확인해 주세요");
}

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