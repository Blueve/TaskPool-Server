@extends('layouts.base')

@section('content')
  
  <div class="col-md-6 col-md-offset-4 column">
    <div class="alert alert-{{{ $noticeType }}}" role="alert">
      <strong>{{{ $noticeStatus }}}</strong>{{{ $noticeInfo }}}
    </div>
    <div class="jumbotron">
      <h1>{{{ $noticeTitle }}}</h1>
      <p>{{ htmlspecialchars_decode($noticeContent) }}</p>
      <p><a class="btn btn-primary btn-lg" role="button" href="{{{ URL::to($noticeRoute, $noticeRouteValue) }}}">继续</a></p>
    </div>
  </div>
@stop