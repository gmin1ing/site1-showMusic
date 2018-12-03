<?php

// 表单处理三部曲
// 1、接收并校验表单数据
// 2、持久化
// 3、响应
// 
// 接收用户提交的数据，保存到TXT文件中
/**
 * 回发处理逻辑
 * @return [type] [description]
 */
function postback(){
	// 声明 $message 是全局变量
	global $message;
	// 1 校验参数到完整性
	if (empty($_POST['username'])) {
		//没有提交用户名 或者用户名为空
		$message = '用户名没有填写';
		// 或者把 $message 放入超全局数组 $GLOBALS['message']
		return;
	} 
	if (empty($_POST['password'])) {
		//没有提交用户名 或者用户名为空
		$message = '请填写密码';
		return;
	} 
	if (empty($_POST['confirm'])) {
				//没有提交用户名 或者用户名为空
		$message = '请填写确认密码';
		return;
	}
	if ($_POST['password'] !== $_POST['confirm']) {
		$message = '两次输入的不一致';
		return;
	}
	if (!(isset($_POST['agree']) && $_POST['agree']==='on')){
			$message = '必须同意协议';
			return;
	}
		//所有的校验均成功
	$username=$_POST['username'];
	$password=$_POST['password'];
	file_put_contents('users.txt', $username.'|'.$password."\n",FILE_APPEND);
	$message='注册成功，请重新登录';
	header("Refresh:1;url=login.php");
						
}
if ($_SERVER['REQUEST_METHOD']==='POST'){
	postback();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<style>
		table {
			margin: 50px auto;
		}
	</style>
</head>
<body>
	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
		<table>
			<tr>
				<td><h3>用户注册</h2></td>
				<td></td>
			</tr>
			<tr>
				<td><label for="username"></lable>用户名：</td>
				<td><input type="text" name="username" id="username" value="<?php echo isset($_POST['username']) ? $_POST['username']:''; ?>">
				</td>
			</tr>
			<tr>
				<td><label for="password">密码:</label></td>
				<td><input type="password" name="password" id="password"></td>
			</tr>
			<tr>
				<td><label for="confirm">确认密码:</label></td>
				<td><input type="password" name="confirm" id="confirm"></td>
			</tr>
			<tr>
				<td></td>
				<td><label><input type="checkbox" name="agree" <?php if($_POST['agree']==='on') echo "checked"; ?>> 同意注册协议</label></td>
			</tr>
			<?php if (isset($message)):
			// if(isset($_GLOBAL['message']))
			 ?>

			<tr>
				<td></td>
				<td><?php echo $message; ?></td>
			</tr>
			<?php endif ?>
			<tr>
				<td></td>
				<td><button class="btn btn-primary">注册</button></td>
			</tr>

		</table>
	</form>
</body>
</html>