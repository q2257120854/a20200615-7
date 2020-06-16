apiready = function(){
    api.parseTapmode();
    var header = $api.byId('aui-header');
    $api.fixStatusBar(header);
    var headerPos = $api.offset(header);
    var body_h = $api.offset($api.dom('body')).h;
    api.openFrame({
        name: 'vip_frm',
        url: 'vip_frm.html',
        bounces: false,
        rect: {
            x: 0,
            y: headerPos.h,
            w: 'auto',
            h: 'auto'
        }
    })
};
function closeWin(){
    api.closeWin({
    });
}