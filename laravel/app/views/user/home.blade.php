@extends('layouts.base')

@section('content')

  <div class="container">

    <div class="row">
      <div class="col-md-11 col-md-offset-1 column">
        @include('layouts.pageheader')
        <ul class="nav nav-tabs" id="tasklist" role="tablist">

          <li class="active" id='create_list_pop'>
            <a data-toggle="popover" href="#" >
              <span class="glyphicon glyphicon-plus"></span>
            </a>
          </li>

        </ul>
      </div>
    </div>

    <div class="row">
      <div class="col-md-3 col-md-offset-1 column">
        <ul class="nav nav-pills nav-stacked">

          <li class="active">
            <a href="#">
              <span class="badge pull-right">42</span>
              {{{ Lang::get('task.today') }}}
            </a>
          </li>
          <li>
            <a href="#">
              <span class="badge pull-right">0</span>
              {{{ Lang::get('task.this_week') }}}
            </a>
          </li>
          <li>
            <a href="#">
              <span class="badge pull-right">0</span>
              {{{ Lang::get('task.this_month') }}}
            </a>
          </li>
          <li>
            <a href="#">
              <span class="badge pull-right">0</span>
              {{{ Lang::get('task.pending') }}}
            </a>
          </li>

        </ul>
      </div>
      <div class="col-md-8 column">

      </div>
    </div>

  </div>
@stop