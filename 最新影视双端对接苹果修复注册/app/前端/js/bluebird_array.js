    (function (){  
        //注册命名空间  
        window["数组操作"] = {}   
        
        function 取成员数(arr){  //返回数组中的成员的数量
            if(arr!=null){
                return arr.length;
            }else{
                return 0;
            }
        }

        function 合并数组(arr1,arr2){  //将两个数组合并，返回合并后的数组
            if(arr1==null){
                return arr2;
            }
            if(arr2==null){
                return arr1;
            }
            return arr1.concat(arr2);            
        }
        
        function 连接成员(arr,separator){  //将数组中的所有成员用指定符号连接成一个文本，返回连接后的文本
            if(arr==null || separator==null){
                return "";
            }
            return arr.join(separator); 
        }

        function 加入首成员(arr,element){  //在数组的首部加入一个成员，该数组将被直接改变，返回加入成员后该数组的成员数量
            if(arr==null){
                return 0;
            }
            arr.unshift(element);
            return arr.length;            
        } 
 
        function 加入尾成员(arr,element){  //在数组的尾部加入一个成员，该数组将被直接改变，返回加入成员后该数组的成员数量
            if(arr==null){
                return 0;
            }
            arr.push(element);
            return arr.length;            
        } 

        function 删除首成员(arr){  //删除数组的第一个成员，该数组将被直接改变，返回删除成员后该数组的成员数量
            if(arr==null){
                return 0;
            }
            arr.shift();
            return arr.length;            
        } 

        function 删除尾成员(arr){  //删除数组的最后一个成员，该数组将被直接改变，返回删除成员后该数组的成员数量
            if(arr==null){
                return 0;
            }
            arr.pop();
            return arr.length;            
        } 

        function 删除成员(arr,index){  //删除数组的指定成员，该数组将被直接改变，返回删除成员后该数组的成员数量
            if(arr==null){
                return 0;
            }
            arr.splice(index,1);
            return arr.length;            
        } 

        function 清空数组(arr){  //删除数组的全部成员，该数组将被直接改变，返回删除成员后该数组的成员数量
            if(arr==null){
                return 0;
            }
            arr.splice(0,arr.length);
            return arr.length;            
        }

        function 翻转顺序(arr){  //翻转数组中成员的顺序，该数组将被直接改变
            if(arr!=null){
                arr.reverse(); 
            }
        } 

        function 排列顺序(arr,type){  //按照字母(1)或者数字(2)升序排列数组成员，该数组将被直接改变
            if(arr!=null){
                if(type==1){
                    arr.sort();
                }else{
                    arr.sort(sortNumber);
                } 
            }
        } 

        function sortNumber(a, b)
        {
            return a - b
        }
 
        //注册function
        window["数组操作"]["取成员数"]=取成员数;  
        window["数组操作"]["合并数组"]=合并数组;
        window["数组操作"]["连接成员"]=连接成员;  
        window["数组操作"]["加入首成员"]=加入首成员;  
        window["数组操作"]["加入尾成员"]=加入尾成员;  
        window["数组操作"]["删除首成员"]=删除首成员;  
        window["数组操作"]["删除尾成员"]=删除尾成员;   
        window["数组操作"]["删除成员"]=删除成员;    
        window["数组操作"]["清空数组"]=清空数组;    
        window["数组操作"]["翻转顺序"]=翻转顺序;  
        window["数组操作"]["排列顺序"]=排列顺序;  
    })();
 