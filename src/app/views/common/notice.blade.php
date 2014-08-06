@extends('layouts.base')

@section('content')
  
  <div class="col-md-6 col-md-offset-4 column">
    <div class="alert alert-{{{ $noticeType }}}" role="alert">
      <strong>
      @if($noticeType == 'success')
        {{{ Lang::get('notice.success') }}}
      @elseif($noticeType == 'info')
        {{{ Lang::get('notice.info') }}}
      @elseif($noticeType == 'warning')
        {{{ Lang::get('notice.warning') }}}
      @else
        {{{ Lang::get('notice.danger') }}}
      @endif
      </strong>
    </div>
    <div class="jumbotron">
      <h1>{{{ $noticeTitle }}}</h1>
      <p>{{ $noticeContent }}</p>
      <p><a class="btn btn-primary btn-lg" role="button" href="{{{ URL::to($noticeRoute, $noticeRouteValue) }}}">{{{ Lang::get('site.go') }}}</a></p>
    </div>
  </div>
@stop