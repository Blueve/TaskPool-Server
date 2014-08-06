$(document).ready(function()
{
	// 全局状态
	var curTaskList = 0;		// 当前选中的列表id - 0为总概列表
	var curDataSet = 'today';	// 当前选中的数据集类型

	/* 添加新的列表
	 * ----------------------------------------
	 * 创建添加新列表的Popover
	 * 注册提交新列表的Ajax事件
	 * ----------------------------------------
	 */
	// 创建添加新列表的Popover
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
		$('#name').focus().select(); // 切换焦点
	});
	// 注册提交新列表的Ajax事件
	$('#tasklist').on('submit', '#newlist_form', function()
	{
		var message = $("#newlist_form").serialize();
		var $btn = $('#newlist_submit');

		$btn.button('loading');

		// 提交信息
		submitNewList(message);

		$btn.button('reset');
		// 禁止响应表单的跳转
		return false;
	});
	
	/* 列表之间切换的动作
	 * ----------------------------------------
	 * 注册列表切换的Ajax事件
	 * 注册数据集切换的Ajax事件
	 * ----------------------------------------
	 */
	// 注册列表切换的Ajax事件
	$('#tasklist').on('show.bs.tab', 'a[data-toggle="tab"]', function(e)
	{
		var $target = $(e.target);
		var targetId = $target.data('id');

		// 更改设置按钮的显示
		$target.find('i:first-child').show(200);

		// 刷新页面
		refreshListContent(targetId, curDataSet);

		// 更新状态
		curTaskList = targetId;
	});
	// 注册数据集切换的Ajax事件
	$('#tasklist_set').on('show.bs.tab', 'a[data-toggle="pill"]', function(e)
	{
		var $target = $(e.target);
		var targetSet = $target.data('set');

		// 刷新页面
		refreshListContent(curTaskList, targetSet);

		// 更新状态
		curDataSet   = $target.data('set');
	});

	/* 调整列表顺序
	 * ----------------------------------------
	 * 开启列表顺序可调
	 * 注册列表顺序调整按钮事件
	 * 注册列表顺序调整保存的Ajax事件
	 * 注册列表顺位调整取消的时间
	 * ----------------------------------------
	 */
	// 开启列表顺序可调
    $('#tasklist').sortable({
	    items: 'li:not(#create_list_pop)',
	    cancel: '#create_list_pop',
	    axis: 'y',
	});
    $('#tasklist').sortable('disable');			// 默认不可调
    // 注册列表顺序调整按钮事件
    $('[data-toggle=tooltip]').tooltip();
    $('#save').hide();							// 默认隐藏保存和取消
    $('#sort').click(function()					// 点击排序按钮
    {
    	$(this).attr({							// 禁止再点击排序按钮
    		disabled: 'disabled'
    	});
    	$('#save').show(400);					// 保存组合框显示
    	//允许列表拖动
		$('#tasklist').sortable('enable');		// 开启调序
    	
    });
    // 注册列表顺序调整保存的Ajax事件
    $('#ok').click(function()
    {
    	$('#save').hide(400);					// 隐藏保存菜单组
    	$('#tasklist').sortable('disable');		// 禁止列表拖动

    	var taskLists = new Array();
    	var i = 0;
    	$('#tasklist a').each(function()		// 获取新顺位
    	{
    		if($(this).data('id'))
    		{
				taskLists[i++] = $(this).data('id');
    		}
    	});
    	taskLists = taskLists.join(',');

    	submitListOrder(taskLists);				// 提交列表顺位
    	$('#sort').removeAttr('disabled');		// 允许排序
    });
    // 注册列表顺位调整取消的时间
    $('#cancel').click(function() 
    {
    	$('#save').hide(400);					// 隐藏保存按钮组
    	$('#tasklist').sortable('disable');		// 禁用排序
    	$('#tasklist').sortable('cancel');		// 恢复初始排序
    	$('#sort').removeAttr('disabled');		// 允许使用调序按钮
    });

    /* 列表设置
	 * ----------------------------------------
	 * 列表设置图标初始化
	 * 列表设置图标点击Ajax事件
	 * 初始化列表设置弹框内容
	 * 注册列表设置表单提交的Ajax事件
	 * ----------------------------------------
	 */
    // 列表设置图标初始化
    $('.fa.fa-cog').hide();							// 默认隐藏 
	$(document).on('mouseenter mouseout', 'li.active a', function(e)				// 鼠标悬停时显示
	{
		if(e.type === 'mouseenter')
		{
			$(e.target).find('i').show(200);
		}
		else
		{
			if(!($(e.relatedTarget).hasClass('fa-cog')))
			{
				$(e.target).find('i').hide(200);
			}
			else
			{
				$(e.relatedTarget).addClass('fa-spin');
			}
		}
	});
	$(document).on('mouseenter mouseout', '.fa.fa-cog', function(e)				// 鼠标悬停时显示
	{
		if(e.type === 'mouseenter')
		{
			$(e.target).addClass('fa-spin');
		}
		else
		{
			$(e.target).removeClass('fa-spin');
		}
	});
    // 列表设置图标点击Ajax事件
    $(document).on('click', 'i.fa.fa-cog', function(e)
    {
    	$(e.target).hide(200);
    	fillListSettingForm(curTaskList);		// Ajax 填充表单
    });

    // 初始化列表设置弹框内容
    $('.radio-normal').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
	});

    // 注册列表设置表单提交的Ajax事件
	$('#TaskListSettingModal').on('submit', '#tasklitsetting_form', function()
	{
		var message = $("#tasklitsetting_form").serialize();
		var $btn = $('#TaskListSettingModal_submit');

		$btn.button('loading');

		// 提交信息
		submitTaskListSetting(message, curDataSet);

		$btn.button('reset');
		// 禁止响应表单的跳转
		return false;
	});
});

function submitNewList(message)
{
	$.post('list/create', message, function(data)
	{
		if(data.state)
		{
			var item = '<li class="task-list-darkgray">\
				            <a href="#list_' + data.id + '" role="tab" data-toggle="tab" data-id="' + data.id + '">\
				             	' + data.name + '\
				             	<i class="fa fa-cog fa-lg pull-right" data-toggle="modal" data-target="#TaskListSettingModal"></i>\
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
}

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

function submitListOrder(taskLists)
{
	$.post('list/reorder', {taskLists:taskLists}, function(data)
    {
    	if(!data.state)
    	{
    		$('#tasklist').sortable('cancel');
    		alert('error');
    	}
    }, 'json');
}

function fillListSettingForm(curTaskList)
{
	$.get('list/getListSetting', {curTaskList:curTaskList}, function(data)
    {
    	if(!data.state)
    	{
    		alert('error');
    	}
    	else
    	{
    		$('#name').val(data.name);
    		$('#' + data.sort_by).iCheck('check');
    		$('#color').val(data.color);
    		$('#id').val(curTaskList);
    	}
    }, 'json');
}

function submitTaskListSetting(message, curDataSet)
{
	$.get('list/updateListSetting', message, function(data)
	{
		if(data.state)
		{
			$(TaskListSettingModal).modal('hide');
			refreshListContent(data.id, curDataSet);
			$('a[href="#list_' + data.id + '"]').html(
				data.name + '<span class="glyphicon glyphicon-wrench pull-right" data-toggle="modal" data-target="#TaskListSettingModal"></span>'
			);
			$('a[href="#list_' + data.id + '"]').parent('li').removeClass().addClass("active task-list-" + data.color); 
		}
		else
		{
			alert('error');
		}
	}, 'json');
}