<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
//curl
function myMethod($url, $method = "post", $data = null )
{
	//开始一个句柄
	$ch = curl_init();
	//设置访问的url
	curl_setopt($ch,CURLOPT_URL,$url);
	//设置是否直接输出， true字符串  false直接输出
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	//是否开启ssl认证
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
	//是否验证ssl主机
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
	if ($method == "post") {
		curl_setopt($ch,CURLOPT_POST,true);
	}
	curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
	//执行请求，返回的是结果
	$result = curl_exec($ch);
	return $result;
}

//随机数
function randmon($start, $end)
{
	// $arr = [];
	// for ($i = 0; $i < $num; $i++) {
	// 	$arr[] = rand($start * 100, $end * 100) / 100;
	// }
	return rand($start * 100, $end * 100) / 100;
	//return $arr;
}

function userTextEncode($str){
    if(!is_string($str))return $str;
    if(!$str || $str=='undefined')return '';

    $text = json_encode($str); //暴露出unicode
    $text = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i",function($str){
        return addslashes($str[0]);
    },$text); //将emoji的unicode留下，其他不动，这里的正则比原答案增加了d，因为我发现我很多emoji实际上是\ud开头的，反而暂时没发现有\ue开头。
    return json_decode($text);
}

function userTextDecode($str){
    $text = json_encode($str); //暴露出unicode
    $text = preg_replace_callback('/\\\\\\\\/i',function($str){
        return '\\';
    },$text); //将两条斜杠变成一条，其他不动
    return json_decode($text);
}