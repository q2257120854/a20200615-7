    function 开关列表框(name,event1){   
        //name表示组件在被创建时的名称，event表示组件拥有的事件
        //如果组件有多个事件，可以在后面继续填写这些事件名称
        //例如：function 开关列表框(name,event1,event2,event3){
        
        //组件内部属性，仅供组件内部使用：
        this.名称 = name;
		this.有边框 = false;
		
        //组件命令：
        this.显示边框 = function (){
			var card = document.createElement("div");//创建卡片边框节点
			card.className = "mui-card";
			var content = document.querySelector(".mui-content");
			var table = document.getElementById(this.名称);
			content.insertBefore(card,table);//将卡片边框插入到列表框前面
			card.appendChild(table);//将列表框添加到卡片边框里
			this.有边框 = true;
		}

		//组件命令：
		this.添加项目 = function (项目标题,开关样式,开关颜色,开关状态,项目标记){
            var table = document.getElementById(this.名称);
			var li = document.createElement("li");//创建项目节点
			li.className = "mui-table-view-cell";
			li.setAttribute("tag",项目标记); //设置项目标记
			var index = table.getElementsByTagName("li").length;
			li.setAttribute("index",index);//设置项目索引			
			var html = "<span>"+项目标题+"</span>\n";
			html = html + "<div id=\""+this.名称+"-"+index+"\" class=\"mui-switch"; //<div class="mui-switch mui-switch-mini mui-switch-blue mui-active">
			if(开关样式==1){ //1、简洁样式  2、显示on/off
				html = html + " mui-switch-mini";
			}
			if(开关颜色==1){ //1、蓝色  2、绿色
				html = html + " mui-switch-blue";
			}
			if(开关状态==true){ //true:打开  false:关闭
				html = html + " mui-active";
			}
			html = html + "\">\n";	
			html = html + "<div class=\"mui-switch-handle\"></div>\n";	
			html = html + "</div>\n";			
			li.innerHTML = html;//设置项目结构
			table.appendChild(li);//将项目添加到列表框中		
			return index;//返回项目索引
		}

        //组件命令：
        this.添加完毕 = function (){
			mui(".mui-switch")["switch"]();//一定要调用这个命令,否则动态添加的switch开关不能用
        	if(event1!=null){
				mui(".mui-table-view .mui-switch").each(function() { //循环枚举所有switch开关
					this.addEventListener("toggle", function(event) {//监听"开关状态改变"事件
						var index = Number(this.parentNode.getAttribute("index"));
						event1(index,event.detail.isActive);//触发"开关状态改变"事件
					});
				});   	
        	}
        }

		//组件命令：
        this.删除项目=function(index){
            var cell = document.getElementById(this.名称).getElementsByClassName("mui-table-view-cell");
            if(cell==null){
                return;
            }
            if(cell.length<=index){
                return;
            }
            cell[index].parentNode.removeChild(cell[index]); 
			cell = document.getElementById(this.名称).getElementsByClassName("mui-table-view-cell");
			for(var i = 0;i < cell.length; i++){
				cell[i].setAttribute("index",i);//刷新全部项目索引
				var sw = cell[i].getElementsByClassName("mui-switch");
				sw[0].setAttribute("id",this.名称+"-"+i);
			}
        }
		
		//组件命令：
        this.清空项目=function(){
			var root = document.getElementById(this.名称);
		    while(root.hasChildNodes()){
				root.removeChild(root.firstChild);
			}
		}
		
		//组件命令：
        this.取项目总数=function(){
            var cell = document.getElementById(this.名称).getElementsByClassName("mui-table-view-cell");
            if(cell==null){
                return 0;
            }else{
                return cell.length;
            }
        }

        //组件命令：
        this.置开关状态 = function (index,state){
            var cell = document.getElementById(this.名称).getElementsByClassName("mui-table-view-cell");
            if(cell==null){
                return;
            }
            if(cell.length<=index){
                return;
            }
            var sw = cell[index].getElementsByClassName("mui-switch");
            if(state==true){
				if(!sw[0].classList.contains("mui-active")){
					//sw[0].classList.add("mui-active");
					mui("#"+this.名称+"-"+index).switch().toggle();				
				}
			}else{
				if(sw[0].classList.contains("mui-active")){
					//sw[0].classList.remove("mui-active");	
					mui("#"+this.名称+"-"+index).switch().toggle();
				}				
			}
			
        } 
        
        //组件命令：
        this.取开关状态 = function (index){
            var cell = document.getElementById(this.名称).getElementsByClassName("mui-table-view-cell");
            if(cell==null){
                return;
            }
            if(cell.length<=index){
                return;
            }
            var sw = cell[index].getElementsByClassName("mui-switch");
			return sw[0].classList.contains("mui-active");         
        } 
		
        //组件命令：
        this.置项目标题 = function (index,title){
            var cell = document.getElementById(this.名称).getElementsByClassName("mui-table-view-cell");
            if(cell==null){
                return;
            }
            if(cell.length<=index){
                return;
            }
            var span = cell[index].getElementsByTagName("span");
            span[0].innerText=title;
        } 
        
        //组件命令：
        this.取项目标题 = function (index){
            var cell = document.getElementById(this.名称).getElementsByClassName("mui-table-view-cell");
            if(cell==null){
                return "";
            }
            if(cell.length<=index){
                return "";
            }
            var span = cell[index].getElementsByTagName("span");
            var title = span[0].innerText;
            return title;           
        }  

        //组件命令：
        this.置项目标记 = function (index,tag){
            var cell = document.getElementById(this.名称).getElementsByClassName("mui-table-view-cell");
            if(cell==null){
                return;
            }
            if(cell.length<=index){
                return;
            }
            cell[index].setAttribute("tag",项目标记);
        } 
        
        //组件命令：
        this.取项目标记 = function (index){
            var cell = document.getElementById(this.名称).getElementsByClassName("mui-table-view-cell");
            if(cell==null){
                return "";
            }
            if(cell.length<=index){
                return "";
            }
            var tag = cell[index].getAttribute("tag");
            return tag;           
        } 
        
        //组件命令：
        this.置可视 = function (value){
            if(value==true){
                var div = document.getElementById(this.名称);
				if(this.有边框 == false){
					div.style.display="block";//显示	
				}else{
					div.parentNode.style.display="block";//显示	
				}                                
            }else{
                var div = document.getElementById(this.名称);
				if(this.有边框 == false){
					div.style.display="none"; //不占位隐藏  
				}else{
					div.parentNode.style.display="none"; //不占位隐藏  
				}            
            }
        } 
        
        //组件命令：
        this.置可视2 = function (value){
            if(value==true){
                var div = document.getElementById(this.名称);
				if(this.有边框 == false){
					div.style.visibility="visible";//显示
				}else{
					div.parentNode.style.visibility="visible";//显示
				}               	                
            }else{
                var div = document.getElementById(this.名称);
				if(this.有边框 == false){
					div.style.visibility="hidden"; //占位隐藏
				}else{
					div.parentNode.style.visibility="hidden"; //占位隐藏
				}                               
            }
        } 
        

    }