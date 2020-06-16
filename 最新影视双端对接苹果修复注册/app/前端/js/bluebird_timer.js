
    function 时钟(name,eventName){  
        this.名称 = name;
        this.定时器 = null;
        this.定时器类型 = 1;
        
        this.开始执行 = function (time,loop){
            //先清除掉原先的定时器
            if(this.定时器!=null){
                if(this.定时器类型 == 1){
                    clearInterval(this.定时器);
                    this.定时器=null;
                }else{
                    clearTimeout(this.定时器);
                    this.定时器=null;
                }
            }
            if(loop==true){
                this.定时器类型 = 1;
                //循环执行
                this.定时器 = setInterval(function() {
                    if(eventName!=null){
                        eventName();
                    }
                },time);               
            }else{
                this.定时器类型 = 2;
                //只执行一次
                this.定时器 = setTimeout(function() {
                    if(eventName!=null){
                        eventName();
                    }
                },time);                
            }
        }
        
        this.停止执行 = function (){
            if(this.定时器!=null){
                if(this.定时器类型 == 1){
                    clearInterval(this.定时器);
                    this.定时器=null;
                }else{
                    clearTimeout(this.定时器);
                    this.定时器=null;
                }
            }            
        }
        
    }  


 