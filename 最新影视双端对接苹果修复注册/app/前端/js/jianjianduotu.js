    function 渐渐多图列表框(name,event,event2){   
        //name表示组件在被创建时的名称，event表示组件拥有的事件
        //如果组件有多个事件，可以在后面继续填写这些事件名称
        //例如：function 渐渐多图列表框(name,event1,event2,event3){
        
        //组件内部属性，仅供组件内部使用：
        this.名称 = name;
        this.项目总数 = 0;
        //组件命令：
        this.置标题 = function (newTitle){
            document.getElementById(this.名称).innerHTML=newTitle;
        } 
        
        //组件命令：
        this.取标题 = function (){
           return document.getElementById(this.名称).innerHTML;
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

		this.添加项目 = function (头像,昵称,内容,时间,位置,图片,图片1,图片2,图片3,图片4,图片5,图片6,图片7,图片8){
				var div = document.createElement("div");//创建一个卡片节点
				div.className = "duotuliebiaokuang";//设置类名
				div.setAttribute("index",""+this.项目总数);//设置项目索引
				div.setAttribute("tag",头像);//设置项目标记
				div.setAttribute("tag0",昵称);//设置项目标记
				div.setAttribute("tag1",内容);//设置项目标记
				div.setAttribute("tag2",时间);//设置项目标记
				div.setAttribute("tag3",位置);//设置项目标记
				var 图片代码 = "";
				if(图片 != ""){
               		图片代码 =	 "<div class=\"my-gallery\">\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片+"\" index=\"1\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
                	"	</div>"
					div.setAttribute("images",图片);//设置项目标记
				}
				if(图片1 != ""){
               		图片代码 =	 "<div class=\"my-gallery\">\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片+"\" inde=\""+this.项目总数+"\" index=\"1\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片1+"\" inde=\""+this.项目总数+"\" index=\"2\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片1+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
                	"	</div>"
					div.setAttribute("images",图片);//设置项目标记
					div.setAttribute("images1",图片1);//设置项目标记
				}
				if(图片2 != ""){
               		图片代码 =	 "<div class=\"my-gallery\">\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片+"\" inde=\""+this.项目总数+"\" index=\"1\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片1+"\" inde=\""+this.项目总数+"\" index=\"2\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片1+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片2+"\" inde=\""+this.项目总数+"\" index=\"3\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片2+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
                	"	</div>"
					div.setAttribute("images",图片);//设置项目标记
					div.setAttribute("images1",图片1);//设置项目标记
					div.setAttribute("images2",图片2);//设置项目标记
				}
				if(图片3 != ""){
               		图片代码 =	 "<div class=\"my-gallery\">\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片+"\" inde=\""+this.项目总数+"\" index=\"1\"  data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片1+"\" inde=\""+this.项目总数+"\" index=\"2\"  data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片1+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片2+"\" inde=\""+this.项目总数+"\" index=\"3\"  data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片2+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片3+"\" inde=\""+this.项目总数+"\" index=\"4\"  data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片3+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
                	"	</div>"
					div.setAttribute("images",图片);//设置项目标记
					div.setAttribute("images1",图片1);//设置项目标记
					div.setAttribute("images2",图片2);//设置项目标记
					div.setAttribute("images3",图片3);//设置项目标记
				}
				if(图片4 != ""){
               		图片代码 =	 "<div class=\"my-gallery\">\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片+"\" inde=\""+this.项目总数+"\" index=\"1\"  data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片1+"\" inde=\""+this.项目总数+"\" index=\"2\"  data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片1+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片2+"\" inde=\""+this.项目总数+"\" index=\"3\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片2+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片3+"\" inde=\""+this.项目总数+"\" index=\"4\"  data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片3+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片4+"\" inde=\""+this.项目总数+"\" index=\"5\"  data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片4+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
                	"	</div>"
					div.setAttribute("images",图片);//设置项目标记
					div.setAttribute("images1",图片1);//设置项目标记
					div.setAttribute("images2",图片2);//设置项目标记
					div.setAttribute("images3",图片3);//设置项目标记
					div.setAttribute("images4",图片4);//设置项目标记
				}
				if(图片5 != ""){
               		图片代码 =	 "<div class=\"my-gallery\">\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片+"\" inde=\""+this.项目总数+"\" index=\"1\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片1+"\" inde=\""+this.项目总数+"\" index=\"2\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片1+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片2+"\" inde=\""+this.项目总数+"\" index=\"3\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片2+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片3+"\" inde=\""+this.项目总数+"\" index=\"4\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片3+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片4+"\" inde=\""+this.项目总数+"\" index=\"5\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片4+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片5+"\" inde=\""+this.项目总数+"\" index=\"6\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片5+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
                	"	</div>"
					div.setAttribute("images",图片);//设置项目标记
					div.setAttribute("images1",图片1);//设置项目标记
					div.setAttribute("images2",图片2);//设置项目标记
					div.setAttribute("images3",图片3);//设置项目标记
					div.setAttribute("images4",图片4);//设置项目标记
					div.setAttribute("images5",图片5);//设置项目标记
				}
				if(图片6 != ""){
               		图片代码 =	 "<div class=\"my-gallery\">\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片+"\" inde=\""+this.项目总数+"\" index=\"1\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片1+"\" inde=\""+this.项目总数+"\" index=\"2\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片1+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片2+"\" inde=\""+this.项目总数+"\" index=\"3\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片2+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片3+"\" inde=\""+this.项目总数+"\" index=\"4\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片3+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片4+"\" inde=\""+this.项目总数+"\" index=\"5\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片4+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片5+"\" inde=\""+this.项目总数+"\" index=\"6\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片5+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片6+"\" inde=\""+this.项目总数+"\" index=\"7\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片6+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
                	"	</div>"
					div.setAttribute("images",图片);//设置项目标记
					div.setAttribute("images1",图片1);//设置项目标记
					div.setAttribute("images2",图片2);//设置项目标记
					div.setAttribute("images3",图片3);//设置项目标记
					div.setAttribute("images4",图片4);//设置项目标记
					div.setAttribute("images5",图片5);//设置项目标记
					div.setAttribute("images6",图片6);//设置项目标记
				}
				if(图片7 != ""){
               		图片代码 =	 "<div class=\"my-gallery\">\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片+"\" inde=\""+this.项目总数+"\" index=\"1\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片1+"\" inde=\""+this.项目总数+"\" index=\"2\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片1+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片2+"\" inde=\""+this.项目总数+"\" index=\"3\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片2+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片3+"\" inde=\""+this.项目总数+"\" index=\"4\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片3+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片4+"\" inde=\""+this.项目总数+"\" index=\"5\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片4+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片5+"\" inde=\""+this.项目总数+"\" index=\"6\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片5+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片6+"\" inde=\""+this.项目总数+"\" index=\"7\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片6+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片7+"\" inde=\""+this.项目总数+"\" index=\"8\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片7+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
                	"	</div>"
					div.setAttribute("images",图片);//设置项目标记
					div.setAttribute("images1",图片1);//设置项目标记
					div.setAttribute("images2",图片2);//设置项目标记
					div.setAttribute("images3",图片3);//设置项目标记
					div.setAttribute("images4",图片4);//设置项目标记
					div.setAttribute("images5",图片5);//设置项目标记
					div.setAttribute("images6",图片6);//设置项目标记
					div.setAttribute("images7",图片7);//设置项目标记
				}
				if(图片8 != ""){
               		图片代码 =	 "<div class=\"my-gallery\">\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片+"\" inde=\""+this.项目总数+"\" index=\"1\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片1+"\" inde=\""+this.项目总数+"\" index=\"2\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片1+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片2+"\" inde=\""+this.项目总数+"\" index=\"3\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片2+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片3+"\" inde=\""+this.项目总数+"\" index=\"4\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片3+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片4+"\" inde=\""+this.项目总数+"\" index=\"5\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片4+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片5+"\" inde=\""+this.项目总数+"\" index=\"6\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片5+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片6+"\" inde=\""+this.项目总数+"\" index=\"7\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片6+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片7+"\" inde=\""+this.项目总数+"\" index=\"8\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片7+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
               		"    	<figure>\n"+
					"              <a href=\""+图片8+"\" inde=\""+this.项目总数+"\" index=\"9\" data-size=\"800x1142\">\n"+
                	"     	       <img src=\""+图片8+"\" />\n"+
					"              </a>\n"+
                	"    	</figure>\n"+
                	"	</div>"
					div.setAttribute("images",图片);//设置项目标记
					div.setAttribute("images1",图片1);//设置项目标记
					div.setAttribute("images2",图片2);//设置项目标记
					div.setAttribute("images3",图片3);//设置项目标记
					div.setAttribute("images4",图片4);//设置项目标记
					div.setAttribute("images5",图片5);//设置项目标记
					div.setAttribute("images6",图片6);//设置项目标记
					div.setAttribute("images7",图片7);//设置项目标记
					div.setAttribute("images8",图片8);//设置项目标记
				}
				div.innerHTML = "	<div class=\"container\" index=\""+this.项目总数+"\">\n"+
				"    	<!--用户头像-->\n"+
				"		<div class=\"header\">\n"+
				"			<div><img src=\""+头像+"\" /></div>\n"+
				"		</div>\n"+
				"		<div class=\"right_con\">\n"+
				"			<div class=\"demo\">\n"+
				"            	<!--用户名and发布时间-->\n"+
				"            	<div class=\"use\">\n"+
				"                	<div class=\"usename\"><span>"+昵称+"</span><em class=\"pub-time\">"+时间+"</em></div>\n"+
				"                </div>\n"+
				"                <!--分享的内容-->\n"+
				"                <p class=\"fx_content\">"+内容+"</p>\n"+
				"                <!--分享的图片-->\n"+
				图片代码+
				"                <!--显示的位置-->\n"+
				"                <div class=\"fx_address\">"+位置+"</div>\n"+
				"            </div>\n"+
				"		</div>\n"+
				"	</div>"
				this.项目总数 = this.项目总数+1;
           	 	var root = document.getElementById(this.名称);
				root.appendChild(div);//将卡片节点添加到卡片列表根节点
				return this.项目总数;
			//return mycars[3];
		}
		
		this.清空项目 = function(){
			var root = document.getElementById(this.名称);
		    while(root.hasChildNodes()){
				root.removeChild(root.firstChild);
			}
		}
		this.取项目内容 = function(index){
			var card = document.getElementById(this.名称).getElementsByClassName("duotuliebiaokuang");
			if(card.length>index){
				return card[index].getAttribute("tag1");
			}else{
				return "";
			}
		}
		
		this.取项目头像 = function(index){
			var card = document.getElementById(this.名称).getElementsByClassName("duotuliebiaokuang");
			if(card.length>index){
				return card[index].getAttribute("tag");
			}else{
				return "";
			}
		}
		
		this.取项目昵称 = function(index){
			var card = document.getElementById(this.名称).getElementsByClassName("duotuliebiaokuang");
			if(card.length>index){
				return card[index].getAttribute("tag0");
			}else{
				return "";
			}
		}
		
		this.取项目时间 = function(index){
			var card = document.getElementById(this.名称).getElementsByClassName("duotuliebiaokuang");
			if(card.length>index){
				return card[index].getAttribute("tag2");
			}else{
				return "";
			}
		}
		
		this.取项目位置 = function(index){
			var card = document.getElementById(this.名称).getElementsByClassName("duotuliebiaokuang");
			if(card.length>index){
				return card[index].getAttribute("tag3");
			}else{
				return "";
			}
		}
		
		this.取项目图片 = function(index){
			var card = document.getElementById(this.名称).getElementsByClassName("duotuliebiaokuang");
			if(card.length>index){
				return card[index].getAttribute("images");
			}else{
				return "";
			}
		}
		
        //组件事件
        if(event!=null){
 			document.getElementById(this.名称).addEventListener("tap", function () {
                event();//触发组件的相关事件，这里演示的是被单击事件
            });
        }
		
		if(event2!=null){
			//mui("#"+组件ID).on(事件名称, 标签名称或类名称, function() {
 			mui("#"+this.名称).on("tap", "a", function() {
				var index1 = this.getAttribute("inde");
				var index2 = this.getAttribute("index");
                event2(Number(index1),Number(index2));//触发组件的相关事件，这里的是"项目图片被单击"事件
            });
		}
    }