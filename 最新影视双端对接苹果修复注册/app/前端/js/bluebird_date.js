    (function (){  
        //注册命名空间  
        window["时间操作"] = {}   

        function 取当前日期时间() { 
            return new Date();
        }

        function 取现行日期() { 
            var date = new Date();
            var month = date.getMonth() + 1;
            var strDate = date.getDate();
            if (month >= 1 && month <= 9) {
                month = "0" + month;
            }
            if (strDate >= 0 && strDate <= 9) {
                strDate = "0" + strDate;
            }
            var currentdate = date.getFullYear() + "/" + month + "/" + strDate;
            return currentdate;
        }
        
        function 取现行时间() { 
            var date = new Date();
            var getHours = date.getHours();
            var getMinutes = date.getMinutes();
            var getSeconds = date.getSeconds();
            if (getHours >= 0 && getHours <= 9) {
                getHours = "0" + getHours;
            }
            if (getMinutes >= 0 && getMinutes <= 9) {
                getMinutes = "0" + getMinutes;
            }
            if (getSeconds >= 0 && getSeconds <= 9) {
                getSeconds = "0" + getSeconds;
            }
            var currenttime = getHours + ":" + getMinutes + ":" + getSeconds;
            return currenttime;
        }

        function 到日期时间(年,月,日,时,分,秒) {
            return new Date(年,月-1,日,时,分,秒);
        } 

        function 到日期时间2(value) {
            return new Date(value);
        } 

        function 时间到文本(date){ 
            var month = date.getMonth()+1;
            var strDate = date.getDate();
            if (month >= 1 && month <= 9) {
                month = "0" + month;
            }
            if (strDate >= 0 && strDate <= 9) {
                strDate = "0" + strDate;
            }
            var currentdate = date.getFullYear() + "/" + month + "/" + strDate; 
            
            var getHours = date.getHours();
            var getMinutes = date.getMinutes();
            var getSeconds = date.getSeconds();
            if (getHours >= 0 && getHours <= 9) {
                getHours = "0" + getHours;
            }
            if (getMinutes >= 0 && getMinutes <= 9) {
                getMinutes = "0" + getMinutes;
            }
            if (getSeconds >= 0 && getSeconds <= 9) {
                getSeconds = "0" + getSeconds;
            }
            var currenttime = getHours + ":" + getMinutes + ":" + getSeconds;     
            
            return currentdate + " " + currenttime;                  
        }

        function 取时间间隔(a,b){ 
            return a.getTime()-b.getTime();
        }

        function 取年(time){ 
            return time.getFullYear();
        }

        function 取月(time){ 
            return time.getMonth()+1;
        }

        function 取日(time){ 
            return time.getDate();
        }

        function 取时(time){ 
            return time.getHours();
        }
        
        function 取分(time){ 
            return time.getMinutes();
        }
        
        function 取秒(time){ 
            return time.getSeconds();
        }
       
        function 取星期几(time){ 
            return time.getDay();
        }

        function 取时间戳(time){ 
            return Date.parse(time);
        }

        function 时间戳到时间(value){ 
            return new Date(value);
        }
        
        //注册function       
        window["时间操作"]["取当前日期时间"]=取当前日期时间;  
        window["时间操作"]["取现行日期"]=取现行日期;  
        window["时间操作"]["取现行时间"]=取现行时间;  
        window["时间操作"]["到日期时间"]=到日期时间; 
        window["时间操作"]["到日期时间2"]=到日期时间2; 
        window["时间操作"]["时间到文本"]=时间到文本; 
        window["时间操作"]["取时间间隔"]=取时间间隔;           
        window["时间操作"]["取年"]=取年;
        window["时间操作"]["取月"]=取月;
        window["时间操作"]["取日"]=取日;
        window["时间操作"]["取时"]=取时;
        window["时间操作"]["取分"]=取分;
        window["时间操作"]["取秒"]=取秒;       
        window["时间操作"]["取星期几"]=取星期几;
        window["时间操作"]["取时间戳"]=取时间戳;
        window["时间操作"]["时间戳到时间"]=时间戳到时间;
        
    })();
 