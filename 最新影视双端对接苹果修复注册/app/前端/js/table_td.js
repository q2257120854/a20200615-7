    function 普通表格(name,event){ 
        //name表示组件在被创建时的名称，event表示组件拥有的事件
        //如果组件有多个事件，可以在后面继续填写这些事件名称
        //例如：function 普通表格(name,event1,event2,event3){
        
		
		//注意：在工程数据-设置-属性中,添加了用于创建组件的HTML代码
		//注意：在工程的css样式目录里,放置了一个css样式文件,可以修改里面的样式设置
		
        //组件内部属性，仅供组件内部使用：	  
        this.名称 = name;
		
		//组件命令：
		this.添加表项 = function (color,items){ //color为文本型,items为文本型数组
			var 单元格="";
			var 行索引=document.getElementById(this.名称).childNodes.length;
			for (var i=0;i<items.length;i++)
			{
				单元格=单元格+"<td id=\""+this.名称+"-"+行索引+"-"+i+"\">"+items[i]+"</td>";
			}
			if(color==""){
		   		document.getElementById(this.名称).innerHTML=document.getElementById(this.名称).innerHTML+
			                      "<tr id=\""+this.名称+"-"+行索引+"\">"+单元格+"</tr>";				
			}else{
		   		document.getElementById(this.名称).innerHTML=document.getElementById(this.名称).innerHTML+
			                      "<tr id=\""+this.名称+"-"+行索引+"\" style=\"background:"+color+"\">"+单元格+"</tr>";				
			}
        }

		//组件命令：
		this.删除表项 = function (行索引){
			var table = document.getElementById(this.名称);
			var tr = document.getElementById(this.名称+"-"+行索引);
            var tbody = tr.parentNode;
			table.removeChild(tbody);//删除该行				
            var trs = document.getElementById(this.名称).getElementsByTagName("tr");
			if(trs!=null){		
				for(var i=0;i<trs.length;i++){
					trs[i].id=this.名称+"-"+i;//更新其他表项的行索引
					var tds = trs[i].getElementsByTagName("td");
					if(tds!=null){
						for(var j=0;j<tds.length;j++){
							tds[j].id=this.名称+"-"+i+"-"+j;//更新表项的单元格的行索引
						}
					}
				}
			}
        }
		
		//组件命令：
        this.清空表项 = function (){
			var table = document.getElementById(this.名称);
		    while(table.hasChildNodes()){
				table.removeChild(table.firstChild);
			}
		}

		//组件命令：
		this.置字体大小 = function (大小){
			document.getElementById(this.名称).style.fontSize=大小;
		}

		//组件命令：
		this.置边框颜色 = function (颜色){
			document.getElementById(this.名称).style.borderColor=颜色;
		}

		//组件命令：
		this.置表项背景色 = function (行索引,颜色){
		    var id = this.名称+"-"+行索引;
			document.getElementById(id).style.background=颜色;
		}

		//组件命令：
		this.置单元格背景色 = function (行索引,列索引,颜色){
		    var id = this.名称+"-"+行索引+"-"+列索引;
			document.getElementById(id).style.background=颜色;
		}

		//组件命令：
		this.置单元格文字色 = function (行索引,列索引,颜色){
		    var id = this.名称+"-"+行索引+"-"+列索引;
			document.getElementById(id).style.color=颜色;
		}

		//组件命令：
		this.置表项标记 = function (行索引,标记){
		    var id = this.名称+"-"+行索引;
			document.getElementById(id).setAttribute("tag",标记);
		}

		//组件命令：
		this.取表项标记 = function (行索引){
		    var id = this.名称+"-"+行索引;
			return document.getElementById(id).getAttribute("tag");
		}
		
		//组件命令：
		this.置单元格内容 = function (行索引,列索引,内容){
		    var id = this.名称+"-"+行索引+"-"+列索引;
			document.getElementById(id).innerHTML=内容;
		}
		
		//组件命令：
		this.取单元格内容 = function (行索引,列索引){
			var id = this.名称+"-"+行索引+"-"+列索引;
			var title = document.getElementById(id).innerHTML;
			title = title.replace(/(^\n*)|(\n*$)/g, ""); //去掉首尾的换行符
			return title;
		}
		
		//组件命令：
		this.取表项总数 = function (){
            return document.getElementById(this.名称).getElementsByTagName("tr").length;
        }
        
        //组件命令：
        this.置可视 = function (value){
            if(value==true){
                var div = document.getElementById(this.名称);
                div.style.display="";//显示               
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
		        
        //组件事件        
		if(event!=null){
            mui("#"+this.名称).on("tap", "td", function() {
				var index = this.getAttribute("id").split("-"); //id:表格名称-行索引-列索引
                var title = this.innerText;
                title = title.replace(/(^\n*)|(\n*$)/g, ""); //去掉首尾的换行符
                event(Number(index[1]),Number(index[2]),title);//单元格被单击事件，返回单元格所在的行索引、列索引、单元格内容
            });       	
        }
    }
	
