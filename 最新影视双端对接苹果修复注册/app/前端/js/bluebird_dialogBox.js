
    function 对话框(name,eventName1,eventName2,eventName3){  
        this.名称 = name;
        this.mytoast = null;
        
        this.信息框 = function (title,msg){        
            mui.alert(msg, title, function() {
            	if(eventName1!=null){
                    eventName1();
                }
            },"div");
        } 

        this.信息框_全局 = function (msg){ 
            alert(msg);
        }

        this.信息框_原生 = function (title,msg,ok){        			
			plus.nativeUI.alert(msg, function(){
            	if(eventName1!=null){
                    eventName1();
                }
			}, title, ok);			
        }
        
        this.询问框 = function (title,msg,ok,no){
            var btnArray = [ok,no];
            mui.confirm(msg, title, btnArray, function(e) {
            	if(eventName2!=null){
                	eventName2(e.index);
               }
            },"div");
        } 

        this.询问框_全局 = function (msg){ 
            return confirm(msg);
        }

        this.询问框_原生 = function (title,msg,ok,no){
            var btnArray = [ok,no];			
			plus.nativeUI.confirm(msg, function(e){
            	if(eventName2!=null){
                	eventName2(e.index);
                }
			}, title, btnArray);			
        } 
        
        this.输入框 = function (title,msg,ok,no){
            var btnArray = [ok,no];
            mui.prompt(msg, "", title, btnArray, function(e) {
            	if(eventName3!=null){
            		eventName3(e.index,e.value);
            	}
            },"div");
        } 

        this.输入框_全局 = function (msg,defmsg){ 
            return prompt(msg,defmsg);
        }

        this.输入框_原生 = function (title,msg,ok,no){
            var btnArray = [ok,no];			
			plus.nativeUI.prompt(msg, function(e){
            	if(eventName3!=null){
            		eventName3(e.index,e.value);
            	}				
			},title, "", btnArray);			
        }		
		
        this.弹出提示 = function (msg){        
            mui.toast(msg);
        } 

        this.显示等待框 = function (msg){
            if(mui.os.plus){
                try{
                    plus.nativeUI.showWaiting(msg);
                }catch(e){
                    console.log("'显示等待框'命令只能在手机中运行");
                }                
            }else{
                this.mytoast = document.createElement("div");
                this.mytoast.classList.add("mui-toast-container");
                this.mytoast.style.bottom = "200px";
                this.mytoast.innerHTML = "<div class=\"mui-toast-message\"><a class=\"mui-icon mui-spinner\"></a><br>" + msg + "</div>";
                document.body.appendChild(this.mytoast);   
                this.mytoast.classList.add("mui-active");           
            }           
        } 
        
        this.关闭等待框 = function (){
            if(mui.os.plus){
                try{
                    plus.nativeUI.closeWaiting();
                }catch(e){
                    console.log("'关闭等待框'命令只能在手机中运行");
                }  
            }else{
                if(this.mytoast!=null){
                    this.mytoast.classList.remove("mui-active");
                    this.mytoast.parentNode.removeChild(this.mytoast);
                    this.mytoast = null;
                }
            }              
        }         
        
    }  


 