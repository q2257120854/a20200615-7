function 上传器(name,event1,event2){   
    //name表示组件在被创建时的名称，event表示组件拥有的事件
    //如果组件有多个事件，可以在后面继续填写这些事件名称
    //例如：function 上传器(name,event1,event2,event3){
        
    //组件内部属性，仅供组件内部使用：
    this.名称 = name;
        
    //组件命令：
    this.创建任务 = function (服务端网址){
		var dtask = plus.uploader.createUpload(服务端网址,
					{ method:"POST",blocksize:102400,priority:100 },
					function ( t, status ) {
						// 上传完成,必须加上这个监听函数,否则无法上传成功
						/*if ( status == 200 ) { 
							alert( "Upload success: " + t.url );
						} else {
							alert( "Upload failed: " + status );
						}*/
					}					
		);		
		dtask.addEventListener("statechanged", onStateChanged, false);
		return dtask;
	} 

    //组件命令：
    this.添加文件 = function (任务对象,文件路径,文件名称){
        if(文件名称!=undefined){
            任务对象.addFile(文件路径, {key:文件路径,name:文件名称});
        }else{
            任务对象.addFile(文件路径, {key:文件路径});
        }
    }

    //组件命令：
    this.添加数据 = function (任务对象,数据名称,数据内容){
        任务对象.addData(数据名称,数据内容);
    } 

    //组件命令：
    this.开始上传 = function (任务对象){
        任务对象.start();
    }  
        
    //组件事件：
    function onStateChanged(任务对象,状态码){
        if(任务对象.state == 3){
            if(event1!=null){//触发组件的上传进度改变事件	
                event1(任务对象);
            }				
        }else if(任务对象.state == 4){
            if(event2!=null){//触发组件的上传完毕事件	
                if(状态码 == 200){
                    event2(true,任务对象);
                }else{
                    event2(false,任务对象);
                }
            }					
        }
    }

    //组件命令：
    this.暂停任务 = function (任务对象){
        任务对象.pause();
    }  

    //组件命令：
    this.继续任务 = function (任务对象){
        任务对象.resume();
    } 

    //组件命令：
    this.取消任务 = function (任务对象){
        任务对象.abort();
    } 

    //组件命令：
    this.取任务标志 = function (任务对象){
        return 任务对象.id;
    }
	
    //组件命令：
    this.取已上传大小 = function (任务对象){
        return 任务对象.uploadedSize;
    } 

    //组件命令：
    this.取文件总大小 = function (任务对象){
        return 任务对象.totalSize;
    } 	

    //组件命令：
    this.取返回数据 = function (任务对象){
        return 任务对象.responseText; 
    }	

    //组件命令：
    this.释放内存 = function (){
        plus.uploader.clear();
    } 
	
}