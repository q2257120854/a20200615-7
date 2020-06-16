    (function (){  
        //注册命名空间  
        window["应用操作"] = {}   
        
        function 安装应用(path){       
            plus.runtime.install(path);//"files/test.apk"
        }

        function 取应用版本(){       
            return plus.runtime.version;        
        }

        function 取应用ID(){       
            return plus.runtime.appid;        
        }

        function 结束程序(){       
            plus.runtime.quit();        
        }
        
        function 重启程序(){       
            plus.runtime.restart();        
        }        
        
        function 启动应用(packagename){       //"com.test.app"
            plus.runtime.launchApplication({pname:packagename}, function (e){});
        }       
       
        //注册function
        window["应用操作"]["安装应用"]=安装应用;  
        window["应用操作"]["取应用版本"]=取应用版本; 
        window["应用操作"]["取应用ID"]=取应用ID;  
        window["应用操作"]["结束程序"]=结束程序;  
        window["应用操作"]["重启程序"]=重启程序; 
        window["应用操作"]["启动应用"]=启动应用; 
    })();
 