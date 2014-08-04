@extends('layouts.base')

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-md-11 col-md-offset-1 column">
        @include('layouts.pageheader')
      </div>
    </div>
    {{-- 列表操作 --}}
    <div class="row">
      <div class="col-md-2 col-md-offset-1 column text-right">
        <div class="btn-group btn-group-lg">
          <button type="button" class="btn btn-default" id="sort" data-toggle="tooltip" data-placement="top" title="{{{ Lang::get('task.change_list_order') }}}"><span class="glyphicon glyphicon-sort"></span></button>
        </div>
        <div class="btn-group btn-group-lg" id="save">
          <button type="button" class="btn btn-default" id="ok" data-toggle="tooltip" data-placement="top" title="{{{ Lang::get('site.save') }}}"><span class="glyphicon glyphicon-ok"></span></button>
          <button type="button" class="btn btn-default" id="cancel" data-toggle="tooltip" data-placement="top" title="{{{ Lang::get('site.cancel') }}}"><span class="glyphicon glyphicon-remove"></span></button>
        </div>
      </div>
      {{-- 选择子集 --}}
      <div class="col-md-9 column">
        <ul class="nav nav-pills nav-justified" id="tasklist_set">
          <li class="active">
            <a href="#" data-toggle="pill" data-id="" data-set="today">
              <span class="badge pull-right">0</span>
              {{{ Lang::get('task.today') }}}
            </a>
          </li>
          <li>
            <a href="#" data-toggle="pill" data-id="" data-set="week">
              <span class="badge pull-right">0</span>
              {{{ Lang::get('task.this_week') }}}
            </a>
          </li>
          <li>
            <a href="#" data-toggle="pill" data-id="" data-set="month">
              <span class="badge pull-right">0</span>
              {{{ Lang::get('task.this_month') }}}
            </a>
          </li>
          <li>
            <a href="#" data-toggle="pill" data-id="" data-set="pending">
              <span class="badge pull-right">0</span>
              {{{ Lang::get('task.pending') }}}
            </a>
          </li>
        </ul>
      </div>
    </div>

    <div class="row">
      <div class="col-md-2 col-md-offset-1 column">
        <ul class="nav nav-tabs nav-stacked" id="tasklist" role="tablist">
          {{-- 列表标题 --}}
          @foreach($taskLists as $item)
          <li class="task-list-{{{ $item->color }}}">
            <a href="#list_{{{ $item->id }}}" role="tab" data-toggle="tab" data-id="{{{ $item->id }}}">
              {{{ $item->name }}}
              <span class="glyphicon glyphicon-wrench pull-right" data-toggle="modal" data-target="#TaskListSettingModal"></span>
            </a>
          </li>
          @endforeach

          <li {{ count($taskLists) == 0 ? 'class="active task-list-darkgray"' : 'class="task-list-darkgray"' }} id='create_list_pop'>
            <a data-toggle="popover">
              创建列表 <span class="glyphicon glyphicon-plus pull-right"></span>
            </a>
          </li>
        </ul>
      </div>

      {{-- 列表内容 --}}
      <div class="col-md-9 column">
        <div>

        </div>
        <div class="tab-content" id="tasklist_content">
          @foreach($taskLists as $item)
          <div class="tab-pane fade" id="list_{{{ $item->id }}}">

          </div>
          @endforeach

        </div>
      </div>
    </div>
    {{-- 列表设置弹框 --}}
    <div class="modal fade" id="TaskListSettingModal" tabindex="-1" role="dialog" aria-labelledby="TaskListSettingModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="TaskListSettingModalLabel">{{{ Lang::get('task.list_option') }}}</h4>
          </div>
          <div class="modal-body">
            <form role="form" method="post" id="tasklitsetting_form" action="{{{ URL::action('ListController@updateListSetting') }}}">
              <input type="hidden" id="updateTaskListId" name="updateTaskListId"/>
              <div class="form-group">
                 <label for="listName">{{{ Lang::get('task.list_name') }}}</label>
                 <input type="text" class="form-control" id="listName" name="listName" />
              </div>

              <div class="form-group">
                <label for="sort_by">{{{ Lang::get('task.sort_by') }}}</label>
              </div>

              <div class="form-group">
                <label for="sort_by">
                   <input type="radio" class="radio-normal" name="sortBy" id="important" value="important" />{{{ Lang::get('task.important') }}}
                </label>
              </div>

              <div class="form-group">
                <label for="sort_by">
                  <input type="radio" class="radio-normal" name="sortBy" id="urgent" value="urgent"/>{{{ Lang::get('task.urgent') }}}
                </label>
              </div>

              <div class="form-group">
                <label for="sort_by">
                  <input type="radio" class="radio-normal" name="sortBy" id="date" value="date"/>{{{ Lang::get('task.date') }}}
                </label>
              </div>

              <div class="form-group">
                <label for="sort_by">
                  <input type="radio" class="radio-normal" name="sortBy" id="custom" value="custom"/>{{{ Lang::get('task.custom') }}}
                </label>
              </div>

              <div class="form-group">
                <!--<<label for="color">{{{ Lang::get('task.color') }}}</label>-->
                <input type="hidden" id="color" name="color"/>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{{ Lang::get('site.cancel') }}}</button>
                <button type="submit" class="btn btn-primary">{{{ Lang::get('site.save') }}}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
@stop

@section('javascript')
  <script src="{{{ asset('js/taskpool/user.home.js') }}}"></script>
@stop