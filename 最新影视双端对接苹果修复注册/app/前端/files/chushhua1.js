            /* var appendTestData = Common.appendTestData,
                // 记录一个最新
                maxDataSize = 30,
                //listDom = document.querySelector('#listdata'),
                requestDelayTime = 600; */

            var miniRefresh = new MiniRefresh({
                container: '#minirefresh',
                down: {
					isAuto: false,
                    callback: function() {
                        //setTimeout(function() {
                            // 每次下拉刷新后，上拉的状态会被自动重置
                            //appendTestData(listDom, 10, true);
                            //miniRefresh.endDownLoading(true);
                        //}, requestDelayTime);
						
                    }
                },
                up: {
                    //isAuto: false,
                    callback: function() {
                       // setTimeout(function() {
                            //appendTestData(listDom, 10);
                            //miniRefresh.endUpLoading(listDom.children.length >= maxDataSize ? true : false);
                        //}, requestDelayTime);
						
                    }
                }
            });