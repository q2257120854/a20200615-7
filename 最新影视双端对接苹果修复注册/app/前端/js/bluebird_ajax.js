//相关文档地址 http://dev.dcloud.net.cn/mui/ajax/
    function 网络操作(name,eventName){  
        this.名称 = name;
        this.服务端返回数据类型 = "";
        this.请求头 = null;
        this.跨域 = false;
        this.返回编码 = "utf-8";
        var 响应头 = null;
        
        this.取网络状态 = function(){
            return plus.networkinfo.getCurrentType();
            /*plus.networkinfo.CONNECTION_UNKNOW：0  未知状态
              plus.networkinfo.CONNECTION_NONE：1  无网络连接
              plus.networkinfo.CONNECTION_ETHERNET：2 有线网络
              plus.networkinfo.CONNECTION_WIFI：3 WIFI网络
              plus.networkinfo.CONNECTION_CELL2G：4   2G网络
              plus.networkinfo.CONNECTION_CELL3G：5   3G网络
              plus.networkinfo.CONNECTION_CELL4G：6   4G网络
            */
        }

        this.置返回编码 = function(value){
            this.返回编码 = value;
        }
        
        this.置跨域请求 = function(cross){
            this.跨域 = cross;
        }
        
        this.置附加请求头 = function(header){
            this.请求头 = header;
        }

        this.置UserAgent = function(ua){
            plus.navigator.setUserAgent(ua, false);
        }

        this.取UserAgent = function(){
            return plus.navigator.getUserAgent();
        }

        this.置Cookie = function(url, value){
            plus.navigator.setCookie(url, value);
        }

        this.取Cookie = function(url){
            return plus.navigator.getCookie(url);
        }

        this.删除全部Cookie = function(){
            return plus.navigator.removeAllCookie();
        }

        this.删除指定Cookie = function(url){
            return plus.navigator.removeCookie(url);
        }

        this.删除会话Cookie = function(){
            return plus.navigator.removeSessionCookie();
        }
       
        this.发送网络请求 = function (url地址,type请求类型,dataType返回数据类型,data数据,timeout超时){
            var temp = dataType返回数据类型;
            if(dataType返回数据类型=="txt"){
                temp="text";
            }
            this.服务端返回数据类型 = temp;
            
            mui.ajax(url地址, {
                crossDomain:this.跨域,
                type: type请求类型,                        
                headers:this.请求头,
                dataType: temp,
                data: data数据,
                timeout: timeout超时,
                charset_accept:this.返回编码,
                
                success: function(response,textStatus,xhr) {
                    响应头=xhr;
                    //alert(xhr.getAllResponseHeaders());
                    complete(true,response);
                },
                
                error: function(xhr,type,errorThrown) {
                    响应头=xhr;
                    complete(false,type);
                }
            });  
           
        }
        
        var complete = function(result,response) {
            if(eventName==null){
                return;
            }
            if(result==true){
                if (this.服务端返回数据类型 === "json") {
                    response = JSON.stringify(response);
                } else if (this.服务端返回数据类型 === "xml") {
                    response = new XMLSerializer().serializeToString(response);
                }
            }
            eventName(result,response);//发送完毕
        };      

        this.取指定响应头 = function(a){
            if(响应头!=null){
                return 响应头.getResponseHeader(a);
            }else{
                return "";
            }
        }

        this.取全部响应头 = function(){
            if(响应头!=null){
                return 响应头.getAllResponseHeaders();
            }else{
                return "";
            }
        }
        
    }  