    function 轮奸图(name,event){   
        //name表示组件在被创建时的名称，event表示组件拥有的事件
        //如果组件有多个事件，可以在后面继续填写这些事件名称
        //例如：function 轮奸图(name,event1,event2,event3){
        
        //组件内部属性，仅供组件内部使用：
        this.名称 = name;
		var i = 0;
		var leng;
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
                div.style.display="";//显示，也可以设置为block	                
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
		
		//组件命令
		this.添加轮播图 = function (图片,标记){
		var tab = document.getElementById(this.名称);
		tab.style= "background: url("+图片+") no-repeat center top/100% auto"		
		var table = tab.getElementsByClassName("swiper-wrapper")[0];
		var div = document.createElement("div");
		leng = i;
		if (i==0){
		   div.className = "swiper-slide swiper-slide-center none-effect";
		}else{
		   div.className = "swiper-slide";
		}
		div.innerHTML = "<a href='#'><img index='"+leng+"' tag='"+标记+"' src='"+图片+"' ></a></div>";      			
	    table.appendChild(div);	
		i++;	
		}	
		
		//自定义程序
		var swiper;
		function cse(){
		swiper = new Swiper(".swiper-container",{
		autoplay:3000,   
		speed:1000,
		autoplayDisableOnInteraction : false,
		loop:true,
		centeredSlides : true,
		slidesPerView:2,
        pagination : ".swiper-pagination",
		paginationClickable:true,
		prevButton:".swiper-button-prev",
        nextButton:".swiper-button-next",
		onInit:function(swiper){
			swiper.slides[2].className="swiper-slide swiper-slide-active";
			},
        breakpoints: { 
                200: {
                    slidesPerView: 1,
                 }
            }
		});
		}	
		
		this.添加完毕 = function(tit){
		    //var id1 = document.getElementById(this.名称).getElementsByClassName("swiper-wrapper")[0].getElmentsByClassName("swiper-slide").length;
			if(leng != 0){
				cse();
			}
		}	       				
		
		this.清空项目 = function(){
			document.getElementById(this.名称).getElementsByClassName("swiper-wrapper")[0].innerHTML = "";
			i = 0;
			leng = 0;
			swiper.init();
		}
		
        //组件事件
        if(event!=null){
		mui("#"+this.名称).on("tap",".swiper-slide",function (){
		var img = this.getElementsByTagName("img")[0].getAttribute("src");
		var index = this.getElementsByTagName("img")[0].getAttribute("index");
		var tag = this.getElementsByTagName("img")[0].getAttribute("tag");
		console.log(index);
		console.log(img);
		console.log(tag);
		event(Number(index),img,tag);		
            });       	
        }
    }