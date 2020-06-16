    function 渐渐下载列表框(name,event){   
        //name表示组件在被创建时的名称，event表示组件拥有的事件
        //如果组件有多个事件，可以在后面继续填写这些事件名称
        //例如：function 渐渐下载列表框(name,event1,event2,event3){
        
        //组件内部属性，仅供组件内部使用：
        this.名称 = name;
        this.项目总数 = 0;

        //组件命令：
        this.置可视 = function (value){
            if(value==true){
                var div = document.getElementById(this.名称).parentNode;
                div.style.display="";//显示，也可以设置为block	                
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
		
		this.添加项目 = function(图片,圆角度,标题,标题颜色,进度,最大进度,标签1,标签2,标签颜色,项目标记){
			var div = document.createElement("li");//创建一个卡片节点
			div.id = "DownloadListBox"+this.项目总数;
			div.className = "mui-table-view-cell mui-media";//设置类名
			div.setAttribute("index",""+this.项目总数);//设置项目索引
			div.innerHTML = "	<a href=\"javascript:;\" style=\"height:60px;position:relative;top:-8px;\">\n"+
							"		<img class=\"mui-media-object mui-pull-left\" style=\"border-radius:"+圆角度+"px;position:relative;top:5px;\" src=\""+图片+"\">\n"+
							"			<div class=\"mui-media-body\">\n"+
							"               <span id=\"jianjiandowbt"+this.项目总数+"\" style=\"font-size: 16px;color:"+标题颜色+";\">"+标题+"</span>\n"+
							"				<p class='mui-ellipsis'>\n"+
							"					<progress value=\""+进度+"\" max=\""+最大进度+"\" id=\"jianjainproDownFile"+this.项目总数+"\" style=\"width: 100%;height: 4px;position:relative;top:-5px;\"></progress>\n"+
							"				</p>\n"+
							"				<span id=\"jianjaindownbq1"+this.项目总数+"\" style=\"font-size: 10px;position:relative;top:-10px;color:"+标签颜色+";\">"+标签1+"</span><span id=\"jianjaindownbq2"+this.项目总数+"\" style=\"float:right;font-size: 10px;position:relative;top:-9px;color:"+标签颜色+";\">"+标签2+"</span>\n"+
							"			</div>\n"+
							"	</a>"
			var root = document.getElementById(this.名称);
			root.appendChild(div);//将卡片节点添加到卡片列表根节点
			this.项目总数 = this.项目总数+1;
		}
		
		this.置项目进度 = function(表项索引,进度,标签1,标签2){
			var a = document.getElementById("jianjainproDownFile" + 表项索引);
				a.value = 进度;
		}
		this.置项目最大进度 = function(表项索引,最大进度,标签1,标签2){
			var a = document.getElementById("jianjainproDownFile" + 表项索引);
				a.max = 最大进度;
		}
		this.置标题颜色 = function(表项索引,项目颜色){
			var a = document.getElementById("jianjiandowbt" + 表项索引);
				a.style.color = 项目颜色;
		}
		
		this.置标签颜色 = function(表项索引,标签颜色){
			var a = document.getElementById("jianjaindownbq1" + 表项索引);
				a.style.color = 标签颜色;
			var a = document.getElementById("jianjaindownbq2" + 表项索引);
				a.style.color = 标签颜色;
		}
		
		this.置项目标题 = function(表项索引,标题){
			var a = document.getElementById("jianjiandowbt" + 表项索引);
				a.innerHTML = 标题;
		}
		
		this.置项目标签1 = function(表项索引,标签1){
			var a = document.getElementById("jianjaindownbq1" + 表项索引)
				a.innerHTML = 标签1;
		}
		
		this.置项目标签2 = function(表项索引,标签1){
			var a = document.getElementById("jianjaindownbq2" + 表项索引)
				a.innerHTML = 标签2;
		}
		
		
		
		this.取项目标题 = function(表项索引){
			var a = document.getElementById("jianjiandowbt" + 表项索引);
				return a.innerText;
		}
		
		this.取项目标签1标题 = function(表项索引){
			var a = document.getElementById("jianjaindownbq1" + 表项索引);
				return a.innerHTML;
		}
		
		this.取项目标签2标题 = function(表项索引){
			var a = document.getElementById("jianjaindownbq2" + 表项索引);
				return a.innerHTML;
		}
		
		this.取进度条最大位置 = function(表项索引){
			var a = document.getElementById("jianjainproDownFile" + 表项索引);
				return a.max;
		}
		
		this.取进度条位置 = function(表项索引){
			var a = document.getElementById("jianjainproDownFile" + 表项索引);
				return a.value;
		}
		
		this.取项目标记 = function(表项索引){
			return document.getElementById("DownloadListBox" + 表项索引).getAttribute("tag");
		}
		
		this.清空项目 = function(){
			var root = document.getElementById(this.名称);
			while(root.hasChildNodes()){
				root.removeChild(root.firstChild);
				this.项目总数 = 0;
			}
		}
		
		this.删除项目 = function(表项索引){
			var item = document.getElementById("DownloadListBox"+表项索引);
			if (item == null){
				return;
			}
			item.parentNode.removeChild(item);//删除项目节点
			this.项目总数 = this.项目总数 - 1;
			
			item = document.getElementById(this.名称).getElementsByClassName("mui-table-view-cell");
			for(var i = 0;i < item.length; i++){//刷新全部项目索引				
				item[i].setAttribute("id","DownloadListBox"+i);
				item[i].setAttribute("index",i);

				var handle = item[i].getElementsByClassName("mui-media-body");
				var span = handle[0].getElementsByTagName("span");
				span[0].setAttribute("id","jianjiandowbt"+i);
				span[1].setAttribute("id","jianjaindownbq1"+i);
				span[2].setAttribute("id","jianjaindownbq2"+i);
				
				var handle = item[i].getElementsByClassName("mui-ellipsis");
				var span = handle[0].getElementsByTagName("progress");
				span[0].setAttribute("id","jianjainproDownFile"+i);
			}
		}
        
        //组件事件
        if(event!=null){
			mui("#"+this.名称).on("tap", ".mui-table-view-cell.mui-media", function() {
				var index2 = this.getAttribute("index");
				event(Number(index2));//触发组件的相关事件，这里的是"表项按钮被单击"事件
			});
        }
    }