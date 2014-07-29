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
	var template = '\
		<form role="form" id="newlist_form">\
          <div class="form-group" width="276px">\
            <label class="sr-only" for="name">列表名</label>\
            <input type="text" class="form-control" id="name" name="name" placeholder="列表名">\
          </div>\
          <button type="submit" id="newlist_submit" class="btn btn-default btn-block">创建</button>\
        </form>\
	';
	$('#create_list_pop').popover(
		{
			html: true,
			title: '创建',
			content: template
		});

	$('#create_list_pop').on('shown.bs.popover', function()
	{
		// 提交新的列表
		$('#newlist_form').submit(function(){
			var btn = $('#newlist_submit');
			btn.button('loding');
			var message = $("#newlist_form").serialize();
			$.post('list/create', message,
			function(data)
			{
				btn.button('reset');
				if(data.state)
				{
					$('#tasklist li').each(function()
						{
							$(this).removeAttr("class");
						});
					var item = '\
								<li class="active">\
						            <a href="#' + data.id + '" data-toggle="tab">\
						             	' + data.name + '\
						            </a>\
						         </li>';
					$(item).insertBefore('#create_list_pop');
					item = '<div class="tab-pane fade" id="list_' + data.id + '"></div>';
					$('#tasklist_content').append(item);
					$('#create_list_pop').popover('hide');
				}
				else
				{
					alert('error');
				}
				
			},
			'json');
			return false;
		});
	});

	$('#create_list_pop').on('shown.bs.popover', function()
	{
		// 切换焦点
		$('#name').focus().select();
	});

	// 切换列表
	$('a[data-toggle="tab"]').on('show.bs.tab', function(e)
	{
		var targetId = $(e.target).data('id');
		$.post('list/content', {id:targetId}, function(data) 
		{
			$($(e.target).attr('href')).html(data.tasks);
			$('a[data-toggle="pill"]').each(function()
			{
				$(this).data('id', targetId);
			});
		});
	});

	$('a[data-toggle="pill"]').on('show.bs.tab', function(e)
	{
		var targetId = $(e.target).data('id');
		var targetDataSet = $(e.target).data('set');
		$.post('list/content', {id:targetId, dataset:targetDataSet}, function(data) 
		{
			$('#list_' + targetId).html(data.tasks);
		});
	});
});