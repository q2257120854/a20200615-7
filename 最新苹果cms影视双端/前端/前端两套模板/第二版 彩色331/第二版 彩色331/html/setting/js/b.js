apiready = function(){
    api.parseTapmode();
    var header = $api.byId('aui-header');
    $api.fixStatusBar(header);
    var headerPos = $api.offset(header);
    var body_h = $api.offset($api.dom('body')).h;
    api.openFrame({
        name: 'setting_frm',
        url: 'setting_frm.html',
        bounces: false,
        rect: {
            x: 0,
            y: headerPos.h,
            w: 'auto',
            h: 'auto'
        },
        pageParam: {
           
        }
    })
};
function closeWin(){
    api.closeWin({
    });
}