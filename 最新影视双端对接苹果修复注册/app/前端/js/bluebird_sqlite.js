    function sqlite数据库(name,event1,event2,event3,event4,event5,event6){   
        //name表示组件在被创建时的名称，event表示组件拥有的事件
        //如果组件有多个事件，可以在后面继续填写这些事件名称
        //例如：function sqlite数据库(name,event1,event2,event3){
        
		//参考文档：http://www.cnblogs.com/yuaima/p/5909314.html
		//          http://www.jb51.net/html5/65058.html
		
        //组件内部属性，仅供组件内部使用：
        this.db = null;
        
        //组件命令：
        this.打开数据库 = function(DBName,size){
            this.db = openDatabase(DBName,"1.0","MyDataBase",size);
			if(!this.db){
				return false;
			}else{
				return true;
			}
        } 
        //------------------------------------------------------------------------
        //组件命令：
        this.创建数据表 = function(table,column){//CREATE TABLE IF NOT EXISTS TableName (name text,info text,id integer)
			this.db.transaction(function(trans){
                trans.executeSql("CREATE TABLE IF NOT EXISTS " + table + " (" + column + ")",
					[],
					function(trans,result){
						event_a(true);
					},
                    function(trans,message){
						event_a(false);
                    });
            })           
        }  
       
        //组件事件
        function event_a(result){
			if(event1!=null){
				event1(result);//触发"创建数据表完毕"事件
			} 			     	
        }
		//------------------------------------------------------------------------
        //组件命令：
        this.添加数据 = function(table,data){//INSERT INTO TableName VALUES (?,?,?) [name,info,id]
			this.db.transaction(function(trans){
				var temp = "?";
				for(var i=0; i<data.length; i++){
					if(i>0){
						temp = temp + ",?";
					}
				}
                trans.executeSql("INSERT INTO " + table + " VALUES ("+temp+")",
					data,
					function(trans,result){
						event_b(true);
					},
                    function(trans,message){
						event_b(false);
                    });
            })           
        }  
       
        //组件事件
        function event_b(result){
			if(event2!=null){
				event2(result);//触发"添加数据完毕"事件
			} 			     	
        }		
		//------------------------------------------------------------------------
        //组件命令：
        this.删除数据 = function(table,condition){//DELETE FROM TableName WHERE name='Jack'
			this.db.transaction(function(trans){
                trans.executeSql("DELETE FROM " + table + " WHERE " + condition,
					[],
					function(trans,result){
						event_c(true);
					},
                    function(trans,message){
						event_c(false);
                    });
            })           
        }  
       
        //组件事件
        function event_c(result){
			if(event3!=null){
				event3(result);//触发"删除数据完毕"事件
			} 			     	
        }
		//------------------------------------------------------------------------
        //组件命令：
        this.修改数据 = function(table,data,condition){//"UPDATE TableName SET info='man' WHERE name='Jack'
			this.db.transaction(function(trans){
                trans.executeSql("UPDATE " + table + " SET " + data + " WHERE " + condition,
					[],
					function(trans,result){
						event_d(true);
					},
                    function(trans,message){
						event_d(false);
                    });
            })           
        }  
       
        //组件事件
        function event_d(result){
			if(event4!=null){
				event4(result);//触发"修改数据完毕"事件
			} 			     	
        }		
		//------------------------------------------------------------------------
        //组件命令：
        this.查询数据 = function(table,condition){//"SELECT * FROM TableName WHERE name='Jack'
			this.db.transaction(function(trans){
                trans.executeSql("SELECT * FROM " + table + " WHERE " + condition,
					[],
					function(trans,result){
						var data = new Array();
						for(var i=0;i<result.rows.length;i++){
                            data.push(result.rows.item(i));
                        }
						event_e(true,result.rows.length,data);
					},
                    function(trans,message){
						event_e(false,0,null);
                    });
            })           
        }  
       
        //组件事件
        function event_e(result,length,item){
			if(event5!=null){
				event5(result,length,item);//触发"查询数据完毕"事件
			} 			     	
        }
		//------------------------------------------------------------------------
        //组件命令：
        this.执行语句 = function(sql){
			this.db.transaction(function(trans){
                trans.executeSql(sql,
					[],
					function(trans,result){
						event_f(true,result);
					},
                    function(trans,message){
						event_f(false,message);
                    });
            })           
        }  
       
        //组件事件
        function event_f(result,msg){
			if(event6!=null){
				event6(result,msg);//触发"执行语句完毕"事件
			} 			     	
        }				
    }