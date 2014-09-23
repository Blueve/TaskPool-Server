{{-- 新建任务 --}}
<div class="col-md-9 column">
  <form class="form-inline" role="form" id="newTask_form">
    <div class="form-group">
      <label class="sr-only" for="taskName">{{{ Lang::get('task.create_task') }}}</label>
      <input type="text" class="form-control" id="taskName" name="taskName" placeholder="{{{ Lang::get('task.create_task') }}}">
    </div>
    <button type="submit" class="btn btn-default">{{{ Lang::get('site.create') }}}</button>
    <button type="button" class="btn btn-default" id="createTaskMore_button" >
        <i class="fa fa-arrow-down" data-toggle="tooltip" data-placement="top" title="{{{ Lang::get('task.create_task_more') }}}"></i>
    </button>
  </form>
</div>
<div class="col-md-9 column">
  <form class="form-inline" role="form" id="newTaskAdvance_form">
    <div class="form-group">
      <label class="sr-only" for="taskName">{{{ Lang::get('task.create_task') }}}</label>
      <input type="text" class="form-control" id="taskName" name="taskName" placeholder="{{{ Lang::get('task.create_task') }}}">
    </div>
    <button type="submit" class="btn btn-default">{{{ Lang::get('site.create') }}}</button>
    <button type="button" class="btn btn-default" id="createTaskLess_button">
        <i class="fa fa-arrow-up" data-toggle="tooltip" data-placement="top" title="{{{ Lang::get('task.create_task_less') }}}"></i>
    </button>
  </form>
</div>