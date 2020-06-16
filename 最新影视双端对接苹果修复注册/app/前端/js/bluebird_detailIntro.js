    function 伸缩简介框(name){   
        //name表示组件在被创建时的名称，event表示组件拥有的事件
        //如果组件有多个事件，可以在后面继续填写这些事件名称
        //例如：function 伸缩简介框(name,event1,event2,event3){
        
        //组件内部属性，仅供组件内部使用：
        var 名称 = name;

 		document.getElementById(名称).addEventListener("tap", function () {
			if(document.getElementById(名称).classList.contains("detail-intro-hide")==true){
				document.getElementById(名称).classList.remove("detail-intro-hide");				
				document.getElementById(名称).getElementsByTagName("span")[0].className="mui-icon mui-icon-arrowup";				
			}else{
				document.getElementById(名称).classList.add("detail-intro-hide");
				document.getElementById(名称).getElementsByTagName("span")[0].className="mui-icon mui-icon-arrowdown";
			}
        }); 

        this.置背景颜色 = function (color){
            document.getElementById(名称).style.background=color;
        }

        this.置字体颜色 = function (color){
            document.getElementById(名称).style.color=color;
        }
        
        //组件命令：
        this.置内容 = function (newTitle){
            document.getElementById(名称).getElementsByClassName("detail-intro-text")[0].innerHTML=newTitle;
        } 
        
        //组件命令：
        this.取内容 = function (){
           return document.getElementById(名称).getElementsByClassName("detail-intro-text")[0].innerHTML;
        }  
        
        //组件命令：
        this.置可视 = function (value){
            if(value==true){
                var div = document.getElementById(名称).style.display="";//显示，也可以设置为block	      
            }else{
                var div = document.getElementById(名称).style.display="none"; //不占位隐藏              
            }
        } 
        
        //组件命令：
        this.置可视2 = function (value){
            if(value==true){
                var div = document.getElementById(名称).style.visibility="visible";//显示	      
            }else{
                var div = document.getElementById(名称).style.visibility="hidden"; //占位隐藏               
            }
        } 
             	

    }