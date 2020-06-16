mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
var 仔仔1 = new 仔仔("仔仔1",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
var 网络操作2 = new 网络操作("网络操作2",网络操作2_发送完毕);
var 对话框1 = new 对话框("对话框1",null,null,null);
if(mui.os.plus){
    mui.plusReady(function() {
        gaimi_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        gaimi_创建完毕();
        
    }
}

var username;
var password;
var 机器码;
var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
function 判断主题颜色(){
document.getElementById("标题栏1").style.background = 背景颜色,document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色,document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>改密</h1>";
}
function gaimi_创建完毕(){
判断主题颜色();
var div = document.createElement("div");
	div.innerHTML = "<div class='minirefresh-scroll'><div id=推荐 style='list-style: none;'></div><div id=其他 style='list-style: none;display: none;'></div></div>";
	div.id = "minirefresh";
	div.class = "minirefresh-wrap";
	div.style.overflow = "inherit";
	document.body.appendChild(div);
	document.body.querySelectorAll("div")[0].insertBefore(div, document.body.nextSibling);

var div = document.createElement("div");
	div.innerHTML = "<ul id=其他列表 class='mui-table-view mui-grid-view' style='padding: 0;'></ul>";
	document.body.appendChild(div);
	document.getElementById("其他").appendChild(div);
	if (窗口操作.是否在安卓内运行() == false){机器码 = 仔仔1.命令_获取UUID()}else{机器码 = 仔仔1.命令_获取IMEI()}
	html = "<ul id='列表框1' style='width:100%;color:#000000;font-size:14px;margin:50px 0px 0px 0px;padding:0px;text-align:center'>"+
	"<input id=账号 style='margin-top: 30px; width: 85%;border-radius:5px;' type=text placeholder='账号'></input>"+
	"<input id=密码1 type='text' style='margin-top: 0px; width: 85%;border-radius:5px;' type=text placeholder='旧密码'></input>"+
	"<input id=密码2 type='password' style='margin-top: 0px; width: 85%;border-radius:5px;' type=text placeholder='输入新密码'></input>"+

	"<button id=确定 class='btn' style='width: 85%;height: 35px;border-radius: 5px;background: " + 背景颜色 + "; color: " + 激活颜色 + ";font-size: 17px;font-family: 黑体;'>确定</button><p></p><div style='margin: 2rem;'>"+
	"<div id=列表框2 style='width: 100%;'><div id=忘记 style='float: left; width: 40%;z-index: 999;color:" + 背景颜色 + ";'>联系客服</div><div id=content style='float: right; width: 40%;z-index: 999;color:" + 背景颜色 + ";'><div id=注册 >返回登录</div></div><br></ul>";
	顶部插入div(html);
	document.getElementById("确定").addEventListener("click", function() { 开始修改(document.getElementById("账号").value,document.getElementById("密码1").value,document.getElementById("密码2").value);}, false),document.getElementById("忘记").addEventListener("click", function() { 切换客服窗口();}, false),document.getElementById("注册").addEventListener("click", function() { 切换登录窗口();}, false);
}
function 切换客服窗口(){窗口操作.预加载窗口("kefu.html"),窗口操作.取指定窗口("kefu.html").show("slide-in-right", 300)}
function 切换登录窗口(){
		var self = plus.webview.currentWebview();
		plus.webview.close(self,"slide-out-right");
	}
function 开始修改(user,pass1,pass2){
	if (文本操作.取文本长度(pass2) < 6){
		mui.toast("请输入6位数以上帐号密码");
	}else{
		if (user == "" || pass1 == null || pass2 == null){
			mui.toast("请正确输入账号密码");
		}else{
			对话框1.显示等待框("请稍后...");
			读写设置.保存设置("用户帐号",user);
			读写设置.保存设置("用户密码",pass2);
			网络操作1.发送网络请求(公用模块.AdminGuanLi() + "/api.php?action=modify","post","txt","username=" + user + "&password=" + pass1+ "&newpass=" + pass2,5000);
		}
	}
}

function 顶部插入div(html){
var newNodeBottom = document.createElement("div");
    newNodeBottom.innerHTML = html;
	document.getElementById("推荐").appendChild(newNodeBottom);
}

function 网络操作1_发送完毕(发送结果,返回信息){
	var json = 转换操作.文本转json(文本操作.子文本替换(返回信息,"\\\+",""));
	var 信息 = 转换操作.json转文本(json);
	switch(信息){
		case "101" :
			mui.toast("账号为空");
		break;
		case "102" :
			mui.toast("密码为空");
		break;
		case "141" :
			mui.toast("新密码为空");
		break;
		case "110" :
			mui.toast("错误");
		break;
		case "200" :

			网络操作2.发送网络请求(公用模块.AdminGuanLi() + "/api.php?action=editcode","post","txt","username=" + 读写设置.读取设置("用户帐号") + "&superpass=" + 读写设置.读取设置("用户密码") + "&newcode=" + 机器码 ,5000);
		break;
	}
}
function 网络操作2_发送完毕(发送结果,返回信息){
	对话框1.关闭等待框();
	console.log(返回信息);
	var json = 转换操作.文本转json(文本操作.子文本替换(返回信息,"\\\+",""));
	var 信息 = 转换操作.json转文本(json);
	switch(信息){
		case "101" :
			mui.toast("账号为空");
		break;
		case "102" :
			mui.toast("密码为空");
		break;
		case "141" :
			mui.toast("新密码为空");
		break;
		case "110" :
			mui.toast("错误");
		break;
		case "200" :
			mui.toast("成功");

		break;
	}
}
function 标题栏1_左侧图标被单击(){
var self = plus.webview.currentWebview();
	plus.webview.close(self,"slide-out-right");
}

function Register_按下返回键(){
var self = plus.webview.currentWebview();
	plus.webview.close(self,"slide-out-right");
	return;
}