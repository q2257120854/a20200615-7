/**
 * 中英文翻译切换
 * @param {type} lang
 * @returns {undefined}
 */
function change_lang(lang){
    if (lang == 'zh-cn') {
        layer.confirm('您确定把语言切换为中文版？', {
            btn: ['是', '否'] //按钮
        }, function () {
            $.cookie('ds_home_lang', lang, { path: '/' });
            window.location.reload();
        });
    }else if(lang == 'en-us'){
        layer.confirm('您确定把语言切换为英文版？', {
            btn: ['是', '否'] //按钮
        }, function () {
            $.cookie('ds_home_lang', lang, { path: '/' });
            window.location.reload();
        });
    }else{
        layer.alert('未设置有语言'+lang)
    }
}


