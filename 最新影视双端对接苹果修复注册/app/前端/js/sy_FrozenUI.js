//by 授渔-更新于 20170626 19:24
//除触发部分调用了mui选择器,其余大部分均由原生js编写
添加css("js/frozenui-1.3.0/css/frozen.css");
添加js("js/frozenui-1.3.0/lib/zepto.min.js",function(){}); 
添加js("js/frozenui-1.3.0/js/frozen.js",function(){});
//引入头部
function sy_FrozenUI(name,event){   
this.名称=name;

this.调试_动态代码= function (代码){
eval(代码);
}

this.getClass= function (calss属性) 
	{ 
	    /*by 获取指定元素属性的代码
        var div=document.getElementById(this.名称);
        var tags=div.getElementsByTagName("*");
        var tagArr=[]; 
        for(var i=0;i < tags.length; i++) 
		{ 
		if(tags[i].className==calss属性)
		{
		if(tags[i].attributes[属性].value==属性)
		{ 
		tagArr[tagArr.length]=tags[i];
		} 
		}
		return tagArr; 
		*/	
		//by 获取class属性的代码
        var tags=document.getElementById(this.名称).getElementsByTagName("*");
        var tagArr=[]; 
        for(var i=0;i < tags.length; i++) 
		{ 
		if(tags[i].className==calss属性)
		{
		tagArr[tagArr.length]=tags[i];
		}
		}
		return tagArr; 	
	}

this.弹出提示=function (提示内容,显示时间){
            el=$.tips({
            content:提示内容,
            stayTime:显示时间,
            type:"success"
            })	
        }
		
this.列表框_置右属性=function (index,内容){
        var p=document.getElementById(this.名称).getElementsByTagName("ul")[0].getElementsByTagName("li");
	    var pp=p[index].childNodes[1].childNodes[1];
		if(pp.className=="ui-txt-info" || pp.className=="ui-badge-num"){
		pp.innerHTML=内容;
		}else if(pp.className=="ui-switch"){
		pp.firstChild.checked=内容;
		  }
		return;
        }	

this.列表框_置图片=function (index,图片){
        var p=document.getElementById(this.名称).getElementsByTagName("ul")[0].getElementsByTagName("li");
	    var str=p[index].childNodes[0].firstChild.style.backgroundImage="url("+图片+")";
        }
		
this.列表框_置左标题=function (index,标题){
        var p=document.getElementById(this.名称).getElementsByTagName("ul")[0].getElementsByTagName("li");
		return p[index].childNodes[1].childNodes[0].innerHTML=标题;
        }	

this.列表框_取右属性=function (index){
        var p=document.getElementById(this.名称).getElementsByTagName("ul")[0].getElementsByTagName("li");
	    var pp=p[index].childNodes[1].childNodes[1];
		if(pp.className=="ui-txt-info" || pp.className=="ui-badge-num"){
		return pp.innerHTML;
		}else if(pp.className=="ui-switch"){
		return pp.firstChild.checked;
		  }
		return;
        }	

this.列表框_取左标题=function (index){
        var p=document.getElementById(this.名称).getElementsByTagName("ul")[0].getElementsByTagName("li");
		return p[index].childNodes[1].childNodes[0].innerHTML;
        }	
				
this.列表框_取图片=function (index){
        var p=document.getElementById(this.名称).getElementsByTagName("ul")[0].getElementsByTagName("li");
	    var str=p[index].childNodes[0].firstChild.style.backgroundImage;
		return str.slice(5,str.length-2);
        }
	
this.列表框_删除消息=function (index){
            删除内容(this.名称,"ui-border-t",index,"li");
        }
		
this.列表框_取总数=function (){
        var p=document.getElementById(this.名称).getElementsByTagName("ul")[0].getElementsByTagName("li");
		return p.length;
        }

this.列表框_添加=function (样式,图片,左标题,右标题,取消箭头){
        if(取消箭头==true){
		var ulclass="ui-list ui-list-one ui-border-tb ui-list-active ui-list-cover";
		}else{
		var ulclass="ui-list ui-list-one ui-border-tb ui-list-active ui-list-cover ui-list-link";
		   }
		var 代码="<li class='ui-border-t'>";
		代码+="<div class='ui-list-thumb'>";
		代码+="<span style='background-image:url("+图片+")'></span>";
		代码+="</div>";
		代码+="<div class='ui-list-info'>";
		代码+="<h4 class='ui-nowrap'>"+左标题+"</h4>";
		switch (样式){
		case 1:
		代码+="<div class='ui-txt-info'>"+右标题+"</div>";
		break;
		case 2:
		代码+="<div class='ui-badge-num'>"+右标题+"</div>";
		break;
		case 3:
		代码+="<div class='ui-reddot ui-reddot-static'></div>";
		break;
		case 4:
		代码+="<label class='ui-switch'><input type='checkbox'></label>";
		break;
		default:
		代码+="<div class='ui-txt-info'>"+右标题+"</div>";
		break;
		    }
		代码+="</div></li>";			   
		   
		var div = document.getElementById(this.名称);
		var p=document.getElementById(this.名称).getElementsByTagName("ul");
		if(p.length<=0){
		var p = document.createElement("ul");
		p.setAttribute("class",ulclass);
		div.appendChild(p);	
		var p=document.getElementById(this.名称).getElementsByTagName("ul");
		var index=p[0].getElementsByTagName("li").length;
		p[0].innerHTML =代码;
		var p = document.getElementById(this.名称).getElementsByTagName("ul");
		div1=p[0].getElementsByTagName("li");
		div1[index].index=index;
        return div1[index].index;
		}else{
		var p=document.getElementById(this.名称).getElementsByTagName("ul");
		index=p[0].getElementsByTagName("li").length;
		p[0].innerHTML =p[0].innerHTML+代码;
		var p=document.getElementById(this.名称).getElementsByTagName("ul");
		div1=p[0].getElementsByTagName("li");
		div1[index].index=index;	
		var div = document.getElementById(this.名称).getElementsByTagName("li");
		for (var x=0;x< div.length;x++){
		div[x].index=x;
		}
		return div1[index].index;	
		   }	
        }



this.徽标_置徽标内容=function (index,内容){
            var tags = document.getElementById(this.名称).getElementsByTagName("div");
            if(index<=tags.length){
            for(var i=0;i < tags.length; i++) 
              { 
            if(tags[i].index==index && tags[i].className=="ui-badge-wrap")
              {
              var s=tags[i].getElementsByTagName("div")[0];
			  s.innerHTML=内容;
              }
              }
			}
        }

this.徽标_置红点内容=function (index,内容){
            var tags = document.getElementById(this.名称).getElementsByTagName("div");
            if(index<=tags.length){
            for(var i=0;i < tags.length; i++) 
              { 
            if(tags[i].index==index && tags[i].className=="ui-badge-wrap")
              {
              var s=tags[i].getElementsByTagName("div")[1];
			  s.innerHTML=内容;
              }
              }
			}
        }


this.徽标_取徽标内容=function (index){
            var tags = document.getElementById(this.名称).getElementsByTagName("div");
            if(index<=tags.length){
            for(var i=0;i < tags.length; i++) 
              { 
            if(tags[i].index==index && tags[i].className=="ui-badge-wrap")
              {
              var s=tags[i].getElementsByTagName("div")[0];
			  return s.innerHTML;
              }
              }
			}
        }

this.徽标_取红点内容=function (index){
            var tags = document.getElementById(this.名称).getElementsByTagName("div");
            if(index<=tags.length){
            for(var i=0;i < tags.length; i++) 
              { 
            if(tags[i].index==index && tags[i].className=="ui-badge-wrap")
              {
              var s=tags[i].getElementsByTagName("div")[1];
			  return s.innerHTML;
              }
              }
			}
        }

this.徽标_添加=function (徽标内容,红点内容){

		var div = document.getElementById(this.名称);
		var p = document.createElement("div");
		p.setAttribute("class","ui-badge-wrap");
		p.setAttribute("style","width:100px;line-height:50px");
		var 代码="<div>"+徽标内容+"</div><div class='ui-badge-corner'>"+红点内容+"</div>";
		var index=this.getClass("ui-badge-wrap");
		p.innerHTML =代码;
		p.index=index.length;
        div.appendChild(p);	
        return p.index;	

        }
		
		
		
		
this.通知_添加=function (提示内容,按钮名称){

		var div = document.getElementById(this.名称);
		var p = document.createElement("section");
		p.setAttribute("class","ui-notice");
		var 代码="<i></i><p>"+提示内容+"</p><div class='ui-notice-btn'>";
		代码+="<button class='ui-btn-primary ui-btn-lg'>"+按钮名称+"</button></div>";
		var index=this.getClass("ui-notice");
		if(index.length>0){
	    p.innerHTML ="<div class='ui-tips ui-tips-warn'><i></i><span>一个页面只能添加一个搜索框</span></div>";
		div.appendChild(p);
		return;
		}else{
		p.innerHTML =代码;
		p.index=index.length;
        div.appendChild(p);	
        return p.index;		
		  }
        }


this.搜索框_置内容=function (内容){

		var tags=document.getElementById(this.名称).getElementsByTagName("div");
		for(var i=0;i < tags.length; i++){ 
		if(tags[i].className=="ui-searchbar-wrap ui-border-b focus")
		{
		tags[i].childNodes[0].childNodes[2].firstChild.value=内容;
		tags[i].childNodes[0].childNodes[1].innerHTML="<p class='ui-txt-highlight'>"+内容+"</p>";
		
		}else if(tags[i].className=="ui-searchbar-wrap ui-border-b"){
		tags[i].childNodes[0].childNodes[2].firstChild.value=内容;
		tags[i].childNodes[0].childNodes[1].innerHTML="<p class='ui-txt-highlight'>"+内容+"</p>";
		      }
		   }
        }
		
this.搜索框_取内容=function (){
  
		var tags=document.getElementById(this.名称).getElementsByTagName("div");
		for(var i=0;i < tags.length; i++){ 
		if(tags[i].className=="ui-searchbar-wrap ui-border-b focus")
		{
		return tags[i].childNodes[0].childNodes[2].firstChild.value;
		}else if(tags[i].className=="ui-searchbar-wrap ui-border-b"){
		//return tags[i].childNodes[0].childNodes[1].innerHTML;
		return tags[i].childNodes[0].childNodes[2].firstChild.value;
		      }
		   }
        }

this.搜索框_添加=function (提示内容){
		var div = document.getElementById(this.名称);
		var p = document.createElement("div");
		p.setAttribute("class","ui-searchbar-wrap ui-border-b");
		var 代码="<div class='ui-searchbar ui-border-radius'>";
		代码+="<i class='ui-icon-search'></i>";
		代码+="<div class='ui-searchbar-text'>"+提示内容+"</div>";
		代码+="<div class='ui-searchbar-input'><input style='height:30px' value='' type='tel' placeholder='"+提示内容+"' autocapitalize='off'></div>";
		代码+="<i class='ui-icon-close'></i></div><button class='ui-btn ui-btn-danger'>搜索</button>";
		var index=this.getClass("ui-searchbar-wrap ui-border-b");
		var index1=this.getClass("ui-searchbar-wrap ui-border-b focus");
		if(index.length>0 || index1.length >0){
	    p.innerHTML ="<div class='ui-tips ui-tips-warn'><i></i><span>一个页面只能添加一个搜索框</span></div>";
		div.appendChild(p);
		return;
		}else{
		p.innerHTML =代码;
		p.index=index.length;
        div.appendChild(p);
		//Frozen框架触发头部
		$('.ui-searchbar').tap(function(){
        $('.ui-searchbar-wrap').addClass('focus');
        $('.ui-searchbar-input input').focus();
        });
		//Frozen框架触发尾部	
        return p.index;		
		  }
        }

this.工具条_删除提示=function (index){
		删除内容(this.名称,"ui-tooltips ui-tooltips-warn",index,"div");
        }

this.工具条_置提示内容 = function (index,提示内容){
            var tags = document.getElementById(this.名称).getElementsByTagName("div");
            if(index<=tags.length){
            for(var i=0;i < tags.length; i++) 
              { 
            if(tags[i].index==index && tags[i].className=="ui-tooltips ui-tooltips-warn")
              {
              var s=tags[i].getElementsByTagName("div")[0];
			  if(s.className=="ui-tooltips-cnt ui-border-b"){
			  s.innerHTML="<i></i>"+提示内容+"<a class='ui-icon-close'></a>";
			  }else{
			  s.innerHTML="<i></i>"+提示内容;
			  }
              }
              }
			}
        }

				
this.工具条_新提示=function (提示内容,提示样式,背景颜色,字体颜色){
		
		if(背景颜色==undefined){背景颜色=="#FFF2BA"}
		if(字体颜色==undefined){字体颜色=="#000"}
        var div = document.getElementById(this.名称);
		var p = document.createElement("div");
		p.setAttribute("class","ui-tooltips ui-tooltips-warn");
		if(提示样式==1){
		代码="<div class='ui-tooltips-cnt ui-border-b' style='background:"+背景颜色+";color:"+字体颜色+"'>";
	    代码+="<i></i>"+提示内容+"<a class='ui-icon-close'></a></div>";
		}else{
		代码="<div class='ui-tooltips-cnt ui-tooltips-cnt-link ui-border-b'>";
	    代码+="<i></i>"+提示内容+"</div>";		
		}
        p.innerHTML =代码;
		var index=this.getClass("ui-tooltips ui-tooltips-warn");
		p.index=index.length;
        div.appendChild(p);
        return p.index;
        }
	
this.新消息_删除消息=function (index){
            删除内容(this.名称,"ui-newstips-wrap",index,"div");
        }

this.新消息_清空消息 = function (){
            var table = document.getElementById(this.名称);
            while(table.hasChildNodes()){
                table.removeChild(table.firstChild);
            }
        }

this.新消息_取消息总数 = function (){
            var s=this.getClass("ui-newstips-wrap");
            return s.length;
        }

this.新消息_取消息内容 = function (index){
            var tags = document.getElementById(this.名称).getElementsByTagName("div");
            if(index<=tags.length){
            for(var i=0;i < tags.length; i++) 
              { 
            if(tags[i].index==index && tags[i].className=="ui-newstips-wrap")
              {
              var s=tags[i].getElementsByTagName("div")[1];
			  return s.innerHTML;
              }
              }
			}
        }
		
this.新消息_取消息角标 = function (index){
            var tags = document.getElementById(this.名称).getElementsByTagName("div");
            if(index<=tags.length){
            for(var i=0;i < tags.length; i++) 
              { 
            if(tags[i].index==index && tags[i].className=="ui-newstips-wrap")
              {
              var s=tags[i].getElementsByTagName("span")[2];
			  return s.innerHTML;
              }
              }
			}
        }
		
this.新消息_置消息内容 = function (index,消息内容){
            var tags = document.getElementById(this.名称).getElementsByTagName("div");
            if(index<=tags.length){
            for(var i=0;i < tags.length; i++) 
              { 
            if(tags[i].index==index && tags[i].className=="ui-newstips-wrap")
              {
              var s=tags[i].getElementsByTagName("div")[1];
			  s.innerHTML=消息内容;
              }
              }
			}
        }
		
this.新消息_置消息角标 = function (index,角标){
            var tags = document.getElementById(this.名称).getElementsByTagName("div");
            if(index<=tags.length){
            for(var i=0;i < tags.length; i++) 
              { 
            if(tags[i].index==index && tags[i].className=="ui-newstips-wrap")
              {
              var s=tags[i].getElementsByTagName("span")[2];
			  if(角标==undefined){
			  s.innerHTML="0";
			  }else{
			  s.innerHTML=角标;
			  }
              }
              }
			}
        }

this.新消息_开启角标 = function (index,角标){
            var tags = document.getElementById(this.名称).getElementsByTagName("div");
            if(index<=tags.length){
            for(var i=0;i < tags.length; i++) 
              { 
            if(tags[i].index==index && tags[i].className=="ui-newstips-wrap")
              {
              var s=tags[i].getElementsByTagName("span")[2];
			  s.className="ui-badge-num";
			  if(角标==undefined){
			  s.innerHTML="0";
			  }else{
			  s.innerHTML=角标;
			  }
              }
              }
			}
        }
		
this.新消息_关闭角标 = function (index){
            var tags = document.getElementById(this.名称).getElementsByTagName("div");
            if(index<=tags.length){
            for(var i=0;i < tags.length; i++) 
              { 
            if(tags[i].index==index && tags[i].className=="ui-newstips-wrap")
              {
              var s=tags[i].getElementsByTagName("span")[2];
			  s.className="ui-reddot ui-reddot-static";
			  s.innerHTML="";
              }
              }
			}
        }
		
this.新消息_添加新消息=function (图片地址,新消息,角标数字){

		//http://placeholder.qiniudn.com/60x60
        var div = document.getElementById(this.名称);
		var p = document.createElement("div");
		p.setAttribute("class","ui-newstips-wrap");
		
		代码="<div class='ui-newstips'>";
	    代码+="<span class='ui-avatar-tiled'>";
		代码+="<span style='background-image:url("+图片地址+")'></span></span>";
		代码+="<div>"+新消息+"</div>";
		if(角标数字>0){代码+="<span class='ui-badge-num'>"+角标数字+"</span>";}else{代码+="<span class='ui-reddot ui-reddot-static'></span>";
		}
		代码+="</div>";
        p.innerHTML =代码;
		var index=this.getClass("ui-newstips-wrap");
		p.index=index.length;
        div.appendChild(p);
        return p.index;

		/*
        var div = document.getElementById(this.名称);
		p = document.createElement("ul");
		p.setAttribute("class","ui-grid-halve");
		代码="<li><div class='ui-grid-halve-img ui-tag-svip'><span style='background-image:url(http://placeholder.qiniudn.com/290x160)'></span></div></li>";
		代码+="<li><div class='ui-grid-halve-img'><span style='background-image:url(http://placeholder.qiniudn.com/290x160)' class='ui-tag-pop-hot'></span></div></li></ul>";
		代码+="<p class='ui-tag-wrap'>"+新消息+"<i class='ui-tag-vip'></i></p>";

        p.innerHTML =代码;
        div.appendChild(p);
      */
        }

        if(event!=null){

		mui("#"+this.名称).on("tap", "*", function() {
		//新消息

		if(this.className=="ui-newstips-wrap"){
        var index = Number(this.index);  
		event("新消息",index); 
		return;
		}
		//工具条提示
		
		if(this.className=="ui-icon-close" && this.parentNode.parentNode.className=="ui-tooltips ui-tooltips-warn"){//这里加一个获取父节点class,以免出错
		删除内容(name,"ui-tooltips ui-tooltips-warn",this.parentNode.parentNode.index,"div");
		return;
		}else if(this.className=="ui-tooltips ui-tooltips-warn"){
        var index = Number(this.index);  
		event("工具条",index); 
		return;
		}
		
		//搜索框 触发部分写在搜索框_添加里
		if(this.className=="ui-icon-close" && this.parentNode.parentNode.className=="ui-searchbar-wrap ui-border-b focus"){//这里加一个获取父节点class,以免出错
		this.parentNode.childNodes[2].firstChild.value="";
		return; 
		}
        
		if(this.className=="ui-btn ui-btn-danger" && this.parentNode.className=="ui-searchbar-wrap ui-border-b focus" || this.className=="ui-icon-close" && this.parentNode.className=="ui-searchbar-wrap ui-border-b") {
        $('.ui-searchbar-wrap').removeClass('focus');
		if(this.parentNode.firstChild.childNodes[2].firstChild.value==""){
		this.parentNode.firstChild.childNodes[1].innerHTML=this.parentNode.firstChild.childNodes[2].firstChild.placeholder;
		return; 
		}else{
		this.parentNode.firstChild.childNodes[1].innerHTML="<p class='ui-txt-highlight'>"+this.parentNode.firstChild.childNodes[2].firstChild.value+"</p>";
		event("搜索框",0,this.parentNode.firstChild.childNodes[2].firstChild.value); 
		return; 		
	     	}
		}
		
		//通知
        if(this.className=="ui-btn-primary ui-btn-lg" && this.parentNode.parentNode.className=="ui-notice"){//这里加一个获取父节点class,以免出错
		event("通知");
        }
		
		//列表框
        if(this.className=="ui-border-t" && this.parentNode.className.indexOf("ui-list ui-list-one ui-border-tb ui-list-active ui-list-cover")>=0){//这里加一个获取父节点class,以免出错 				
		event("列表框",this.index);
        }		
		
		
		
		return; 
		//MUI触发尾部
        });  
		
	
		
        }
		

}
//引入尾部	
		
	function 添加js(url,代码)
	{
		var p=document.getElementsByTagName("script");
		for(var i=0;i<p.length;i++){
		if(p[i].src!=undefined){
		var str=p[i].src;
		if(str.indexOf(url)>=0){
		return;
		}
		}}
		var JS = document.createElement("script");
		JS.type = "text/javascript";
		JS.src = url;
		document.getElementsByTagName("body").item(0).appendChild(JS);
		if(代码!=undefined){
		JS.onload = function(){  
        代码();  
        };
		}
	}
		
	function 添加css(url)
	{
		var p=document.getElementsByTagName("link");
		for(var i=0;i<p.length;i++){
		if(p[i].href!=undefined){
		var str=p[i].href;
		if(str.indexOf(url)>=0){
		return;
		}
		}}
		var CSS = document.createElement("link");
		CSS.rel = "stylesheet";
		CSS.type = "text/css";
		CSS.href = url;
		document.getElementsByTagName("head").item(0).appendChild(CSS);
	}
	
	function 删除内容(uid,class属性,index,元素样式)
	{
	        var div = document.getElementById(uid).getElementsByTagName(元素样式);
            if(index<div.length){
			    for(var i=0;i < div.length; i++){
				if(div[i].className==class属性 && div[i].index==index){
                var table = div[i].parentNode;
                table.removeChild(div[i]);
                var div2 = document.getElementById(uid).getElementsByTagName(元素样式);
				var ii=0;
                for(var i = 0;i < div2.length; i++){
				if(div2[i].className==class属性){
                    div2[i].index=ii;
					ii++;
					}
                  }
				  return;
			    }

            }
        }	
	}
	