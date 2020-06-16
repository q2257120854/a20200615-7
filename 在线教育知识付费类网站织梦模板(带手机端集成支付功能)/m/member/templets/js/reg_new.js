<!--

$(document).ready(function()

{



	//checkSubmit

	$('#regUser').submit(function ()

	{

		

		if($('#txtUsername').val()==""){

			$('#txtUsername').focus();

			alert("手机号不能为空");

			return false;

		}

		if (!/^(13[0-9]|14[0-9]|15[0-9]|16[0-9]|17[0-9]|18[0-9]|19[0-9])\d{8}$/i.test($("#txtUsername").val())) {

		alert("手机号码不对,请正确填写");return false;}

		if($('#txtPassword').val()=="")

		{

			$('#txtPassword').focus();

			alert("密码不能为空");

			return false;

		}





		//互亿无线代码  www.ihuyi.com start

		if($('#mobile_phone').val()==""){

			$('#mobile_phone').focus();

			alert("手机号不能为空");

			return false;

		}	

		if($('#mobilecode').val()==""){

			$('#mobilecode').focus();

			alert("手机验证码不能为空");

			return false;

		}

        //互亿无线代码  www.ihuyi.com end

	})

	

	//AJAX changChickValue

	$("#txtUsername").change( function() {

			var sEmail = /^0{0,1}(13[0-9]|14[0-9]|15[0-9]|16[0-9]|17[0-9]|18[0-9]|19[0-9])[0-9]{8}$/;

		if(!sEmail.exec($("#txtUsername").val()))

		{

			$('#_userid').html("<font color='red'><b>×手机号码不正确</b></font>");

			$('#txtUsername').focus();

		}else{	$.ajax({type: reMethod,url: "index_do.php",

		data: "dopost=checkuser&fmdo=user&cktype=1&uid="+$("#txtUsername").val(),

		dataType: 'html',

		success: function(result){$("#_userid").html(result);}}); 

	}

	});

	



	$('#txtPassword').change( function(){

		if($('#txtPassword').val().length < pwdmin)

		{

			$('#_userpwdok').html("<font color='red'><b>×密码不能小于"+pwdmin+"位</b></font>");

		}

		else

		{

			$('#_userpwdok').html("<font color='#4E7504'><b>√填写正确</b></font>");

		}

	});

	



	

});

-->