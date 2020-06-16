mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
if(mui.os.plus){
    mui.plusReady(function() {
        Guanyu_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        Guanyu_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (Guanyu_按下返回键()!=true) {
        mui_back();
    }
};

var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
var 搜索颜色 = 读写设置.读取设置("搜索颜色");
document.getElementById("标题栏1").style.background = 背景颜色;
document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>关于我们</h1>";
function Guanyu_创建完毕(){
var div=document.createElement("div");
	div.innerHTML = "<div class='minirefresh-scroll'><div id=推荐 style='list-style: none;'></div><div id=其他 style='list-style: none;display: none;'></div></div>";
	div.id = "minirefresh";
	div.class = "minirefresh-wrap";
	div.style.overflow = "inherit";
	document.body.appendChild(div);
	document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);

var div=document.createElement("div");
	div.innerHTML = "<ul id=其他列表 class='mui-table-view mui-grid-view' style='padding: 0;'></ul>";
	document.body.appendChild(div);
	document.getElementById("其他").appendChild(div);
	html = "<div style='text-align: center;'><p id='列表0' style='width:100%;color:#A7A7A7;font-size:14px;padding:0px; margin:23% 0px 0px 0px;'>" + 公用模块.APP标题() + "</p></div>"+
	"<div style='text-align: center;'><img src="+读写设置.读取设置("分享图片")+" style='width: 150px;height:150px;margin: 10% 0px 0px 0px;' /></div>"+
	"<div style='text-align: center;'><p id='列表0' style='width:100%;color:#A7A7A7;font-size:14px;padding:0px; margin: 5% 0px 0px 0px;'>微信扫一扫关注我们</p></div>"+
	"</ul>";
	顶部插入div(html);
	mui("#分享列表").on("tap", "li", function() { 分享被单击(this.getAttribute("index"));});
}
function 顶部插入div(html){
var newNodeBottom = document.createElement("div");
    newNodeBottom.innerHTML = html;
	document.getElementById("推荐").appendChild(newNodeBottom);
}
function 标题栏1_左侧图标被单击(){
var self = plus.webview.currentWebview();
	plus.webview.close(self,"slide-out-right");
}
function Guanyu_按下返回键(){
var self = plus.webview.currentWebview();
	plus.webview.close(self,"slide-out-right");
}