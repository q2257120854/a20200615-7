    function 面板(name){   
        //name表示组件在被创建时的名称，event表示组件拥有的事件
        //如果组件有多个事件，可以在后面继续填写这些事件名称
        //例如：function 面板(name,event1,event2,event3){
        
        //组件内部属性，仅供组件内部使用：
        this.名称 = name;
		this.组件间距 = "5px";
		this.面板高度 = "40px";
		
        //组件命令：
        this.添加组件 = function (组件名称,组件宽度){
			var child = document.getElementById(组件名称);//获取组件元素
            var parent = child.parentNode;//获取组件的父元素			
			var temp = document.getElementById(this.名称).hasChildNodes();
			var panel = document.getElementById(this.名称);
									
			if(parent.classList.contains("mui-password")){//密码编辑框
				if(!panel.classList.contains("mui-password")){
					panel.classList.add("mui-password");
				}
				var child2 = child.nextSibling;
				var child3 = child2.nextSibling;
				parent.removeChild(child);//从父元素上删除该组件元素
				panel.appendChild(child);//将组件元素添加到面板上
				if(child2!=null){
					parent.removeChild(child2);
					panel.appendChild(child2);
				}
				if(child3!=null){
					parent.removeChild(child3);
					panel.appendChild(child3);
				}				
			}else if(parent.classList.contains("mui-search")){//搜索编辑框			
				if(!panel.classList.contains("mui-search")){
					panel.classList.add("mui-search");
				}
				var child2 = child.nextSibling;
				var child3 = child2.nextSibling;
				parent.removeChild(child);//从父元素总删除该组件元素
				panel.appendChild(child);//将组件元素添加到面板上
				if(child2!=null){
					parent.removeChild(child2);
					panel.appendChild(child2);
				}
				if(child3!=null){
					parent.removeChild(child3);
					panel.appendChild(child3);
				}			
			}else{//普通编辑框或其他组件
				parent.removeChild(child);//从父元素总删除该组件元素
				panel.appendChild(child);//将组件元素添加到面板上
			}	
								
			//设置组件元素在面板上的宽度
			if(取文本右边(组件宽度,1)=="%"){
				child.style.width=组件宽度;
			}else if(取文本右边(组件宽度,2)=="px"){
				child.style.width=组件宽度;
			}else{
				//child.style.flex=组件宽度;
				child.style.setProperty("-webkit-flex",组件宽度);
				child.style.width="0px";
			}
			if(temp){
				child.style.marginLeft=this.组件间距;//面板上的组件与它左边的组件的间距
			}
			//console.log(child.tagName);
			if(child.tagName=="LABEL"){
				child.style.paddingTop = "11px";//如果是标签组件,则设置一下上下内边距,使其在垂直方向居中显示
				child.style.paddingBottom = "11px";
			}			
			if(parent.className!="mui-content"){
				parent.parentNode.removeChild(parent);//如果组件元素之前的父元素不是mui-content,则从mui-content上删除该父元素
			}
        }  

        function 取文本右边(str,len){
			if(isNaN(len)||len==null)
			{
				len = str.length;
			}else{
				if(parseInt(len)<0||parseInt(len)>str.length)
		 		{
		 			len = str.length;
		 		}
		 	}
		 	return str.substring(str.length-len,str.length);
		 }

        //组件命令：
        this.置背景颜色 = function (color){
			var panel = document.getElementById(this.名称);
			panel.style.background = color;
		}

        //组件命令：
        this.置边框颜色 = function (position,width,color){
			var panel = document.getElementById(this.名称);
			switch(position){
				case 1:
					panel.style.borderTop="solid "+width+" "+color;
					break;					
				case 2:
					panel.style.borderRight="solid "+width+" "+color;			
					break;					
				case 3:
					panel.style.borderBottom="solid "+width+" "+color;
					break;
				case 4:
					panel.style.borderLeft="solid "+width+" "+color;
					break;	
				case 5:
					panel.style.border="solid "+width+" "+color;
					break;															
			}
		}

        //组件命令：
        this.置边框阴影 = function (blur,spread,color){
			var panel = document.getElementById(this.名称);
			panel.style.boxShadow="0px 0px "+blur+" "+spread+" "+color;
		}

        //组件命令：
        this.置组件间距 = function (left){
			this.组件间距 = left;
		}

        //组件命令：
        this.置宽度 = function (value){
			var panel = document.getElementById(this.名称);
			panel.style.width = value;
		}

        //组件命令：
        this.置高度 = function (value){
			var panel = document.getElementById(this.名称);
			panel.style.height = value;
			this.面板高度 = value;
		}

        //组件命令：
        this.置外边距 = function (top,right,bottom,left){
			var panel = document.getElementById(this.名称);
			panel.style.margin = top+" "+right+" "+bottom+" "+left;
		}

        //组件命令：
        this.置内边距 = function (top,right,bottom,left){
			var panel = document.getElementById(this.名称);
			panel.style.padding = top+" "+right+" "+bottom+" "+left;
		}

        //组件命令：
        this.固定在顶部 = function (){
			//var body = document.getElementsByTagName("body")[0];		
			var content = document.getElementsByClassName("mui-content")[0];
			var body = content.parentNode;
			var headers = body.getElementsByTagName("header");
			var header;
			if(headers==null || headers.length==0){
				header = document.createElement("header");
				body.insertBefore(header,content);
				header.className="mui-bar";
				header.style.padding = "0px 0px";
				header.style.height = this.面板高度;
			}else{
				header = headers[0]; 
			}
			var panel = document.getElementById(this.名称);
            var parent = panel.parentNode;
			parent.removeChild(panel);
			header.appendChild(panel);	
			content.style.paddingTop=this.面板高度;			
		}

        //组件命令：
        this.固定在底部 = function (){
			//var body = document.getElementsByTagName("body")[0];			
			var content = document.getElementsByClassName("mui-content")[0];
			var body = content.parentNode;
			var footers = body.getElementsByTagName("footer");
			var footer;
			if(footers==null || footers.length==0){
				footer = document.createElement("footer");				
				body.insertBefore(footer, content.nextSibling);
				footer.style.position = "fixed";
				footer.style.bottom = "0px";
				footer.style.width = "100%"
				footer.style.setProperty("z-index",10000);
			}else{
				footer = footers[0]; 
			}
			var panel = document.getElementById(this.名称);
            var parent = panel.parentNode;
			parent.removeChild(panel);
			footer.appendChild(panel);
			content.style.paddingBottom=this.面板高度;				
		}
        
        //组件命令：
        this.置可视 = function (value){
            if(value==true){
                var div = document.getElementById(this.名称);
                div.style.display="-webkit-flex";//显示	                
            }else{
                var div = document.getElementById(this.名称);
                div.style.display="none"; //不占位隐藏               
            }
        } 
        
        //组件命令：
        this.置可视2 = function (value){
            if(value==true){
                var div = document.getElementById(this.名称);
                div.style.visibility="visible";//显示	                
            }else{
                var div = document.getElementById(this.名称);
                div.style.visibility="hidden"; //占位隐藏               
            }
        } 

        //组件命令：
        this.显示组件 = function (cname){
			var div = document.getElementById(cname);
			div.style.display="";//显示
			div.removeAttribute("visibility");
			div.style.visibility="visible"; 
        } 

        //组件命令：
        this.隐藏组件 = function (cname,type){
			var div = document.getElementById(cname);
            if(type==false){
                div.style.display="none"; //不占位隐藏           
            }else{
                div.style.visibility="hidden"; //占位隐藏       
            }
        } 
        
    }