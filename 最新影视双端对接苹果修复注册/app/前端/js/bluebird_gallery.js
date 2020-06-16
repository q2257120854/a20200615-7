    function 系统相册(name,event1,event2,event3){   
        //name表示组件在被创建时的名称，event表示组件拥有的事件
        //如果组件有多个事件，可以在后面继续填写这些事件名称
        //例如：function 系统相册(name,event1,event2,event3){
        
        //组件内部属性，仅供组件内部使用：
        this.名称 = name;
		this.类型 = "image";
		
        //组件命令：
		this.置选择文件类型 = function (value){
			this.类型 = value;
		}
        
        //组件命令：
		this.选择单个图片 = function (){
			plus.gallery.pick(function(path){
				if(event1!=null){
					event1(true,path);//触发选择单个图片完毕事件
				}				
			}, function (error) {
				if(event1!=null){
					event1(false,error.message);//触发选择单个图片完毕事件
				}
			}, {filter: this.类型} );	
        }
        
        //组件命令：
		this.选择多个图片 = function (){
			var wenj="";
			plus.gallery.pick(function(e){
				if(event2!=null){
					event2(true,e.files);//触发选择多个图片完毕事件
				}										
			}, function (e) {
				if(event2!=null){
					event2(false,e.message);//触发选择多个图片完毕事件
				}	
			},{filter: this.类型, multiple:true});
        }

        //组件命令：
		this.保存图片到相册 = function (path){
			var path2 = plus.io.convertLocalFileSystemURL(path);
           	plus.gallery.save(path2, function () {
                //console.log( "保存图片到相册成功" );
				if(event3!=null){
					event3(true);
				}
            },function(){
                //console.log( "保存图片到相册失败" );
				if(event3!=null){
					event3(false);
				}
            });	
       }
    }