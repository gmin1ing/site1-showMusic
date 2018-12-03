<?php

// 通过客户端在url地址中？参数不同来辨别要删除的数据的
	
// 接收 URL中的不同的ID
if (empty($_GET['id'])) {
		// 没有传递必要的参数
		exit('<h1>必须指定参数</h1>');
}
$id=$_GET['id'];

// 找到要删除的数据并删除
$data =json_decode(file_get_contents('storage.json'),true);
foreach ($data as $item) {
	if ($item['id']!==$id) continue;
	// $item => 我们需要删除的数据
	// 从原有的数据中删除
	$index = array_search($item, $data);
	array_splice($data, $index ,1);

	// 保存数据删除指定数据过后的内容
	// echo '<pre>';
	// var_dump($data);
	// echo '</pre>';
	$json=json_encode($data);
	file_put_contents('storage.json', $json);
	// 跳转回list
	header('Location: list.php');
}


