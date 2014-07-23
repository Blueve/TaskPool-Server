<!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Find your Task Pool login password. <samll>找回Task Pool的登录密码！</small></h2>

		<div>
			为了完成密码找回过程，您需要访问下面的地址来修改密码：<br/>
			{{ URL::to('findpassword', array($userId, $checkCode)) }}<br/>
			请在{{{ Config::get('app.confirm_limit') / 60 }}}分钟内完成确认
		</div>
	</body>
</html>