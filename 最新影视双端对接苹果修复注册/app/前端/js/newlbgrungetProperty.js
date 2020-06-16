    function 列表哥热更新(name,runtimegetProperty,runtimegetProperty1,runtimegetProperty2,runtimegetProperty3){   
        this.名称 = name;
		
		
		var wgtVer=null;
		function plusReady(){
    		// ......
    		// 获取本地应用资源版本号
    		plus.runtime.getProperty(plus.runtime.appid,function(inf){
        		wgtVer=inf.version;
				if(runtimegetProperty!=null){
					runtimegetProperty(wgtVer);
				}
    		});
		}
		
		// 检测更新
		var checkUrl=null;
		function checkUpdate(){
		    var xhr=new XMLHttpRequest();
		    xhr.onreadystatechange=function(){
		        switch(xhr.readyState){
		            case 4:
		            plus.nativeUI.closeWaiting();
 		           if(xhr.status==200){
   		             var newVer=xhr.responseText;
    		            if(wgtVer&&newVer&&(wgtVer!=newVer)){
							if(runtimegetProperty1!=null){
								runtimegetProperty1(newVer,true);
							}
    		            }else{
							if(runtimegetProperty1!=null){
						  		runtimegetProperty1("无新版本可更新",false);
							}
     		           }
     		       }else{
				   		if(runtimegetProperty1!=null){
      		          		runtimegetProperty1("检测更新失败",false);
						}
     		       }
          		  break;
         		   default:
        		    break;
     		   }
  		  }
 		   xhr.open('GET',checkUrl);
 		   xhr.send();
		}
		
		// 下载wgt文件
		var wgtUrl=null;
		function downWgt(){
    		plus.downloader.createDownload( wgtUrl, {filename:"_doc/update/"}, function(d,status){
        		if ( status == 200 ) { 
            		if(runtimegetProperty2!=null){
      		          	runtimegetProperty2(d.filename,true);
					}
        		} else {
            		if(runtimegetProperty2!=null){
      		          	runtimegetProperty2("下载失败",false);
					}
        		}
    		}).start();
		}
		
		// 更新应用资源
		function installWgt(path){
    		plus.runtime.install(path,{},function(){
        		if(runtimegetProperty3!=null){
      				runtimegetProperty3("更新成功",true);
				}
    		},function(e){
        		if(runtimegetProperty3!=null){
      				runtimegetProperty3("code["+e.code+"]:"+e.message,false);
				}
    		});
		}
		
		this.刷新资源文件 = function(){
			plus.runtime.restart();
		}
		
		this.应用资源文件 = function(文件地址){
			installWgt(文件地址);
		}
		
		this.检测服务器版本号 = function(检测地址){
		
			checkUrl = 检测地址;
			checkUpdate();
			
		}
		
		this.获取本地应用资源版本号 = function(){
			if(window.plus){
    			plusReady();
			}else{
    			document.addEventListener('plusready',plusReady,false);
			}
		}
		
		this.下载文件 = function(资源地址){
			wgtUrl = 资源地址;
			downWgt();
		}
		
		
		
    }