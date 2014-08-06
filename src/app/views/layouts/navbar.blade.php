<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
       <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> 
        <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span>
        <span class="icon-bar"></span><span class="icon-bar"></span>
      </button> 
      <a class="navbar-brand" href="#">{{{ Lang::get('site.site_title')}}}</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li {{{ $pageTag === 'home' ? 'class=active' : '' }}}>
          <a href="{{{ URL::action('HomeController@startup') }}}">{{{ Lang::get('site.home') }}}</a>
        </li>
      </ul>
      @if(Auth::check())
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{{ Auth::user()->name }}} <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="{{{ URL::action('UserController@home') }}}">{{{ Lang::get('site.my') }}}</a></li>
            <li><a href="{{{ URL::action('UserController@setting') }}}">{{{ Lang::get('site.setting')}}}</a></li>
            <li class="divider"></li>
           <li><a href="{{{ URL::action('AccountController@signout') }}}">{{{ Lang::get('site.signout') }}}</a></li>
          </ul>
        </li>
      </ul>
      @endif
    </div>
  </div>
</nav>