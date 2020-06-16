
    //相关文档地址 http://dev.dcloud.net.cn/mui/pulldown/
    function 下拉刷新(name){  
        this.名称 = name;

        this.滚动到顶部 = function(){
            mui(".mui-scroll-wrapper").scroll().reLayout();
            mui('#pullRefreshContainer').pullRefresh().scrollTo(0,0,100);
        }

        this.滚动到底部 = function(){
            //mui('.mui-scroll-wrapper').scroll().scrollToBottom(100);
            var pullRefreshContainer = document.getElementById("pullRefreshContainer");
            //mui(".mui-scroll-wrapper").scroll().scrollTo(0,document.body.scrollHeight-pullRefreshContainer.scrollHeight,100);  
            mui(".mui-scroll-wrapper").scroll().reLayout();
            mui(".mui-scroll-wrapper").scroll().scrollToBottom(100);         
        }

        this.执行下拉刷新 = function(){
            if (mui.os.plus) {
                setTimeout(function() {
                    mui('#pullRefreshContainer').pullRefresh().pulldownLoading();
                }, 1000);
            }else{
                mui('#pullRefreshContainer').pullRefresh().pulldownLoading();
            }
        }

        this.执行上拉加载 = function(){
            if (mui.os.plus) {
                setTimeout(function() {
                    mui('#pullRefreshContainer').pullRefresh().pullupLoading();
                }, 1000);
            }else{
                mui('#pullRefreshContainer').pullRefresh().pullupLoading();
            }
        }
      
        this.停止下拉刷新 = function(){
            mui('#pullRefreshContainer').pullRefresh().endPulldownToRefresh();
        }
        
        this.停止上拉加载 = function(){
            mui('#pullRefreshContainer').pullRefresh().endPullupToRefresh(false);
        }
        
    }  


 