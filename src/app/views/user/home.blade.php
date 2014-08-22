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

      <div class="col-md-2 col-md-offset-1 column">
        <ul class="nav nav-tabs nav-stacked" id="taskList" role="tablist">
          {{-- 列表标题 --}}
          @foreach($taskLists as $item)
          <li class="task-list-{{{ $item->taskList->color }}}">
            <a href="#list_{{{ $item->taskList->id }}}" role="tab" data-toggle="tab" data-id="{{{ $item->taskList->id }}}">
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
    <div class="modal fade" id="taskListSetting_modal" tabindex="-1" role="dialog" 
      aria-labelledby="taskListSetting_modalLabel" 
      aria-hidden="true">

      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="taskListSetting_modalLabel">{{{ Lang::get('task.list_option') }}}</h4>
          </div>

          <div class="modal-body">
            <form role="form" method="post" id="taskListSetting_form" class="form-horizontal">
              <input type="hidden" id="id" name="id" value=""/>

              <div class="form-group">
                <div class="col-sm-12">
                  <div class="input-group input-group-lg">
                    <span class="input-group-btn">
                      <button class="btn btn-default" id="icon" data-iconset="fontawesome" data-icon="fa-heart" data-placement="bottom" role="iconpicker"></button>
                    </span>
                    <input type="text" class="form-control" id="name" name="name" value=""/>
                  </div>
                </div>
              </div>

              <hr />
              
              <div class="row">
                <div class="col-xs-6 column">
                  <div class="form-group">
                    <label for="sort_by" class="col-xs-6 control-label">{{{ Lang::get('task.sort_by') }}}</label>
                  </div>
                  <div class="radio">
                      <label for="important">
                        <input type="radio" class="radio-normal" name="sortBy" id="important" value="important" />
                        {{{ Lang::get('task.important') }}}
                      </label>
                  </div>
                  <div class="radio">
                      <label for="urgent">
                        <input type="radio" class="radio-normal" name="sortBy" id="urgent" value="urgent"/>
                        {{{ Lang::get('task.urgent') }}}
                  </div>
                  <div class="radio">
                      <label for="sort_by">
                        <input type="radio" class="radio-normal" name="sortBy" id="date" value="date"/>
                        {{{ Lang::get('task.date') }}}
                      </label>
                  </div>
                  <div class="radio">
                      <label for="sort_by">
                        <input type="radio" class="radio-normal" name="sortBy" id="custom" value="custom"/>
                        {{{ Lang::get('task.custom') }}}
                      </label>
                  </div>
                </div>
                <div class="col-xs-6 column">
                  <div class="form-group">
                    <label for="share" class="control-label">{{{ Lang::get('task.shareable') }}}</label>
                  </div>
                  <input type="checkbox" name="share" id="share" />
                </div>
              </div>
              <hr />
              <div class="form-group">
                <label for="color" class="col-sm-2 control-label">{{{ Lang::get('task.list_color') }}}</label>
                <div class="tile red" data-color="red"><i class="fa fa-check fa-lg"></i></div>
                <div class="tile orange" data-color="orange"><i class="fa fa-check fa-lg"></i></div>
                <div class="tile yellow" data-color="yellow"><i class="fa fa-check fa-lg"></i></div>
                <div class="tile green" data-color="green"><i class="fa fa-check fa-lg"></i></div>
                <div class="tile blue" data-color="blue"><i class="fa fa-check fa-lg"></i></div>
                <div class="tile indigo" data-color="indigo"><i class="fa fa-check fa-lg"></i></div>
                <div class="tile purple" data-color="purple"><i class="fa fa-check fa-lg"></i></div>
                <div class="tile black" data-color="black"><i class="fa fa-check fa-lg"></i></div>
                <div class="tile darkgray" data-color="darkgray"><i class="fa fa-check fa-lg"></i></div>
                <div class="tile gray" data-color="gray"><i class="fa fa-check fa-lg"></i></div>
                <input type="hidden" id="color" name="color"/>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" id="taskListSetting_modalDelete">{{{ Lang::get('site.delete') }}}</button>
                <button type="button" class="btn btn-default pull-left" style="display: none" id="taskListSetting_modalDeleteCancel">{{{ Lang::get('site.delete_cancel') }}}</button>
                <button type="button" class="btn btn-danger pull-left" style="display: none" id="taskListSetting_modalDeleteConfirm">{{{ Lang::get('site.delete_confirm') }}}</button>

                <button type="button" class="btn btn-default" data-dismiss="modal" id="taskListSetting_modalCancel">{{{ Lang::get('site.cancel') }}}</button>
                <button type="submit" class="btn btn-primary" id="taskListSetting_modalSubmit" >{{{ Lang::get('site.save') }}}</button>
              </div>
            </form>
          </div>

        </div>
      </div>

    </div>
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