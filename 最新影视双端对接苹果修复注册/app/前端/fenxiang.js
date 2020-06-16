mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
var 剪贴板1 = new 剪贴板("剪贴板1");
var 微信分享1 = new 微信分享("微信分享1",null,null);
if(mui.os.plus){
    mui.plusReady(function() {
        Fenxiang_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        Fenxiang_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (Fenxiang_按下返回键()!=true) {
        mui_back();
    }
};

function Fenxiang_创建完毕(){
document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;'>返回</h1>";
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
	html = "<img src=images/fenxiang/hb_shaore_banner.png style='width: 100%;margin: 0px 0px 0px 0px;' />"+
	"<ul><label id='列表0' style='text-align: center;color:#A7A7A7;margin-top: 0px;'>您的邀请码为： " + 读写设置.读取设置("邀请码") + "</label></ul>"+
	"<ul><label id='列表2' style='text-align: center;color:#A7A7A7;margin-top: 0px;'>分享给好友获取VIP</label></ul>"+

	"<div id=分享列表><ul style='width: 100%;padding: 0;list-style: none;font-family: 黑体;line-height: 20px;margin: 0;'>"+
	"<li style='width:33%;float: left;text-align: -webkit-center;' index=0 >"+
	"<img src=images/fenxiang/hb_share_wx_new.png style='width: 42px;height: 42px;margin-top: 5px;' />"+
	"<p style='color:#A7A7A7;margin-top: 0px;'>微信分享</p>"+
	"</li></ul>"+

	"<ul style='width: 100%;padding: 0;list-style: none;font-family: 黑体;line-height: 20px;margin: 0;'>"+
	"<li style='width:33%;float: left;text-align: -webkit-center;' index=1 >"+
	"<img src=images/fenxiang/hb_share_qq_new.png style='width: 42px;height: 42px;margin-top: 5px;' />"+
	"<p style='color:#A7A7A7;margin-top: 0px;'>QQ分享</p>"+
	"</li></ul>"+

	"<ul style='width: 100%;padding: 0;list-style: none;font-family: 黑体;line-height: 20px;margin: 0;'>"+
	"<li style='width:33%;float: left;text-align: -webkit-center;' index=2 >"+
	"<img src=images/fenxiang/hb_share_pyq_new.png style='width: 42px;height: 42px;margin-top: 5px;' />"+
	"<p style='color:#A7A7A7;margin-top: 0px;'>复制下载地址</p>"+
	"</li></ul></div>";
	顶部插入div(html);
	mui("#分享列表").on("tap", "li", function() { 分享被单击(this.getAttribute("index"));});
	if (读写设置.读取设置("邀请码") == "" || 读写设置.读取设置("邀请码") == null){document.getElementById("列表0").innerText = "登录后获取邀请码"}
	微信分享1.获取分享服务列表();
}

function 分享被单击(i){
	console.log(i);
	if (i == "0"){
		剪贴板1.置剪贴板内容("最新最全最快电影,尽在《" + 公用模块.APP标题() + "》 ,邀请码：" + 读写设置.读取设置("邀请码") + ",下载地址：" + 读写设置.读取设置("下载地址"));
		mui.toast("已复制内容到粘贴板,直接给好友发送吧")}
	if (i == "1"){
		微信分享1.分享到QQ好友(读写设置.读取设置("下载地址"),公用模块.APP标题(),"最新最全最快电影,尽在《" + 公用模块.APP标题() + "》邀请码：" + 读写设置.读取设置("邀请码"),"","");
		mui.toast("已复制内容到粘贴板,直接给好友发送吧")}
	if (i == "2"){
		剪贴板1.置剪贴板内容("最新最全最快电影,尽在《" + 公用模块.APP标题() + "》 ,邀请码：" + 读写设置.读取设置("邀请码") + ",下载地址：" + 读写设置.读取设置("下载地址"));
		mui.toast("已复制内容到粘贴板,直接给好友发送吧")}
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
function Fenxiang_按下返回键(){
var self = plus.webview.currentWebview();
	plus.webview.close(self,"slide-out-right");
}