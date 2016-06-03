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
<body>
<div class="container">
 <div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-5">
	<form action="addBus.php" method="post" id="data">
	  <div class="form-group">
		<label for="busNum">호차</label>
		<input type="text" class="form-control" name="busNum" id="busNum" placeholder="1">
	  </div>
	  <div class="form-group">
		<label for="start">출발일시</label>
		<input type="text" class="form-control" name="start" id="start" placeholder="2015-09-25 15:00">
	  </div>
	  <div class="form-group">
		<label for="dep">출발지</label>
		<input type="text" class="form-control" name="dep" id="dep" placeholder="학교">
	  </div>
	  <div class="form-group">
		<label for="dest">도착지</label>
		<input type="text" class="form-control" id="dest" name="dest" placeholder="동서울">
	  </div>
	  <div class="form-group">
		<label for="charger">담당자</label>
		<input type="text" class="form-control" name="charger" id="charger" placeholder="한동이">
	  </div>
	  <div class="col-md-10"></div>
	  <button type="button" onclick="check();" class="btn btn-default">추가</button>
	</form>
  </div>
 </div>
 </div>


<script>
function check(){
	if($("#busNum").val() == ""){
		alert("호차를 입력해주세요");
		$("#busNum").focus();
	}else if($("#start").val() == ""){
		alert("출발일시를 형식에 맞게 입력해주세요");
		$("#start").focus();
	}else if($("#dep").val() == ""){
		alert("출발지를를 입력해주세요");
		$("#dep").focus();
	}else if($("#dest").val() == ""){
		alert("도착지를 입력해주세요");
		$("#dest").focus();
	}else
		$("#data").submit();
}
</script>
</body>