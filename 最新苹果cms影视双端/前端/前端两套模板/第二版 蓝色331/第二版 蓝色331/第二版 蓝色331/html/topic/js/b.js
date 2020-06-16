apiready = function(){
    var topic_id = api.pageParam.topic_id;
    var topic_name = api.pageParam.topic_name;
    var topic_pic = api.pageParam.topic_pic;

    api.parseTapmode();
    var header = $api.byId('aui-header');
    $api.fixStatusBar(header);
    var headerPos = $api.offset(header);
    var body_h = $api.offset($api.dom('body')).h;
    api.openFrame({
        name: 'topic_frm',
        url: 'topic_frm.html',
        bounces: false,
        rect: {
            x: 0,
            y: headerPos.h,
            w: 'auto',
            h: 'auto'
        },
        pageParam: {
            topic_id: topic_id,
            topic_name:topic_name,
            topic_pic:topic_pic
        }
    })
};
function closeWin(){
    api.closeWin({
    });
}