@extends('layouts.base')

@section('content')

  <div class="container">

    <div class="row">
      <div class="col-md-12 column">
        @include('layouts.pageheader')
      </div>
    </div>

    {{-- 列表操作 --}}
    <div class="row">
      <div class="col-md-2 column text-right">
        <div class="btn-group btn-group-lg">
          <button type="button" class="btn btn-default" id="sort" >
            <i class="fa fa-sort" data-toggle="tooltip" data-placement="top" title="{{{ Lang::get('task.change_list_order') }}}"></i>
          </button>
        </div>
        <div class="btn-group btn-group-lg" id="save">
          <button type="button" class="btn btn-default" id="ok" >
            <i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="{{{ Lang::get('site.save') }}}"></i>
          </button>
          <button type="button" class="btn btn-default" id="cancel" >
            <i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="{{{ Lang::get('site.cancel') }}}"></i>
          </button>
        </div>
      </div>

      {{-- 选择子集 --}}
      <div class="col-md-9 column">
        <ul class="nav nav-pills nav-justified" id="taskListSet">
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

      <div class="col-md-2 column">
        <ul class="nav nav-tabs nav-stacked" id="taskList" role="tablist">
          {{-- 列表标题 --}}
          @foreach($taskLists as $item)
          <li class="task-list-{{{ $item->taskList->color }}}">
            <a href="#list_{{{ $item->id }}}" role="tab" data-toggle="tab" data-id="{{{ $item->id }}}">
              <i class="fa {{{ $item->taskList->icon }}} fa-lg fa-fw align-left"></i>
              {{{ $item->taskList->name }}}
              <i class="fa fa-cog fa-lg-repair align-right" data-toggle="modal" data-target="#taskListSetting_modal"></i>
            </a>
          </li>
          @endforeach

          <li {{-- count($taskLists) == 0 ? 'class="active task-list-darkgray"' : 'class="task-list-darkgray"' --}} id="createList_pop" >
            <a data-toggle="popover" class="popover-dismiss" title="{{{ Lang::get('task.create_list') }}}">
              <i class="fa fa-plus fa-lg"></i></span>
            </a>
          </li>
        </ul>
      </div>

      {{-- 新建任务 --}}
      @include('user.child.createtask')

      {{-- 列表内容 --}}
      <div class="col-md-9 column">
        <div class="tab-content" id="tasklistContent">
          @foreach($taskLists as $item)
          <div class="tab-pane fade" id="list_{{{ $item->id }}}">

          </div>
          @endforeach
        </div>
      </div>
    </div>

    {{-- 列表设置弹框 --}}
    @include('user.child.listsetting')

@stop

@section('css')
  <link href="{{{ asset('css/bootstrap-iconpicker.min.css') }}}" rel="stylesheet">
  <link href="{{{ asset('css/bootstrap-switch.min.css') }}}" rel="stylesheet">
@stop

@section('javascript')
  <script src="{{{ asset('js/bootstrap-iconpicker.js') }}}"></script>
  <script src="{{{ asset('js/bootstrap-switch.min.js') }}}"></script>
  <script src="{{{ asset('js/taskpool/user.home.js') }}}"></script>
@stop