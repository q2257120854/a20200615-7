
//相关文档地址 http://www.html5plus.org/doc/zh_cn/downloader.html

function 下载器(name,event1,event2){   
    //name表示组件在被创建时的名称，event表示组件拥有的事件
    //如果组件有多个事件，可以在后面继续填写这些事件名称
    //例如：function 下载器(name,event1,event2,event3){
    
    //组件内部属性，仅供组件内部使用：
    //this.名称 = name;
    
    //组件命令：
    this.创建任务 = function (文件网址){
        /*var dtask = plus.downloader.createDownload(文件网址, {}, function (任务对象,状态码) {
            if (状态码 == 200) { 
                event2(true,任务对象);
            } else {
                event2(false,任务对象);
            }  
        });*/
        var dtask = plus.downloader.createDownload(文件网址);
        dtask.addEventListener("statechanged", onStateChanged, false);
        dtask.start();
        return dtask;
    } 
    
    //组件事件：
    function onStateChanged(任务对象,状态码){
        if(任务对象.state == 3){
            if(event1!=null){//触发组件的下载进度改变事件	
                event1(任务对象);
            }				
        }else if(任务对象.state == 4){
            if(event2!=null){//触发组件的下载完毕事件	
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
    this.置任务标志 = function (任务对象,value){
        任务对象.id=value;
    } 

    //组件命令：
    this.取文件网址 = function (任务对象){
        return 任务对象.url;
    }

    //组件命令：
    this.取本地路径 = function (任务对象){
        return 任务对象.filename;
    } 

    //组件命令：
    this.取本地路径2 = function (任务对象){
        return plus.io.convertLocalFileSystemURL(任务对象.filename);
    } 

    //组件命令：
    this.取已下载大小 = function (任务对象){
        return 任务对象.downloadedSize;
    } 

    //组件命令：
    this.取文件总大小 = function (任务对象){
        return 任务对象.totalSize;
    } 

    //组件命令：
    this.释放内存 = function (){
        plus.downloader.clear();
    }
   
}

 