<!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Welcome to Task Pool. <samll>Task Pool 欢迎你的加入！</small></h2>

		<div>
			为了完成注册过程，您需要访问下面的地址来验证你的邮箱：<br/>
			{{ URL::to('user/confirm', array($userId, $checkCode)) }}<br/>
			请在{{{ Config::get('app.confirm_limit') / 60 }}}分钟内完成确认
		</div>
	</body>
</html>