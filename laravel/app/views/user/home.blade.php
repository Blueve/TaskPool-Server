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
          <button type="button" class="btn btn-default" id="sort" data-toggle="tooltip" data-placement="top" title="调整列表顺序"><span class="glyphicon glyphicon-sort"></span></button>
        </div>
        <div class="btn-group btn-group-lg" id="save">
          <button type="button" class="btn btn-default" id="ok" data-toggle="tooltip" data-placement="top" title="保存"><span class="glyphicon glyphicon-ok"></span></button>
          <button type="button" class="btn btn-default" id="cancel" data-toggle="tooltip" data-placement="top" title="取消"><span class="glyphicon glyphicon-remove"></span></button>
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

          @foreach($taskLists as $item)
          <li>
            <a href="#list_{{{ $item->id }}}" role="tab" data-toggle="tab" data-id="{{{ $item->id }}}">
              {{{ $item->name }}}
            </a>
          </li>
          @endforeach

          <li {{ count($taskLists) == 0 ? 'class="active"' : '' }} id='create_list_pop'>
            <a data-toggle="popover">
              创建列表 <span class="glyphicon glyphicon-plus"></span>
            </a>
          </li>
        </ul>
      </div>
      {{-- 列表内容 --}}
      <div class="col-md-9 column">
        <div class="tab-content" id="tasklist_content">

          @foreach($taskLists as $item)
          <div class="tab-pane fade" id="list_{{{ $item->id }}}">

          </div>
          @endforeach

        </div>
      </div>
    </div>

  </div>
@stop