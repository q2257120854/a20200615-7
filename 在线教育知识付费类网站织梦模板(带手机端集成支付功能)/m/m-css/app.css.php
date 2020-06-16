<?php
session_start();
if(strpos($_SERVER['HTTP_USER_AGENT'],'APICloud') !== false || $_SESSION['isApp'] == 1){ 
echo 'document.write("<style>.yxw-header,.appblank,.topbar,.m-header-member,.index-logo,.gzs-bottombar,.gzskcfx,.my_item_a,.m-header-more,.yxw-list-logo,.m-newsheader{display:none !important;}.wrapper{padding-bottom:0 !important;}.m-search-index{margin:0 15px !important;}.yxw-top-share,.gzs-lxwm,.hy-kf-app,.my-item-box,.my_item_app{display:block !important;}</style>");';
}
if($_COOKIE["DedeUserID"]){
	$DedeUserID = $_COOKIE["DedeUserID"];
}else{
	$DedeUserID = 0;
}
?>
var DedeUserID = <?php echo $DedeUserID; ?>;
function gouser(ob){
	<?php if(strpos($_SERVER['HTTP_USER_AGENT'],'APICloud') !== false || $_SESSION['isApp'] == 1){  ?>
		api.execScript({name: 'root',script: 'tabbar_setselect(3)'});
		return;
	<?php }else{ ?>
		var url = $(ob).attr("data-goto");
		window.location.href = url;
	<?php } ?>
}
<?php if(strpos($_SERVER['HTTP_USER_AGENT'],'APICloud') !== false || $_SESSION['isApp'] == 1){  ?>

$(function(){

$(document).bind('DOMSubtreeModified', function () {
  //init_app_alink();
});

init_app_alink();

	
});

apiready = function(){
init_app_alink();
api.execScript({name: 'root',script: 'set_userid(<?php echo $DedeUserID; ?>)'}); 
};
function init_app_alink(){
	
	
	
	$("a").click(function(event){
	   var url =  this.href;
	   console.log(url);
	   var click = $(this).attr("onclick");
	   if(click){
		   return;
	   }
	   
	   if( url == 'http://m.test.com/app/faq/' || url == 'http://m.test.com/app/shezhi/' || url == 'http://m.test.com/about/zhucexieyi/' || url == 'http://m.test.com/app/about/' || url == 'http://m.test.com/about/banquan/' || url == 'http://m.test.com/kcfx.html'){
		    var title = $(this).attr("data-title");
			api.execScript({name: 'root',script: 'openurlwin2("'+url+'","'+title+'")'}); 
		    return false;
	   }
	   
	     if( url == 'http://m.test.com/member/buyhui.php' ||  url == 'http://m.test.com/member/tui.php' ||  url == 'http://m.test.com/member/edit_face.php'){
		    var title = $(this).attr("data-title");
			api.execScript({name: 'root',script: 'openurlwin2("'+url+'","'+title+'")'}); 
		    return false;
	   }

	   if(url == 'javascript:;' || url == 'javascript:void(0)' || url == 'javascript:void(0);'){
		   return;
	   }
	   
	   if(url == 'http://m.test.com/member/index_do.php?fmdo=login&dopost=exit'){
		   return;
	   }
	   
	   if(url == 'http://m.test.com/' || url == '/'){
		   api.execScript({name: 'root',script: 'tabbar_setselect(0)'}); 
		   api.closeToWin({name: 'root'});
		   return;
	   }

	   if( DedeUserID && url == 'http://m.test.com/member/'){
		   api.execScript({name: 'root',script: 'tabbar_setselect(3)'});
		   api.closeToWin({name: 'root'});
		   return;
	   }
	   
	   
	  
	   
	   
	   if(url == 'javascript:history.go(-1);'){
		   api.execScript({script: 'closeWin()'}); 
	   }else{
		   
		     if(url.indexOf("/course/") != -1 && url.indexOf("/article/") != -1){
				 if(url.indexOf("html") != -1){
				   api.execScript({name: 'root',script: 'openurlwin4("'+url+'")'}); 
			    }else{
				    api.execScript({name: 'root',script: 'openurlwin("'+url+'")'}); 
			    }
				 return false;
			 }
		   
		   
		     if(url.indexOf("/member/") != -1){
			  var title = $(this).attr("data-title");
			  if(!title){
				  var title = $(this).html();
			  }
			  if(url.indexOf("archives_do") != -1){
				  if(url.indexOf("dopost=viewArchives") != -1){
					   api.execScript({name: 'root',script: 'openurlwin("'+url+'")'}); 
				  }
				   if(url.indexOf("dopost=viewType") != -1){
					  api.execScript({name: 'root',script: 'openurlwin3("'+url+'")'}); 
				  }
				 
			  }else{
				  api.execScript({name: 'root',script: 'openurlwin2("'+url+'","'+title+'")'});
			  }
			   
	      
           }else if(url.indexOf("/course/") != -1){
			   if(url.indexOf("html") != -1){
				   api.execScript({name: 'root',script: 'openurlwin("'+url+'")'}); 
			   }else{
				   api.execScript({name: 'root',script: 'openurlwin3("'+url+'")'}); 
			   }
			   
		   }else if(url.indexOf("/article/") != -1){
			    api.execScript({name: 'root',script: 'openurlwin4("'+url+'")'}); 
		   }else{
			   api.execScript({name: 'root',script: 'openurlwin("'+url+'")'}); 
		   }
		   
	   }
       event.preventDefault();
	   return false;
    });
	
}

function app_share(sharedata){
	var data = JSON.stringify(sharedata);
	api.execScript({name: 'root',script: "web_share('"+data+"')"}); 
}


<?php }else{ ?>

function init_app_alink(){return;}
function app_share(sharedata){return;}

<?php } ?>