    function 仔仔浏览框(name,event){   
        this.名称 = name;
		var gaodu=document.body.scrollHeight-4.6;
		
		document.getElementById(this.名称).style.height=gaodu+"px";
		document.getElementById(this.名称).style.border="0px";
		
		
		this.访问 = function (newTitle){
			document.getElementById(this.名称).src=newTitle;
        }
		
		this.高度 = function (newTitle){
			document.getElementById(this.名称).style.height=newTitle+"px";
        }
		
		this.取屏幕高度 = function (){
			return document.body.scrollHeight-4.6;
        }
		
        //组件命令：
        this.置可视 = function (value){
            if(value==true){
                var div = document.getElementById(this.名称).parentNode;
                div.style.display="block";//显示	                
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
		
        //组件事件
        if(event!=null){
 		document.getElementById(this.名称).addEventListener("tap", function () {
                event();//触发组件的相关事件，这里演示的是被单击事件
            });       	
        }
    }
	