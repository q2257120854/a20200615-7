    function 微信分享(name,event1,event2){  
        //name表示组件在被创建时的名称，event表示组件拥有的事件
        //如果组件有多个事件，可以在后面继续填写这些事件名称
        //例如：function 微信分享(name,event1,event2,event3){
        
        //组件内部属性，仅供组件内部使用：
        this.名称 = name;
        var shares = null; 

        //组件命令：
        this.获取分享服务列表 = function (){
 			plus.share.getServices(function(s) {              
            	shares = {}; 
				var temp = new Array;
            	for (var i in s) { 
                	var t = s[i]; 
                	shares[t.id] = t; 
					temp.push(t.id);
            	}        		
        		if(event1!=null){
 			     	event1(true,temp);//触发组件事件	
        		}				
        	}, function(e) { 
            	//console.log("获取分享服务列表失败：" + e.message); 
        		if(event1!=null){
 			     	event1(false,null);//触发组件事件	
        		}					
        	}); 
        } 
        
        //组件命令：
        this.分享到微信好友 = function (href,title,content,image,picture){
			 shareAction("weixin","WXSceneSession",href,title,content,image,picture);
        }  
       
        //组件命令：
        this.分享到微信朋友圈 = function (href,title,content,image,picture){
             shareAction("weixin","WXSceneTimeline",href,title,content,image,picture);
        }  

        //组件命令：
        this.分享到QQ好友 = function (href,title,content,image,picture){
			 shareAction("qq","",href,title,content,image,picture);
        }

        //组件命令：
        this.分享到腾讯微博 = function (href,title,content,image,picture){
			 shareAction("tencentweibo","",href,title,content,image,picture);
        }

        //组件命令：
        this.分享到新浪微博 = function (href,title,content,image,picture){
			 shareAction("sinaweibo","",href,title,content,image,picture);
        }
		
		function shareAction(id,ex,href,title,content,image,picture) { 
        	var s = null;          
        	if (!id || !(s = shares[id])) { 
            	//console.log("无效的分享服务"); 
				event_b(false,1);
            	return; 
        	} 
        	if (s.authenticated) { 
            	//console.log("---已授权---"); 
            	shareMessage(s,ex,href,title,content,image,picture); 
        	} else { 
            	//console.log("---未授权---"); 
            	//TODO 授权无法回调，有bug 
            	s.authorize(function() {     
                	//console.log("授权成功...");               
                	shareMessage(s,ex,href,title,content,image,picture); 
            	}, function(e) {         
                	//console.log("认证授权失败：" + e.code + " - " + e.message); 
					event_b(false,2);
            	}); 
        	} 	
		}
		
        function shareMessage(s,ex,href,title,content,image,picture) { 
            var msg = { 
                extra: { 
                    scene: ex 
                } 
            }; 
            msg.href = href; 
            msg.title = title; 
            msg.content = content; 
			if(image!=null && image!=""){
				if(image.slice(0, "http".length) == "http"){
					msg.thumbs = [image]; 					
				}else{
					var img = plus.io.convertAbsoluteFileSystem(image.replace("file://", "")); 
					msg.thumbs = [img]; 					
				}
			}
			if(picture!=null && picture!=""){
				if(picture.slice(0, "http".length) == "http"){
					msg.pictures = [picture]; 					
				}else{
					var img = plus.io.convertAbsoluteFileSystem(picture.replace("file://", "")); 
					msg.pictures = [img]; 
				}
			}            
            //console.log(JSON.stringify(msg)); 
            s.send(msg, function() { 
                // "分享成功";
				event_b(true,0);
            }, function(e) {          
                if (e.code == -2) { 
                    //"已取消分享" 
					event_b(false,3);
                } else if (e.code == -3 || e.code == -8) {  
                    //分享失败,可能是图片过大的问题
					event_b(false,4);
                }else{ 
                    //"分享失败"
					event_b(false,5); 
                } 
            }); 
        };
		
		function event_b(result,code){
			if(event2!=null){
				event2(result,code);//触发组件事件
			}
		}	
		
    }