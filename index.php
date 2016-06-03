<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
@import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);

td{
	padding:5px
}

.ticket-wrapper{

margin-bottom:20px;
box-shadow: 5px 5px 5px rgba(0,0,0,0.2);

border-top-left-radius: 35px;
border-top-right-radius: 0px;
border-bottom-right-radius: 5px;
border-bottom-left-radius: 5px;
border: solid 1px #DDDDDD;
display:none;

}

.ticket-head{

padding: 10px 15px;
border-bottom:1px solid transparent;
border-top-left-radius: 35px;
border-top-right-radius: 0px;
background-color: #3ED83E;
color: #FFF;
font-family: 'Nanum Gothic', sans-serif;
text-align:center;
}

.ticket-title{
font-weight:900;
font-size:20;

}


.ticket-guide{
font-size: 12px;
vertical-align: text-bottom;
}

.ticket-info{
font-size: 20px;
font-weight: 900;
}

.center{
 text-align: center;

}

.ticket-body{

padding:15px 15px 15px 15px;

}

.margin-cross{
margin-left:-10px;
}

</style>



</head>
<body style="margin-top:50px;">
<div class="container">
<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6"><h3>주말버스</h3></div>
	<div class="col-md-3"></div>
</div>

<!-- 공지사항은 여기에 넣도록 하자 -->

<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6"><button class="btn btn-default">티켓, 입금확인</button></div>
	<div class="col-md-3"></div>
</div>
<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6"><button class="btn btn-default">신청하기</button></div>
	<div class="col-md-3"></div>
</div>

<!-- 

	 <div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6"><p align="center" style="font-size:15px"><b>버스 티켓 확인</b></p><br></div>
		<div class="col-md-3"></div>
	 </div>

	 <div class="row">
	  <div class="col-md-3"></div>
	  <div class="col-md-6" align="center">
		<form class="form-inline" action="javascript:check();" id="data">
		  <div class="form-group">
			<label for="name">성명+학번(끝세자리)</label>
			<input type="text" class="form-control" name="name" id="name" placeholder="한동이024">
		    <button type="button" onclick="check();" class="btn btn-default">검 색</button>
		  </div>
		</form>
	  </div>
	  <div class="col-md-3"></div>
	 </div>
-->
</div>

<!--<div class="container">
  <div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6">
	  <div id="ticket">
		<table id="tTable" class="table table table-bordered">
		<tr align='center'>
		<td>이름+학번</td><td>호차</td><td>출발지</td><td>도착지</td><td>출발시간</td><td>입금확인</td>
		<tr>
		</table>
	  </div>	
  </div>
  </div>
</div>
-->



<script>
function check(){
	if($("#name").val() == ""){
		alert("이름+학번을 입력해주세요");
		$("#name").focus();
	}else{
		$.post("getTicket.php", {name:$("#name").val()}, function(dbresult){
			if(dbresult){
				var arr = eval(dbresult);
				if(typeof arr[0] != "undefined"){
					if(arr[0]['confirm'] == 0 )
						arr[0]['isOk'] = '미확인';
					else
						arr[0]['isOk'] = '확인';
				
					$("#pTicket").remove();

					if(!arr[0]['busNum']){
						$("#tTable").append("<tr id='pTicket' align='center'><td>"+arr[0]['name']+"</td><td>-</td><td>-</td><td>-</td><td>-</td><td>"+arr[0]['isOk']+"</td></tr>");
					}else{
						$("#tTable").append("<tr id='pTicket' align='center'><td>"+arr[0]['name']+"</td><td>"+arr[0]['busNum']+"</td><td>"+arr[0]['dep']+"</td><td>"+arr[0]['dest']+"</td><td>"+arr[0]['start']+"</td><td>"+arr[0]['isOk']+"</td></tr>");
					}
				}else{
					$("#pTicket").remove();
					$("#tTable").append("<tr id='pTicket' align='center'><td colspan='6'>결과가 없습니다.</td></tr>");
				}

			}
			$(".ticket-wrapper").css("display", "block");
		});
	}
}

</script>

<div class="container">
	<div class="row">
		<div class="col-md-5"></div>
		<div class="col-md-3">
			<div class="ticket-wrapper">
			  <div class="ticket-head">
				<span class="ticket-title">추석버스</span>
			  </div>
			  <div class="panel-body">
			  <div style="width:90%">한동대생123</div> 
				
				<div class="row">
					<table style="width:90%;margin:auto">
						<tr align="center">
							<td><span class="ticket-guide">출발 </span><span class="ticket-info">포항</span></td>
							<td>
								<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
								<span class="glyphicon glyphicon-menu-right margin-cross" aria-hidden="true"></span>
							</td>
							<td><span class="ticket-guide">도착 </span><span class="ticket-info">서울</span></td>
						</tr>
					</table>
				 </div>
				 
				 <div class="row" style="margin-top:10px">
					<table class="table" style="width:90%;margin:auto">
						<tr align="center">
							<td style="min-width:55px;"><span class="ticket-guide">호차</span></td>
							
							<td><span class="ticket-guide">날짜</span></td>
						</tr>
						<tr align="center">
							<td><span id="busNum" class="ticket-info">4</span></td>
							
							<td><span id="date" class="ticket-info">09/25 14:00</span></td>
						</tr>
					</table>
				 </div>
				 
				  <div class="row" style="margin-top:10px">
					<table style="margin:auto">
						<tr align="center">
							<td></td>
							<td><span class="ticket-guide">입금여부</span></td>
							<td><span class="ticket-info">확인</span></td>
						</tr>
					</table>
				 </div>
			  </div>
			</div><!--/panel -->
		</div><!-- /col-md-3-->
		<div class="col-md-4"></div>

	</div><!--/row-->
</div><!-- /container-->

</body>