
    function 按钮组(name,event){  
        this.名称 = name;

        this.置样式 = function (index,style){
            var div = document.getElementById(this.名称);
            //var buttons = div.childNodes;
            var buttons = div.getElementsByTagName("button");
            if(index<buttons.length){
                buttons[index].className=style;
            }
        } 
        
        this.置标题 = function (index,newTitle){
            var div = document.getElementById(this.名称);
            //var buttons = div.childNodes;
            var buttons = div.getElementsByTagName("button");
            if(index<buttons.length){
                buttons[index].innerHTML=newTitle;
            }
        } 

        this.取标题 = function (index){
            var div = document.getElementById(this.名称);
            //var buttons = div.childNodes;
            var buttons = div.getElementsByTagName("button");
            if(index<buttons.length){
                return buttons[index].innerHTML;
            }else{
                return "";
            }
        }  

        this.置可视 = function (value){
            if(value==true){
                var div = document.getElementById(this.名称);
                div.style.display="-webkit-flex";                
            }else{
                var div = document.getElementById(this.名称);
                div.style.display="none"; //不占位               
            }
        } 

        this.置可视2 = function (value){
            if(value==true){
                var div = document.getElementById(this.名称);
                div.style.visibility="visible";	                
            }else{
                var div = document.getElementById(this.名称);
                div.style.visibility="hidden"; //占位               
            }
        } 
        
        if(event!=null){
 			mui("#"+this.名称).on("tap", "button",function () {
                var index = this.getAttribute("id");
                event(Number(index));//被单击事件，返回按钮索引
            });       	
        }
    }  


 