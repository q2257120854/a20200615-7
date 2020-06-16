    function 下拉框(name,event){   
        this.名称 = name;
        
        this.添加项目 = function (title,tag){
			var xiangmu = document.createElement("option"); 
			xiangmu.value=tag;
			xiangmu.innerText=title;
			document.getElementById(this.名称).appendChild(xiangmu);
        }
		
		this.删除项目 = function (index){
			var option = document.getElementById(this.名称).getElementsByTagName("option");
			if(index<option.length){
				var table = option[index].parentNode;
				table.removeChild(option[index]);
			}
        }
        
		this.清空项目 = function (){
           document.getElementById(this.名称).innerHTML="";
        }

		this.置字体大小 = function (value){
		   document.getElementById(this.名称).style.fontSize=value;
        }

		this.置现行选中项 = function (index){
		   document.getElementById(this.名称).options[index].selected=true;
        }
		
		this.置项目标题 = function (index,title){
		   document.getElementById(this.名称).options[index].innerText = title;
        }
		
		this.取项目标题 = function (index){
		   return document.getElementById(this.名称).options[index].innerText;
        }

		this.置项目标记 = function (index,tag){
		   document.getElementById(this.名称).options[index].value = tag;
        }
		
		this.取项目标记 = function (index){
		   return document.getElementById(this.名称).options[index].value;
        }
		
		this.取项目总数 = function (){
            return document.getElementById(this.名称).getElementsByTagName("option").length;
        }
		 
        
        this.置可视 = function (value){
            if(value==true){
                var div = document.getElementById(this.名称).parentNode;
                div.style.display="block";//显示	                
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
		
		if(event!=null){
			document.getElementById(this.名称).addEventListener("change", function () {
				var index = this.options.selectedIndex;
                event(index,this.options[index].innerText,this.options[index].value);
            });       	
        }
		
		
    }