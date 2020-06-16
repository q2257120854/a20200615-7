    function 正则(name){   

        this.res ;
		this.sl = 0 ;
		this.arr ;
		this.bd  = "";
		this.zz = "" ;
        //组件命令：
        this.创建正则 = function (所有文本,正则文本,不区分大小写,多行查找){
            this.bd = "";
			this.zz = "";
			
			this.zz =正则文本 ;
			var zz = "g";
			
			if(不区分大小写){
				zz = zz + "i";
				this.bd = this.bd + "i";
			}
			if(多行查找){
				zz = zz + "m";
				this.bd = this.bd + "m";
			}
			this.res = 所有文本.match(RegExp(正则文本, zz));
			//console.log(this.res)；
        } 
        
        this.取匹配数量 = function (){
			if(this.res == "" || this.res == null){
				this.sl = 0 ;
			}else{
				this.sl = this.res.length;
			}
            
			return this.sl;
        } 
		
        this.取匹配文本 = function (匹配索引){
			if(this.res == "" || this.res == null  ){
				return "";
			}
			
			if(匹配索引 == null){
				return this.res;
			}
			return this.res[匹配索引];
        } 
		
		this.取子匹配文本 = function(匹配索引,子匹配索引){
			if(this.res == "" || this.res == null  ){
				return "";
			}
			this.arr = this.res[匹配索引].match(RegExp(this.zz, this.bd));
			return this.arr[子匹配索引];
		
		}
		
		this.检测是否为数字字母 = function (检测文本) {
			var patrn=/^(\w){1,}$/; 
			//console.log(patrn)
			if (!patrn.exec(检测文本)) {
				return false 
			}else{
				return true 
			}

		}
		
		this.检测是否为数字 = function (检测文本) {
			var patrn=/^(\d){1,}$/; 
			if (!patrn.exec(检测文本)) {
				return false 
			}else{
				return true 
			}

		}
		this.检测是否为字母 = function (检测文本) {
			var patrn=/^([a-zA-Z]){1,}$/; 
			if (!patrn.exec(检测文本)) {
				return false 
			}else{
				return true 
			}

		}
		this.检测是否为汉字 = function (检测文本) {
			var patrn=/^[\u4e00-\u9fa5]+$/; 
			if (!patrn.exec(检测文本)) {
				return false 
			}else{
				return true 
			}

		}		
		
		this.检测是否为邮箱 = function (检测文本) {
			var patrn=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/; 
			if (!patrn.exec(检测文本)) {
				return false 
			}else{
				return true 
			}

		}
		
}