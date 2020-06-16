    function 微信登录(name,event1,event2){   
        //name表示组件在被创建时的名称，event表示组件拥有的事件
        //如果组件有多个事件，可以在后面继续填写这些事件名称
        //例如：function 微信登录(name,event1,event2,event3){
        
        //组件内部属性，仅供组件内部使用：
        this.名称 = name;
        var auths = null; 
		
        //组件命令：
        this.获取登录服务列表 = function (){
 			plus.oauth.getServices(function(s) {              
            	auths = s; 
				var temp = new Array;
            	for (var i in s) { 
                	var t = s[i]; 
					temp.push(t.id);
            	}        		
        		if(event1!=null){
 			     	event1(true,temp);//触发获取完毕事件	
        		}				
        	}, function(e) { 
            	//console.log("获取登录服务列表失败：" + e.message); 
        		if(event1!=null){
 			     	event1(false,null);//触发获取完毕事件	
        		}					
        	}); 
        } 
        
        //组件命令：
        this.登录微信 = function (){
           authLogin("weixin");
        }  

        //组件命令：
        this.登录QQ = function (){
           authLogin("qq");
        }  

        //组件命令：
        this.登录新浪微博 = function (){
           authLogin("sinaweibo");
        }  

		function authLogin(type) { 
            var s; 
            for (var i = 0; i < auths.length; i++) { 
                if (auths[i].id == type) { 
                    s = auths[i]; 
                    break; 
                } 
            } 
            s.login(function(e) { 
                //mui.toast("登录认证成功！"); 
				s.getUserInfo(function(e) { 
                    var josnStr = JSON.stringify(s.userInfo);  
                    //console.log("获取用户信息成功：" + josnStr); 
                    authLogout(); //登录完毕之后马上注销登录
        			if(event2!=null){
 			     		event2(true,josnStr);//触发登录完毕事件	
        			}						
                }, function(e) { 
                    //alert("获取用户信息失败：" + e.message + " - " + e.code); 
        			if(event2!=null){
 			     		event2(false,"");//触发登录完毕事件	
        			}						
                }); 
            }, function(e) { 
                //mui.toast("登录认证失败！"); 
        			if(event2!=null){
 			     		event2(false,"");//触发登录完毕事件	
        			}					
            }); 

		}

        function authLogout() { 
            for (var i in auths) { 
                var s = auths[i]; 
                if (s.authResult) { 
                    s.logout(function(e) { 
                        //console.log("注销登录成功！"); 
                    }, function(e) { 
                        //console.log("注销登录失败！"); 
                    }); 
                } 
            } 
        } 		

    }