<?php
function login_feedback(){
	global $message;
	if (empty($_POST['username'])) {
		$message = '请输入用户名';
		return;
	}
	if (empty($_POST['password'])) {
		$message='请输入密码';
		return;
	}
	$username=$_POST['username'];
	$password=$_POST['password'];

	$users=file_get_contents('users.txt');
	$lines = explode("\n", $users);
	$data=array();
	foreach ($lines as $item) {
		if ($item==='') continue;
		$cols=explode("|", $item);
		$data[]=$cols;
		if ($cols[0]===$username) {
			if ($cols[1]===$password) {
				$message='登录成功，正在跳转';
				header("Refresh:1;url=list.php");
				return;
			} else {
				$message='密码错误，请重新输入';
				return;
			}
		} 
	}
	$message='对不起，该用户不存在，请注册';
}


if ($_SERVER['REQUEST_METHOD']==='POST') {
	login_feedback();
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<style>
		.login {
			width: 500px;
			height: 400px;
			margin: 20px auto;
			border:1px solid #efefef;
			padding: 10px;
		}
	</style>
</head>
<body>
	<div class="login">
		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" >
		  <div class="form-group">
		    <label for="username">用户名</label>
		    <input type="用户名" class="form-control" id="username" name="username" placeholder="请输入用户名" value="<?php if($_SERVER['REQUEST_METHOD']==='POST'){echo $_POST['username'];} ?>">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword1">密码</label>
		    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="请输入密码" name="password">
		  </div>
		  <div class="form-check">
		    <input type="checkbox" class="form-check-input" id="exampleCheck1">
		    <label class="form-check-label" for="exampleCheck1">记住密码</label>
		  </div>
		  
		  <small id="Help" class="form-text text-muted mb-2"><?php echo $message; ?></small>

		  <div>
		  	<button class="btn btn-primary">登录</button>
		  	<a href="register.php" class="btn btn-info ml-3">注册</a>
		  </div>
		</form>
	</div>
	
</body>
</html>