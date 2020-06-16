    function App资源在线升级更新(name,event,event1,event2,event3){   
        //name表示组件在被创建时的名称，event表示组件拥有的事件
        //如果组件有多个事件，可以在后面继续填写这些事件名称
        //例如：function App资源在线升级更新(name,event1,event2,event3){
        
        //组件内部属性，仅供组件内部使用：
        this.名称 = name;
		var wgtVer = null;
		var checkUrl = "";
		var checkbtete = "";
		var wgtUrl = "";
		var wgtbtete = "";
        //组件命令：
        this.置标题 = function (newTitle){
            document.getElementById(this.名称).innerHTML=newTitle;
        } 
        
        //组件命令：
        this.取标题 = function (){
           return document.getElementById(this.名称).innerHTML;
        }  
       	
		this.获取本地应用资源版本号 = function(){
			plusReady();
			return wgtVer;
		}
		
		function plusReady() {
			// ......
			// 获取本地应用资源版本号
			plus.runtime.getProperty(plus.runtime.appid, function(inf) {
				wgtVer = inf.version;
				});
			}
			if(window.plus) {
				plusReady();
			} else {
				document.addEventListener('plusready', plusReady, false);
			}
		
		this.检测更新 = function(更新地址){
			checkUrl = 更新地址;
			checkUpdate();
		}
		
		function checkUpdate() {
			plus.nativeUI.showWaiting("检测更新...");
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				switch(xhr.readyState) {
					case 4:
						plus.nativeUI.closeWaiting();
						if(xhr.status == 200) {
							event2(xhr.responseText);
							var newVer = xhr.responseText;
							if(wgtVer && newVer && (wgtVer != newVer)) {
								
							} else {
								event2("无新版本可更新！");
							}
						} else {
							event2("检测更新失败！");
						}
						break;
					default:
						break;
				}
			}
			xhr.open('GET', checkUrl);
			xhr.send();
			}
		
		this.下载并更新WGT = function(文件地址){
			wgtUrl = 文件地址;
			downWgt();
		}

		function downWgt() {
				plus.nativeUI.showWaiting("下载更新文件...");
				plus.downloader.createDownload(wgtUrl, { filename: "_doc/update/" }, function(d, status) {
					if(status == 200) {
						installWgt(d.filename); // 安装wgt包
					} else {
						event1("" + d.filename);
					}
					plus.nativeUI.closeWaiting();
				}).start();
			}

			// 更新应用资源
			function installWgt(path) {
				plus.nativeUI.showWaiting("安装更新文件...");
				plus.runtime.install(path, {}, function() {
					plus.nativeUI.closeWaiting();
					event("安装wgt文件成功！");
					plus.nativeUI.alert("应用资源更新完成！", function() {
						plus.runtime.restart();
					});
				}, function(e) {
					plus.nativeUI.closeWaiting();
					event1("安装wgt文件失败[" + e.code + "]：" + e.message);
				});
			}
		this.清空缓存 = function(){
			plus.io.resolveLocalFileSystemURL( "_doc/update/", function(entry){
				entry.removeRecursively();
			});
			event4("缓存清理成功");
		}

}