mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
var 仔仔1 = new 仔仔("仔仔1",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
if(mui.os.plus){
    mui.plusReady(function() {
        Register_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        Register_创建完毕();
        
    }
}
var mui_back = mui.back;
mui.back = function() {
    if (Register_按下返回键()!=true) {
        mui_back();
    }
};

var username;
var password;
var 机器码;
var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
function 判断主题颜色(){
背景颜色 = 读写设置.读取设置("背景颜色"),默认颜色 = 读写设置.读取设置("默认颜色"),激活颜色 = 读写设置.读取设置("激活颜色");
document.getElementById("标题栏1").style.background = 背景颜色,document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色,document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>注册</h1>";
}

function Register_创建完毕(){
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
	"<input id=账号 style='margin-top: 30px; width: 85%;border-radius:5px;' type=text placeholder='账号'></input>"+
	"<input id=密码1 type='password' style='margin-top: 0px; width: 85%;border-radius:5px;' type=text placeholder='密码'></input>"+
	"<input id=密码2 type='password' style='margin-top: 0px; width: 85%;border-radius:5px;' type=text placeholder='再次输入密码'></input>"+
	"<input id=邀请码 type='text' style='margin-top: 0px; width: 85%;border-radius:5px;' type=text placeholder='邀请码'></input>"+
	"<button id=注册 class='btn' style='width: 85%;height: 35px;border-radius: 5px;background: " + 背景颜色 + "; color: " + 激活颜色 + ";font-size: 17px;font-family: 黑体;'>注册</button><p></p><div style='margin: 2rem;'></ul>";

	顶部插入div(html);
	if (窗口操作.是否在安卓内运行() == false){机器码 = 仔仔1.命令_获取UUID()}else{机器码 = 仔仔1.命令_获取IMEI()}

	document.getElementById("注册").addEventListener("click", function() { 开始注册(document.getElementById("账号").value,document.getElementById("密码1").value,document.getElementById("密码2").value,document.getElementById("邀请码").value);}, false);

}

function 开始注册(user,pass1,pass2,inv){
	if (文本操作.取文本长度(user) < 6 || 文本操作.取文本长度(pass1) < 6 || 文本操作.取文本长度(pass2) < 6){
	mui.toast("请输入6位数以上帐号密码");
	}else{
	if (inv == "" || inv == null || inv == null){inv = ""}

	if (user == "" || pass1 == null || pass2 == null){mui.toast("请正确输入账号密码")}else{
	if (pass1 == pass2){username = user,password = pass2,网络操作1.发送网络请求(公用模块.AdminGuanLi() + "/api.php?action=register","post","txt","name=ID：" +仔仔1.命令_获取设备型号() + "&username=" + user + "&password=" + pass1 + "&superpass=" + pass2 + "&regcode=" + 机器码 + "&inv=" + inv,12000)}else{mui.toast("密码有误,请重新输入")}}
	}
}

function 顶部插入div(html){
var newNodeBottom = document.createElement("div");
    newNodeBottom.innerHTML = html;
	document.getElementById("推荐").appendChild(newNodeBottom);
}

function 网络操作1_发送完毕(发送结果,返回信息){
	var json = 转换操作.文本转json(文本操作.子文本替换(返回信息,"\\\+",""));
	console.log(json);
	var 返回信息 = 数学操作.到数值(转换操作.json转文本(json));
if (返回信息 == 200){
	mui.toast("注册成功");
	读写设置.保存设置("用户帐号",username);
	读写设置.保存设置("用户密码",password);
	窗口操作.执行代码("caidan.html","获取登录数据()");
	plus.webview.close("register.html","slide-out-right");
	return;
}
if (返回信息 == 101){mui.toast("账号为空")}
if (返回信息 == 102){mui.toast("密码为空")}
if (返回信息 == 103){mui.toast("密码为空")}
if (返回信息 == 104){mui.toast("104注册信息错误")}
if (返信息 == 105){mui.toast("该账号已被注册")}
if (返回信息 == 106){mui.toast("您今天已经注册过一次了,明天再来试试")}
if (返回信息 == 107){mui.toast("您今天已经注册过一次了,明天再来试试")}
if (返回信息 == 108){mui.toast("邀请人不存在,请重试")}
if (返回信息 == 109){mui.toast("您已经注册过一次了,自己邀自己不送会员哦")}
if (返回信息 == 1005){mui.toast("请人不存在")}

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