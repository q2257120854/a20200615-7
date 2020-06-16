
    function 列表框(name,arrow,event1,event2){  
        this.名称 = name;
        this.显示箭头 = arrow;

        this.置可视 = function (value){
            if(value==true){
                var div = document.getElementById(this.名称).parentNode;
                div.style.display="";	                
            }else{
                var div = document.getElementById(this.名称).parentNode;
                div.style.display="none"; //不占位               
            }
        } 

        this.置可视2 = function (value){
            if(value==true){
                var div = document.getElementById(this.名称).parentNode;
                div.style.visibility="visible";	                
            }else{
                var div = document.getElementById(this.名称).parentNode;
                div.style.visibility="hidden"; //占位               
            }
        } 
        
        this.添加项目 = function (title,tag,buttonClass,buttonTitle){
            var table = document.getElementById(this.名称);
            var li = document.createElement('li');
            li.className = 'mui-table-view-cell';
            li.setAttribute("tag",tag); //设置项目标记
            var itemTitle = title;
            if(buttonClass!=null && buttonClass!=""){
                itemTitle = itemTitle + "<button type='button' class='"+buttonClass+"'>" + buttonTitle + "</button>"; //显示右侧按钮
            }            
            if(this.显示箭头==true){
                li.innerHTML = '<a class="mui-navigate-right">' + itemTitle + '</a>'; //显示右侧箭头
            }else{
                li.innerHTML = itemTitle;
            }
            var index = table.getElementsByTagName("li").length;
            li.index = index;//设置项目索引
            table.appendChild(li);
            return index;
        } 

        this.添加项目2 = function (title,tag,buttonClass,buttonTitle){
            var table = document.getElementById(this.名称);
            var li = document.createElement('li');
            li.className = 'mui-table-view-cell mui-card';
            li.setAttribute("tag",tag); //设置项目标记
            var itemTitle = title;
            if(buttonClass!=null && buttonClass!=""){
                itemTitle = itemTitle + "<button type='button' class='"+buttonClass+"'>" + buttonTitle + "</button>"; //显示右侧按钮
            }            
            if(this.显示箭头==true){
                li.innerHTML = '<a class="mui-navigate-right">' + itemTitle + '</a>'; //显示右侧箭头
            }else{
                li.innerHTML = itemTitle;
            }
            var index = table.getElementsByTagName("li").length;
            li.index = index;//设置项目索引
            table.appendChild(li);
            return index;
        } 
        
        this.删除项目 = function (index){
            /*var table = document.getElementById(this.名称);
            var li = table.childNodes;
            console.log(li.length);
            console.log(li[index].nodeName);
            if(index<li.length){
                table.removeChild(li[index]);
            }*/
            var li = document.getElementById(this.名称).getElementsByTagName("li");
            //console.log(li.length);
            if(index<li.length){
                var table = li[index].parentNode;
                table.removeChild(li[index]);
                var li2 = document.getElementById(this.名称).getElementsByTagName("li");
                for(var i = 0;i < li2.length; i++){
                    li2[i].index=i;//刷新全部项目索引
                }
            }
        }

        this.清空项目 = function (){
            var table = document.getElementById(this.名称);
            while(table.hasChildNodes()){
                table.removeChild(table.firstChild);
            }
        }
        
        this.置项目标题 = function (index,title,buttonClass,buttonTitle){
            //document.getElementById(this.名称).getElementsByTagName("li")[index].innerText = title; //会丢失箭头
            var li = document.getElementById(this.名称).getElementsByTagName("li")[index];
            var itemTitle = title;
            if(buttonClass!=null && buttonClass!=""){
                itemTitle = itemTitle + "<button type='button' class='"+buttonClass+"'>" + buttonTitle + "</button>"; //显示右侧按钮
            }             
            if(this.显示箭头==true){
                li.innerHTML = '<a class="mui-navigate-right">' + itemTitle + '</a>'; 
            }else{
                li.innerHTML = itemTitle;
            }            
        }
        
        this.取项目标题 = function (index){
            return getTitle(index);  
        }

        function getTitle(index){
            //return document.getElementById(this.名称).getElementsByTagName("li")[index].innerText; //尾部会多出一个换行符
            var li = document.getElementById(name).getElementsByTagName("li")[index];
            var title = li.innerText;
            /*if(title!="" && title.length>1){
                if(title.substring(title.length-1,title.length)=="\n"){
                    title = title.substr(0,title.length-1);//去掉首尾的换行符 
                }
            }*/
            title=title.replace(/(^\n*)|(\n*$)/g, ""); //去掉首尾的换行符
            var button = li.getElementsByTagName("button")[0];
            if(button!=null && typeof(button)!="undefined"){
                var buttonTitle = button.innerText;
                title = title.substr(0,title.length-buttonTitle.length);
            }
            return title;  
        }

        this.置项目标记 = function (index,tag){
            document.getElementById(this.名称).getElementsByTagName("li")[index].setAttribute("tag",tag); 
        }
        
        this.取项目标记 = function (index){
            return document.getElementById(this.名称).getElementsByTagName("li")[index].getAttribute("tag");
        }

        this.取项目总数 = function (){
            return document.getElementById(this.名称).getElementsByTagName("li").length;
        }

        this.置背景颜色 = function (r,g,b,a){
			var div = document.getElementById(this.名称);	
			div.style.setProperty("background-color", "rgba(" + r + "," + g + "," + b + "," + a + ")");			
		}

        this.置标题颜色 = function (value){
			var div = document.getElementById(this.名称);	
			div.style.setProperty("color", value);			
		}

        this.置分割线颜色 = function (value){
            var styleElement = document.createElement('style');
            styleElement.type = 'text/css';
            document.getElementsByTagName('head')[0].appendChild(styleElement);
            styleElement.appendChild(document.createTextNode("#"+this.名称+" .mui-table-view-cell:after{background-color: "+value+" !important;}")); 
		}        

        this.置箭头颜色 = function (value){
            var styleElement = document.createElement('style');
            styleElement.type = 'text/css';
            document.getElementsByTagName('head')[0].appendChild(styleElement);
            styleElement.appendChild(document.createTextNode("#"+this.名称+" a.mui-navigate-right:after{color: "+value+" !important;}")); 
		}  
       
        this.按钮被单击=false;

        function getState(){
            return this.按钮被单击;
        }

        function setState(value){
            this.按钮被单击=value;
        }
        
        if(event1!=null){
            mui('#'+this.名称).on('tap', 'li', function() {
                var index = Number(this.index);
                //var title = this.innerText;
                //title=title.replace(/(^\n*)|(\n*$)/g, ""); //去掉首尾的换行符                
                var title = getTitle(index);
                var tag = this.getAttribute("tag");
                if(getState()==true){
                    setState(false); 
                }else{
                   event1(index,title,tag);//表项被单击事件，返回项目索引、项目标题、项目标记
                }
            });       	
        }
        
        if(event2!=null){
            mui('#'+this.名称).on('tap', 'button', function() {
                setState(true);
                var li;
                if(arrow){
                    li = this.parentNode.parentNode;  
                }else{
                    li = this.parentNode;  
                }
                var index = Number(li.index);           
                event2(index);//按钮被单击事件，返回项目索引
            });       	
        }        
    }  


 