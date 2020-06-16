mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
var 仔仔1 = new 仔仔("仔仔1",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
var 网络操作2 = new 网络操作("网络操作2",网络操作2_发送完毕);
var 面板1 = new 面板("面板1");
var 标签1 = new 标签("标签1",标签1_被单击);
var 标签2 = new 标签("标签2",标签2_被单击);
var 微信登录1 = new 微信登录("微信登录1",null,微信登录1_登录完毕);
var 网络操作3 = new 网络操作("网络操作3",网络操作3_发送完毕);
var 对话框1 = new 对话框("对话框1",null,null,null);
if(mui.os.plus){
    mui.plusReady(function() {
        Login_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        Login_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (Login_按下返回键()!=true) {
        mui_back();
    }
};

var username;
var password;
var 机器码;
var openid;
var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
function 判断主题颜色(){
背景颜色 = 读写设置.读取设置("背景颜色"),默认颜色 = 读写设置.读取设置("默认颜色"),激活颜色 = 读写设置.读取设置("激活颜色");
document.getElementById("标题栏1").style.background = 背景颜色,document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色,document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>登录</h1>";
}

function Login_创建完毕(){
	微信登录1.获取登录服务列表();
	标题栏1.置可视(true);
	面板1.添加组件("标签1","50%");
	面板1.添加组件("标签2","50%");
	标签1.置标题("<img id=标签1 style='width:40px;height:40px;margin:0px 0px 0px 0px'src='images/qq.png'>");
	标签2.置标题("<img id=标签2 style='width:40px;height:40px;margin:0px 0px 0px 0px'src='images/wx.png'>");
	面板1.固定在底部();
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
	html = "<ul id='列表框1' style='width:100%;color:#000000;font-size:14px;margin:50px 0px 0px 0px;padding:0px;text-align:center'>"+
	"<input id=账号 type='text' style='margin-top: 30px; width: 85%;border-radius:5px;' type=text placeholder='请输入帐号'></input>"+
	"<input id=密码 type='password' style='margin-top: 0px; width: 85%;border-radius:5px;' type=text placeholder='请输入密码'></input>"+
	"<button id=登录 class='btn' style='width: 85%;height: 35px;border-radius: 5px;background: " + 背景颜色 + "; color: " + 激活颜色 + ";font-size: 17px;font-family: 黑体;'>登录</button><p></p><div style='margin: 2rem;'>"+
	"<div id=列表框2 style='width: 100%;'><div id=忘记 style='float: left; width: 40%;z-index: 999;color:" + 背景颜色 + ";'>忘记密码?</div><div id=content style='float: right; width: 40%;z-index: 999;color:" + 背景颜色 + ";'><div id=注册 >新用户注册</div></div><br></ul>";
	顶部插入div(html);
	if (窗口操作.是否在安卓内运行() == false){机器码 = 仔仔1.命令_获取UUID()}else{机器码 = 仔仔1.命令_获取IMEI()}
	document.getElementById("登录").addEventListener("click", function() { 开始登录(document.getElementById("账号").value,document.getElementById("密码").value);}, false),document.getElementById("忘记").addEventListener("click", function() { 切换改密窗口();}, false),document.getElementById("注册").addEventListener("click", function() { 切换注册窗口();}, false);
}

function 网络操作1_发送完毕(发送结果,返回信息){
	var json = 转换操作.文本转json(文本操作.子文本替换(返回信息,"\\\+",""));
	var 返回信息=数学操作.到数值(转换操作.json转文本(json));
if (返回信息 == 101){mui.toast("账号为空")}
if (返回信息 == 102){mui.toast("密码为空")}
if (返回信息 == 104){mui.toast("机器码为空")}
if (返回信息 == 110){mui.toast("账号密码有误")}
if (返回信息 == 108){mui.toast("机器码不匹配")}
if (json.token != "" || json.token != null || json.token != null){读写设置.保存设置("用户帐号",username),读写设置.保存设置("用户密码",password),网络操作2.发送网络请求(公用模块.AdminGuanLi() + "/api.php?action=getinfo","post","txt","&username=" + username + "&token=" + json.token,5000)}
}
function 标题栏1_左侧图标被单击(){
var self = plus.webview.currentWebview();
	plus.webview.close(self,"slide-out-right");
}
function Login_按下返回键(){
var self = plus.webview.currentWebview();
	plus.webview.close(self,"slide-out-right");
	return;
}
function 网络操作2_发送完毕(发送结果,返回信息){
	var json = 转换操作.文本转json(文本操作.子文本替换(返回信息,"\\\+",""));
	对话框1.关闭等待框();
	读写设置.保存设置("已邀请人数",json.number),读写设置.保存设置("用户token",json.online),读写设置.保存设置("用户时间",json.vip),读写设置.保存设置("用户余额",json.money),读写设置.保存设置("用户上级",json.inv),读写设置.保存设置("邀请码",json.uid);
if (读写设置.读取设置("用户时间") == "0" || 读写设置.读取设置("用户时间") == 0){读写设置.保存设置("用户时间",json.regdate)}
if (json.lock == "n") {
if (json.vip == "999999999"){读写设置.保存设置("用户时间","4102415999")}else if (json.vip == "888888888"){读写设置.保存设置("用户时间","4102415999")}
	mui.toast("登录成功"),窗口操作.执行代码("caidan.html","获取登录数据()");
	plus.webview.close("login.html","slide-out-right");
	}else{对话框1.关闭等待框(),mui.toast(""),读写设置.删除设置("用户帐号"),读写设置.删除设置("用户密码")}
}

function 切换改密窗口(){窗口操作.预加载窗口("gaimi.html"),窗口操作.取指定窗口("gaimi.html").show("slide-in-right", 300)}
function 切换注册窗口(){窗口操作.预加载窗口("register.html"),窗口操作.取指定窗口("register.html").show("slide-in-right", 300)}
function 开始登录(user,pass){
	对话框1.显示等待框("请稍后...");
	if (user == "" || pass == null){
		对话框1.关闭等待框();
		mui.toast("请正确输入账号密码");
	}else{
		username = user;
		password = pass;
		网络操作1.发送网络请求(公用模块.AdminGuanLi() + "/api.php?action=login","post","txt","&username=" + username + "&password=" + password + "&logcode=" + 机器码,5000);
		}
	}
function 顶部插入div(html){
var newNodeBottom = document.createElement("div");
newNodeBottom.innerHTML = html,document.getElementById("推荐").appendChild(newNodeBottom)}


function 标签1_被单击(){
	微信登录1.登录QQ();
}

function 标签2_被单击(){
	mui.toast("暂不支持");
}

function 微信登录1_登录完毕(登录结果,用户信息){
	if(登录结果== true ){
		var json = 转换操作.文本转json("["+用户信息+"]");
		var nickname = json[0].nickname;
		openid = 文本操作.子文本替换(json[0].headimgurl,"/30","");
		openid = 文本操作.取文本右边(openid,32);
		网络操作3.发送网络请求(公用模块.AdminGuanLi() + "/api.php?action=register","post","txt","name=" + nickname + "&username=" + openid+ "&password=" + openid+ "&superpass=" + openid+ "&regcode=" + 机器码 + "&inv=1",12000);
	}else{
		对话框1.关闭等待框();
	}
}
function 网络操作3_发送完毕(发送结果,返回信息){
	var json = 转换操作.文本转json(文本操作.子文本替换(返回信息,"\\\+",""));
	var 信息 = 转换操作.json转文本(json);
	switch(信息){
		case "101" :
			读写设置.删除设置("用户帐号"),读写设置.删除设置("用户密码");
		break;
		case "102" :
			读写设置.删除设置("用户帐号"),读写设置.删除设置("用户密码");
		break;
		case "103" :
			读写设置.删除设置("用户帐号"),读写设置.删除设置("用户密码");
		break;
		case "104" :
			读写设置.删除设置("用户帐号"),读写设置.删除设置("用户密码");
		break;
		case "105" :
			读写设置.删除设置("用户帐号"),读写设置.删除设置("用户密码");
			开始登录(openid,openid);
		break;
		case "106" :
			读写设置.删除设置("用户帐号"),读写设置.删除设置("用户密码");
		break;
		case "107" :
			读写设置.删除设置("用户帐号"),读写设置.删除设置("用户密码");
		break;
		case "108" :
			读写设置.删除设置("用户帐号"),读写设置.删除设置("用户密码");
		break;
		case "109" :
			读写设置.删除设置("用户帐号"),读写设置.删除设置("用户密码");
		break;
		case "1005" :
			读写设置.删除设置("用户帐号"),读写设置.删除设置("用户密码");
		break;
		case "200" :
			读写设置.删除设置("用户帐号"),读写设置.删除设置("用户密码");
			开始登录(openid,openid);
		break;
	}
}