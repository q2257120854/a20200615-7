// 选择商品分类
function selClass($this){

    $('.wp_category_list').css('background', '');

    $("#commodityspan").hide();
    $("#commoditydt").show();
    $("#commoditydd").show();
    $this.siblings('li').children('a').attr('class', '');
    $this.children('a').attr('class', 'classDivClick');
    var data_str = '';
    eval('data_str = ' + $this.attr('data-param'));
    $('#class_id').val(data_str.gcid);
    $('#dataLoading').show();
    var deep = parseInt(data_str.deep) + 1;
    $.getJSON(HOMESITEURL+'/Sellergoodsadd/ajax_goods_class.html', {gc_id : data_str.gcid, deep: deep}, function(data) {
        if (data != '') {
            $('input[dstype="buttonNextStep"]').prop('disabled', true);
//            $('input[dstype="buttonNextStep"]').prop('disabled', false).css('cursor', 'pointer');
            $('#class_div_' + deep).children('ul').html('').end()
                .parents('.wp_category_list:first').removeClass('blank')
                .parents('.sort_list:first').nextAll('div').children('div').addClass('blank').children('ul').html('');
            $.each(data, function(i, n){
                $('#class_div_' + deep).children('ul').append('<li data-param="{gcid:'
                        + n.gc_id +',deep:'+ deep  +'}"><a class="" href="javascript:void(0)"><i class="iconfontt"></i>'
                        + n.gc_name + '</a></li>')
                        .find('li:last').click(function(){
                            selClass($(this));
                        });
            });
        } else {
            $('#class_div_' + data_str.deep).parents('.sort_list:first').nextAll('div').children('div').addClass('blank').children('ul').html('');
            disabledButton();
        }
        // 显示选中的分类
        showCheckClass();
        $('#dataLoading').hide();
    });
}
function disabledButton() {
    if ($('#class_id').val() != '') {
        $('input[dstype="buttonNextStep"]').prop('disabled', false).css('cursor', 'pointer');
    } else {
        $('input[dstype="buttonNextStep"]').prop('disabled', true).css('cursor', 'auto');
    }
}

$(function(){
    
    //自定义滚定条
    $('#class_div_1').perfectScrollbar();
    $('#class_div_2').perfectScrollbar();
    $('#class_div_3').perfectScrollbar();
    
    // ajax选择分类
    $('li[dstype="selClass"]').click(function(){
        selClass($(this));
    });
});
// 显示选中的分类
function showCheckClass(){
    var str = "";
    $.each($('a[class=classDivClick]'), function(i) {
        str += $(this).text() + '<i class="iconfont"></i>';
    });
    str = str.substring(0, str.length - 40);
    $('#commoditydd').html(str);
}