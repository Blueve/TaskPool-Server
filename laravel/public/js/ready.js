


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
	var curDataSet = 'today';
	$('#create_list_pop').popover(
		{
			html: true,
			title: '创建',
			content: template
		});

	// 提交新的列表
	$('#tasklist').on('submit', '#newlist_form', function(){
		var btn = $('#newlist_submit');
		btn.button('loding');
		var message = $("#newlist_form").serialize();
		$.post('list/create', message, function(data)
		{
			btn.button('reset');
			if(data.state)
			{
				var item = '<li>\
					            <a href="#list_' + data.id + '" role="tab" data-toggle="tab" data-id="' + data.id + '">\
					             	' + data.name + '\
					            </a>\
					         </li>';
				$(item).insertBefore('#create_list_pop');
				item = '<div class="tab-pane fade" id="list_' + data.id + '"></div>';
				$('#tasklist_content').append(item);
				$('#create_list_pop').popover('hide');

				$('a[href="#list_' + data.id + '"]').tab('show');
				refreshListContent(data.id);
			}
			else
			{
				alert('error');
			}
		}, 'json');
		return false;
	});
	$('#create_list_pop').on('shown.bs.popover', function()
	{
		// 切换焦点
		$('#name').focus().select();
	});

	// 切换列表
	$('#tasklist').on('show.bs.tab', 'a[data-toggle="tab"]', function(e)
	{
		var targetId = $(e.target).data('id');
		refreshListContent(targetId, curDataSet);
	});
	$('#tasklist_set').on('show.bs.tab', 'a[data-toggle="pill"]', function(e)
	{
		var targetId = $(e.target).data('id');
		curDataSet = $(e.target).data('set');
		$.post('list/content', {id:targetId, dataset:curDataSet}, function(data) 
		{
			$('#list_' + targetId).html(data.tasks);
		});
	});

	
	// 列表拖动
    $('#tasklist').sortable({
	    items: 'li:not(#create_list_pop)',
	    cancel: '#create_list_pop',
	    axis: 'y',
	});
    $('#tasklist').sortable('disable');

    // 列表操作开关
    $('[data-toggle=tooltip]').tooltip();
    $('#save').hide();
    $('#sort').click(function()
    {
    	$(this).attr({
    		disabled: 'disabled'
    	});
    	$('#save').show(400);
    	//允许列表拖动
		$('#tasklist').sortable('enable');
    	
    });
    $('#ok').click(function() 
    {
    	$('#save').hide(400);
    	$('#sort').removeAttr('disabled');
    	//禁止列表拖动
    	$('#tasklist').sortable('disable');

    	var taskLists = new Array();
    	var i = 0;
    	$('#tasklist a').each(function()
    	{
    		if($(this).data('id'))
    		{
				taskLists[i] = $(this).data('id');
	    		i++;
    		}
    	});

    	taskLists = taskLists.join(',');

    	$.post('list/reorder', {taskLists:taskLists}, function(data)
    	{
    		if(!data.state)
    		{
    			$('#tasklist').sortable('cancel');
    			alert('error');
    		}
    	}, 'json');

    });
    $('#cancel').click(function() 
    {
    	$('#save').hide(400);
    	$('#sort').removeAttr('disabled');
    	//禁止列表拖动
    	$('#tasklist').sortable('disable');
    	$('#tasklist').sortable('cancel');
    });

});

function refreshListContent(listId, dataSet)
{
	$.post('list/content', {id:listId, dataset:dataSet}, function(data) 
	{
		$('#list_' + listId).html(data.tasks);
		$('a[data-toggle="pill"]').each(function()
		{
			$(this).data('id', listId);
		});
	});
}