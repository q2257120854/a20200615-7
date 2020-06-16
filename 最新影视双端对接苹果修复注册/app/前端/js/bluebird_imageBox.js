
    function 图片框(name,functionName){  
        this.名称 = name;
        
        this.置图片 = function (newSrc){
            document.getElementById(this.名称).src=newSrc;
        } 

        this.取图片 = function (){
           return document.getElementById(this.名称).src;
        }  

        this.置圆角 = function (value){
            document.getElementById(this.名称).style.borderRadius=value;
        } 

        this.置边框 = function (width,color){
			var img = document.getElementById(this.名称);
			img.style.border="solid "+width+" "+color;
		}

        this.置阴影 = function (blur,spread,color){
			var img = document.getElementById(this.名称);
			img.style.boxShadow="0px 0px "+blur+" "+spread+" "+color;
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


 