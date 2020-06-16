
    function 菜单(name,eventName){  
        this.名称 = name;
        var 菜单数组 = new Array();
        this.添加菜单项 = function (菜单项标题){
			if(mui.os.plus){
				var item = {title:菜单项标题};
				菜单数组.push(item);
			}else{
				var table = document.getElementById(this.名称).getElementsByTagName("ul")[0];
				var li = document.createElement('li');
				li.className = 'mui-table-view-cell';
				li.innerHTML = "<a href="+"'#"+this.名称+"'>"+菜单项标题+"</a>";
				table.appendChild(li);				
			}			
        } 

        this.清空菜单项 = function (){
			if(mui.os.plus){
				菜单数组.splice(0,菜单数组.length);
			}else{			
				var table = document.getElementById(this.名称).getElementsByTagName("ul")[0];
				while(table.hasChildNodes()){
					table.removeChild(table.firstChild);
				}
			}
        } 

        this.显示菜单 = function (){
			if(mui.os.plus){
				plus.nativeUI.actionSheet( {cancel:"取消",buttons:菜单数组}, function(e){
					if(e.index>0){
						var item = 菜单数组[e.index-1];
						eventName(item.title);//菜单项被单击事件，返回菜单项标题
					}else{
						eventName("取消");
					}
				});
			}else{			
				mui('#'+this.名称).popover('show');
			}
        } 

        this.隐藏菜单 = function (){
			if(!mui.os.plus){
				mui('#'+this.名称).popover('hide');
			}
        } 

        if(eventName!=null){
			if(!mui.os.plus){
				mui('#'+this.名称).on('tap', '.mui-popover-action li>a', function() {
					mui('#'+name).popover('hide');//隐藏菜单
					eventName(this.innerText);//菜单项被单击事件，返回菜单项标题
				});      
			}
        }
    }  


 