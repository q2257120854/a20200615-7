
    function 标签(name,functionName){  
        this.名称 = name;
        
        this.置标题 = function (newTitle){
            //document.getElementById(this.名称).innerText=newTitle;
            document.getElementById(this.名称).innerHTML=newTitle;
        } 

        this.取标题 = function (){
           //return document.getElementById(this.名称).innerText;
           return document.getElementById(this.名称).innerHTML;
        }  

        this.置图标 = function (图标类别,图标名称){
            //var title = document.getElementById(this.名称).innerText;
            var title = document.getElementById(this.名称).innerHTML;
            var temp;
            if(图标类别=="mui-icon"){
                temp = "<span class='mui-icon " + 图标名称 + "' style='vertical-align:middle'></span>"
            }else if(图标类别=="svg"){
                temp = "<svg class='mui-icon icon' aria-hidden='true' style='vertical-align:middle'><use xlink:href='#" + 图标名称 + "' /></svg>"
            }else{
                temp = "<span class='mui-icon " + 图标类别 + " " + 图标名称 + "' style='vertical-align:middle'></span>"
            }            
            document.getElementById(this.名称).innerHTML=temp + title;
        }

        this.置背景颜色 = function (color){
            document.getElementById(this.名称).style.background=color;
        }

        this.置字体颜色 = function (color){
            document.getElementById(this.名称).style.color=color;
        }

        this.置缩略显示 = function (){
            var div = document.getElementById(this.名称);
            div.style.setProperty("white-space", "nowrap");	
            div.style.setProperty("overflow", "hidden");	
            div.style.setProperty("text-overflow", "ellipsis");	
        }

        this.置竖排显示 = function (height){
            document.getElementById(this.名称).style.writingMode = "vertical-lr";
            置组件高度(this.名称,height);
        }

        this.置横排显示 = function (height){
            document.getElementById(this.名称).style.writingMode = "inherit";
            置组件高度(this.名称,height);            
        }

        function 置组件高度(divname,value){
            var div = document.querySelector("#"+divname);
            if(div.parentNode.className!="mui-content"){
                if(div.parentNode.getAttribute("tag")=="自由面板" || div.parentNode.parentNode.getAttribute("tag")=="自由面板"){
                    //自由面板上的组件
                    div.parentNode.style.height = value;
                }else{
                    //面板上的组件
                    div.style.height = value;
                }
            }else{
                div.style.height = value;
            }            
        }    

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
        
        if(functionName!=null){
 			document.getElementById(this.名称).addEventListener("tap", function () {
                functionName();//被单击事件
            });       	
        }
    }  


 