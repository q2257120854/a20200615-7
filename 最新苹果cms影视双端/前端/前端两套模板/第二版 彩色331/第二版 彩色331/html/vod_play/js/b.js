var vod_name;
    apiready = function(){
        var vod_id = api.pageParam.vod_id;
        vod_name = api.pageParam.vod_name;
        var name=$api.byId('name');
        name.innerHTML = vod_name;
        api.addEventListener({
            name: 'myEvent'
        }, function(ret){
            if(ret && ret.value){
                var value = ret.value;
                vod_name=value.key1;
                name.innerHTML = vod_name;
            }
        });
        if(api.pageParam.ulog_nid){
            var ulog_nid = api.pageParam.ulog_nid;
        }else{
            var ulog_nid = 0;
        }
        var type_id = api.pageParam.type_id;
        var vod_area = api.pageParam.vod_area;
        api.parseTapmode();
        var header = $api.byId('aui-header');
        $api.fixStatusBar(header);
        var headerPos = $api.offset(header);
        var body_h = $api.offset($api.dom('body')).h;
        api.openFrame({
            name: 'vod_play_frm',
            url: 'vod_play_frm.html',
            bounces: false,
            rect: {
                x: 0,
                y: headerPos.h,
                w: 'auto',
                h: 'auto'
            },
            pageParam: {
                vod_id:vod_id,
                vod_name:vod_name,
                vod_area:vod_area,
                type_id:type_id,
                ulog_nid:ulog_nid,
                headH:headerPos.h
            }
        })
    };
    function closeWin(){
        api.closeWin({
        });
    }