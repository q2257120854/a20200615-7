    function 轮播图(name,event_0){   
        //name表示组件在被创建时的名称，event表示组件拥有的事件
        //如果组件有多个事件，可以在后面继续填写这些事件名称
        //例如：function 轮播图(name,event1,event2,event3){
        
        //组件内部属性，仅供组件内部使用：
        this.名称 = name;
		var sep = this.名称;//定义项目id分割字符
		
		var swiper = this.名称+"swiper";
		var cnt = 0;
		var time = 3000;
        //组件命令：
        this.添加项目_普通 = function (项目图片){
            var div = document.createElement("div");
            div.id = this.名称+"div"+cnt;
		    div.className = "swiper-slide";
		    div.style.cssText = "width:100%;height:140px;background-color:#FFAF60;";
		    document.getElementById(this.名称+'ull').appendChild(div);
			div.onclick=function() { AddChild(this) };
		    var img = document.createElement("img");
		    img.id = this.名称+"img"+cnt;
		    img.src=项目图片;
		    img.style.cssText = "width:100%;height:100%;";
		    document.getElementById(div.id).appendChild(img);
		    cnt ++;
        } 
		this.添加项目_3D流 = function (项目图片,图片宽度,图片高度){
			var div = document.createElement("div");
            div.id = this.名称+"div"+cnt;
		    div.className = "swiper-slide";
		    div.style.cssText = "width:"+图片宽度+";height:"+图片高度+";background-color:#FFAF60;";
		    document.getElementById(this.名称+'ull').appendChild(div);
		    var img = document.createElement("img");
		    img.id = this.名称+"img"+cnt;
		    img.src=项目图片;
		    img.style.cssText = "width:100%;height:100%;";
		    document.getElementById(div.id).appendChild(img);
		    img.onclick=function() { AddChild(this) };
		    cnt ++;
		}
		this.添加项目_视差 = function (标题,信息,描述文本,标题颜色,信息颜色,文本颜色,上边距,左边距){
			var div = document.createElement("div");
            div.id = this.名称+"div"+cnt;
		    div.className = "swiper-slide";
		    div.style.cssText = "width:100%;height:100%;";
		    document.getElementById(this.名称+'ull').appendChild(div);
		    div.onclick=function() { AddChild(this) };
		  
		    var div_title = document.createElement("div");
		    div_title.id = this.名称+"div_title"+cnt;
		    div_title.className = "title";
		    div_title.style.cssText = "color:"+标题颜色+";"+"margin-top:"+上边距+";"+"margin-left:"+左边距+";";
		    div_title.innerHTML = 标题;
		    document.getElementById(div.id).appendChild(div_title);
		    var div_subtitle = document.createElement("div");
		    div_subtitle.id = this.名称+"div_subtitle"+cnt;
		    div_subtitle.className = "subtitle";
		    div_subtitle.style.cssText = "color:"+信息颜色+";"+"margin-left:"+左边距+";"+"margin-top:6px";
		    div_subtitle.innerHTML = 信息;
		    document.getElementById(div.id).appendChild(div_subtitle);
		    var div_text = document.createElement("div");
		    div_text.id = this.名称+"div_text"+cnt;
		    div_text.className = "text";
		    div_text.style.cssText = "color:"+文本颜色+";"+"margin-left:"+左边距+";"+"margin-top:5px";
		    div_text.innerHTML = 描述文本;
		    document.getElementById(div.id).appendChild(div_text);
			cnt ++;
		}
		//div被单击事件代码
	    function AddChild(obj){
		    var idTxt = dson(obj.id,sep);
			function dson(str, separator){
			    if(str==null || separator==null){
				   return null;
			    }
				   return str.split(separator);
			}
	        var newId = Number(idTxt[1].replace(/[^0-9]/ig,""));
			event_0(newId);
		   
	    }
        
		this.置轮播周期 = function (周期){
		    time = 周期;
		}
		
		this.添加完毕_普通 = function (切换方式){
		   if (切换方式==1){
			   //普通滑动切换
			   swiper = new Swiper("#"+this.名称+"swiper-container", {
				  spaceBetween: 30,
				  effect: 'slide',//位移效果
				  centeredSlides: true,
				  autoplay: {
					delay: time,//切换周期
					disableOnInteraction: false,
				  },
				  pagination: {
					el: "#"+this.名称+"swiper-pagination",
					clickable: true,
					renderBullet: function (index, className) {
					  return '<span class="' + className + '">' + (index + 1) + '</span>';
					},
				  },
				});
		    }
			if (切换方式==2){
				//渐变切换
				swiper = new Swiper("#"+this.名称+"swiper-container", {
					spaceBetween: 30,
					effect: 'fade',//渐变效果
					centeredSlides: true,
					autoplay: {
				       delay: time,//切换周期
					   disableOnInteraction: false,
					},
					pagination: {
					   el: "#"+this.名称+"swiper-pagination",
					   clickable: true,
                       renderBullet: function (index, className) {
						  return '<span class="' + className + '">' + (index + 1) + '</span>';
					    },
					},
				});
			}
			if (切换方式==3){
				//3D翻转切换
				swiper = new Swiper("#"+this.名称+"swiper-container", {
					effect: 'flip',//翻转效果
					grabCursor: true,
					autoplay: {
				       delay: time,//切换周期
					   disableOnInteraction: false,
					},
					pagination: {
					   el: "#"+this.名称+"swiper-pagination",
					   clickable: true,
                       renderBullet: function (index, className) {
						  return '<span class="' + className + '">' + (index + 1) + '</span>';
					    },
					},
				});
			}
		   
		}
		this.添加完毕_3D流 = function (){
			swiper = new Swiper("#"+this.名称+"swiper-container", {
			  effect: 'coverflow',//3D图片流
			  grabCursor: true,
			  centeredSlides: true,
			  slidesPerView: 'auto',
			  coverflowEffect: {
				rotate: 50,
				stretch: 0,
				depth: 100,
				modifier: 1,
				slideShadows : true,
			  },
			  autoplay: {
				delay: time,//切换周期
				disableOnInteraction: false,
			  },
			  pagination: {
				el: "#"+this.名称+"swiper-pagination",
				clickable: true,
				renderBullet: function (index, className) {
				   return '<span class="' + className + '">' + (index + 1) + '</span>';
				},
			  },
			  
			});
		}
		this.添加完毕_视差 = function (背景图片,是否显示小圆点){
            if(是否显示小圆点==true){
				document.getElementById(this.名称+"parallax-bg").style.backgroundImage = "url("+背景图片+")";
				swiper = new Swiper("#"+this.名称+"swiper-container", {
				  speed: 600,
				  parallax: true,//视差效果
				  autoplay: {
					delay: time,//切换周期
					disableOnInteraction: false,
				  },
				  pagination: {
					el: "#"+this.名称+"swiper-pagination",
					clickable: true,
					renderBullet: function (index, className) {
					   return '<span class="' + className + '">' + (index + 1) + '</span>';
					},
				  },
				  
				});
			}else {
				document.getElementById(this.名称+"parallax-bg").style.backgroundImage = "url("+背景图片+")";
				swiper = new Swiper("#"+this.名称+"swiper-container", {
				  speed: 600,
				  parallax: true,//视差效果
				  autoplay: {
					delay: time,//切换周期
					disableOnInteraction: false,
				  },
				  
				});
			}
			
		}
		
		//组件命令：
		this.置轮播区尺寸 = function (w,h){
		   document.getElementById(this.名称+"swiper-container").style.width = w;
		   document.getElementById(this.名称+"swiper-container").style.height = h;
		}
		//组件命令：
		this.开始轮播 = function (){
			swiper.autoplay.start();
		}
		//组件命令：
		this.暂停轮播 = function (){
			swiper.autoplay.stop();
		}
		
        //组件命令：
        this.置项目图片 = function (项目索引,项目图片){
           document.getElementById(sep+"img"+项目索引).src = 项目图片;
        } 
		this.取项目图片 = function (项目索引){
           return document.getElementById(sep+"img"+项目索引).src;
        } 
		
        //组件命令：
        this.置可视 = function (value){
            if(value==true){
                document.getElementById(this.名称).style.display="block";//显示	                
            }else{
                document.getElementById(this.名称).style.display="none"; //不占位隐藏               
            }
        } 
        
    }