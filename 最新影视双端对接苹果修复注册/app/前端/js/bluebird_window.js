    (function (){  
        //注册命名空间  
        window["窗口操作"] = {}   

        function 取打开窗口(){      
            return plus.webview.currentWebview().opener();
        }

        function 执行代码(窗口,代码){
            if(typeof(窗口)=="string"){
                var a = 取指定窗口(窗口);
                a.evalJS(代码); 
            }else{
                窗口.evalJS(代码); 
            }
        }
        
        function 取当前窗口(){      
            return plus.webview.currentWebview();
        }

        function 取当前页面地址(){
            return window.location.href;
        }

        function 取当前页面名称(){
            var str = window.location.href;
            var len = str.lastIndexOf("/", str.length-1);
            str = str.substring(len+1);
            return str;
        }
        
        function 取当前页面参数(name){
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
            var r = window.location.search.substr(1).match(reg); 
            if (r != null){
                return decodeURI(r[2]); 
            }else{
                return ""; 
            }
        }
        
        function 取启动窗口(){   
            if(plus.runtime.appid=="H5400773A"){//在调试基座中运行
                return plus.webview.getWebviewById("index.html");
            }else{
                return plus.webview.getLaunchWebview();//在打包成APP后
            }            
        }

        function 创建窗口(页面名称,顶边,底边){
            var style = {top:顶边,bottom:底边};
            return plus.webview.create(页面名称, 页面名称, style);
        }

        function 添加子窗口(父窗口,子窗口){
            父窗口.append(子窗口);
        }

        function 取子窗口数量(){       
            return plus.webview.currentWebview().children().length;
        }

        function 取子窗口(index){      
            return plus.webview.currentWebview().children()[index];
        }

        function 取指定窗口(页面名称){
            if(是否在苹果内运行()){
                if(页面名称=="index.html"){
                    var webs = plus.webview.all();
                    var web;
                    for(i=0;i<webs.length;i++){
                        var str = webs[i].getURL();
                        var len = str.lastIndexOf("/", str.length-1);
                        str = str.substring(len+1);
                        if(str=="index.html"){
                            web = webs[i];
                            break;
                        }                        
                    } 
                    return web;
                }else{
                    return plus.webview.getWebviewById(页面名称);
                }              
            }else{
                if(页面名称=="index.html"){
                    if(plus.runtime.appid=="H5400773A"){//在调试基座中运行
                        return plus.webview.getWebviewById(页面名称);
                    }else{
                        return plus.webview.getLaunchWebview();
                    }                
                }else{
                    return plus.webview.getWebviewById(页面名称);
                }
            }
        }

        function 显示窗口(窗口对象或页面名称){         
            //plus.webview.show(窗口对象或页面名称,"zoom-fade-out",500);
            plus.webview.show(窗口对象或页面名称,"none",0);
        }

        function 隐藏窗口(窗口对象或页面名称){      
            //plus.webview.hide(窗口对象或页面名称,"zoom-fade-in",500);
            plus.webview.hide(窗口对象或页面名称,"none",0);
        }

        function 销毁窗口(窗口对象或页面名称){        
            //plus.webview.close(窗口对象或页面名称,"zoom-fade-in",500);
            plus.webview.close(窗口对象或页面名称,"none",0);
        }

        function 返回上一个窗口(){
            mui.back();
        }
        
        function 创建并添加子窗口(父窗口页面名称,子窗口页面名称,顶边距离,底边距离,是否显示子窗口){        
            var style = {top:顶边距离,bottom:底边距离};
            var 子窗口 = plus.webview.create(子窗口页面名称, 子窗口页面名称, style);
            var 父窗口; 
            if(父窗口页面名称=="index.html"){
                if(plus.runtime.appid=="H5400773A"){//在调试基座中运行
                    //父窗口 = plus.webview.currentWebview();
                    父窗口 = plus.webview.getWebviewById("index.html");
                }else{
                    父窗口 = plus.webview.getLaunchWebview();//在打包成APP后
                } 
            }else{
                父窗口 = plus.webview.getWebviewById(父窗口页面名称);
            }
            父窗口.append(子窗口);
            if(是否显示子窗口==false){
                plus.webview.hide(子窗口);
            }
        }

        function 预加载窗口(页面名称){
            if(页面名称=="index.html"){
                return;
            }
            mui.preload({
                url: 页面名称,
                id: 页面名称
            });	
        }
        
        function 切换窗口(页面名称,附加参数){
            try{
                var web;
                if(页面名称=="index.html"){               
                    if(plus.runtime.appid=="H5400773A"){//在调试基座中运行
                        //web = plus.webview.currentWebview();
                        web = plus.webview.getWebviewById("index.html");
                    }else{
                        web = plus.webview.getLaunchWebview();//在打包成APP后
                    }                                
                    //web = plus.webview.getWebviewById(plus.runtime.appid); 
                    //plus.webview.show(web,"zoom-fade-out",500);
                    plus.webview.show(web,"none",0);
                    //web = plus.webview.currentWebview().opener();
                    //web = plus.webview.all()[0];//调试基座中正常，打包后不正常
                    var webs = plus.webview.all();
                    for(i=0;i<webs.length;i++){
                        var str = webs[i].getURL();
                        var len = str.lastIndexOf("/", str.length-1);
                        str = str.substring(len+1);
                        if(str=="index.html"){
                            mui.fire(webs[i],"customEvent",{param:附加参数}); 
                            break; 
                        }                        
                    }
                    return;
                }
                web = plus.webview.getWebviewById(页面名称);
                if(web!=null){
                    //plus.webview.show(页面名称,"zoom-fade-out",500);
                    plus.webview.show(页面名称,"none",0);
                    mui.fire(web,"customEvent",{param:附加参数});
                    return;
                }
                mui.openWindow({
                    url: 页面名称,
                    id: 页面名称,
                    show: {
                        aniShow: "none",
                        duration: 0
                    }
                });	
                web = plus.webview.getWebviewById(页面名称);
                mui.fire(web,"customEvent",{param:附加参数}); 
            }catch(e){
                console.log(e.message);
                //在浏览器中运行
                mui.openWindow({
                    url: 页面名称,
                    id: 页面名称,
                    show: {
                        aniShow: "none",
                        duration: 0
                    }
                });	
            }       
        }

        function 取窗口宽度(){
            return window.innerWidth;
        }

        function 取窗口高度(){
            return window.innerHeight;         
        }
        
        function 取屏幕宽度(){
			if(mui.os.plus){
				return plus.screen.resolutionWidth*plus.screen.scale;
			}else{
				return window.screen.width;
			}
        }

        function 取屏幕高度(){
			if(mui.os.plus){
				return plus.screen.resolutionHeight*plus.screen.scale;
			}else{
				return window.screen.height;
			}			    
        }
        
        function 打开指定网址(网址,方式){
            if(方式==1){ //在应用内打开
                window.location.href = 网址;
            }else{ //调用系统默认浏览器打开
                if(mui.os.plus){
                    plus.runtime.openURL(网址);
                }else{
                    window.open(网址);  
                }                 
            }
        }

        function 结束程序(){       
            plus.runtime.quit();        
        }

        function 置界面边距(value){
            document.querySelector(".mui-content").style.paddingLeft = value;
            document.querySelector(".mui-content").style.paddingRight = value;
        }

        /*function 置组件宽度(name,value){
            var div = document.querySelector("#"+name);
            div.parentNode.style.textAlign = "center";
            div.style.width = value;
            div.style.cssFloat="none";
        }

        function 置组件高度(name,value){
            document.querySelector("#"+name).style.height = value;
        }*/
        
        function 置组件宽度(name,value){
            var div = document.querySelector("#"+name);
            if(div.parentNode.className!="mui-content"){
                if(div.parentNode.getAttribute("tag")=="自由面板" || div.parentNode.parentNode.getAttribute("tag")=="自由面板"){
                    //自由面板上的组件
                    div.parentNode.style.width = value;
                }else{
                    //面板上的组件
                    div.parentNode.style.textAlign = "center";
                    div.style.width = value;
                    div.style.cssFloat="none";                    
                }
            }else{
                div.style.width = value;
            }
        }

        function 置组件高度(name,value){
            var div = document.querySelector("#"+name);
            if(div.parentNode.className!="mui-content"){
                if(div.parentNode.getAttribute("tag")=="自由面板" || div.parentNode.parentNode.getAttribute("tag")=="自由面板"){
                    //自由面板上的组件
                    div.parentNode.style.height = value;
                }else{
                    //面板上的组件
                    div.style.height = value;
                }
            }else{
                div.style.height = value;
            }            
        }        

        function 置组件左边(name,value){
            var div = document.querySelector("#"+name);
            if(div.parentNode.className!="mui-content"){
                if(div.parentNode.getAttribute("tag")=="自由面板" || div.parentNode.parentNode.getAttribute("tag")=="自由面板"){
                    //自由面板上的组件
                    div.parentNode.style.left = value;
                }else{
                    //面板上的组件
                    div.style.left = value;
                }
            }else{
                div.style.left = value;
            }              
        }

        function 置组件顶边(name,value){
            var div = document.querySelector("#"+name);           
            if(div.parentNode.className!="mui-content"){
                if(div.parentNode.getAttribute("tag")=="自由面板" || div.parentNode.parentNode.getAttribute("tag")=="自由面板"){
                    //自由面板上的组件
                    div.parentNode.style.top = value;
                }else{
                    //面板上的组件
                    div.style.top = value;
                }
            }else{
                div.style.top = value;
            }              
        }          

        function 取组件宽度(name){
            var div = document.querySelector("#"+name);
            if(div.parentNode.className!="mui-content"){
                if(div.parentNode.getAttribute("tag")=="自由面板" || div.parentNode.parentNode.getAttribute("tag")=="自由面板"){
                    //自由面板上的组件
                    return div.parentNode.offsetWidth; 
                }else{
                    //面板上的组件
                    return div.offsetWidth; 
                }
            }else{
                return div.offsetWidth; 
            }
        }

        function 取组件高度(name){
            var div = document.querySelector("#"+name);
            if(div.parentNode.className!="mui-content"){
                if(div.parentNode.getAttribute("tag")=="自由面板" || div.parentNode.parentNode.getAttribute("tag")=="自由面板"){
                    //自由面板上的组件
                    return div.parentNode.offsetHeight;
                }else{
                    //面板上的组件
                    return div.offsetHeight;
                }
            }else{
                return div.offsetHeight;
            }            
        }  

        function 取组件左边(name){
            var div = document.querySelector("#"+name);
            if(div.parentNode.className!="mui-content"){
                if(div.parentNode.getAttribute("tag")=="自由面板" || div.parentNode.parentNode.getAttribute("tag")=="自由面板"){
                    //自由面板上的组件
                    return div.parentNode.offsetLeft;
                }else{
                    //面板上的组件
                    return div.offsetLeft;
                }                
            }else{
                return div.offsetLeft;
            }              
        }

        function 取组件顶边(name){
            var div = document.querySelector("#"+name);           
            if(div.parentNode.className!="mui-content"){
                if(div.parentNode.getAttribute("tag")=="自由面板" || div.parentNode.parentNode.getAttribute("tag")=="自由面板"){
                    //自由面板上的组件
                    return div.parentNode.offsetTop;
                }else{
                    //面板上的组件
                    return div.offsetTop;
                }                   
            }else{
                return div.offsetTop;
            }              
        }  
        
        function 置组件外边距(name,top,right,bottom,left){
            var div = document.querySelector("#"+name);
			if(div.parentNode.className!="mui-content"){
                if(div.parentNode.style.display=="-webkit-flex"){
                    div.style.margin = top+" "+right+" "+bottom+" "+left;
                }else{
                    div.parentNode.style.margin = top+" "+right+" "+bottom+" "+left;
                }
			}else{
                div.style.margin = top+" "+right+" "+bottom+" "+left;
			}
        }

        function 置组件内边距(name,top,right,bottom,left){
            var div = document.querySelector("#"+name);
            div.style.padding = top+" "+right+" "+bottom+" "+left;
        }

        function 置组件圆角(cname,value){
            document.getElementById(cname).style.borderRadius=value;
        } 

        function 置组件边框(cname,width,color){
			document.getElementById(cname).style.border="solid "+width+" "+color;
		}

        function 置组件阴影(cname,blur,spread,color){
			document.getElementById(cname).style.boxShadow="0px 0px "+blur+" "+spread+" "+color;
		}
        
        function 是否在APP内运行(){
            if(mui.os.plus){
                return true;   
            }else{
                return false;
            }
        }

        function 是否在安卓内运行(){
            if(mui.os.android){
                return true;   
            }else{
                return false;
            }               
        }

        function 是否在苹果内运行(){ 
            if(mui.os.ios){
                return true;   
            }else{
                return false;
            }              
        }

        function 是否在微信内运行(){
            if(mui.os.wechat){
                return true;   
            }else{
                return false;
            }               
        }

        function 清空缓存(){
            plus.cache.clear();  
        } 

        function 滚动到顶部(){
			window.scrollTo(0,0);
			//下拉刷新组件
            var pullRefreshContainer = document.getElementById("pullRefreshContainer");
            if(pullRefreshContainer){
                mui(".mui-scroll-wrapper").scroll().reLayout();
                mui(".mui-scroll-wrapper").scroll().scrollTo(0,0,100); 
            }
			//侧滑面板组件
            var offCanvasContentScroll = document.getElementById("offCanvasContentScroll");
            if(offCanvasContentScroll){
                mui("#offCanvasContentScroll").scroll().reLayout();
                mui("#offCanvasContentScroll").scroll().scrollTo(0,0,100); 
            }  			
		}

        function 滚动到底部(){
			window.scrollTo(0,document.body.scrollHeight);	
			//下拉刷新组件
            var pullRefreshContainer = document.getElementById("pullRefreshContainer");
            if(pullRefreshContainer){
                mui(".mui-scroll-wrapper").scroll().reLayout();
                //mui(".mui-scroll-wrapper").scroll().scrollTo(0,document.body.scrollHeight-pullRefreshContainer.scrollHeight,100); 
                mui(".mui-scroll-wrapper").scroll().scrollToBottom(100);
            }
			//侧滑面板组件
            var offCanvasContentScroll = document.getElementById("offCanvasContentScroll");
            if(offCanvasContentScroll){
                mui("#offCanvasContentScroll").scroll().reLayout();
                //mui("#offCanvasContentScroll").scroll().scrollTo(0,document.body.scrollHeight-offCanvasContentScroll.scrollHeight,100); 
                //mui("#offCanvasContentScroll").scroll().y;
                mui("#offCanvasContentScroll").scroll().scrollToBottom(100);
            }            
		}
        
        function 设置状态栏颜色(color){ 
            plus.navigator.setStatusBarBackground(color);
        }
        
        function 设置启动界面(imagepath,delaytime){ 
            plus.navigator.updateSplashscreen({image:imagepath,delay:delaytime});
        }

        function 锁定屏幕方向(value){ 
            switch(value){
                case 1:
                    plus.screen.lockOrientation("portrait-primary");
                break;
                case 2:
                    plus.screen.lockOrientation("portrait-secondary");
                break;   
                case 3:
                    plus.screen.lockOrientation("landscape-primary");
                break;                 
                case 4:
                    plus.screen.lockOrientation("landscape-secondary");
                break;                 
                case 5:
                    plus.screen.lockOrientation("portrait");
                break;                 
                case 6:
                    plus.screen.lockOrientation("landscape");
                break;  
            }
        }        
        
        function 解锁屏幕方向(){
			plus.screen.unlockOrientation();	
		}

        function 取屏幕方向(){
            if(window.orientation === 180 || window.orientation === 0) {
                return 1;//竖屏
            }
            if(window.orientation === 90 || window.orientation === -90) {
                return 2;//横屏
            }	            
        }

        function 设置是否全屏(value){ 
            plus.navigator.setFullscreen(value);
        }

        function 设置屏幕常亮(value){ 
            plus.device.setWakelock(value);
        }

        function 置系统音量(value){ 
            plus.device.setVolume(value);
        }

        function 取系统音量(){ 
            return plus.device.getVolume();
        }

        function 引入css文件(path){ 
            var CSS = document.createElement("link");
            CSS.href = path;
            CSS.rel = "stylesheet";
            CSS.type = "text/css";
            document.getElementsByTagName("head").item(0).appendChild(CSS);
        }

        function 引入js文件(path,code){ 
            var JS = document.createElement("script");
            JS.src = path;
            JS.type = "text/javascript";
            if(!code){
                code="utf-8";
            }
            JS.charset=code;
            document.getElementsByTagName("body").item(0).appendChild(JS);
        }

        function 置窗口标题(newTitle){
            document.getElementsByTagName("title").item(0).innerText=newTitle;
        } 
		
        //注册function
        window["窗口操作"]["取当前窗口"]=取当前窗口;  
        window["窗口操作"]["取当前页面地址"]=取当前页面地址; 
        window["窗口操作"]["取当前页面名称"]=取当前页面名称; 
        window["窗口操作"]["取当前页面参数"]=取当前页面参数; 
        window["窗口操作"]["取启动窗口"]=取启动窗口;
        window["窗口操作"]["取打开窗口"]=取打开窗口;       
        window["窗口操作"]["创建窗口"]=创建窗口;  
        window["窗口操作"]["添加子窗口"]=添加子窗口;  
        window["窗口操作"]["取子窗口数量"]=取子窗口数量;  
        window["窗口操作"]["取子窗口"]=取子窗口; 
        window["窗口操作"]["取指定窗口"]=取指定窗口;         
        window["窗口操作"]["执行代码"]=执行代码;  
        window["窗口操作"]["显示窗口"]=显示窗口;  
        window["窗口操作"]["隐藏窗口"]=隐藏窗口;  
        window["窗口操作"]["销毁窗口"]=销毁窗口;  
        window["窗口操作"]["返回上一个窗口"]=返回上一个窗口;  
        window["窗口操作"]["创建并添加子窗口"]=创建并添加子窗口;  
        window["窗口操作"]["预加载窗口"]=预加载窗口;  
        window["窗口操作"]["切换窗口"]=切换窗口;  
        window["窗口操作"]["取屏幕宽度"]=取屏幕宽度;  
        window["窗口操作"]["取屏幕高度"]=取屏幕高度;  
        window["窗口操作"]["取窗口宽度"]=取窗口宽度;  
        window["窗口操作"]["取窗口高度"]=取窗口高度;         
        window["窗口操作"]["打开指定网址"]=打开指定网址;  
        window["窗口操作"]["结束程序"]=结束程序;  
        window["窗口操作"]["置界面边距"]=置界面边距;  
        window["窗口操作"]["置组件宽度"]=置组件宽度;  
        window["窗口操作"]["置组件高度"]=置组件高度;  
        window["窗口操作"]["置组件左边"]=置组件左边;  
        window["窗口操作"]["置组件顶边"]=置组件顶边;        
        window["窗口操作"]["取组件宽度"]=取组件宽度;  
        window["窗口操作"]["取组件高度"]=取组件高度;  
        window["窗口操作"]["取组件左边"]=取组件左边;  
        window["窗口操作"]["取组件顶边"]=取组件顶边;  
        window["窗口操作"]["置组件外边距"]=置组件外边距;
        window["窗口操作"]["置组件内边距"]=置组件内边距;       
        window["窗口操作"]["置组件圆角"]=置组件圆角;
        window["窗口操作"]["置组件边框"]=置组件边框;
        window["窗口操作"]["置组件阴影"]=置组件阴影;      
        window["窗口操作"]["是否在APP内运行"]=是否在APP内运行; 
        window["窗口操作"]["是否在安卓内运行"]=是否在安卓内运行; 
        window["窗口操作"]["是否在苹果内运行"]=是否在苹果内运行; 
        window["窗口操作"]["是否在微信内运行"]=是否在微信内运行; 
        window["窗口操作"]["清空缓存"]=清空缓存;  
        window["窗口操作"]["滚动到顶部"]=滚动到顶部;  
        window["窗口操作"]["滚动到底部"]=滚动到底部;  
        window["窗口操作"]["设置状态栏颜色"]=设置状态栏颜色;  
        window["窗口操作"]["设置启动界面"]=设置启动界面;  
        window["窗口操作"]["锁定屏幕方向"]=锁定屏幕方向; 
        window["窗口操作"]["解锁屏幕方向"]=解锁屏幕方向; 
        window["窗口操作"]["取屏幕方向"]=取屏幕方向;
        window["窗口操作"]["设置是否全屏"]=设置是否全屏; 
        window["窗口操作"]["设置屏幕常亮"]=设置屏幕常亮; 
        window["窗口操作"]["引入css文件"]=引入css文件; 
        window["窗口操作"]["引入js文件"]=引入js文件;
        window["窗口操作"]["置系统音量"]=置系统音量;
        window["窗口操作"]["取系统音量"]=取系统音量;
        window["窗口操作"]["置窗口标题"]=置窗口标题;
    })();
 