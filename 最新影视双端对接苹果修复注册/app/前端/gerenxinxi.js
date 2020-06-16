mui.init({swipeBack: false
,gestureConfig: {tap:true,doubletap:true,longtap:true,hold:true,release:true}});

var 标题栏1 = new 标题栏("标题栏1",null,null,标题栏1_左侧图标被单击);
var 标签1 = new 标签("标签1",null);
var 图片框1 = new 图片框("图片框1",图片框1_被单击);
var 标签2 = new 标签("标签2",null);
var CYS超级列表框1 = new CYS超级列表框("CYS超级列表框1",CYS超级列表框1_项目被单击,null);
var 仔仔1 = new 仔仔("仔仔1",null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null,null);
var 对话框1 = new 对话框("对话框1",null,null,对话框1_输入框被单击);
var 网络操作1 = new 网络操作("网络操作1",网络操作1_发送完毕);
var 上传器1 = new 上传器("上传器1",null,上传器1_上传完毕);
var 系统相册1 = new 系统相册("系统相册1",系统相册1_选择单个图片完毕,null,null);
var 按钮1 = new 按钮("按钮1",按钮1_被单击,null,null);
var 面板1 = new 面板("面板1");
if(mui.os.plus){
    mui.plusReady(function() {
        gerenxinxi_创建完毕();
        
    });
}else{
    window.onload=function(){ 
        gerenxinxi_创建完毕();
        
    }
}

var 背景颜色 = 读写设置.读取设置("背景颜色");
var 默认颜色 = 读写设置.读取设置("默认颜色");
var 激活颜色 = 读写设置.读取设置("激活颜色");
var 搜索颜色 = 读写设置.读取设置("搜索颜色");
var i= 0;
document.getElementById("标题栏1").style.background = 背景颜色;
document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'>个人信息</h1>";

function gerenxinxi_创建完毕(){
	面板1.添加组件("按钮1","1");
	面板1.固定在底部();
	按钮1.置样式();
	标签2.置标题("<label id='标签2' style='width:100%;color:#808080;font-size:9px;margin:-20px 0px 0px 0px;padding:0px;text-align:center'>修改头像</label>");
	窗口操作.置组件圆角("图片框1","100px");
	图片框1.置图片( 公用模块.AdminGuanLi() + "/" + 读写设置.读取设置("用户头像"));
	CYS超级列表框1.添加项目("昵称",读写设置.读取设置("用户名字"),1,"","");
	CYS超级列表框1.添加项目("账号",读写设置.读取设置("用户帐号"),1,"","");
	if (读写设置.读取设置("用户时间") == "4102415999"){
			CYS超级列表框1.添加项目("会员","永久会员",1,"","");
		}else{
			CYS超级列表框1.添加项目("会员",仔仔1.时间_时间戳转时间(读写设置.读取设置("用户时间")),1,"","");
		return}



}
function 主题信息(){
	document.getElementById("标题栏1").style.background = 背景颜色;
	document.querySelectorAll("#标题栏1 a")[0].style.color = 激活颜色;
	document.querySelectorAll("#标题栏1 a")[0].innerHTML += "<h1 style='font-size: 15px;float: right;color:" + 激活颜色 + ";'></h1>";
}
function CYS超级列表框1_项目被单击(项目索引){
	switch(项目索引){
		case 0 :
			对话框1.输入框("请输入新名字",读写设置.读取设置("用户名字"),"确定修改","取消");
		break;
		case 1 :

		break;
		case 2 :

		break;
	}
}

function shengchengkami_按下返回键(){
	plus.webview.close("gerenxinxi.html","slide-out-right");
	return;
}

function 标题栏1_左侧图标被单击(){
	plus.webview.close("gerenxinxi.html","slide-out-right");
}



function 对话框1_输入框被单击(按钮索引,输入内容){
	if(按钮索引 ==0 ){
		if(输入内容 !="" ){
			读写设置.保存设置("输入内容",输入内容);
			网络操作1.发送网络请求(公用模块.AdminGuanLi() + "/api.php?action=altername","post","txt","username=" + 读写设置.读取设置("用户帐号")+"&token=" + 读写设置.读取设置("用户token")+ "&name=" + 输入内容,5000);
		}
	}
}
function 网络操作1_发送完毕(发送结果,返回信息){
	var json = 转换操作.文本转json(文本操作.子文本替换(返回信息,"\\\+",""));
	var 信息 = 转换操作.json转文本(json);
	switch(信息){
		case "101" :
			mui.toast("读取账号失败,请重试");
		break;
		case "150" :
			mui.toast("登入可能过期了,请重试");
		break;
		case "130" :
			mui.toast("修改的名称不能为空");
		break;
		case "151" :
			mui.toast("登入可能已失效,请重新登入");
		break;
		case "200" :
			mui.toast("修改成功");
			CYS超级列表框1.置项目内容(0,读写设置.读取设置("输入内容"));
			窗口操作.执行代码("Caidan.html"," 获取登录数据()");

		break;
	}
}




function 图片框1_被单击(){
	系统相册1.选择单个图片();
}

function 系统相册1_选择单个图片完毕(结果,路径){
	var 任务对象= 上传器1.创建任务(公用模块.AdminGuanLi() +"/api.php?action=alterpic&type=bbp&token=" + 读写设置.读取设置("用户token"));
	if(结果 == true ){
		对话框1.显示等待框("上传中");
		图片框1.置图片(路径);
		读写设置.保存设置("用户头像",路径);
		上传器1.添加文件(任务对象,路径);
		上传器1.开始上传(任务对象);
	}
}
function 上传器1_上传完毕(上传结果,任务对象){
	对话框1.关闭等待框();
	if(文本操作.寻找文本(上传器1.取返回数据(任务对象),"200",0)!=-1 ){
		对话框1.弹出提示("上传成功");
		窗口操作.执行代码("caidan.html"," 获取登录数据()");
		plus.webview.close("gerenxinxi.html","slide-out-right");
	}else{
		对话框1.弹出提示("网络不给力,请重试");
	}
}


function 按钮1_被单击(){
	读写设置.保存设置("用户头像","images/Home_logo.png"),读写设置.保存设置("用户帐号",""),读写设置.保存设置("用户密码",""),读写设置.保存设置("用户时间","");
	窗口操作.执行代码("caidan.html","刷新登录数据()");
	plus.webview.close("gerenxinxi.html","slide-out-right");
}