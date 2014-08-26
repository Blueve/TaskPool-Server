$(document).ready(function()
{
	// 全局状态
	var curTaskList     = 0;		// 当前选中的列表id - 0为总概列表
	var curDataSet      = 'today';	// 当前选中的数据集类型
	var curTaskListHtml = ''; 		// 当前列表的Html

	var sortable        = false;	// 是否可排序

	var curNewListType  = 'CREATE'; // 当前创建列表的选项

	// 初始化列表阴影
	refreshListShadow(curTaskList);

	/* 添加新的列表
	 * ----------------------------------------
	 * 创建添加新列表的Popover
	 * 创建切换创建列表类型的事件
	 * 注册提交新列表的Ajax事件
	 * ----------------------------------------
	 */
	// 创建添加新列表的Popover
	var template = '\
		<form role="form" id="newList_form">\
          <div class="form-group" width="276px">\
            <div class="input-group">\
		      <div class="input-group-btn">\
		        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="newList_button">新建<span class="caret"></span></button>\
		        <ul class="dropdown-menu" role="menu">\
		          <li><a href="#create" class="listOp">新建</a></li>\
		          <li class="divider"></li>\
		          <li><a href="#copy" class="listOp">复制</a></li>\
		          <li><a href="#link" class="listOp">链接</a></li>\
		        </ul>\
		      </div>\
              <input type="text" class="form-control" id="nameOrCode" name="nameOrCode" placeholder="列表名" required/>\
            </div>\
          </div>\
          <button type="submit" id="newList_submit" class="btn btn-default btn-block">执行</button>\
        </form>\
	';
	$('#createList_pop').popover(
	{
		html: true,
		title: '创建',
		content: template,
		trigger: 'click focus'
	});
	$('#createList_pop').on('shown.bs.popover', function()
	{
		curNewListType = 'CREATE';
		$('#name').focus().select(); // 切换焦点
	});
	// 创建切换创建列表类型的事件
	$(document).on('click', '.listOp', function(e)
	{
		op = $(e.target).attr('href');
		if(op == '#create')
		{
			curNewListType = 'CREATE';
			$('#name').attr('placeholder', '列表名');
			$('#newList_button').html('新建<span class="caret"></span>');
		}
		else if(op == '#copy')
		{
			curNewListType = 'COPY';
			$('#name').attr('placeholder', '共享码');
			$('#newList_button').html('复制<span class="caret"></span>');
		}
		else if(op == '#link')
		{
			curNewListType = 'LINK';
			$('#name').attr('placeholder', '共享码');
			$('#newList_button').html('链接<span class="caret"></span>');
		}
		$('#name').focus().select(); // 切换焦点
	});
	// 注册提交新列表的Ajax事件
	$('#taskList').on('submit', '#newList_form', function()
	{
		var message = $("#newList_form").serialize() + '&type=' + curNewListType;
		var $btn = $('#newList_submit');

		$btn.button('loading');

		// 提交信息
		submitNewList(message, function(){
			$btn.button('reset');
			refreshListShadow(curTaskList);
		});

		// 禁止响应表单的跳转
		return false;
	});
	
	/* 列表之间切换的动作
	 * ----------------------------------------
	 * 注册列表切换的Ajax事件
	 * 注册列表切换完毕的样式刷新
	 * 注册数据集切换的Ajax事件
	 * ----------------------------------------
	 */
	// 注册列表切换的Ajax事件
	$('#taskList').on('show.bs.tab', 'a[data-toggle="tab"]', function(e)
	{
		var $target = $(e.target);
		var targetId = $target.data('id');

		// 更改设置按钮的显示
		$target.find('i.fa.fa-cog').show(200);

		// 刷新页面
		refreshListContent(targetId, curDataSet);

		// 更新状态
		curTaskList = targetId;
	});
	// 注册列表切换完毕的样式刷新
	$('#taskList').on('shown.bs.tab', 'a[data-toggle="tab"]', function(e)
	{
		refreshListShadow(curTaskList);
	});
	// 注册数据集切换的Ajax事件
	$('#taskListSet').on('show.bs.tab', 'a[data-toggle="pill"]', function(e)
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
	 * 注册列表顺位调整中的事件
	 * ----------------------------------------
	 */
	// 开启列表顺序可调
    $('#taskList').sortable({
	    items: 'li:not(#createList_pop)',
	    cancel: '#createList_pop',
	    axis: 'y',
	    stop: function(event, ui) {}
	});
    $('#taskList').sortable('disable');			// 默认不可调
    // 注册列表顺序调整按钮事件
    $('[data-toggle=tooltip]').tooltip();
    $('#save').hide();							// 默认隐藏保存和取消
    $('#sort').click(function() {				// 点击排序按钮
    	$(this).attr({							// 禁止再点击排序按钮
    		disabled: 'disabled'
    	});
    	$('#save').show(400);					// 保存组合框显示
    	//允许列表拖动
    	sortable = true;
    	$('.fa.fa-cog').hide();
		$('#taskList').sortable('enable');		// 开启调序
    });
    // 注册列表顺序调整保存的Ajax事件
    $('#ok').click(function() {
    	$('#save').hide(400);					// 隐藏保存菜单组
    	$('#taskList').sortable('disable');		// 禁止列表拖动

    	var taskLists = new Array();
    	var i = 0;
    	$('#taskList a').each(function()		// 获取新顺位
    	{
    		if($(this).data('id'))
    		{
				taskLists[i++] = $(this).data('id');
    		}
    	});
    	taskLists = taskLists.join(',');

    	submitListOrder(taskLists);				// 提交列表顺位
    	sortable = false;
    	$('#sort').removeAttr('disabled');		// 禁止排序

    	curTaskListHtml = $('#taskList').html();// 保存当前列表的Html
    });
    // 注册列表顺位调整取消的事件
    $('#cancel').click(function() {
    	$('#save').hide(400);					// 隐藏保存按钮组

    	// 恢复初始排序	
    	if(!curTaskListHtml)
    	{
    		$('#taskList').sortable('cancel');	
    	}
    	else
    	{
    		$('#taskList').html(curTaskListHtml);
    	}
    	sortable = false;
    	$('#taskList').sortable('disable');		// 禁用排序
    	$('#sort').removeAttr('disabled');		// 允许使用调序按钮
    });
    // 注册列表顺位调整中的事件
   	$('#taskList').on('sortstop', function(event, ui) {
   		refreshListShadow(curTaskList);
   	})

    /* 列表设置
	 * ----------------------------------------
	 * 列表设置图标初始化
	 * 列表设置图标点击Ajax事件
	 * 初始化列表设置弹框内容
	 * 注册列表设置表单提交的Ajax事件
	 * 注册删除列表的按钮事件
	 * 颜色选择器
	 * 共享开关初始化
	 * ----------------------------------------
	 */
    // 列表设置图标初始化
    $('.fa.fa-cog').hide();							// 默认隐藏 
	$(document).on('mouseenter mouseout', 'li.active a', function(e)			// 鼠标悬停时显示
	{
		if(e.type === 'mouseenter' && !sortable)
		{
			$(e.target).find('i.fa.fa-cog').show(200);
		}
		else
		{
			if(!($(e.relatedTarget).hasClass('fa')))
			{
				$(e.target).find('i.fa.fa-cog').hide(200);
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
			if($(e.relatedTarget).attr('href') !== '#list_' + curTaskList )
			{
				$(e.target).hide(200);
			}
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
	$('#taskListSetting_modal').on('submit', '#taskListSetting_form', function()
	{
		var message = $("#taskListSetting_form").serialize();
		var $btn = $('#taskListSetting_modalSubmit');
		var icon = $('#icon').find(':input').val();
		message += "&icon=" + icon;

		$btn.button('loading');

		// 提交信息
		submitTaskListSetting(message, curTaskList, curDataSet, function()
		{
			$btn.button('reset');
		});

		// 禁止响应表单的跳转
		return false;
	});
	
	// 显示确认删除按钮
	$('#taskListSetting_modalDelete').click(function()
	{
		$('#taskListSetting_modalDelete').hide(200);
		$('#taskListSetting_modalDeleteCancel').show(200);
		$('#taskListSetting_modalDeleteConfirm').show(200);
	});

	// 隐藏确认删除按钮
	$('#taskListSetting_modal').on('hidden.bs.modal', function ()
	{
		$('#taskListSetting_modalDelete').show();
		$('#taskListSetting_modalDeleteCancel').hide();
		$('#taskListSetting_modalDeleteConfirm').hide();
	});

	$('#taskListSetting_modalDeleteCancel').click(function()
	{
		$('#taskListSetting_modalDelete').show(200);
		$('#taskListSetting_modalDeleteCancel').hide(200);
		$('#taskListSetting_modalDeleteConfirm').hide(200);
	});

	// 注册确认删除列表的按钮事件
	$('#taskListSetting_modalDeleteConfirm').click(function()
	{
		var $btn = $('#TaskListSetting_modalDeleteConfirm');

		$btn.button('loading');

		$.post('list/delete/' + curTaskList, '', function(data)
	    {
	    	if(!data.state)
	    	{
	    		alert('error');
	    	}
	    	else
	    	{
	    		$('a[href="#list_' + curTaskList + '"]').parent('li').remove();
	    		$('#tasklist a:first').tab('show');
	    	}

	    	$('#taskListSetting_modal').modal('hide');
	    	$btn.button('reset');
	    	//TODO:refreshListShadow();
	    }, 'json');	
	});

	// 颜色选择器
	$('.tile i').hide();
	$('.tile.selected i').show();
	$('.tile').click(function(event) {
		changeColorTo($(this).data('color'));
	});

	// 共享开关初始化
	$('#share').bootstrapSwitch({
		'onText':'<i class="fa fa-check"></i>',
		'offText': '<i class="fa fa-times">',
	});
});

function refreshListShadow(curTaskList)
{
	var increment = true;
	var $preTarget = null;
	$('#taskList li').each(function(index, element) {
		$target = $(element).find('a');
		if($target.data('id') == curTaskList)
		{
			increment = false;
		}
		
		$target.css('box-shadow', (increment ? '-4px -3px 4px #eee' : '-4px 3px 4px #eee'));
		$target.css('border-top', (increment ? '1px solid #ddd' : '1px solid transparent'));
		$target.css('border-bottom', (increment ? '1px solid transparent' : '1px solid #ddd'));

		if($target.data('id') == curTaskList)
		{
			$target.css('border-top', '1px solid #ddd');
		}
		$preTarget = $target;
	});
}

function submitNewList(message, callback)
{
	$.post('list/create', message, function(data)
	{
		if(data.state)
		{
			var item = '<li class="task-list-darkgray">\
				            <a href="#list_' + data.id + '" role="tab" data-toggle="tab" data-id="' + data.id + '">' +
				            	'<i class="fa ' + data.icon + ' fa-lg-repair fa-fw align-left"></i>' +
				             	data.name + '\
				             	<i class="fa fa-cog fa-lg pull-right" data-toggle="modal" data-target="#taskListSetting_modal" style="display: none"></i>\
				            </a>\
				         </li>';
			$(item).insertBefore('#createList_pop');
			item = '<div class="tab-pane fade" id="list_' + data.id + '"></div>';
			$('#taskListContent').append(item);
			$('#createList_pop').popover('hide');
			callback();
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

function submitListOrder(userLists)
{
	$.post('list/reorder', {userLists:userLists}, function(data)
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
	var $el = $(document.createElement('div'));
	
	$el.addClass('shadow');
	$el.html('<i class="fa fa-spinner fa-spin fa-3x"></i>');

	$('body').append($el);
	$.get('list/getListSetting/' + curTaskList, '', function(data)
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
    		changeColorTo(data.color);
    		$('#id').val(curTaskList);
    		$('#icon').iconpicker('setIcon', data.icon);
    		if(data.shareable)
    		{
    			$('#share').bootstrapSwitch('state', true, true);
    		}
    		else
    		{
    			$('#share').bootstrapSwitch('state', false, true);
    		}
    		$el.remove();
    	}
    }, 'json');
}

function submitTaskListSetting(message, curTaskList, curDataSet, callback)
{
	$.post('list/updateListSetting', message, function(data)
	{
		if(data.state)
		{
			$('#taskListSetting_modal').modal('hide');
			refreshListContent(curTaskList, curDataSet);
			$('a[href="#list_' + curTaskList + '"]').html(
				'<i class="fa ' + data.icon + ' fa-lg fa-fw align-left"></i>' +
				data.name + 
				'<i class="fa fa-cog fa-lg-repair pull-right" data-toggle="modal" data-target="#taskListSetting_modal" style="display: none;"></i>'
			);
			$('a[href="#list_' + curTaskList + '"]').parent('li').removeClass().addClass("active task-list-" + data.color);
			callback();
		}
		else
		{
			alert('error');
		}
	}, 'json');
}

function changeColorTo(color)
{
	$preSelected = $('.tile.selected');
	$nowSelected = $('[data-color="' + color + '"]');
	// 取消原先的选择
	$preSelected.removeClass('selected');
	$preSelected.find('i').hide(200);
	// 选中新的颜色
	$nowSelected.addClass('selected');
	$nowSelected.find('i').show(200);
	$('#color').val(color);
}