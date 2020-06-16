function 顶部图形导航(name,event1){   
	//name表示组件在被创建时的名称，event表示组件拥有的事件
	//如果组件有多个事件，可以在后面继续填写这些事件名称
	//例如：function 顶部图形导航(name,event1,event2,event3){
		
		//组件内部属性，仅供组件内部使用：
		this.名称 = name;
		this.项目总数 = 0;
		this.数据量 = 0;
		//组件命令：
		this.添加项目 = function (跳转页面,项目图片,项目标题,标题颜色,图标间距){
			var div = document.createElement("a");
			div.id = "txdh"+this.项目总数;
			div.className = "boximg";
			div.setAttribute("index",""+this.项目总数);
			this.项目总数 = this.项目总数+1;
			div.innerHTML = "<div style=\"height: 80px;width: 60px;display:inline-block;margin-right: "+图标间距+"px;\">\n"+
			"                     <a href=\""+跳转页面+"\"><img src=\""+项目图片+"\" tag=\"\" height=\"25px\" width=\"25px\" /></a>\n<br/>"+
			"                     <span style=\"margin: 0px 5px 0px 0px;font-size: 10px;color: "+标题颜色+";\">"+项目标题+"</span>\n"+
			"			           </div>"
			var root = document.getElementById(this.名称);
			root.appendChild(div);
		}
		
		this.添加弹出项目 = function(弹出页面,页面标题,项目图片,项目标题,标题颜色,图标间距){
			this.数据量 = this.数据量 + 1;
			var div = document.createElement("div");
			div.id = "modal"+this.数据量;
			div.className = "mui-modal";
			div.innerHTML = "<header class=\"mui-bar mui-bar-nav\">\n"+
			"<a class=\"mui-icon mui-icon-close mui-pull-right\" href=\"#modal"+this.数据量+"\"></a>\n"+
			"<h1 class=\"mui-title\">"+页面标题+"</h1>\n"+
			"</header>\n"+
			"<div class=\"mui-content\" style=\"height: 100%;\">\n"+
			"<Iframe src=\""+弹出页面+"\" width=\"100%\" height=\"100%\" scrolling=\"Auto\" frameborder=\"0\"></iframe>\n"+
			"</div>\n"+
			"</div>"
			var root = document.getElementById(this.名称+"yemian");
			root.appendChild(div);			
			this.添加项目("#modal"+this.数据量,项目图片,项目标题,标题颜色,图标间距);			
		}
		
		this.清空项目 = function(){
			var root = document.getElementById(this.名称);
			while(root.hasChildNodes()){
				root.removeChild(root.firstChild);
			}
			var root = document.getElementById(this.名称+"yemian");
			while(root.hasChildNodes()){
				root.removeChild(root.firstChild);
			}
			this.项目总数 = 0;
			this.数据量 = 0;
		}

		//组件命令：
		this.置背景色 = function (color){
			var div = document.getElementById(this.名称).parentNode;
			div.style.background=color;               
		} 
		
		//组件命令：
		this.置可视 = function (value){
			if(value==true){
				var div = document.getElementById(this.名称).parentNode;
				div.style.display="block";//显示	                
				}else{
				var div = document.getElementById(this.名称).parentNode;
				div.style.display="none"; //不占位隐藏               
			}
		} 
		
		//组件命令：
		this.置可视2 = function (value){
			if(value==true){
				var div = document.getElementById(this.名称).parentNode;
				div.style.visibility="visible";//显示	                
				}else{
				var div = document.getElementById(this.名称).parentNode;
				div.style.visibility="hidden"; //占位隐藏               
			}
		} 
		
		if(event1!=null){
			//mui("#"+组件ID).on(事件名称, 标签名称或类名称, function() {
				mui("#"+this.名称).on("tap", ".boximg", function() {
					var index1 = this.parentNode.parentNode.getAttribute("index");
					var index2 = this.getAttribute("index");
					event1(Number(index2));//触发组件的相关事件，这里的是"表项按钮被单击"事件
				});
			}
			
			//组件命令：
			this.添加事件 = function (){
				var child=document.getElementById(this.名称+"yemian").getElementsByClassName("mui-modal");
				for(var i=0;i<child.length;i++){
					(function(i){
						child[i].onclick=function(){
							event1(i)
						}
					})(i);
				}	
			}
			
			
		}																																																																																										