    function 仔仔弹出通知(name,event){   
        this.名称 = name;

        this.成功 = function (newTitle,time){
			var notyf = new Notyf({delay:time});
			notyf.confirm(newTitle);
        }
        
        this.警告 = function (newTitle,time){
		   var notyf = new Notyf({delay:time});
           notyf.alert(newTitle);
        }
    }