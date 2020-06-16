function CYS悬浮导航(name,event){
	/*作者：CYS。  QQ：649812788
		  有BUG请反馈,谢谢！
	*/
	var nav = document.getElementById(name);
	var tableView = document.getElementsByClassName("cys-nav-table-view")[0];
	var group = nav.getElementsByClassName("cys-nav-group")[0];
	var _top = tableView.offsetTop;
	var offTop = 46;
	var itemSpace = 0;
	this.名称 = name;
	
	
	this.添加项目 = function(title,img){
		var item = document.createElement("li");
		var count = group.getElementsByClassName("cys-nav-item").length;
		item.className = "cys-nav-item";
		item.setAttribute("index",count);
		item.innerHTML = "<img src='"+img+"' /><p>"+title+"</p>";
		group.appendChild(item);
		sort();
	};
	
	this.置偏移 = function(val){
		offTop = val;
	};
	
	this.置项目间距 = function(val){
		itemSpace = val;
		sort();
	}
	
	this.取项目数 = function(){
		var liArr = group.getElementsByClassName("cys-nav-item");
		return liArr.length;
	};
	

	
	this.置可视 = function (value){
        if(value==true){
            var div = document.getElementById(this.名称).parentNode;
            div.style.display="";//显示，也可以设置为block	                
        }else{
            var div = document.getElementById(this.名称).parentNode;
            div.style.display="none"; //不占位隐藏               
        }
    } 
        
    this.置可视2 = function (value){
        if(value==true){
            var div = document.getElementById(this.名称).parentNode;
            div.style.visibility="visible";//显示	                
        }else{
            var div = document.getElementById(this.名称).parentNode;
            div.style.visibility="hidden"; //占位隐藏               
        }
    } 
	
	
	
	window.onscroll = function(){
		var t = document.documentElement.scrollTop || document.body.scrollTop;
		if(_top-offTop<t){
			if(tableView.className.indexOf("fiexd") == -1){
				tableView.className = "cys-nav-table-view cys-nav-table-view-fiexd";
			}
		}else{
			if(tableView.className.indexOf("fiexd") != -1){
				tableView.className = "cys-nav-table-view";
			}
		}
		//console.log(_top,t);
	};
	
	
	mui('.mui-scroll-wrapper').scroll({
			deceleration: 0.0005,
			scrollY: false,
	 		scrollX: true 
	});
	
	function sort(){
		var liArr = group.getElementsByClassName("cys-nav-item");
		var w = liArr.length * 80 + (liArr.length-1) * itemSpace;
		//var l = (tableView.clientWidth - w)/2;
		var l;
		group.style.width = w + "px";
		
		w<tableView.clientWidth ? l=(tableView.clientWidth - w)/2 : l=0;
		for(var i=0;i<liArr.length;i++){
			liArr[i].style.left = l + 80 * i + itemSpace * i + "px";
		}
	}
	
	
	mui("#"+name).on("tap",".cys-nav-item",function(){
		if(event!=null){
			event(Number(this.getAttribute("index")));
		}
	});
	

}