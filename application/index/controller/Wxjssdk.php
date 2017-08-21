<?php
namespace app\index\controller;
class Wxjssdk{
	private $appId = APPID;
	private $appSecret = APPSECRET;


	public function getSignPackage() {
		$jsapiTicket = $this->getJsApiTicket();

		// 注意 URL 一定要动态获取，不能 hardcode.
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		$timestamp = time();
		$nonceStr = $this->createNonceStr();

		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

		$signature = sha1($string);

		$signPackage = [
			"appId"     => $this->appId,
			"nonceStr"  => $nonceStr,
			"timestamp" => $timestamp,
			"url"       => $url,
			"signature" => $signature,
			"rawString" => $string
		];
		return $signPackage; 
	}

	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
		  $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}

		return $str;
	}
	//获取jsticket
	private function getJsApiTicket() {
		// jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
		if (file_exists(JSTOKEN_CACHE)) {
	        $tokenStr = json_decode(file_get_contents(JSTOKEN_CACHE),true);
	        //判断文件是否过期
	        if (filectime(JSTOKEN_CACHE) + $tokenStr['expires_in'] > time()) {
	          return $tokenStr['ticket'];
	        }
	        unlink(JSTOKEN_CACHE);
	    }
	    $accessToken = $this->getAccessToken();
	    $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
		$result = myMethod($url,'get');
	    file_put_contents(JSTOKEN_CACHE,$result);
	    $tokenStr = json_decode($result,true);
	    return $tokenStr['ticket'];
	}

	
	//获取access_token
	private function getAccessToken($appid = APPID, $secret = APPSECRET)
	{
	    if (file_exists(TOKEN_CACHE)) {
	        $tokenStr = file_get_contents(TOKEN_CACHE);
	        $tokenStr = json_decode($tokenStr,true);
	        //判断文件是否过期
	        if (filectime(TOKEN_CACHE) + $tokenStr['expires_in'] > time()) {
	          return $tokenStr['access_token'];
	        }
	        unlink(TOKEN_CACHE);
	    }
	    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
	    $result = myMethod($url,'get');
	   // echo $result;
	    file_put_contents('token.txt',$result);
	    $tokenStr = json_decode($result,true);
	    return $tokenStr['access_token'];
	}

}