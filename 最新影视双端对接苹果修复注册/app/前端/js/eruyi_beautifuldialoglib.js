    function 如意特效对话框(name,event1,event2){   
        //name表示组件在被创建时的名称，event表示组件拥有的事件
        //如果组件有多个事件，可以在后面继续填写这些事件名称
        //例如：function 如意特效对话框(name,event1,event2,event3){
        
        //组件内部属性，仅供组件内部使用：
        this.名称 = name;
		
		$("#modal-1").on("shown.nifty.modal", function(){
		   event1();
		});
		$("#modal-1").on("hidden.nifty.modal", function(){
		   event2();
		});
		
		this.置对话框的样式 = function (stylename){
            $("#modal-1").removeClass();
			$("#modal-1").addClass("nifty-modal");
			$("#modal-1").addClass(stylename);
			$("#modal-1").nifty("update");
        }
		
		this.置关闭按钮样式 = function (stylename){
            $("#CloseDialog").removeClass();
			$("#CloseDialog").addClass("btn");
			$("#CloseDialog").addClass("md-close");
			$("#CloseDialog").addClass(stylename);
			$("#CloseDialog").nifty("update");
        }
		
		this.置标题背景颜色 = function (color){
            $("div .md-title").css("background-color",color); 
        }
		
		this.置标题文字颜色 = function (color){
            $("div .md-title h3").css("color",color);
        }
		
		this.置内容背景颜色 = function (color){
            $("div .md-body").css("background-color",color); 
        }
		
		this.置内容文字颜色 = function (color){
            $("div .md-body").css("color",color);
        }
 
        this.置对话框的标题 = function (newTitle){
            $("div .md-title h3").text(newTitle);
        } 

        this.取对话框的标题 = function (){
           return $("div .md-title h3").text();
        } 
		
	
        this.置对话框的内容 = function (newTitle){
            $("div .md-body .body").html(newTitle);
        } 
        
        this.取对话框的内容 = function (){
           return $("div .md-body .body").html();
        }  
		

        this.置关闭按钮文字 = function (newTitle){
            $("#CloseDialog").text(newTitle);
        } 
        
 
        this.取关闭按钮文字 = function (){
           return $("#CloseDialog").text();
        } 
		
		this.弹出对话框 = function (){
           $("#modal-1").nifty("show")
        }
		
		this.隐藏对话框 = function (){
           $("#modal-1").nifty("hide")
        } 
		
		this.更新对话框 = function (){
           $("#modal-1").nifty("update")
        }
		
    }