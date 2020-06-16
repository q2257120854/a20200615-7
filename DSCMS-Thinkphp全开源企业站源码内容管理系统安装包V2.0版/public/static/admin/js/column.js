$(document).ready(function(){
	//列表下拉
	$('img[ds_type="flex"]').click(function(){
		var status = $(this).attr('status');
                 
		if(status == 'open'){
			var pr = $(this).parent('td').parent('tr');
			var id = $(this).attr('fieldid');
			var obj = $(this);
			$(this).attr('status','none');
			//aja
                   
			$.ajax({
				url: ADMINSITEURL+'/column/index?ajax=1&parent_id='+id,
				dataType: 'json',
				success: function(data){
					var src='';
                                    console.log(data);
					for(var i = 0; i < data.length; i++){
						var tmp_vertline = "<img class='preimg' src='templates/images/vertline.gif'/>";
						src += "<tr class='"+pr.attr('class')+" row"+id+"'>";
						
						if(data[i].have_child == 1){
							src += "<img fieldid='"+data[i].column_id+"' status='open' ds_type='flex' src='"+ADMINSITEROOT+"/images/treetable/tv-expandable.gif' />";
						}else{
							src += "<img fieldid='"+data[i].column_id+"' status='none' ds_type='flex' src='"+ADMINSITEROOT+"/images/treetable/tv-item.gif' />";
						}
						//图片
						src += "</td><td class='column_name'>";
                                                
                                                 //名称
						for(var tmp_i=1; tmp_i < (data[i].deep-1); tmp_i++){
							src += tmp_vertline;
						}
						if(data[i].have_child == 1){
							src += " <img fieldid='"+data[i].cloumn_id+"' status='open' ds_type='flex' src='"+ADMINSITEROOT+"/images/treetable/tv-item1.gif' />";
						}else{
							src += " <img fieldid='"+data[i].cloumn_id+"' status='none' ds_type='flex' src='"+ADMINSITEROOT+"/images/treetable/tv-expandable1.gif' />";
						}
						src += " <span fieldname='column_name' >"+data[i].column_name+"</span>";
						//新增下级
						if(data[i].deep < 2){
                                         
							src += "<a class='btn-add-nofloat marginleft' href='"+ADMINSITEURL+"/column/add/parent_id/"+data[i].column_id+"'><span  class='layui-btn layui-btn-xs'>新增下级</span></a>";
						}
                         
						src += "</td>";
						
						src += "<td class='w48 column_order'>";
                                                //排序
                                                src +=  "<span title='可编辑' ajax_branch='column_order' datatype='number' fieldid='"+data[i].column_id+"' fieldname='column_order' ds_type='inline_edit' class='editable'>"+data[i].column_order+"</span>"
						src += "</td>";
						
						//操作
						src += "<td class='w84'>";
						src += "<span><a href=\"javascript:dsLayerOpen('" + ADMINSITEURL + "/column/edit/id/" + data[i].column_id + "','编辑-"+data[i].column_name+"')\" class='layui-btn layui-btn-xs'><i class='layui-icon layui-icon-edit'></i>编辑</a>";
						src += "<a href=\"javascript:dsLayerConfirm('" + ADMINSITEURL + "/column/del/id/" + data[i].column_id + "','删除该分类将会同时删除该分类的所有下级分类，您确定要删除吗');\" class='layui-btn layui-btn-xs layui-btn-danger'><i class='layui-icon layui-icon-delete'></i>删除</a>";
						src += "</td>";
						src += "</tr>";
					}
					//插入
					pr.after(src);
					obj.attr('status','close');
					obj.attr('src',obj.attr('src').replace("tv-expandable","tv-collapsable"));
					$('img[ds_type="flex"]').unbind('click');
					$('span[ds_type="inline_edit"]').unbind('click');
					//重现初始化页面
					$.getScript(ADMINSITEROOT+"/js/column.js");

				},
				error: function(){
					alert('获取信息失败');
				}
			});
		}
		if(status == 'close'){
			$(".row"+$(this).attr('fieldid')).remove();
			$(this).attr('src',$(this).attr('src').replace("tv-collapsable","tv-expandable"));
			$(this).attr('status','open');
		}
	})
});