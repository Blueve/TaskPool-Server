$(document).ready(function()
{
	// 初始化iCheck插件
	$('.checkbox-normal').iCheck({
		checkboxClass: 'icheckbox_flat-blue',
		radioClass: 'iradio_flat-blue',
	});

	// 初始化注册、登录表单
	$('#signup_form').hide();

	// 切换注册、登录表单
	$('#signup_button').click(function(){
		$('#signup_form').slideDown();
		$('#signin_form').slideUp();
	});
	$('#signin_button').click(function(){
		$('#signup_form').slideUp();
		$('#signin_form').slideDown();
	});

	// 添加新的列表
	$('#create_list_pop').popover(
		{
			html: true,
			//trigger: 'focus',
			title: '创建',
			content: $('#create_list').html()
		});
});