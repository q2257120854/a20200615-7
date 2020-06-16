
    function 编辑框(name,event1,event2,event3,event4,event5){  
        this.名称 = name;
        
        this.置内容 = function (newText){
            document.getElementById(this.名称).value=newText;
        } 

        this.取内容 = function (){
           return document.getElementById(this.名称).value;
        }  

        this.置边框 = function (width,color){
			var div = document.getElementById(this.名称);
			div.style.border="solid "+width+" "+color;
		}

        this.置背景颜色 = function (r,g,b,a){
			var div = document.getElementById(this.名称);	
			div.style.setProperty("background-color", "rgba(" + r + "," + g + "," + b + "," + a + ")");			
		}

        this.置图标 = function (path){
			var div = document.getElementById(this.名称);	
            div.style.setProperty("padding-left","40px");
            div.style.background = "url("+path+") no-repeat 5px center #FFFFFF";				
		}

        this.置只读模式 = function (value){
			var div = document.getElementById(this.名称);
			if(value==true){
                div.setAttribute("readonly",value);
			}else{
                div.removeAttribute("readonly");
			}
		}

        this.置提示内容 = function (value){
			var div = document.getElementById(this.名称);
			div.setAttribute("placeholder",value);
		}
		
        this.清除焦点 = function (){
			var div = document.getElementById(this.名称);
			div.blur();
		}		

        this.获取焦点 = function (){
			var div = document.getElementById(this.名称);
			div.focus();
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
 			document.getElementById(this.名称).addEventListener("keydown", function (e) {
                var keynum = window.event ? e.keyCode : e.which;
                event2(keynum);//按下某键事件
            });       	
        } 
        
        if(event3!=null){
 			document.getElementById(this.名称).addEventListener("input", function () {
                event3(this.value);//内容被改变事件
            });       	
        }        

        if(event4!=null){
 			document.getElementById(this.名称).addEventListener("blur", function () {
                event4();//失去焦点事件
            });       	
        } 

        if(event5!=null){
 			document.getElementById(this.名称).addEventListener("focus", function () {
                event5();//获得焦点事件
            });       	
        } 
        
    }  


 