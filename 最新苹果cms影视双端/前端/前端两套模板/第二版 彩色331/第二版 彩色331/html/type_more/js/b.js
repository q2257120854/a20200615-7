apiready = function(){
    var type_id = api.pageParam.type_id;
    var type_name = api.pageParam.type_name;
    var type_pic = api.pageParam.type_pic;
    var type_mid= api.pageParam.type_mid;

    $api.byId('name').innerHTML = type_name;
    api.parseTapmode();
    var header = $api.byId('aui-header');
    $api.fixStatusBar(header);
    var headerPos = $api.offset(header);
    var body_h = $api.offset($api.dom('body')).h;
    api.openFrame({
        name: 'type_more_frm',
        url: 'type_more_frm.html',
        bounces: false,
        rect: {
            x: 0,
            y: headerPos.h,
            w: 'auto',
            h: 'auto'
        },
        pageParam: {
            type_id:type_id,
            type_name:type_name,
            type_pic:type_pic,
            type_mid:type_mid
        }
    })
};
function closeWin(){
    api.closeWin({
    });
}