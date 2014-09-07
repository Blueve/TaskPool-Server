{{-- 新建任务 --}}
<div class="col-md-9 column">
  <form class="form-inline" role="form" id="newTask_form">
    <div class="form-group">
      <label class="sr-only" for="taskName">{{{ Lang::get('task.create_task') }}}</label>
      <input type="text" class="form-control" id="taskName" name="taskName" placeholder="{{{ Lang::get('task.create_task') }}}">
    </div>
    <button type="submit" class="btn btn-default">{{{ Lang::get('site.create') }}}</button>
  </form>
</div>