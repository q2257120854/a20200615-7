
    function 按钮(name,event1,event2,event3){  
        this.名称 = name;
        
        this.置标题 = function (newTitle){
            document.getElementById(this.名称).innerHTML=newTitle;
        } 

        this.取标题 = function (){
           return document.getElementById(this.名称).innerHTML;
        }  

        this.置图标 = function (图标类别,图标名称){
            if(图标类别=="mui-icon"){
                document.getElementById(this.名称).classList.add(图标类别);
            }else{
                document.getElementById(this.名称).classList.add("mui-icon");
                document.getElementById(this.名称).classList.add(图标类别);
            }
            document.getElementById(this.名称).classList.add(图标名称);
        } 

        this.置样式 = function (style){
            document.getElementById(this.名称).className=style;
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
        
        if(event1!=null){
 			document.getElementById(this.名称).addEventListener("tap", function () {
                event1();//被单击事件
            });       	
        }
        
        if(event2!=null){
 			document.getElementById(this.名称).addEventListener("hold", function () {
                event2();//被按下事件
            });       	
        }        
        
        if(event3!=null){
 			document.getElementById(this.名称).addEventListener("release", function () {
                event3();//被弹起事件
            });       	
        }  
        
        //mui(".mui-input-row").on("longtap", "#"+this.名称, function(e) {
            //被长按事件
        //});         
        
    }  


 