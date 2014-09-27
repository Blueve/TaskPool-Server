{{-- 快捷新建任务 --}}
<div class="col-md-9 column">
  <form class="form-inline" role="form" id="newTask_form">
    <div class="form-group">
      <label class="sr-only" for="taskName">{{{ Lang::get('task.create_task_quick') }}}</label>
      <input type="text" class="form-control" id="taskName" name="taskName" placeholder="{{{ Lang::get('task.create_task') }}}">
    </div>
    <button type="submit" class="btn btn-primary">
      <i class="fa fa-plus"></i>
      {{{ Lang::get('site.create') }}}
    </button>
    <button type="button" class="btn btn-default" id="createTaskMore_button" >
        <i class="fa fa-arrow-down" data-toggle="tooltip" data-placement="top" title="{{{ Lang::get('task.create_task_more') }}}"></i>
    </button>
  </form>
</div>
{{-- 高级新建任务 --}}
<div class="col-md-9 column">
  <form class="form-horizontal" role="form" id="newTaskAdvance_form">
    <div class="form-group">
      <div class="col-sm-12">
        <input type="text" class="form-control" id="taskNameA" name="taskName" placeholder="{{{ Lang::get('task.create_task') }}}">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-4">
        <textarea class="form-control" rows="6" id="description" name="description" placeholder="{{{ Lang::get('task.description') }}}"></textarea>
      </div>

      <div class="col-sm-4">
        <div class="tile tile-type i-nu" 
          data-toggle="tooltip" 
          title="{{{ Lang::get('task.i_nu') }}}"
          data-placement="top"><i class="fa fa-exclamation fa-2x"></i></div>
        <div class="tile tile-type i-u"
          data-toggle="tooltip" 
          title="{{{ Lang::get('task.i_u') }}}"
          data-placement="top"><i class="fa fa-exclamation fa-2x"></i><i class="fa fa-bolt fa-2x"></i></div>
        <div class="tile tile-type ni-nu"
          data-toggle="tooltip" 
          title="{{{ Lang::get('task.ni_nu') }}}"
          data-placement="bottom"></div>
        <div class="tile tile-type ni-u"
          data-toggle="tooltip" 
          title="{{{ Lang::get('task.ni_u') }}}"
          data-placement="bottom"><i class="fa fa-bolt fa-2x"></i></div>
      </div>

      <div class="col-sm-4">
        <label for="start">{{{ Lang::get('task.start') }}}</label>
        <div class="input-group date">
          <input type="text" class="form-control" id="start" name="start" readonly>
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        </div>

        <label for="end">{{{ Lang::get('task.end') }}}</label>
        <div class="input-group date">
          <input type="text" class="form-control" id="end" name="end" readonly>
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        </div>
      </div>
      
    </div>
    <div class="form-group">
      <div class="col-sm-2">
        <button type="submit" class="btn btn-primary">
          <i class="fa fa-plus"></i>
          {{{ Lang::get('site.create') }}}
        </button>
        <button type="button" class="btn btn-default" id="createTaskLess_button">
            <i class="fa fa-arrow-up" data-toggle="tooltip" data-placement="top" title="{{{ Lang::get('task.create_task_less') }}}"></i>
        </button>
      </div>
    </div>
  </form>
</div>