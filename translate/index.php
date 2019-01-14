<?php
include_once("./inc/config.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>千语翻译</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="icon" href="./favicon.ico" type="image/x-icon"/>
<script src="./js/jquery-1.11.3.min.js" language="javascript"></script>
<script src="./js/mobile.viewport.2.0.js" language="javascript"></script>
<style type="text/css"> 
body,div,p,span,img,ul,li,a{ margin:0; padding:0;}
ul,li{ list-style:none;}
body{ background:#f0efed; font-size:36px;}
.page{ width:750px; margin:0 auto;}
.logo{ width:329px; height:70px; margin:40px auto 100px; background:url('./logo.png');}
.page1{ padding-top:140px;}
.page1 .searchBox{ width:590px; height:80px; margin:0 auto; border:2px solid #bababa; border-radius:90px; padding:5px 45px; background:#fff; overflow:hidden;}
.page1 .searchBox .mcon{width:500px; float:left;}
.page1 .searchBox input{ border:none; line-height:80px; font-size:36px; width:100%; margin-left:-20px;}
.page1 .serachicon{ width:48px; height:48px;background:url('./search.png'); background-size:cover;float:right; margin:20px -20px 0 0;}
.page1 .hot{ margin:80px auto 0; width:700px;}
/*.page1 .hot .hoticon{ width:74px; height:95px;background:url('./hot.png'); color:#c00;}*/
.guide{ color:#333;margin:0 0 30px  16px;}
.page1 .hot .hoticon{  color:#c00;}
.page1 .hot .hotcon{ line-height:45px; font-size:30px; color:#444; margin-top:20px;}
.page1 .hot .hotcon span{ margin:20px; display:inline-block;}
.page2{ color:#333; }
.page2 h4{ text-align:center; margin:60px auto;}
.table{    min-height: .8rem;
    position: relative;
    overflow: hidden;
    z-index: 0;
    background:#FDFDFC;
	width:700px; margin:20px auto;
	}
.table:before {
    content: '';
    position: absolute;
    width: 25%;
    left: 25%;
    height: 100%;
    border-left: 1px solid #ddd8ce;
    border-right: 1px solid #ddd8ce;
}
.table:after {
    content: '';
    position: absolute;
    width: 10%;
    left: 75%;
    height: 100%;
    border-left: 1px solid #ddd8ce;
    border-right: none;
}
.table li{
    display: inline-block;
    width: 25%;
    height: 60px;
    line-height: 60px;
    font-size: 28px;
    text-align: center;
    border-bottom: 1px solid #ddd8ce;
    margin-bottom: -1px;
    float: left;
    position: relative;
    z-index: 10;
}
a.react, label.react {
    display: block;
    color: inherit;
    height: 100%;
    overflow-x: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
li .react.on{ color:#fff; font-weight:bold; background:#1aac19;}
.scon{ width:660px; height:70px;border-radius:70px; padding:0 20px;background:#fff;margin:20px auto; overflow:hidden;}
.scon #key2{ border:none; width:600px; line-height:70px; height:70px;background:#fff;border-radius:70px; font-size:30px; color:#000;}
.result{ width:660px; margin:20px auto 60px; background:#fff; line-height:50px; font-size:28px; color:#000; min-height:160px; padding:10px 10px 10px 30px; font-weight:bold; position:relative;}
.copy{ width:200px; font-size:30px; height:60px; line-height:60px; background:#1aac19; position:absolute; right:10px; top:-80px; border-radius:10px; color:#fff; text-align:center; display:none;}
.sub{ width:600px; height:80px; line-height:80px; text-align:center; margin:40px auto; background:#1aac19; color:#fff; font-size:30px; font-weight:bold; border-radius:10px;}
</style>

</head>

<body class="report_sub"> 
	<div class="page page1">
    	<div class="logo"></div>
        <div class="searchBox">
        	<div class="mcon">
        		<input type="text" id="key"  width="600" placeholder="请输入要翻译的文本">
            </div>
            <div class="serachicon"></div>
        </div>
        <div class="hot">
        	<div class="guide hoticon">热门查询</div>
        	<div class="hotcon">
            	<?php foreach($hot as $v){?>
                <span><?php echo $v;?></span>
                <?php }?>
            </div>
        </div>
    </div>
    <div class="page page2" style="display:none;">
    	<div class="logo"></div>
    	<div class="guide">输入语句</div>
        <div class="scon">
        		<input type="text" id="key2" >
                <div class="close"></div>
        </div>
        <div class="guide">选择目标语言</div>
        <div class="table">
        <?php foreach($lang as $k=>$v){
			if($k=="zh") continue;	
		?>
        	<li><a  class="react<?php if(in_array($v,$defaultLang)!==false){?> on<?php }?>" name="<?php echo $k;?>"><?php echo $v;?></a></li>
        <?Php }?>
   		 </div>
         <div class="sub" onClick="subWord();">生成</div>
         <div class="guide">结果</div>
         <div class="result">
         	<div class="copy" data-clipboard-action="copy" data-clipboard-target="#rs">点击复制结果</div>
            <div class="rs" id="rs"></div>
         </div>
    </div>
 
</body>


</html>
<script type="text/javascript" src="./js/canvasResizePack.2.0.js"></script>
<script src="./js/clipboard.min.js"></script>
<script>
//复制按钮
var clipboard = new ClipboardJS('.copy');

    clipboard.on('success', function(e) {
		alert("已复制");
        console.log(e);
    });

    clipboard.on('error', function(e) {
		alert("您的浏览器暂不支持复制，请您选中文本复制");
        console.log(e);
 });
//上传图片
	var keyword="";
	$(function(){
		  $(".react").on("click",function(){
			$(this).toggleClass("on");  
		  });
		  $(".hotcon span").on("click",function(){
		  		keyword=$(this).text();
				toPage2();
		  })
		  
		  $("#key").on("click",function(){
				toPage2();
		  });
 });
 
 function toPage2(){
	$(".page1").hide();
	$(".page2").show();
	$("#key2").focus().val(keyword);
 }
var isSub=false;
function subWord(){
	var langArr=[];
	keyword=$.trim($("#key2").val());
	$(".react.on").each(function(index, element) {
        var nname=$(this).attr("name");
		langArr.push(nname);
    });
	var langs=langArr.join(",");
	if(keyword==""){
		alert("請輸入您要翻譯的語言！")	;
		$("#key2").focus();
		return false;
	}
	if(langs==""){
		alert("请选择最少一种目标翻译语言");
		return false;
	}
	if(isSub) return false;
	isSub = true;	
	$.ajax({ 
		type: "post", 
		url: "translateApi.php?r="+Math.random(), 
		data: {keyword:keyword,langs:langs},
		error: function() {
			isSub = false;
		}, 
		timeout:20000,
		success: function(data) {
			$(".rs").html(data);
			isSub = false;
			console.log(data);
		} 
	});	
}

</script>