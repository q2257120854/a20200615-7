    (function (){  
        //注册命名空间  
        window["数学操作"] = {}   

        function 到数值(str) { 
            return Number(str);
        }
        
        function 取随机数(min,max){
            return parseInt(Math.random()*(max-min+1)+min,10);
        }

        function 取绝对值(value){ 
            return Math.abs(value);
        }

        function 取余数(a,b){ 
            return a%b;
        }  
        
        function 取整数(value){
            return parseInt(value);
        }

        function 取次方(a,b){ 
            return Math.pow(a,b);
        } 

        function 四舍五入(value,num){
            //return value.toFixed(num);
            return Math.round(value * Math.pow(10, num)) / Math.pow(10, num);
        }

        function 表达式计算(value){
            return eval(value);
        }
        
        //注册function
        window["数学操作"]["到数值"]=到数值;  
        window["数学操作"]["取随机数"]=取随机数;  
        window["数学操作"]["取绝对值"]=取绝对值; 
        window["数学操作"]["取余数"]=取余数;
        window["数学操作"]["取整数"]=取整数;
        window["数学操作"]["取次方"]=取次方;
        window["数学操作"]["四舍五入"]=四舍五入;
        window["数学操作"]["表达式计算"]=表达式计算;
    })();
 