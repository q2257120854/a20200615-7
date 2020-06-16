
    function 高级列表框(name,haveArrow,haveMsg,lazy,functionName){  
        this.名称 = name;
        this.显示箭头 = haveArrow;
        this.显示信息 = haveMsg;
        this.懒加载 = lazy;
        this.图片宽度 = "";//默认的大图标：42px，小图标：29px，右边距：10px
        this.图片高度 = "";
        
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

        this.置图片尺寸 = function (w,h){
            this.图片宽度 = w;
            this.图片高度 = h;
        }
        
        this.添加项目 = function (img,title,msg,tag){
            var table = document.getElementById(this.名称);
            var li = document.createElement('li');
            var temp = '<div class="mui-media-body">'+title;
            if(this.显示信息==true){
                li.className = 'mui-table-view-cell mui-media';
                temp = temp+'<p class="mui-ellipsis">'+msg+'</p></div>';
            }else{
                li.className = 'mui-table-view-cell mui-media mui-media-icon';
                temp = temp+'</div>';
            }
            li.setAttribute("tag",tag); //设置项目标记
            if(this.懒加载==true){
                if(this.图片宽度!=""){
                    temp = '<img class="mui-pull-left" style="width:'+this.图片宽度+';height:'+this.图片高度+';margin-right:10px" data-lazyload='+img+'>'+temp;
                }else{
                    temp = '<img class="mui-media-object mui-pull-left" data-lazyload='+img+'>'+temp;
                }
            }else{
                if(this.图片宽度!=""){
                    temp = '<img class="mui-pull-left" style="width:'+this.图片宽度+';height:'+this.图片高度+';margin-right:10px" src='+img+'>'+temp;
                }else{
                    temp = '<img class="mui-media-object mui-pull-left" src='+img+'>'+temp;
                }
            }
            if(this.显示箭头==true){
                temp = '<a class="mui-navigate-right">'+temp+'</a>';
            }
            li.innerHTML = temp;
            var index = table.getElementsByTagName("li").length;
            li.index = index;//设置项目索引
            table.appendChild(li);
            return index;
        } 

        this.添加项目2 = function (img,title,msg,tag){
            var table = document.getElementById(this.名称);
            var li = document.createElement('li');
            var temp = '<div class="mui-media-body">'+title;
            if(this.显示信息==true){
                li.className = 'mui-table-view-cell mui-media mui-card';
                temp = temp+'<p class="mui-ellipsis">'+msg+'</p></div>';
            }else{
                li.className = 'mui-table-view-cell mui-media mui-media-icon mui-card';
                temp = temp+'</div>';
            }
            li.setAttribute("tag",tag); //设置项目标记
            if(this.懒加载==true){
                if(this.图片宽度!=""){
                    temp = '<img class="mui-pull-left" style="width:'+this.图片宽度+';height:'+this.图片高度+';margin-right:10px" data-lazyload='+img+'>'+temp;
                }else{
                    temp = '<img class="mui-media-object mui-pull-left" data-lazyload='+img+'>'+temp;
                }                
            }else{
                if(this.图片宽度!=""){
                    temp = '<img class="mui-pull-left" style="width:'+this.图片宽度+';height:'+this.图片高度+';margin-right:10px" src='+img+'>'+temp;
                }else{
                    temp = '<img class="mui-media-object mui-pull-left" src='+img+'>'+temp;
                }                
            }
            if(this.显示箭头==true){
                temp = '<a class="mui-navigate-right">'+temp+'</a>';
            }
            li.innerHTML = temp;
            var index = table.getElementsByTagName("li").length;
            li.index = index;//设置项目索引
            table.appendChild(li);
            return index;
        } 

        this.开始加载 = function (loadingImg){
            (function($) {
                $(document).imageLazyload({
                    placeholder: loadingImg
                });
            })(mui);             
        }
        
        this.删除项目 = function (index){
            /*var table = document.getElementById(this.名称);
            var li = table.childNodes;
            console.log(li.length);
            console.log(li[index].nodeName);
            if(index<li.length){
                table.removeChild(li[index]);
            }*/
            var li = document.getElementById(this.名称).getElementsByTagName("li");
            //console.log(li.length);
            if(index<li.length){
                var table = li[index].parentNode;
                table.removeChild(li[index]);
                var li2 = document.getElementById(this.名称).getElementsByTagName("li");
                for(var i = 0;i < li2.length; i++){
                    li2[i].index=i;//刷新全部项目索引
                }
            }
        }

        this.清空项目 = function (){
            var table = document.getElementById(this.名称);
            while(table.hasChildNodes()){
                table.removeChild(table.firstChild);
            }
        }

        this.置项目图片 = function (index,image){
            var li = document.getElementById(this.名称).getElementsByTagName("li");
            if(li==null){
                return;
            }
            if(li.length<=index){
                return;
            }
            var img = li[index].getElementsByTagName("img")[0];                     
            img.setAttribute("src",image); 
        }
        
        this.取项目图片 = function (index){
            var li = document.getElementById(this.名称).getElementsByTagName("li");
            if(li==null){
                return "";
            }
            if(li.length<=index){
                return "";
            }
            var img = li[index].getElementsByTagName("img")[0]; 
            var image = img.getAttribute("src"); 
            if(image == null){
                image = "";
            }           
            return image;
        }
        
        this.置项目标题 = function (index,title){
            var li = document.getElementById(this.名称).getElementsByTagName("li");
            if(li==null){
                return;
            }
            if(li.length<=index){
                return;
            }         
            var item = li[index].getElementsByTagName("div")[0];
            if(this.显示信息==true){
                var msgHtml = "";
                //var msgObject = item.getElementsByTagName("p");
                var msgObject = item.lastChild;
                item.innerHTML = '<div class="mui-media-body">' + title + '</div>'; 
                item.appendChild(msgObject);
            }else{
                item.innerHTML = '<div class="mui-media-body">' + title + '</div>'; 
            }            
        }
        
        this.取项目标题 = function (index){
            var li = document.getElementById(this.名称).getElementsByTagName("li");
            if(li==null){
                return "";
            }
            if(li.length<=index){
                return "";
            }         
            var item = li[index].getElementsByTagName("div")[0];
            var title = item.innerText;
            title = title.replace(/(^\n*)|(\n*$)/g, ""); //去掉首尾的换行符
            if(this.显示信息==true){
                var msg = "";
                var msgObject = item.getElementsByTagName("p");
                if(msgObject!=null){
                    if(msgObject.length>0){
                        msg = msgObject[0].innerText;
                        msg = msg.replace(/(^\n*)|(\n*$)/g, ""); //去掉首尾的换行符
                        title = title.substr(0,title.length-msg.length);   
                        title = title.replace(/(^\n*)|(\n*$)/g, ""); //去掉首尾的换行符                     
                    }
                }            
            }
            return title;
        }

        this.置项目信息 = function (index,msg){
            if(this.显示信息!=true){
                return;
            }
            var li = document.getElementById(this.名称).getElementsByTagName("li");
            if(li==null){
                return;
            }
            if(li.length<=index){
                return;
            }            
            var item = li[index].getElementsByTagName("div")[0];
            var msgObject = item.getElementsByTagName("p");
            if(msgObject!=null){
                if(msgObject.length>0){
                    msgObject[0].innerHTML = '<p class="mui-ellipsis">' + msg + '</p>'; 
                }
            } 
        }
        
        this.取项目信息 = function (index){
            if(this.显示信息!=true){
                return "";
            }
            var li = document.getElementById(this.名称).getElementsByTagName("li");
            if(li==null){
                return "";
            }
            if(li.length<=index){
                return "";
            }          
            var item = li[index].getElementsByTagName("div")[0];
            var msg = "";
            var msgObject = item.getElementsByTagName("p");
            if(msgObject!=null){
                if(msgObject.length>0){
                    msg = msgObject[0].innerText;
                    msg = msg.replace(/(^\n*)|(\n*$)/g, ""); //去掉首尾的换行符                  
                }
            }            
            return msg;
        }

        this.置项目标记 = function (index,tag){
            var li = document.getElementById(this.名称).getElementsByTagName("li");
            if(li==null){
                return;
            }
            if(li.length<=index){
                return;
            }          
            li[index].setAttribute("tag",tag); 
        }
        
        this.取项目标记 = function (index){
            var li = document.getElementById(this.名称).getElementsByTagName("li");
            if(li==null){
                return "";
            }
            if(li.length<=index){
                return "";
            }          
            return li[index].getAttribute("tag");
        }

        this.置项目角标 = function (index,value){
            var li = document.getElementById(this.名称).getElementsByTagName("li");
            if(li==null){
                return;
            }
            if(li.length<=index){
                return;
            }   
            if(value==0 || value==""){
                var span = li[index].getElementsByClassName("mui-badge")[0];
                if(span!=null){
                    span.parentNode.removeChild(span);
                }
                return;
            }      
            if(this.显示箭头==true){
                var a = li[index].getElementsByTagName("a")[0];
                var span = a.getElementsByClassName("mui-badge")[0];
                if(span!=null){
                    span.innerText=""+value;
                }else{
                    var newBadge = document.createElement("span");
                    newBadge.className="mui-badge mui-badge-danger";
                    newBadge.innerText=""+value;
                    a.appendChild(newBadge);
                }
            }else{
                var span = li[index].getElementsByClassName("mui-badge")[0];
                if(span!=null){
                    span.innerText=""+value;
                }else{
                    var newBadge = document.createElement("span");
                    newBadge.className="mui-badge mui-badge-danger";
                    newBadge.innerText=""+value;
                    li[index].appendChild(newBadge);
                }
            }            
        }

        this.取项目角标 = function (index){
            var li = document.getElementById(this.名称).getElementsByTagName("li");
            if(li==null){
                return;
            }
            if(li.length<=index){
                return;
            }         
            if(this.显示箭头==true){
                var a = li[index].getElementsByTagName("a")[0];
                var span = a.getElementsByClassName("mui-badge")[0];
                if(span!=null){
                    var a = Number(span.innerText);
                    if(isNaN(a)){
                        return span.innerText;
                    }else{
                        return a;
                    }
                }else{
                    return 0;
                }
            }else{
                var span = li[index].getElementsByClassName("mui-badge")[0];
                if(span!=null){
                    var a = Number(span.innerText);
                    if(isNaN(a)){
                        return span.innerText;
                    }else{
                        return a;
                    }                
                }else{
                    return 0;
                }
            }            
        }

        this.取项目总数 = function (){
            return document.getElementById(this.名称).getElementsByTagName("li").length;
        }

        this.置背景颜色 = function (r,g,b,a){
			var div = document.getElementById(this.名称);	
			div.style.setProperty("background-color", "rgba(" + r + "," + g + "," + b + "," + a + ")");			
		}

        this.置标题颜色 = function (value){
			var div = document.getElementById(this.名称);	
			div.style.setProperty("color", value);			
		}
        
        this.置分割线颜色 = function (value){
            var styleElement = document.createElement('style');
            styleElement.type = 'text/css';
            document.getElementsByTagName('head')[0].appendChild(styleElement);
            styleElement.appendChild(document.createTextNode("#"+this.名称+" .mui-media-body:after{background-color: "+value+" !important;}")); 
            styleElement.appendChild(document.createTextNode("#"+this.名称+" .mui-media:after{background-color: "+value+" !important;}")); 
		}        

        this.置箭头颜色 = function (value){
            var styleElement = document.createElement('style');
            styleElement.type = 'text/css';
            document.getElementsByTagName('head')[0].appendChild(styleElement);
            styleElement.appendChild(document.createTextNode("#"+this.名称+" a.mui-navigate-right:after{color: "+value+" !important;}")); 
		}  

        if(functionName!=null){
            mui('#'+this.名称).on('tap', 'li', function() {
                var item = this.getElementsByTagName("div")[0];
                var title = item.innerText;
                title = title.replace(/(^\n*)|(\n*$)/g, ""); //去掉首尾的换行符
                var msg = "";
                var msgObject = this.getElementsByTagName("p");
                if(msgObject!=null){
                    if(msgObject.length>0){
                        msg = msgObject[0].innerText;
                        msg = msg.replace(/(^\n*)|(\n*$)/g, ""); //去掉首尾的换行符
                        title = title.substr(0,title.length-msg.length);   
                        title = title.replace(/(^\n*)|(\n*$)/g, ""); //去掉首尾的换行符                     
                    }
                }
                var img = this.getElementsByTagName("img")[0];
                var image = img.getAttribute("src");
                functionName(Number(this.index),image,title,msg,this.getAttribute("tag"));//表项被单击事件，返回项目索引、项目图片、项目标题、项目信息、项目标记
            });       	
        }
    }  


 